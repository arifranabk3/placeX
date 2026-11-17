@extends('admin.layouts.auth', ['title' => 'Password Recovery'])

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-white tracking-tight">Recover Admin Password</h1>
    <p class="text-xs text-slate-400 mt-1">Enter your registered staff email address to receive password reset instructions.</p>
</div>

<form method="POST" action="{{ route('admin.password.email') }}" class="space-y-4.5">
    @csrf

    <div>
        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Admin Email Address
        </label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500 text-sm">
                <i class="fa-solid fa-envelope"></i>
            </span>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                placeholder="admin@placex.test"
                class="w-full bg-slate-900/80 border @error('email') border-red-500 @else border-slate-700 @enderror rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
            >
        </div>
        @error('email')
            <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <button 
        type="submit" 
        class="w-full mt-2 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-orange-500/25 transition-all flex items-center justify-center gap-2 text-sm"
    >
        <i class="fa-solid fa-paper-plane"></i>
        <span>Send Reset Link</span>
    </button>
</form>

<div class="mt-6 pt-5 border-t border-slate-800 text-center">
    <a href="{{ route('admin.login') }}" class="text-xs text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to sign in</span>
    </a>
</div>
@endsection
