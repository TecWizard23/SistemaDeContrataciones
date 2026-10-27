<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create HR Admin User
        User::updateOrCreate(
            ['email' => 'rrhh@kullakita.org'],
            [
                'name' => 'Reclutador RRHH',
                'email' => 'rrhh@kullakita.org',
                'password' => Hash::make('password123'),
                'role' => 'HR',
                'candidate_id' => null,
            ]
        );

        // 2. Create Default Candidate & User Account
        $candidate = Candidate::updateOrCreate(
            ['email' => 'postulante@kullakita.org'],
            [
                'full_name' => 'Juan Carlos Postulante',
                'email' => 'postulante@kullakita.org',
                'phone' => '+591 70001122',
                'applied_position' => 'Desarrollador Fullstack Laravel',
            ]
        );

        User::updateOrCreate(
            ['email' => 'postulante@kullakita.org'],
            [
                'name' => 'Juan Carlos Postulante',
                'email' => 'postulante@kullakita.org',
                'password' => Hash::make('password123'),
                'role' => 'CANDIDATE',
                'candidate_id' => $candidate->id,
            ]
        );

        // 3. Call EvaluationSeeder for Cognitive and DISC evaluations
        $this->call(EvaluationSeeder::class);

        // 4. Call CandidateComparisonSeeder for candidate sessions and comparison test data
        $this->call(CandidateComparisonSeeder::class);

        // 5. Seed Initial Vacancies
        if (\App\Models\Vacancy::count() === 0) {
            \App\Models\Vacancy::create([
                'title' => 'Psicólogo/a Clínico Especialista en Niñez',
                'department' => 'Protección y Bienestar Social',
                'location' => 'La Paz',
                'contract_type' => 'Tiempo Completo',
                'openings_count' => 2,
                'status' => 'OPEN',
                'salary_range' => '4.800 - 6.200 BOB',
                'description' => 'Responsable de la evaluación psicométrica, contención emocional y seguimiento terapéutico de menores en centros de acogida.',
                'requirements' => 'Licenciatura en Psicología, experiencia mínima de 2 años en niñez y adolescencia, conocimiento de pruebas psicométricas.',
                'closing_date' => now()->addDays(30),
            ]);

            \App\Models\Vacancy::create([
                'title' => 'Trabajador/a Social de Campo',
                'department' => 'Desarrollo Comunitario',
                'location' => 'El Alto',
                'contract_type' => 'Tiempo Completo',
                'openings_count' => 3,
                'status' => 'OPEN',
                'salary_range' => '4.200 - 5.500 BOB',
                'description' => 'Visitas domiciliarias, diagnóstico social familiar e intervención comunitaria en distritos vulnerables.',
                'requirements' => 'Título en Trabajo Social, disponibilidad para trabajo de campo en El Alto, habilidades de mediación comunitaria.',
                'closing_date' => now()->addDays(20),
            ]);

            \App\Models\Vacancy::create([
                'title' => 'Coordinador/a de Proyectos Educativos',
                'department' => 'Gestión de Proyectos',
                'location' => 'La Paz',
                'contract_type' => 'Consultoría',
                'openings_count' => 1,
                'status' => 'IN_REVIEW',
                'salary_range' => '6.500 - 8.000 BOB',
                'description' => 'Supervisión de planes educativos, redacción de informes a cooperantes y monitoreo de indicadores de impacto.',
                'requirements' => 'Formación en Ciencias de la Educación o Pedagogía, dominio de marco lógico y gestión de fondos de cooperación.',
                'closing_date' => now()->addDays(15),
            ]);
        }
    }
}
