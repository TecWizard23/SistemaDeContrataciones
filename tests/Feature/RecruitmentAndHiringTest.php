<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecruitmentAndHiringTest extends TestCase
{
    use RefreshDatabase;

    private User $hrUser;
    private User $candidateUser;
    private Candidate $candidate;
    private Vacancy $vacancy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hrUser = User::factory()->create([
            'email' => 'hr_recruitment@kullakita.org',
            'role' => 'HR',
        ]);

        $this->candidate = Candidate::create([
            'full_name' => 'Carla Mendoza Quispe',
            'email' => 'carla.mendoza@test.com',
            'phone' => '+591 71234567',
            'applied_position' => 'Psicólogo Comunitario',
            'hiring_stage' => 'POSTULADO',
        ]);

        $this->candidateUser = User::factory()->create([
            'email' => 'carla.mendoza@test.com',
            'role' => 'CANDIDATE',
            'candidate_id' => $this->candidate->id,
        ]);

        $this->vacancy = Vacancy::create([
            'title' => 'Psicólogo(a) Comunitario(a)',
            'department' => 'Área Psicosocial',
            'location' => 'El Alto',
            'contract_type' => 'Tiempo Completo',
            'openings_count' => 2,
            'status' => 'OPEN',
            'salary_range' => '4.500 - 5.500 Bs.',
            'description' => 'Atención psicosocial a familias beneficiarias.',
            'requirements' => 'Licenciatura en Psicología con 2 años de experiencia.',
            'created_by' => $this->hrUser->id,
        ]);
    }

    public function test_public_vacancies_index_is_accessible_by_guests(): void
    {
        $response = $this->get(route('public.vacancies.index'));

        $response->assertStatus(200);
        $response->assertSee('Psicólogo(a) Comunitario(a)');
        $response->assertSee('Área Psicosocial');
        $response->assertSee('Únete a Nuestro Equipo');
    }

    public function test_public_vacancy_detail_is_accessible_by_guests_via_qr_destination(): void
    {
        $response = $this->get(route('public.vacancies.show', $this->vacancy));

        $response->assertStatus(200);
        $response->assertSee($this->vacancy->title);
        $response->assertSee('Formulario de Postulación');
        $response->assertSee('4.500 - 5.500 Bs.');
        $response->assertSee('Área Psicosocial');
    }

    public function test_guest_can_apply_to_vacancy_and_is_automatically_registered_as_candidate(): void
    {
        $applicationData = [
            'full_name' => 'Roberto Carlos Vargas',
            'email' => 'roberto.vargas@ejemplo.com',
            'phone' => '+591 78912345',
            'city' => 'La Paz',
            'education_level' => 'Licenciatura',
            'experience_years' => 3,
            'linkedin_url' => 'https://linkedin.com/in/robertovargas',
            'summary' => 'Experiencia sólida en desarrollo comunitario.',
            'password' => 'secreto123',
            'password_confirmation' => 'secreto123',
        ];

        $response = $this->post(route('public.vacancies.apply', $this->vacancy), $applicationData);

        $response->assertRedirect(route('portal.index'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('candidates', [
            'email' => 'roberto.vargas@ejemplo.com',
            'full_name' => 'Roberto Carlos Vargas',
            'applied_position' => $this->vacancy->title,
            'vacancy_id' => $this->vacancy->id,
            'hiring_stage' => 'POSTULADO',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'roberto.vargas@ejemplo.com',
            'role' => 'CANDIDATE',
        ]);
    }

    public function test_hr_can_update_candidate_hiring_stage(): void
    {
        $response = $this->actingAs($this->hrUser)->patch(route('candidates.update-stage', $this->candidate), [
            'hiring_stage' => 'ENTREVISTA',
            'hiring_notes' => 'Candidato citado a entrevista para el viernes.',
        ]);

        $response->assertRedirect();
        $this->candidate->refresh();

        $this->assertEquals('ENTREVISTA', $this->candidate->hiring_stage);
        $this->assertEquals('Candidato citado a entrevista para el viernes.', $this->candidate->hiring_notes);
    }

    public function test_hr_can_formalize_candidate_hiring(): void
    {
        $response = $this->actingAs($this->hrUser)->post(route('candidates.hire', $this->candidate), [
            'hiring_notes' => 'Contratación formalizada con contrato de plazo fijo y sueldo de 5.200 Bs.',
        ]);

        $response->assertRedirect();
        $this->candidate->refresh();

        $this->assertEquals('CONTRATADO', $this->candidate->hiring_stage);
        $this->assertNotNull($this->candidate->hired_at);
        $this->assertTrue($this->candidate->isHired());
        $this->assertStringContainsString('Contratación formalizada', $this->candidate->hiring_notes);
    }

    public function test_candidate_cannot_update_hiring_stage(): void
    {
        $response = $this->actingAs($this->candidateUser)->patch(route('candidates.update-stage', $this->candidate), [
            'hiring_stage' => 'CONTRATADO',
        ]);

        $response->assertRedirect(route('portal.index'));
        $this->candidate->refresh();
        $this->assertNotEquals('CONTRATADO', $this->candidate->hiring_stage);
    }

    public function test_hr_can_filter_candidates_by_hiring_stage(): void
    {
        $response = $this->actingAs($this->hrUser)->get(route('candidates.index', ['stage' => 'POSTULADO']));

        $response->assertStatus(200);
        $response->assertSee('Carla Mendoza Quispe');
        $response->assertSee('1. Postulados');
        $response->assertSee('5. Contratados');
    }
}
