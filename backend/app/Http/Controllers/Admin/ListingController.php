<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ModerationCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Listing::with(['user', 'category', 'location', 'images' => fn ($q) => $q->where('is_primary', true)]);

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

        if ($request->filled('listing_status')) {
            $query->where('listing_status', $request->input('listing_status'));
        }

        if ($request->filled('moderation_status')) {
            $query->where('moderation_status', $request->input('moderation_status'));
        }

        $listings = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.listings.index', compact('listings', 'categories'));
    }

    public function show(Listing $listing): View
    {
        $listing->load([
            'user',
            'category',
            'location',
            'images',
            'jobDetail',
            'propertyDetail',
            'classifiedDetail',
            'vehicleDetail',
            'matrimonialProfile',
        ]);

        // Matrimonial privacy check: Only Admins/SuperAdmins/Moderators with permission can view details
        $isMatrimonial = $listing->category && strtolower($listing->category->slug) === 'matrimonial';
        $canViewMatrimonial = Auth::user()->hasPermission('matrimonial.manage') || Auth::user()->isSuperAdmin();

        return view('admin.listings.show', compact('listing', 'isMatrimonial', 'canViewMatrimonial'));
    }

    public function edit(Listing $listing): View
    {
        $listing->load(['category', 'location', 'images']);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:10',
            'description' => 'required|string',
            'listing_status' => 'required|in:active,inactive,expired,draft',
            'moderation_status' => 'required|in:pending,approved,rejected',
        ]);

        DB::transaction(function () use ($validated, $listing) {
            $listing->update($validated);

            AuditLog::record(
                'listing.updated',
                Listing::class,
                $listing->id,
                ['title' => $listing->title, 'status' => $listing->listing_status]
            );
        });

        return redirect()->route('admin.listings.show', $listing)->with('success', "Listing '{$listing->title}' updated successfully.");
    }

    public function updateModeration(Request $request, Listing $listing): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        $status = $request->input('status');
        $reason = $request->input('rejection_reason');

        DB::transaction(function () use ($listing, $status, $reason) {
            $listing->update([
                'moderation_status' => $status,
                'published_at' => $status === 'approved' ? ($listing->published_at ?? now()) : null,
                'listing_status' => $status === 'approved' ? 'active' : 'inactive',
            ]);

            ModerationCase::create([
                'listing_id' => $listing->id,
                'moderator_id' => Auth::id(),
                'action' => $status,
                'notes' => $reason ?? "Moderator marked listing as {$status}",
            ]);

            AuditLog::record(
                "listing.moderation_{$status}",
                Listing::class,
                $listing->id,
                ['status' => $status, 'notes' => $reason]
            );
        });

        return back()->with('success', "Listing moderation status changed to {$status}.");
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        DB::transaction(function () use ($listing) {
            AuditLog::record('listing.deleted', Listing::class, $listing->id, ['title' => $listing->title]);
            $listing->delete();
        });

        return redirect()->route('admin.listings.index')->with('success', "Listing has been removed.");
    }
}
