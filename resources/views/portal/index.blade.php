@extends('layouts.fmk')

@section('title', 'Portal del Postulante - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Candidate Profile Hero Banner (FMK Azul/Índigo) -->
    <div class="bg-gradient-to-r from-[#5965db] to-[#4539a8] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white select-none pointer-events-none">
            <svg class="w-48 h-48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white font-black text-2xl border border-white/30 shadow-inner">
                    {{ strtoupper(substr($candidate->full_name, 0, 1)) }}
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl font-extrabold text-white tracking-tight">{{ $candidate->full_name }}</h1>
                        <span class="px-3 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-400 text-slate-900 uppercase tracking-wider">
                            Postulante Activo
                        </span>
                    </div>
                    <p class="text-xs text-indigo-100">
                        Puesto: <strong class="text-white">{{ $candidate->applied_position }}</strong>
                    </p>
                    <div class="text-[11px] text-indigo-200">
                        {{ $candidate->email }} @if($candidate->phone) &bull; {{ $candidate->phone }} @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Evaluations Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#00a8cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Evaluaciones Asignadas</span>
            </h2>
            <span class="text-xs text-slate-400 font-semibold">Completa todas las pruebas requeridas</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($evaluations as $evaluation)
                @php
                    $session = $sessions->get($evaluation->id);
                    $status = $session ? $session->status : 'PENDING';
                @endphp

                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-sky-50 text-[#00a8cc] border border-sky-200 uppercase tracking-wider">
                                {{ $evaluation->type }}
                            </span>
                            
                            <!-- Status Badge -->
                            @if($status === 'COMPLETED')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Completado</span>
                                </span>
                            @elseif($status === 'IN_PROGRESS')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>En Curso</span>
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                    Pendiente
                                </span>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $evaluation->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-medium">{{ $evaluation->description }}</p>

                        <div class="flex items-center gap-4 text-xs text-slate-500 font-semibold pt-1">
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
                               class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition-colors flex items-center justify-center gap-2">
                                <span>Ver Confirmación de Entrega</span>
                                <span>&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('exam.show', $evaluation) }}" 
                               class="w-full py-3 bg-[#00a8cc] hover:bg-[#007b99] text-white font-extrabold rounded-xl text-xs shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <span>{{ $status === 'IN_PROGRESS' ? 'Continuar Evaluación' : 'Rendir Examen' }}</span>
                                <span>&rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
