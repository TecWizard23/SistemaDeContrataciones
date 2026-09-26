<?php

namespace App\Services\Scoring;

use App\Models\CandidateSession;

class CognitiveStrategy implements ScoringStrategyInterface
{
    public function evaluate(CandidateSession $session): array
    {
        $answers = $session->answers()->with('question')->get();
        $totalQuestions = $answers->count();
        $correctCount = 0;
        $totalPointsEarned = 0;
        $maxPossiblePoints = 0;

        foreach ($answers as $answer) {
            $question = $answer->question;
            $points = $question->points ?? 1;
            $maxPossiblePoints += $points;

            $isCorrect = false;
            if ($question && !is_null($answer->selected_option) && !is_null($question->correct_option)) {
                $isCorrect = (strtoupper(trim($answer->selected_option)) === strtoupper(trim($question->correct_option)));
            }

            $score = $isCorrect ? $points : 0;
            if ($isCorrect) {
                $correctCount++;
                $totalPointsEarned += $points;
            }

            $answer->update([
                'is_correct' => $isCorrect,
                'score' => $score,
            ]);
        }

        $accuracyPercentage = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;

        $qualitativeLevel = match (true) {
            $accuracyPercentage >= 85 => 'Superior',
            $accuracyPercentage >= 70 => 'Promedio Alto',
            $accuracyPercentage >= 50 => 'Promedio',
            default => 'Bajo el umbral',
        };

        return [
            'raw_score' => (float) $totalPointsEarned,
            'fit_percentage' => (float) round($accuracyPercentage, 2),
            'metrics_summary' => [
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctCount,
                'total_points' => $maxPossiblePoints,
                'earned_points' => $totalPointsEarned,
                'qualitative_level' => $qualitativeLevel,
                'accuracy_percentage' => round($accuracyPercentage, 2),
            ],
        ];
    }
}
