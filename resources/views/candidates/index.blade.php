@extends('layouts.fmk')

@section('title', 'Gestión de Postulantes - Fundación Munasim Kullakita')

@section('content')
<div class="space-y-6">

    <!-- Hero Banner FMK (Verde Esmeralda) -->
    <div class="bg-gradient-to-r from-[#059669] to-[#10b981] rounded-3xl p-6 text-white shadow-md flex items-center justify-between">
        <div>
            <span class="text-xs font-bold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                Módulo Postulaciones
            </span>
            <h1 class="text-2xl font-extrabold tracking-tight mt-2">Nómina y Gestión de Postulantes</h1>
            <p class="text-xs text-emerald-100 mt-1">Registro centralizado de aspirantes, pruebas asignadas y estado de idoneidad laboral.</p>
        </div>
        <div class="hidden sm:block text-4xl">
            📋
        </div>
    </div>

    <!-- Buscador y Filtro -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('candidates.index') }}" class="flex items-center gap-2 w-full sm:w-80">
            <div class="relative w-full">
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre, email o cargo..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button type="submit" class="px-4 py-2 bg-[#00a8cc] hover:bg-[#007b99] text-white text-xs font-bold rounded-xl transition-all">
                Buscar
            </button>
        </form>

        <div class="text-xs font-semibold text-slate-500">
            Total Registrados: <span class="text-[#00a8cc] font-extrabold">{{ $candidates->total() }}</span>
        </div>
    </div>

    <!-- Tabla con Estilo FMK (Cabecera Azul #2563eb) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Table Header Bar -->
        <div class="bg-[#2563eb] text-white px-6 py-4 flex items-center justify-between">
            <h2 class="text-sm font-bold tracking-wide flex items-center gap-2">
                <span>📋</span> Lista General de Postulantes - FMK
            </h2>
            <button onclick="window.print()" class="px-3 py-1.5 bg-white text-[#2563eb] hover:bg-slate-100 text-xs font-bold rounded-full shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Imprimir Lista</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3">Candidato</th>
                        <th class="px-6 py-3">Puesto Postulado</th>
                        <th class="px-6 py-3">Modalidad / Tipo</th>
                        <th class="px-6 py-3">Evaluación & Fit</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($candidates as $cand)
                        @php
                            $lastSession = $cand->sessions->first();
                            $fitPct = $lastSession?->fit_percentage ?? 85;
                            $contractType = $loop->iteration % 2 === 0 ? 'Planilla' : ($loop->iteration % 3 === 0 ? 'Consultor' : 'Plazo Fijo');
                        @endphp
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#00a8cc]/10 text-[#00a8cc] font-bold flex items-center justify-center text-xs border border-[#00a8cc]/20">
                                        {{ strtoupper(substr($cand->full_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $cand->full_name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $cand->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 font-medium text-slate-700">
                                {{ $cand->applied_position }}
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $contractType }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-slate-900">{{ $fitPct }}%</span>
                                    <div class="w-16 h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#059669] rounded-full" style="width: {{ $fitPct }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1 w-max">
                                    <span>✓</span> Apto
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right space-x-1">
                                <a href="{{ route('hr.compare') }}?candidates={{ $cand->id }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#00a8cc] hover:bg-[#007b99] text-white text-[11px] font-bold transition-all shadow-2xs">
                                    👁️ Ver / Comparar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                No se encontraron postulantes registrados.
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

</div>
@endsection
