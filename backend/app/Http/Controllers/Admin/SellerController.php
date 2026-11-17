<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SellerController extends Controller
{
    public function index(Request $request): View
    {
        $query = SellerProfile::with(['user', 'user.listings']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('verification')) {
            $query->where('is_verified', $request->input('verification') === 'verified');
        }

        if ($request->filled('type')) {
            $query->where('seller_type', $request->input('type'));
        }

        $sellers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.sellers.index', compact('sellers'));
    }

    public function show(SellerProfile $seller): View
    {
        $seller->load(['user', 'user.listings' => fn ($q) => $q->latest()->take(15)]);

        return view('admin.sellers.show', compact('seller'));
    }

    public function toggleVerification(SellerProfile $seller): RedirectResponse
    {
        $newState = ! $seller->is_verified;
        $seller->update([
            'is_verified' => $newState,
            'verified_at' => $newState ? now() : null,
        ]);

        AuditLog::record(
            $newState ? 'seller.verified' : 'seller.unverified',
            SellerProfile::class,
            $seller->id,
            ['business_name' => $seller->business_name, 'user_id' => $seller->user_id]
        );

        $statusStr = $newState ? 'verified' : 'unverified';
        return back()->with('success', "Seller '{$seller->business_name}' is now marked as {$statusStr}.");
    }

    public function toggleSuspension(SellerProfile $seller): RedirectResponse
    {
        $user = $seller->user;
        $newStatus = $user->status === 'active' ? 'blocked' : 'active';
        $user->update(['status' => $newStatus]);

        AuditLog::record(
            "seller.{$newStatus}",
            SellerProfile::class,
            $seller->id,
            ['business_name' => $seller->business_name, 'new_status' => $newStatus]
        );

        $action = $newStatus === 'blocked' ? 'suspended' : 'reactivated';
        return back()->with('success', "Seller '{$seller->business_name}' has been {$action}.");
    }
}
