@extends('admin.layouts.auth', ['title' => 'Reset Password'])

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-white tracking-tight">Set New Password</h1>
    <p class="text-xs text-slate-400 mt-1">Choose a strong, secure password for your administrative account.</p>
</div>

<form method="POST" action="{{ route('admin.password.update') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Admin Email
        </label>
        <input 
            id="email" 
            type="email" 
            name="email" 
            value="{{ old('email', $email) }}" 
            required 
            class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-orange-500"
        >
        @error('email')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            New Password
        </label>
        <input 
            id="password" 
            type="password" 
            name="password" 
            required 
            class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-orange-500"
            placeholder="At least 8 characters"
        >
        @error('password')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Confirm Password
        </label>
        <input 
            id="password_confirmation" 
            type="password" 
            name="password_confirmation" 
            required 
            class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-orange-500"
            placeholder="Repeat new password"
        >
    </div>

    <button 
        type="submit" 
        class="w-full mt-2 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-orange-500/25 transition-all flex items-center justify-center gap-2 text-sm"
    >
        <i class="fa-solid fa-key"></i>
        <span>Reset Password and Sign In</span>
    </button>
</form>
@endsection
