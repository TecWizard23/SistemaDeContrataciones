@extends('layouts.fmk')

@section('title', 'Analítica & Estadísticas de Contratación - Munasim Kullakita')

@section('content')
<div class="space-y-6">

    <!-- Hero Banner Superior Verde FMK -->
    <div class="relative bg-gradient-to-r from-[#10b981] to-[#059669] rounded-3xl p-8 text-white shadow-xl overflow-hidden">
        <!-- Accent Pattern Background -->
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white select-none pointer-events-none">
            <svg class="w-48 h-48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>

        <div class="relative z-10 space-y-3">
            <div class="flex items-center gap-3">
                <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full border border-white/30 uppercase tracking-wider">
                    Módulo RRHH - Munasim Kullakita
                </span>
                <span class="text-xs text-emerald-100 font-semibold flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    Actualizado en tiempo real
                </span>
            </div>

            <h1 class="text-3xl font-extrabold tracking-tight">
                Estadísticas y Métricas de Contratación
            </h1>
            <p class="text-sm text-emerald-50 max-w-2xl font-medium">
                Panel analítico de adecuación psicométrica, distribución por perfil conductual DISC y desempeño comparativo de postulantes.
            </p>
        </div>
    </div>

    <!-- Filtro Superior en Cascada -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('analytics.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <!-- Filter 1: Puesto / Vacante -->
            <div class="flex items-center gap-2">
                <label for="position" class="text-xs font-bold text-slate-500">Puesto / Vacante:</label>
                <select name="position" id="position" onchange="this.form.submit()" 
                        class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ $selectedPosition === $pos ? 'selected' : '' }}>
                            {{ $pos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter 2: Rango de Fechas -->
            <div class="flex items-center gap-2">
                <label for="date_range" class="text-xs font-bold text-slate-500">Periodo:</label>
                <select name="date_range" id="date_range" onchange="this.form.submit()" 
                        class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                    <option value="Últimos 30 días" {{ $selectedDateRange === 'Últimos 30 días' ? 'selected' : '' }}>Últimos 30 días</option>
                    <option value="Últimos 90 días" {{ $selectedDateRange === 'Últimos 90 días' ? 'selected' : '' }}>Últimos 90 días</option>
                    <option value="Últimos 365 días" {{ $selectedDateRange === 'Últimos 365 días' ? 'selected' : '' }}>Últimos 365 días</option>
                    <option value="Año Actual" {{ $selectedDateRange === 'Año Actual' ? 'selected' : '' }}>Año Actual</option>
                </select>
            </div>
        </form>

        <div class="text-xs font-semibold text-slate-400">
            Filtro activo: <span class="text-[#00a8cc] font-bold">{{ $selectedPosition }}</span> &bull; {{ $selectedDateRange }}
        </div>
    </div>

    <!-- Fila de 4 Tarjetas de Métricas KPI FMK (4 Colores Corporativos) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Card 1: Azul Vibrante (#1d4ed8) -> Total Postulantes -->
        <div class="bg-[#1d4ed8] text-white rounded-2xl p-6 shadow-md shadow-blue-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Total Postulantes</p>
                <p class="text-3xl font-extrabold">{{ number_format($totalCandidates) }}</p>
                <p class="text-[11px] text-blue-200">Registrados en la plataforma</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: Verde Institucional (#059669) -> Exámenes Aprobados / Fit Alto -->
        <div class="bg-[#059669] text-white rounded-2xl p-6 shadow-md shadow-emerald-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-emerald-100 uppercase tracking-wider">Exámenes Aprobados</p>
                <p class="text-3xl font-extrabold">{{ number_format($completedSessions) }}</p>
                <p class="text-[11px] text-emerald-200">Sesiones evaluadas (Fit Alto)</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 3: Mostaza / Naranja (#f59e0b) -> Promedio Fit General -->
        <div class="bg-[#f59e0b] text-white rounded-2xl p-6 shadow-md shadow-amber-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-amber-100 uppercase tracking-wider">Fit Promedio Global</p>
                <p class="text-3xl font-extrabold">{{ $avgFitGlobal }}%</p>
                <p class="text-[11px] text-amber-100">Adecuación al puesto laboral</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>

        <!-- Card 4: Celeste Turquesa (#06b6d4) -> Tasa de Retención Estimada -->
        <div class="bg-[#06b6d4] text-white rounded-2xl p-6 shadow-md shadow-cyan-500/10 flex items-center justify-between relative overflow-hidden">
            <div class="space-y-1 relative z-10">
                <p class="text-xs font-semibold text-cyan-100 uppercase tracking-wider">Retención Estimada</p>
                <p class="text-3xl font-extrabold">{{ $estimatedRetention }}%</p>
                <p class="text-[11px] text-cyan-100">Proyección de estabilidad laboral</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-xs flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Sección de Gráficos Interactivos (Chart.js) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Panel Izquierdo: Radar de Competencias (8 Dimensiones) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Radar Multiaxial de Competencias</h2>
                    <p class="text-xs text-slate-400">Comparación de las 8 dimensiones evaluadas vs. Perfil Ideal</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-sky-50 text-[#00a8cc] rounded-lg border border-sky-200">
                    8 Ejes FMK
                </span>
            </div>

            <div class="relative h-80 w-full flex items-center justify-center">
                <canvas id="fmkRadarChart"></canvas>
            </div>
        </div>

        <!-- Panel Derecho: Distribución de Perfiles DISC -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Distribución de Perfiles Conductuales (DISC)</h2>
                    <p class="text-xs text-slate-400">Proporción de estilos conductuales dominantes en candidatos</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-amber-50 text-amber-700 rounded-lg border border-amber-200">
                    DISC Psicometría
                </span>
            </div>

            <div class="relative h-80 w-full flex items-center justify-center">
                <canvas id="fmkDiscChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Panel Inferior: Línea de Tiempo de Evaluaciones -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Línea de Tiempo y Tendencia Mensual</h2>
                <p class="text-xs text-slate-400">Volumen de postulaciones y exámenes procesados de Enero a Diciembre</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-[#00a8cc]"></span>
                    <span class="text-slate-600">Postulaciones</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-[#10b981]"></span>
                    <span class="text-slate-600">Exámenes Completados</span>
                </div>
            </div>
        </div>

        <div class="relative h-72 w-full">
            <canvas id="fmkTimelineChart"></canvas>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. Radar Chart Configuration (8 Dimensions)
    const ctxRadar = document.getElementById('fmkRadarChart').getContext('2d');
    new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: @json($dimensions),
            datasets: [
                {
                    label: 'Perfil Promedio Postulantes',
                    data: @json($candidateRadarScores),
                    borderColor: '#00a8cc',
                    backgroundColor: 'rgba(0, 168, 204, 0.2)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#00a8cc',
                    pointRadius: 4,
                },
                {
                    label: 'Perfil Ideal del Cargo',
                    data: @json($idealCargoProfile),
                    borderColor: '#f59e0b',
                    borderDash: [4, 4],
                    backgroundColor: 'rgba(245, 158, 11, 0.08)',
                    borderWidth: 2,
                    pointRadius: 0,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', size: 11 } } },
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
                        color: '#334155'
                    }
                }
            }
        }
    });

    // 2. DISC Doughnut Chart Configuration
    const ctxDisc = document.getElementById('fmkDiscChart').getContext('2d');
    const discData = @json(array_values($discDistribution));
    const discLabels = @json(array_keys($discDistribution));

    new Chart(ctxDisc, {
        type: 'doughnut',
        data: {
            labels: discLabels,
            datasets: [{
                data: discData,
                backgroundColor: [
                    '#ef4444', // Dominante - Red
                    '#f59e0b', // Influyente - Yellow/Amber
                    '#10b981', // Estable - Emerald Green
                    '#3b82f6', // Cumplidor - Blue
                ],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', size: 11 } } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ` ${context.label}: ${context.raw} candidatos`;
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });

    // 3. Timeline Line Chart Configuration
    const ctxTimeline = document.getElementById('fmkTimelineChart').getContext('2d');
    new Chart(ctxTimeline, {
        type: 'line',
        data: {
            labels: @json($timelineLabels),
            datasets: [
                {
                    label: 'Postulaciones Totales',
                    data: @json($timelineData),
                    borderColor: '#00a8cc',
                    backgroundColor: 'rgba(0, 168, 204, 0.1)',
                    tension: 0.35,
                    borderWidth: 3,
                    fill: true,
                    pointRadius: 4,
                },
                {
                    label: 'Exámenes Completados',
                    data: @json($completedTimelineData),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    tension: 0.35,
                    borderWidth: 2.5,
                    borderDash: [3, 3],
                    pointRadius: 3,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226, 232, 240, 0.6)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

});
</script>
@endpush
