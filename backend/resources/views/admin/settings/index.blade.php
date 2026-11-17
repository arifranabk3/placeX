@extends('admin.layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">PlaceX System Settings</h1>
            <p class="text-sm text-slate-500 mt-1">Configure marketplace parameters, moderation thresholds, and platform contact info.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        @foreach($settings as $group => $groupSettings)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                    {{ ucfirst($group) }} Configuration
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($groupSettings as $st)
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                {{ ucwords(str_replace('_', ' ', explode('.', $st->key)[1] ?? $st->key)) }}
                            </label>
                            @if($st->type === 'boolean')
                                <select name="{{ $st->key }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <option value="1" {{ $st->value ? 'selected' : '' }}>Enabled (True)</option>
                                    <option value="0" {{ !$st->value ? 'selected' : '' }}>Disabled (False)</option>
                                </select>
                            @else
                                <input type="text" name="{{ $st->key }}" value="{{ $st->value }}"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @endif
                            <span class="text-[11px] text-slate-400 mt-0.5 block font-mono">{{ $st->key }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-6 py-2.5 bg-primary-900 text-white text-sm font-semibold rounded-lg hover:bg-primary-800 transition">
                Save System Settings
            </button>
        </div>
    </form>
</div>
@endsection
