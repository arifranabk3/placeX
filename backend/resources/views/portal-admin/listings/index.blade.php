@extends('portal-admin.layouts.app', ['title' => 'Marketplace Listings'])

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Marketplace Listings Directory</h1>
            <p class="text-xs text-slate-500 mt-1">Manage, curate, publish, pause, or edit live and draft listings appearing on the Next.js portal.</p>
        </div>
        <a href="{{ route('portal-admin.listings.create') }}" class="btn-portal-primary px-4 py-2 rounded-lg text-xs font-bold flex items-center space-x-2 self-start sm:self-auto shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>Create New Listing</span>
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-placex-line">
        <form method="GET" action="{{ route('portal-admin.listings.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Search Keyword</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, keyword..."
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Category</label>
                <select name="category_id" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Publish Status</label>
                <select name="status" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active (Live)</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="paused" {{ request('status') === 'paused' ? 'selected' : '' }}>Paused</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Moderation</label>
                <select name="moderation" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange">
                    <option value="">All Moderation</option>
                    <option value="approved" {{ request('moderation') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('moderation') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                    <option value="rejected" {{ request('moderation') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-lg text-xs transition">
                    Filter
                </button>
                <a href="{{ route('portal-admin.listings.index') }}" class="px-3 py-2 border border-slate-200 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Listings Table -->
    <div class="bg-white rounded-xl shadow-sm border border-placex-line overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 uppercase font-black text-slate-600 text-[10px] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Listing Title</th>
                        <th class="px-5 py-3.5">Category</th>
                        <th class="px-5 py-3.5">Price</th>
                        <th class="px-5 py-3.5">Publisher</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Moderation</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($listings as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center space-x-3">
                                    @php $thumb = $item->images->first(); @endphp
                                    @if($thumb)
                                        <img src="{{ $thumb->image_url }}" alt="{{ $item->title }}" class="w-10 h-10 rounded-lg object-cover bg-slate-100 flex-shrink-0 border border-slate-200">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 flex-shrink-0 border border-slate-200">
                                            <i class="fa-solid fa-image text-xs"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <a href="{{ route('portal-admin.listings.edit', $item) }}" class="font-bold text-slate-900 hover:text-orange block truncate">
                                            {{ $item->title }}
                                        </a>
                                        <span class="text-[10px] text-slate-400">
                                            {{ $item->location->name ?? 'Pakistan' }} · Slug: <code>{{ $item->slug }}</code>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded font-semibold text-[11px] bg-slate-100 text-slate-800">
                                    {{ $item->category->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                {{ $item->currency }} {{ number_format($item->price) }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                <div class="font-medium text-slate-800">{{ $item->user->name ?? 'System Staff' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $item->user->email ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($item->listing_status === 'active')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span> Active
                                    </span>
                                @elseif($item->listing_status === 'draft')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        Draft
                                    </span>
                                @elseif($item->listing_status === 'paused')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        Paused
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        {{ ucfirst($item->listing_status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $item->moderation_status === 'approved' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ ucfirst($item->moderation_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                @if($item->listing_status !== 'active')
                                    <form method="POST" action="{{ route('portal-admin.listings.publish', $item) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded text-[10px] transition" title="Publish live to Next.js">
                                            Publish
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('portal-admin.listings.unpublish', $item) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1 bg-slate-600 hover:bg-slate-700 text-white font-bold rounded text-[10px] transition" title="Unpublish / Hide">
                                            Unpublish
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('portal-admin.listings.edit', $item) }}" class="p-1.5 text-slate-400 hover:text-orange rounded inline-block" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>

                                <form method="POST" action="{{ route('portal-admin.listings.destroy', $item) }}" class="inline-block" onsubmit="return confirm('Archive listing?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded transition" title="Archive">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">No marketplace listings match the search criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($listings->hasPages())
            <div class="px-5 py-4 border-t border-placex-line">
                {{ $listings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
