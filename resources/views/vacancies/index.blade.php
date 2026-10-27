@extends('layouts.fmk')

@section('title', 'Gestión de Convocatorias y Vacantes - Fundación Munasim Kullakita')

@section('content')
<div x-data="{}" class="space-y-6">

    <!-- Hero Banner FMK -->
    <div class="bg-gradient-to-r from-[#00a8cc] via-[#059669] to-[#10b981] rounded-3xl p-6 sm:p-8 text-white shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="text-[11px] font-extrabold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                Módulo RRHH - Convocatorias
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Gestión de Convocatorias y Vacantes</h1>
            <p class="text-xs sm:text-sm text-emerald-100 font-medium max-w-xl leading-relaxed">
                Publica, administra y supervisa los requerimientos de talento humano para las diferentes áreas de la fundación.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button type="button" 
                    onclick="openQrModal({
                        title: 'Convocatorias Laborales Abiertas',
                        department: 'Fundación Munasim Kullakita',
                        location: 'La Paz / El Alto',
                        salary: 'Remuneración Competitiva',
                        contractType: 'Tiempo Completo / Consultor',
                        url: '{{ route('public.vacancies.index') }}'
                    })"
                    class="inline-flex items-center gap-2 px-4 py-3 bg-white/10 hover:bg-white/20 text-white font-extrabold rounded-2xl text-xs border border-white/30 backdrop-blur-xs shadow-xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <span>Kit QR General de Difusión</span>
            </button>

            <a href="{{ route('vacancies.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-3 bg-white text-[#059669] hover:bg-emerald-50 font-extrabold rounded-2xl text-xs shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all duration-200 cursor-pointer">
                <svg class="w-4 h-4 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Nueva Convocatoria</span>
            </a>
        </div>
    </div>

    <!-- KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Convocatorias Abiertas</p>
                <p class="text-3xl font-extrabold text-[#059669] mt-1">{{ $totalOpen }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Recibiendo postulaciones</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#059669] flex items-center justify-center border border-emerald-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">En Evaluación / Filtro</p>
                <p class="text-3xl font-extrabold text-[#f59e0b] mt-1">{{ $totalInReview }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Revisión de perfiles</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#f59e0b] flex items-center justify-center border border-amber-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Procesos Cerrados</p>
                <p class="text-3xl font-extrabold text-slate-600 mt-1">{{ $totalClosed }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Plazas cubiertas o finalizadas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center border border-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('vacancies.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <div class="sm:col-span-5">
                <label class="block text-xs font-bold text-slate-600 mb-1">Buscar Convocatoria</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Título, área, ubicación..." 
                           class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-medium">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label class="block text-xs font-bold text-slate-600 mb-1">Área / Departamento</label>
                <select name="department" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-semibold">
                    <option value="">Todas las áreas</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-1">Estado</label>
                <select name="status" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-semibold">
                    <option value="">Todos</option>
                    <option value="OPEN" {{ request('status') === 'OPEN' ? 'selected' : '' }}>Abierta</option>
                    <option value="IN_REVIEW" {{ request('status') === 'IN_REVIEW' ? 'selected' : '' }}>En Evaluación</option>
                    <option value="CLOSED" {{ request('status') === 'CLOSED' ? 'selected' : '' }}>Cerrada</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-grow py-2 bg-[#00a8cc] hover:bg-[#007b99] text-white font-bold rounded-xl text-xs shadow-xs transition-all cursor-pointer active:scale-95">
                    Filtrar
                </button>
                @if(request()->hasAny(['search', 'department', 'status']))
                    <a href="{{ route('vacancies.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Vacancies Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-[#2563eb] text-white px-6 py-4 flex items-center justify-between">
            <h2 class="text-sm font-bold tracking-wide flex items-center gap-2">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>Convocatorias Registradas</span>
            </h2>
            <span class="text-xs font-semibold px-3 py-1 bg-white/20 rounded-full border border-white/30">
                Total: {{ $vacancies->total() }} registro(s)
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-6">Puesto / Vacante</th>
                        <th class="py-3.5 px-6">Área & Ubicación</th>
                        <th class="py-3.5 px-6">Plazas & Salario</th>
                        <th class="py-3.5 px-6 text-center">Postulantes</th>
                        <th class="py-3.5 px-6">Estado</th>
                        <th class="py-3.5 px-6">Fecha Límite</th>
                        <th class="py-3.5 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($vacancies as $vac)
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $vac->title }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">{{ $vac->contract_type }}</div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800">{{ $vac->department }}</div>
                                <div class="text-slate-400 text-[11px] flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $vac->location }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $vac->openings_count }} vacante(s)</div>
                                <div class="text-[11px] text-[#059669] font-medium">{{ $vac->salary_range ?? 'A convenir' }}</div>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('candidates.index') }}?vacancy_id={{ $vac->id }}" 
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-extrabold {{ $vac->candidates_count > 0 ? 'bg-sky-100 text-[#00a8cc] hover:bg-sky-200' : 'bg-slate-100 text-slate-400' }} transition-colors">
                                    <span>{{ $vac->candidates_count ?? 0 }}</span>
                                    <span class="text-[10px] font-semibold">aspirantes</span>
                                </a>
                            </td>

                            <td class="py-4 px-6">
                                @if($vac->status === 'OPEN')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Abierta</span>
                                    </span>
                                @elseif($vac->status === 'IN_REVIEW')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>En Selección</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span>Cerrada</span>
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6">
                                <span class="font-medium text-slate-600">
                                    {{ $vac->closing_date ? $vac->closing_date->format('d/m/Y') : 'Sin fecha límite' }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <!-- QR & Social Media Kit Button -->
                                    <button type="button" 
                                            onclick="openQrModal({
                                                id: {{ $vac->id }},
                                                title: '{{ addslashes($vac->title) }}',
                                                department: '{{ addslashes($vac->department) }}',
                                                location: '{{ addslashes($vac->location) }}',
                                                salary: '{{ addslashes($vac->salary_range ?? '') }}',
                                                contractType: '{{ addslashes($vac->contract_type) }}',
                                                url: '{{ route('public.vacancies.show', $vac) }}'
                                            })"
                                            class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-[#059669] text-[#059669] hover:text-white font-extrabold text-xs border border-emerald-200 transition-all flex items-center gap-1 cursor-pointer shadow-2xs"
                                            title="Generar QR y Afiche de Redes">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                        <span>QR Redes</span>
                                    </button>

                                    <!-- Toggle Status Button -->
                                    <form action="{{ route('vacancies.toggle-status', $vac) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" title="{{ $vac->status === 'OPEN' ? 'Cerrar Convocatoria' : 'Abrir Convocatoria' }}"
                                                class="px-2.5 py-1.5 rounded-lg text-xs font-bold border transition-all cursor-pointer {{ $vac->status === 'OPEN' ? 'bg-amber-50 border-amber-200 text-amber-800 hover:bg-amber-100' : 'bg-emerald-50 border-emerald-200 text-emerald-800 hover:bg-emerald-100' }}">
                                            {{ $vac->status === 'OPEN' ? 'Pausar' : 'Activar' }}
                                        </button>
                                    </form>

                                    <!-- Edit Link -->
                                    <a href="{{ route('vacancies.edit', $vac) }}" 
                                       class="p-1.5 text-slate-400 hover:text-[#00a8cc] hover:bg-sky-50 rounded-lg transition-colors cursor-pointer" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('vacancies.destroy', $vac) }}" method="POST" onsubmit="return confirm('¿Confirmas que deseas eliminar esta convocatoria?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">
                                No se encontraron convocatorias con los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($vacancies->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $vacancies->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
