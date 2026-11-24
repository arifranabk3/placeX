<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingReport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PortalDashboardController extends Controller
{
    public function index(): View
    {
        // 1. Core KPIs (Real Database Counts)
        $totalListings = Listing::count();
        $publishedListings = Listing::where('listing_status', 'active')
            ->where('moderation_status', 'approved')
            ->count();
        $pendingApproval = Listing::where('moderation_status', 'pending')->count();
        $draftListings = Listing::where('listing_status', 'draft')->count();
        $closedListings = Listing::whereIn('listing_status', ['inactive', 'expired', 'closed'])->count();

        $totalUsers = User::count();
        $activeSellers = User::whereHas('roles', function ($q) {
            $q->where('slug', 'seller');
        })->where('status', 'active')->count();

        if ($activeSellers === 0) {
            // Count users who have published at least one active listing
            $activeSellers = User::whereHas('listings', function ($q) {
                $q->where('listing_status', 'active');
            })->count();
        }

        $totalEnquiries = ListingReport::count();
        $pendingEnquiries = ListingReport::where('status', 'pending')->count();

        // 2. Category-Wise Breakdown for 5 Verticals
        $coreCategories = ['jobs', 'property', 'classifieds', 'vehicles', 'matrimonial'];
        $categoryBreakdown = [];
        $categoryChartLabels = [];
        $categoryChartCounts = [];

        foreach ($coreCategories as $slug) {
            $cat = Category::where('slug', $slug)->first();
            $count = 0;
            $name = ucfirst($slug);
            if ($cat) {
                $name = $cat->name;
                $categoryIds = Category::where('id', $cat->id)
                    ->orWhere('parent_id', $cat->id)
                    ->pluck('id');
                $count = Listing::whereIn('category_id', $categoryIds)->count();
            }
            $categoryBreakdown[$slug] = [
                'name' => $name,
                'count' => $count,
                'slug' => $slug,
            ];
            $categoryChartLabels[] = $name;
            $categoryChartCounts[] = $count;
        }

        // 3. Status Distribution Chart (Published vs Draft vs Pending vs Closed)
        $statusDistribution = [
            'labels' => ['Published Live', 'Drafts', 'Pending Review', 'Closed / Inactive'],
            'data' => [
                $publishedListings,
                $draftListings,
                $pendingApproval,
                $closedListings,
            ],
        ];

        // 4. Monthly Trend (Real DB query grouped by month for past 6 months)
        $monthlyTrendRaw = Listing::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_str, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month_str')
            ->orderBy('month_str')
            ->pluck('count', 'month_str')
            ->toArray();

        $monthlyTrend = [
            'labels' => [],
            'data' => [],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $monthlyTrend['labels'][] = $date->format('M Y');
            $monthlyTrend['data'][] = $monthlyTrendRaw[$key] ?? 0;
        }

        // 5. Activity Feeds
        $recentListings = Listing::with(['category', 'user', 'location', 'images'])
            ->latest()
            ->take(6)
            ->get();

        $pendingModerationItems = Listing::with(['category', 'user', 'location'])
            ->where('moderation_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $recentRegistrations = User::latest()
            ->take(5)
            ->get();

        $latestEnquiries = ListingReport::with(['listing', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 6. Navigation categories with counts
        $categories = Category::whereNull('parent_id')->withCount('listings')->get();
        $mediaAssets = \App\Models\ListingImage::count();
        $newEnquiries = $pendingEnquiries;
        $pendingModeration = $pendingApproval;

        return view('portal-admin.dashboard.index', compact(
            'totalListings',
            'publishedListings',
            'pendingApproval',
            'draftListings',
            'closedListings',
            'totalUsers',
            'activeSellers',
            'totalEnquiries',
            'categoryBreakdown',
            'categoryChartLabels',
            'categoryChartCounts',
            'statusDistribution',
            'monthlyTrend',
            'recentListings',
            'pendingModerationItems',
            'recentRegistrations',
            'latestEnquiries',
            'categories',
            'mediaAssets',
            'newEnquiries',
            'pendingModeration'
        ));
    }
}
