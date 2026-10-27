<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fundación Munasim Kullakita - Sistema de Selección & Evaluaciones')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Compiled Vite Assets (Tailwind CSS v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- QRCode Generator Library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="h-full flex flex-col bg-slate-50 antialiased selection:bg-slate-900 selection:text-white">

    <!-- Header Superior FMK (Executive Enterprise Navbar) -->
    <header class="bg-slate-950 text-white h-16 px-6 flex items-center justify-between border-b border-slate-800 shadow-sm z-30 flex-shrink-0">
        <!-- Left Side: Logotipo & Nombre Institucional -->
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white border border-white/15 shadow-xs">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <a href="{{ auth()->check() ? (auth()->user()->isHR() ? route('dashboard.index') : route('portal.index')) : route('login') }}" class="flex items-center gap-2 group">
                    <span class="text-base font-bold tracking-tight text-white group-hover:text-slate-200 transition-colors">
                        Fundación Munasim Kullakita
                    </span>
                    <span class="text-[10px] font-semibold px-2 py-0.5 bg-indigo-500/20 rounded-full border border-indigo-400/30 text-indigo-200 uppercase tracking-wider">
                        Sistema RRHH
                    </span>
                </a>
            </div>
        </div>

        <!-- Right Side: User Email & Logout Pill Button -->
        <div class="flex items-center gap-3 text-xs font-semibold">
            @auth
                <div class="hidden sm:flex items-center gap-2 bg-slate-900 px-3 py-1.5 rounded-full border border-slate-800 text-slate-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Usuario: <strong class="text-white font-medium">{{ auth()->user()->email ?? 'usuario.fmk' }}</strong></span>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white/10 hover:bg-white/20 text-white font-medium rounded-full border border-white/20 shadow-2xs transition-all cursor-pointer">
                        <span>Salir</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-1.5 bg-white/10 hover:bg-white/20 text-white font-medium rounded-full border border-white/20 transition-all">
                    Iniciar Sesión
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Wrapper with Sidebar -->
    <div class="flex-grow flex min-h-0">
        
        @auth
        <!-- Sidebar Lateral Izquierdo (Modern Executive Style) -->
        <aside class="w-56 sm:w-60 bg-white border-r border-slate-200 flex flex-col justify-between py-6 z-20 flex-shrink-0 shadow-2xs">
            <nav class="space-y-1 px-3">
                
                <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    {{ auth()->user()->isHR() ? 'Panel Reclutador RRHH' : 'Portal del Postulante' }}
                </div>

                @if(auth()->user()->isHR())
                    <!-- HR Role Sidebar Items -->
                    <a href="{{ route('dashboard.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('dashboard.index') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('dashboard.index') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Inicio / Dashboard</span>
                    </a>

                    <a href="{{ route('vacancies.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('vacancies.*') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('vacancies.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Convocatorias & Vacantes</span>
                    </a>

                    <a href="{{ route('candidates.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('candidates.*') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('candidates.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Contrataciones & Postulantes</span>
                    </a>

                    <div>
                        <a href="{{ route('evaluations-manage.index') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('evaluations-manage.index') || request()->routeIs('evaluations-manage.show') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('evaluations-manage.index') || request()->routeIs('evaluations-manage.show') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Banco de Evaluaciones</span>
                        </a>
                        <a href="{{ route('evaluations-manage.create') }}" 
                           class="flex items-center gap-2 pl-9 pr-3 py-1.5 mt-0.5 rounded-lg text-[11px] font-medium transition-all {{ request()->routeIs('evaluations-manage.create') ? 'bg-slate-900 text-white font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span>+ Crear Nuevo Examen</span>
                        </a>
                    </div>

                    <a href="{{ route('hr.compare') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('hr.compare') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('hr.compare') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                        </svg>
                        <span>Comparar Candidatos</span>
                    </a>
                @else
                    <!-- Candidate Role Sidebar Items -->
                    <a href="{{ route('portal.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('portal.index') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('portal.index') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Mis Evaluaciones</span>
                    </a>

                    <a href="{{ route('portal.profile') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('portal.profile') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('portal.profile') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mi Perfil Profesional</span>
                    </a>

                    <a href="{{ route('portal.my-results') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('portal.my-results') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('portal.my-results') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Mis Resultados</span>
                    </a>
                @endif

                <div class="pt-4 border-t border-slate-100 space-y-1">
                    <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Portal Público
                    </div>
                    <a href="{{ route('public.vacancies.index') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <span>Ver Convocatorias</span>
                        </div>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 font-medium">Web</span>
                    </a>
                </div>
            </nav>

            <div class="px-6 text-[10px] text-slate-400 text-center font-medium border-t border-slate-100 pt-4">
                Fundación Munasim Kullakita &copy; {{ date('Y') }}
            </div>
        </aside>
        @endauth

        <!-- Main Body Workspace -->
        <main class="flex-grow overflow-y-auto p-6 md:p-8 space-y-6">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @auth
        @if(auth()->user()->isHR())
            <!-- Global QR Code & Social Media Recruitment Kit Modal -->
            @include('components.qr-social-kit-modal')
        @endif
    @endauth

    @stack('scripts')
</body>
</html>
