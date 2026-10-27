@extends('layouts.fmk')

@section('title', 'Portal del Postulante - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Candidate Profile Hero Banner (Executive Dark Slate & Indigo) -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-2xl p-6 sm:p-8 text-white border border-slate-800 shadow-sm relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white font-extrabold text-2xl border border-white/20 shadow-xs">
                    {{ strtoupper(substr($candidate->full_name, 0, 1)) }}
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">{{ $candidate->full_name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 uppercase tracking-wider">
                            Postulante Activo
                        </span>
                    </div>
                    <p class="text-xs text-slate-300">
                        Postulación: <strong class="text-white">{{ $candidate->applied_position }}</strong>
                    </p>
                    <div class="text-[11px] text-slate-400">
                        {{ $candidate->email }} @if($candidate->phone) &bull; {{ $candidate->phone }} @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('portal.profile') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-xl text-xs font-semibold shadow-xs transition-all">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Editar Mi Perfil</span>
                </a>
                <a href="{{ route('portal.my-results') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-xs transition-all">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Ver Mis Resultados</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Assigned Evaluations Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between pb-1 border-b border-slate-200">
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Evaluaciones Asignadas</span>
            </h2>
            <span class="text-xs text-slate-500 font-medium">Completa las pruebas psicométricas requeridas para tu postulación</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($evaluations as $evaluation)
                @php
                    $session = $sessions->get($evaluation->id);
                    $status = $session ? $session->status : 'PENDING';
                @endphp

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs hover:border-slate-300 transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase tracking-wider">
                                {{ $evaluation->type }}
                            </span>
                            
                            <!-- Status Badge -->
                            @if($status === 'COMPLETED')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Completado</span>
                                </span>
                            @elseif($status === 'IN_PROGRESS')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>En Curso</span>
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                    Pendiente
                                </span>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $evaluation->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-normal">{{ $evaluation->description }}</p>

                        <div class="flex items-center gap-4 text-xs text-slate-500 font-medium pt-1">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span>{{ $evaluation->questions_count }} Preguntas</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $evaluation->time_limit_minutes }} Minutos</span>
                            </span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        @if($status === 'COMPLETED')
                            <a href="{{ route('exam.completed', $session) }}" 
                               class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition-colors flex items-center justify-center gap-2">
                                <span>Ver Confirmación de Entrega</span>
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('exam.show', $evaluation) }}" 
                               class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <span>{{ $status === 'IN_PROGRESS' ? 'Continuar Evaluación' : 'Rendir Examen' }}</span>
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
