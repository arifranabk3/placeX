@extends('admin.layouts.app')

@section('title', 'Report Case #' . $report->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Report Case #{{ $report->id }}</h1>
            <p class="text-sm text-slate-500 mt-1">Status: <span class="font-bold text-slate-800 uppercase">{{ $report->status }}</span> · Submitted {{ $report->created_at->format('M d, Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
            Back to Reports
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-3">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Complaint Details</h3>
                <div>
                    <span class="text-xs text-slate-500 block">Report Reason</span>
                    <span class="font-bold text-rose-700 uppercase text-sm">{{ $report->reason }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Complainant Remarks</span>
                    <div class="p-3 bg-slate-50 rounded-lg text-sm text-slate-700 mt-1">
                        {{ $report->details ?? 'No additional narrative provided.' }}
                    </div>
                </div>
            </div>

            <!-- Resolution Form -->
            <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
                @csrf
                @method('PATCH')
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Resolve or Update Complaint</h3>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Update Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="investigating" {{ $report->status === 'investigating' ? 'selected' : '' }}>Investigating</option>
                        <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved (Action Taken)</option>
                        <option value="dismissed" {{ $report->status === 'dismissed' ? 'selected' : '' }}>Dismissed (False Report)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Resolution Notes</label>
                    <textarea name="action_taken" rows="4" placeholder="Detail the outcome, user warnings issued, or listing bans..." class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('action_taken', $report->action_taken) }}</textarea>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-5 py-2 bg-primary-900 text-white text-sm font-semibold rounded-lg hover:bg-primary-800 transition">
                        Update Case
                    </button>
                </div>
            </form>
        </div>

        <!-- Accused Listing Card -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Accused Listing</h3>
            @if($report->listing)
                <div class="text-sm">
                    <a href="{{ route('admin.listings.show', $report->listing) }}" class="font-bold text-slate-900 hover:text-primary-600 block">
                        {{ $report->listing->title }}
                    </a>
                    <span class="text-xs text-slate-500">{{ $report->listing->currency }} {{ number_format($report->listing->price) }}</span>
                </div>
                <div class="pt-2 text-xs text-slate-500 border-t border-slate-100">
                    <div>Owner: <span class="font-medium text-slate-800">{{ $report->listing->user->name ?? 'Unknown' }}</span></div>
                    <div>Status: <span class="font-medium text-slate-800">{{ $report->listing->listing_status }}</span></div>
                </div>
                <div class="pt-2">
                    <a href="{{ route('admin.listings.show', $report->listing) }}" class="block text-center py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-200">
                        View Listing Page &rarr;
                    </a>
                </div>
            @else
                <p class="text-xs text-slate-400">Listing has already been permanently deleted.</p>
            @endif
        </div>
    </div>
</div>
@endsection
