@extends('layouts.fmk')

@section('title', 'Panel Principal de Reclutamiento - Fundación Munasim Kullakita')

@section('content')
<div class="space-y-6 pb-12">

    <!-- Hero Banner de Bienvenida FMK (Variante Azul/Índigo) -->
    <div class="relative bg-gradient-to-r from-[#5965db] via-[#4f46e5] to-[#4539a8] rounded-3xl p-6 sm:p-8 text-white shadow-xl overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white select-none pointer-events-none">
            <svg class="w-56 h-56" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2.5">
                    <span class="bg-white/20 backdrop-blur-md text-white text-[11px] font-extrabold px-3 py-1 rounded-full border border-white/30 uppercase tracking-wider">
                        Sistema RRHH
                    </span>
                    <span class="text-xs text-indigo-100 font-semibold flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Selección & Evaluaciones Munasim Kullakita
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Panel de Control de Reclutamiento
                </h1>
                <p class="text-xs sm:text-sm text-indigo-100 max-w-2xl font-medium leading-relaxed">
                    Monitorea postulaciones en tiempo real, administra convocatorias laborales y supervisa resultados psicométricos con análisis de ajuste al puesto.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" 
                        onclick="openQrModal({
                            title: 'Convocatorias & Reclutamiento FMK',
                            department: 'Fundación Munasim Kullakita',
                            location: 'La Paz / El Alto',
                            salary: 'Remuneración Competitiva',
                            contractType: 'Tiempo Completo / Consultor',
                            url: '{{ route('public.vacancies.index') }}'
                        })"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold rounded-2xl text-xs shadow-md hover:shadow-lg transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    <span>Generar QR Redes</span>
                </button>

                <a href="{{ route('vacancies.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-[#4539a8] hover:bg-indigo-50 font-extrabold rounded-2xl text-xs shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-[#4539a8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Nueva Convocatoria</span>
                </a>

                <a href="{{ route('evaluations-manage.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-extrabold rounded-2xl text-xs border border-white/30 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Crear Examen</span>
                </a>

                <a href="{{ route('candidates.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-extrabold rounded-2xl text-xs border border-white/30 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Contrataciones</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Fila de 4 KPI Cards FMK -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Azul Vibrante (#1d4ed8) -> Total Postulantes -->
        <div class="bg-[#1d4ed8] text-white rounded-2xl p-5 shadow-md shadow-blue-500/10 flex items-center justify-between relative overflow-hidden group hover:scale-[1.02] transition-transform">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Candidatos Registrados</p>
                <p class="text-3xl font-extrabold">{{ number_format($totalCandidatesCount) }}</p>
                <p class="text-[11px] text-blue-200">En base de datos FMK</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: Verde Esmeralda (#059669) -> Pruebas Completadas -->
        <div class="bg-[#059669] text-white rounded-2xl p-5 shadow-md shadow-emerald-500/10 flex items-center justify-between relative overflow-hidden group hover:scale-[1.02] transition-transform">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-emerald-100 uppercase tracking-wider">Pruebas Completadas</p>
                <p class="text-3xl font-extrabold">{{ number_format($completedSessionsCount) }}</p>
                <p class="text-[11px] text-emerald-200">Sesiones evaluadas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 3: Mostaza / Ámbar (#f59e0b) -> Promedio Fit -->
        <div class="bg-[#f59e0b] text-white rounded-2xl p-5 shadow-md shadow-amber-500/10 flex items-center justify-between relative overflow-hidden group hover:scale-[1.02] transition-transform">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-amber-100 uppercase tracking-wider">Promedio Fit General</p>
                <p class="text-3xl font-extrabold">{{ $avgFitPercentage }}%</p>
                <p class="text-[11px] text-amber-100">Adecuación al perfil</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>

        <!-- Card 4: Celeste Turquesa (#06b6d4) -> Convocatorias Abiertas -->
        <a href="{{ route('vacancies.index') }}" class="bg-[#06b6d4] text-white rounded-2xl p-5 shadow-md shadow-cyan-500/10 flex items-center justify-between relative overflow-hidden group hover:scale-[1.02] transition-transform cursor-pointer">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-cyan-100 uppercase tracking-wider">Convocatorias Abiertas</p>
                <p class="text-3xl font-extrabold">{{ $openVacanciesCount }}</p>
                <p class="text-[11px] text-cyan-100">Procesos activos &rarr;</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </a>

    </div>

    <!-- Analytics & Fit Distribution Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Fit Distribution Card (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    </svg>
                    <span>Distribución de Ajuste</span>
                </h3>
                <span class="text-[10px] font-extrabold text-slate-400">Total: {{ $completedSessionsCount }}</span>
            </div>

            <div class="space-y-3.5 pt-1">
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1">
                        <span class="text-emerald-700">Ajuste Alto (&ge; 70%)</span>
                        <span class="text-slate-900">{{ $highFitCount }} candidato(s)</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" 
                             style="width: {{ $completedSessionsCount > 0 ? round(($highFitCount / $completedSessionsCount) * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs font-bold mb-1">
                        <span class="text-amber-700">Ajuste Medio (40% - 69%)</span>
                        <span class="text-slate-900">{{ $midFitCount }} candidato(s)</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full transition-all duration-500" 
                             style="width: {{ $completedSessionsCount > 0 ? round(($midFitCount / $completedSessionsCount) * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs font-bold mb-1">
                        <span class="text-slate-600">En Observación (&lt; 40%)</span>
                        <span class="text-slate-900">{{ $lowFitCount }} candidato(s)</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-slate-400 rounded-full transition-all duration-500" 
                             style="width: {{ $completedSessionsCount > 0 ? round(($lowFitCount / $completedSessionsCount) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <a href="{{ route('analytics.index') }}" class="text-xs font-bold text-[#00a8cc] hover:underline flex items-center justify-between">
                    <span>Ver estadísticas completas</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity Feed (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#00a8cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Últimos Exámenes Rendidos</span>
                </h3>
                <span class="text-[10px] font-extrabold text-slate-400">Monitoreo en Vivo</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($recentSessions as $rSession)
                    <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-sky-50/30 hover:border-sky-200 transition-all flex items-center justify-between gap-3">
                        <div class="space-y-0.5 min-w-0">
                            <p class="text-xs font-extrabold text-slate-900 truncate">{{ $rSession->candidate->full_name }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ $rSession->evaluation->title }}</p>
                            <p class="text-[10px] text-slate-400">{{ $rSession->completed_at ? $rSession->completed_at->diffForHumans() : 'Reciente' }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-black {{ $rSession->fit_percentage >= 70 ? 'bg-emerald-100 text-emerald-800' : ($rSession->fit_percentage >= 40 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                                {{ $rSession->fit_percentage }}%
                            </span>
                            <a href="{{ route('dashboard.sessions.show', $rSession) }}" class="p-1 text-slate-400 hover:text-[#00a8cc] rounded-md transition-colors" title="Ver detalle">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 col-span-2 py-4 text-center">No hay exámenes completados recientemente.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Barra de Filtros FMK (SQL Injection-Immune) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('dashboard.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Buscar Candidato</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o correo..." 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Puesto Postulado</label>
                <select name="position" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-semibold">
                    <option value="">Todos los puestos</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Fit Mínimo (%)</label>
                <input type="number" name="min_fit" value="{{ request('min_fit') }}" min="0" max="100" placeholder="Ej. 50" 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-bold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Fit Máximo (%)</label>
                <input type="number" name="max_fit" value="{{ request('max_fit') }}" min="0" max="100" placeholder="Ej. 100" 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-bold">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-grow py-2 bg-[#00a8cc] hover:bg-[#007b99] text-white font-bold rounded-xl text-xs shadow-xs transition-colors cursor-pointer active:scale-95">
                    Filtrar
                </button>
                @if(request()->hasAny(['search', 'position', 'min_fit', 'max_fit']))
                    <a href="{{ route('dashboard.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabla con Estilo FMK (Cabecera Azul #2563eb) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Table Header Bar -->
        <div class="bg-[#2563eb] text-white px-6 py-4 flex items-center justify-between">
            <h2 class="text-sm font-bold tracking-wide flex items-center gap-2">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Postulantes Registrados en Sistema FMK</span>
            </h2>
            <span class="text-xs font-semibold px-3 py-1 bg-white/20 rounded-full border border-white/30">
                Total: {{ $candidates->count() }} candidato(s)
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-6">Candidato</th>
                        <th class="py-3.5 px-6">Puesto Postulado</th>
                        <th class="py-3.5 px-6">Evaluaciones Asignadas</th>
                        <th class="py-3.5 px-6">Fit Promedio</th>
                        <th class="py-3.5 px-6 text-right">Reportes & Detalle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($candidates as $candidate)
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-[#00a8cc]/10 text-[#00a8cc] font-extrabold flex items-center justify-center text-xs border border-[#00a8cc]/20">
                                        {{ strtoupper(substr($candidate->full_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $candidate->full_name }}</div>
                                        <div class="text-slate-400 text-[11px]">{{ $candidate->email }} @if($candidate->phone) &bull; {{ $candidate->phone }} @endif</div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 font-bold text-[11px]">
                                    {{ $candidate->applied_position }}
                                </span>
                            </td>

                            <td class="py-4 px-6">
                                <div class="space-y-1.5">
                                    @forelse($candidate->sessions as $s)
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $s->status === 'COMPLETED' ? 'bg-emerald-500' : ($s->status === 'IN_PROGRESS' ? 'bg-amber-500' : 'bg-slate-300') }}"></span>
                                            <span class="font-medium text-slate-700">{{ $s->evaluation->title }}</span>
                                            @if($s->status === 'COMPLETED')
                                                <span class="text-[10px] text-emerald-700 font-extrabold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                                                    {{ $s->fit_percentage }}%
                                                </span>
                                            @endif
                                        </div>
                                    @empty
                                        <span class="text-slate-400 italic">Sin pruebas asignadas</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                @php
                                    $completed = $candidate->sessions->where('status', 'COMPLETED');
                                    $cAvg = $completed->count() > 0 ? round($completed->avg('fit_percentage'), 1) : null;
                                @endphp
                                @if($cAvg !== null)
                                    <div class="flex items-center gap-2">
                                        <div class="w-14 bg-slate-200 h-2 rounded-full overflow-hidden">
                                            <div class="h-full {{ $cAvg >= 70 ? 'bg-emerald-500' : ($cAvg >= 50 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $cAvg }}%"></div>
                                        </div>
                                        <span class="font-extrabold text-xs {{ $cAvg >= 70 ? 'text-emerald-700' : ($cAvg >= 50 ? 'text-amber-700' : 'text-red-700') }}">
                                            {{ $cAvg }}%
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-400 text-[11px]">Pendiente</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    @if($candidate->sessions->isNotEmpty())
                                        @php $firstSession = $candidate->sessions->first(); @endphp
                                        <a href="{{ route('dashboard.sessions.show', $firstSession) }}" 
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-sky-50 text-[#00a8cc] hover:bg-sky-100 rounded-lg text-xs font-bold border border-sky-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span>Detalle</span>
                                        </a>

                                        @if($firstSession->status === 'COMPLETED')
                                            <a href="{{ route('candidate.session.pdf', $firstSession) }}" target="_blank"
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg text-xs font-bold border border-rose-200 transition-colors" title="Descargar PDF Oficial">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span>PDF</span>
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-slate-400 text-xs italic">Sin sesiones</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                                No se encontraron candidatos con los filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
