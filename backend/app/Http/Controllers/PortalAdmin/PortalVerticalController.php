<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Services\PortalAdmin\PortalListingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PortalVerticalController extends Controller
{
    public function __construct(protected PortalListingService $listingService)
    {
    }

    /**
     * Vertical Listing Directory & Management
     */
    public function index(string $vertical): View
    {
        $category = Category::where('slug', $vertical)->first();
        $catIds = [];
        if ($category) {
            $catIds = Category::where('id', $category->id)->orWhere('parent_id', $category->id)->pluck('id');
        }

        $query = Listing::with(['category', 'user', 'location', 'images'])
            ->whereIn('category_id', $catIds);

        // Strict Privacy Gating for Matrimonial
        $canViewMatrimonial = true;
        if ($vertical === 'matrimonial') {
            $canViewMatrimonial = Auth::user()->hasPermission('portal.matrimonial.manage') || Auth::user()->isSuperAdmin();
        }

        $listings = $query->latest()->paginate(15);
        $verticalTitle = ucfirst($vertical);

        return view("portal-admin.{$vertical}.index", compact('listings', 'category', 'vertical', 'verticalTitle', 'canViewMatrimonial'));
    }

    /**
     * Quick Create Form for Vertical
     */
    public function create(string $vertical): View
    {
        $category = Category::where('slug', $vertical)->with('children')->first();
        $locations = Location::all();
        $verticalTitle = ucfirst($vertical);

        return view("portal-admin.{$vertical}.create", compact('category', 'locations', 'vertical', 'verticalTitle'));
    }

    /**
     * Store Vertical Listing
     */
    public function store(Request $request, string $vertical): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'nullable|exists:locations,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'listing_status' => 'required|in:draft,active,inactive',
        ]);

        $listing = $this->listingService->createListing($request->all(), $vertical);

        return redirect()->route("portal-admin.{$vertical}.index")
            ->with('success', "New {$vertical} listing published/saved successfully.");
    }
}
