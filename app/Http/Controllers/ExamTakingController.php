<?php

namespace App\Http\Controllers;

use App\Models\CandidateSession;
use App\Models\Evaluation;
use App\Models\SessionAnswer;
use App\Services\AssessmentEvaluatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamTakingController extends Controller
{
    public function __construct(
        protected AssessmentEvaluatorService $evaluatorService
    ) {}

    /**
     * Start or resume an assessment exam for the logged-in candidate.
     */
    public function show(Evaluation $evaluation)
    {
        $candidate = Auth::user()->candidate;

        if (!$candidate) {
            abort(403, 'Perfil de candidato no encontrado.');
        }

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
            return redirect()->route('exam.completed', $session);
        }

        if ($session->status === 'PENDING') {
            $session->update([
                'status' => 'IN_PROGRESS',
                'started_at' => now(),
            ]);
        }

        $timeLimitMinutes = $evaluation->time_limit_minutes ?? 15;
        $timeLimitSeconds = $timeLimitMinutes * 60;
        $elapsedSeconds = $session->started_at ? now()->diffInSeconds($session->started_at) : 0;
        $remainingSeconds = max(0, $timeLimitSeconds - $elapsedSeconds);

        $questions = $evaluation->questions()->get();

        return view('portal.take_exam', compact(
            'candidate',
            'evaluation',
            'session',
            'questions',
            'remainingSeconds'
        ));
    }

    /**
     * Submit candidate exam answers and run evaluation engine.
     */
    public function submit(Request $request, CandidateSession $session)
    {
        $candidate = Auth::user()->candidate;

        if ($session->candidate_id !== $candidate->id) {
            abort(403, 'No tienes autorización sobre esta sesión.');
        }

        if ($session->status === 'COMPLETED') {
            return redirect()->route('exam.completed', $session);
        }

        $validated = $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string',
        ]);

        $answers = $validated['answers'] ?? [];

        foreach ($answers as $questionId => $selectedOption) {
            if (!empty($selectedOption)) {
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
        }

        $this->evaluatorService->evaluateSession($session);

        return redirect()->route('exam.completed', $session)
            ->with('success', 'Tus respuestas han sido registradas y evaluadas correctamente.');
    }

    /**
     * Display formal completion confirmation screen for the candidate.
     */
    public function completed(CandidateSession $session)
    {
        $candidate = Auth::user()->candidate;

        if ($session->candidate_id !== $candidate->id) {
            abort(403, 'No tienes acceso a este reporte.');
        }

        $session->load(['evaluation']);

        return view('portal.completed', compact('session'));
    }
}
