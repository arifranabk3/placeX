@extends('admin.layouts.app', ['title' => 'Dashboard Overview'])

@section('breadcrumbs')
    <span class="text-slate-600">/</span>
    <span class="text-slate-200 font-semibold">Dashboard</span>
@endsection

@section('content')
<div class="space-y-6 pt-2">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">PlaceX Operations Center</h1>
            <p class="text-xs text-slate-400 mt-1">Live enterprise metrics, queue workloads and system telemetry.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-navy-800 border border-slate-700/80 text-xs font-semibold text-slate-300">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>System Online · {{ now()->format('M d, Y') }}</span>
            </span>
        </div>
    </div>

    <!-- 8 CORE KPIS CARDS (Actual DB Records) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- 1. Total Users -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Total Users</span>
                <div class="w-8 h-8 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-white">{{ number_format($kpis['total_users']) }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] text-emerald-400 font-medium">
                <i class="fa-solid fa-check"></i>
                <span>Registered accounts</span>
            </div>
        </div>

        <!-- 2. Active Users -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Active Users</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-white">{{ number_format($kpis['active_users']) }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] text-slate-400">
                <span>Healthy standing</span>
            </div>
        </div>

        <!-- 3. Total Sellers -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Total Sellers</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-store"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-white">{{ number_format($kpis['total_sellers']) }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] text-indigo-400">
                <span>Merchant profiles</span>
            </div>
        </div>

        <!-- 4. Total Listings -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Total Ads</span>
                <div class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-white">{{ number_format($kpis['total_listings']) }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] text-slate-400">
                <span>Across 5 categories</span>
            </div>
        </div>

        <!-- 5. Pending Moderation -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all {{ $kpis['pending_moderation'] > 0 ? 'ring-1 ring-amber-500/30' : '' }}">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Pending Review</span>
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
            <div class="text-2xl font-black {{ $kpis['pending_moderation'] > 0 ? 'text-amber-400' : 'text-white' }}">
                {{ number_format($kpis['pending_moderation']) }}
            </div>
            <div class="mt-1 flex items-center gap-1 text-[11px] {{ $kpis['pending_moderation'] > 0 ? 'text-amber-400 font-semibold' : 'text-slate-400' }}">
                <span>Queue workload</span>
            </div>
        </div>

        <!-- 6. Published Active -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Published Ads</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-white">{{ number_format($kpis['published_listings']) }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] text-emerald-400">
                <span>Live in marketplace</span>
            </div>
        </div>

        <!-- 7. Reported Listings -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all {{ $kpis['reported_listings'] > 0 ? 'ring-1 ring-red-500/30' : '' }}">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Flagged Reports</span>
                <div class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <div class="text-2xl font-black {{ $kpis['reported_listings'] > 0 ? 'text-red-400' : 'text-white' }}">
                {{ number_format($kpis['reported_listings']) }}
            </div>
            <div class="mt-1 flex items-center gap-1 text-[11px] {{ $kpis['reported_listings'] > 0 ? 'text-red-400 font-semibold' : 'text-slate-400' }}">
                <span>Unresolved flags</span>
            </div>
        </div>

        <!-- 8. Featured / Promoted -->
        <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-4.5 shadow-lg relative overflow-hidden group hover:border-slate-700 transition-all">
            <div class="flex items-center justify-between text-slate-400 mb-2">
                <span class="text-xs font-bold uppercase tracking-wider">Promoted Ads</span>
                <div class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-bolt"></i>
                </div>
            </div>
            <div class="text-2xl font-black text-white">{{ number_format($kpis['featured_listings']) }}</div>
            <div class="mt-1 flex items-center gap-1 text-[11px] text-orange-400 font-medium">
                <span>Active monetization</span>
            </div>
        </div>
    </div>

    <!-- CATEGORY DISTRIBUTION STRIP -->
    <div class="bg-navy-900/80 border border-slate-800 rounded-2xl p-5 shadow-lg">
        <div class="flex items-center justify-between mb-3.5">
            <h2 class="text-sm font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-chart-simple text-orange-500"></i>
                <span>Marketplace Inventory by Category</span>
            </h2>
            <a href="{{ route('admin.categories.index') }}" class="text-xs text-orange-400 hover:text-orange-300 font-semibold">Manage Categories →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach($categoryDistribution as $cat)
            <div class="bg-navy-950/60 border border-slate-800/80 rounded-xl p-3 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-navy-800 text-orange-400 flex items-center justify-center text-sm">
                        <i class="fa-solid {{ $cat->icon ?? 'fa-folder' }}"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white leading-tight">{{ $cat->name }}</p>
                        <p class="text-[10px] text-slate-400">{{ $cat->slug }}</p>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-200 text-xs font-bold font-mono">
                    {{ $cat->listings_count }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- MAIN TWO-COLUMN SPLIT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT 2 COLUMNS: Recent Listings & Pending Queue -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Recent Listings Table -->
            <div class="bg-navy-900/80 border border-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-4 border-b border-slate-800 flex items-center justify-between bg-navy-950/40">
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-orange-500"></i>
                        <span>Recent Marketplace Listings</span>
                    </h2>
                    <a href="{{ route('admin.listings.index') }}" class="text-xs text-orange-400 hover:text-orange-300 font-semibold">View all ads →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-800 text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-navy-950/60">
                                <th class="py-3 px-4">Title & Details</th>
                                <th class="py-3 px-4">Category</th>
                                <th class="py-3 px-4">Seller</th>
                                <th class="py-3 px-4">Price</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($recentListings as $listing)
                            <tr class="hover:bg-navy-800/40 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-white max-w-xs truncate">{{ $listing->title }}</div>
                                    <div class="text-[11px] text-slate-400 flex items-center gap-1.5 mt-0.5">
                                        <i class="fa-solid fa-location-dot text-[9px] text-orange-400"></i>
                                        <span>{{ $listing->location->city ?? 'Pakistan' }}</span>
                                        <span>·</span>
                                        <span>{{ $listing->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-navy-800 border border-slate-700 text-slate-300 text-[11px] font-medium">
                                        <i class="fa-solid {{ $listing->category->icon ?? 'fa-folder' }} text-[9px] text-orange-400"></i>
                                        <span>{{ $listing->category->name }}</span>
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-300 font-medium">
                                    {{ $listing->user->name ?? 'Deleted User' }}
                                </td>
                                <td class="py-3 px-4 font-bold text-emerald-400 font-mono">
                                    {{ $listing->price ? 'PKR ' . number_format($listing->price) : 'N/A' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($listing->listing_status === 'active' && $listing->moderation_status === 'approved')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
                                    @elseif($listing->moderation_status === 'pending_review')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending Review</span>
                                    @elseif($listing->moderation_status === 'rejected')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">Rejected</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-500/10 text-slate-400 border border-slate-500/20">{{ ucfirst($listing->listing_status) }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.listings.show', $listing->id) }}" class="p-1.5 rounded-lg bg-navy-800 hover:bg-orange-500 text-slate-300 hover:text-white transition-colors" title="View details">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500">
                                    <i class="fa-solid fa-inbox text-2xl mb-1 block"></i>
                                    No listings found in database.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pending Moderation Queue Card -->
            <div class="bg-navy-900/80 border border-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-4 border-b border-slate-800 flex items-center justify-between bg-navy-950/40">
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-amber-400"></i>
                        <span>Pending Moderation Queue</span>
                    </h2>
                    <a href="{{ route('admin.moderation.index') }}" class="text-xs text-orange-400 hover:text-orange-300 font-semibold">Open queue →</a>
                </div>

                <div class="divide-y divide-slate-800/80">
                    @forelse($pendingModeration as $pending)
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 hover:bg-navy-800/30 transition-colors">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">Needs Review</span>
                                <h3 class="text-xs font-bold text-white">{{ $pending->title }}</h3>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 line-clamp-1">{{ $pending->description }}</p>
                            <div class="text-[10px] text-slate-500 mt-1 flex items-center gap-2">
                                <span>Author: <b>{{ $pending->user->name ?? 'User' }}</b></span>
                                <span>·</span>
                                <span>Submitted: {{ $pending->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <form method="POST" action="{{ route('admin.moderation.verdict', $pending->id) }}">
                                @csrf
                                <input type="hidden" name="verdict" value="approved">
                                <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-white border border-emerald-500/30 text-xs font-bold transition-all">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                            </form>
                            <a href="{{ route('admin.listings.show', $pending->id) }}" class="px-2.5 py-1.5 rounded-lg bg-navy-800 hover:bg-navy-700 text-slate-300 border border-slate-700 text-xs font-bold transition-colors">
                                Inspect
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-slate-500">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-2xl mb-1 block"></i>
                        No pending listings in moderation queue.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (1/3): Reports, Users & Audit Trail -->
        <div class="space-y-6">

            <!-- Latest Reports & Flags -->
            <div class="bg-navy-900/80 border border-slate-800 rounded-2xl shadow-lg p-4.5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-3">
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-red-400"></i>
                        <span>Recent User Reports</span>
                    </h2>
                    <a href="{{ route('admin.reports.index') }}" class="text-xs text-orange-400 hover:underline">All →</a>
                </div>

                <div class="space-y-3">
                    @forelse($latestReports as $rep)
                    <div class="p-3 bg-navy-950/60 border border-slate-800/80 rounded-xl space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-red-400">{{ $rep->reason }}</span>
                            <span class="text-[10px] text-slate-500">{{ $rep->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-[11px] text-slate-300 line-clamp-1">Listing: {{ $rep->listing->title ?? 'Deleted' }}</p>
                        <p class="text-[10px] text-slate-400">By: {{ $rep->reporter->name ?? 'Anonymous' }}</p>
                    </div>
                    @empty
                    <p class="text-center py-4 text-xs text-slate-500">No active complaints or user reports.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Registrations -->
            <div class="bg-navy-900/80 border border-slate-800 rounded-2xl shadow-lg p-4.5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-3">
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-sky-400"></i>
                        <span>Recent Registrations</span>
                    </h2>
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-orange-400 hover:underline">All →</a>
                </div>

                <div class="space-y-2.5">
                    @forelse($recentUsers as $u)
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-800/50 last:border-0">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-full bg-navy-800 text-orange-400 font-bold text-[11px] flex items-center justify-center shrink-0 border border-slate-700">
                                {{ $u->initials }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-white truncate">{{ $u->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ $u->email }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-300 shrink-0">
                            {{ $u->roles->first()->name ?? 'User' }}
                        </span>
                    </div>
                    @empty
                    <p class="text-center py-3 text-xs text-slate-500">No users found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Audit Trail Activities -->
            <div class="bg-navy-900/80 border border-slate-800 rounded-2xl shadow-lg p-4.5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-3">
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                        <span>Recent Staff Actions</span>
                    </h2>
                    <a href="{{ route('admin.audit-logs.index') }}" class="text-xs text-orange-400 hover:underline">Full Log →</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentActivities as $act)
                    <div class="text-[11px] space-y-0.5">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-200">{{ $act->user->name ?? 'System' }}</span>
                            <span class="text-[10px] text-slate-500">{{ $act->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-orange-400 font-mono text-[10px]">{{ $act->action }}</div>
                        <div class="text-[10px] text-slate-400">Target: {{ $act->entity_type }} #{{ $act->entity_id }}</div>
                    </div>
                    @empty
                    <p class="text-center py-3 text-xs text-slate-500">No recent audit log entries.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
