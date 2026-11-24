<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingReport;
use App\Models\User;
use Illuminate\View\View;

class PortalDashboardController extends Controller
{
    public function index(): View
    {
        // 1. Core Listing Figures (Actual Database Records)
        $totalListings = Listing::count();
        $publishedListings = Listing::where('listing_status', 'active')
            ->where('moderation_status', 'approved')
            ->count();
        $draftListings = Listing::where('listing_status', 'draft')->count();
        $pendingModeration = Listing::where('moderation_status', 'pending')->count();
        $closedListings = Listing::whereIn('listing_status', ['inactive', 'expired', 'closed'])->count();
        $totalUsers = User::count();

        // 2. Category-Wise Statistics
        $categoryBreakdown = [];
        $coreCategories = ['jobs', 'property', 'classifieds', 'vehicles', 'matrimonial'];

        foreach ($coreCategories as $slug) {
            $cat = Category::where('slug', $slug)->first();
            $count = 0;
            if ($cat) {
                $categoryIds = Category::where('id', $cat->id)
                    ->orWhere('parent_id', $cat->id)
                    ->pluck('id');
                $count = Listing::whereIn('category_id', $categoryIds)->count();
            }
            $categoryBreakdown[$slug] = [
                'name' => ucfirst($slug),
                'count' => $count,
                'slug' => $slug,
            ];
        }

        // 3. Recent Marketplace Listings
        $recentListings = Listing::with(['category', 'user', 'location', 'images'])
            ->latest()
            ->take(8)
            ->get();

        // 4. Pending Review Queue
        $pendingQueue = Listing::with(['category', 'user'])
            ->where('moderation_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // 5. Recent Reports & Inquiries
        $recentReports = ListingReport::with(['listing', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $mediaAssets = \App\Models\ListingImage::count();
        $newEnquiries = ListingReport::where('status', 'pending')->count();
        $categories = Category::whereNull('parent_id')->withCount('listings')->get();

        return view('portal-admin.dashboard.index', compact(
            'totalListings',
            'publishedListings',
            'draftListings',
            'pendingModeration',
            'closedListings',
            'totalUsers',
            'categoryBreakdown',
            'recentListings',
            'pendingQueue',
            'recentReports',
            'mediaAssets',
            'newEnquiries',
            'categories'
        ));
    }
}
