@extends('layouts.fmk')

@section('title', 'Detalle de Evaluación - ' . $evaluation->title)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Banner Executive Dark Slate -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-2xl p-6 sm:p-8 text-white border border-slate-800 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-semibold px-2.5 py-0.5 bg-indigo-500/20 text-indigo-200 rounded-full border border-indigo-400/30 uppercase tracking-wider">
                    {{ $evaluation->type }}
                </span>
                <span class="text-xs text-slate-300 font-medium">ID #{{ $evaluation->id }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">{{ $evaluation->title }}</h1>
            <p class="text-xs sm:text-sm text-slate-300 font-normal max-w-xl">
                {{ $evaluation->description ?? 'Sin descripción adicional registrada.' }}
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('evaluations-manage.edit', $evaluation) }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl shadow-xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span>Editar Examen</span>
            </a>

            <a href="{{ route('evaluations-manage.index') }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-xl border border-white/20 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Volver</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards (Clean Executive Standard) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Total de Preguntas</p>
                <p class="text-2xl font-bold text-slate-900">{{ $totalQuestions }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Tiempo Límite</p>
                <p class="text-2xl font-bold text-slate-900">{{ $evaluation->time_limit_minutes }} min</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Sesiones Rendidas</p>
                <p class="text-2xl font-bold text-slate-900">{{ $evaluation->candidateSessions->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Questions Detailed List -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/90 shadow-2xs space-y-6">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Preguntas del Examen ({{ $evaluation->questions->count() }})</span>
            </h2>
            <span class="text-xs font-semibold text-slate-500">Puntaje Máximo: {{ $totalPoints }} pts</span>
        </div>

        <div class="space-y-4">
            @forelse($evaluation->questions as $index => $q)
                <div class="bg-slate-50/70 border border-slate-200/90 rounded-xl p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-semibold text-slate-700">Puntos: {{ $q->points ?? 1 }}</span>
                        </div>
                        @if($q->correct_option)
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Clave Correcta: {{ $q->correct_option }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xs font-bold text-slate-900 leading-snug">
                        {{ $q->question_text }}
                    </h3>

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                        @if(is_array($q->options))
                            @foreach($q->options as $opt)
                                @php
                                    $isCorrect = (strtoupper($opt['key'] ?? '') === strtoupper($q->correct_option ?? ''));
                                @endphp
                                <div class="p-3 rounded-xl border flex items-center justify-between text-xs font-medium {{ $isCorrect ? 'bg-emerald-50 border-emerald-300 text-emerald-900 font-bold' : 'bg-white border-slate-200 text-slate-700' }}">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-5 h-5 rounded-md bg-slate-100 text-slate-700 flex items-center justify-center text-[11px] font-bold border border-slate-200">
                                            {{ $opt['key'] ?? '-' }}
                                        </span>
                                        <span>{{ $opt['text'] ?? '' }}</span>
                                    </div>
                                    @if(!empty($opt['trait']))
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-900 rounded border border-amber-200 text-[10px] font-semibold">
                                            Rasgo: {{ $opt['trait'] }}
                                        </span>
                                    @endif
                                    @if($isCorrect)
                                        <span class="text-emerald-700 font-bold text-xs">Correcta</span>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 text-xs">
                    Esta evaluación aún no tiene preguntas configuradas.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Candidate Sessions History -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/90 shadow-2xs space-y-4">
        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Postulantes que rindieron esta prueba ({{ $evaluation->candidateSessions->count() }})</span>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-white text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Postulante</th>
                        <th class="py-3 px-4">Puesto</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4">Ajuste / Fit</th>
                        <th class="py-3 px-4">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($evaluation->candidateSessions as $session)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4 font-bold text-slate-900">
                                {{ $session->candidate->full_name ?? 'Candidato' }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 font-normal">
                                {{ $session->candidate->applied_position ?? '-' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $session->status === 'COMPLETED' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                    {{ $session->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-900">
                                {{ $session->fit_percentage ?? 0 }}%
                            </td>
                            <td class="py-3 px-4 text-slate-400 font-normal">
                                {{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">
                                Ningún postulante ha completado esta evaluación todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
