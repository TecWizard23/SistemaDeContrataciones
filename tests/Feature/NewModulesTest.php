<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewModulesTest extends TestCase
{
    use RefreshDatabase;

    private User $hrUser;
    private User $candidateUser;
    private Candidate $candidate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hrUser = User::create([
            'name' => 'HR Admin',
            'email' => 'hr_admin@kullakita.org',
            'password' => bcrypt('password123'),
            'role' => 'HR',
        ]);

        $this->candidate = Candidate::create([
            'full_name' => 'Carla Mendoza Postulante',
            'email' => 'carla@kullakita.org',
            'phone' => '+591 76543210',
            'applied_position' => 'Trabajadora Social',
            'city' => 'La Paz',
        ]);

        $this->candidateUser = User::create([
            'name' => 'Carla Mendoza Postulante',
            'email' => 'carla@kullakita.org',
            'password' => bcrypt('password123'),
            'role' => 'CANDIDATE',
            'candidate_id' => $this->candidate->id,
        ]);
    }

    public function test_hr_can_view_and_manage_vacancies(): void
    {
        // 1. Index
        $response = $this->actingAs($this->hrUser)->get(route('vacancies.index'));
        $response->assertStatus(200);
        $response->assertSee('Gestión de Convocatorias y Vacantes');

        // 2. Create View
        $response = $this->actingAs($this->hrUser)->get(route('vacancies.create'));
        $response->assertStatus(200);
        $response->assertSee('Publicar Convocatoria Laboral');

        // 3. Store
        $payload = [
            'title' => 'Educador/a Social Nocturno',
            'department' => 'Protección Infantil',
            'location' => 'El Alto',
            'contract_type' => 'Tiempo Completo',
            'openings_count' => 2,
            'status' => 'OPEN',
            'salary_range' => '4.200 - 5.000 BOB',
            'description' => 'Acompañamiento a menores en turnos nocturnos.',
            'requirements' => 'Experiencia en trabajo social o pedagogía.',
        ];

        $response = $this->actingAs($this->hrUser)->post(route('vacancies.store'), $payload);
        $response->assertRedirect(route('vacancies.index'));

        $this->assertDatabaseHas('vacancies', [
            'title' => 'Educador/a Social Nocturno',
            'location' => 'El Alto',
        ]);

        $vacancy = Vacancy::where('title', 'Educador/a Social Nocturno')->first();
        $this->assertNotNull($vacancy);

        // 4. Toggle Status
        $response = $this->actingAs($this->hrUser)->patch(route('vacancies.toggle-status', $vacancy));
        $response->assertStatus(302);
        $vacancy->refresh();
        $this->assertEquals('CLOSED', $vacancy->status);
    }

    public function test_candidate_cannot_access_vacancies_management(): void
    {
        $response = $this->actingAs($this->candidateUser)->get(route('vacancies.index'));
        $response->assertRedirect(route('portal.index'));
    }

    public function test_candidate_can_view_and_update_profile(): void
    {
        // 1. View Profile
        $response = $this->actingAs($this->candidateUser)->get(route('portal.profile'));
        $response->assertStatus(200);
        $response->assertSee('Mi Perfil Profesional');
        $response->assertSee('Carla Mendoza Postulante');

        // 2. Update Profile
        $updatePayload = [
            'full_name' => 'Carla Mendoza de la Riva',
            'phone' => '+591 79998877',
            'city' => 'Cochabamba',
            'experience_years' => 4,
            'education_level' => 'Licenciatura / Grado',
            'linkedin_url' => 'https://linkedin.com/in/carla-mendoza',
            'summary' => 'Profesional con 4 años de experiencia en intervención comunitaria.',
        ];

        $response = $this->actingAs($this->candidateUser)->put(route('portal.profile.update'), $updatePayload);
        $response->assertRedirect(route('portal.profile'));

        $this->candidate->refresh();
        $this->assertEquals('Carla Mendoza de la Riva', $this->candidate->full_name);
        $this->assertEquals('Cochabamba', $this->candidate->city);
        $this->assertEquals(4, $this->candidate->experience_years);
    }

    public function test_candidate_can_view_personal_results(): void
    {
        $evaluation = Evaluation::create([
            'title' => 'Prueba de Razonamiento Lógico',
            'type' => 'COGNITIVE',
            'time_limit_minutes' => 20,
        ]);

        CandidateSession::create([
            'candidate_id' => $this->candidate->id,
            'evaluation_id' => $evaluation->id,
            'status' => 'COMPLETED',
            'raw_score' => 18,
            'fit_percentage' => 85.5,
            'completed_at' => now(),
        ]);

        $response = $this->actingAs($this->candidateUser)->get(route('portal.my-results'));
        $response->assertStatus(200);
        $response->assertSee('Mis Resultados y Desempeño');
        $response->assertSee('Prueba de Razonamiento Lógico');
        $response->assertSee('85.5%');
    }
}
