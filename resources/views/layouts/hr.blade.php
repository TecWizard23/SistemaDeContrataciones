<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullakita - Comparar Candidatos & Radar de Competencias')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Compiled Vite Assets (Tailwind CSS v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js CDN (defer) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="h-full flex bg-slate-50 antialiased selection:bg-kenjo-500 selection:text-white">

    <!-- Left Fixed Icon Sidebar (Kenjo HR Style) -->
    <aside class="w-16 sm:w-20 bg-white border-r border-slate-200 flex flex-col justify-between items-center py-5 z-40 flex-shrink-0 shadow-sm">
        <div class="flex flex-col items-center gap-6 w-full">
            <!-- Brand Mark Icon -->
            <a href="{{ route('dashboard.index') }}" class="w-10 h-10 rounded-xl bg-gradient-to-tr from-kenjo-600 to-emerald-400 flex items-center justify-center text-white shadow-md shadow-kenjo-500/20 hover:scale-105 transition-transform" title="Kullakita HR">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </a>

            <!-- Vertical Navigation Icons -->
            <nav class="flex flex-col items-center gap-2 w-full px-2">
                <!-- Home / Dashboard -->
                <a href="{{ route('dashboard.index') }}" 
                   class="w-11 h-11 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all {{ request()->routeIs('dashboard.index') ? 'bg-slate-100 text-slate-900 font-bold' : '' }}" 
                   title="Inicio / Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </a>

                <!-- Candidatos -->
                <a href="{{ route('dashboard.index') }}" 
                   class="w-11 h-11 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all" 
                   title="Candidatos & Postulantes">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </a>

                <!-- Portafolio / Evaluaciones Banco -->
                <a href="{{ route('evaluations-manage.index') }}" 
                   class="w-11 h-11 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all {{ request()->routeIs('evaluations-manage.*') ? 'bg-slate-100 text-slate-900 font-bold' : '' }}" 
                   title="Banco de Evaluaciones">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </a>

                <!-- Comparar / Analytics (Active) -->
                <a href="{{ route('hr.compare') }}" 
                   class="w-11 h-11 rounded-xl flex items-center justify-center transition-all relative {{ request()->routeIs('hr.compare') ? 'bg-kenjo-50 text-kenjo-600 font-semibold ring-1 ring-kenjo-500/30' : 'text-slate-400 hover:text-slate-700 hover:bg-slate-100' }}" 
                   title="Comparar Candidatos & Radar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    @if(request()->routeIs('hr.compare'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-kenjo-500 rounded-r-full"></span>
                    @endif
                </a>

                <!-- Reportes -->
                <a href="#" class="w-11 h-11 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all" title="Reportes">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </a>

                <!-- Configuración -->
                <a href="#" class="w-11 h-11 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all" title="Configuración">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>
            </nav>
        </div>

        <!-- Bottom User Avatar & Language Picker -->
        <div class="flex flex-col items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600 border border-slate-200" title="Idioma ES">
                ES
            </div>
            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="w-10 h-10 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center ring-2 ring-slate-200 hover:ring-kenjo-500 transition-all text-xs shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'HR', 0, 2)) }}
                </button>

                <div x-show="open" @click.outside="open = false" x-cloak class="absolute left-12 bottom-0 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                    <div class="px-4 py-2 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'Usuario RRHH' }}</p>
                        <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 font-medium transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Right Main Wrapper -->
    <div class="flex-grow flex flex-col min-w-0 overflow-y-auto">
        <!-- Top Horizontal Header Navbar (Kenjo HR style) -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-30 px-6 py-3 flex items-center justify-between shadow-xs">
            <!-- Left Header Title & Subnav -->
            <div class="flex items-center gap-8">
                <!-- Title & Logo text -->
                <div class="flex items-center gap-3">
                    <span class="text-lg font-extrabold text-slate-900 tracking-tight">Kullakita</span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-kenjo-50 text-kenjo-700 border border-kenjo-200">
                        HR Analytics
                    </span>
                </div>

                <!-- Navigation Tabs (Active tab underlined in mint green) -->
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="{{ route('dashboard.index') }}" class="py-1 text-slate-500 hover:text-slate-900 font-medium transition-colors">
                        Evaluación de desempeño
                    </a>
                    <a href="{{ route('evaluations-manage.index') }}" class="py-1 text-slate-500 hover:text-slate-900 font-medium transition-colors">
                        Evaluaciones
                    </a>
                    <a href="{{ route('dashboard.index') }}" class="py-1 text-slate-500 hover:text-slate-900 font-medium transition-colors">
                        Resultados
                    </a>
                    <a href="{{ route('hr.compare') }}" class="py-1 font-bold text-slate-900 border-b-2 border-kenjo-500 pb-3 -mb-3 transition-colors">
                        Comparar
                    </a>
                </nav>
            </div>

            <!-- Right Navbar Utilities -->
            <div class="flex items-center gap-4">
                <!-- Search Box -->
                <div class="relative hidden sm:block">
                    <input type="text" placeholder="Buscar candidato o puesto..." class="w-64 pl-9 pr-4 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:bg-white transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Notifications Icon -->
                <button class="p-2 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100 transition-colors relative" title="Notificaciones">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-kenjo-500 rounded-full ring-2 ring-white"></span>
                </button>

                <!-- Help Icon -->
                <button class="p-2 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100 transition-colors" title="Centro de Ayuda">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Dynamic Page Content -->
        <main class="flex-grow p-6 md:p-8">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
