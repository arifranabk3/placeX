<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ListingImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortalMediaController extends Controller
{
    public function index(): View
    {
        $images = ListingImage::with('listing')->latest()->paginate(24);

        return view('portal-admin.media.index', compact('images'));
    }

    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'listing_id' => 'nullable|exists:listings,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/listings', 'public');
            $url = Storage::url($path);

            $media = ListingImage::create([
                'listing_id' => $request->input('listing_id', 1),
                'image_url' => $url,
                'is_primary' => false,
                'sort_order' => 10,
            ]);

            AuditLog::record('portal.media_uploaded', ListingImage::class, $media->id, [
                'path' => $path,
                'url' => $url,
            ]);

            return back()->with('success', 'Media file uploaded successfully.');
        }

        return back()->with('error', 'Failed to process file upload.');
    }

    public function destroy(ListingImage $image): RedirectResponse
    {
        // Safe delete: remove file from public storage if local
        if (str_starts_with($image->image_url, '/storage/')) {
            $relative = str_replace('/storage/', '', $image->image_url);
            Storage::disk('public')->delete($relative);
        }

        $image->delete();

        return back()->with('success', 'Media file deleted successfully.');
    }
}
