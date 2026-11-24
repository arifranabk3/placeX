<!DOCTYPE html>
<html lang="en" class="h-full">
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
            overflow-x: hidden;
            width: 100%;
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

        /* Fully Fluid Layout Rules */
        .portal-layout {
            display: flex;
            min-height: 100dvh;
            width: 100%;
            position: relative;
        }

        .portal-main {
            flex: 1 1 0%;
            min-width: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .portal-content-fluid {
            width: 100%;
            min-width: 0;
            padding: clamp(12px, 1.8vw, 32px);
            flex: 1 1 auto;
        }

        /* Fluid Dashboard & Grid Utilities */
        .fluid-dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr));
            gap: clamp(12px, 1.5vw, 20px);
        }

        .fluid-editor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 380px), 1fr));
            gap: clamp(16px, 2vw, 28px);
        }

        /* Custom subtle scrollbar */
        .portal-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .portal-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full flex flex-col antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">

    <!-- Fluid Top Header -->
    <header class="bg-[#031727] text-white border-b border-white/10 sticky top-0 z-40 shadow-md w-full">
        <div class="w-full px-3 sm:px-6 h-[56px] flex items-center justify-between gap-2 sm:gap-4">
            
            <!-- Left: Mobile Toggle & Brand -->
            <div class="flex items-center space-x-3 sm:space-x-5">
                <!-- Mobile Drawer Toggle -->
                <button type="button" 
                        @click="sidebarOpen = !sidebarOpen" 
                        aria-label="Toggle navigation drawer"
                        class="p-2 rounded-lg bg-white/5 hover:bg-white/10 text-slate-200 transition focus:outline-none focus:ring-2 focus:ring-orange lg:hidden">
                    <i class="fa-solid fa-bars text-base"></i>
                </button>

                <!-- Desktop Sidebar Collapse Toggle -->
                <button type="button"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        aria-label="Toggle sidebar collapse"
                        class="hidden lg:flex p-2 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition">
                    <i class="fa-solid" :class="sidebarCollapsed ? 'fa-indent' : 'fa-outdent'"></i>
                </button>

                <!-- Brand -->
                <a href="{{ route('portal-admin.dashboard') }}" class="flex flex-col leading-none select-none">
                    <span class="text-xl sm:text-2xl font-black tracking-tight text-white">
                        Place<span class="brand-x">X</span>
                    </span>
                    <small class="text-[7.5px] sm:text-[8px] font-extrabold tracking-widest text-slate-300 uppercase mt-0.5">
                        Portal Admin CMS
                    </small>
                </a>
            </div>

            <!-- Center: Responsive Fluid Search or Status Indicator -->
            <div class="hidden xl:flex items-center flex-1 max-w-md mx-4">
                <form action="{{ route('portal-admin.listings.index') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" placeholder="Quick search listings, employers, vehicles..."
                           class="w-full pl-9 pr-4 py-1.5 bg-white/10 text-xs text-white placeholder-slate-400 rounded-xl border border-white/15 focus:outline-none focus:ring-2 focus:ring-orange focus:bg-white/15 transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </form>
            </div>

            <!-- Right Actions (Adaptive & Touch-Friendly) -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <!-- Public Next.js site preview link -->
                <a href="http://localhost:3000" target="_blank" 
                   class="hidden md:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold text-slate-200 transition"
                   title="View Public Next.js Website">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-orange"></i>
                    <span>Live Portal</span>
                </a>

                <!-- Create Listing Button -->
                <a href="{{ route('portal-admin.listings.create') }}" 
                   class="btn-portal-primary px-3 sm:px-4 py-1.5 rounded-xl text-xs flex items-center space-x-1.5 shadow-sm font-bold">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    <span class="hidden sm:inline">Create Listing</span>
                    <span class="sm:hidden">New</span>
                </a>

                <!-- Staff Profile Menu -->
                <div class="relative" x-data="{ profileMenu: false }" @click.outside="profileMenu = false">
                    <button @click="profileMenu = !profileMenu" 
                            aria-haspopup="true" 
                            :aria-expanded="profileMenu"
                            class="flex items-center space-x-2 text-xs text-slate-200 hover:text-white pl-1 sm:pl-2 focus:outline-none">
                        <div class="w-7 h-7 rounded-full bg-orange flex items-center justify-center text-white font-bold text-xs ring-2 ring-white/10">
                            {{ auth()->user() ? auth()->user()->initials() : 'P' }}
                        </div>
                        <span class="hidden md:inline font-semibold text-xs truncate max-w-[120px]">{{ auth()->user()->name ?? 'Staff' }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <div x-show="profileMenu" x-cloak 
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 z-50 text-slate-800 text-xs">
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
                            <i class="fa-solid fa-envelope-open-text w-4 mr-2 text-slate-400"></i> Enquiries &amp; Feedback
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

    <!-- Main Fluid Layout Container (Sidebar + Content) -->
    <div class="portal-layout flex-1">

        <!-- Mobile Backdrop / Overlay -->
        <div x-show="sidebarOpen" 
             x-cloak
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 lg:hidden"
             aria-hidden="true"></div>

        <!-- Fully Responsive Adaptive Sidebar Drawer -->
        <aside :class="{
                   'translate-x-0': sidebarOpen,
                   '-translate-x-full': !sidebarOpen,
                   'lg:w-64': !sidebarCollapsed,
                   'lg:w-20': sidebarCollapsed
               }"
               class="fixed inset-y-0 left-0 z-50 bg-[#061b2d] text-white flex flex-col transition-all duration-300 ease-in-out lg:static lg:translate-x-0 border-r border-white/10 shrink-0">
            
            <!-- Mobile Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-white/10 lg:hidden">
                <span class="text-lg font-black tracking-tight text-white">Place<span class="brand-x">X</span> CMS</span>
                <button type="button" @click="sidebarOpen = false" class="p-2 text-slate-400 hover:text-white rounded-lg">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto portal-scrollbar py-3 px-2 space-y-1">
                <div class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400"
                     :class="{ 'lg:hidden': sidebarCollapsed }">
                    Navigation
                </div>

                <!-- Dashboard -->
                <a href="{{ route('portal-admin.dashboard') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.dashboard') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Dashboard' : ''">
                    <i class="fa-solid fa-gauge w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Dashboard</span>
                </a>

                <!-- All Listings -->
                <a href="{{ route('portal-admin.listings.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.listings.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'All Listings' : ''">
                    <i class="fa-solid fa-layer-group w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">All Listings</span>
                </a>

                <div class="pt-3 px-3 pb-1 text-[10px] font-black uppercase tracking-wider text-slate-400"
                     :class="{ 'lg:hidden': sidebarCollapsed }">
                    5 Verticals
                </div>

                <!-- Jobs -->
                <a href="{{ route('portal-admin.jobs.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.jobs.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Jobs Portal' : ''">
                    <i class="fa-solid fa-briefcase w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Jobs</span>
                </a>

                <!-- Property -->
                <a href="{{ route('portal-admin.property.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.property.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Property Portal' : ''">
                    <i class="fa-solid fa-building w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Property</span>
                </a>

                <!-- Classifieds -->
                <a href="{{ route('portal-admin.classifieds.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.classifieds.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Classifieds' : ''">
                    <i class="fa-solid fa-boxes-stacked w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Classifieds</span>
                </a>

                <!-- Vehicles -->
                <a href="{{ route('portal-admin.vehicles.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.vehicles.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Vehicles' : ''">
                    <i class="fa-solid fa-car w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Vehicles</span>
                </a>

                <!-- Matrimonial -->
                <a href="{{ route('portal-admin.matrimonial.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.matrimonial.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Matrimonial' : ''">
                    <i class="fa-solid fa-heart w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Matrimonial</span>
                </a>

                <div class="pt-3 px-3 pb-1 text-[10px] font-black uppercase tracking-wider text-slate-400"
                     :class="{ 'lg:hidden': sidebarCollapsed }">
                    Publishing Tools
                </div>

                <!-- Media Library -->
                <a href="{{ route('portal-admin.media.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.media.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Media Library' : ''">
                    <i class="fa-solid fa-images w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Media Library</span>
                </a>

                <!-- Homepage CMS -->
                <a href="{{ route('portal-admin.homepage.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.homepage.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Homepage CMS' : ''">
                    <i class="fa-solid fa-house-laptop w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Homepage CMS</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('portal-admin.categories.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.categories.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Categories' : ''">
                    <i class="fa-solid fa-tags w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">Categories</span>
                </a>

                <!-- SEO -->
                <a href="{{ route('portal-admin.seo.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('portal-admin.seo.*') ? 'bg-[#ff5a0a] text-white shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'SEO & Metadata' : ''">
                    <i class="fa-solid fa-chart-line w-5 text-sm text-center mr-2.5 shrink-0"></i>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }">SEO Metadata</span>
                </a>
            </div>

            <!-- Sidebar Bottom Info -->
            <div class="p-3 border-t border-white/10 text-[11px] text-slate-400"
                 :class="{ 'text-center': sidebarCollapsed }">
                <div class="flex items-center gap-2" :class="{ 'justify-center': sidebarCollapsed }">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                    <span :class="{ 'lg:hidden': sidebarCollapsed }" class="font-bold text-slate-300">Live API Ready</span>
                </div>
            </div>
        </aside>

        <!-- Right Main Content Area (Fluid & Expanding) -->
        <div class="portal-main">

            <!-- Flash Alerts -->
            <div class="w-full px-3 sm:px-6 pt-3">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-xs mb-3" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 text-base">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-xs mb-3" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700 text-base">&times;</button>
                    </div>
                @endif
            </div>

            <!-- Yielded Fluid Content -->
            <main class="portal-content-fluid">
                @yield('content')
            </main>

            <!-- Fluid Footer -->
            <footer class="bg-white border-t border-placex-line py-4 px-4 sm:px-6 text-xs text-slate-500 mt-auto w-full">
                <div class="w-full flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-slate-800">PlaceX Portal Admin</span>
                        <span>·</span>
                        <span>Responsive Fluid CMS</span>
                    </div>
                    <div class="flex items-center space-x-3 text-[11px]">
                        <a href="http://localhost:3000" target="_blank" class="hover:text-orange font-medium">Next.js Portal</a>
                        <span>·</span>
                        <span>Environment: <b class="text-slate-700">{{ app()->environment() }}</b></span>
                        <span>·</span>
                        <span>&copy; {{ date('Y') }} PlaceX</span>
                    </div>
                </div>
            </footer>
        </div>

    </div>

    @stack('scripts')
</body>
</html>
