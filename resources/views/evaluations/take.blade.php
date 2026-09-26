@extends('layouts.app')

@section('title', $evaluation->title . ' - Evaluación')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Assessment Header Card -->
    <div class="bg-slate-800/80 border border-slate-700/60 rounded-2xl p-6 shadow-xl backdrop-blur-sm relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-brand-500/20 text-brand-300 border border-brand-500/40 uppercase tracking-wider">
                        {{ $evaluation->type }}
                    </span>
                    <span class="text-xs text-slate-400">&bull; {{ $questions->count() }} Preguntas</span>
                </div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">{{ $evaluation->title }}</h1>
                <p class="text-sm text-slate-400 mt-1">Candidato: <strong class="text-slate-200">{{ $candidate->full_name }}</strong> ({{ $candidate->applied_position }})</p>
            </div>

            <!-- Timer Box -->
            @if($evaluation->time_limit_minutes)
            <div class="bg-slate-900/90 border border-slate-700/80 rounded-xl p-4 flex items-center gap-3 shadow-inner">
                <div class="w-10 h-10 rounded-lg bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400 animate-pulse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Tiempo Restante</div>
                    <div id="timer" class="text-xl font-bold font-mono text-amber-300 tracking-wider">--:--</div>
                </div>
            </div>
            @endif
        </div>

        @if($evaluation->description)
            <div class="mt-4 pt-4 border-t border-slate-700/50 text-sm text-slate-300 leading-relaxed">
                {{ $evaluation->description }}
            </div>
        @endif
    </div>

    <!-- Exam Form -->
    <form id="evaluationForm" action="{{ route('sessions.submit', $session) }}" method="POST" class="space-y-6">
        @csrf

        @foreach($questions as $index => $question)
        <div class="bg-slate-800/50 border border-slate-700/60 rounded-2xl p-6 shadow-lg hover:border-slate-600 transition-colors">
            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-xl bg-slate-700 text-slate-200 flex items-center justify-center font-bold text-sm flex-shrink-0 shadow">
                    {{ $index + 1 }}
                </span>
                <div class="flex-grow space-y-4">
                    <h2 class="text-lg font-semibold text-slate-100 leading-snug">
                        {{ $question->question_text }}
                    </h2>

                    <!-- Options List -->
                    <div class="space-y-3">
                        @if(is_array($question->options))
                            @foreach($question->options as $opt)
                                @php
                                    $optionKey = $opt['key'] ?? '';
                                    $optionText = $opt['text'] ?? '';
                                @endphp
                                <label class="flex items-center gap-3 p-4 rounded-xl bg-slate-900/50 border border-slate-700/50 hover:bg-slate-700/40 hover:border-slate-500/50 cursor-pointer transition-all duration-150 group">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $optionKey }}" 
                                           required
                                           class="w-5 h-5 text-brand-500 bg-slate-800 border-slate-600 focus:ring-brand-500 focus:ring-offset-slate-900 cursor-pointer">
                                    <span class="w-7 h-7 rounded-lg bg-slate-800 group-hover:bg-brand-600 group-hover:text-white text-slate-400 font-bold text-xs flex items-center justify-center border border-slate-700 group-hover:border-brand-500 transition-colors">
                                        {{ $optionKey }}
                                    </span>
                                    <span class="text-sm font-medium text-slate-200 group-hover:text-white">
                                        {{ $optionText }}
                                    </span>
                                </label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Submit Bar -->
        <div class="sticky bottom-6 bg-slate-800/90 backdrop-blur-md border border-slate-700 rounded-2xl p-4 shadow-2xl flex items-center justify-between">
            <div class="text-xs text-slate-400">
                Responde todas las preguntas antes de enviar.
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-brand-500/25 transition-all flex items-center gap-2 hover:scale-[1.02] active:scale-[0.98]">
                <span>Finalizar y Enviar Evaluación</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@if($evaluation->time_limit_minutes)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let totalSeconds = {{ $evaluation->time_limit_minutes * 60 }};
        const timerDisplay = document.getElementById('timer');
        const form = document.getElementById('evaluationForm');

        const interval = setInterval(function () {
            if (totalSeconds <= 0) {
                clearInterval(interval);
                alert('El tiempo límite ha expirado. Tu evaluación será enviada automáticamente.');
                form.submit();
                return;
            }

            totalSeconds--;
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            timerDisplay.textContent = 
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        }, 1000);
    });
</script>
@endif
@endpush
