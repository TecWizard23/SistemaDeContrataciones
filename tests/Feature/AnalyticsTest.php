<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_hr_user_can_access_analytics_page(): void
    {
        $hrUser = User::factory()->create(['role' => 'HR']);

        Candidate::create([
            'full_name' => 'Test Candidate FMK',
            'email' => 'fmk@example.com',
            'applied_position' => 'Educador Social',
        ]);

        $response = $this->actingAs($hrUser)->get('/estadisticas');

        $response->assertStatus(200);
        $response->assertViewIs('analytics.index');
        $response->assertViewHasAll([
            'totalCandidates',
            'completedSessions',
            'avgFitGlobal',
            'discDistribution',
            'dimensions',
            'candidateRadarScores',
            'idealCargoProfile',
        ]);
    }

    public function test_candidate_user_is_redirected_from_analytics(): void
    {
        $candidateUser = User::factory()->create(['role' => 'CANDIDATE']);

        $response = $this->actingAs($candidateUser)->get('/estadisticas');

        $response->assertRedirect(route('portal.index'));
    }
}
