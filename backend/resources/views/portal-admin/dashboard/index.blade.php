@extends('portal-admin.layouts.app', ['title' => 'Portal Dashboard'])

@section('content')
<div class="space-y-6">

    <!-- Hero / Welcome Banner matching Next.js visual vibe -->
    <div class="bg-gradient-to-r from-[#031727] via-[#06243d] to-[#093557] rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-lg border border-white/10">
        <div class="relative z-10 max-w-2xl space-y-2">
            <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#ff5a0a]/20 text-[#ff8b51] text-[11px] font-extrabold uppercase tracking-wider border border-[#ff5a0a]/30">
                PlaceX Marketplace CMS
            </span>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                Frontend Marketplace &amp; Content Management
            </h1>
            <p class="text-xs sm:text-sm text-slate-300">
                Curate, publish, and inspect listings across Pakistan that appear live on <a href="http://localhost:3000" target="_blank" class="text-orange underline font-bold">http://localhost:3000</a>.
            </p>
        </div>
        <div class="absolute right-6 -bottom-6 text-white/5 text-9xl font-black pointer-events-none select-none">
            PlaceX
        </div>
    </div>

    <!-- 6 KPI CARDS (Real Database Figures) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        <!-- Total Listings -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-placex-line flex flex-col justify-between">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Ads</span>
                <i class="fa-solid fa-layer-group text-slate-300"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-slate-900">{{ number_format($totalListings) }}</span>
                <span class="text-[10px] text-slate-400 block mt-0.5">Database records</span>
            </div>
        </div>

        <!-- Published (Active & Approved) -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-emerald-100 flex flex-col justify-between">
            <div class="flex items-center justify-between text-emerald-600">
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-800">Live on Site</span>
                <i class="fa-solid fa-globe"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-emerald-600">{{ number_format($publishedListings) }}</span>
                <span class="text-[10px] text-emerald-700/80 block mt-0.5">Published &amp; Approved</span>
            </div>
        </div>

        <!-- Draft Listings -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-placex-line flex flex-col justify-between">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Drafts</span>
                <i class="fa-solid fa-file-pen text-slate-300"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-slate-700">{{ number_format($draftListings) }}</span>
                <span class="text-[10px] text-slate-400 block mt-0.5">Unpublished drafts</span>
            </div>
        </div>

        <!-- Pending Moderation -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-amber-100 flex flex-col justify-between">
            <div class="flex items-center justify-between text-amber-600">
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-800">In Review</span>
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-amber-600">{{ number_format($pendingModeration) }}</span>
                <span class="text-[10px] text-amber-700/80 block mt-0.5">Pending approval</span>
            </div>
        </div>

        <!-- Closed / Inactive -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-placex-line flex flex-col justify-between">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Closed / Exp</span>
                <i class="fa-solid fa-box-archive text-slate-300"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-slate-500">{{ number_format($closedListings) }}</span>
                <span class="text-[10px] text-slate-400 block mt-0.5">Inactive or expired</span>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-placex-line flex flex-col justify-between">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Market Users</span>
                <i class="fa-solid fa-users text-slate-300"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-slate-900">{{ number_format($totalUsers) }}</span>
                <span class="text-[10px] text-slate-400 block mt-0.5">Registered accounts</span>
            </div>
        </div>
    </div>

    <!-- 5 CATEGORY SPECIFIC COUNTERS (Matching Next.js 5 Sections) -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-placex-line space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight">Marketplace Core Verticals</h2>
                <p class="text-xs text-slate-500">Real-time listing counts by public portal categories</p>
            </div>
            <a href="{{ route('portal-admin.categories.index') }}" class="text-xs font-bold text-orange hover:underline">
                Manage Taxonomy &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <!-- Jobs -->
            <a href="{{ route('portal-admin.jobs.index') }}" 
               class="p-4 rounded-xl bg-[#edf4ff] hover:bg-[#e1edff] transition border border-blue-100 flex flex-col justify-between group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-[#0874ef]">JOBS</span>
                    <i class="fa-solid fa-briefcase text-[#0874ef] text-sm group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="mt-3">
                    <div class="text-xl font-black text-[#0874ef]">{{ $categoryBreakdown['jobs']['count'] ?? 0 }}</div>
                    <span class="text-[11px] text-blue-900/60 font-medium">Careers &amp; Employers</span>
                </div>
            </a>

            <!-- Property -->
            <a href="{{ route('portal-admin.property.index') }}" 
               class="p-4 rounded-xl bg-[#edf8f1] hover:bg-[#dcf4e4] transition border border-emerald-100 flex flex-col justify-between group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-[#07964c]">PROPERTY</span>
                    <i class="fa-solid fa-building text-[#07964c] text-sm group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="mt-3">
                    <div class="text-xl font-black text-[#07964c]">{{ $categoryBreakdown['property']['count'] ?? 0 }}</div>
                    <span class="text-[11px] text-emerald-900/60 font-medium">Sale &amp; Rent Listings</span>
                </div>
            </a>

            <!-- Classifieds -->
            <a href="{{ route('portal-admin.classifieds.index') }}" 
               class="p-4 rounded-xl bg-[#fff3e8] hover:bg-[#ffe7d1] transition border border-orange-100 flex flex-col justify-between group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-[#ff8500]">CLASSIFIEDS</span>
                    <i class="fa-solid fa-boxes-stacked text-[#ff8500] text-sm group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="mt-3">
                    <div class="text-xl font-black text-[#ff8500]">{{ $categoryBreakdown['classifieds']['count'] ?? 0 }}</div>
                    <span class="text-[11px] text-orange-900/60 font-medium">Items, Goods, Mobiles</span>
                </div>
            </a>

            <!-- Vehicles -->
            <a href="{{ route('portal-admin.vehicles.index') }}" 
               class="p-4 rounded-xl bg-[#fff0f2] hover:bg-[#ffe0e4] transition border border-rose-100 flex flex-col justify-between group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-[#ff3b52]">VEHICLES</span>
                    <i class="fa-solid fa-car text-[#ff3b52] text-sm group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="mt-3">
                    <div class="text-xl font-black text-[#ff3b52]">{{ $categoryBreakdown['vehicles']['count'] ?? 0 }}</div>
                    <span class="text-[11px] text-rose-900/60 font-medium">Cars, Bikes, Motors</span>
                </div>
            </a>

            <!-- Matrimonial -->
            <a href="{{ route('portal-admin.matrimonial.index') }}" 
               class="p-4 rounded-xl bg-[#f5edff] hover:bg-[#ecdcff] transition border border-purple-100 flex flex-col justify-between group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-[#9137e8]">MATRIMONIAL</span>
                    <i class="fa-solid fa-heart text-[#9137e8] text-sm group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="mt-3">
                    <div class="text-xl font-black text-[#9137e8]">{{ $categoryBreakdown['matrimonial']['count'] ?? 0 }}</div>
                    <span class="text-[11px] text-purple-900/60 font-medium">Confidential Profiles</span>
                </div>
            </a>
        </div>
    </div>

    <!-- MAIN TWO COLUMN OPERATIONAL AREA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Listings on Public Feed (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-placex-line overflow-hidden space-y-4 p-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-base font-black text-slate-900">Recent Marketplace Submissions</h2>
                    <p class="text-xs text-slate-500">Live listings synchronized with public web feed</p>
                </div>
                <a href="{{ route('portal-admin.listings.index') }}" class="text-xs font-bold text-orange hover:underline">
                    View All Ads &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentListings as $ad)
                    <div class="py-3 flex items-center justify-between gap-4 hover:bg-slate-50 transition px-2 rounded-lg">
                        <div class="flex items-center space-x-3 min-w-0">
                            @php
                                $img = $ad->images->first();
                            @endphp
                            @if($img)
                                <img src="{{ $img->image_url }}" alt="{{ $ad->title }}" class="w-12 h-12 rounded-lg object-cover bg-slate-100 flex-shrink-0 border border-slate-200">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 flex-shrink-0 border border-slate-200">
                                    <i class="fa-solid fa-image text-xs"></i>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <a href="{{ route('portal-admin.listings.edit', $ad) }}" class="font-bold text-xs text-slate-900 hover:text-orange truncate block">
                                    {{ $ad->title }}
                                </a>
                                <div class="flex items-center space-x-2 text-[11px] text-slate-500 mt-0.5">
                                    <span class="font-semibold text-slate-700">{{ $ad->category->name ?? 'General' }}</span>
                                    <span>·</span>
                                    <span>{{ $ad->currency }} {{ number_format($ad->price) }}</span>
                                    <span>·</span>
                                    <span>{{ $ad->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 flex-shrink-0">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $ad->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($ad->listing_status) }}
                            </span>
                            <a href="{{ route('portal-admin.listings.edit', $ad) }}" class="p-1.5 text-slate-400 hover:text-orange" title="Edit Listing">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">No listings submitted yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Review Queue & Quick Inquiries (1 col) -->
        <div class="space-y-6">

            <!-- Review Queue -->
            <div class="bg-white rounded-2xl shadow-sm border border-placex-line p-5 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-hourglass-start text-amber-500"></i>
                        <span>Pending Review ({{ $pendingModeration }})</span>
                    </h3>
                </div>

                <div class="divide-y divide-slate-100 text-xs">
                    @forelse($pendingQueue as $pItem)
                        <div class="py-2.5 flex items-center justify-between">
                            <div class="min-w-0 pr-2">
                                <a href="{{ route('portal-admin.listings.edit', $pItem) }}" class="font-bold text-slate-800 hover:text-orange truncate block">
                                    {{ $pItem->title }}
                                </a>
                                <span class="text-[10px] text-slate-400">{{ $pItem->category->name ?? 'Ad' }} · By {{ $pItem->user->name ?? 'User' }}</span>
                            </div>
                            <form method="POST" action="{{ route('portal-admin.listings.publish', $pItem) }}" class="flex-shrink-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded text-[10px] transition">
                                    Publish
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">Queue is clear! No pending ads.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Safety Reports & Feedback -->
            <div class="bg-white rounded-2xl shadow-sm border border-placex-line p-5 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-rose-500"></i>
                        <span>Market Safety &amp; Enquiries</span>
                    </h3>
                    <a href="{{ route('portal-admin.enquiries.index') }}" class="text-[11px] text-orange hover:underline font-bold">All</a>
                </div>

                <div class="space-y-2 text-xs">
                    @forelse($recentReports as $rep)
                        <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                            <div class="flex items-center justify-between font-bold text-slate-900 text-[11px]">
                                <span class="text-rose-600 uppercase">{{ $rep->reason }}</span>
                                <span class="text-slate-400 font-normal">{{ $rep->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[11px] text-slate-600 mt-1 line-clamp-1">{{ $rep->details ?? 'No details' }}</p>
                            <div class="mt-1.5 flex items-center justify-between text-[10px] text-slate-500">
                                <span>Ad: #{{ $rep->listing_id }}</span>
                                <a href="{{ route('portal-admin.enquiries.show', $rep) }}" class="text-orange font-bold hover:underline">Inspect Case &rarr;</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">No active safety complaints.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
