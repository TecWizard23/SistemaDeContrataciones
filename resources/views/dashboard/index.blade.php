@extends('layouts.fmk')

@section('title', 'Panel Principal de Reclutamiento - Fundación Munasim Kullakita')

@section('content')
<div class="space-y-6">

    <!-- Hero Banner de Bienvenida FMK (Variante Azul/Índigo) -->
    <div class="relative bg-gradient-to-r from-[#5965db] to-[#4539a8] rounded-3xl p-8 text-white shadow-xl overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl font-bold select-none pointer-events-none">
            ☀️
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full border border-white/30 uppercase tracking-wider">
                        Sistema FMK
                    </span>
                    <span class="text-xs text-indigo-100 font-semibold">
                        Selección & Evaluación Psicométrica
                    </span>
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight">
                    Panel Principal de Reclutamiento
                </h1>
                <p class="text-xs sm:text-sm text-indigo-100 max-w-2xl font-medium">
                    Gestión centralizada de postulantes, supervisión de exámenes cognitivos y perfiles conductuales DISC.
                </p>
            </div>

            <div>
                <a href="{{ route('evaluations-manage.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white text-[#4539a8] hover:bg-sky-50 font-extrabold rounded-2xl text-xs shadow-lg transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-[#4539a8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Gestionar Evaluaciones</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Fila de 4 KPI Cards FMK -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Azul Vibrante (#1d4ed8) -> Total Postulantes -->
        <div class="bg-[#1d4ed8] text-white rounded-2xl p-5 shadow-md shadow-blue-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Candidatos Registrados</p>
                <p class="text-3xl font-extrabold">{{ number_format($totalCandidatesCount) }}</p>
                <p class="text-[11px] text-blue-200">En base de datos FMK</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white text-2xl font-bold">
                👥
            </div>
        </div>

        <!-- Card 2: Verde Esmeralda (#059669) -> Pruebas Completadas -->
        <div class="bg-[#059669] text-white rounded-2xl p-5 shadow-md shadow-emerald-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-emerald-100 uppercase tracking-wider">Pruebas Completadas</p>
                <p class="text-3xl font-extrabold">{{ number_format($completedSessionsCount) }}</p>
                <p class="text-[11px] text-emerald-200">Sesiones evaluadas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white text-2xl font-bold">
                ✅
            </div>
        </div>

        <!-- Card 3: Mostaza / Ámbar (#f59e0b) -> Promedio Fit -->
        <div class="bg-[#f59e0b] text-white rounded-2xl p-5 shadow-md shadow-amber-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-amber-100 uppercase tracking-wider">Promedio Fit General</p>
                <p class="text-3xl font-extrabold">{{ $avgFitPercentage }}%</p>
                <p class="text-[11px] text-amber-100">Adecuación al perfil</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white text-2xl font-bold">
                🎯
            </div>
        </div>

        <!-- Card 4: Celeste Turquesa (#06b6d4) -> En Revisión -->
        <div class="bg-[#06b6d4] text-white rounded-2xl p-5 shadow-md shadow-cyan-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-cyan-100 uppercase tracking-wider">Puestos Activos</p>
                <p class="text-3xl font-extrabold">{{ count($positions) }}</p>
                <p class="text-[11px] text-cyan-100">Convocatorias vigentes</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white text-2xl font-bold">
                📂
            </div>
        </div>

    </div>

    <!-- Barra de Filtros FMK -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('dashboard.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Buscar Candidato</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o correo..." 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Puesto Postulado</label>
                <select name="position" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                    <option value="">Todos los puestos</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Fit Mínimo (%)</label>
                <input type="number" name="min_fit" value="{{ request('min_fit') }}" min="0" max="100" placeholder="Ej. 50" 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Fit Máximo (%)</label>
                <input type="number" name="max_fit" value="{{ request('max_fit') }}" min="0" max="100" placeholder="Ej. 100" 
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-grow py-2 bg-[#00a8cc] hover:bg-[#007b99] text-white font-bold rounded-xl text-xs shadow-xs transition-colors cursor-pointer">
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
                <span>📋</span> Postulantes Registrados en Sistema FMK
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
                                    <div class="w-8 h-8 rounded-full bg-[#00a8cc]/10 text-[#00a8cc] font-bold flex items-center justify-center text-xs border border-[#00a8cc]/20">
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
                                    @forelse($candidate->sessions as $session)
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-slate-700">
                                                {{ $session->evaluation->title }}:
                                            </span>
                                            @if($session->status === 'COMPLETED')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    COMPLETADA ({{ number_format($session->fit_percentage, 0) }}%)
                                                </span>
                                            @elseif($session->status === 'IN_PROGRESS')
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                    EN CURSO
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                    PENDIENTE
                                                </span>
                                            @endif
                                        </div>
                                    @empty
                                        <span class="text-slate-400 italic">Sin pruebas iniciadas</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                @php
                                    $completed = $candidate->sessions->where('status', 'COMPLETED');
                                    $avgFit = $completed->count() > 0 ? $completed->avg('fit_percentage') : null;
                                @endphp

                                @if(!is_null($avgFit))
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200">
                                            <div class="bg-[#059669] h-2 rounded-full" style="width: {{ min(100, $avgFit) }}%"></div>
                                        </div>
                                        <span class="font-bold text-slate-900">{{ number_format($avgFit, 1) }}%</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 font-medium">N/A</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right space-y-1">
                                @foreach($candidate->sessions as $s)
                                    @if($s->status === 'COMPLETED')
                                        <div>
                                            <a href="{{ route('dashboard.sessions.show', $s) }}" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#00a8cc] hover:bg-[#007b99] text-white text-[11px] font-bold rounded-full transition-all shadow-2xs">
                                                <span>Ver Detalle ({{ $s->evaluation->type }})</span>
                                                <span>&rarr;</span>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                                No se encontraron candidatos con los criterios especificados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
