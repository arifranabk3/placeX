<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Listing;
use App\Models\ListingPromotion;
use App\Models\PromotionEntitlement;
use App\Models\PromotionPlan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function index(): View
    {
        $plans = PromotionPlan::withCount('promotions')->orderBy('price')->get();
        $activePromotions = ListingPromotion::with(['listing', 'plan'])->where('status', 'active')->latest()->paginate(15);
        $totalPromoted = ListingPromotion::where('status', 'active')->count();

        return view('admin.promotions.index', compact('plans', 'activePromotions', 'totalPromoted'));
    }

    public function grantEntitlement(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:promotion_plans,id',
            'quantity' => 'required|integer|min:1|max:50',
            'valid_days' => 'required|integer|min:1|max:365',
        ]);

        $entitlement = PromotionEntitlement::create([
            'user_id' => $validated['user_id'],
            'plan_id' => $validated['plan_id'],
            'quantity_remaining' => $validated['quantity'],
            'expires_at' => now()->addDays($validated['valid_days']),
        ]);

        AuditLog::record(
            'promotion.entitlement_granted',
            PromotionEntitlement::class,
            $entitlement->id,
            $validated
        );

        return back()->with('success', "Granted {$validated['quantity']} promotion credit(s) to user.");
    }
}
