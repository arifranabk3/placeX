@extends('portal-admin.layouts.app', ['title' => 'Portal Dashboard'])

@section('content')
<div class="space-y-5 w-full">

    <!-- Hero / Welcome Banner matching Next.js visual vibe (Fluid) -->
    <div class="bg-gradient-to-r from-[#031727] via-[#06243d] to-[#093557] rounded-2xl p-5 sm:p-7 text-white relative overflow-hidden shadow-lg border border-white/10 w-full">
        <div class="relative z-10 max-w-3xl space-y-2">
            <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#ff5a0a]/20 text-[#ff8b51] text-[11px] font-extrabold uppercase tracking-wider border border-[#ff5a0a]/30">
                PlaceX Marketplace CMS
            </span>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-black tracking-tight leading-tight">
                Frontend Marketplace &amp; Content Management
            </h1>
            <p class="text-xs sm:text-sm text-slate-300">
                Curate, publish, and inspect listings across Pakistan that appear live on <a href="http://localhost:3000" target="_blank" class="text-orange underline font-bold">http://localhost:3000</a>.
            </p>
        </div>
        <div class="absolute right-4 -bottom-6 text-white/5 text-8xl sm:text-9xl font-black pointer-events-none select-none hidden md:block">
            PlaceX
        </div>
    </div>

    <!-- 6 KPI CARDS (Fluid Adaptive Grid) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4 w-full">
        <!-- Total Listings -->
        <div class="bg-white p-4 rounded-2xl shadow-xs border border-placex-line flex flex-col justify-between">
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
        <div class="bg-white p-4 rounded-2xl shadow-xs border border-emerald-100 flex flex-col justify-between">
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
        <div class="bg-white p-4 rounded-2xl shadow-xs border border-placex-line flex flex-col justify-between">
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
        <div class="bg-white p-4 rounded-2xl shadow-xs border border-amber-100 flex flex-col justify-between">
            <div class="flex items-center justify-between text-amber-600">
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-800">Pending</span>
                <i class="fa-solid fa-clock text-amber-400"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-amber-600">{{ number_format($pendingModeration) }}</span>
                <span class="text-[10px] text-amber-700/80 block mt-0.5">Awaiting review</span>
            </div>
        </div>

        <!-- Media Assets -->
        <div class="bg-white p-4 rounded-2xl shadow-xs border border-placex-line flex flex-col justify-between">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Media Photos</span>
                <i class="fa-solid fa-images text-slate-300"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-slate-800">{{ number_format($mediaAssets) }}</span>
                <span class="text-[10px] text-slate-400 block mt-0.5">Stored images</span>
            </div>
        </div>

        <!-- Enquiries -->
        <div class="bg-white p-4 rounded-2xl shadow-xs border border-placex-line flex flex-col justify-between">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Enquiries</span>
                <i class="fa-solid fa-comments text-slate-300"></i>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-slate-800">{{ number_format($newEnquiries) }}</span>
                <span class="text-[10px] text-slate-400 block mt-0.5">Customer leads</span>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts across 5 Categories (Fluid Auto-Fit Grid) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 w-full">
        <!-- Jobs -->
        <a href="{{ route('portal-admin.jobs.index') }}" 
           class="bg-white p-4 rounded-2xl border border-placex-line shadow-xs hover:border-orange hover:shadow-md transition flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg group-hover:bg-orange group-hover:text-white transition shrink-0">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-bold text-slate-900 block truncate">Jobs Portal</span>
                <span class="text-[10px] text-slate-400">Careers &amp; Hiring</span>
            </div>
        </a>

        <!-- Property -->
        <a href="{{ route('portal-admin.property.index') }}" 
           class="bg-white p-4 rounded-2xl border border-placex-line shadow-xs hover:border-orange hover:shadow-md transition flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg group-hover:bg-orange group-hover:text-white transition shrink-0">
                <i class="fa-solid fa-building"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-bold text-slate-900 block truncate">Property Portal</span>
                <span class="text-[10px] text-slate-400">Sale &amp; Rent</span>
            </div>
        </a>

        <!-- Classifieds -->
        <a href="{{ route('portal-admin.classifieds.index') }}" 
           class="bg-white p-4 rounded-2xl border border-placex-line shadow-xs hover:border-orange hover:shadow-md transition flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg group-hover:bg-orange group-hover:text-white transition shrink-0">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-bold text-slate-900 block truncate">Classifieds</span>
                <span class="text-[10px] text-slate-400">Electronics &amp; Items</span>
            </div>
        </a>

        <!-- Vehicles -->
        <a href="{{ route('portal-admin.vehicles.index') }}" 
           class="bg-white p-4 rounded-2xl border border-placex-line shadow-xs hover:border-orange hover:shadow-md transition flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg group-hover:bg-orange group-hover:text-white transition shrink-0">
                <i class="fa-solid fa-car"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-bold text-slate-900 block truncate">Vehicles</span>
                <span class="text-[10px] text-slate-400">Cars &amp; Bikes</span>
            </div>
        </a>

        <!-- Matrimonial -->
        <a href="{{ route('portal-admin.matrimonial.index') }}" 
           class="bg-white p-4 rounded-2xl border border-placex-line shadow-xs hover:border-orange hover:shadow-md transition flex items-center space-x-3 group col-span-2 sm:col-span-1">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg group-hover:bg-orange group-hover:text-white transition shrink-0">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-bold text-slate-900 block truncate">Matrimonial</span>
                <span class="text-[10px] text-slate-400">Verified Matchmaking</span>
            </div>
        </a>
    </div>

    <!-- Recent Listings & Live Synchronization -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 w-full">

        <!-- Left Table (Fluid 8 cols on desktop, full width on mobile) -->
        <div class="lg:col-span-8 bg-white rounded-2xl shadow-xs border border-placex-line overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-black text-slate-900 tracking-tight">Recent Marketplace Activity</h2>
                        <p class="text-[11px] text-slate-400">Latest listings synced with the Next.js public platform.</p>
                    </div>
                    <a href="{{ route('portal-admin.listings.index') }}" class="text-xs font-bold text-orange hover:underline">
                        View All Listings &rarr;
                    </a>
                </div>

                <!-- Table Container with Fluid Inner Scroll -->
                <div class="overflow-x-auto portal-scrollbar">
                    <table class="w-full text-left text-xs text-slate-700 min-w-[580px]">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-[10px] font-black uppercase text-slate-500 tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Ad Title</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentListings as $listing)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-slate-900 truncate max-w-xs">{{ $listing->title }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $listing->location->name ?? 'Pakistan' }} · {{ $listing->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">
                                            {{ $listing->category->name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-bold text-slate-900 whitespace-nowrap">
                                        {{ $listing->currency }} {{ number_format($listing->price) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($listing->listing_status === 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                                {{ ucfirst($listing->listing_status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <a href="{{ route('portal-admin.listings.edit', $listing) }}" class="text-orange hover:text-orange/80 font-bold text-xs">
                                            Edit &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-xs">
                                        No recent listings recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: CMS Quick Navigation & Public Health (4 cols) -->
        <div class="lg:col-span-4 space-y-4">
            <!-- Next.js Frontend Link Box -->
            <div class="bg-white p-5 rounded-2xl shadow-xs border border-placex-line space-y-3">
                <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">
                    Public Portal Synchronization
                </span>
                <p class="text-xs text-slate-600 leading-relaxed">
                    All published listings immediately stream to the Next.js React frontend through the REST API v1.
                </p>
                <div class="pt-2">
                    <a href="http://localhost:3000" target="_blank" 
                       class="w-full btn-portal-primary py-2.5 rounded-xl text-xs font-bold flex items-center justify-center space-x-2 shadow-sm">
                        <span>Open PlaceX Frontend (Next.js)</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Vertical Quick Jumps -->
            <div class="bg-white p-5 rounded-2xl shadow-xs border border-placex-line space-y-2.5">
                <span class="text-xs font-black uppercase tracking-wider text-slate-800 block">
                    Quick CMS Categories
                </span>
                <div class="space-y-1.5">
                    @foreach($categories as $category)
                        <a href="{{ route('portal-admin.listings.index', ['category_id' => $category->id]) }}" 
                           class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 text-xs text-slate-700 font-semibold group transition">
                            <span class="group-hover:text-orange truncate">{{ $category->name }}</span>
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-[10px] text-slate-500 font-bold shrink-0">
                                {{ $category->listings_count ?? $category->listings()->count() }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
