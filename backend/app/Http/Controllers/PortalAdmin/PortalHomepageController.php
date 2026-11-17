<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Listing;
use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalHomepageController extends Controller
{
    public function index(): View
    {
        // Load homepage configuration and featured listings
        $featuredListings = Listing::where('listing_status', 'active')
            ->where('moderation_status', 'approved')
            ->latest()
            ->take(8)
            ->get();

        $heroHeadline = SystemSetting::get('homepage.hero_headline', 'Discover Real Opportunities in Pakistan');
        $heroSubheadline = SystemSetting::get('homepage.hero_subheadline', 'Explore thousands of verified Jobs, Homes, Cars & Deals');
        $trendingPills = SystemSetting::get('homepage.trending_keywords', 'Used Cars, House for Sale, House for Rent, Jobs Near Me, Mobiles');
        $bannerActive = SystemSetting::get('homepage.banner_active', '1');

        return view('portal-admin.homepage.index', compact(
            'featuredListings',
            'heroHeadline',
            'heroSubheadline',
            'trendingPills',
            'bannerActive'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_headline' => 'required|string|max:200',
            'hero_subheadline' => 'required|string|max:300',
            'trending_keywords' => 'required|string|max:500',
            'banner_active' => 'nullable|boolean',
        ]);

        SystemSetting::set('homepage.hero_headline', $validated['hero_headline'], 'homepage', 'string');
        SystemSetting::set('homepage.hero_subheadline', $validated['hero_subheadline'], 'homepage', 'string');
        SystemSetting::set('homepage.trending_keywords', $validated['trending_keywords'], 'homepage', 'string');
        SystemSetting::set('homepage.banner_active', $request->has('banner_active') ? '1' : '0', 'homepage', 'boolean');

        AuditLog::record('portal.homepage_updated', SystemSetting::class, 0, $validated);

        return back()->with('success', 'Homepage content updated successfully and synchronized with Next.js endpoints.');
    }
}
