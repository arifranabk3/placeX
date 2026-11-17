<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Listing;
use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalSeoController extends Controller
{
    public function index(): View
    {
        $siteTitle = SystemSetting::get('seo.default_title', 'PlaceX — Jobs, Property, Classifieds, Vehicles, Matrimonial in Pakistan');
        $siteDescription = SystemSetting::get('seo.default_description', 'Discover real opportunities, verified listings and amazing deals across Pakistan.');
        $ogImage = SystemSetting::get('seo.default_og_image', 'https://placex.test/images/placex-og.png');

        $popularListings = Listing::where('listing_status', 'active')
            ->latest()
            ->take(10)
            ->get();

        return view('portal-admin.seo.index', compact('siteTitle', 'siteDescription', 'ogImage', 'popularListings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_title' => 'required|string|max:120',
            'default_description' => 'required|string|max:250',
            'default_og_image' => 'nullable|url|max:500',
        ]);

        SystemSetting::set('seo.default_title', $validated['default_title'], 'seo', 'string');
        SystemSetting::set('seo.default_description', $validated['default_description'], 'seo', 'string');
        SystemSetting::set('seo.default_og_image', $validated['default_og_image'] ?? '', 'seo', 'string');

        AuditLog::record('portal.seo_updated', SystemSetting::class, 0, $validated);

        return back()->with('success', 'Global SEO metadata and OpenGraph rules updated.');
    }
}
