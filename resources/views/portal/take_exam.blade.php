@extends('layouts.fmk')

@section('title', $evaluation->title . ' - Evaluación FMK')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Card with Timer -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-2xs relative overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase tracking-wider">
                        {{ $evaluation->type }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">&bull; {{ $questions->count() }} Pregunta(s)</span>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $evaluation->title }}</h1>
                <p class="text-xs text-slate-500 font-normal">Postulante: <strong class="text-slate-800">{{ $candidate->full_name }}</strong></p>
            </div>

            <!-- Countdown Timer Box -->
            <div class="bg-amber-50/80 border border-amber-200/80 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-amber-800 font-bold uppercase tracking-wider">Tiempo Restante</div>
                    <div id="timer" class="text-xl font-bold font-mono text-amber-950 tracking-wider">--:--</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Form -->
    <form id="examForm" action="{{ route('exam.submit', $session) }}" method="POST" class="space-y-6">
        @csrf

        @foreach($questions as $index => $question)
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-2xs space-y-4">
            <div class="flex items-start gap-4">
                <span class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-2xs">
                    {{ $index + 1 }}
                </span>
                <div class="flex-grow space-y-4">
                    <h2 class="text-sm font-bold text-slate-900 leading-snug">
                        {{ $question->question_text }}
                    </h2>

                    <!-- Options List (Interactive Cards) -->
                    <div class="space-y-2.5">
                        @if(is_array($question->options))
                            @foreach($question->options as $opt)
                                @php
                                    $optionKey = $opt['key'] ?? '';
                                    $optionText = $opt['text'] ?? '';
                                @endphp
                                <label class="flex items-center gap-3.5 p-3.5 rounded-xl bg-slate-50/70 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 cursor-pointer transition-all group">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $optionKey }}" 
                                           required
                                           class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500 cursor-pointer">
                                    <span class="w-6 h-6 rounded-lg bg-white group-hover:bg-indigo-600 group-hover:text-white text-slate-600 font-bold text-xs flex items-center justify-center border border-slate-200 group-hover:border-indigo-600 transition-colors shadow-2xs">
                                        {{ $optionKey }}
                                    </span>
                                    <span class="text-xs font-medium text-slate-800 group-hover:text-slate-900">
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
        <div class="sticky bottom-6 bg-white border border-slate-200 rounded-2xl p-4 shadow-lg flex items-center justify-between z-30">
            <div class="text-xs text-slate-500 font-medium hidden sm:block">
                Revisa tus respuestas antes de finalizar la evaluación.
            </div>
            <button type="submit" 
                    class="w-full sm:w-auto px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Finalizar Examen</span>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let remainingSeconds = {{ $remainingSeconds }};
        const timerDisplay = document.getElementById('timer');
        const form = document.getElementById('examForm');

        function updateTimerDisplay() {
            const minutes = Math.floor(remainingSeconds / 60);
            const seconds = remainingSeconds % 60;
            timerDisplay.textContent = 
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        }

        updateTimerDisplay();

        const interval = setInterval(function () {
            if (remainingSeconds <= 0) {
                clearInterval(interval);
                alert('El tiempo límite ha expirado. Tu examen se enviará automáticamente.');
                form.submit();
                return;
            }

            remainingSeconds--;
            updateTimerDisplay();
        }, 1000);
    });
</script>
@endpush
