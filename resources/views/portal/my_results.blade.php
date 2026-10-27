@extends('layouts.fmk')

@section('title', 'Mis Resultados y Evaluaciones - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-12">

    <!-- Hero Banner FMK -->
    <div class="bg-gradient-to-r from-[#059669] via-[#047857] to-[#00a8cc] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
            <div class="space-y-1">
                <span class="text-[11px] font-extrabold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                    Historial de Evaluación
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-1">Mis Resultados y Desempeño</h1>
                <p class="text-xs sm:text-sm text-emerald-100 font-medium max-w-xl">
                    Revisa el estado de tus pruebas completadas, tu nivel de ajuste global y los perfiles evaluados.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('portal.index') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white text-[#059669] hover:bg-emerald-50 text-xs font-extrabold rounded-full shadow-xs transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Volver a Mis Pruebas</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pruebas Rendidas</p>
                <p class="text-3xl font-extrabold text-[#059669] mt-1">{{ $completedSessions->count() }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Exámenes completados</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#059669] flex items-center justify-center border border-emerald-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ajuste Global Promedio</p>
                <p class="text-3xl font-extrabold text-[#00a8cc] mt-1">{{ $overallFit }}%</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Adecuación al perfil</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-[#00a8cc] flex items-center justify-center border border-sky-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Etapa del Proceso</p>
                <p class="text-lg font-extrabold text-slate-800 mt-1 uppercase">{{ $candidate->hiring_stage }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">En supervisión por RRHH</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Completed Assessments List -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Detalle de Pruebas Rendidas</h2>
                <p class="text-xs text-slate-500 mt-0.5">Puntajes y constancias de entrega de tus exámenes psicotécnicos.</p>
            </div>
            <span class="text-xs font-extrabold text-slate-400">{{ $completedSessions->count() }} completada(s)</span>
        </div>

        <div class="space-y-4">
            @forelse($completedSessions as $session)
                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50 hover:border-slate-300 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                                {{ $session->evaluation->type }}
                            </span>
                            <span class="text-xs font-bold text-slate-400">
                                Rendido el {{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : 'Reciente' }}
                            </span>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-900">{{ $session->evaluation->title }}</h3>
                        <p class="text-xs text-slate-500 font-medium">
                            Puntaje Obtenido: <strong class="text-slate-900">{{ $session->raw_score ?? 0 }} pts</strong>
                        </p>
                    </div>

                    <div class="flex items-center gap-4 flex-shrink-0">
                        <div class="text-right">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Ajuste de Perfil</span>
                            <span class="text-lg font-black text-[#059669]">{{ $session->fit_percentage }}%</span>
                        </div>

                        <a href="{{ route('exam.completed', $session) }}" 
                           class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold shadow-2xs transition-colors flex items-center gap-1.5">
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
