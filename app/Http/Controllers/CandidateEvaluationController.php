<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use App\Models\SessionAnswer;
use App\Services\AssessmentEvaluatorService;
use Illuminate\Http\Request;

class CandidateEvaluationController extends Controller
{
    public function __construct(
        protected AssessmentEvaluatorService $evaluatorService
    ) {}

    /**
     * Prepares and displays the assessment session for a candidate.
     */
    public function show(Candidate $candidate, Evaluation $evaluation)
    {
        $session = CandidateSession::firstOrCreate(
            [
                'candidate_id' => $candidate->id,
                'evaluation_id' => $evaluation->id,
            ],
            [
                'status' => 'IN_PROGRESS',
                'started_at' => now(),
            ]
        );

        if ($session->status === 'COMPLETED') {
            return redirect()->route('sessions.results', $session)
                ->with('info', 'Esta evaluación ya ha sido completada previamente.');
        }

        if ($session->status === 'PENDING') {
            $session->update([
                'status' => 'IN_PROGRESS',
                'started_at' => now(),
            ]);
        }

        $questions = $evaluation->questions()->get();

        return view('evaluations.take', compact('candidate', 'evaluation', 'session', 'questions'));
    }

    /**
     * Handles candidate submission, saves answers, runs domain evaluation and redirects to results.
     */
    public function submit(Request $request, CandidateSession $session)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        foreach ($validated['answers'] as $questionId => $selectedOption) {
            SessionAnswer::updateOrCreate(
                [
                    'candidate_session_id' => $session->id,
                    'question_id' => $questionId,
                ],
                [
                    'selected_option' => $selectedOption,
                ]
            );
        }

        $this->evaluatorService->evaluateSession($session);

        return redirect()->route('sessions.results', $session)
            ->with('success', '¡Evaluación completada con éxito!');
    }

    /**
     * Renders detailed result metrics for a candidate session.
     */
    public function results(CandidateSession $session)
    {
        $session->load(['candidate', 'evaluation', 'answers.question']);

        return view('evaluations.results', compact('session'));
    }
}
