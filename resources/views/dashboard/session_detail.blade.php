@extends('layouts.fmk')

@section('title', 'Reporte Detallado de Candidato - ' . $session->candidate->full_name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Volver al Panel General</span>
        </a>
        <span class="text-xs text-slate-400 font-medium">ID Sesión: #{{ $session->id }}</span>
    </div>

    <!-- Executive Summary Card (FMK Style) -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/90 shadow-2xs relative overflow-hidden space-y-4">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 text-[10px] font-semibold rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase tracking-wider">
                        {{ $session->evaluation->type }}
                    </span>
                    <span class="text-xs text-slate-400 font-normal">
                        &bull; Completado el {{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : 'N/A' }}
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">{{ $session->candidate->full_name }}</h1>
                <p class="text-xs text-slate-500">
                    Puesto: <strong class="text-slate-800">{{ $session->candidate->applied_position }}</strong> &bull; {{ $session->candidate->email }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <a href="{{ route('candidate.session.pdf', $session) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-all shadow-xs cursor-pointer">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Descargar PDF</span>
                </a>

                <!-- Fit Badge -->
                <div class="flex flex-col items-center justify-center p-3.5 rounded-xl bg-slate-50 border border-slate-200 min-w-[130px] shadow-2xs">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Adecuación</span>
                    <span class="text-2xl font-extrabold text-emerald-600 mt-0.5">{{ number_format($session->fit_percentage, 1) }}%</span>
                    <span class="text-[10px] text-slate-400 font-medium">Puntaje: {{ $session->raw_score }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Metrics Breakdown Card -->
    @php
        $metrics = $session->metrics_summary ?? [];
        $type = strtoupper($session->evaluation->type);
    @endphp

    @if($type === 'COGNITIVE')
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs text-center">
                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Nivel Cualitativo</span>
                <div class="text-xl font-bold text-slate-900 mt-2">{{ $metrics['qualitative_level'] ?? 'N/A' }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs text-center">
                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Aciertos Totales</span>
                <div class="text-xl font-bold text-emerald-600 mt-2">{{ $metrics['correct_answers'] ?? 0 }} / {{ $metrics['total_questions'] ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs text-center">
                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Precisión</span>
                <div class="text-xl font-bold text-amber-600 mt-2">{{ number_format($metrics['accuracy_percentage'] ?? 0, 1) }}%</div>
            </div>
        </div>
    @elseif($type === 'DISC' || $type === 'SITUATIONAL')
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-2xs space-y-6">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Perfil Conductual DISC Calculado</span>
            </h2>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 leading-relaxed font-normal">
                {{ $metrics['profile_description'] ?? 'No disponible' }}
            </div>

            <!-- DISC Dimension Bars -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $percentages = $metrics['trait_percentages'] ?? [];
                    $traitColors = [
                        'D' => ['bg' => 'bg-red-500', 'text' => 'text-red-600', 'name' => 'Dominancia (D)'],
                        'I' => ['bg' => 'bg-amber-500', 'text' => 'text-amber-600', 'name' => 'Influencia (I)'],
                        'S' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'name' => 'Serenidad / Estabilidad (S)'],
                        'C' => ['bg' => 'bg-indigo-500', 'text' => 'text-indigo-600', 'name' => 'Cumplimiento / Normativo (C)'],
                    ];
                @endphp

                @foreach(['D', 'I', 'S', 'C'] as $trait)
                    @php
                        $pct = $percentages[$trait] ?? 0;
                        $color = $traitColors[$trait];
                    @endphp
                    <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200/90 space-y-2">
                        <div class="flex justify-between items-center text-xs font-semibold">
                            <span class="{{ $color['text'] }}">{{ $color['name'] }}</span>
                            <span class="text-slate-900 font-bold">{{ number_format($pct, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                            <div class="{{ $color['bg'] }} h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Individual Answer Logs Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="bg-white text-slate-900 border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xs font-bold tracking-wide flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Desglose Respuesta por Respuesta</span>
            </h3>
            <span class="text-[11px] font-medium text-slate-500">Total: {{ count($session->answers) }} ítem(s)</span>
        </div>

        <div class="p-6 divide-y divide-slate-100 text-xs">
            @foreach($session->answers as $index => $answer)
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-slate-400 font-semibold text-[11px]">#{{ $index + 1 }}</span>
                        <span class="text-slate-800 font-medium">{{ $answer->question->question_text ?? 'Pregunta' }}</span>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-700 font-semibold border border-slate-200 text-[11px]">
                            Opción {{ $answer->selected_option }}
                        </span>
                        @if(!is_null($answer->is_correct))
                            @if($answer->is_correct)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200 text-[10px]">
                                    Correcta (+{{ $answer->score }})
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-700 font-semibold border border-red-200 text-[10px]">
                                    Incorrecta (0)
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
