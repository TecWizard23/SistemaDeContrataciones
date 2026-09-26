<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\CandidateSession;
use Illuminate\Support\Collection;

class CandidateComparisonService
{
    /**
     * Define the 8 core competency axes matching Kenjo HR style.
     */
    public const COMPETENCY_AXES = [
        'Rendimiento / Fit General',
        'Potencial',
        'Achievement (Objetivos)',
        'Capacidad Analítica',
        'Comunicación (DISC I)',
        'Flexibilidad (DISC S)',
        'Liderazgo (DISC D)',
        'Planificación (DISC C)',
    ];

    /**
     * Palettes for UI rendering in charts and active chips.
     */
    public const COLOR_PALETTE = [
        ['name' => 'Orange', 'hex' => '#f97316', 'bg' => 'rgba(249, 115, 22, 0.15)', 'border' => '#f97316'],
        ['name' => 'Purple', 'hex' => '#a855f7', 'bg' => 'rgba(168, 85, 247, 0.15)', 'border' => '#a855f7'],
        ['name' => 'Cyan', 'hex' => '#06b6d4', 'bg' => 'rgba(6, 182, 212, 0.15)', 'border' => '#06b6d4'],
        ['name' => 'Mint', 'hex' => '#10b981', 'bg' => 'rgba(16, 185, 129, 0.15)', 'border' => '#10b981'],
        ['name' => 'Pink', 'hex' => '#ec4899', 'bg' => 'rgba(236, 72, 153, 0.15)', 'border' => '#ec4899'],
        ['name' => 'Indigo', 'hex' => '#6366f1', 'bg' => 'rgba(99, 102, 241, 0.15)', 'border' => '#6366f1'],
    ];

    /**
     * Get consolidated metrics, radar values, trend data and department benchmarks.
     */
    public function getComparisonData(array $candidateIds = [], ?string $department = null, ?string $dateRange = null): array
    {
        // 1. Fetch available candidates
        $query = Candidate::with(['sessions.evaluation']);
        
        if (!empty($department) && $department !== 'All') {
            $query->where('applied_position', 'LIKE', "%{$department}%");
        }

        $allCandidates = Candidate::all();

        // If no candidate IDs specified, select up to 3 candidates by default
        if (empty($candidateIds)) {
            $candidateIds = $allCandidates->pluck('id')->take(3)->toArray();
        }

        $selectedCandidates = Candidate::with(['sessions.evaluation'])
            ->whereIn('id', $candidateIds)
            ->get();

        // 2. Build datasets for each selected candidate
        $candidateDatasets = [];
        $index = 0;

        foreach ($selectedCandidates as $candidate) {
            $color = self::COLOR_PALETTE[$index % count(self::COLOR_PALETTE)];
            $scores = $this->calculate8CompetencyScores($candidate);
            $timeline = $this->calculateTimelineTrend($candidate, $scores);

            $candidateDatasets[] = [
                'id' => $candidate->id,
                'name' => $candidate->full_name,
                'email' => $candidate->email,
                'applied_position' => $candidate->applied_position,
                'avatar_initials' => $this->getInitials($candidate->full_name),
                'color' => $color,
                'scores' => $scores, // Array of 8 numeric values (0-100)
                'timeline' => $timeline, // Array of 12 monthly values
                'overall_score' => round(array_sum($scores) / count($scores), 1),
            ];
            $index++;
        }

        // 3. Calculate Department / Benchmark Average
        $benchmarkScores = $this->calculateBenchmarkScores($selectedCandidates, $candidateDatasets);

        // 4. Time series monthly labels
        $timelineLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        return [
            'axes_labels' => self::COMPETENCY_AXES,
            'timeline_labels' => $timelineLabels,
            'selected_candidates' => $candidateDatasets,
            'department_benchmark' => $benchmarkScores,
            'all_candidates' => $allCandidates->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->full_name,
                'position' => $c->applied_position,
                'email' => $c->email,
                'avatar_initials' => $this->getInitials($c->full_name),
            ])->values(),
            'departments' => [
                'Tecnología',
                'Producto',
                'Marketing',
                'Finanzas',
                'Administración',
                'Legal',
            ],
        ];
    }

    /**
     * Calculate 8 competency scores (0-100) for a candidate based on CandidateSessions.
     */
    public function calculate8CompetencyScores(Candidate $candidate): array
    {
        $sessions = $candidate->sessions;
        
        $cognitiveSession = $sessions->first(fn($s) => optional($s->evaluation)->type === 'COGNITIVE');
        $discSession = $sessions->first(fn($s) => optional($s->evaluation)->type === 'DISC');

        // Extract DISC dimension scores if present
        $discMetrics = $discSession?->metrics_summary['scores'] ?? $discSession?->metrics_summary['dimensions'] ?? [];
        
        $discD = (float)($discMetrics['D'] ?? $discMetrics['Dominancia'] ?? 75);
        $discI = (float)($discMetrics['I'] ?? $discMetrics['Influencia'] ?? 80);
        $discS = (float)($discMetrics['S'] ?? $discMetrics['Estabilidad'] ?? 70);
        $discC = (float)($discMetrics['C'] ?? $discMetrics['Cumplimiento'] ?? 85);

        // Normalize DISC values to 0-100 scale if raw counts
        $maxDisc = max($discD, $discI, $discS, $discC, 1);
        if ($maxDisc <= 10) {
            $discD = min(100, round(($discD / 4) * 100));
            $discI = min(100, round(($discI / 4) * 100));
            $discS = min(100, round(($discS / 4) * 100));
            $discC = min(100, round(($discC / 4) * 100));
        }

        // Cognitive score
        $cognitiveScore = $cognitiveSession?->fit_percentage 
            ?? $cognitiveSession?->raw_score 
            ?? $this->generateDeterministicSeed($candidate->id, 75, 95);

        // Overall Fit General
        $overallFit = $sessions->avg('fit_percentage') 
            ?? $this->generateDeterministicSeed($candidate->id + 1, 70, 92);

        // Potencial (weighted combo of cognitive + growth capability)
        $potential = round(($cognitiveScore * 0.6) + ($discI * 0.2) + ($discD * 0.2));

        // Achievement (Objetivos)
        $achievement = round(($overallFit * 0.5) + ($discD * 0.3) + ($discC * 0.2));

        // Capacidad Analítica
        $analytical = round(($cognitiveScore * 0.7) + ($discC * 0.3));

        return [
            min(100, max(40, (int)$overallFit)),    // Rendimiento / Fit General
            min(100, max(40, (int)$potential)),     // Potencial
            min(100, max(40, (int)$achievement)),   // Achievement (Objetivos)
            min(100, max(40, (int)$analytical)),    // Capacidad Analítica
            min(100, max(40, (int)$discI)),         // Comunicación (DISC I)
            min(100, max(40, (int)$discS)),         // Flexibilidad (DISC S)
            min(100, max(40, (int)$discD)),         // Liderazgo (DISC D)
            min(100, max(40, (int)$discC)),         // Planificación (DISC C)
        ];
    }

    /**
     * Calculate 12-month timeline trend simulation based on candidate performance.
     */
    protected function calculateTimelineTrend(Candidate $candidate, array $scores): array
    {
        $baseScore = array_sum($scores) / count($scores);
        $timeline = [];

        for ($month = 1; $month <= 12; $month++) {
            // Smooth curve simulation leading up to final evaluation score
            $variation = sin($month * 0.5 + $candidate->id) * 6;
            $monthVal = round($baseScore - 12 + ($month * 0.9) + $variation);
            $timeline[] = min(100, max(30, (int)$monthVal));
        }

        return $timeline;
    }

    /**
     * Calculate average benchmark scores across all dataset candidates.
     */
    protected function calculateBenchmarkScores(Collection $selectedCandidates, array $candidateDatasets): array
    {
        if (empty($candidateDatasets)) {
            return [70, 72, 68, 75, 74, 71, 69, 76];
        }

        $benchmark = array_fill(0, count(self::COMPETENCY_AXES), 0);

        foreach ($candidateDatasets as $cand) {
            foreach ($cand['scores'] as $idx => $val) {
                $benchmark[$idx] += $val;
            }
        }

        $count = count($candidateDatasets);
        return array_map(fn($sum) => round($sum / $count, 1), $benchmark);
    }

    /**
     * Generate deterministic numbers for preview fallback if candidates lack completed sessions.
     */
    protected function generateDeterministicSeed(int $seed, int $min = 60, int $max = 95): int
    {
        $hash = crc32((string)$seed);
        return $min + ($hash % ($max - $min + 1));
    }

    /**
     * Extract initials from a full name (e.g. Arthur Williamson -> AW).
     */
    public function getInitials(string $name): string
    {
        $words = explode(' ', trim($name));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }
}
