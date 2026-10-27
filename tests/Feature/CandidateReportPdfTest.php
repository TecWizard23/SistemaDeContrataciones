<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateReportPdfTest extends TestCase
{
    use RefreshDatabase;

    private Candidate $candidate;
    private Evaluation $cognitiveEval;
    private Evaluation $discEval;
    private CandidateSession $cognitiveSession;
    private CandidateSession $discSession;
    private User $hrUser;
    private User $candidateUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hrUser = User::factory()->create(['role' => 'HR']);
        $this->candidateUser = User::factory()->create(['role' => 'CANDIDATE']);

        $this->candidate = Candidate::create([
            'full_name' => 'Ana Morales Paz',
            'email' => 'ana.morales@kullakita.org',
            'phone' => '+591 71234567',
            'applied_position' => 'Coordinador de Proyectos Sociales',
        ]);

        $this->cognitiveEval = Evaluation::create([
            'title' => 'Evaluación de Razonamiento Lógico',
            'type' => 'COGNITIVE',
            'duration_minutes' => 20,
        ]);

        $this->discEval = Evaluation::create([
            'title' => 'Perfil Conductual DISC',
            'type' => 'DISC',
            'duration_minutes' => 15,
        ]);

        $this->cognitiveSession = CandidateSession::create([
            'candidate_id' => $this->candidate->id,
            'evaluation_id' => $this->cognitiveEval->id,
            'status' => 'COMPLETED',
            'started_at' => now()->subMinutes(18),
            'completed_at' => now(),
            'raw_score' => 9.0,
            'fit_percentage' => 88.5,
            'metrics_summary' => [
                'total_questions' => 10,
                'correct_answers' => 9,
                'qualitative_level' => 'Superior',
            ],
        ]);

        $this->discSession = CandidateSession::create([
            'candidate_id' => $this->candidate->id,
            'evaluation_id' => $this->discEval->id,
            'status' => 'COMPLETED',
            'started_at' => now()->subMinutes(12),
            'completed_at' => now(),
            'raw_score' => 10.0,
            'fit_percentage' => 78.0,
            'metrics_summary' => [
                'scores' => ['D' => 65, 'I' => 90, 'S' => 85, 'C' => 70],
                'dominant_trait' => 'I',
            ],
        ]);
    }

    /**
     * Test that guest is redirected to login.
     */
    public function test_guest_cannot_download_report_pdf(): void
    {
        $response = $this->get(route('candidate.session.pdf', $this->cognitiveSession));
        $response->assertRedirect('/login');
    }

    /**
     * Test that candidate role cannot access the PDF report.
     */
    public function test_candidate_cannot_download_report_pdf(): void
    {
        $response = $this->actingAs($this->candidateUser)->get(route('candidate.session.pdf', $this->cognitiveSession));
        $response->assertRedirect(route('portal.index'));
    }

    /**
     * Test that HR user can export PDF report for Cognitive sessions.
     */
    public function test_hr_can_export_cognitive_pdf_report(): void
    {
        $response = $this->actingAs($this->hrUser)->get(route('candidate.session.pdf', $this->cognitiveSession));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        $content = $response->getContent();
        $this->assertStringStartsWith('%PDF-', $content);
    }

    /**
     * Test that HR user can export PDF report for DISC sessions.
     */
    public function test_hr_can_export_disc_pdf_report(): void
    {
        $response = $this->actingAs($this->hrUser)->get(route('candidate.session.pdf', $this->discSession));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        $content = $response->getContent();
        $this->assertStringStartsWith('%PDF-', $content);
    }
}
