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

    <!-- Evaluations Grid FMK Style -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($evaluations as $evaluation)
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
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
                            <span>⏱</span> Límite: <strong>{{ $evaluation->time_limit_minutes }} min</strong>
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400 font-semibold">ID Evaluación: #{{ $evaluation->id }}</span>

                    <form action="{{ route('evaluations-manage.destroy', $evaluation) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta evaluación?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3.5 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 rounded-xl text-xs font-bold transition-colors cursor-pointer">
                            Eliminar
                        </button>
                    </form>
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
