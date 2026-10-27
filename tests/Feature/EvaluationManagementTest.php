<?php

namespace Tests\Feature;

use App\Models\Evaluation;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluationManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $hrUser;
    private User $candidateUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hrUser = User::create([
            'name' => 'HR Admin',
            'email' => 'hr@test.com',
            'password' => bcrypt('secret123'),
            'role' => 'HR',
        ]);

        $this->candidateUser = User::create([
            'name' => 'Candidate User',
            'email' => 'candidate@test.com',
            'password' => bcrypt('secret123'),
            'role' => 'CANDIDATE',
        ]);
    }

    public function test_hr_can_view_evaluation_management_index(): void
    {
        $response = $this->actingAs($this->hrUser)->get(route('evaluations-manage.index'));
        $response->assertStatus(200);
        $response->assertSee('Banco de Evaluaciones Psicométricas');
    }

    public function test_candidate_cannot_access_evaluation_management(): void
    {
        $response = $this->actingAs($this->candidateUser)->get(route('evaluations-manage.index'));
        $response->assertRedirect(route('portal.index'));
    }

    public function test_hr_can_view_create_block_builder(): void
    {
        $response = $this->actingAs($this->hrUser)->get(route('evaluations-manage.create'));
        $response->assertStatus(200);
        $response->assertSee('Crear Examen por Bloques');
        $response->assertSee('Vista Previa');
    }

    public function test_hr_can_create_new_evaluation_with_blocks(): void
    {
        $payload = [
            'title' => 'Evaluación de Lógica y Algoritmos',
            'type' => 'COGNITIVE',
            'description' => 'Prueba técnica de resolución de problemas',
            'time_limit_minutes' => 30,
            'questions' => [
                [
                    'question_text' => '¿Cuál es la complejidad temporal de una búsqueda binaria?',
                    'points' => 5,
                    'correct_option' => 'B',
                    'options' => [
                        ['key' => 'A', 'text' => 'O(n)'],
                        ['key' => 'B', 'text' => 'O(log n)'],
                        ['key' => 'C', 'text' => 'O(n^2)'],
                    ],
                ],
                [
                    'question_text' => '¿Qué estructura sigue la política LIFO?',
                    'points' => 5,
                    'correct_option' => 'A',
                    'options' => [
                        ['key' => 'A', 'text' => 'Pila (Stack)'],
                        ['key' => 'B', 'text' => 'Cola (Queue)'],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($this->hrUser)->post(route('evaluations-manage.store'), $payload);
        $response->assertRedirect(route('evaluations-manage.index'));

        $this->assertDatabaseHas('evaluations', [
            'title' => 'Evaluación de Lógica y Algoritmos',
            'type' => 'COGNITIVE',
        ]);

        $evaluation = Evaluation::where('title', 'Evaluación de Lógica y Algoritmos')->first();
        $this->assertNotNull($evaluation);
        $this->assertCount(2, $evaluation->questions);
    }

    public function test_hr_can_view_edit_block_builder_for_existing_evaluation(): void
    {
        $evaluation = Evaluation::create([
            'title' => 'Examen Psicométrico Original',
            'type' => 'DISC',
            'description' => 'Instrucciones previas',
            'time_limit_minutes' => 20,
        ]);

        $q = Question::create([
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Ante una situación imprevista de alta presión...',
            'points' => 1,
            'options' => [
                ['key' => 'A', 'text' => 'Tomo el control directo', 'trait' => 'D'],
                ['key' => 'B', 'text' => 'Busco motivar a los demás', 'trait' => 'I'],
                ['key' => 'C', 'text' => 'Mantengo la calma y escucho', 'trait' => 'S'],
                ['key' => 'D', 'text' => 'Analizo los datos rigurosamente', 'trait' => 'C'],
            ],
        ]);

        $response = $this->actingAs($this->hrUser)->get(route('evaluations-manage.edit', $evaluation));
        $response->assertStatus(200);
        $response->assertSee('Editar Evaluación');
        $response->assertSee('Examen Psicométrico Original');
        $response->assertSee('Tomo el control directo');
    }

    public function test_hr_can_update_evaluation_and_modify_blocks(): void
    {
        $evaluation = Evaluation::create([
            'title' => 'Examen Original',
            'type' => 'COGNITIVE',
            'description' => 'Original',
            'time_limit_minutes' => 15,
        ]);

        $q1 = Question::create([
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Pregunta 1 original',
            'points' => 2,
            'correct_option' => 'A',
            'options' => [
                ['key' => 'A', 'text' => 'Opción 1'],
                ['key' => 'B', 'text' => 'Opción 2'],
            ],
        ]);

        $q2 = Question::create([
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Pregunta 2 a eliminar',
            'points' => 3,
            'correct_option' => 'B',
            'options' => [
                ['key' => 'A', 'text' => 'Opción A'],
                ['key' => 'B', 'text' => 'Opción B'],
            ],
        ]);

        // Submit update: keep $q1 updated, drop $q2, add a new question
        $updatePayload = [
            'title' => 'Examen Actualizado y Mejorado',
            'type' => 'COGNITIVE',
            'description' => 'Nueva descripción',
            'time_limit_minutes' => 25,
            'questions' => [
                [
                    'id' => $q1->id,
                    'question_text' => 'Pregunta 1 texto editado',
                    'points' => 4,
                    'correct_option' => 'B',
                    'options' => [
                        ['key' => 'A', 'text' => 'Opción 1 modificada'],
                        ['key' => 'B', 'text' => 'Opción 2 correcta ahora'],
                    ],
                ],
                [
                    'id' => null, // Nueva pregunta creada en el editor
                    'question_text' => 'Pregunta 3 añadida dinámicamente',
                    'points' => 6,
                    'correct_option' => 'A',
                    'options' => [
                        ['key' => 'A', 'text' => 'Respuesta A'],
                        ['key' => 'B', 'text' => 'Respuesta B'],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($this->hrUser)->put(route('evaluations-manage.update', $evaluation), $updatePayload);
        $response->assertRedirect(route('evaluations-manage.index'));

        $evaluation->refresh();
        $this->assertEquals('Examen Actualizado y Mejorado', $evaluation->title);
        $this->assertEquals(25, $evaluation->time_limit_minutes);

        // Verify q1 was updated in-place (same id preserved)
        $q1->refresh();
        $this->assertEquals('Pregunta 1 texto editado', $q1->question_text);
        $this->assertEquals(4, $q1->points);
        $this->assertEquals('B', $q1->correct_option);

        // Verify q2 was deleted
        $this->assertDatabaseMissing('questions', ['id' => $q2->id]);

        // Verify new question was inserted
        $this->assertDatabaseHas('questions', [
            'evaluation_id' => $evaluation->id,
            'question_text' => 'Pregunta 3 añadida dinámicamente',
        ]);
        $this->assertCount(2, $evaluation->questions);
    }
}
