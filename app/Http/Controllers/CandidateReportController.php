<?php

namespace App\Http\Controllers;

use App\Models\CandidateSession;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CandidateReportController extends Controller
{
    /**
     * Trait definitions and behavioral descriptions for DISC assessment.
     */
    private const DISC_TRAITS = [
        'D' => [
            'name' => 'Dominancia (D)',
            'short' => 'Dominancia',
            'focus' => 'Orientado a Resultados',
            'color' => '#dc2626', // Red
            'description' => 'Enfocado en superar desafíos, toma de decisiones rápida, firmeza, asertividad y orientación al logro de objetivos estratégicos.',
        ],
        'I' => [
            'name' => 'Influencia (I)',
            'short' => 'Influencia',
            'focus' => 'Orientado a Personas',
            'color' => '#d97706', // Amber/Yellow
            'description' => 'Habilidad para persuadir, comunicar con entusiasmo, generar alianzas, empatía interpersonal y dinamizar el trabajo en equipo.',
        ],
        'S' => [
            'name' => 'Estabilidad (S)',
            'short' => 'Estabilidad',
            'focus' => 'Orientado al Equipo y Constancia',
            'color' => '#059669', // Emerald/Green
            'description' => 'Paciencia, perseverancia, escucha activa, lealtad y consistencia en la ejecución metódica en ambientes estructurados.',
        ],
        'C' => [
            'name' => 'Cumplimiento (C)',
            'short' => 'Cumplimiento',
            'focus' => 'Orientado a Procesos y Normas',
            'color' => '#2563eb', // Blue
            'description' => 'Rigurosidad analítica, apego a normativas de calidad, precisión técnica, atención minuciosa al detalle y objetividad.',
        ],
    ];

    /**
     * Export Technical & Psychometric Candidate Sheet as PDF.
     *
     * @param CandidateSession $session
     * @return Response
     */
    public function exportPdf(CandidateSession $session)
    {
        // 1. Authorization: Only HR staff can download technical reports
        if (!Auth::check() || !Auth::user()->isHR()) {
            abort(403, 'Acceso restringido: Solo personal autorizado de Recursos Humanos de FMK puede acceder a este reporte.');
        }

        // 2. Eager loading relationships
        $session->loadMissing(['candidate', 'evaluation', 'answers.question']);

        $candidate = $session->candidate;
        $evaluation = $session->evaluation;
        $evalType = strtoupper($evaluation->type ?? 'GENERIC');
        $metrics = $session->metrics_summary ?? [];

        // 3. Suitability Status (Idoneidad del Candidato)
        $fitPercentage = (float) round($session->fit_percentage ?? 0, 1);
        $suitability = $this->resolveSuitability($fitPercentage);

        // 4. Elapsed time calculation
        $durationFormatted = $this->calculateDuration($session->started_at, $session->completed_at);

        // 5. Type-specific metric processing
        $discData = null;
        $cognitiveData = null;

        if ($evalType === 'DISC' || $evalType === 'SITUATIONAL') {
            $discData = $this->processDiscMetrics($session, $metrics);
        } elseif ($evalType === 'COGNITIVE') {
            $cognitiveData = $this->processCognitiveMetrics($session, $metrics, $fitPercentage);
        }

        // 6. Report metadata
        $reportDate = Carbon::now()->format('d/m/Y H:i');
        $reportCode = sprintf('FMK-RRHH-%04d-%04d', $candidate->id ?? 0, $session->id);

        $data = [
            'session' => $session,
            'candidate' => $candidate,
            'evaluation' => $evaluation,
            'evalType' => $evalType,
            'fitPercentage' => $fitPercentage,
            'suitability' => $suitability,
            'durationFormatted' => $durationFormatted,
            'discData' => $discData,
            'cognitiveData' => $cognitiveData,
            'reportDate' => $reportDate,
            'reportCode' => $reportCode,
        ];

        // 7. Generate PDF with dompdf
        $pdf = Pdf::loadView('reports.candidate_pdf', $data)
            ->setPaper('letter', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $fileName = sprintf('Ficha_Psicometrica_%s_%s.pdf', $candidate->id ?? '0', $session->id);

        return $pdf->stream($fileName);
    }

    /**
     * Determine candidate suitability status based on Fit Percentage.
     */
    private function resolveSuitability(float $fit): array
    {
        if ($fit >= 80.0) {
            return [
                'label' => 'Altamente Recomendado',
                'status' => 'HIGH',
                'badge_color' => '#059669', // Emerald
                'badge_bg' => '#ecfdf5',
                'border_color' => '#a7f3d0',
                'text_color' => '#065f46',
                'description' => 'El postulante supera ampliamente las competencias requeridas para el perfil del puesto en FMK.',
            ];
        }

        if ($fit >= 60.0) {
            return [
                'label' => 'Recomendado con Observaciones',
                'status' => 'MEDIUM',
                'badge_color' => '#d97706', // Amber
                'badge_bg' => '#fffbeb',
                'border_color' => '#fde68a',
                'text_color' => '#92400e',
                'description' => 'El postulante cumple con el perfil base requerido, recomendándose profundizar en áreas específicas durante la entrevista.',
            ];
        }

        return [
            'label' => 'No Recomendado',
            'status' => 'LOW',
            'badge_color' => '#dc2626', // Red
            'badge_bg' => '#fef2f2',
            'border_color' => '#fecaca',
            'text_color' => '#991b1b',
            'description' => 'El postulante no alcanza el umbral mínimo de idoneidad técnica o conductual para este cargo.',
        ];
    }

    /**
     * Calculate formatted duration between started and completed dates.
     */
    private function calculateDuration(?Carbon $start, ?Carbon $end): string
    {
        if (!$start || !$end) {
            return 'N/A';
        }

        $totalSeconds = max(0, $start->diffInSeconds($end));
        $minutes = floor($totalSeconds / 60);
        $seconds = $totalSeconds % 60;

        if ($minutes == 0) {
            return "{$seconds} seg";
        }

        return sprintf('%d min %02d seg', $minutes, $seconds);
    }

    /**
     * Process DISC dimensions, relative percentages, and primary/secondary style interpretation.
     */
    private function processDiscMetrics(CandidateSession $session, array $metrics): array
    {
        // Extract raw scores or percentages from metrics_summary
        $rawScores = $metrics['scores'] ?? [];

        if (empty($rawScores) && isset($metrics['trait_counts'])) {
            $rawScores = $metrics['trait_counts'];
        }

        // Fallback: If not in metrics, compute dynamically from recorded session answers
        if (empty($rawScores)) {
            $rawScores = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
            foreach ($session->answers as $ans) {
                $question = $ans->question;
                if ($question && is_array($question->options)) {
                    foreach ($question->options as $opt) {
                        if (isset($opt['key']) && strtoupper(trim($opt['key'])) === strtoupper(trim($ans->selected_option))) {
                            $trait = strtoupper(trim($opt['trait'] ?? ''));
                            if (isset($rawScores[$trait])) {
                                $rawScores[$trait]++;
                            }
                            break;
                        }
                    }
                }
            }
        }

        // Ensure all 4 dimensions are set
        $dimensions = [
            'D' => (float) ($rawScores['D'] ?? 0),
            'I' => (float) ($rawScores['I'] ?? 0),
            'S' => (float) ($rawScores['S'] ?? 0),
            'C' => (float) ($rawScores['C'] ?? 0),
        ];

        $totalPoints = array_sum($dimensions);

        // Calculate relative percentages (0 to 100%)
        $percentages = [];
        foreach ($dimensions as $key => $val) {
            if ($totalPoints > 0) {
                // If scores are already in 0-100 scale (from seeders) vs counts
                if ($totalPoints > 100) {
                    $percentages[$key] = round(($val / $totalPoints) * 100, 1);
                } else {
                    $percentages[$key] = round(($val / $totalPoints) * 100, 1);
                }
            } else {
                $percentages[$key] = 25.0;
            }
        }

        // Sort descending to find primary and secondary styles
        $sorted = $percentages;
        arsort($sorted);
        $keys = array_keys($sorted);

        $primaryKey = $keys[0] ?? 'D';
        $secondaryKey = $keys[1] ?? 'I';

        $primaryInfo = self::DISC_TRAITS[$primaryKey] ?? self::DISC_TRAITS['D'];
        $secondaryInfo = self::DISC_TRAITS[$secondaryKey] ?? self::DISC_TRAITS['I'];

        $profileCode = $primaryKey . $secondaryKey;
        $profileTitle = sprintf('Estilo Conductual %s: %s con tendencia en %s',
            $profileCode,
            $primaryInfo['short'],
            $secondaryInfo['short']
        );

        $profileSummary = sprintf(
            'El candidato presenta una marcada inclinación hacia la dimensión de %s (%s%%), lo cual indica que en su desempeño laboral destaca por ser %s. Como factor secundario, manifiesta rasgos de %s (%s%%), reflejando %s.',
            $primaryInfo['name'],
            $percentages[$primaryKey],
            mb_strtolower($primaryInfo['description']),
            $secondaryInfo['name'],
            $percentages[$secondaryKey],
            mb_strtolower($secondaryInfo['description'])
        );

        // Build detailed rows for blade table
        $traitsTable = [];
        foreach (self::DISC_TRAITS as $key => $info) {
            $traitsTable[$key] = [
                'code' => $key,
                'name' => $info['name'],
                'short' => $info['short'],
                'focus' => $info['focus'],
                'score' => $dimensions[$key],
                'percentage' => $percentages[$key],
                'color' => $info['color'],
                'description' => $info['description'],
                'is_primary' => ($key === $primaryKey),
                'is_secondary' => ($key === $secondaryKey),
            ];
        }

        return [
            'traitsTable' => $traitsTable,
            'primaryKey' => $primaryKey,
            'primaryName' => $primaryInfo['name'],
            'secondaryKey' => $secondaryKey,
            'secondaryName' => $secondaryInfo['name'],
            'profileCode' => $profileCode,
            'profileTitle' => $profileTitle,
            'profileSummary' => $profileSummary,
        ];
    }

    /**
     * Process Cognitive evaluation balance, qualitative level, and analytical agility assessment.
     */
    private function processCognitiveMetrics(CandidateSession $session, array $metrics, float $fitPercentage): array
    {
        $totalQuestions = (int) ($metrics['total_questions'] ?? $session->answers->count() ?: 0);
        $correctAnswers = (int) ($metrics['correct_answers'] ?? $metrics['correct_count'] ?? 0);

        if ($totalQuestions === 0 && $session->answers->isNotEmpty()) {
            $totalQuestions = $session->answers->count();
            $correctAnswers = $session->answers->where('is_correct', true)->count();
        }

        $incorrectAnswers = max(0, $totalQuestions - $correctAnswers);
        $accuracyRate = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 1) : $fitPercentage;

        $qualitativeLevel = $metrics['qualitative_level'] ?? match (true) {
            $accuracyRate >= 85.0 => 'Superior',
            $accuracyRate >= 70.0 => 'Promedio Alto',
            $accuracyRate >= 50.0 => 'Promedio',
            default => 'Bajo el Umbral',
        };

        $analyticalAgility = match ($qualitativeLevel) {
            'Superior' => 'Demuestra una capacidad sobresaliente de razonamiento lógico, pensamiento crítico abstracto y asimilación rápida de problemas complejos.',
            'Promedio Alto' => 'Evidencia sólida capacidad analítica, buen discernimiento en la toma de decisiones técnicas y agilidad adecuada en resolución de situaciones estructuradas.',
            'Promedio' => 'Presenta un nivel cognitivo funcional y acorde a la media esperada. Resuelve favorablemente tareas con lineamientos establecidos.',
            default => 'Registra dificultad en el procesamiento analítico bajo presión de tiempo o frente a reactivos lógicos de mediana complejidad.',
        };

        return [
            'totalQuestions' => $totalQuestions,
            'correctAnswers' => $correctAnswers,
            'incorrectAnswers' => $incorrectAnswers,
            'accuracyRate' => $accuracyRate,
            'qualitativeLevel' => $qualitativeLevel,
            'analyticalAgility' => $analyticalAgility,
            'rawScore' => $session->raw_score,
        ];
    }
}
