@extends('layouts.fmk')

@section('title', 'Convocatorias Laborales Abiertas - Fundación Munasim Kullakita')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto py-2">

    <!-- Public Hero Banner (Executive Dark Slate & Indigo) -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-2xl p-8 sm:p-12 text-white border border-slate-800 shadow-sm">
        <div class="relative z-10 max-w-2xl space-y-3">
            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-3 py-1 bg-indigo-500/20 text-indigo-200 rounded-full border border-indigo-400/30 uppercase tracking-wider">
                <svg class="w-3.5 h-3.5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Oportunidades de Empleo • FMK</span>
            </span>
            <h1 class="text-2xl sm:text-4xl font-bold tracking-tight text-white leading-tight">
                Únete a Nuestro Equipo y Transforma Vidas
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 font-normal leading-relaxed">
                Descubre las convocatorias vigentes en Fundación Munasim Kullakita. Promovemos un proceso de selección transparente, ético y basado en competencias laborales.
            </p>
        </div>

        <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none translate-x-10 translate-y-10">
            <svg class="w-96 h-96 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs">
        <form method="GET" action="{{ route('public.vacancies.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <div class="sm:col-span-7">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Buscar por cargo, área o ubicación</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ej. Psicólogo, Trabajador Social, La Paz..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-normal">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Área Institucional</label>
                <select name="department" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-medium">
                    <option value="">Todas las áreas</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ $department === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-grow py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl text-xs shadow-xs transition-all cursor-pointer">
                    Buscar
                </button>
                @if($search || $department)
                    <a href="{{ route('public.vacancies.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-all">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Vacancies Grid -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span>Convocatorias Vigentes</span>
                <span class="text-[11px] font-semibold px-2.5 py-0.5 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
                    {{ $vacancies->total() }} disponibles
                </span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vacancies as $vac)
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs hover:shadow-xs hover:border-slate-300 transition-all flex flex-col justify-between group">
                    
                    <div class="space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase tracking-wider">
                                {{ $vac->department }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $vac->location }}</span>
                            </span>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors leading-snug">
                                {{ $vac->title }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 mt-2 leading-relaxed font-normal">
                                {{ $vac->description ?: 'Fundación Munasim Kullakita convoca a profesionales calificados a postular a este cargo clave en nuestros programas psicosociales.' }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider block">Modalidad</span>
                                <span class="font-semibold text-slate-700">{{ $vac->contract_type }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider block">Plazas</span>
                                <span class="font-semibold text-slate-700">{{ $vac->openings_count }} vacante(s)</span>
                            </div>
                        </div>

                        @if($vac->salary_range)
                            <div class="bg-slate-50 rounded-xl px-3 py-2 border border-slate-200/80 flex items-center justify-between text-xs">
                                <span class="text-[11px] font-medium text-slate-600">Remuneración:</span>
                                <span class="font-bold text-slate-900">{{ $vac->salary_range }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between gap-3">
                        <span class="text-[11px] text-slate-400 font-medium">
                            {{ $vac->closing_date ? 'Límite: ' . $vac->closing_date->format('d/m/Y') : 'Abierta hasta cubrir' }}
                        </span>

                        <a href="{{ route('public.vacancies.show', $vac) }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-xs transition-all cursor-pointer">
                            <span>Ver y Postular</span>
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">No hay convocatorias activas en este momento</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Vuelve a consultar periódicamente para enterarte de nuevos requerimientos de contratación.</p>
                </div>
            @endforelse
        </div>

        @if($vacancies->hasPages())
            <div class="mt-8">
                {{ $vacancies->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
