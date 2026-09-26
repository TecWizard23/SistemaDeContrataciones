<?php

namespace App\Services\Scoring;

use App\Models\CandidateSession;

interface ScoringStrategyInterface
{
    /**
     * Evaluate a candidate session and return structured evaluation result.
     *
     * @param CandidateSession $session
     * @return array{raw_score: float, fit_percentage: float, metrics_summary: array}
     */
    public function evaluate(CandidateSession $session): array;
}
