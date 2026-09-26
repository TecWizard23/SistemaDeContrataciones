@extends('layouts.fmk')

@section('title', 'Reporte Detallado de Candidato - ' . $session->candidate->full_name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#00a8cc] hover:text-[#007b99] transition-colors">
            <span>&larr;</span>
            <span>Volver al Panel General</span>
        </a>
        <span class="text-xs text-slate-400 font-semibold">ID Sesión: #{{ $session->id }}</span>
    </div>

    <!-- Executive Summary Card (FMK Style) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md relative overflow-hidden space-y-4">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-sky-50 text-[#00a8cc] border border-sky-200 uppercase tracking-wider">
                        {{ $session->evaluation->type }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">
                        &bull; Completado el {{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : 'N/A' }}
                    </span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $session->candidate->full_name }}</h1>
                <p class="text-xs text-slate-500">
                    Puesto: <strong class="text-slate-800">{{ $session->candidate->applied_position }}</strong> &bull; {{ $session->candidate->email }}
                </p>
            </div>

            <!-- Fit Badge -->
            <div class="flex flex-col items-center justify-center p-5 rounded-2xl bg-slate-50 border border-slate-200 min-w-[160px] shadow-2xs">
                <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Adecuación (Fit)</span>
                <span class="text-3xl font-black text-[#059669] mt-1">{{ number_format($session->fit_percentage, 1) }}%</span>
                <span class="text-[10px] text-slate-400 font-medium mt-0.5">Puntaje Bruto: {{ $session->raw_score }}</span>
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
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs text-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nivel Cualitativo</span>
                <div class="text-2xl font-extrabold text-[#2563eb] mt-2">{{ $metrics['qualitative_level'] ?? 'N/A' }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs text-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Aciertos Totales</span>
                <div class="text-2xl font-extrabold text-[#059669] mt-2">{{ $metrics['correct_answers'] ?? 0 }} / {{ $metrics['total_questions'] ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs text-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Precisión</span>
                <div class="text-2xl font-extrabold text-[#f59e0b] mt-2">{{ number_format($metrics['accuracy_percentage'] ?? 0, 1) }}%</div>
            </div>
        </div>
    @elseif($type === 'DISC' || $type === 'SITUATIONAL')
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-6">
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span class="text-xl">📊</span>
                Perfil Conductual DISC Calculado
            </h2>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 leading-relaxed font-medium">
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
                        'C' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'name' => 'Cumplimiento / Normativo (C)'],
                    ];
                @endphp

                @foreach(['D', 'I', 'S', 'C'] as $trait)
                    @php
                        $pct = $percentages[$trait] ?? 0;
                        $color = $traitColors[$trait];
                    @endphp
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="{{ $color['text'] }}">{{ $color['name'] }}</span>
                            <span class="text-slate-900">{{ number_format($pct, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                            <div class="{{ $color['bg'] }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Individual Answer Logs Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-[#2563eb] text-white px-6 py-4 flex items-center justify-between">
            <h3 class="text-xs font-bold tracking-wide flex items-center gap-2">
                <span>📝</span> Desglose Respuesta por Respuesta
            </h3>
            <span class="text-[11px] font-semibold opacity-90">Total: {{ count($session->answers) }} ítem(s)</span>
        </div>

        <div class="p-6 divide-y divide-slate-100 text-xs">
            @foreach($session->answers as $index => $answer)
                <div class="py-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-slate-400 font-bold">#{{ $index + 1 }}</span>
                        <span class="text-slate-800 font-semibold">{{ $answer->question->question_text ?? 'Pregunta' }}</span>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-bold border border-slate-200 text-[11px]">
                            Opción {{ $answer->selected_option }}
                        </span>
                        @if(!is_null($answer->is_correct))
                            @if($answer->is_correct)
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold border border-emerald-200 text-[10px]">
                                    Correcta (+{{ $answer->score }})
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 font-bold border border-red-200 text-[10px]">
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
