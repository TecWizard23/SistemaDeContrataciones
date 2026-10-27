@extends('layouts.fmk')

@section('title', $evaluation->title . ' - Evaluación FMK')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Card with Timer FMK Style -->
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-md relative overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-sky-50 text-[#00a8cc] border border-sky-200 uppercase tracking-wider">
                        {{ $evaluation->type }}
                    </span>
                    <span class="text-xs text-slate-400 font-semibold">&bull; {{ $questions->count() }} Pregunta(s)</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $evaluation->title }}</h1>
                <p class="text-xs text-slate-500 font-medium">Postulante: <strong class="text-slate-800">{{ $candidate->full_name }}</strong></p>
            </div>

            <!-- Countdown Timer Box -->
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-center gap-3 shadow-2xs">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-amber-800 font-extrabold uppercase tracking-wider">Tiempo Restante</div>
                    <div id="timer" class="text-2xl font-black font-mono text-amber-900 tracking-wider">--:--</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Form -->
    <form id="examForm" action="{{ route('exam.submit', $session) }}" method="POST" class="space-y-6">
        @csrf

        @foreach($questions as $index => $question)
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-[#00a8cc] text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-2xs">
                    {{ $index + 1 }}
                </span>
                <div class="flex-grow space-y-4">
                    <h2 class="text-base font-bold text-slate-900 leading-snug">
                        {{ $question->question_text }}
                    </h2>

                    <!-- Options List (Interactive Cards) -->
                    <div class="space-y-3">
                        @if(is_array($question->options))
                            @foreach($question->options as $opt)
                                @php
                                    $optionKey = $opt['key'] ?? '';
                                    $optionText = $opt['text'] ?? '';
                                @endphp
                                <label class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:bg-sky-50/60 hover:border-sky-300 cursor-pointer transition-all group">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $optionKey }}" 
                                           required
                                           class="w-5 h-5 text-[#00a8cc] border-slate-300 focus:ring-[#00a8cc] cursor-pointer">
                                    <span class="w-7 h-7 rounded-xl bg-white group-hover:bg-[#00a8cc] group-hover:text-white text-slate-600 font-bold text-xs flex items-center justify-center border border-slate-200 group-hover:border-[#00a8cc] transition-colors shadow-2xs">
                                        {{ $optionKey }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-800 group-hover:text-slate-900">
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
        <div class="sticky bottom-6 bg-white border border-slate-200 rounded-2xl p-4 shadow-xl flex items-center justify-between z-30">
            <div class="text-xs text-slate-500 font-medium hidden sm:block">
                Revisa tus respuestas antes de finalizar la evaluación.
            </div>
            <button type="submit" 
                    class="w-full sm:w-auto px-8 py-3 bg-[#059669] hover:bg-emerald-700 text-white font-extrabold rounded-xl text-xs shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Finalizar Examen</span>
                <span>&rarr;</span>
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
