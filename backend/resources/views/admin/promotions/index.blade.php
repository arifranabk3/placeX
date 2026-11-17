@extends('admin.layouts.app')

@section('title', 'Promotions & Featured Plans')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Promotions & Entitlements</h1>
            <p class="text-sm text-slate-500 mt-1">Manage monetization tiers, featured listing plans, and customer promotion quotas.</p>
        </div>
    </div>

    <!-- Plans Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($plans as $plan)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary-900">{{ $plan->name }}</span>
                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $plan->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $plan->is_active ? 'Active' : 'Disabled' }}
                    </span>
                </div>
                <div class="text-2xl font-black text-slate-900">
                    PKR {{ number_format($plan->price) }}
                </div>
                <div class="text-xs text-slate-500 space-y-1">
                    <div>Duration: <span class="font-semibold text-slate-800">{{ $plan->duration_days }} Days</span></div>
                    <div>Badge: <span class="font-semibold text-slate-800">{{ $plan->badge_label ?? 'Featured' }}</span></div>
                    <div>Active Usages: <span class="font-semibold text-slate-800">{{ $plan->promotions_count }}</span></div>
                </div>
            </div>
        @empty
            <div class="col-span-4 bg-white p-8 rounded-xl border border-slate-200 text-center text-slate-500">
                No promotion plans configured.
            </div>
        @endforelse
    </div>

    <!-- Manual Entitlement Grant Form -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Grant Manual Promotion Quota to User</h2>
        <form method="POST" action="{{ route('admin.promotions.grant') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">User ID</label>
                <input type="number" name="user_id" required placeholder="User account ID" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Promotion Plan</label>
                <select name="plan_id" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @foreach($plans as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->duration_days }}d)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Quantity</label>
                <input type="number" name="quantity" value="1" min="1" max="50" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Validity (Days)</label>
                <input type="number" name="valid_days" value="30" min="1" max="365" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2 bg-primary-900 text-white text-sm font-semibold rounded-lg hover:bg-primary-800 transition">
                    Grant Entitlement
                </button>
            </div>
        </form>
    </div>

    <!-- Active Promoted Listings Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">Currently Featured Listings ({{ $totalPromoted }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-600 tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Listing Title</th>
                        <th class="px-5 py-3">Applied Plan</th>
                        <th class="px-5 py-3">Promoted Since</th>
                        <th class="px-5 py-3">Expires At</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($activePromotions as $promo)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.listings.show', $promo->listing) }}" class="font-medium text-slate-900 hover:text-primary-600">
                                    {{ $promo->listing->title ?? 'Listing #' . $promo->listing_id }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $promo->plan->name ?? 'Custom' }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $promo->starts_at ? $promo->starts_at->format('M d, Y') : '—' }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $promo->ends_at ? $promo->ends_at->format('M d, Y') : '—' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Active</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-slate-500">No active featured ads running.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
