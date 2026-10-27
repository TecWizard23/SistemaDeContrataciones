@extends('layouts.fmk')

@section('title', 'Crear Examen por Bloques - Fundación Munasim Kullakita')

@section('content')
<div x-data="blockExamBuilder()" class="space-y-6 pb-12">

    <!-- Hero Header Banner Ejecutivo -->
    <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800/80 overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 transition-all duration-300">
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-extrabold px-3 py-1 bg-white/10 rounded-full border border-white/20 uppercase tracking-wider backdrop-blur-xs text-indigo-200">
                    Módulo de Evaluaciones
                </span>
                <span class="text-xs text-slate-300 font-semibold flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Constructor Modular
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">Crear Examen por Bloques</h1>
            <p class="text-xs sm:text-sm text-slate-300 font-normal max-w-xl leading-relaxed">
                Diseña el examen añadiendo preguntas de forma ágil e interactiva. Cada bloque es independiente y personalizable.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('evaluations-manage.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-slate-900 hover:bg-slate-100 text-xs font-extrabold rounded-xl shadow-md transition-all cursor-pointer">
                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Banco de Evaluaciones</span>
            </a>
        </div>
    </div>

    <!-- Mode Switcher Tabs (Diseñador vs Vista Previa) -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between bg-white rounded-2xl p-2 border border-slate-200 shadow-xs gap-3">
        <div class="flex items-center gap-1.5 bg-slate-100/70 p-1 rounded-xl">
            <button type="button" @click="activeTab = 'editor'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-extrabold transition-all duration-200 flex items-center gap-2 cursor-pointer"
                    :class="activeTab === 'editor' ? 'bg-slate-900 text-white shadow-xs scale-[1.02]' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Diseñador de Preguntas</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black"
                      :class="activeTab === 'editor' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'"
                      x-text="blocks.length"></span>
            </button>

            <button type="button" @click="activeTab = 'preview'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-extrabold transition-all duration-200 flex items-center gap-2 cursor-pointer"
                    :class="activeTab === 'preview' ? 'bg-indigo-600 text-white shadow-xs scale-[1.02]' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span>Vista Previa del Postulante</span>
            </button>
        </div>

        <!-- Quick Summary Counters -->
        <div class="flex items-center justify-end gap-3 px-3 text-xs font-semibold text-slate-500">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-slate-900"></span>
                Total Preguntas: <strong class="text-slate-900 font-extrabold" x-text="blocks.length"></strong>
            </span>
            <span class="text-slate-300">&bull;</span>
            <span>Puntos: <strong class="text-emerald-700 font-extrabold" x-text="totalPoints()"></strong></span>
            <span class="text-slate-300">&bull;</span>
            <span>Tiempo: <strong class="text-amber-600 font-extrabold" x-text="timeLimit + ' min'"></strong></span>
        </div>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium space-y-1.5 animate-block-enter">
            <div class="font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Por favor corrige los siguientes errores:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-red-700 pl-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM WRAPPER -->
    <form action="{{ route('evaluations-manage.store') }}" method="POST" id="examForm" class="space-y-6">
        @csrf

        <!-- TAB 1: BLOCK DESIGNER -->
        <div x-show="activeTab === 'editor'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-6">

            <!-- Section 1: Configuración General del Examen -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shadow-2xs">1</span>
                        <span>Configuración Principal del Examen</span>
                    </h2>

                    <!-- Plantillas Rápidas -->
                    <div class="flex items-center gap-2">
                        <button type="button" @click="loadSampleTemplate('COGNITIVE')" 
                                class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer hover:shadow-xs active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <span>Plantilla Cognitiva</span>
                        </button>

                        <button type="button" @click="loadSampleTemplate('DISC')" 
                                class="px-3 py-1.5 bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer hover:shadow-xs active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Plantilla DISC</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                    <div class="md:col-span-8">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Título de la Evaluación / Convocatoria *</label>
                        <input type="text" name="title" x-model="title" required 
                               placeholder="Ej. Evaluación de Aptitud Analítica y Lógica Algorítmica" 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all font-semibold">
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tipo de Evaluación *</label>
                        <select name="type" x-model="generalType" @change="onGeneralTypeChange()" required 
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all font-bold">
                            <option value="COGNITIVE">Aptitud Cognitiva / Técnica (Con respuesta correcta)</option>
                            <option value="DISC">Perfil Conductual DISC (Autoevaluación de personalidad)</option>
                            <option value="SITUATIONAL">Juicio Situacional (Resolución de casos)</option>
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tiempo Límite (Minutos) *</label>
                        <div class="relative">
                            <input type="number" name="time_limit_minutes" x-model="timeLimit" min="1" max="180" required 
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="md:col-span-8">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Instrucciones u Orientaciones para el Postulante</label>
                        <input type="text" name="description" x-model="description" 
                               placeholder="Indicaciones previas a rendir la prueba (ej. responde con sinceridad, tiempo límite estricto)..." 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 2: Bloques Dinámicos de Preguntas -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold shadow-2xs">2</span>
                            <span>Lista de Preguntas (Bloques Independientes)</span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Cada pregunta es un bloque modular. Puedes moverlas de posición, duplicarlas o editarlas sin alterar las demás.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="expandAllBlocks()" 
                                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all cursor-pointer active:scale-95">
                            Expandir Todo
                        </button>
                        <button type="button" @click="collapseAllBlocks()" 
                                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all cursor-pointer active:scale-95">
                            Colapsar Todo
                        </button>
                    </div>
                </div>

                <!-- Block Cards Container -->
                <div class="space-y-4">
                    <template x-for="(block, bIndex) in blocks" :key="block.uid">
                        <div class="bg-white border rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 space-y-4 animate-block-enter"
                             :class="block.collapsed ? 'border-slate-200 bg-slate-50/50' : 'border-slate-300 ring-2 ring-slate-900/5'">

                            <!-- Hidden Question Correct Option -->
                            <input type="hidden" :name="`questions[${bIndex}][correct_option]`" :value="block.correct_option || ''">

                            <!-- Block Toolbar Header -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-3">
                                    <!-- Block Number Pill -->
                                    <span class="px-3 py-1 rounded-xl text-xs font-black text-white shadow-2xs flex items-center gap-1.5 bg-slate-900">
                                        <span x-text="`Pregunta #${bIndex + 1}`"></span>
                                    </span>

                                    <!-- Collapsed Title Peek -->
                                    <span x-show="block.collapsed" class="text-xs font-bold text-slate-700 truncate max-w-md"
                                          x-text="block.question_text || '(Sin enunciado aún)'"></span>

                                    <span class="text-xs text-slate-400 font-semibold hidden sm:inline"
                                          x-text="`${block.options.length} alternativas &bull; ${block.points} pts`">
                                    </span>
                                </div>

                                <!-- Action Buttons: Move Up, Move Down, Duplicate, Collapse, Delete -->
                                <div class="flex items-center gap-1">
                                    <button type="button" @click="moveBlockUp(bIndex)" :disabled="bIndex === 0" title="Subir de posición"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 disabled:opacity-30 disabled:pointer-events-none transition-all cursor-pointer active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    </button>

                                    <button type="button" @click="moveBlockDown(bIndex)" :disabled="bIndex === blocks.length - 1" title="Bajar de posición"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 disabled:opacity-30 disabled:pointer-events-none transition-all cursor-pointer active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <button type="button" @click="duplicateBlock(bIndex)" title="Duplicar esta pregunta"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all cursor-pointer active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>

                                    <button type="button" @click="block.collapsed = !block.collapsed" title="Colapsar / Desplegar"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all cursor-pointer">
                                        <svg class="w-4 h-4 transition-transform duration-300" :class="block.collapsed ? '-rotate-90 text-slate-400' : 'rotate-0 text-slate-900'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <button type="button" @click="removeBlock(bIndex)" x-show="blocks.length > 1" title="Eliminar pregunta"
                                            class="p-1.5 rounded-lg text-red-400 hover:text-red-700 hover:bg-red-50 transition-all cursor-pointer active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Block Editable Body -->
                            <div x-show="!block.collapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="space-y-4 pt-1">
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                    <div class="sm:col-span-10">
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Enunciado de la Pregunta *</label>
                                        <input type="text" :name="`questions[${bIndex}][question_text]`" x-model="block.question_text" required 
                                               placeholder="Escribe la consigna, planteamiento o pregunta..." 
                                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all font-medium">
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Puntaje</label>
                                        <input type="number" :name="`questions[${bIndex}][points]`" x-model="block.points" min="1" max="50" required 
                                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 text-center font-bold focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                                    </div>
                                </div>

                                <!-- Dynamic Options Sub-Blocks -->
                                <div class="space-y-3 pt-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Alternativas de Respuesta</span>
                                        <button type="button" @click="addOption(bIndex)" 
                                                class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1.5 cursor-pointer hover:underline">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <span>+ Agregar Alternativa</span>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 gap-2.5">
                                        <template x-for="(opt, optIndex) in block.options" :key="optIndex">
                                            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-slate-300 transition-all duration-150">
                                                
                                                <div class="flex items-center gap-3 flex-grow">
                                                    <!-- Option Key Label -->
                                                    <span class="w-7 h-7 rounded-lg bg-white text-slate-800 font-black text-xs flex items-center justify-center flex-shrink-0 border border-slate-200 shadow-2xs" 
                                                          x-text="opt.key"></span>
                                                    <input type="hidden" :name="`questions[${bIndex}][options][${optIndex}][key]`" :value="opt.key">
                                                    
                                                    <!-- Option Text -->
                                                    <input type="text" :name="`questions[${bIndex}][options][${optIndex}][text]`" x-model="opt.text" required 
                                                           :placeholder="`Texto de la alternativa ${opt.key}...`" 
                                                           class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 transition-all">
                                                </div>

                                                <div class="flex items-center gap-2 justify-end flex-shrink-0">
                                                    <!-- Botón Marcar Correcta (Para pruebas que tienen respuesta correcta) -->
                                                    <template x-if="generalType !== 'DISC'">
                                                        <button type="button" 
                                                                @click="block.correct_option = opt.key" 
                                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs font-bold transition-all duration-200 cursor-pointer active:scale-95"
                                                                :class="block.correct_option === opt.key 
                                                                    ? 'bg-emerald-50 border-emerald-500 text-emerald-700 ring-2 ring-emerald-500/20 shadow-xs' 
                                                                    : 'bg-white border-slate-200 text-slate-500 hover:border-slate-300 hover:text-slate-700'">
                                                            <svg class="w-3.5 h-3.5 transition-transform duration-200" 
                                                                 :class="block.correct_option === opt.key ? 'text-emerald-600 scale-110' : 'text-slate-300'" 
                                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            <span x-text="block.correct_option === opt.key ? 'Respuesta Correcta' : 'Marcar Correcta'"></span>
                                                        </button>
                                                    </template>

                                                    <template x-if="generalType === 'DISC'">
                                                        <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg">
                                                            Opción de conducta
                                                        </span>
                                                    </template>

                                                    <!-- Quitar alternativa -->
                                                    <button type="button" @click="removeOption(bIndex, optIndex)" x-show="block.options.length > 2" title="Quitar alternativa"
                                                            class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-150 cursor-pointer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </template>
                </div>

                <!-- Single Prominent Animated Add Question Button -->
                <div class="pt-4 flex justify-center">
                    <button type="button" @click="addBlock()" 
                            class="w-full sm:w-auto px-8 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-xs font-black shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2.5 cursor-pointer group">
                        <div class="w-5 h-5 rounded-lg bg-white/10 flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span>Añadir Nueva Pregunta</span>
                        <span class="px-2 py-0.5 rounded-full bg-white/20 text-[10px] font-black" x-text="`#${blocks.length + 1}`"></span>
                    </button>
                </div>
            </div>

            <!-- Sticky Bottom Submit Bar -->
            <div class="sticky bottom-6 z-20 bg-white/95 backdrop-blur-md rounded-3xl p-4 sm:p-5 border border-slate-200 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4 transition-all duration-300">
                <div class="flex items-center gap-3 text-xs text-slate-600">
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200 font-black">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-extrabold text-slate-900" x-text="`${blocks.length} Preguntas listas para el examen`"></p>
                        <p class="text-[11px] text-slate-400">Total acumulado: <strong class="text-emerald-700" x-text="totalPoints()"></strong> puntos en <strong class="text-amber-600" x-text="timeLimit + ' min'"></strong></p>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('evaluations-manage.index') }}" 
                       class="w-1/2 sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs text-center transition-all cursor-pointer">
                        Cancelar
                    </a>

                    <button type="submit" 
                            class="w-1/2 sm:w-auto px-7 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold rounded-xl text-xs shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <span>Guardar Examen</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- TAB 2: CANDIDATE SIMULATED PREVIEW -->
        <div x-show="activeTab === 'preview'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-6">

            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs text-amber-900 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Modo de Simulación:</strong> Así es exactamente como tus postulantes verán y resolverán la evaluación en su portal.</span>
                </div>
                <button type="button" @click="activeTab = 'editor'" class="font-bold underline cursor-pointer text-amber-800 hover:text-amber-950">
                    Volver a Editar
                </button>
            </div>

            <!-- Header of exam preview -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200/60" x-text="generalType"></span>
                        <h2 class="text-xl font-extrabold text-slate-900 mt-2" x-text="title || 'Título de la Evaluación sin definir'"></h2>
                        <p class="text-xs text-slate-500 mt-1" x-text="description || 'Sin orientaciones previas registradas.'"></p>
                    </div>

                    <div class="flex items-center gap-4 bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200">
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Tiempo de examen</span>
                            <span class="text-base font-black text-slate-900" x-text="timeLimit + ':00 min'"></span>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-[#f59e0b] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Simulated Questions Preview List -->
                <div class="space-y-6 pt-2">
                    <template x-for="(block, bIndex) in blocks" :key="bIndex">
                        <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/40 space-y-3">
                            <div class="flex items-start justify-between gap-4">
                                <h3 class="text-xs font-bold text-slate-900 flex items-start gap-2">
                                    <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700 font-extrabold text-[11px]" x-text="`#${bIndex + 1}`"></span>
                                    <span x-text="block.question_text || '(Sin enunciado)'"></span>
                                </h3>
                                <span class="text-[11px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md flex-shrink-0" x-text="`${block.points} pts`"></span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                                <template x-for="(opt, optIndex) in block.options" :key="optIndex">
                                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50/20 transition-all duration-150 cursor-pointer">
                                        <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-700 font-black text-xs flex items-center justify-center" x-text="opt.key"></span>
                                        <span class="text-xs text-slate-800 font-medium" x-text="opt.text || `Alternativa ${opt.key}`"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function blockExamBuilder() {
        return {
            activeTab: 'editor',
            title: '',
            generalType: 'COGNITIVE',
            timeLimit: 20,
            description: '',
            letters: ['A', 'B', 'C', 'D', 'E', 'F'],
            blocks: [
                {
                    uid: 'b_' + Date.now() + '_' + Math.floor(Math.random() * 10000),
                    question_text: '',
                    points: 1,
                    correct_option: 'A',
                    collapsed: false,
                    options: [
                        { key: 'A', text: '' },
                        { key: 'B', text: '' },
                        { key: 'C', text: '' },
                        { key: 'D', text: '' }
                    ]
                }
            ],

            onGeneralTypeChange() {
                // Adjust correct_option default only if needed, NEVER touches option texts or existing structures
                if (this.generalType === 'DISC') {
                    this.blocks.forEach(b => {
                        b.correct_option = null;
                    });
                } else {
                    this.blocks.forEach(b => {
                        if (!b.correct_option && b.options.length) {
                            b.correct_option = b.options[0].key;
                        }
                    });
                }
            },

            addBlock() {
                // Adds a clean, new independent question block without touching any existing block
                const defaultCorrect = this.generalType === 'DISC' ? null : 'A';
                this.blocks.push({
                    uid: 'b_' + Date.now() + '_' + Math.floor(Math.random() * 10000),
                    question_text: '',
                    points: 1,
                    correct_option: defaultCorrect,
                    collapsed: false,
                    options: [
                        { key: 'A', text: '' },
                        { key: 'B', text: '' },
                        { key: 'C', text: '' },
                        { key: 'D', text: '' }
                    ]
                });
            },

            duplicateBlock(index) {
                const source = this.blocks[index];
                const clone = JSON.parse(JSON.stringify(source));
                clone.uid = 'b_' + Date.now() + '_' + Math.floor(Math.random() * 10000);
                clone.collapsed = false;
                this.blocks.splice(index + 1, 0, clone);
            },

            removeBlock(index) {
                if (this.blocks.length > 1) {
                    this.blocks.splice(index, 1);
                }
            },

            moveBlockUp(index) {
                if (index > 0) {
                    const item = this.blocks.splice(index, 1)[0];
                    this.blocks.splice(index - 1, 0, item);
                }
            },

            moveBlockDown(index) {
                if (index < this.blocks.length - 1) {
                    const item = this.blocks.splice(index, 1)[0];
                    this.blocks.splice(index + 1, 0, item);
                }
            },

            expandAllBlocks() {
                this.blocks.forEach(b => b.collapsed = false);
            },

            collapseAllBlocks() {
                this.blocks.forEach(b => b.collapsed = true);
            },

            addOption(blockIndex) {
                const b = this.blocks[blockIndex];
                if (b.options.length < this.letters.length) {
                    const nextKey = this.letters[b.options.length];
                    b.options.push({
                        key: nextKey,
                        text: ''
                    });
                }
            },

            removeOption(blockIndex, optIndex) {
                const b = this.blocks[blockIndex];
                if (b.options.length > 2) {
                    b.options.splice(optIndex, 1);
                    b.options.forEach((opt, idx) => {
                        opt.key = this.letters[idx];
                    });
                    if (b.correct_option === this.letters[optIndex]) {
                        b.correct_option = b.options[0].key;
                    }
                }
            },

            totalPoints() {
                return this.blocks.reduce((acc, b) => acc + (parseInt(b.points) || 1), 0);
            },

            loadSampleTemplate(type) {
                this.generalType = type;
                if (type === 'COGNITIVE') {
                    this.title = 'Prueba de Habilidades Técnicas y Razonamiento Lógico';
                    this.timeLimit = 30;
                    this.description = 'Esta prueba evalúa tu capacidad de análisis cuantitativo, comprensión de procesos y resolución estructurada de problemas.';
                    this.blocks = [
                        {
                            uid: 'b_1_' + Date.now(),
                            question_text: '¿Cuál es la complejidad temporal promedio de búsqueda en una estructura hash balanceada?',
                            points: 2,
                            correct_option: 'A',
                            collapsed: false,
                            options: [
                                { key: 'A', text: 'O(1) Tiempo constante' },
                                { key: 'B', text: 'O(n) Tiempo lineal' },
                                { key: 'C', text: 'O(log n) Tiempo logarítmico' },
                                { key: 'D', text: 'O(n^2) Tiempo cuadrático' }
                            ]
                        },
                        {
                            uid: 'b_2_' + Date.now(),
                            question_text: 'En una arquitectura modular de software, ¿cuál es el objetivo primordial del patrón MVC?',
                            points: 2,
                            correct_option: 'C',
                            collapsed: false,
                            options: [
                                { key: 'A', text: 'Optimizar la base de datos físicamente' },
                                { key: 'B', text: 'Acelerar la conexión del usuario a Internet' },
                                { key: 'C', text: 'Separar los datos, la interfaz de usuario y la lógica de control' },
                                { key: 'D', text: 'Evitar el uso de lenguajes compilados' }
                            ]
                        }
                    ];
                } else if (type === 'DISC') {
                    this.title = 'Inventario de Estilos Conductuales y Preferencias Laborales (DISC)';
                    this.timeLimit = 20;
                    this.description = 'Selecciona en cada situación la alternativa que mejor describa tu forma habitual de interactuar y resolver desafíos.';
                    this.blocks = [
                        {
                            uid: 'b_disc_1_' + Date.now(),
                            question_text: 'Frente a un cambio inesperado en un proyecto que requiere decisiones rápidas...',
                            points: 1,
                            correct_option: null,
                            collapsed: false,
                            options: [
                                { key: 'A', text: 'Asumo el mando, priorizo la meta y tomo decisiones directas' },
                                { key: 'B', text: 'Comunico al equipo con optimismo para mantener la motivación' },
                                { key: 'C', text: 'Mantengo la serenidad, escucho a todos y aseguro el orden colectivo' },
                                { key: 'D', text: 'Reviso minuciosamente los datos y evalúo riesgos con cautela' }
                            ]
                        },
                        {
                            uid: 'b_disc_2_' + Date.now(),
                            question_text: 'En situaciones donde surgen desacuerdos de opinión en el equipo...',
                            points: 1,
                            correct_option: null,
                            collapsed: false,
                            options: [
                                { key: 'A', text: 'Argumento con firmeza y busco una resolución inmediata' },
                                { key: 'B', text: 'Propongo una dinámica para persuadir y recuperar la armonía' },
                                { key: 'C', text: 'Busco mediar con paciencia para no alterar la convivencia' },
                                { key: 'D', text: 'Analizo las evidencias objetivas y me baso en los hechos' }
                            ]
                        }
                    ];
                }
            }
        };
    }
</script>
@endpush
