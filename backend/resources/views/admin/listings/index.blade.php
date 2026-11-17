@extends('admin.layouts.app')

@section('title', 'Listings Directory')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Listings Directory</h1>
            <p class="text-sm text-slate-500 mt-1">Manage, inspect, and moderate advertisements across Jobs, Property, Classifieds, Vehicles, and Matrimonial.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.listings.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or keyword..." 
                       class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Category</label>
                <select name="category_id" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Ad Status</label>
                <select name="listing_status" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('listing_status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('listing_status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="expired" {{ request('listing_status') === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Moderation</label>
                <select name="moderation_status" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">All</option>
                    <option value="pending" {{ request('moderation_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('moderation_status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('moderation_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full px-4 py-2 bg-primary-900 text-white text-sm font-medium rounded-lg hover:bg-primary-800 transition">
                    Filter
                </button>
                <a href="{{ route('admin.listings.index') }}" class="px-3 py-2 border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
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
                        <th class="px-5 py-3">Listing Title</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Seller</th>
                        <th class="px-5 py-3">Price</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Moderation</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($listings as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.listings.show', $item) }}" class="font-medium text-slate-900 hover:text-primary-600 block line-clamp-1">
                                    {{ $item->title }}
                                </a>
                                <span class="text-xs text-slate-400">{{ $item->location->name ?? 'Pakistan' }} · {{ $item->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                                    {{ $item->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs">
                                <div class="font-medium text-slate-900">{{ $item->user->name ?? 'Unknown' }}</div>
                                <div class="text-slate-400">{{ $item->user->email ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                {{ $item->currency }} {{ number_format($item->price) }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $item->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($item->listing_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($item->moderation_status === 'approved')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        Approved
                                    </span>
                                @elseif($item->moderation_status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1">
                                <a href="{{ route('admin.listings.show', $item) }}" class="p-1.5 text-slate-500 hover:text-primary-600 rounded transition inline-block" title="Inspect">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(auth()->user()->hasPermission('listings.edit'))
                                    <a href="{{ route('admin.listings.edit', $item) }}" class="p-1.5 text-slate-500 hover:text-amber-600 rounded transition inline-block" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-500">No listings found matching criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($listings->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
