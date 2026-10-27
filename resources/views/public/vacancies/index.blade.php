@extends('layouts.fmk')

@section('title', 'Convocatorias Laborales Abiertas - Fundación Munasim Kullakita')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto py-4">

    <!-- Public Hero Banner FMK -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#064e3b] via-[#059669] to-[#00a8cc] rounded-3xl p-8 sm:p-12 text-white shadow-xl">
        <div class="relative z-10 max-w-2xl space-y-3">
            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold px-3.5 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider backdrop-blur-xs">
                <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span>Oportunidades de Empleo • FMK</span>
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                Únete a Nuestro Equipo y Transforma Vidas
            </h1>
            <p class="text-sm sm:text-base text-emerald-100 font-medium leading-relaxed">
                Descubre las vacantes vigentes en Fundación Munasim Kullakita. Promovemos un proceso de selección transparente, ético e inclusivo basado en competencias y mérito profesional.
            </p>
        </div>

        <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none translate-x-10 translate-y-10">
            <svg class="w-96 h-96 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('public.vacancies.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <div class="sm:col-span-7">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Buscar por cargo, área o ubicación</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ej. Psicólogo, Trabajador Social, La Paz..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-medium">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Área Institucional</label>
                <select name="department" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-semibold">
                    <option value="">Todas las áreas</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ $department === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-grow py-2.5 bg-[#059669] hover:bg-[#047857] text-white font-bold rounded-xl text-xs shadow-xs hover:shadow-md transition-all cursor-pointer active:scale-95">
                    Buscar
                </button>
                @if($search || $department)
                    <a href="{{ route('public.vacancies.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Vacancies Grid -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span>Convocatorias Vigentes</span>
                <span class="text-xs font-bold px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-full border border-emerald-200">
                    {{ $vacancies->total() }} disponibles
                </span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vacancies as $vac)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group hover:-translate-y-1">
                    
                    <div class="space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-[#059669] border border-emerald-200 uppercase tracking-wider">
                                {{ $vac->department }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $vac->location }}</span>
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-[#059669] transition-colors leading-snug">
                                {{ $vac->title }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 mt-2 leading-relaxed">
                                {{ $vac->description ?: 'Fundación Munasim Kullakita convoca a profesionales calificados a postular a este cargo clave en nuestros programas psicosociales.' }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Modalidad</span>
                                <span class="font-bold text-slate-700">{{ $vac->contract_type }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Plazas</span>
                                <span class="font-bold text-slate-700">{{ $vac->openings_count }} vacante(s)</span>
                            </div>
                        </div>

                        @if($vac->salary_range)
                            <div class="bg-emerald-50/60 rounded-xl px-3 py-2 border border-emerald-100 flex items-center justify-between text-xs">
                                <span class="text-[11px] font-semibold text-emerald-800">Remuneración Referencial:</span>
                                <span class="font-extrabold text-[#059669]">{{ $vac->salary_range }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between gap-3">
                        <span class="text-[11px] text-slate-400 font-medium">
                            {{ $vac->closing_date ? 'Límite: ' . $vac->closing_date->format('d/m/Y') : 'Abierta hasta cubrir' }}
                        </span>

                        <a href="{{ route('public.vacancies.show', $vac) }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#00a8cc] hover:bg-[#007b99] text-white text-xs font-bold rounded-xl shadow-xs transition-all cursor-pointer">
                            <span>Ver y Postular</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-200">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">No hay convocatorias activas por el momento</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Vuelve a consultar periódicamente o sigue nuestras redes sociales para enterarte de nuevos requerimientos.</p>
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
