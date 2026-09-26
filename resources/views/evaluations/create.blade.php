@extends('layouts.fmk')

@section('title', 'Diseñar Nueva Evaluación - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Hero Banner Verde Esmeralda FMK -->
    <div class="bg-gradient-to-r from-[#059669] to-[#10b981] rounded-3xl p-6 sm:p-8 text-white shadow-lg flex items-center justify-between">
        <div class="space-y-1">
            <span class="text-xs font-extrabold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                Configuración Evaluativa
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Diseñar Nueva Evaluación Psicométrica</h1>
            <p class="text-xs sm:text-sm text-emerald-100 font-medium">Define el título, tipo de prueba, tiempo límite y preguntas con sus opciones.</p>
        </div>
        <a href="{{ route('evaluations-manage.index') }}" 
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-[#059669] hover:bg-emerald-50 text-xs font-extrabold rounded-full shadow-xs transition-all">
            <span>&larr; Volver</span>
        </a>
    </div>

    <form action="{{ route('evaluations-manage.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- 1. General Configuration -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-[#00a8cc] text-white flex items-center justify-center text-xs">1</span>
                    Información General de la Prueba
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Título de la Evaluación *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ej. Razonamiento Lógico Computacional" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tipo de Evaluación *</label>
                    <select name="type" id="evaluationType" required 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                        <option value="COGNITIVE">COGNITIVE (Prueba Aptitud / Lógica)</option>
                        <option value="DISC">DISC (Perfil Conductual / Situacional)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tiempo Límite (Minutos) *</label>
                    <input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes', 15) }}" min="1" max="180" required 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Descripción / Instrucciones</label>
                    <input type="text" name="description" value="{{ old('description') }}" placeholder="Instrucciones breves para el candidato..." 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                </div>
            </div>
        </div>

        <!-- 2. Questions Section -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-[#00a8cc] text-white flex items-center justify-center text-xs">2</span>
                    Banco de Preguntas y Opciones
                </h2>
                <button type="button" id="addQuestionBtn" 
                        class="px-4 py-2 bg-[#00a8cc] hover:bg-[#007b99] text-white font-bold rounded-xl text-xs shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                    <span>+ Añadir Pregunta</span>
                </button>
            </div>

            <div id="questionsContainer" class="space-y-6">
                <!-- Question Template Block 0 -->
                <div class="question-block bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4 relative">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#00a8cc]">Pregunta #1</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Enunciado de la Pregunta *</label>
                        <input type="text" name="questions[0][question_text]" required placeholder="Escribe la pregunta aquí..." 
                               class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc]">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="space-y-2 bg-white p-3 rounded-xl border border-slate-200">
                            <span class="text-xs font-bold text-slate-700">Opción A:</span>
                            <input type="hidden" name="questions[0][options][0][key]" value="A">
                            <input type="text" name="questions[0][options][0][text]" required placeholder="Texto de la Opción A..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900">
                            <input type="text" name="questions[0][options][0][trait]" placeholder="Trait DISC (D, I, S, C)" class="w-full px-3 py-1 bg-amber-50 border border-amber-200 rounded text-[11px] text-amber-900 font-bold">
                        </div>
                        <div class="space-y-2 bg-white p-3 rounded-xl border border-slate-200">
                            <span class="text-xs font-bold text-slate-700">Opción B:</span>
                            <input type="hidden" name="questions[0][options][1][key]" value="B">
                            <input type="text" name="questions[0][options][1][text]" required placeholder="Texto de la Opción B..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900">
                            <input type="text" name="questions[0][options][1][trait]" placeholder="Trait DISC (D, I, S, C)" class="w-full px-3 py-1 bg-amber-50 border border-amber-200 rounded text-[11px] text-amber-900 font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Opción Correcta (Solo para Cognitiva - Ej: A o B)</label>
                        <input type="text" name="questions[0][correct_option]" placeholder="Clave (A, B, etc.)" class="w-32 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 font-bold">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-3.5 bg-[#059669] hover:bg-emerald-700 text-white font-extrabold rounded-2xl shadow-md transition-all text-xs cursor-pointer">
            Guardar Evaluación Completa en Sistema FMK
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = 1;
        const container = document.getElementById('questionsContainer');
        const addBtn = document.getElementById('addQuestionBtn');

        addBtn.addEventListener('click', function () {
            const block = document.createElement('div');
            block.className = 'question-block bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4 relative';
            block.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-[#00a8cc]">Pregunta #${questionIndex + 1}</span>
                    <button type="button" class="remove-q-btn text-xs text-red-600 font-bold hover:underline">Eliminar</button>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Enunciado de la Pregunta *</label>
                    <input type="text" name="questions[${questionIndex}][question_text]" required placeholder="Escribe la pregunta aquí..." class="w-full px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc]">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="space-y-2 bg-white p-3 rounded-xl border border-slate-200">
                        <span class="text-xs font-bold text-slate-700">Opción A:</span>
                        <input type="hidden" name="questions[${questionIndex}][options][0][key]" value="A">
                        <input type="text" name="questions[${questionIndex}][options][0][text]" required placeholder="Texto de la Opción A..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900">
                        <input type="text" name="questions[${questionIndex}][options][0][trait]" placeholder="Trait DISC (D, I, S, C)" class="w-full px-3 py-1 bg-amber-50 border border-amber-200 rounded text-[11px] text-amber-900 font-bold">
                    </div>
                    <div class="space-y-2 bg-white p-3 rounded-xl border border-slate-200">
                        <span class="text-xs font-bold text-slate-700">Opción B:</span>
                        <input type="hidden" name="questions[${questionIndex}][options][1][key]" value="B">
                        <input type="text" name="questions[${questionIndex}][options][1][text]" required placeholder="Texto de la Opción B..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-900">
                        <input type="text" name="questions[${questionIndex}][options][1][trait]" placeholder="Trait DISC (D, I, S, C)" class="w-full px-3 py-1 bg-amber-50 border border-amber-200 rounded text-[11px] text-amber-900 font-bold">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Opción Correcta (Solo para Cognitiva - Ej: A o B)</label>
                    <input type="text" name="questions[${questionIndex}][correct_option]" placeholder="Clave (A, B, etc.)" class="w-32 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 font-bold">
                </div>
            `;

            container.appendChild(block);

            block.querySelector('.remove-q-btn').addEventListener('click', function () {
                block.remove();
            });

            questionIndex++;
        });
    });
</script>
@endpush
