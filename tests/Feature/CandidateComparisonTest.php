<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use App\Models\User;
use App\Services\CandidateComparisonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateComparisonTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_comparison_service_returns_8_competency_axes(): void
    {
        $candidate = Candidate::create([
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'applied_position' => 'Fullstack Developer (Tecnología)',
        ]);

        $evaluation = Evaluation::create([
            'title' => 'Cognitive Test',
            'type' => 'COGNITIVE',
        ]);

        CandidateSession::create([
            'candidate_id' => $candidate->id,
            'evaluation_id' => $evaluation->id,
            'status' => 'COMPLETED',
            'started_at' => now(),
            'completed_at' => now(),
            'fit_percentage' => 85.0,
            'metrics_summary' => ['scores' => ['D' => 80, 'I' => 75, 'S' => 70, 'C' => 90]],
        ]);

        $service = app(CandidateComparisonService::class);
        $data = $service->getComparisonData([$candidate->id]);

        $this->assertCount(8, $data['axes_labels']);
        $this->assertEquals('Rendimiento / Fit General', $data['axes_labels'][0]);
        $this->assertCount(1, $data['selected_candidates']);
        $this->assertCount(8, $data['selected_candidates'][0]['scores']);
        $this->assertCount(12, $data['selected_candidates'][0]['timeline']);
    }

    public function test_hr_user_can_access_compare_dashboard(): void
    {
        $hrUser = User::factory()->create(['role' => 'HR']);

        $response = $this->actingAs($hrUser)->get('/hr/compare');

        $response->assertStatus(200);
        $response->assertViewIs('hr.compare');
        $response->assertViewHas('comparisonData');
    }

    public function test_candidate_user_cannot_access_compare_dashboard(): void
    {
        $candidateUser = User::factory()->create(['role' => 'CANDIDATE']);

        $response = $this->actingAs($candidateUser)->get('/hr/compare');

        $response->assertRedirect(route('portal.index'));
    }

    public function test_export_route_generates_csv_download(): void
    {
        $hrUser = User::factory()->create(['role' => 'HR']);

        $candidate = Candidate::create([
            'full_name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'applied_position' => 'Product Owner (Producto)',
        ]);

        $response = $this->actingAs($hrUser)->get('/hr/compare/export?candidates=' . $candidate->id);

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertTrue(str_contains($response->headers->get('content-disposition'), 'comparativa_candidatos'));
    }
}
