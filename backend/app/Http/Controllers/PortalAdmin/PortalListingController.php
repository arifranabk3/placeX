<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Services\PortalAdmin\PortalListingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalListingController extends Controller
{
    public function __construct(protected PortalListingService $listingService)
    {
    }

    public function index(Request $request): View
    {
        $query = Listing::with(['category', 'user', 'location', 'images']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('listing_status', $request->input('status'));
        }

        if ($request->filled('moderation')) {
            $query->where('moderation_status', $request->input('moderation'));
        }

        $listings = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::whereNull('parent_id')->get();

        return view('portal-admin.listings.index', compact('listings', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $locations = Location::all();

        return view('portal-admin.listings.create', compact('categories', 'locations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'nullable|exists:locations,id',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'description' => 'required|string',
            'listing_status' => 'required|in:draft,active,inactive,closed',
            'moderation_status' => 'nullable|in:pending,approved,rejected',
            'image_url' => 'nullable|url|max:500',
        ]);

        $listing = $this->listingService->createListing($request->all());

        return redirect()->route('portal-admin.listings.index')
            ->with('success', "Listing '{$listing->title}' saved successfully as {$listing->listing_status}.");
    }

    public function edit(Listing $listing): View
    {
        $listing->load([
            'category', 'location', 'images', 'jobDetail', 'propertyDetail',
            'classifiedDetail', 'vehicleDetail', 'matrimonialProfile'
        ]);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $locations = Location::all();

        return view('portal-admin.listings.edit', compact('listing', 'categories', 'locations'));
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'nullable|exists:locations,id',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'description' => 'required|string',
            'listing_status' => 'required|in:draft,active,inactive,closed,archived,paused',
            'moderation_status' => 'nullable|in:pending,approved,rejected',
            'image_url' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
            'removed_image_ids' => 'nullable|array',
            'removed_image_ids.*' => 'integer|exists:listing_images,id',
        ]);

        $this->listingService->updateListing($listing, $request->all());

        return redirect()->route('portal-admin.listings.index')
            ->with('success', "Listing '{$listing->title}' updated successfully.");
    }

    public function publish(Listing $listing): RedirectResponse
    {
        $listing->update([
            'listing_status' => 'active',
            'moderation_status' => 'approved',
            'published_at' => $listing->published_at ?? now(),
        ]);

        AuditLog::record('portal.listing_published', Listing::class, $listing->id, [
            'title' => $listing->title,
        ]);

        return back()->with('success', "Listing '{$listing->title}' is now Published and live on Next.js public website.");
    }

    public function unpublish(Listing $listing): RedirectResponse
    {
        $listing->update([
            'listing_status' => 'inactive',
        ]);

        AuditLog::record('portal.listing_unpublished', Listing::class, $listing->id, [
            'title' => $listing->title,
        ]);

        return back()->with('success', "Listing '{$listing->title}' unpublished and hidden from public visitors.");
    }

    public function pause(Listing $listing): RedirectResponse
    {
        $newStatus = $listing->listing_status === 'paused' ? 'active' : 'paused';
        $listing->update(['listing_status' => $newStatus]);

        return back()->with('success', "Listing status updated to {$newStatus}.");
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $listing->delete();
        AuditLog::record('portal.listing_archived', Listing::class, $listing->id, [
            'title' => $listing->title,
        ]);

        return redirect()->route('portal-admin.listings.index')
            ->with('success', "Listing safely archived/deleted.");
    }
}
