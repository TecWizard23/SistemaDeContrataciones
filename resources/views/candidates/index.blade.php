@extends('layouts.fmk')

@section('title', 'Módulo de Contrataciones y Selección - Fundación Munasim Kullakita')

@section('content')
<div x-data="hiringManagement()" class="space-y-6">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <span class="text-[10px] text-emerald-600 uppercase tracking-wider font-extrabold">Operación Exitosa</span>
        </div>
    @endif

    <!-- Hero Banner Ejecutivo: Gestión de Contrataciones -->
    <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800/80 overflow-hidden">
        <div class="absolute -right-8 -bottom-8 opacity-5 text-white select-none pointer-events-none">
            <svg class="w-64 h-64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-extrabold px-3 py-1 bg-white/10 rounded-full border border-white/20 uppercase tracking-wider backdrop-blur-xs text-indigo-200">
                        Flujo de Contratación & Pipeline
                    </span>
                    <span class="text-xs text-slate-400 font-semibold flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Reclutamiento Activo
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Gestión Integral de Contrataciones
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 font-normal leading-relaxed">
                    Supervisa el ciclo de vida completo de cada postulante: evaluación psicométrica, entrevistas, ofertas y formalización final de contratos.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="button" 
                        onclick="openQrModal({
                            title: 'Convocatorias & Reclutamiento Masivo',
                            department: 'Fundación Munasim Kullakita',
                            location: 'La Paz / El Alto',
                            salary: 'Remuneración Competitiva',
                            contractType: 'Tiempo Completo / Consultoría',
                            url: '{{ route('public.vacancies.index') }}'
                        })"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl text-xs border border-white/20 backdrop-blur-xs shadow-xs transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    <span>Generar QR de Difusión</span>
                </button>

                <a href="{{ route('vacancies.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-slate-900 hover:bg-slate-100 font-extrabold rounded-xl text-xs shadow-md transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Ver Convocatorias</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Hiring Funnel KPI Ribbon (Embudo de Contratación) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        
        <!-- Postulados -->
        <a href="{{ route('candidates.index', ['stage' => 'POSTULADO']) }}" 
           class="bg-white rounded-2xl p-4 border {{ request('stage') === 'POSTULADO' ? 'border-slate-900 ring-2 ring-slate-900/10 shadow-sm' : 'border-slate-200/80' }} shadow-2xs hover:shadow-xs hover:border-slate-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">1. Postulados</span>
                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPostulados }}</div>
            <p class="text-[10px] text-slate-400 mt-0.5">Ingresados al sistema</p>
        </a>

        <!-- En Evaluación -->
        <a href="{{ route('candidates.index', ['stage' => 'EVALUADO']) }}" 
           class="bg-white rounded-2xl p-4 border {{ request('stage') === 'EVALUADO' ? 'border-indigo-600 ring-2 ring-indigo-500/20 shadow-sm' : 'border-slate-200/80' }} shadow-2xs hover:shadow-xs hover:border-slate-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider">2. Evaluados</span>
                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
            </div>
            <div class="text-2xl font-extrabold text-indigo-900 mt-1">{{ $totalEvaluados }}</div>
            <p class="text-[10px] text-slate-400 mt-0.5">Pruebas rendidas</p>
        </a>

        <!-- En Entrevista -->
        <a href="{{ route('candidates.index', ['stage' => 'ENTREVISTA']) }}" 
           class="bg-white rounded-2xl p-4 border {{ request('stage') === 'ENTREVISTA' ? 'border-blue-600 ring-2 ring-blue-500/20 shadow-sm' : 'border-slate-200/80' }} shadow-2xs hover:shadow-xs hover:border-slate-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-blue-600 uppercase tracking-wider">3. Entrevista</span>
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            </div>
            <div class="text-2xl font-extrabold text-blue-900 mt-1">{{ $totalEntrevista }}</div>
            <p class="text-[10px] text-slate-400 mt-0.5">Filtro personal</p>
        </a>

        <!-- Con Oferta -->
        <a href="{{ route('candidates.index', ['stage' => 'OFERTA']) }}" 
           class="bg-white rounded-2xl p-4 border {{ request('stage') === 'OFERTA' ? 'border-amber-500 ring-2 ring-amber-500/20 shadow-sm' : 'border-slate-200/80' }} shadow-2xs hover:shadow-xs hover:border-slate-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-amber-600 uppercase tracking-wider">4. Oferta</span>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <div class="text-2xl font-extrabold text-amber-800 mt-1">{{ $totalOferta }}</div>
            <p class="text-[10px] text-slate-400 mt-0.5">Propuesta enviada</p>
        </a>

        <!-- Contratados (¡Meta Lograda!) -->
        <a href="{{ route('candidates.index', ['stage' => 'CONTRATADO']) }}" 
           class="bg-white rounded-2xl p-4 border {{ request('stage') === 'CONTRATADO' ? 'border-emerald-600 ring-2 ring-emerald-500/20 shadow-sm' : 'border-emerald-200 bg-emerald-50/20' }} shadow-2xs hover:shadow-xs hover:border-emerald-400 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider">5. Contratados</span>
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
            </div>
            <div class="text-2xl font-extrabold text-emerald-700 mt-1">{{ $totalContratados }}</div>
            <p class="text-[10px] text-emerald-600 font-semibold mt-0.5">Plazas formalizadas</p>
        </a>

        <!-- Tasa de Conversión a Contratación -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Conversión</span>
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $hireRate }}%</div>
            <p class="text-[10px] text-slate-400 mt-0.5">Tasa de contratación</p>
        </div>

    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-4">
        
        <!-- Stage Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
            <a href="{{ route('candidates.index') }}" 
               class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ !request('stage') ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Todos ({{ $totalCandidates }})
            </a>
            <a href="{{ route('candidates.index', array_merge(request()->query(), ['stage' => 'POSTULADO'])) }}" 
               class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('stage') === 'POSTULADO' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Postulados ({{ $totalPostulados }})
            </a>
            <a href="{{ route('candidates.index', array_merge(request()->query(), ['stage' => 'EVALUADO'])) }}" 
               class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('stage') === 'EVALUADO' ? 'bg-indigo-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                En Evaluación ({{ $totalEvaluados }})
            </a>
            <a href="{{ route('candidates.index', array_merge(request()->query(), ['stage' => 'ENTREVISTA'])) }}" 
               class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('stage') === 'ENTREVISTA' ? 'bg-blue-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                En Entrevista ({{ $totalEntrevista }})
            </a>
            <a href="{{ route('candidates.index', array_merge(request()->query(), ['stage' => 'OFERTA'])) }}" 
               class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('stage') === 'OFERTA' ? 'bg-amber-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Con Oferta ({{ $totalOferta }})
            </a>
            <a href="{{ route('candidates.index', array_merge(request()->query(), ['stage' => 'CONTRATADO'])) }}" 
               class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('stage') === 'CONTRATADO' ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Contratados ({{ $totalContratados }})
            </a>
            <a href="{{ route('candidates.index', array_merge(request()->query(), ['stage' => 'DESCARTADO'])) }}" 
               class="px-3.5 py-1.5 rounded-xl font-bold transition-all {{ request('stage') === 'DESCARTADO' ? 'bg-rose-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Descartados ({{ $totalDescartados }})
            </a>
        </div>

        <form method="GET" action="{{ route('candidates.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            <input type="hidden" name="stage" value="{{ request('stage') }}">

            <div class="sm:col-span-6">
                <label class="block text-xs font-bold text-slate-700 mb-1">Buscar Postulante</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre, correo, cargo o ciudad..." 
                           class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all font-medium">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <div class="sm:col-span-4">
                <label class="block text-xs font-bold text-slate-700 mb-1">Filtrar por Convocatoria / Vacante</label>
                <select name="vacancy_id" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all font-semibold">
                    <option value="">Todas las convocatorias</option>
                    @foreach($vacancies as $vac)
                        <option value="{{ $vac->id }}" {{ (string) request('vacancy_id') === (string) $vac->id ? 'selected' : '' }}>
                            {{ $vac->title }} ({{ $vac->department }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-grow py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-xs shadow-xs transition-all cursor-pointer active:scale-95">
                    Filtrar
                </button>
                @if(request()->hasAny(['search', 'vacancy_id', 'stage']))
                    <a href="{{ route('candidates.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all" title="Limpiar filtros">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Candidates Master Table (Contrataciones y Reclutamiento) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <div class="bg-white border-b border-slate-200/80 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900 tracking-tight">
                        Registro Oficial de Postulantes & Decisiones de Contratación
                    </h2>
                    <p class="text-[11px] text-slate-400">Gestión de etapas del embudo y formalización de personal</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold px-3 py-1 bg-slate-100 text-slate-700 rounded-full border border-slate-200/80">
                    {{ $candidates->total() }} postulante(s)
                </span>
                <button onclick="window.print()" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all cursor-pointer border border-slate-200/80">
                    Imprimir Nómina
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-100 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">Candidato / Contacto</th>
                        <th class="px-6 py-3.5">Puesto & Vacante</th>
                        <th class="px-6 py-3.5">Ajuste & Evaluaciones</th>
                        <th class="px-6 py-3.5">Etapa en el Embudo</th>
                        <th class="px-6 py-3.5">Estado de Contratación</th>
                        <th class="px-6 py-3.5 text-right">Acciones de Selección</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($candidates as $cand)
                        @php
                            $lastSession = $cand->sessions->first();
                            $fitPct = $lastSession?->fit_percentage ?? 80;
                            $stage = $cand->hiring_stage ?? 'POSTULADO';
                        @endphp
                        <tr class="hover:bg-sky-50/40 transition-colors {{ $cand->isHired() ? 'bg-emerald-50/30' : '' }}">
                            
                            <!-- Candidate Name & Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $cand->isHired() ? 'bg-emerald-600 text-white' : 'bg-slate-900 text-white' }} font-bold flex items-center justify-center text-xs shadow-xs flex-shrink-0">
                                        {{ strtoupper(substr($cand->full_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-slate-900 text-sm flex items-center gap-1.5">
                                            <span>{{ $cand->full_name }}</span>
                                            @if($cand->isHired())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase tracking-wider">
                                                    Contratado
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-2">
                                            <span>{{ $cand->email }}</span>
                                            @if($cand->phone)
                                                <span>•</span>
                                                <span>{{ $cand->phone }}</span>
                                            @endif
                                            @if($cand->city)
                                                <span>•</span>
                                                <span class="text-slate-600 font-semibold">{{ $cand->city }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Position & Vacancy -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $cand->applied_position }}</div>
                                @if($cand->vacancy)
                                    <div class="text-[11px] text-indigo-600 font-semibold mt-0.5 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <span>Convocatoria: {{ $cand->vacancy->title }}</span>
                                    </div>
                                @else
                                    <div class="text-[11px] text-slate-400 mt-0.5">Postulación espontánea</div>
                                @endif
                            </td>

                            <!-- Evaluation & Fit Score -->
                            <td class="px-6 py-4">
                                <div class="space-y-1.5 min-w-[130px]">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-500 font-medium">Ajuste Psicotécnico:</span>
                                        <span class="font-extrabold {{ $fitPct >= 80 ? 'text-emerald-700' : ($fitPct >= 60 ? 'text-amber-600' : 'text-slate-500') }}">{{ $fitPct }}%</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full {{ $fitPct >= 80 ? 'bg-emerald-500' : ($fitPct >= 60 ? 'bg-amber-500' : 'bg-slate-400') }} rounded-full" style="width: {{ $fitPct }}%"></div>
                                    </div>
                                    <div class="text-[10px] text-slate-400">
                                        {{ $cand->sessions->count() }} prueba(s) registrada(s)
                                    </div>
                                </div>
                            </td>

                            <!-- Hiring Stage Selector Dropdown -->
                            <td class="px-6 py-4">
                                <form action="{{ route('candidates.update-stage', $cand) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="hiring_stage" 
                                            onchange="this.form.submit()" 
                                            class="px-2.5 py-1.5 rounded-xl text-xs font-bold border transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-slate-900
                                            {{ $stage === 'CONTRATADO' ? 'bg-emerald-50 text-emerald-800 border-emerald-300 font-extrabold' : 
                                               ($stage === 'ENTREVISTA' ? 'bg-blue-50 text-blue-800 border-blue-200' : 
                                               ($stage === 'OFERTA' ? 'bg-amber-50 text-amber-800 border-amber-200' : 
                                               ($stage === 'EVALUADO' ? 'bg-indigo-50 text-indigo-800 border-indigo-200' : 
                                               ($stage === 'DESCARTADO' ? 'bg-rose-50 text-rose-800 border-rose-200' : 'bg-slate-50 text-slate-700 border-slate-200')))) }}">
                                        <option value="POSTULADO" {{ $stage === 'POSTULADO' ? 'selected' : '' }}>Postulado</option>
                                        <option value="EVALUADO" {{ $stage === 'EVALUADO' ? 'selected' : '' }}>En Evaluación</option>
                                        <option value="ENTREVISTA" {{ $stage === 'ENTREVISTA' ? 'selected' : '' }}>En Entrevista</option>
                                        <option value="OFERTA" {{ $stage === 'OFERTA' ? 'selected' : '' }}>Con Oferta</option>
                                        <option value="CONTRATADO" {{ $stage === 'CONTRATADO' ? 'selected' : '' }}>Contratado</option>
                                        <option value="DESCARTADO" {{ $stage === 'DESCARTADO' ? 'selected' : '' }}>Descartado</option>
                                    </select>
                                </form>
                            </td>

                            <!-- Hiring Status & Date -->
                            <td class="px-6 py-4">
                                @if($cand->isHired())
                                    <div class="space-y-0.5">
                                        <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-emerald-700">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Contrato Firmado</span>
                                        </span>
                                        <div class="text-[10px] text-slate-400">
                                            {{ $cand->hired_at ? $cand->hired_at->format('d/m/Y') : 'Reciente' }}
                                        </div>
                                    </div>
                                @else
                                    <span class="text-[11px] font-semibold text-slate-500">
                                        En proceso selectivo
                                    </span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="px-6 py-4 text-right space-x-1">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    
                                    <!-- Quick "Contratar" Action Button (If not already hired) -->
                                    @if(!$cand->isHired())
                                        <button type="button" 
                                                @click="openHireModal({{ $cand->id }}, '{{ addslashes($cand->full_name) }}', '{{ addslashes($cand->applied_position) }}', {{ $fitPct }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs hover:shadow-sm transition-all cursor-pointer active:scale-95">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Contratar</span>
                                        </button>
                                    @endif

                                    <!-- Compare / View Radar Link -->
                                    <a href="{{ route('hr.compare') }}?candidates={{ $cand->id }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200/80 transition-all shadow-2xs"
                                       title="Comparar y analizar perfil de competencias">
                                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Radar</span>
                                    </a>

                                    @if($lastSession)
                                        <a href="{{ route('candidate.session.pdf', $lastSession) }}" 
                                           class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer" 
                                           title="Descargar Ficha en PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 text-xs">
                                No se encontraron postulantes que coincidan con los criterios de búsqueda o etapa seleccionada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $candidates->links() }}
        </div>
    </div>

    <!-- Modal para Formalizar Contratación -->
    <div x-show="hireModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" 
         aria-modal="true">
        
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="hireModalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-lg border border-slate-200">
                
                <form :action="'{{ url('/candidates') }}/' + candidateId + '/hire'" method="POST">
                    @csrf

                    <div class="bg-gradient-to-r from-[#059669] to-[#10b981] px-6 py-5 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-extrabold px-2.5 py-0.5 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                                    Decisión Final de Selección
                                </span>
                                <h3 class="text-lg font-extrabold tracking-tight mt-0.5">
                                    Formalizar Contratación
                                </h3>
                            </div>
                        </div>

                        <button @click="hireModalOpen = false" type="button" class="text-white/80 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="bg-emerald-50 rounded-2xl p-4 border border-emerald-200">
                            <div class="text-xs text-slate-500 font-semibold">Postulante a contratar:</div>
                            <div class="text-base font-extrabold text-slate-900 mt-0.5" x-text="candidateName"></div>
                            <div class="text-xs text-emerald-800 font-bold mt-1 flex items-center gap-2">
                                <span x-text="'Cargo: ' + candidatePosition"></span>
                                <span>•</span>
                                <span x-text="'Ajuste: ' + candidateFit + '%'"></span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Notas de Contratación / Términos de Contrato (Opcional)
                            </label>
                            <textarea name="hiring_notes" rows="3" placeholder="Ej. Contratado a partir del 1ro de noviembre con sueldo acordado de 5.500 Bs. Cargo: Área Psicosocial." 
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-medium"></textarea>
                            <span class="text-[11px] text-slate-400 mt-1 block">
                                Al confirmar, el candidato pasará a estado oficial CONTRATADO y se registrará la fecha y hora de formalización.
                            </span>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" @click="hireModalOpen = false" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition-all cursor-pointer">
                            Cancelar
                        </button>
                        <button type="submit" class="px-5 py-2 bg-[#059669] hover:bg-[#047857] text-white font-extrabold rounded-xl text-xs shadow-md transition-all cursor-pointer">
                            Confirmar Contratación
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

<script>
function hiringManagement() {
    return {
        hireModalOpen: false,
        candidateId: '',
        candidateName: '',
        candidatePosition: '',
        candidateFit: 0,

        openHireModal(id, name, position, fit) {
            this.candidateId = id;
            this.candidateName = name;
            this.candidatePosition = position;
            this.candidateFit = fit;
            this.hireModalOpen = true;
        }
    };
}
</script>
@endsection
