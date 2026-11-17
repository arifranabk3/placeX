@extends('admin.layouts.app')

@section('title', 'Moderation Queue')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Moderation Queue</h1>
            <p class="text-sm text-slate-500 mt-1">Review flagged and pending submissions to ensure safety, policy compliance, and quality.</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex border-b border-slate-200 space-x-6 text-sm font-semibold">
        <a href="{{ route('admin.moderation.index', ['status' => 'pending']) }}" 
           class="pb-3 border-b-2 flex items-center space-x-2 {{ $status === 'pending' ? 'border-primary-600 text-primary-900' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <span>Pending Review</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-amber-100 text-amber-800">{{ $pendingCount }}</span>
        </a>
        <a href="{{ route('admin.moderation.index', ['status' => 'approved']) }}" 
           class="pb-3 border-b-2 flex items-center space-x-2 {{ $status === 'approved' ? 'border-primary-600 text-primary-900' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <span>Approved</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">{{ $approvedCount }}</span>
        </a>
        <a href="{{ route('admin.moderation.index', ['status' => 'rejected']) }}" 
           class="pb-3 border-b-2 flex items-center space-x-2 {{ $status === 'rejected' ? 'border-primary-600 text-primary-900' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <span>Rejected</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-rose-100 text-rose-800">{{ $rejectedCount }}</span>
        </a>
    </div>

    <!-- Listings Review Cards -->
    <div class="space-y-4">
        @forelse($listings as $ad)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="space-y-2 max-w-2xl">
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded">
                            {{ $ad->category->name ?? 'Category' }}
                        </span>
                        <span class="text-xs text-slate-400">· Submitted {{ $ad->created_at->diffForHumans() }} by {{ $ad->user->name ?? 'User' }}</span>
                    </div>
                    <a href="{{ route('admin.listings.show', $ad) }}" class="text-base font-bold text-slate-900 hover:text-primary-600 block">
                        {{ $ad->title }}
                    </a>
                    <p class="text-xs text-slate-500 line-clamp-2">
                        {{ $ad->description }}
                    </p>
                    <div class="text-xs font-bold text-slate-900">
                        {{ $ad->currency }} {{ number_format($ad->price) }} · {{ $ad->location->name ?? 'Pakistan' }}
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-end sm:items-center gap-2">
                    <a href="{{ route('admin.listings.show', $ad) }}" class="px-3 py-2 border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition">
                        Full Preview
                    </a>
                    <form method="POST" action="{{ route('admin.moderation.process', $ad) }}" class="inline-flex space-x-1">
                        @csrf
                        <input type="hidden" name="notes" value="Approved via fast moderation queue">
                        <button type="submit" name="action" value="approve" class="px-3 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-lg hover:bg-emerald-700 transition">
                            Approve
                        </button>
                        <button type="submit" name="action" value="reject" class="px-3 py-2 bg-rose-600 text-white text-xs font-semibold rounded-lg hover:bg-rose-700 transition">
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 text-center rounded-xl border border-slate-200 text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="font-semibold text-slate-700">Queue is Clear</div>
                <p class="text-xs text-slate-400 mt-1">No listings currently in {{ $status }} state.</p>
            </div>
        @endforelse
    </div>

    @if($listings->hasPages())
        <div class="bg-white px-5 py-4 rounded-xl border border-slate-200">
            {{ $listings->links() }}
        </div>
    @endif
</div>
@endsection
