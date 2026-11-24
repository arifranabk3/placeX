@extends('portal-admin.layouts.app', ['title' => 'Portal Dashboard'])

@section('content')
<div class="space-y-6 w-full" x-data="portalDashboard()">

    <!-- 1. WELCOME HEADER (Premium Navy + Orange Gradient, Fluid) -->
    <div class="bg-gradient-to-r from-[#031727] via-[#06243d] to-[#093557] rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-xl border border-white/10 w-full">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-[#ff5a0a]/20 text-[#ff8b51] text-[11px] font-extrabold uppercase tracking-wider border border-[#ff5a0a]/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff5a0a] animate-pulse"></span>
                        PlaceX Marketplace CMS
                    </span>
                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        {{ now()->format('l, d F Y') }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight leading-tight">
                    Marketplace &amp; Content Management
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Welcome back, <strong class="text-white">{{ auth()->user()->name ?? 'Administrator' }}</strong>. Curate, publish, and inspect listings across Pakistan synced live with the storefront.
                </p>
            </div>

            <!-- Welcome Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 shrink-0">
                <a href="{{ route('portal-admin.listings.create') }}" 
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-orange hover:bg-orange/90 text-white text-xs sm:text-sm font-bold shadow-md shadow-orange/30 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Create Listing</span>
                </a>
                <a href="{{ route('portal-admin.jobs.create') }}" 
                   class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-semibold border border-white/15 backdrop-blur-sm transition-all">
                    <i class="fa-solid fa-briefcase text-xs text-orange"></i>
                    <span>Add Job</span>
                </a>
                <a href="{{ route('portal-admin.property.create') }}" 
                   class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-semibold border border-white/15 backdrop-blur-sm transition-all">
                    <i class="fa-solid fa-building text-xs text-emerald-400"></i>
                    <span>Add Property</span>
                </a>
            </div>
        </div>

        <!-- Decorative background watermark -->
        <div class="absolute right-4 -bottom-8 text-white/[0.04] text-8xl sm:text-9xl font-black pointer-events-none select-none hidden lg:block tracking-tighter">
            PlaceX
        </div>
    </div>

    <!-- 2. SIX KPI STATISTIC CARDS (100% Real Database Data) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 w-full">
        
        <!-- KPI 1: Total Listings -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/90 flex flex-col justify-between hover:border-slate-300 hover:shadow-md transition min-w-0">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 leading-tight">Total Listings</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-xs shrink-0">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalListings) }}</span>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1.5 truncate">
                    <i class="fa-solid fa-database text-[11px] text-slate-400 shrink-0"></i>
                    <span>All categories</span>
                </div>
            </div>
        </div>

        <!-- KPI 2: Published Listings -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-emerald-200/90 flex flex-col justify-between hover:border-emerald-300 hover:shadow-md transition min-w-0">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 leading-tight">Published Live</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl sm:text-3xl font-black text-emerald-600 tracking-tight block">{{ number_format($publishedListings) }}</span>
                <div class="flex items-center gap-1.5 text-xs text-emerald-700 font-semibold mt-1.5 truncate">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shrink-0"></span>
                    <span>Live on PlaceX</span>
                </div>
            </div>
        </div>

        <!-- KPI 3: Pending Approval -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-amber-200/90 flex flex-col justify-between hover:border-amber-300 hover:shadow-md transition min-w-0">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-800 leading-tight">Pending Review</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl sm:text-3xl font-black {{ $pendingApproval > 0 ? 'text-amber-600' : 'text-slate-900' }} tracking-tight block">{{ number_format($pendingApproval) }}</span>
                <div class="flex items-center gap-1.5 text-xs {{ $pendingApproval > 0 ? 'text-amber-700 font-bold' : 'text-slate-400' }} mt-1.5 truncate">
                    <i class="fa-regular fa-clock text-[11px] shrink-0"></i>
                    <span>Moderation queue</span>
                </div>
            </div>
        </div>

        <!-- KPI 4: Total Users -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-blue-200/90 flex flex-col justify-between hover:border-blue-300 hover:shadow-md transition min-w-0">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-800 leading-tight">Total Users</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalUsers) }}</span>
                <div class="flex items-center gap-1.5 text-xs text-blue-600 font-medium mt-1.5 truncate">
                    <i class="fa-solid fa-user-check text-[11px] shrink-0"></i>
                    <span>Registered users</span>
                </div>
            </div>
        </div>

        <!-- KPI 5: Active Sellers -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-purple-200/90 flex flex-col justify-between hover:border-purple-300 hover:shadow-md transition min-w-0">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-purple-800 leading-tight">Active Sellers</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs shrink-0">
                    <i class="fa-solid fa-store"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($activeSellers) }}</span>
                <div class="flex items-center gap-1.5 text-xs text-purple-600 font-medium mt-1.5 truncate">
                    <i class="fa-solid fa-shop text-[11px] shrink-0"></i>
                    <span>Verified posters</span>
                </div>
            </div>
        </div>

        <!-- KPI 6: Total Enquiries -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-rose-200/90 flex flex-col justify-between hover:border-rose-300 hover:shadow-md transition min-w-0">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-rose-800 leading-tight">Total Enquiries</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs shrink-0">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalEnquiries) }}</span>
                <div class="flex items-center gap-1.5 text-xs text-slate-400 mt-1.5 truncate">
                    <i class="fa-solid fa-comments text-[11px] shrink-0"></i>
                    <span>Customer reports</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. FIVE CATEGORY SHORTCUTS (Real DB Counts & Direct Links) -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-shapes text-orange"></i>
                <span>Marketplace Verticals</span>
            </h2>
            <span class="text-xs text-slate-400 font-medium">5 Core Sectors</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 w-full">
            
            <!-- Jobs -->
            <a href="{{ route('portal-admin.jobs.index') }}" 
               class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-orange hover:shadow-md transition-all group flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-orange/10 text-orange flex items-center justify-center text-lg group-hover:bg-orange group-hover:text-white transition-all shrink-0">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-bold text-slate-900 block truncate group-hover:text-orange transition">Jobs</span>
                    <span class="text-[11px] text-slate-500 font-semibold">{{ $categoryBreakdown['jobs']['count'] ?? 0 }} Ads</span>
                </div>
            </a>

            <!-- Property -->
            <a href="{{ route('portal-admin.property.index') }}" 
               class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-emerald-500 hover:shadow-md transition-all group flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg group-hover:bg-emerald-600 group-hover:text-white transition-all shrink-0">
                    <i class="fa-solid fa-building"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-bold text-slate-900 block truncate group-hover:text-emerald-600 transition">Property</span>
                    <span class="text-[11px] text-slate-500 font-semibold">{{ $categoryBreakdown['property']['count'] ?? 0 }} Ads</span>
                </div>
            </a>

            <!-- Classifieds -->
            <a href="{{ route('portal-admin.classifieds.index') }}" 
               class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-blue-500 hover:shadow-md transition-all group flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg group-hover:bg-blue-600 group-hover:text-white transition-all shrink-0">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-bold text-slate-900 block truncate group-hover:text-blue-600 transition">Classifieds</span>
                    <span class="text-[11px] text-slate-500 font-semibold">{{ $categoryBreakdown['classifieds']['count'] ?? 0 }} Ads</span>
                </div>
            </a>

            <!-- Vehicles -->
            <a href="{{ route('portal-admin.vehicles.index') }}" 
               class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-purple-500 hover:shadow-md transition-all group flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg group-hover:bg-purple-600 group-hover:text-white transition-all shrink-0">
                    <i class="fa-solid fa-car"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-bold text-slate-900 block truncate group-hover:text-purple-600 transition">Vehicles</span>
                    <span class="text-[11px] text-slate-500 font-semibold">{{ $categoryBreakdown['vehicles']['count'] ?? 0 }} Ads</span>
                </div>
            </a>

            <!-- Matrimonial -->
            <a href="{{ route('portal-admin.matrimonial.index') }}" 
               class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:border-rose-500 hover:shadow-md transition-all group flex items-center gap-3.5 col-span-2 sm:col-span-1">
                <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg group-hover:bg-rose-600 group-hover:text-white transition-all shrink-0">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-bold text-slate-900 block truncate group-hover:text-rose-600 transition">Matrimonial</span>
                    <span class="text-[11px] text-slate-500 font-semibold">{{ $categoryBreakdown['matrimonial']['count'] ?? 0 }} Profiles</span>
                </div>
            </a>

        </div>
    </div>

    <!-- 4. ANALYTICS CHARTS SECTION (Chart.js via CDN, Responsive Canvas) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 w-full">
        
        <!-- Monthly Growth Trend (7 Cols) -->
        <div class="lg:col-span-7 bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-orange"></i>
                        <span>Monthly Listing Growth Trend</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Real creation trajectory over the last 6 months</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-[11px] font-bold text-slate-600">
                    Total: {{ number_format($totalListings) }} Ads
                </span>
            </div>
            <div class="relative w-full h-64 sm:h-72">
                <canvas id="monthlyTrendChart"></canvas>
            </div>
        </div>

        <!-- Category & Status Breakdown (5 Cols) -->
        <div class="lg:col-span-5 bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-orange"></i>
                        <span>Category Distribution</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Active inventory share across 5 verticals</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-orange-50 text-[11px] font-bold text-orange">
                    5 Verticals
                </span>
            </div>
            <div class="relative w-full h-64 sm:h-72 flex items-center justify-center">
                <canvas id="categoryDistributionChart"></canvas>
            </div>
        </div>

    </div>

    <!-- 5. FOUR ACTIVITY FEEDS & OPERATIONS (Fluid 2x2 Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 w-full">

        <!-- Feed 1: Recent Listings (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left text-orange"></i>
                            <span>Recent Listings</span>
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Fresh marketplace additions synced with storefront</p>
                    </div>
                    <a href="{{ route('portal-admin.listings.index') }}" class="text-xs font-bold text-orange hover:underline flex items-center gap-1">
                        <span>View All</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="overflow-x-auto portal-scrollbar">
                    <table class="w-full text-left text-xs text-slate-700 min-w-[500px]">
                        <thead class="bg-slate-50/70 border-b border-slate-100 text-[10px] font-black uppercase text-slate-500 tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Title / Seller</th>
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
                                        <div class="text-[10px] text-slate-400">{{ $listing->user->name ?? 'Guest User' }} · {{ $listing->created_at->diffForHumans() }}</div>
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
                                        @if($listing->listing_status === 'active' && $listing->moderation_status === 'approved')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span> Published
                                            </span>
                                        @elseif($listing->moderation_status === 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1"></span> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
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
                                        No recent listings recorded.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Feed 2: Pending Moderation & Enquiries (5 cols) -->
        <div class="lg:col-span-5 space-y-5">
            
            <!-- Pending Moderation Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 sm:p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-amber-500"></i>
                        <span>Pending Moderation</span>
                    </h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $pendingApproval > 0 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-500' }}">
                        {{ $pendingApproval }} Waiting
                    </span>
                </div>

                @if($pendingModerationItems->isNotEmpty())
                    <div class="space-y-2.5">
                        @foreach($pendingModerationItems as $item)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-slate-900 truncate">{{ $item->title }}</div>
                                    <div class="text-[10px] text-slate-400">By {{ $item->user->name ?? 'User' }} · {{ $item->category->name ?? 'Ad' }}</div>
                                </div>
                                <a href="{{ route('portal-admin.listings.edit', $item) }}" class="px-2.5 py-1 rounded-lg bg-orange text-white text-[10px] font-bold shrink-0 hover:bg-orange/90">
                                    Review
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-6 text-center text-slate-400 text-xs flex flex-col items-center">
                        <i class="fa-regular fa-circle-check text-2xl text-emerald-500 mb-1"></i>
                        <span class="font-medium text-slate-600">All caught up!</span>
                        <span class="text-[11px] text-slate-400">No ads are waiting in the moderation queue.</span>
                    </div>
                @endif
            </div>

            <!-- Recent Registrations -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 sm:p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-blue-500"></i>
                        <span>Recent Registrations</span>
                    </h3>
                    <span class="text-xs text-slate-400 font-medium">{{ $totalUsers }} Total</span>
                </div>

                <div class="space-y-2.5">
                    @forelse($recentRegistrations as $user)
                        <div class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-slate-900 truncate">{{ $user->name }}</div>
                                    <div class="text-[10px] text-slate-400 truncate">{{ $user->email }}</div>
                                </div>
                            </div>
                            <span class="text-[10px] text-slate-400 shrink-0 font-medium">
                                {{ $user->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <div class="py-4 text-center text-slate-400 text-xs">No users found.</div>
                    @endforelse
                </div>
            </div>

            <!-- Latest Enquiries -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 sm:p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-envelope-open-text text-rose-500"></i>
                        <span>Customer Enquiries</span>
                    </h3>
                    <a href="{{ route('portal-admin.enquiries.index') }}" class="text-xs font-bold text-orange hover:underline">
                        View All
                    </a>
                </div>

                @if($latestEnquiries->isNotEmpty())
                    <div class="space-y-2.5">
                        @foreach($latestEnquiries as $enquiry)
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-900 truncate">{{ $enquiry->reason ?? 'General Inquiry' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $enquiry->listing->title ?? 'Listing' }} · {{ $enquiry->created_at->diffForHumans() }}</div>
                                </div>
                                <a href="{{ route('portal-admin.enquiries.show', $enquiry) }}" class="text-orange font-bold text-xs hover:underline shrink-0">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-4 text-center text-slate-400 text-xs">
                        No pending reports or enquiries.
                    </div>
                @endif
            </div>

        </div>

    </div>

    <!-- 6. QUICK ACTIONS & PUBLIC STOREFRONT SYNC (Bottom Fluid Bar) -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-orange"></i>
                    <span>Quick Management Actions</span>
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Direct shortcuts to high-frequency publishing workflows</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('portal-admin.listings.create') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-orange hover:text-white text-xs font-bold text-slate-700 transition">
                    + Create New Listing
                </a>
                <a href="{{ route('portal-admin.jobs.create') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-orange hover:text-white text-xs font-bold text-slate-700 transition">
                    + Add Job
                </a>
                <a href="{{ route('portal-admin.property.create') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-orange hover:text-white text-xs font-bold text-slate-700 transition">
                    + Add Property
                </a>
                <a href="{{ route('portal-admin.vehicles.create') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-orange hover:text-white text-xs font-bold text-slate-700 transition">
                    + Add Vehicle
                </a>
                <a href="{{ route('portal-admin.classifieds.create') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-orange hover:text-white text-xs font-bold text-slate-700 transition">
                    + Add Classified
                </a>
                <a href="{{ route('portal-admin.listings.index', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-500 hover:text-white text-xs font-bold text-amber-800 transition">
                    View Pending ({{ $pendingApproval }})
                </a>
                <a href="http://localhost:3000" target="_blank" class="px-3 py-1.5 rounded-xl bg-navy hover:bg-navy-light text-white text-xs font-bold transition flex items-center gap-1.5">
                    <span>Preview Next.js Live</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js CDN and Alpine Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Real Data from Controller
        const monthlyLabels = {!! json_encode($monthlyTrend['labels'] ?? []) !!};
        const monthlyData = {!! json_encode($monthlyTrend['data'] ?? []) !!};
        
        const categoryLabels = {!! json_encode($categoryChartLabels ?? ['Jobs', 'Property', 'Classifieds', 'Vehicles', 'Matrimonial']) !!};
        const categoryData = {!! json_encode($categoryChartCounts ?? [0, 0, 0, 0, 0]) !!};

        // 1. Monthly Listing Growth Trend Chart
        const monthlyCtx = document.getElementById('monthlyTrendChart');
        if (monthlyCtx) {
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Listings Created',
                        data: monthlyData,
                        borderColor: '#ff5a0a',
                        backgroundColor: 'rgba(255, 90, 10, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#ff5a0a',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#031727',
                            titleFont: { family: 'Roboto', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Roboto', size: 11 },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: {
                                font: { family: 'Roboto', size: 11 },
                                precision: 0
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Roboto', size: 11 } }
                        }
                    }
                }
            });
        }

        // 2. Category Distribution Doughnut Chart
        const categoryCtx = document.getElementById('categoryDistributionChart');
        if (categoryCtx) {
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: [
                            '#ff5a0a', // Orange (Jobs)
                            '#10b981', // Emerald (Property)
                            '#3b82f6', // Blue (Classifieds)
                            '#8b5cf6', // Purple (Vehicles)
                            '#f43f5e'  // Rose (Matrimonial)
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 14,
                                font: { family: 'Roboto', size: 11, weight: '600' },
                                color: '#475569'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#031727',
                            titleFont: { family: 'Roboto', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Roboto', size: 11 },
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    cutout: '68%'
                }
            });
        }
    });

    function portalDashboard() {
        return {
            init() {}
        };
    }
</script>
@endsection
