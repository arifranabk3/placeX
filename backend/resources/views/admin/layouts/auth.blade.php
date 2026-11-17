<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sign In' }} | PlaceX Admin Console</title>

    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS 3 CDN with PlaceX Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            800: '#0f233d',
                            900: '#0b1a30',
                            950: '#061324',
                        },
                        orange: {
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
    </style>
</head>
<body class="h-full flex items-center justify-center bg-gradient-to-br from-navy-950 via-navy-900 to-slate-950 text-slate-100 p-4">
    <div class="w-full max-w-md">
        <!-- Logo and Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 mb-2">
                <span class="text-3xl font-black tracking-tight text-white">Place<span class="text-orange-500">X</span></span>
                <span class="text-[10px] font-bold tracking-widest uppercase px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20">Admin</span>
            </div>
            <p class="text-xs text-slate-400 font-medium">Enterprise Marketplace Management Console</p>
        </div>

        <!-- Auth Card -->
        <div class="bg-navy-900/90 backdrop-blur-xl border border-slate-800 rounded-2xl shadow-2xl p-8 relative overflow-hidden">
            <!-- Decorative Accent Bar -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-600 via-orange-500 to-amber-500"></div>

            <!-- Flash Banners -->
            @if(session('error'))
                <div class="mb-5 p-3.5 bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded-xl flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs rounded-xl flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check mt-0.5 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('status'))
                <div class="mb-5 p-3.5 bg-sky-500/10 border border-sky-500/30 text-sky-400 text-xs rounded-xl flex items-start gap-2.5">
                    <i class="fa-solid fa-info-circle mt-0.5 text-sm"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer Notice -->
        <div class="text-center mt-6 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} PlaceX Marketplace. All administrative actions are recorded.</p>
            <p class="mt-1 text-[11px] text-slate-600">Restricted system. Unauthorized access attempts are monitored and logged.</p>
        </div>
    </div>
</body>
</html>
