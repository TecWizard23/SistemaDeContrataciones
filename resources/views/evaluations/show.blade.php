@extends('layouts.fmk')

@section('title', 'Detalle de Evaluación - ' . $evaluation->title)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Banner FMK -->
    <div class="bg-gradient-to-r from-[#00a8cc] to-[#059669] rounded-3xl p-6 sm:p-8 text-white shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-xs font-extrabold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                    {{ $evaluation->type }}
                </span>
                <span class="text-xs text-sky-100 font-semibold">ID #{{ $evaluation->id }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $evaluation->title }}</h1>
            <p class="text-xs sm:text-sm text-sky-100 font-medium max-w-xl">
                {{ $evaluation->description ?? 'Sin descripción adicional registrada.' }}
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('evaluations-manage.edit', $evaluation) }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white text-[#00a8cc] hover:bg-sky-50 text-xs font-extrabold rounded-full shadow-xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-[#00a8cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span>Editar Examen</span>
            </a>

            <a href="{{ route('evaluations-manage.index') }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white text-xs font-extrabold rounded-full border border-white/30 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Volver</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total de Preguntas</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $totalQuestions }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-[#00a8cc] flex items-center justify-center border border-sky-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tiempo Límite</p>
                <p class="text-2xl font-black text-[#f59e0b] mt-1">{{ $evaluation->time_limit_minutes }} min</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sesiones Rendidas</p>
                <p class="text-2xl font-black text-[#059669] mt-1">{{ $evaluation->candidateSessions->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#059669] flex items-center justify-center border border-emerald-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Questions Detailed List -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#00a8cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Preguntas del Examen ({{ $evaluation->questions->count() }})</span>
            </h2>
            <span class="text-xs font-semibold text-slate-500">Puntaje Máximo: {{ $totalPoints }} pts</span>
        </div>

        <div class="space-y-6">
            @forelse($evaluation->questions as $index => $q)
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-[#00a8cc] text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-bold text-slate-700">Puntos: {{ $q->points ?? 1 }}</span>
                        </div>
                        @if($q->correct_option)
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Clave Correcta: {{ $q->correct_option }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-sm font-bold text-slate-900 leading-snug">
                        {{ $q->question_text }}
                    </h3>

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        @if(is_array($q->options))
                            @foreach($q->options as $opt)
                                @php
                                    $isCorrect = (strtoupper($opt['key'] ?? '') === strtoupper($q->correct_option ?? ''));
                                @endphp
                                <div class="p-3 rounded-xl border flex items-center justify-between text-xs font-medium {{ $isCorrect ? 'bg-emerald-50 border-emerald-300 text-emerald-900 font-bold' : 'bg-white border-slate-200 text-slate-700' }}">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-bold border border-slate-200">
                                            {{ $opt['key'] ?? '-' }}
                                        </span>
                                        <span>{{ $opt['text'] ?? '' }}</span>
                                    </div>
                                    @if(!empty($opt['trait']))
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-900 rounded border border-amber-200 text-[10px] font-bold">
                                            Rasgo: {{ $opt['trait'] }}
                                        </span>
                                    @endif
                                    @if($isCorrect)
                                        <span class="text-emerald-600 font-extrabold text-xs">Correcta</span>
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
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4">
        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Postulantes que rindieron esta prueba ({{ $evaluation->candidateSessions->count() }})</span>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
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
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 font-bold text-slate-900">
                                {{ $session->candidate->full_name ?? 'Candidato' }}
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $session->candidate->applied_position ?? '-' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $session->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $session->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-extrabold text-slate-900">
                                {{ $session->fit_percentage ?? 0 }}%
                            </td>
                            <td class="py-3 px-4 text-slate-400">
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
