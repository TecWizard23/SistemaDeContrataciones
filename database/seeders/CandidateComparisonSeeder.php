<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;

class CandidateComparisonSeeder extends Seeder
{
    public function run(): void
    {
        $cognitiveEval = Evaluation::where('type', 'COGNITIVE')->first();
        $discEval = Evaluation::where('type', 'DISC')->first();

        // Sample Candidates matching Kenjo HR mockup reference
        $candidates = [
            [
                'full_name' => 'Arthur Williamson',
                'email' => 'arthur.williamson@example.com',
                'phone' => '+591 78901234',
                'applied_position' => 'Líder de Producto (Producto)',
                'cognitive_fit' => 92.5,
                'disc_scores' => ['D' => 88, 'I' => 92, 'S' => 65, 'C' => 78],
            ],
            [
                'full_name' => 'Cristina Carrión',
                'email' => 'cristina.carrion@example.com',
                'phone' => '+591 79012345',
                'applied_position' => 'Gerente de Marketing (Marketing)',
                'cognitive_fit' => 86.0,
                'disc_scores' => ['D' => 70, 'I' => 95, 'S' => 80, 'C' => 68],
            ],
            [
                'full_name' => 'Ines Reiniger',
                'email' => 'ines.reiniger@example.com',
                'phone' => '+591 70123456',
                'applied_position' => 'Analista Financiero (Finanzas)',
                'cognitive_fit' => 95.0,
                'disc_scores' => ['D' => 60, 'I' => 65, 'S' => 75, 'C' => 96],
            ],
            [
                'full_name' => 'Robert Mustermann',
                'email' => 'robert.mustermann@example.com',
                'phone' => '+591 71234567',
                'applied_position' => 'Arquitecto de Software (Tecnología)',
                'cognitive_fit' => 91.0,
                'disc_scores' => ['D' => 82, 'I' => 72, 'S' => 68, 'C' => 92],
            ],
            [
                'full_name' => 'Laura Kaiser',
                'email' => 'laura.kaiser@example.com',
                'phone' => '+591 72345678',
                'applied_position' => 'Especialista Legal (Legal)',
                'cognitive_fit' => 88.0,
                'disc_scores' => ['D' => 75, 'I' => 70, 'S' => 82, 'C' => 90],
            ],
        ];

        foreach ($candidates as $candData) {
            $candidate = Candidate::updateOrCreate(
                ['email' => $candData['email']],
                [
                    'full_name' => $candData['full_name'],
                    'email' => $candData['email'],
                    'phone' => $candData['phone'],
                    'applied_position' => $candData['applied_position'],
                ]
            );

            // Create completed Cognitive Session if evaluation exists
            if ($cognitiveEval) {
                CandidateSession::updateOrCreate(
                    [
                        'candidate_id' => $candidate->id,
                        'evaluation_id' => $cognitiveEval->id,
                    ],
                    [
                        'status' => 'COMPLETED',
                        'started_at' => now()->subDays(5),
                        'completed_at' => now()->subDays(5)->addMinutes(12),
                        'raw_score' => round($candData['cognitive_fit'] * 0.04, 1),
                        'fit_percentage' => $candData['cognitive_fit'],
                        'metrics_summary' => [
                            'correct_count' => (int)round(($candData['cognitive_fit'] / 100) * 4),
                            'total_questions' => 4,
                        ],
                    ]
                );
            }

            // Create completed DISC Session if evaluation exists
            if ($discEval) {
                CandidateSession::updateOrCreate(
                    [
                        'candidate_id' => $candidate->id,
                        'evaluation_id' => $discEval->id,
                    ],
                    [
                        'status' => 'COMPLETED',
                        'started_at' => now()->subDays(4),
                        'completed_at' => now()->subDays(4)->addMinutes(15),
                        'raw_score' => 10.0,
                        'fit_percentage' => round(array_sum($candData['disc_scores']) / 4, 1),
                        'metrics_summary' => [
                            'scores' => $candData['disc_scores'],
                            'dominant_trait' => array_search(max($candData['disc_scores']), $candData['disc_scores']),
                        ],
                    ]
                );
            }
        }
    }
}
