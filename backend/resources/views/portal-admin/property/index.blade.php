@extends('portal-admin.layouts.app', ['title' => 'Property CMS'])

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-7 h-7 rounded-lg bg-[#edf8f1] text-[#07964c] flex items-center justify-center text-xs">
                    <i class="fa-solid fa-building"></i>
                </span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Real Estate &amp; Property Management</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">Manage residential, commercial, plots, and rental listings appearing on <code>/property</code>.</p>
        </div>
        <a href="{{ route('portal-admin.property.create') }}" class="btn-portal-primary px-4 py-2 rounded-lg text-xs font-bold flex items-center space-x-2 self-start sm:self-auto shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>Add Property</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-placex-line overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 uppercase font-black text-slate-600 text-[10px] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Property Listing</th>
                        <th class="px-5 py-3.5">Purpose</th>
                        <th class="px-5 py-3.5">Area</th>
                        <th class="px-5 py-3.5">Bed / Bath</th>
                        <th class="px-5 py-3.5">Price</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($listings as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('portal-admin.listings.edit', $item) }}" class="font-bold text-slate-900 hover:text-orange block truncate">
                                    {{ $item->title }}
                                </a>
                                <span class="text-[10px] text-slate-400">{{ $item->location->name ?? 'Pakistan' }}</span>
                            </td>
                            <td class="px-5 py-3.5 uppercase font-bold text-[10px] text-emerald-700">
                                {{ $item->propertyDetail->property_purpose ?? 'Sale' }}
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">
                                {{ $item->propertyDetail->area_size ?? '5 Marla' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $item->propertyDetail->bedrooms ?? 3 }} Bed · {{ $item->propertyDetail->bathrooms ?? 3 }} Bath
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                PKR {{ number_format($item->price) }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($item->listing_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('portal-admin.listings.edit', $item) }}" class="p-1.5 text-slate-400 hover:text-orange rounded inline-block" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">No real estate listings found.</td>
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
