@extends('admin.layouts.app')

@section('title', 'Immutable Audit Logs')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Audit Logs (Read-Only)</h1>
            <p class="text-sm text-slate-500 mt-1">Tamper-evident trail of administrative mutations, approvals, and credential modifications.</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase text-slate-600 tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Timestamp</th>
                        <th class="px-5 py-3">Actor</th>
                        <th class="px-5 py-3">Action</th>
                        <th class="px-5 py-3">Entity</th>
                        <th class="px-5 py-3">IP Address</th>
                        <th class="px-5 py-3">Metadata Payload</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 text-xs text-slate-500 whitespace-nowrap">
                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="px-5 py-3.5 text-xs">
                                <span class="font-medium text-slate-900">{{ $log->actor->name ?? 'System' }}</span>
                                <div class="text-slate-400 font-mono">{{ $log->actor->email ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <code class="text-xs bg-slate-100 px-2 py-0.5 rounded text-primary-900 font-bold font-mono">{{ $log->action }}</code>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">
                                {{ class_basename($log->entity_type) }} #{{ $log->entity_id }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-500">
                                {{ $log->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td class="px-5 py-3.5 text-xs">
                                <pre class="bg-slate-50 p-1.5 rounded text-[11px] font-mono text-slate-600 max-w-xs overflow-x-auto">{{ json_encode($log->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">No audit log records stored yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
