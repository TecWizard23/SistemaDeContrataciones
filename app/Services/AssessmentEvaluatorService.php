<?php

namespace App\Services;

use App\Models\CandidateSession;
use App\Services\Scoring\CognitiveStrategy;
use App\Services\Scoring\DiscStrategy;
use App\Services\Scoring\ScoringStrategyInterface;
use InvalidArgumentException;

class AssessmentEvaluatorService
{
    /**
     * Factory method to resolve scoring strategy polymorphically.
     */
    public function resolveStrategy(string $type): ScoringStrategyInterface
    {
        return match (strtoupper($type)) {
            'COGNITIVE' => new CognitiveStrategy(),
            'DISC', 'SITUATIONAL' => new DiscStrategy(),
            default => throw new InvalidArgumentException("Tipo de evaluación no soportado: [{$type}]"),
        };
    }

    /**
     * Evaluates a candidate session, persists the results and updates status.
     */
    public function evaluateSession(CandidateSession $session): CandidateSession
    {
        $session->loadMissing(['evaluation', 'answers.question']);

        $strategy = $this->resolveStrategy($session->evaluation->type);
        $results = $strategy->evaluate($session);

        $session->update([
            'status' => 'COMPLETED',
            'completed_at' => now(),
            'raw_score' => $results['raw_score'],
            'fit_percentage' => $results['fit_percentage'],
            'metrics_summary' => $results['metrics_summary'],
        ]);

        return $session;
    }
}
