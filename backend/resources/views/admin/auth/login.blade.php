@extends('admin.layouts.auth', ['title' => 'Administrative Sign In'])

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-white tracking-tight">Administrative Sign In</h1>
    <p class="text-xs text-slate-400 mt-1">Authenticate with your PlaceX staff credentials to proceed.</p>
</div>

<form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4.5" x-data="{ showPass: false }">
    @csrf

    <!-- Email Field -->
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
                value="{{ old('email', 'admin@placex.test') }}" 
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

    <!-- Password Field -->
    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                Password
            </label>
            <a href="{{ route('admin.password.request') }}" class="text-xs text-orange-400 hover:text-orange-300 font-medium transition-colors">
                Forgot password?
            </a>
        </div>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500 text-sm">
                <i class="fa-solid fa-lock"></i>
            </span>
            <input 
                id="password" 
                :type="showPass ? 'text' : 'password'" 
                name="password" 
                required 
                placeholder="••••••••••••"
                value="AdminPlaceX2026!"
                class="w-full bg-slate-900/80 border @error('password') border-red-500 @else border-slate-700 @enderror rounded-xl pl-10 pr-10 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
            >
            <button 
                type="button" 
                @click="showPass = !showPass" 
                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500 hover:text-slate-300 transition-colors"
                tabindex="-1"
            >
                <i :class="showPass ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'"></i>
            </button>
        </div>
        @error('password')
            <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Remember Session -->
    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center gap-2 cursor-pointer select-none">
            <input 
                type="checkbox" 
                name="remember" 
                value="1" 
                class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-900"
            >
            <span class="text-xs text-slate-400 font-medium">Keep administrative session active</span>
        </label>
    </div>

    <!-- Submit Button -->
    <button 
        type="submit" 
        class="w-full mt-2 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-orange-500/35 active:scale-[0.99] transition-all flex items-center justify-center gap-2 text-sm tracking-wide"
    >
        <i class="fa-solid fa-shield-halved"></i>
        <span>Sign In to Admin Console</span>
    </button>
</form>

<div class="mt-6 pt-5 border-t border-slate-800 text-center text-xs text-slate-400">
    <p>Default credentials for testing:</p>
    <div class="mt-2 p-2.5 bg-slate-950/60 rounded-lg text-left font-mono text-[11px] text-slate-300 space-y-1">
        <div><span class="text-slate-500">Super Admin:</span> admin@placex.test / AdminPlaceX2026!</div>
        <div><span class="text-slate-500">Moderator:</span> moderator@placex.test / ModPlaceX2026!</div>
        <div><span class="text-slate-500">Support:</span> support@placex.test / SupportPlaceX2026!</div>
    </div>
</div>
@endsection
