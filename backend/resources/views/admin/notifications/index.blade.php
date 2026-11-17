@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Notifications</h1>
            <p class="text-sm text-slate-500 mt-1">Admin alerts, suspicious listings, and operational updates.</p>
        </div>
        <form method="POST" action="{{ route('admin.notifications.mark-read') }}">
            @csrf
            <button type="submit" class="px-4 py-2 border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition">
                Mark All as Read
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 divide-y divide-slate-100 overflow-hidden">
        @forelse($notifications as $notif)
            <div class="p-4 flex items-start space-x-3 {{ $notif->read_at ? 'bg-white' : 'bg-primary-50/20' }}">
                <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="flex-1 text-sm">
                    <div class="font-medium text-slate-900">{{ $notif->data['title'] ?? 'System Alert' }}</div>
                    <div class="text-xs text-slate-600 mt-0.5">{{ $notif->data['message'] ?? 'Notification details' }}</div>
                    <div class="text-xs text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <div class="text-sm font-semibold text-slate-600">No Notifications</div>
                <p class="text-xs text-slate-400 mt-0.5">Your inbox is clear.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
