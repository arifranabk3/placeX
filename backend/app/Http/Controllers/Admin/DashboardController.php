<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingPromotion;
use App\Models\ListingReport;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Core KPIs from actual database records
        $kpis = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_sellers' => SellerProfile::count(),
            'total_listings' => Listing::count(),
            'pending_moderation' => Listing::where('moderation_status', 'pending_review')->count(),
            'published_listings' => Listing::where('listing_status', 'active')->where('moderation_status', 'approved')->count(),
            'reported_listings' => ListingReport::where('status', 'pending')->count(),
            'featured_listings' => ListingPromotion::where('status', 'active')->where('expires_at', '>', now())->count(),
        ];

        // 2. Recent activity and data sets
        $recentUsers = User::latest()->take(5)->with('roles')->get();
        $recentListings = Listing::latest()->take(6)->with(['category', 'user', 'location'])->get();
        $pendingModeration = Listing::where('moderation_status', 'pending_review')->latest()->take(5)->with(['category', 'user'])->get();
        $latestReports = ListingReport::latest()->take(5)->with(['listing', 'reporter'])->get();
        $categoryDistribution = Category::withCount('listings')->get();
        $recentActivities = AuditLog::latest()->take(7)->with('user')->get();

        return view('admin.dashboard.index', compact(
            'kpis',
            'recentUsers',
            'recentListings',
            'pendingModeration',
            'latestReports',
            'categoryDistribution',
            'recentActivities'
        ));
    }
}
