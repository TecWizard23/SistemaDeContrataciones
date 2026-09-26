@extends('layouts.fmk')

@section('title', 'Portal del Postulante - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Candidate Profile Hero Banner (FMK Azul/Índigo) -->
    <div class="bg-gradient-to-r from-[#5965db] to-[#4539a8] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl font-bold select-none pointer-events-none">
            ☀️
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
                <span class="text-xl">📋</span>
                Evaluaciones Asignadas
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
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    ✓ Completado
                                </span>
                            @elseif($status === 'IN_PROGRESS')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    ⏱ En Curso
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
                            <span class="flex items-center gap-1">
                                📝 {{ $evaluation->questions_count }} Preguntas
                            </span>
                            <span class="flex items-center gap-1">
                                ⏱ {{ $evaluation->time_limit_minutes }} Minutos
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
