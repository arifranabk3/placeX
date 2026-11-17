@extends('portal-admin.layouts.app', ['title' => 'Matrimonial CMS'])

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-7 h-7 rounded-lg bg-[#f5edff] text-[#9137e8] flex items-center justify-center text-xs">
                    <i class="fa-solid fa-heart"></i>
                </span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Matrimonial &amp; Matchmaking Portal</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">Manage private matchmaking profiles, family preferences, and consent verification on <code>/matrimonial</code>.</p>
        </div>
        @if($canViewMatrimonial)
            <a href="{{ route('portal-admin.matrimonial.create') }}" class="btn-portal-primary px-4 py-2 rounded-lg text-xs font-bold flex items-center space-x-2 self-start sm:self-auto shadow-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Add Matrimonial Profile</span>
            </a>
        @endif
    </div>

    <!-- Strict Privacy Notice -->
    <div class="p-4 bg-purple-50/70 border border-purple-200 rounded-xl flex items-start space-x-3 text-xs text-purple-900">
        <i class="fa-solid fa-shield-cat text-purple-600 text-sm mt-0.5"></i>
        <div>
            <span class="font-bold">Confidentiality &amp; Data Safeguard Active:</span>
            <p class="text-purple-800 text-[11px] mt-0.5">Matrimonial records are strictly serialized and protected. Sensitive personal attributes are only viewable by authorized Portal Managers with explicit <code>portal.matrimonial.manage</code> credentials.</p>
        </div>
    </div>

    @if(! $canViewMatrimonial)
        <div class="bg-white p-12 text-center rounded-2xl border border-placex-line text-slate-400">
            <i class="fa-solid fa-lock text-3xl mb-2 text-slate-300"></i>
            <h3 class="font-bold text-slate-700">Access Restricted</h3>
            <p class="text-xs text-slate-500 mt-1">You do not possess the required <code>portal.matrimonial.manage</code> permission to view matrimonial candidate listings.</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-placex-line overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 border-b border-slate-200 uppercase font-black text-slate-600 text-[10px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Candidate Heading</th>
                            <th class="px-5 py-3.5">Gender / Age</th>
                            <th class="px-5 py-3.5">Marital Status</th>
                            <th class="px-5 py-3.5">Profession / Edu</th>
                            <th class="px-5 py-3.5">City</th>
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
                                    <span class="text-[10px] text-slate-400">Profile Code: #MAT-{{ $item->id }}</span>
                                </td>
                                <td class="px-5 py-3.5 font-semibold text-slate-800 capitalize">
                                    {{ $item->matrimonialProfile->gender ?? '—' }} · {{ $item->matrimonialProfile->age ?? '—' }} yrs
                                </td>
                                <td class="px-5 py-3.5 capitalize text-slate-600">
                                    {{ $item->matrimonialProfile->marital_status ?? 'Single' }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-700">
                                    <div class="font-semibold">{{ $item->matrimonialProfile->profession ?? 'Professional' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $item->matrimonialProfile->education ?? '' }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-slate-600">
                                    {{ $item->location->name ?? 'Pakistan' }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($item->listing_status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('portal-admin.listings.edit', $item) }}" class="p-1.5 text-slate-400 hover:text-orange rounded inline-block" title="Edit Profile">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-slate-400">No matrimonial profiles registered.</td>
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
    @endif

</div>
@endsection
