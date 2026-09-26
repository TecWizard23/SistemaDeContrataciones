<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Evaluation;
use App\Models\Question;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Sample Candidates
        $candidates = [
            [
                'full_name' => 'Carlos Mendoza',
                'email' => 'carlos.mendoza@example.com',
                'phone' => '+591 71234567',
                'applied_position' => 'Desarrollador Senior Laravel',
            ],
            [
                'full_name' => 'Ana Sofía Torres',
                'email' => 'ana.torres@example.com',
                'phone' => '+591 72345678',
                'applied_position' => 'Líder de Proyecto / Scrum Master',
            ],
            [
                'full_name' => 'Roberto Gómez',
                'email' => 'roberto.gomez@example.com',
                'phone' => '+591 73456789',
                'applied_position' => 'Analista de Garantía de Calidad (QA)',
            ],
            [
                'full_name' => 'Lucía Paredes',
                'email' => 'lucia.paredes@example.com',
                'phone' => '+591 74567890',
                'applied_position' => 'Desarrollador Frontend React',
            ],
        ];

        foreach ($candidates as $candData) {
            Candidate::firstOrCreate(['email' => $candData['email']], $candData);
        }

        // 2. Create Cognitive Evaluation
        $cognitiveEval = Evaluation::updateOrCreate(
            ['type' => 'COGNITIVE'],
            [
                'title' => 'Evaluación de Aptitud Cognitiva y Razonamiento Lógico',
                'description' => 'Esta prueba mide tu capacidad para resolver problemas complejos, encontrar patrones numéricos/gráficos y deducir respuestas lógicas.',
                'time_limit_minutes' => 15,
                'rubric_config' => [
                    'passing_percentage' => 70,
                    'levels' => [
                        'Superior' => 85,
                        'Promedio Alto' => 70,
                        'Promedio' => 50,
                        'Bajo el umbral' => 0,
                    ]
                ]
            ]
        );

        $cognitiveEval->questions()->delete();

        $cognitiveQuestions = [
            [
                'question_text' => '¿Cuál es el número que continúa lógicamente en la serie: 2, 4, 8, 16, 32, ...?',
                'options' => [
                    ['key' => 'A', 'text' => '48'],
                    ['key' => 'B', 'text' => '64'],
                    ['key' => 'C', 'text' => '54'],
                    ['key' => 'D', 'text' => '128'],
                ],
                'correct_option' => 'B',
                'points' => 1,
            ],
            [
                'question_text' => 'Si todos los desarrolladores usan teclado y algunos usuarios de teclado escuchan música, ¿cuál de las siguientes afirmaciones es necesariamente verdadera?',
                'options' => [
                    ['key' => 'A', 'text' => 'Todos los desarrolladores escuchan música.'],
                    ['key' => 'B', 'text' => 'Ningún desarrollador escucha música.'],
                    ['key' => 'C', 'text' => 'Es posible que algunos desarrolladores escuchen música.'],
                    ['key' => 'D', 'text' => 'Todos los que escuchan música son desarrolladores.'],
                ],
                'correct_option' => 'C',
                'points' => 1,
            ],
            [
                'question_text' => 'Un sistema de software procesa 120 peticiones por minuto. Si se optimiza y su rendimiento se incrementa en un 25%, ¿cuántas peticiones procesará por minuto?',
                'options' => [
                    ['key' => 'A', 'text' => '135 peticiones'],
                    ['key' => 'B', 'text' => '140 peticiones'],
                    ['key' => 'C', 'text' => '150 peticiones'],
                    ['key' => 'D', 'text' => '160 peticiones'],
                ],
                'correct_option' => 'C',
                'points' => 1,
            ],
            [
                'question_text' => 'Complete la analogía: CÓDIGO es a PROGRAMADOR como PLANO es a...',
                'options' => [
                    ['key' => 'A', 'text' => 'Edificio'],
                    ['key' => 'B', 'text' => 'Arquitecto'],
                    ['key' => 'C', 'text' => 'Ingeniería'],
                    ['key' => 'D', 'text' => 'Construcción'],
                ],
                'correct_option' => 'B',
                'points' => 1,
            ],
        ];

        foreach ($cognitiveQuestions as $q) {
            Question::create([
                'evaluation_id' => $cognitiveEval->id,
                'question_text' => $q['question_text'],
                'options' => $q['options'],
                'correct_option' => $q['correct_option'],
                'points' => $q['points'],
            ]);
        }

        // 3. Create DISC Behavioral Evaluation
        $discEval = Evaluation::updateOrCreate(
            ['type' => 'DISC'],
            [
                'title' => 'Evaluación del Perfil Conductual DISC',
                'description' => 'Responde a cada una de las situaciones seleccionando la opción que mejor describa tu comportamiento habitual en el entorno laboral.',
                'time_limit_minutes' => 20,
                'rubric_config' => [
                    'dimensions' => ['D', 'I', 'S', 'C'],
                ]
            ]
        );

        $discEval->questions()->delete();

        $discQuestions = [
            [
                'question_text' => 'Al enfrentar un proyecto nuevo con fechas de entrega extremadamente ajustadas, ¿cuál es tu primera reacción?',
                'options' => [
                    ['key' => 'A', 'text' => 'Tomo el control inmediato, asigno metas agresivas y exijo resultados rápidamente.', 'trait' => 'D'],
                    ['key' => 'B', 'text' => 'Motivo e inspiro al equipo con entusiasmo para trabajar juntos con energía.', 'trait' => 'I'],
                    ['key' => 'C', 'text' => 'Organizo un ritmo constante y predecible apoyando calmadamente a los compañeros.', 'trait' => 'S'],
                    ['key' => 'D', 'text' => 'Analizo en detalle los requerimientos y establezco un plan metodológico preciso.', 'trait' => 'C'],
                ],
            ],
            [
                'question_text' => 'En una reunión donde se presenta un desacuerdo técnico o estratégico importante, tú sueles:',
                'options' => [
                    ['key' => 'A', 'text' => 'Defender firmemente mi postura y presionar para llegar a una decisión rápida.', 'trait' => 'D'],
                    ['key' => 'B', 'text' => 'Usar la persuasión y la simpatía para conciliar ánimos y lograr consenso.', 'trait' => 'I'],
                    ['key' => 'C', 'text' => 'Escuchar pacientemente a todos y evitar conflictos directos buscando la armonía.', 'trait' => 'S'],
                    ['key' => 'D', 'text' => 'Argumentar basándome strictly en datos, normas y evidencia objetiva.', 'trait' => 'C'],
                ],
            ],
            [
                'question_text' => '¿Qué entorno de trabajo te resulta más estimulante y satisfactorio?',
                'options' => [
                    ['key' => 'A', 'text' => 'Un ambiente competitivo, dinámico y enfocado en superar grandes desafíos.', 'trait' => 'D'],
                    ['key' => 'B', 'text' => 'Un entorno social, participativo, abierto a nuevas ideas y relaciones.', 'trait' => 'I'],
                    ['key' => 'C', 'text' => 'Un ambiente estable, colaborativo, seguro y con procesos bien definidos.', 'trait' => 'S'],
                    ['key' => 'D', 'text' => 'Un entorno estructurado donde prime la calidad, la precisión y el rigor técnico.', 'trait' => 'C'],
                ],
            ],
            [
                'question_text' => 'Cuando cometes o detectas un error en un entregable, tu enfoque principal es:',
                'options' => [
                    ['key' => 'A', 'text' => 'Resolverlo de inmediato asumiendo la responsabilidad y minimizando el impacto.', 'trait' => 'D'],
                    ['key' => 'B', 'text' => 'Hablar con el equipo para desdramatizarlo y buscar soluciones creativas en grupo.', 'trait' => 'I'],
                    ['key' => 'C', 'text' => 'Ofrecer apoyo a los afectados y trabajar en silencio hasta corregirlo.', 'trait' => 'S'],
                    ['key' => 'D', 'text' => 'Investigar la causa raíz en el proceso para asegurar que nunca vuelva a repetirse.', 'trait' => 'C'],
                ],
            ],
        ];

        foreach ($discQuestions as $q) {
            Question::create([
                'evaluation_id' => $discEval->id,
                'question_text' => $q['question_text'],
                'options' => $q['options'],
                'correct_option' => null,
                'points' => 1,
            ]);
        }
    }
}
