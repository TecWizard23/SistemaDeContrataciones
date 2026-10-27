<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ficha Técnica Psicométrica - {{ $candidate->full_name }}</title>
    <style>
        @page {
            margin: 25px 30px 45px 30px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.35;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Top Institutional Header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .brand-title {
            font-size: 15px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
            font-weight: 500;
        }

        .header-meta {
            text-align: right;
            font-size: 9px;
            color: #64748b;
            line-height: 1.4;
        }

        .header-meta strong {
            color: #0f172a;
        }

        .accent-strip {
            width: 100%;
            height: 3px;
            background-color: #4f46e5;
            margin-bottom: 14px;
        }

        /* Document Title */
        .doc-title-container {
            text-align: center;
            margin-bottom: 14px;
            padding: 6px 0;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .doc-title {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin: 0;
        }

        .doc-subtitle {
            font-size: 9.5px;
            color: #4f46e5;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Section Block Styling */
        .section-header {
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1.5px solid #4f46e5;
            padding-bottom: 3px;
            margin-top: 10px;
            margin-bottom: 6px;
        }

        /* General Information Grid (Table based) */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 4px 6px;
            font-size: 9.5px;
            border: 1px solid #e2e8f0;
        }

        .info-label {
            background-color: #f8fafc;
            font-weight: bold;
            color: #475569;
            width: 18%;
        }

        .info-value {
            color: #0f172a;
            width: 32%;
        }

        /* Executive Summary Two-Column Layout */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .summary-table > tbody > tr > td {
            vertical-align: top;
            width: 50%;
            padding: 0 4px;
        }

        .summary-card {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 10px;
            background-color: #ffffff;
            min-height: 85px;
        }

        .score-large {
            font-size: 26px;
            font-weight: bold;
            color: #059669;
            margin: 2px 0;
        }

        .badge-box {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-top: 4px;
        }

        /* Progress Bar Table */
        .bar-container-table {
            width: 100%;
            height: 8px;
            border-collapse: collapse;
            background-color: #e2e8f0;
            margin: 4px 0;
        }

        .bar-fill-cell {
            height: 8px;
            font-size: 1px;
            line-height: 1px;
        }

        .bar-empty-cell {
            height: 8px;
            background-color: #f1f5f9;
            font-size: 1px;
            line-height: 1px;
        }

        /* Data Tables for DISC / Cognitive */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 8px;
        }

        .data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-align: left;
            padding: 5px 6px;
            border: 1px solid #0f172a;
            text-transform: uppercase;
        }

        .data-table td {
            font-size: 9px;
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* Profile Description Box */
        .narrative-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #10b981;
            padding: 8px 10px;
            font-size: 9px;
            color: #166534;
            margin-top: 6px;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .narrative-box.blue {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
            border-left: 4px solid #4f46e5;
            color: #312e81;
        }

        /* Observations and Signatures Section */
        .obs-box {
            width: 100%;
            height: 52px;
            border: 1px dashed #94a3b8;
            background-color: #fafafa;
            margin-top: 4px;
            margin-bottom: 12px;
            padding: 6px;
            font-size: 8.5px;
            color: #64748b;
            box-sizing: border-box;
        }

        .signatures-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .signatures-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 25px;
        }

        .sig-line {
            border-top: 1px solid #475569;
            padding-top: 4px;
            font-size: 9px;
            color: #1e293b;
            font-weight: bold;
        }

        .sig-sub {
            font-size: 8px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Fixed Footer */
        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 25px;
            border-top: 0.5px solid #cbd5e1;
            padding-top: 4px;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            font-size: 8px;
            color: #94a3b8;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <!-- Institutional Header -->
    <table class="header-table">
        <tr>
            <td style="width: 65%;">
                <h1 class="brand-title">Fundación Munasim Kullakita</h1>
                <div class="brand-subtitle">Área de Gestión del Talento Humano &bull; Sistema de Contrataciones</div>
            </td>
            <td class="header-meta" style="width: 35%;">
                <div><strong>Código:</strong> {{ $reportCode }}</div>
                <div><strong>Fecha Emisión:</strong> {{ $reportDate }}</div>
                <div><strong>Sistema:</strong> Kullakita HR Analytics v2.0</div>
            </td>
        </tr>
    </table>

    <div class="accent-strip"></div>

    <!-- Document Title Banner -->
    <div class="doc-title-container">
        <h2 class="doc-title">Ficha Técnica y Reporte Psicométrico</h2>
        <div class="doc-subtitle">Evaluación de Competencias Laborales y Conductuales para Selección de Personal</div>
    </div>

    <!-- BLOQUE 1: Ficha General del Postulante -->
    <div class="section-header">1. Información General del Postulante</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Nombre Completo:</td>
            <td class="info-value" style="font-weight: bold;">{{ $candidate->full_name }}</td>
            <td class="info-label">Cargo Postulado:</td>
            <td class="info-value font-bold" style="color: #4f46e5;">{{ $candidate->applied_position }}</td>
        </tr>
        <tr>
            <td class="info-label">Correo Electrónico:</td>
            <td class="info-value">{{ $candidate->email }}</td>
            <td class="info-label">Teléfono / Celular:</td>
            <td class="info-value">{{ $candidate->phone ?? 'No especificado' }}</td>
        </tr>
        <tr>
            <td class="info-label">Código de Sesión:</td>
            <td class="info-value">#{{ $session->id }}</td>
            <td class="info-label">Tipo de Evaluación:</td>
            <td class="info-value font-bold">{{ $evaluation->title }} ({{ $evalType }})</td>
        </tr>
    </table>

    <!-- BLOQUE 2: Resumen Ejecutivo de Evaluación -->
    <div class="section-header">2. Resumen Ejecutivo y Nivel de Idoneidad</div>
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-card">
                    <div style="font-size: 8.5px; font-weight: bold; color: #64748b; text-transform: uppercase;">
                        Índice de Adecuación al Puesto (Fit Score)
                    </div>
                    <div class="score-large" style="color: {{ $suitability['badge_color'] }};">
                        {{ number_format($fitPercentage, 1) }}%
                    </div>
                    
                    <!-- Progress Bar Simulation for DomPDF -->
                    @php
                        $fillWidth = min(100, max(1, (int)$fitPercentage));
                        $emptyWidth = 100 - $fillWidth;
                    @endphp
                    <table class="bar-container-table">
                        <tr>
                            <td class="bar-fill-cell" style="width: {{ $fillWidth }}%; background-color: {{ $suitability['badge_color'] }};"></td>
                            @if($emptyWidth > 0)
                                <td class="bar-empty-cell" style="width: {{ $emptyWidth }}%;"></td>
                            @endif
                        </tr>
                    </table>
                    <div style="font-size: 8px; color: #64748b; margin-top: 3px;">
                        Puntaje Bruto Registrado: <strong>{{ $session->raw_score ?? 0 }} pts</strong>
                    </div>
                </div>
            </td>
            <td>
                <div class="summary-card">
                    <div style="font-size: 8.5px; font-weight: bold; color: #64748b; text-transform: uppercase;">
                        Dictamen de Recomendación
                    </div>
                    <div class="badge-box" style="background-color: {{ $suitability['badge_bg'] }}; border: 1px solid {{ $suitability['border_color'] }}; color: {{ $suitability['text_color'] }};">
                        &bull; {{ $suitability['label'] }}
                    </div>
                    <div style="font-size: 8.5px; color: #475569; margin-top: 6px; line-height: 1.3;">
                        {{ $suitability['description'] }}
                    </div>
                    <div style="font-size: 8px; color: #64748b; margin-top: 4px; border-top: 0.5px solid #e2e8f0; padding-top: 2px;">
                        Fecha: <strong>{{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i') : 'N/A' }}</strong> &bull; Duración: <strong>{{ $durationFormatted }}</strong>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- BLOQUE 3: Resultados Específicos según Evaluación -->
    @if($evalType === 'DISC' || $evalType === 'SITUATIONAL')
        <div class="section-header">3. Mapeo del Perfil Conductual (Modelo DISC)</div>

        @if(!empty($discData['profileTitle']))
            <div class="narrative-box">
                <div style="font-weight: bold; font-size: 10px; margin-bottom: 2px; color: #065f46;">
                    {{ $discData['profileTitle'] }}
                </div>
                <div>{{ $discData['profileSummary'] }}</div>
            </div>
        @endif

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 28%;">Dimensión Evaluada</th>
                    <th style="width: 14%; text-align: center;">Puntaje (%)</th>
                    <th style="width: 28%;">Intensidad Visual</th>
                    <th style="width: 30%;">Enfoque Laboral</th>
                </tr>
            </thead>
            <tbody>
                @foreach($discData['traitsTable'] as $trait)
                    @php
                        $traitPercent = min(100, max(0, (float)$trait['percentage']));
                        $traitFill = max(2, (int)$traitPercent);
                        $traitEmpty = 100 - $traitFill;
                    @endphp
                    <tr>
                        <td>
                            <strong style="color: {{ $trait['color'] }};">{{ $trait['name'] }}</strong>
                            <div style="font-size: 8px; color: #64748b;">{{ $trait['focus'] }}</div>
                        </td>
                        <td class="text-center font-bold" style="font-size: 10.5px; color: {{ $trait['color'] }};">
                            {{ number_format($trait['percentage'], 1) }}%
                        </td>
                        <td>
                            <table class="bar-container-table" style="height: 9px;">
                                <tr>
                                    <td class="bar-fill-cell" style="width: {{ $traitFill }}%; background-color: {{ $trait['color'] }};"></td>
                                    @if($traitEmpty > 0)
                                        <td class="bar-empty-cell" style="width: {{ $traitEmpty }}%;"></td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                        <td style="font-size: 8.5px; line-height: 1.25; color: #334155;">
                            {{ $trait['description'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($evalType === 'COGNITIVE')
        <div class="section-header">3. Balance de Habilidad Cognitiva y Rendimiento</div>

        <table class="data-table" style="margin-bottom: 6px;">
            <thead>
                <tr>
                    <th class="text-center" style="width: 25%;">Reactivos Totales</th>
                    <th class="text-center" style="width: 25%;">Aciertos Correctos</th>
                    <th class="text-center" style="width: 25%;">Errores / Omitidos</th>
                    <th class="text-center" style="width: 25%;">Nivel Cualitativo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center font-bold" style="font-size: 13px;">{{ $cognitiveData['totalQuestions'] }}</td>
                    <td class="text-center font-bold" style="font-size: 13px; color: #059669;">{{ $cognitiveData['correctAnswers'] }}</td>
                    <td class="text-center font-bold" style="font-size: 13px; color: #dc2626;">{{ $cognitiveData['incorrectAnswers'] }}</td>
                    <td class="text-center font-bold" style="font-size: 12px; color: #4f46e5; text-transform: uppercase;">
                        {{ $cognitiveData['qualitativeLevel'] }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="narrative-box blue">
            <div style="font-weight: bold; font-size: 9.5px; margin-bottom: 2px;">Dictamen de Agilidad Analítica y Resolución de Problemas:</div>
            <div>{{ $cognitiveData['analyticalAgility'] }}</div>
        </div>

    @else
        <div class="section-header">3. Detalle General de la Prueba</div>
        <p style="font-size: 9px; color: #475569;">
            Sesión registrada bajo la modalidad estándar de evaluación. Puntuación bruta obtenida: <strong>{{ $session->raw_score }}</strong> con un nivel de ajuste del <strong>{{ number_format($fitPercentage, 1) }}%</strong>.
        </p>
    @endif

    <!-- BLOQUE 4: Observaciones y Validación Interna -->
    <div class="section-header">4. Observaciones del Comité y Validación Interna</div>
    
    <div style="font-size: 8.5px; font-weight: bold; color: #475569; margin-top: 3px;">
        Notas y Recomendaciones de la Entrevista Técnica / Psicotécnica:
    </div>
    <div class="obs-box">
        <!-- Espacio en blanco punteado reservado para anotaciones manuscritas o de validación -->
    </div>

    <!-- Signatures Table -->
    <table class="signatures-table">
        <tr>
            <td>
                <div class="sig-line">Evaluador de Talento Humano</div>
                <div class="sig-sub">Área de Selección &bull; Fundación Munasim Kullakita</div>
            </td>
            <td>
                <div class="sig-line">Jefatura de Gestión de Personas</div>
                <div class="sig-sub">Visto Bueno Institucional &bull; FMK</div>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td style="text-align: left; width: 65%;">
                    Fundación Munasim Kullakita &bull; Documento Institucional Estrictamente Confidencial
                </td>
                <td style="text-align: right; width: 35%;">
                    Ficha Técnica FMK #{{ $session->id }}
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
