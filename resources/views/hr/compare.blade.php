@extends('layouts.fmk')

@section('title', 'Comparar Candidatos & Radar de Competencias - Kullakita')

@section('content')
<div x-data="comparisonApp({{ json_encode($comparisonData) }})" class="space-y-6">

    <!-- Executive Hero Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-2xl p-6 text-white border border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-500/20 text-indigo-200 border border-indigo-400/30 uppercase tracking-wider">
                    <svg class="w-3 h-3 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                    <span>Analítica Psicométrica</span>
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">Comparador de Candidatos & Radar</h1>
            <p class="text-xs text-slate-300 font-normal">Análisis multiaxial de competencias, adecuación al perfil y evolución temporal del talento evaluado.</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Export Button -->
            <a :href="exportUrl" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-xl text-xs font-semibold shadow-xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span>Exportar Informe</span>
            </a>
        </div>
    </div>

    <!-- Cascading Filter Bar (Dropdowns with Alpine.js) -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex flex-wrap items-center gap-3">
        <!-- Filter 1: Categoría -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="px-3.5 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 flex items-center gap-2 transition-colors">
                <span class="text-slate-400">Categoría:</span>
                <span class="font-semibold text-slate-900" x-text="selectedCategory"></span>
                <svg class="w-3.5 h-3.5 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-cloak class="absolute left-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl py-1 z-40 text-xs">
                <template x-for="cat in categories" :key="cat">
                    <button @click="selectedCategory = cat; open = false;" class="w-full text-left px-4 py-2 hover:bg-slate-50 text-slate-700 flex items-center justify-between">
                        <span x-text="cat"></span>
                        <svg x-show="selectedCategory === cat" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </template>
            </div>
        </div>

        <!-- Filter 2: Revisor / Manager -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="px-3.5 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 flex items-center gap-2 transition-colors">
                <span class="text-slate-400">Revisor:</span>
                <span class="font-semibold text-slate-900" x-text="selectedReviewer"></span>
                <svg class="w-3.5 h-3.5 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-cloak class="absolute left-0 mt-2 w-52 bg-white border border-slate-200 rounded-xl shadow-xl py-1 z-40 text-xs">
                <template x-for="rev in reviewers" :key="rev">
                    <button @click="selectedReviewer = rev; open = false;" class="w-full text-left px-4 py-2 hover:bg-slate-50 text-slate-700 flex items-center justify-between">
                        <span x-text="rev"></span>
                        <svg x-show="selectedReviewer === rev" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </template>
            </div>
        </div>

        <!-- Filter 3: Rango de Fechas -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="px-3.5 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 flex items-center gap-2 transition-colors">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-semibold text-slate-900" x-text="selectedDateRange"></span>
                <svg class="w-3.5 h-3.5 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-cloak class="absolute left-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl py-1 z-40 text-xs">
                <template x-for="range in dateRanges" :key="range">
                    <button @click="selectedDateRange = range; open = false;" class="w-full text-left px-4 py-2 hover:bg-slate-50 text-slate-700 flex items-center justify-between">
                        <span x-text="range"></span>
                        <svg x-show="selectedDateRange === range" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </template>
            </div>
        </div>

        <!-- Filter 4: Candidate Search Dropdown (Kenjo Floating Menu Style) -->
        <div class="relative flex-grow sm:flex-grow-0" x-data="{ open: false, search: '' }">
            <button @click="open = !open" class="w-full sm:w-64 px-3.5 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 flex items-center justify-between gap-2 transition-colors">
                <div class="flex items-center gap-2 truncate">
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="font-semibold text-slate-900 truncate">Añadir candidato...</span>
                </div>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Floating Candidates List -->
            <div x-show="open" @click.outside="open = false" x-cloak class="absolute left-0 mt-2 w-72 bg-white border border-slate-200 rounded-2xl shadow-2xl p-2 z-50 text-xs">
                <div class="p-2 border-b border-slate-100">
                    <input type="text" x-model="search" placeholder="Buscar por nombre o email..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="max-h-56 overflow-y-auto py-1 divide-y divide-slate-50">
                    <template x-for="cand in filteredAllCandidates(search)" :key="cand.id">
                        <button @click="toggleCandidate(cand.id)" class="w-full text-left px-3 py-2 hover:bg-slate-50 rounded-xl flex items-center justify-between transition-colors">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-[10px]" x-text="cand.avatar_initials"></div>
                                <div>
                                    <div class="font-semibold text-slate-800" x-text="cand.name"></div>
                                    <div class="text-[10px] text-slate-400" x-text="cand.position"></div>
                                </div>
                            </div>
                            <svg x-show="isSelectedCandidate(cand.id)" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Filter 5: Department Dropdown with Checkboxes -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="px-3.5 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 flex items-center gap-2 transition-colors">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="text-slate-400">Departamento:</span>
                <span class="font-semibold text-slate-900" x-text="selectedDepartment"></span>
                <svg class="w-3.5 h-3.5 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-xl p-2 z-40 text-xs">
                <button @click="selectedDepartment = 'All'; open = false; filterByDepartment();" class="w-full text-left px-3 py-1.5 hover:bg-slate-50 font-medium rounded-lg text-slate-700 flex items-center justify-between">
                    <span>Todos los Departamentos</span>
                    <svg x-show="selectedDepartment === 'All'" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
                <div class="my-1 border-t border-slate-100"></div>
                <template x-for="dept in rawData.departments" :key="dept">
                    <button @click="selectedDepartment = dept; open = false; filterByDepartment();" class="w-full text-left px-3 py-1.5 hover:bg-slate-50 rounded-lg text-slate-700 flex items-center justify-between">
                        <span x-text="dept"></span>
                        <svg x-show="selectedDepartment === dept" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Active Tag/Chips Band -->
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-xs font-medium text-slate-400 mr-1">Comparando ( <span x-text="selectedCandidates.length"></span> ):</span>

        <!-- Dynamic Candidate Chips with Distinct Colors -->
        <template x-for="cand in selectedCandidates" :key="cand.id">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-semibold shadow-2xs transition-all"
                 :style="`background-color: ${cand.color.bg}; border-color: ${cand.color.border}; color: ${cand.color.hex}`">
                <span class="w-2 h-2 rounded-full" :style="`background-color: ${cand.color.hex}`"></span>
                <span x-text="cand.name"></span>
                <span class="text-[10px] opacity-75 font-normal" x-text="`(${cand.overall_score}%)`"></span>
                <button @click="removeCandidate(cand.id)" class="ml-1 hover:opacity-100 opacity-60 transition-opacity" title="Quitar candidato">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>

        <!-- Department Tag if selected -->
        <template x-if="selectedDepartment !== 'All'">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 border border-slate-300 text-slate-700 text-xs font-semibold">
                <span>Dep: <span x-text="selectedDepartment"></span></span>
                <button @click="selectedDepartment = 'All'; filterByDepartment();" class="ml-1 hover:text-slate-900">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>

        <!-- Clear All Button -->
        <template x-if="selectedCandidates.length > 0">
            <button @click="clearAllCandidates()" class="text-xs text-slate-400 hover:text-red-500 font-medium underline ml-2 transition-colors">
                Limpiar todo
            </button>
        </template>
    </div>

    <!-- Charts Visualization Area Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Top Chart: Line Trend Evolution (Mes a mes) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Evolución en el tiempo</h2>
                    <p class="text-xs text-slate-400">Tendencia mensual de desempeño (Ene - Dic)</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                    <span class="text-xs text-slate-500 font-medium">Línea de tendencia</span>
                </div>
            </div>

            <div class="relative h-72 w-full">
                <canvas id="lineTrendChart"></canvas>
            </div>
        </div>

        <!-- Bottom Chart: Multiaxial Competency Radar Chart (8 Ejes) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Radar de Competencias</h2>
                    <p class="text-xs text-slate-400">Mapeo de 8 ejes (DISC + Aptitud Cognitiva + Fit General)</p>
                </div>
                
                <!-- Toggle Department Benchmark -->
                <button @click="toggleBenchmark()" 
                        class="px-2.5 py-1 rounded-lg text-xs font-semibold border transition-all"
                        :class="showBenchmark ? 'bg-slate-800 text-white border-slate-800' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100'">
                    <span x-text="showBenchmark ? 'Ocultar Media' : 'Mostrar Media'"></span>
                </button>
            </div>

            <div class="relative h-80 w-full flex items-center justify-center">
                <canvas id="competencyRadarChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Candidate Summary Cards Matrix -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Resumen de Evaluación Psicométrica y Ajuste de Perfil
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="cand in selectedCandidates" :key="cand.id">
                <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full font-bold flex items-center justify-center text-xs text-white shadow-xs"
                                 :style="`background-color: ${cand.color.hex}`"
                                 x-text="cand.avatar_initials"></div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900" x-text="cand.name"></h4>
                                <p class="text-[10px] text-slate-400" x-text="cand.applied_position"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-extrabold text-slate-900" x-text="`${cand.overall_score}%`"></span>
                            <p class="text-[10px] font-semibold text-indigo-600">Ajuste General</p>
                        </div>
                    </div>

                    <!-- Mini Competencies Progress Bars -->
                    <div class="space-y-1.5 pt-2 border-t border-slate-200/60 text-[11px]">
                        <div class="flex justify-between text-slate-600">
                            <span>Capacidad Analítica:</span>
                            <span class="font-bold text-slate-800" x-text="`${cand.scores[3]}%`"></span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" :style="`width: ${cand.scores[3]}%; background-color: ${cand.color.hex}`"></div>
                        </div>

                        <div class="flex justify-between text-slate-600 pt-1">
                            <span>Liderazgo (DISC D):</span>
                            <span class="font-bold text-slate-800" x-text="`${cand.scores[6]}%`"></span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" :style="`width: ${cand.scores[6]}%; background-color: ${cand.color.hex}`"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function comparisonApp(initialData) {
    return {
        rawData: initialData,
        selectedCandidates: initialData.selected_candidates || [],
        selectedCategory: 'Todas',
        selectedReviewer: 'Todos los Revisores',
        selectedDateRange: 'Últimos 365 días',
        selectedDepartment: 'All',
        showBenchmark: true,
        
        categories: ['Todas', 'Comunicación', 'Liderazgo', 'Capacidad Analítica', 'Planificación'],
        reviewers: ['Todos los Revisores', 'Manager RRHH', 'Tech Lead', 'Director Operaciones'],
        dateRanges: ['Últimos 30 días', 'Últimos 90 días', 'Últimos 365 días', 'Año Actual'],

        lineChart: null,
        radarChart: null,

        init() {
            this.$nextTick(() => {
                this.renderCharts();
            });
        },

        get exportUrl() {
            const candIds = this.selectedCandidates.map(c => c.id).join(',');
            return `{{ route('hr.compare.export') }}?candidates=${candIds}&department=${encodeURIComponent(this.selectedDepartment)}&date_range=${encodeURIComponent(this.selectedDateRange)}`;
        },

        filteredAllCandidates(searchQuery) {
            if (!searchQuery) return this.rawData.all_candidates;
            const q = searchQuery.toLowerCase();
            return this.rawData.all_candidates.filter(c => 
                c.name.toLowerCase().includes(q) || 
                c.email.toLowerCase().includes(q) || 
                c.position.toLowerCase().includes(q)
            );
        },

        isSelectedCandidate(id) {
            return this.selectedCandidates.some(c => c.id === id);
        },

        toggleCandidate(id) {
            if (this.isSelectedCandidate(id)) {
                this.removeCandidate(id);
            } else {
                this.addCandidate(id);
            }
        },

        addCandidate(id) {
            fetch(`{{ route('hr.compare') }}?candidates=${id}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                const newCand = data.selected_candidates[0];
                if (newCand && !this.isSelectedCandidate(newCand.id)) {
                    // Assign palette color based on index
                    const palette = this.rawData.selected_candidates[0]?.color || { hex: '#10b981', bg: 'rgba(16, 185, 129, 0.15)', border: '#10b981' };
                    const colors = [
                        { hex: '#f97316', bg: 'rgba(249, 115, 22, 0.15)', border: '#f97316' },
                        { hex: '#a855f7', bg: 'rgba(168, 85, 247, 0.15)', border: '#a855f7' },
                        { hex: '#06b6d4', bg: 'rgba(6, 182, 212, 0.15)', border: '#06b6d4' },
                        { hex: '#10b981', bg: 'rgba(16, 185, 129, 0.15)', border: '#10b981' },
                        { hex: '#ec4899', bg: 'rgba(236, 72, 153, 0.15)', border: '#ec4899' },
                        { hex: '#6366f1', bg: 'rgba(99, 102, 241, 0.15)', border: '#6366f1' },
                    ];
                    newCand.color = colors[this.selectedCandidates.length % colors.length];
                    this.selectedCandidates.push(newCand);
                    this.updateCharts();
                }
            });
        },

        removeCandidate(id) {
            this.selectedCandidates = this.selectedCandidates.filter(c => c.id !== id);
            this.updateCharts();
        },

        clearAllCandidates() {
            this.selectedCandidates = [];
            this.updateCharts();
        },

        filterByDepartment() {
            const candIds = this.selectedCandidates.map(c => c.id).join(',');
            fetch(`{{ route('hr.compare') }}?candidates=${candIds}&department=${encodeURIComponent(this.selectedDepartment)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                this.rawData.department_benchmark = data.department_benchmark;
                this.updateCharts();
            });
        },

        toggleBenchmark() {
            this.showBenchmark = !this.showBenchmark;
            this.updateCharts();
        },

        renderCharts() {
            this.renderLineChart();
            this.renderRadarChart();
        },

        renderLineChart() {
            const ctx = document.getElementById('lineTrendChart').getContext('2d');
            
            const datasets = this.selectedCandidates.map(cand => ({
                label: cand.name,
                data: cand.timeline,
                borderColor: cand.color.hex,
                backgroundColor: cand.color.bg,
                tension: 0.35,
                borderWidth: 2.5,
                pointRadius: 3,
                pointHoverRadius: 6,
            }));

            this.lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.rawData.timeline_labels,
                    datasets: datasets,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'bottom', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', size: 11 } } },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: {
                            min: 30,
                            max: 100,
                            grid: { color: 'rgba(226, 232, 240, 0.6)' },
                            ticks: { callback: v => v + '%' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        },

        renderRadarChart() {
            const ctx = document.getElementById('competencyRadarChart').getContext('2d');

            const datasets = this.selectedCandidates.map(cand => ({
                label: cand.name,
                data: cand.scores,
                borderColor: cand.color.hex,
                backgroundColor: cand.color.bg,
                borderWidth: 2,
                pointBackgroundColor: cand.color.hex,
                pointRadius: 3,
            }));

            if (this.showBenchmark) {
                datasets.push({
                    label: 'Media (Vacante / Puesto)',
                    data: this.rawData.department_benchmark,
                    borderColor: '#64748b',
                    borderDash: [5, 5],
                    backgroundColor: 'rgba(100, 116, 139, 0.05)',
                    borderWidth: 1.5,
                    pointRadius: 0,
                });
            }

            this.radarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: this.rawData.axes_labels,
                    datasets: datasets,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'bottom', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', size: 11 } } }
                    },
                    scales: {
                        r: {
                            min: 0,
                            max: 100,
                            ticks: { stepSize: 20, callback: v => v + '%' },
                            grid: { color: 'rgba(226, 232, 240, 0.8)' },
                            angleLines: { color: 'rgba(226, 232, 240, 0.8)' },
                            pointLabels: {
                                font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' },
                                color: '#475569'
                            }
                        }
                    }
                }
            });
        },

        updateCharts() {
            if (this.lineChart) {
                this.lineChart.data.datasets = this.selectedCandidates.map(cand => ({
                    label: cand.name,
                    data: cand.timeline,
                    borderColor: cand.color.hex,
                    backgroundColor: cand.color.bg,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                }));
                this.lineChart.update();
            }

            if (this.radarChart) {
                const radarDatasets = this.selectedCandidates.map(cand => ({
                    label: cand.name,
                    data: cand.scores,
                    borderColor: cand.color.hex,
                    backgroundColor: cand.color.bg,
                    borderWidth: 2,
                    pointBackgroundColor: cand.color.hex,
                    pointRadius: 3,
                }));

                if (this.showBenchmark) {
                    radarDatasets.push({
                        label: 'Media (Vacante / Puesto)',
                        data: this.rawData.department_benchmark,
                        borderColor: '#64748b',
                        borderDash: [5, 5],
                        backgroundColor: 'rgba(100, 116, 139, 0.05)',
                        borderWidth: 1.5,
                        pointRadius: 0,
                    });
                }

                this.radarChart.data.datasets = radarDatasets;
                this.radarChart.update();
            }
        }
    };
}
</script>
@endpush
