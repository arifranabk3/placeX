@extends('portal-admin.layouts.app', ['title' => 'Enquiry #' . $enquiry->id])

@section('content')
<div class="space-y-6 w-full">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Enquiry Case #{{ $enquiry->id }}</h1>
            <p class="text-xs text-slate-500 mt-1">Submitted on {{ $enquiry->created_at->format('M d, Y H:i') }}</p>
        </div>
        <a href="{{ route('portal-admin.enquiries.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
            Back
        </a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-5">
        <div>
            <span class="text-xs font-bold uppercase text-slate-500 block">Report Reason</span>
            <span class="text-base font-black text-rose-600 uppercase">{{ $enquiry->reason }}</span>
        </div>

        <div>
            <span class="text-xs font-bold uppercase text-slate-500 block">Narrative / Complainant Message</span>
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 leading-relaxed mt-1">
                {{ $enquiry->details ?? 'No details provided.' }}
            </div>
        </div>

        <form method="POST" action="{{ route('portal-admin.enquiries.update', $enquiry) }}" class="space-y-4 pt-4 border-t border-slate-100">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Update Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="pending" {{ $enquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="investigating" {{ $enquiry->status === 'investigating' ? 'selected' : '' }}>Investigating</option>
                    <option value="resolved" {{ $enquiry->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="dismissed" {{ $enquiry->status === 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Resolution Outcome / Action Notes</label>
                <textarea name="action_taken" rows="3" placeholder="Enter findings, user warning, or resolution notes..."
                          class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 leading-relaxed">{{ old('action_taken', $enquiry->action_taken) }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                    Update Case
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
