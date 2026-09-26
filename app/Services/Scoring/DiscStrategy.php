<?php

namespace App\Services\Scoring;

use App\Models\CandidateSession;

class DiscStrategy implements ScoringStrategyInterface
{
    private const TRAIT_LABELS = [
        'D' => 'Dominancia (Orientado a Resultados)',
        'I' => 'Influencia (Orientado a Personas)',
        'S' => 'Serenidad/Estabilidad (Orientado al Equipo)',
        'C' => 'Cumplimiento/Concienzudo (Orientado a Procesos)',
    ];

    public function evaluate(CandidateSession $session): array
    {
        $answers = $session->answers()->with('question')->get();
        $totalAnswers = $answers->count();

        $traitCounts = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];

        foreach ($answers as $answer) {
            $question = $answer->question;
            $selectedKey = $answer->selected_option;

            $assignedTrait = null;

            if ($question && is_array($question->options)) {
                foreach ($question->options as $opt) {
                    if (isset($opt['key']) && strtoupper(trim($opt['key'])) === strtoupper(trim($selectedKey))) {
                        $assignedTrait = strtoupper(trim($opt['trait'] ?? ''));
                        break;
                    }
                }
            }

            if ($assignedTrait && isset($traitCounts[$assignedTrait])) {
                $traitCounts[$assignedTrait]++;
            }

            $answer->update([
                'is_correct' => null,
                'score' => 1.00,
            ]);
        }

        $percentages = [];
        foreach ($traitCounts as $trait => $count) {
            $percentages[$trait] = $totalAnswers > 0 ? round(($count / $totalAnswers) * 100, 2) : 0;
        }

        // Sort traits by count descending
        arsort($traitCounts);
        $keys = array_keys($traitCounts);

        $primaryTrait = $keys[0] ?? 'D';
        $secondaryTrait = $keys[1] ?? 'I';

        $primaryLabel = self::TRAIT_LABELS[$primaryTrait] ?? $primaryTrait;
        $secondaryLabel = self::TRAIT_LABELS[$secondaryTrait] ?? $secondaryTrait;

        $profileCode = $primaryTrait . ($percentages[$secondaryTrait] > 15 ? $secondaryTrait : '');
        $profileDescription = "Perfil Conductual {$profileCode}: Estilo Primario {$primaryLabel} con tendencia secundaria en {$secondaryLabel}.";

        // Fit percentage based on primary trait dominance strength
        $fitPercentage = $percentages[$primaryTrait];

        return [
            'raw_score' => (float) $traitCounts[$primaryTrait],
            'fit_percentage' => (float) round($fitPercentage, 2),
            'metrics_summary' => [
                'total_questions' => $totalAnswers,
                'trait_counts' => $traitCounts,
                'trait_percentages' => $percentages,
                'primary_style' => $primaryTrait,
                'primary_label' => $primaryLabel,
                'secondary_style' => $secondaryTrait,
                'secondary_label' => $secondaryLabel,
                'profile_code' => $profileCode,
                'profile_description' => $profileDescription,
            ],
        ];
    }
}
