<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecuritySqlInjectionTest extends TestCase
{
    use RefreshDatabase;

    private User $hrUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hrUser = User::create([
            'name' => 'HR Administrator',
            'email' => 'rrhh@kullakita.org',
            'password' => bcrypt('password123'),
            'role' => 'HR',
        ]);

        Candidate::create([
            'full_name' => 'Test Candidate Real',
            'email' => 'real@kullakita.org',
            'applied_position' => 'Psicólogo Clínico',
            'city' => 'La Paz',
        ]);

        Vacancy::create([
            'title' => 'Psicólogo Especialista',
            'department' => 'Protección',
            'location' => 'La Paz',
            'contract_type' => 'Tiempo Completo',
            'openings_count' => 1,
            'status' => 'OPEN',
            'description' => 'Descripción de prueba',
        ]);
    }

    /**
     * Test login endpoint rejects classic SQL injection payloads and does not bypass authentication.
     */
    public function test_login_is_immune_to_classic_sql_injection(): void
    {
        $payloads = [
            "' OR '1'='1",
            "' OR 1=1 --",
            "admin'--",
            "rrhh@kullakita.org'--",
            "'; DROP TABLE users; --",
            "\" OR \"\"=\"",
            "admin' #",
            "' UNION SELECT null, null, null, null--",
            "1' or '1' = '1",
        ];

        foreach ($payloads as $sqlPayload) {
            $response = $this->post(route('login'), [
                'email' => $sqlPayload,
                'password' => $sqlPayload,
            ]);

            // Must NOT log in the user
            $this->assertGuest();

            // Users table must remain intact
            $this->assertDatabaseHas('users', [
                'email' => 'rrhh@kullakita.org',
            ]);
        }
    }

    /**
     * Test dashboard search query does not execute injected SQL or drop tables.
     */
    public function test_dashboard_search_is_immune_to_sql_injection(): void
    {
        $maliciousSearches = [
            "' OR '1'='1",
            "'; DROP TABLE candidates; --",
            "%' UNION SELECT 1,2,3,4,5,6,7,8,9,10,11--",
            "\\'; DROP TABLE users; --",
            "' OR 1=1 #",
        ];

        foreach ($maliciousSearches as $search) {
            $response = $this->actingAs($this->hrUser)->get(route('dashboard.index', ['search' => $search]));
            
            // Must return HTTP 200 OK without unhandled PDO/SQL exception
            $response->assertStatus(200);

            // Verify candidates table was never dropped or altered
            $this->assertDatabaseHas('candidates', [
                'email' => 'real@kullakita.org',
            ]);
        }
    }

    /**
     * Test vacancies search does not execute injected SQL.
     */
    public function test_vacancies_search_is_immune_to_sql_injection(): void
    {
        $maliciousSearches = [
            "' OR '1'='1",
            "'; DROP TABLE vacancies; --",
            "' UNION SELECT null, null, null--",
        ];

        foreach ($maliciousSearches as $search) {
            $response = $this->actingAs($this->hrUser)->get(route('vacancies.index', ['search' => $search]));
            $response->assertStatus(200);

            $this->assertDatabaseHas('vacancies', [
                'title' => 'Psicólogo Especialista',
            ]);
        }
    }

    /**
     * Test numeric filters safely reject or cast non-numeric SQL injection payloads.
     */
    public function test_numeric_filters_cannot_be_exploited_with_sql_injection(): void
    {
        $payloads = [
            'min_fit' => '50; DROP TABLE candidates; --',
            'max_fit' => "' OR '1'='1",
        ];

        $response = $this->actingAs($this->hrUser)->get(route('dashboard.index', $payloads));
        $response->assertStatus(200);

        $this->assertDatabaseHas('candidates', [
            'email' => 'real@kullakita.org',
        ]);
    }
}
