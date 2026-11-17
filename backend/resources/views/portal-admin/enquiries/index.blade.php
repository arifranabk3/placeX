@extends('portal-admin.layouts.app', ['title' => 'Enquiries & Complaints'])

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Marketplace Enquiries &amp; Reports</h1>
            <p class="text-xs text-slate-500 mt-1">Review feedback, contact submissions, and report flags on live marketplace ads.</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-placex-line overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 uppercase font-black text-slate-600 text-[10px] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Report / Issue</th>
                        <th class="px-5 py-3.5">Target Ad</th>
                        <th class="px-5 py-3.5">Complainant</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Date</th>
                        <th class="px-5 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($enquiries as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-rose-600 uppercase text-[11px] block">{{ $item->reason }}</span>
                                <span class="text-[10px] text-slate-500 line-clamp-1">{{ $item->details ?? 'No additional narrative' }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('portal-admin.listings.edit', $item->listing_id) }}" class="font-semibold text-slate-900 hover:text-orange">
                                    {{ $item->listing->title ?? 'Listing #' . $item->listing_id }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                <div>{{ $item->user->name ?? 'Guest User' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $item->user->email ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold 
                                    @if($item->status === 'resolved') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($item->status === 'pending') bg-amber-50 text-amber-700 border border-amber-200
                                    @else bg-slate-100 text-slate-600 @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-400 text-[10px]">
                                {{ $item->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('portal-admin.enquiries.show', $item) }}" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded font-bold transition">
                                    Resolve &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">No active reports or inquiries.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($enquiries->hasPages())
            <div class="px-5 py-4 border-t border-placex-line">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
