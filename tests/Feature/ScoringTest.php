<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\SessionAnswer;
use App\Services\AssessmentEvaluatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_cognitive_scoring_strategy_calculates_correctly(): void
    {
        $candidate = Candidate::create([
            'full_name' => 'Test Candidate',
            'email' => 'test@example.com',
            'applied_position' => 'Developer',
        ]);

        $evaluation = Evaluation::create([
            'title' => 'Cognitive Test',
            'type' => 'COGNITIVE',
            'time_limit_minutes' => 10,
        ]);

        $q1 = Question::create([
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Question 1',
            'options' => [['key' => 'A', 'text' => 'Opt A'], ['key' => 'B', 'text' => 'Opt B']],
            'correct_option' => 'A',
            'points' => 1,
        ]);

        $q2 = Question::create([
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Question 2',
            'options' => [['key' => 'A', 'text' => 'Opt A'], ['key' => 'B', 'text' => 'Opt B']],
            'correct_option' => 'B',
            'points' => 1,
        ]);

        $session = CandidateSession::create([
            'candidate_id' => $candidate->id,
            'evaluation_id' => $evaluation->id,
            'status' => 'IN_PROGRESS',
            'started_at' => now(),
        ]);

        SessionAnswer::create([
            'candidate_session_id' => $session->id,
            'question_id' => $q1->id,
            'selected_option' => 'A', // Correct
        ]);

        SessionAnswer::create([
            'candidate_session_id' => $session->id,
            'question_id' => $q2->id,
            'selected_option' => 'A', // Incorrect
        ]);

        $evaluator = app(AssessmentEvaluatorService::class);
        $updatedSession = $evaluator->evaluateSession($session);

        $this->assertEquals('COMPLETED', $updatedSession->status);
        $this->assertEquals(1.0, $updatedSession->raw_score);
        $this->assertEquals(50.0, $updatedSession->fit_percentage);
        $this->assertEquals('Promedio', $updatedSession->metrics_summary['qualitative_level']);
    }

    public function test_disc_scoring_strategy_calculates_profile(): void
    {
        $candidate = Candidate::create([
            'full_name' => 'DISC Candidate',
            'email' => 'disc@example.com',
            'applied_position' => 'Manager',
        ]);

        $evaluation = Evaluation::create([
            'title' => 'DISC Test',
            'type' => 'DISC',
            'time_limit_minutes' => 15,
        ]);

        $q1 = Question::create([
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Situational Q1',
            'options' => [
                ['key' => 'A', 'text' => 'Opt A', 'trait' => 'D'],
                ['key' => 'B', 'text' => 'Opt B', 'trait' => 'I'],
            ],
        ]);

        $q2 = Question::create([
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Situational Q2',
            'options' => [
                ['key' => 'A', 'text' => 'Opt A', 'trait' => 'D'],
                ['key' => 'B', 'text' => 'Opt B', 'trait' => 'S'],
            ],
        ]);

        $session = CandidateSession::create([
            'candidate_id' => $candidate->id,
            'evaluation_id' => $evaluation->id,
            'status' => 'IN_PROGRESS',
            'started_at' => now(),
        ]);

        SessionAnswer::create(['candidate_session_id' => $session->id, 'question_id' => $q1->id, 'selected_option' => 'A']);
        SessionAnswer::create(['candidate_session_id' => $session->id, 'question_id' => $q2->id, 'selected_option' => 'A']);

        $evaluator = app(AssessmentEvaluatorService::class);
        $updatedSession = $evaluator->evaluateSession($session);

        $this->assertEquals('COMPLETED', $updatedSession->status);
        $this->assertEquals('D', $updatedSession->metrics_summary['primary_style']);
        $this->assertEquals(100.0, $updatedSession->fit_percentage);
    }
}
