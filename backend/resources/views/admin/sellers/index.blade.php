@extends('admin.layouts.app')

@section('title', 'Sellers Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Seller Management</h1>
            <p class="text-sm text-slate-500 mt-1">Directory of commercial vendors, stores, and verified sellers on PlaceX.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.sellers.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Business name, owner, or email..." 
                       class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Verification Status</label>
                <select name="verification" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">All</option>
                    <option value="verified" {{ request('verification') === 'verified' ? 'selected' : '' }}>Verified Only</option>
                    <option value="unverified" {{ request('verification') === 'unverified' ? 'selected' : '' }}>Unverified</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Seller Type</label>
                <select name="type" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">All Types</option>
                    <option value="individual" {{ request('type') === 'individual' ? 'selected' : '' }}>Individual</option>
                    <option value="business" {{ request('type') === 'business' ? 'selected' : '' }}>Business</option>
                    <option value="dealer" {{ request('type') === 'dealer' ? 'selected' : '' }}>Dealer</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full px-4 py-2 bg-primary-900 text-white text-sm font-medium rounded-lg hover:bg-primary-800 transition">
                    Filter
                </button>
                <a href="{{ route('admin.sellers.index') }}" class="px-3 py-2 border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-600 tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Business / Seller</th>
                        <th class="px-5 py-3">Owner Account</th>
                        <th class="px-5 py-3">Type</th>
                        <th class="px-5 py-3">Verification</th>
                        <th class="px-5 py-3">Active Ads</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sellers as $seller)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-medium text-slate-900">{{ $seller->business_name }}</div>
                                <div class="text-xs text-slate-500">{{ $seller->tagline ?? 'No tagline' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.users.show', $seller->user) }}" class="font-medium text-slate-900 hover:text-primary-600">
                                    {{ $seller->user->name ?? 'Deleted User' }}
                                </a>
                                <div class="text-xs text-slate-500">{{ $seller->user->email ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="capitalize text-xs font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                                    {{ $seller->seller_type ?? 'Individual' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($seller->is_verified)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        Unverified
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 font-medium text-slate-900">
                                {{ $seller->user->listings->count() ?? 0 }}
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1">
                                <a href="{{ route('admin.sellers.show', $seller) }}" class="p-1.5 text-slate-500 hover:text-primary-600 rounded transition inline-block" title="View details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.sellers.toggle-verify', $seller) }}" class="inline-block" onsubmit="return confirm('Toggle verification badge for this seller?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-1.5 text-slate-500 hover:text-emerald-600 rounded transition" title="{{ $seller->is_verified ? 'Remove verification' : 'Verify seller' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">No sellers registered or found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sellers->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $sellers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
