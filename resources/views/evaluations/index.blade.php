@extends('layouts.fmk')

@section('title', 'Banco de Evaluaciones Psicométricas - Fundación Munasim Kullakita')

@section('content')
<div class="space-y-6">

    <!-- Hero Banner Verde Esmeralda FMK -->
    <div class="bg-gradient-to-r from-[#059669] to-[#10b981] rounded-3xl p-6 sm:p-8 text-white shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="text-xs font-extrabold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                Módulo RRHH - Munasim Kullakita
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Banco de Evaluaciones Psicométricas</h1>
            <p class="text-xs sm:text-sm text-emerald-100 font-medium max-w-xl">
                Crea, administra y configura las pruebas de aptitud cognitiva, razonamiento lógico y perfiles conductuales DISC.
            </p>
        </div>

        <div>
            <a href="{{ route('evaluations-manage.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-3 bg-white text-[#059669] hover:bg-emerald-50 font-extrabold rounded-2xl text-xs shadow-md transition-all cursor-pointer">
                <svg class="w-4 h-4 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Nueva Evaluación</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards (No Emojis) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Evaluaciones</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">{{ $evaluations->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#059669] flex items-center justify-center border border-emerald-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pruebas Cognitivas</p>
                <p class="text-3xl font-extrabold text-sky-600 mt-1">{{ $evaluations->where('type', 'COGNITIVE')->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-[#00a8cc] flex items-center justify-center border border-sky-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perfiles DISC / Conductual</p>
                <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ $evaluations->where('type', 'DISC')->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Evaluations Grid FMK Style -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($evaluations as $evaluation)
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-5">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-sky-50 text-[#00a8cc] border border-sky-200 uppercase tracking-wider">
                            {{ $evaluation->type }}
                        </span>
                        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                            {{ $evaluation->questions_count }} Pregunta(s)
                        </span>
                    </div>

                    <h2 class="text-lg font-bold text-slate-900 leading-snug">{{ $evaluation->title }}</h2>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ $evaluation->description }}</p>

                    <div class="flex items-center gap-4 text-xs text-slate-600 font-semibold pt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 rounded-lg border border-amber-200">
                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Límite: <strong>{{ $evaluation->time_limit_minutes }} min</strong></span>
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400 font-semibold">ID #{{ $evaluation->id }}</span>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('evaluations-manage.show', $evaluation) }}" 
                           class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                            Ver Preguntas
                        </a>

                        <a href="{{ route('evaluations-manage.edit', $evaluation) }}" 
                           class="px-3 py-1.5 bg-sky-50 text-[#00a8cc] hover:bg-sky-100 border border-sky-200 rounded-xl text-xs font-bold transition-colors">
                            Editar
                        </a>

                        <form action="{{ route('evaluations-manage.destroy', $evaluation) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta evaluación?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 rounded-xl text-xs font-bold transition-colors cursor-pointer">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white border border-slate-200 rounded-3xl p-10 text-center text-slate-500 text-sm font-medium">
                No hay evaluaciones registradas aún. ¡Crea la primera usando el botón superior!
            </div>
        @endforelse
    </div>
</div>
@endsection
