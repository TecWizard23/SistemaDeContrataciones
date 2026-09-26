@extends('layouts.app')

@section('title', 'Resultados de Evaluación - ' . $session->candidate->full_name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Card -->
    <div class="bg-slate-800/90 border border-slate-700 rounded-2xl p-6 shadow-xl relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 uppercase tracking-wider">
                        Completado
                    </span>
                    <span class="text-xs text-slate-400">&bull; {{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : '' }}</span>
                </div>
                <h1 class="text-2xl font-extrabold text-white">{{ $session->evaluation->title }}</h1>
                <p class="text-sm text-slate-300 mt-1">
                    Candidato: <strong class="text-white">{{ $session->candidate->full_name }}</strong> &bull; {{ $session->candidate->applied_position }}
                </p>
            </div>

            <!-- Fit Percentage Gauge Badge -->
            <div class="flex flex-col items-center justify-center p-4 rounded-2xl bg-slate-900 border border-slate-700 min-w-[140px]">
                <span class="text-xs text-slate-400 font-medium">Índice de Fit / Adecuación</span>
                <span class="text-3xl font-extrabold text-emerald-400 mt-1">{{ number_format($session->fit_percentage, 1) }}%</span>
                <span class="text-[10px] text-slate-500 mt-0.5">Puntaje Raw: {{ $session->raw_score }}</span>
            </div>
        </div>
    </div>

    <!-- Strategy Metrics Breakdown -->
    @php
        $metrics = $session->metrics_summary ?? [];
        $type = strtoupper($session->evaluation->type);
    @endphp

    @if($type === 'COGNITIVE')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-5 text-center">
                <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Nivel Cualitativo</div>
                <div class="text-2xl font-bold text-indigo-400 mt-2">
                    {{ $metrics['qualitative_level'] ?? 'N/A' }}
                </div>
            </div>

            <div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-5 text-center">
                <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Aciertos</div>
                <div class="text-2xl font-bold text-emerald-400 mt-2">
                    {{ $metrics['correct_answers'] ?? 0 }} / {{ $metrics['total_questions'] ?? 0 }}
                </div>
            </div>

            <div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-5 text-center">
                <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Porcentaje de Precisión</div>
                <div class="text-2xl font-bold text-amber-400 mt-2">
                    {{ number_format($metrics['accuracy_percentage'] ?? 0, 1) }}%
                </div>
            </div>
        </div>
    @elseif($type === 'DISC' || $type === 'SITUATIONAL')
        <div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-6 space-y-6">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Perfil Conductual DISC Resumido
            </h2>

            <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-700/70 text-sm text-slate-200 leading-relaxed">
                {{ $metrics['profile_description'] ?? 'No disponible' }}
            </div>

            <!-- Trait Breakdown Bars -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $percentages = $metrics['trait_percentages'] ?? [];
                    $traitColors = [
                        'D' => ['bg' => 'bg-red-500', 'text' => 'text-red-400', 'name' => 'Dominancia (D)'],
                        'I' => ['bg' => 'bg-amber-500', 'text' => 'text-amber-400', 'name' => 'Influencia (I)'],
                        'S' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-400', 'name' => 'Serenidad / Estabilidad (S)'],
                        'C' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-400', 'name' => 'Cumplimiento / Normativo (C)'],
                    ];
                @endphp

                @foreach(['D', 'I', 'S', 'C'] as $trait)
                    @php
                        $pct = $percentages[$trait] ?? 0;
                        $color = $traitColors[$trait];
                    @endphp
                    <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-700/50 space-y-2">
                        <div class="flex justify-between items-center text-xs font-semibold">
                            <span class="{{ $color['text'] }}">{{ $color['name'] }}</span>
                            <span class="text-white">{{ number_format($pct, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-800 rounded-full h-2.5 overflow-hidden">
                            <div class="{{ $color['bg'] }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Question Answers Summary -->
    <div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-6 space-y-4">
        <h3 class="text-md font-bold text-white">Detalle de Respuestas Registradas</h3>

        <div class="divide-y divide-slate-700/50">
            @foreach($session->answers as $index => $answer)
                <div class="py-3 flex items-center justify-between text-sm">
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-400 font-bold">#{{ $index + 1 }}</span>
                        <span class="text-slate-200">{{ $answer->question->question_text ?? 'Pregunta' }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-1 rounded-md bg-slate-700 text-slate-200 text-xs font-bold">
                            Opción {{ $answer->selected_option }}
                        </span>
                        @if(!is_null($answer->is_correct))
                            @if($answer->is_correct)
                                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 text-xs font-semibold">Correcta</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-red-500/20 text-red-400 text-xs font-semibold">Incorrecta</span>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="flex justify-end gap-4">
        <a href="{{ route('dashboard.index') }}" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-200 font-semibold rounded-xl text-sm transition-colors">
            Volver al Dashboard
        </a>
    </div>
</div>
@endsection
