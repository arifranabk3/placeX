@extends('admin.layouts.app')

@section('title', 'Roles & RBAC Matrix')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Roles & Permissions Management</h1>
            <p class="text-sm text-slate-500 mt-1">Granular Role-Based Access Control matrix for Super Admins, Staff, and Customer tiers.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @foreach($roles as $role)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center space-x-3">
                        <span class="font-bold text-base text-slate-900">{{ $role->name }}</span>
                        <code class="text-xs bg-slate-100 px-2 py-0.5 rounded text-slate-600 font-mono">{{ $role->slug }}</code>
                        <span class="text-xs text-slate-400">({{ $role->users->count() }} active accounts)</span>
                    </div>
                    @if($role->slug === 'super-admin')
                        <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-purple-100 text-purple-800">
                            Wildcard Full Access
                        </span>
                    @endif
                </div>

                @if($role->slug === 'super-admin')
                    <p class="text-xs text-slate-500 py-2">
                        Super Administrators automatically bypass all permission checks with unconditional access across all controllers, database models, and operational systems.
                    </p>
                @else
                    <form method="POST" action="{{ route('admin.roles.update-permissions', $role) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($permissions as $group => $perms)
                                <div class="p-3 bg-slate-50/70 rounded-lg border border-slate-100 space-y-2">
                                    <div class="text-xs font-bold uppercase tracking-wider text-slate-700">{{ ucfirst($group) }}</div>
                                    <div class="space-y-1.5">
                                        @foreach($perms as $p)
                                            <label class="flex items-start space-x-2 text-xs text-slate-700 cursor-pointer">
                                                <input type="checkbox" name="permissions[]" value="{{ $p->id }}" 
                                                       {{ $role->permissions->contains('id', $p->id) ? 'checked' : '' }}
                                                       class="rounded text-primary-900 focus:ring-primary-500 mt-0.5">
                                                <span>{{ $p->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-4 py-2 bg-primary-900 text-white text-xs font-semibold rounded-lg hover:bg-primary-800 transition">
                                Update {{ $role->name }} Permissions
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
