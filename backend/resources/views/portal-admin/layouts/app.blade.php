<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Portal Management' }} — PlaceX</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Tailwind CSS (CDN for instant styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'Arial', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            DEFAULT: '#061b2d',
                            dark: '#031727',
                            light: '#09243a',
                            surface: '#0d2b45',
                        },
                        orange: {
                            DEFAULT: '#ff5a0a',
                            hover: '#e04c04',
                            light: '#fff3e8',
                        },
                        placex: {
                            bg: '#f4f7fb',
                            line: '#dce5ee',
                            text: '#101b28',
                            muted: '#607080',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        :root {
            --navy: #061b2d;
            --orange: #ff5a0a;
            --bg: #f4f7fb;
            --text: #101b28;
            --line: #dce5ee;
        }
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            font-size: 14px;
        }
        .brand-x { color: var(--orange); }
        .btn-portal-primary {
            background-color: var(--orange);
            color: #ffffff;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-portal-primary:hover {
            background-color: #e04c04;
        }
        .btn-portal-navy {
            background-color: var(--navy);
            color: #ffffff;
            font-weight: 700;
        }
        .btn-portal-navy:hover {
            background-color: #09243a;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- PlaceX Matching Header -->
    <header class="bg-[#031727] text-white border-b border-white/10 sticky top-0 z-50 shadow-md">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 h-[56px] flex items-center justify-between gap-4">
            <!-- Brand -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('portal-admin.dashboard') }}" class="flex flex-col leading-none select-none">
                    <span class="text-2xl font-black tracking-tight text-white">
                        Place<span class="brand-x">X</span>
                    </span>
                    <small class="text-[8px] font-extrabold tracking-widest text-slate-300 uppercase mt-0.5">
                        Portal Admin CMS
                    </small>
                </a>

                <!-- Portal Primary Nav (Tabs) -->
                <nav class="hidden lg:flex items-center space-x-1 h-[56px]">
                    <a href="{{ route('portal-admin.dashboard') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.dashboard') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-gauge mr-1.5 text-xs"></i> Dashboard
                    </a>
                    <a href="{{ route('portal-admin.listings.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.listings.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-layer-group mr-1.5 text-xs"></i> All Listings
                    </a>
                    <a href="{{ route('portal-admin.jobs.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.jobs.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-briefcase mr-1.5 text-xs"></i> Jobs
                    </a>
                    <a href="{{ route('portal-admin.property.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.property.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-building mr-1.5 text-xs"></i> Property
                    </a>
                    <a href="{{ route('portal-admin.classifieds.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.classifieds.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-boxes-stacked mr-1.5 text-xs"></i> Classifieds
                    </a>
                    <a href="{{ route('portal-admin.vehicles.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.vehicles.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-car mr-1.5 text-xs"></i> Vehicles
                    </a>
                    <a href="{{ route('portal-admin.matrimonial.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.matrimonial.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-heart mr-1.5 text-xs"></i> Matrimonial
                    </a>
                    <a href="{{ route('portal-admin.homepage.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.homepage.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-house-laptop mr-1.5 text-xs"></i> Home CMS
                    </a>
                    <a href="{{ route('portal-admin.media.index') }}" 
                       class="px-3.5 h-full flex items-center text-xs font-bold transition border-b-2 {{ request()->routeIs('portal-admin.media.*') ? 'border-orange text-orange' : 'border-transparent text-slate-200 hover:text-orange' }}">
                        <i class="fa-solid fa-images mr-1.5 text-xs"></i> Media
                    </a>
                </nav>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center space-x-3">
                <!-- Public Next.js site preview link -->
                <a href="http://localhost:3000" target="_blank" 
                   class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium text-slate-200 transition"
                   title="View Public Next.js Website">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-orange"></i>
                    <span>Live Website</span>
                </a>

                <!-- Create Listing Button -->
                <a href="{{ route('portal-admin.listings.create') }}" 
                   class="btn-portal-primary px-3.5 py-1.5 rounded-md text-xs flex items-center space-x-1.5 shadow-sm">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span>Create Listing</span>
                </a>

                <!-- Staff Profile Menu -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 text-xs text-slate-200 hover:text-white pl-2">
                        <div class="w-7 h-7 rounded-full bg-orange flex items-center justify-center text-white font-bold text-xs">
                            {{ auth()->user() ? auth()->user()->initials() : 'P' }}
                        </div>
                        <span class="hidden md:inline font-semibold text-xs">{{ auth()->user()->name ?? 'Staff' }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <div x-show="open" x-cloak 
                         class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-200 py-1.5 z-50 text-slate-800 text-xs">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="font-bold text-slate-900 truncate">{{ auth()->user()->name ?? 'Staff' }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                        <a href="{{ route('portal-admin.categories.index') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-slate-700">
                            <i class="fa-solid fa-tags w-4 mr-2 text-slate-400"></i> Categories &amp; Tags
                        </a>
                        <a href="{{ route('portal-admin.seo.index') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-slate-700">
                            <i class="fa-solid fa-chart-line w-4 mr-2 text-slate-400"></i> SEO &amp; Metadata
                        </a>
                        <a href="{{ route('portal-admin.enquiries.index') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-slate-700">
                            <i class="fa-solid fa-envelope-open-text w-4 mr-2 text-slate-400"></i> Enquiries &amp; Reports
                        </a>
                        @if(auth()->user() && auth()->user()->isAdminStaff())
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-purple-50 text-purple-700 font-semibold">
                                <i class="fa-solid fa-shield-halved w-4 mr-2 text-purple-500"></i> Super Admin Panel &rarr;
                            </a>
                        @endif
                        <div class="border-t border-slate-100 my-1"></div>
                        <form method="POST" action="{{ route('portal-admin.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-rose-50 text-rose-600 font-medium flex items-center">
                                <i class="fa-solid fa-right-from-bracket w-4 mr-2"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sub-Navbar for Quick Category Shortcuts -->
    <div class="bg-white border-b border-placex-line py-2 px-4 sm:px-6 shadow-sm">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between text-xs overflow-x-auto">
            <div class="flex items-center space-x-2 text-slate-600 font-medium">
                <span class="text-slate-400 font-bold uppercase text-[10px] tracking-wider mr-1">Quick CMS:</span>
                <a href="{{ route('portal-admin.jobs.index') }}" class="px-2.5 py-1 rounded hover:bg-slate-100 text-slate-700 font-semibold">Jobs Portal</a>
                <span class="text-slate-300">·</span>
                <a href="{{ route('portal-admin.property.index') }}" class="px-2.5 py-1 rounded hover:bg-slate-100 text-slate-700 font-semibold">Property Portal</a>
                <span class="text-slate-300">·</span>
                <a href="{{ route('portal-admin.classifieds.index') }}" class="px-2.5 py-1 rounded hover:bg-slate-100 text-slate-700 font-semibold">Classifieds Portal</a>
                <span class="text-slate-300">·</span>
                <a href="{{ route('portal-admin.vehicles.index') }}" class="px-2.5 py-1 rounded hover:bg-slate-100 text-slate-700 font-semibold">Vehicles Portal</a>
                <span class="text-slate-300">·</span>
                <a href="{{ route('portal-admin.matrimonial.index') }}" class="px-2.5 py-1 rounded hover:bg-slate-100 text-slate-700 font-semibold">Matrimonial Portal</a>
            </div>
            <div class="hidden sm:flex items-center space-x-2 text-[11px] text-slate-500">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Marketplace Sync: <b class="text-slate-700">Active</b></span>
            </div>
        </div>
    </div>

    <!-- Flash Alerts -->
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 pt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-lg flex items-center justify-between mb-4 shadow-sm" x-data="{ show: true }" x-show="show">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-3 rounded-lg flex items-center justify-between mb-4 shadow-sm" x-data="{ show: true }" x-show="show">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700">&times;</button>
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold px-4 py-3 rounded-lg flex items-center justify-between mb-4 shadow-sm" x-data="{ show: true }" x-show="show">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 text-sm"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                <button @click="show = false" class="text-amber-500 hover:text-amber-700">&times;</button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-[1400px] w-full mx-auto px-4 sm:px-6 py-4">
        @yield('content')
    </main>

    <!-- PlaceX Matching Footer -->
    <footer class="bg-white border-t border-placex-line py-5 mt-12 text-xs text-slate-500">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-slate-800">PlaceX Portal Admin</span>
                <span>·</span>
                <span>Frontend Content Management Suite</span>
            </div>
            <div class="flex items-center space-x-4 text-[11px]">
                <a href="http://localhost:3000" target="_blank" class="hover:text-orange">Next.js Frontend</a>
                <span>·</span>
                <span>Environment: <b class="text-slate-700">{{ app()->environment() }}</b></span>
                <span>·</span>
                <span>&copy; {{ date('Y') }} PlaceX Pakistan</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
