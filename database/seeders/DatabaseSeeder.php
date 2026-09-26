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
    }
}
