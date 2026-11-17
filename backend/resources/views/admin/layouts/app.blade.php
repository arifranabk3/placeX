<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900" x-data="{ sidebarOpen: false, userMenuOpen: false, notifOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Console' }} | PlaceX Enterprise</title>

    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS 3 CDN with PlaceX Enterprise Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            700: '#1e385b',
                            800: '#0f233d',
                            900: '#0b1a30',
                            950: '#061324',
                        },
                        orange: {
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                        }
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Roboto', sans-serif; font-size: 14px; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(15, 35, 61, 0.4); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(249, 115, 22, 0.35); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(249, 115, 22, 0.6); }
    </style>
</head>
<body class="h-full flex overflow-hidden text-slate-200 antialiased bg-slate-950">

    <!-- Mobile Backdrop -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-navy-950/80 backdrop-blur-sm z-40 lg:hidden"
        x-cloak
    ></div>

    <!-- LEFT SIDEBAR -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-navy-900 border-r border-slate-800/80 flex flex-col transition-transform duration-300 ease-in-out shrink-0"
    >
        <!-- Sidebar Header / Brand -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800/80 bg-navy-950/60">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <span class="text-2xl font-black tracking-tight text-white">Place<span class="text-orange-500">X</span></span>
                <span class="text-[9px] font-bold tracking-widest uppercase px-1.5 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/30">Enterprise</span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links (Scrollable) -->
        <nav class="flex-1 overflow-y-auto px-3.5 py-4 space-y-6 custom-scrollbar text-xs">
            
            <!-- Group: OVERVIEW -->
            <div>
                <p class="px-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Overview</p>
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-chart-pie text-sm w-4 text-center"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </div>

            <!-- Group: CORE MARKETPLACE -->
            <div>
                <p class="px-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Marketplace</p>
                <div class="space-y-1">
                    @if(auth()->user()->hasPermission('users.view'))
                    <a 
                        href="{{ route('admin.users.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-users text-sm w-4 text-center"></i>
                            <span>Users Directory</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('sellers.view'))
                    <a 
                        href="{{ route('admin.sellers.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.sellers.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-store text-sm w-4 text-center"></i>
                            <span>Sellers & Merchants</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('listings.view'))
                    <a 
                        href="{{ route('admin.listings.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.listings.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-layer-group text-sm w-4 text-center"></i>
                            <span>All Listings</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('categories.manage'))
                    <a 
                        href="{{ route('admin.categories.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-shapes text-sm w-4 text-center"></i>
                            <span>Categories & Specs</span>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Group: TRUST & SAFETY -->
            <div>
                <p class="px-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Trust & Safety</p>
                <div class="space-y-1">
                    @if(auth()->user()->hasPermission('moderation.view'))
                    <a 
                        href="{{ route('admin.moderation.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.moderation.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-shield-halved text-sm w-4 text-center"></i>
                            <span>Moderation Queue</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('reports.view'))
                    <a 
                        href="{{ route('admin.reports.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-sm w-4 text-center"></i>
                            <span>Reports & Complaints</span>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Group: MONETIZATION -->
            <div>
                <p class="px-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Monetization</p>
                <div class="space-y-1">
                    @if(auth()->user()->hasPermission('promotions.view'))
                    <a 
                        href="{{ route('admin.promotions.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.promotions.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-bolt text-sm w-4 text-center"></i>
                            <span>Promotions & Plans</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('payments.view'))
                    <a 
                        href="{{ route('admin.payments.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.payments.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-receipt text-sm w-4 text-center"></i>
                            <span>Payments & Ledger</span>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Group: SYSTEM GOVERNANCE -->
            <div>
                <p class="px-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">System Governance</p>
                <div class="space-y-1">
                    @if(auth()->user()->hasPermission('roles.manage'))
                    <a 
                        href="{{ route('admin.roles.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.roles.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-user-shield text-sm w-4 text-center"></i>
                            <span>Roles & RBAC Matrix</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('notifications.view'))
                    <a 
                        href="{{ route('admin.notifications.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.notifications.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-bell text-sm w-4 text-center"></i>
                            <span>Admin Notifications</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('audit_logs.view'))
                    <a 
                        href="{{ route('admin.audit-logs.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.audit-logs.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-clock-rotate-left text-sm w-4 text-center"></i>
                            <span>Audit Trail Logs</span>
                        </div>
                    </a>
                    @endif

                    @if(auth()->user()->hasPermission('settings.view'))
                    <a 
                        href="{{ route('admin.settings.index') }}" 
                        class="flex items-center justify-between px-2.5 py-2 rounded-xl font-medium transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-orange-500 text-white font-semibold shadow-md shadow-orange-500/20' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-sliders text-sm w-4 text-center"></i>
                            <span>Platform Settings</span>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

        </nav>

        <!-- Sidebar User Card at Bottom -->
        <div class="p-3 border-t border-slate-800/80 bg-navy-950/40">
            <div class="flex items-center justify-between p-2 rounded-xl bg-navy-800/60 border border-slate-800">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-orange-600 to-amber-500 text-white font-black text-xs flex items-center justify-center shrink-0">
                        {{ auth()->user()->initials }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-white truncate leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-orange-400 font-medium truncate">{{ auth()->user()->roles->first()->name ?? 'Staff' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" title="Sign Out" class="text-slate-400 hover:text-red-400 p-1.5 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-900">
        
        <!-- TOP NAVIGATION BAR -->
        <header class="h-16 bg-navy-900/90 backdrop-blur-md border-b border-slate-800 flex items-center justify-between px-4 lg:px-6 shrink-0 z-30">
            <!-- Left: Toggle & Breadcrumb -->
            <div class="flex items-center gap-3">
                <button 
                    @click="sidebarOpen = !sidebarOpen" 
                    class="lg:hidden text-slate-300 hover:text-white p-2 rounded-lg hover:bg-navy-800"
                    aria-label="Toggle navigation"
                >
                    <i class="fa-solid fa-bars text-base"></i>
                </button>
                <div class="hidden sm:flex items-center gap-2 text-xs text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-200 transition-colors">
                        <i class="fa-solid fa-house"></i>
                    </a>
                    @yield('breadcrumbs')
                </div>
            </div>

            <!-- Right: Actions & User Menu -->
            <div class="flex items-center gap-3.5">
                <!-- Public Website Link -->
                <a 
                    href="http://localhost:3000" 
                    target="_blank" 
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-navy-800 hover:bg-navy-700 text-slate-300 hover:text-white border border-slate-700 transition-colors"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    <span>Public Site</span>
                </a>

                <!-- Quick Environment Badge -->
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    {{ app()->environment() }}
                </span>

                <!-- Notifications Bell -->
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open" 
                        @click.outside="open = false" 
                        class="relative p-2 rounded-lg text-slate-400 hover:text-white hover:bg-navy-800 transition-colors"
                        title="Notifications"
                    >
                        <i class="fa-regular fa-bell text-sm"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-orange-500"></span>
                    </button>

                    <!-- Dropdown -->
                    <div 
                        x-show="open" 
                        x-transition 
                        class="absolute right-0 mt-2 w-80 bg-navy-900 border border-slate-700 rounded-xl shadow-2xl py-2 z-50 text-xs"
                        x-cloak
                    >
                        <div class="px-4 py-2 border-b border-slate-800 flex items-center justify-between">
                            <span class="font-bold text-white">System Alerts</span>
                            <a href="{{ route('admin.notifications.index') }}" class="text-[11px] text-orange-400 hover:underline">View all</a>
                        </div>
                        <div class="p-3 text-center text-slate-400 text-xs">
                            <i class="fa-regular fa-circle-check text-emerald-400 text-lg mb-1 block"></i>
                            All PlaceX systems operational.
                        </div>
                    </div>
                </div>

                <!-- Admin User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open" 
                        @click.outside="open = false" 
                        class="flex items-center gap-2 p-1 pl-2 rounded-xl text-slate-300 hover:bg-navy-800 transition-colors"
                    >
                        <div class="w-8 h-8 rounded-full bg-orange-500 text-white font-bold text-xs flex items-center justify-center shadow">
                            {{ auth()->user()->initials }}
                        </div>
                        <span class="text-xs font-semibold text-white hidden md:inline">{{ auth()->user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <div 
                        x-show="open" 
                        x-transition 
                        class="absolute right-0 mt-2 w-56 bg-navy-900 border border-slate-700 rounded-xl shadow-2xl py-1.5 z-50 text-xs divide-y divide-slate-800"
                        x-cloak
                    >
                        <div class="px-4 py-3">
                            <p class="font-bold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                            <span class="mt-1.5 inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20">
                                {{ auth()->user()->roles->first()->name ?? 'Admin Staff' }}
                            </span>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-300 hover:bg-navy-800 hover:text-white transition-colors">
                                <i class="fa-solid fa-sliders w-4 text-center"></i>
                                <span>Platform Settings</span>
                            </a>
                            <a href="{{ route('admin.audit-logs.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-300 hover:bg-navy-800 hover:text-white transition-colors">
                                <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
                                <span>Audit Logs</span>
                            </a>
                        </div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-red-400 hover:bg-red-500/10 transition-colors">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- FLASH NOTIFICATION BANNERS -->
        <div class="max-w-7xl w-full mx-auto px-4 lg:px-8 pt-4">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-4 p-3.5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs rounded-xl flex items-center justify-between gap-3 shadow-lg">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-200">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="mb-4 p-3.5 bg-red-500/10 border border-red-500/30 text-red-300 text-xs rounded-xl flex items-center justify-between gap-3 shadow-lg">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-red-400 text-sm"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-200">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div x-data="{ show: true }" x-show="show" class="mb-4 p-3.5 bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs rounded-xl flex items-center justify-between gap-3 shadow-lg">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-amber-400 text-sm"></i>
                        <span>{{ session('warning') }}</span>
                    </div>
                    <button @click="show = false" class="text-amber-400 hover:text-amber-200">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- MAIN SCROLLABLE CONTENT BODY -->
        <main class="flex-1 overflow-y-auto px-4 lg:px-8 pb-12 custom-scrollbar">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
</body>
</html>
