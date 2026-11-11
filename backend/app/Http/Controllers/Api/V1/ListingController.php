<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\ListingResource;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListingController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Listing::query()
            ->where('listing_status', 'active')
            ->where('moderation_status', 'approved')
            ->with([
                'category',
                'location',
                'user.sellerProfile',
                'images',
                'jobDetail',
                'propertyDetail',
                'classifiedDetail',
                'vehicleDetail',
                'matrimonialProfile.preferences',
            ]);

        // Category filter
        if ($categorySlug = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // City filter
        if ($city = $request->input('city')) {
            $query->whereHas('location', function ($q) use ($city) {
                $q->where('city', 'like', "%{$city}%");
            });
        }

        // Keyword Search
        if ($keyword = $request->input('q')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Radius / Coordinates discovery (Haversine formula server-side)
        if ($request->filled(['lat', 'lng', 'radius_km'])) {
            $lat = (float) $request->input('lat');
            $lng = (float) $request->input('lng');
            $radius = (float) $request->input('radius_km');

            $haversine = "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";
            $query->selectRaw("listings.*, {$haversine} AS distance", [$lat, $lng, $lat])
                  ->having('distance', '<=', $radius)
                  ->orderBy('distance');
        } else {
            $query->latest('published_at');
        }

        $perPage = min((int) $request->input('per_page', 20), 50);
        $listings = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Listings retrieved successfully',
            'data' => ListingResource::collection($listings),
            'pagination' => [
                'current_page' => $listings->currentPage(),
                'last_page' => $listings->lastPage(),
                'per_page' => $listings->perPage(),
                'total' => $listings->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $listing = Listing::query()
            ->where('slug', $slug)
            ->with([
                'category',
                'location',
                'user.sellerProfile',
                'images',
                'jobDetail',
                'propertyDetail',
                'classifiedDetail',
                'vehicleDetail',
                'matrimonialProfile.preferences',
            ])
            ->first();

        if (!$listing) {
            return $this->errorResponse('Listing not found', [], 404);
        }

        // Authorize viewing (drafts only viewable by owner or admin)
        $this->authorize('view', $listing);

        return $this->successResponse(
            new ListingResource($listing),
            'Listing details retrieved successfully'
        );
    }
}

