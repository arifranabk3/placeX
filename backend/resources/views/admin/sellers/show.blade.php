@extends('admin.layouts.app')

@section('title', 'Seller Profile: ' . $seller->business_name)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="text-2xl font-bold text-slate-900">{{ $seller->business_name }}</h1>
                @if($seller->is_verified)
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Verified
                    </span>
                @endif
            </div>
            <p class="text-sm text-slate-500 mt-1">Owner: {{ $seller->user->name ?? '—' }} ({{ $seller->user->email ?? '—' }})</p>
        </div>
        <div class="flex items-center space-x-2">
            <form method="POST" action="{{ route('admin.sellers.toggle-verify', $seller) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-4 py-2 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                    {{ $seller->is_verified ? 'Revoke Verification' : 'Verify Seller' }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.sellers.toggle-suspend', $seller) }}" onsubmit="return confirm('Suspend or activate this seller account?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-4 py-2 {{ $seller->user->status === 'active' ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }} text-white text-sm font-medium rounded-lg transition">
                    {{ $seller->user->status === 'active' ? 'Suspend Account' : 'Reactivate Account' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Seller Stats & Listings -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Business Details</h3>
            <div class="text-sm space-y-2">
                <div>
                    <span class="text-xs text-slate-400 block">Type</span>
                    <span class="font-medium capitalize text-slate-900">{{ $seller->seller_type ?? 'Individual' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Tagline</span>
                    <span class="font-medium text-slate-900">{{ $seller->tagline ?? 'None' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Website</span>
                    <span class="font-medium text-slate-900">{{ $seller->website ?? 'None' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Registered On</span>
                    <span class="font-medium text-slate-900">{{ $seller->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Inventory / Listings ({{ $seller->user->listings->count() }})</h3>
            <div class="divide-y divide-slate-100">
                @forelse($seller->user->listings as $listing)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <a href="{{ route('admin.listings.show', $listing) }}" class="text-sm font-medium text-slate-900 hover:text-primary-600">
                                {{ $listing->title }}
                            </a>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $listing->currency }} {{ number_format($listing->price) }} · Status: {{ $listing->listing_status }}
                            </div>
                        </div>
                        <a href="{{ route('admin.listings.show', $listing) }}" class="text-xs font-semibold text-primary-600 hover:underline">
                            Inspect &rarr;
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 py-4">No active ads listed under this seller profile.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
