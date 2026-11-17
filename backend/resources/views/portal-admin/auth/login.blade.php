<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Staff Sign In — PlaceX</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Roboto', 'Arial', 'sans-serif'] },
                    colors: {
                        navy: { DEFAULT: '#061b2d', dark: '#031727' },
                        orange: { DEFAULT: '#ff5a0a', hover: '#e04c04' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#f4f7fb] min-h-screen flex flex-col justify-between antialiased">

    <!-- Top Simple Header matching PlaceX Brand -->
    <header class="bg-[#031727] py-3.5 px-6 border-b border-white/10">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="/" class="flex flex-col leading-none">
                <span class="text-2xl font-black tracking-tight text-white">
                    Place<span class="text-[#ff5a0a]">X</span>
                </span>
                <small class="text-[8px] font-extrabold tracking-widest text-slate-300 uppercase mt-0.5">
                    JOBS · PROPERTY · CLASSIFIEDS
                </small>
            </a>
            <a href="http://localhost:3000" class="text-xs text-slate-300 hover:text-white flex items-center space-x-1">
                <span>Public Website</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </div>
    </header>

    <!-- Sign In Card -->
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-200 p-8 space-y-6">
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#fff3e8] text-[#ff5a0a] text-xl mb-1">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Portal CMS Sign In</h1>
                <p class="text-xs text-slate-500">Log in to manage marketplace listings, homepage banners, and SEO.</p>
            </div>

            @if(session('warning'))
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs font-semibold text-amber-800">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('info'))
                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg text-xs font-semibold text-blue-800">
                    {{ session('info') }}
                </div>
            @endif

            <form method="POST" action="{{ route('portal-admin.login.submit') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Staff Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email', 'portal@placex.test') }}" required autofocus
                               placeholder="portal@placex.test"
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#ff5a0a] focus:bg-white text-slate-900 font-medium transition">
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" name="password" required
                               placeholder="••••••••••••"
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#ff5a0a] focus:bg-white text-slate-900 font-medium transition">
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-[#ff5a0a] focus:ring-[#ff5a0a]">
                        <span>Remember session</span>
                    </label>
                    <span class="text-slate-400">PlaceX Staff Only</span>
                </div>

                <button type="submit" class="w-full py-3 bg-[#ff5a0a] hover:bg-[#e04c04] text-white font-bold text-sm rounded-xl transition shadow-md shadow-orange-500/20">
                    Sign In to Portal Admin
                </button>
            </form>

            <div class="border-t border-slate-100 pt-4 text-center">
                <p class="text-[11px] text-slate-400">
                    Are you a platform system administrator? 
                    <a href="{{ route('admin.login') }}" class="font-bold text-[#061b2d] hover:underline">
                        Super Admin Panel &rarr;
                    </a>
                </p>
            </div>
        </div>
    </main>

    <footer class="py-4 text-center text-xs text-slate-400 border-t border-slate-200">
        &copy; {{ date('Y') }} PlaceX Portal CMS. All rights reserved.
    </footer>

</body>
</html>
