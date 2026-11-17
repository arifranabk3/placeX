@extends('admin.layouts.app')

@section('title', 'Payments & Transactions')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Payments & Transactions</h1>
            <p class="text-sm text-slate-500 mt-1">Audit transaction logs, payment gateway receipts, and promotion invoices.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <span class="text-xs text-slate-400 block font-medium">Verified Revenue</span>
                <span class="text-xl font-bold text-slate-900">PKR {{ number_format($totalRevenue) }}</span>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-600 tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Transaction ID</th>
                        <th class="px-5 py-3">User</th>
                        <th class="px-5 py-3">Method</th>
                        <th class="px-5 py-3">Amount</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $pay)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-900 font-semibold">
                                {{ $pay->transaction_id ?? 'TXN-' . $pay->id }}
                            </td>
                            <td class="px-5 py-3.5 text-xs">
                                <span class="font-medium text-slate-900">{{ $pay->user->name ?? 'User #' . $pay->user_id }}</span>
                                <div class="text-slate-400">{{ $pay->user->email ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3.5 text-xs capitalize text-slate-700">{{ $pay->payment_method ?? 'Manual' }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                {{ $pay->currency }} {{ number_format($pay->amount, 2) }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                    @if($pay->status === 'completed') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($pay->status === 'pending') bg-amber-50 text-amber-700 border border-amber-200
                                    @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                                    {{ ucfirst($pay->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $pay->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-5 py-3.5 text-right">
                                @if($pay->status === 'pending')
                                    <form method="POST" action="{{ route('admin.payments.update-status', $pay) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="px-2.5 py-1 bg-emerald-600 text-white text-xs font-semibold rounded hover:bg-emerald-700 transition">
                                            Mark Paid
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">Locked</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-500">No transactions or payments recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
