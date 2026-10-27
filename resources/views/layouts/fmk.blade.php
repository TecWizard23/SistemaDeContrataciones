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
<body class="h-full flex flex-col bg-slate-50 antialiased selection:bg-[#00a8cc] selection:text-white">

    <!-- Header Superior FMK (Navbar Global) -->
    <header class="bg-[#00a8cc] text-white h-16 px-6 flex items-center justify-between shadow-md z-30 flex-shrink-0">
        <!-- Left Side: Logotipo & Nombre Institucional -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-xs flex items-center justify-center text-amber-300 shadow-inner border border-white/30">
                <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <a href="{{ auth()->check() ? (auth()->user()->isHR() ? route('dashboard.index') : route('portal.index')) : route('login') }}" class="flex items-center gap-2 group">
                    <span class="text-lg font-extrabold tracking-tight text-white group-hover:opacity-90 transition-opacity">
                        Fundación Munasim Kullakita
                    </span>
                    <span class="text-[10px] font-bold px-2.5 py-0.5 bg-white/20 rounded-full border border-white/30 text-white uppercase tracking-wider">
                        FMK Sistema
                    </span>
                </a>
            </div>
        </div>

        <!-- Right Side: User Email & Logout Pill Button -->
        <div class="flex items-center gap-4 text-xs font-semibold">
            @auth
                <div class="hidden sm:flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-full border border-white/20">
                    <svg class="w-4 h-4 text-sky-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Usuario: <strong class="text-white">{{ auth()->user()->email ?? 'usuario.fmk' }}</strong></span>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-white text-[#00a8cc] hover:bg-sky-50 font-bold rounded-full border border-white/80 shadow-xs transition-all cursor-pointer">
                        <span>Salir</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-1.5 bg-white text-[#00a8cc] font-bold rounded-full border border-white/80 shadow-xs">
                    Iniciar Sesión
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Wrapper with Sidebar -->
    <div class="flex-grow flex min-h-0">
        
        @auth
        <!-- Sidebar Lateral Izquierdo FMK (Fijo w-56 o w-60) -->
        <aside class="w-56 sm:w-60 bg-white border-r border-slate-200 flex flex-col justify-between py-6 z-20 flex-shrink-0 shadow-xs">
            <nav class="space-y-1 px-3">
                
                <div class="px-3 pb-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                    {{ auth()->user()->isHR() ? 'Panel Reclutador RRHH' : 'Portal del Postulante' }}
                </div>

                @if(auth()->user()->isHR())
                    <!-- HR Role Sidebar Items -->
                    <a href="{{ route('dashboard.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('dashboard.index') ? 'bg-sky-50 text-[#00a8cc] font-bold border-r-4 border-[#00a8cc] shadow-2xs' : 'text-slate-600 hover:bg-sky-50/70 hover:text-[#00a8cc]' }}">
                        <svg class="w-4 h-4 text-slate-400 {{ request()->routeIs('dashboard.index') ? 'text-[#00a8cc]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Inicio / Dashboard</span>
                    </a>

                    <a href="{{ route('vacancies.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('vacancies.*') ? 'bg-sky-50 text-[#00a8cc] font-bold border-r-4 border-[#00a8cc] shadow-2xs' : 'text-slate-600 hover:bg-sky-50/70 hover:text-[#00a8cc]' }}">
                        <svg class="w-4 h-4 text-slate-400 {{ request()->routeIs('vacancies.*') ? 'text-[#00a8cc]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Convocatorias & Vacantes</span>
                    </a>

                    <a href="{{ route('candidates.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('candidates.*') ? 'bg-sky-50 text-[#00a8cc] font-bold border-r-4 border-[#00a8cc] shadow-2xs' : 'text-slate-600 hover:bg-sky-50/70 hover:text-[#00a8cc]' }}">
                        <svg class="w-4 h-4 text-slate-400 {{ request()->routeIs('candidates.*') ? 'text-[#00a8cc]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Contrataciones & Postulantes</span>
                    </a>

                    <div>
                        <a href="{{ route('evaluations-manage.index') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('evaluations-manage.index') || request()->routeIs('evaluations-manage.show') ? 'bg-sky-50 text-[#00a8cc] font-bold border-r-4 border-[#00a8cc] shadow-2xs' : 'text-slate-600 hover:bg-sky-50/70 hover:text-[#00a8cc]' }}">
                            <svg class="w-4 h-4 text-slate-400 {{ request()->routeIs('evaluations-manage.*') ? 'text-[#00a8cc]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Banco de Evaluaciones</span>
                        </a>
                        <a href="{{ route('evaluations-manage.create') }}" 
                           class="flex items-center gap-2 pl-9 pr-3 py-1.5 mt-0.5 rounded-lg text-[11px] font-semibold transition-all {{ request()->routeIs('evaluations-manage.create') ? 'bg-sky-100/70 text-[#00a8cc] font-bold' : 'text-slate-500 hover:text-[#00a8cc] hover:bg-slate-50' }}">
                            <svg class="w-3 h-3 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span>+ Crear Nuevo Examen</span>
                        </a>
                    </div>

                    <a href="{{ route('hr.compare') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('hr.compare') ? 'bg-sky-50 text-[#00a8cc] font-bold border-r-4 border-[#00a8cc] shadow-2xs' : 'text-slate-600 hover:bg-sky-50/70 hover:text-[#00a8cc]' }}">
                        <svg class="w-4 h-4 text-slate-400 {{ request()->routeIs('hr.compare') ? 'text-[#00a8cc]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                        </svg>
                        <span>Comparar Candidatos</span>
                    </a>
                @else
                    <!-- Candidate Role Sidebar Items -->
                    <a href="{{ route('portal.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('portal.index') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('portal.index') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Mis Evaluaciones</span>
                    </a>

                    <a href="{{ route('portal.profile') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('portal.profile') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('portal.profile') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mi Perfil Profesional</span>
                    </a>

                    <a href="{{ route('portal.my-results') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group {{ request()->routeIs('portal.my-results') ? 'bg-slate-900 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('portal.my-results') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Mis Resultados</span>
                    </a>
                @endif

                <div class="pt-4 border-t border-slate-100">
                    <div class="px-3 pb-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                        Sistema
                    </div>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                        <span>Configuración</span>
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
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium flex items-center gap-3">
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
