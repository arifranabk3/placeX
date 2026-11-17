@extends('admin.layouts.app')

@section('title', 'Reports & Grievances')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Reports & Complaints</h1>
            <p class="text-sm text-slate-500 mt-1">Investigate user reports on fraudulent ads, inappropriate content, or scams.</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-600 tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Reported Listing</th>
                        <th class="px-5 py-3">Report Reason</th>
                        <th class="px-5 py-3">Reported By</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Reported At</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reports as $rep)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.listings.show', $rep->listing) }}" class="font-medium text-slate-900 hover:text-primary-600 block line-clamp-1">
                                    {{ $rep->listing->title ?? 'Deleted Ad' }}
                                </a>
                                <span class="text-xs text-slate-400">ID: #{{ $rep->listing_id }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-semibold text-rose-700 text-xs uppercase">{{ $rep->reason }}</span>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $rep->details ?? 'No details provided' }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-xs">
                                <span class="font-medium text-slate-900">{{ $rep->user->name ?? 'Guest User' }}</span>
                                <div class="text-slate-400">{{ $rep->user->email ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                    @if($rep->status === 'pending') bg-amber-50 text-amber-700 border border-amber-200
                                    @elseif($rep->status === 'resolved') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($rep->status === 'dismissed') bg-slate-100 text-slate-600 border border-slate-200
                                    @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                                    {{ ucfirst($rep->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $rep->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('admin.reports.show', $rep) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                                    Inspect &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">No reported listings or safety complaints recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
