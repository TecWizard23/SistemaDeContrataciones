@extends('layouts.fmk')

@section('title', 'Mis Resultados y Evaluaciones - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-12">

    <!-- Executive Hero Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-2xl p-6 sm:p-8 text-white border border-slate-800 shadow-sm relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
            <div class="space-y-1">
                <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold px-2.5 py-0.5 bg-indigo-500/20 text-indigo-200 rounded-full border border-indigo-400/30 uppercase tracking-wider">
                    Historial de Selección
                </span>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white mt-1">Mis Resultados y Desempeño</h1>
                <p class="text-xs sm:text-sm text-slate-300 font-normal max-w-xl">
                    Revisa el estado de tus pruebas psicotécnicas completadas y constancias de entrega emitidas.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('portal.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-xl border border-white/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Volver a Mis Pruebas</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards (Clean Executive Standard) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Pruebas Rendidas</p>
                <p class="text-2xl font-bold text-slate-900">{{ $completedSessions->count() }}</p>
                <p class="text-[11px] text-slate-400">Exámenes completados</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Ajuste Global Promedio</p>
                <p class="text-2xl font-bold text-slate-900">{{ $overallFit }}%</p>
                <p class="text-[11px] text-slate-400">Adecuación al perfil</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Etapa del Proceso</p>
                <p class="text-base font-bold text-slate-900 uppercase tracking-wide">{{ $candidate->hiring_stage }}</p>
                <p class="text-[11px] text-slate-400">Revisión por RRHH</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Completed Assessments List -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Detalle de Pruebas Rendidas</h2>
                <p class="text-xs text-slate-400 mt-0.5">Puntajes y constancias de entrega de tus exámenes psicotécnicos.</p>
            </div>
            <span class="text-xs font-semibold text-slate-500">{{ $completedSessions->count() }} completada(s)</span>
        </div>

        <div class="space-y-3">
            @forelse($completedSessions as $session)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-slate-50 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $session->evaluation->type }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">
                                Rendido el {{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : 'Reciente' }}
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">{{ $session->evaluation->title }}</h3>
                        <p class="text-xs text-slate-500 font-normal">
                            Puntaje Obtenido: <strong class="text-slate-900">{{ $session->raw_score ?? 0 }} pts</strong>
                        </p>
                    </div>

                    <div class="flex items-center gap-4 flex-shrink-0">
                        <div class="text-right">
                            <span class="text-[10px] font-medium text-slate-400 uppercase block">Ajuste de Perfil</span>
                            <span class="text-lg font-bold text-emerald-600">{{ $session->fit_percentage }}%</span>
                        </div>

                        <a href="{{ route('exam.completed', $session) }}" 
                           class="px-3.5 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold shadow-2xs transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>Constancia</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 text-xs">
                    Aún no has completado ninguna evaluación asignada.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
