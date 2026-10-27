<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationManagementController extends Controller
{
    /**
     * Display listing of evaluations.
     */
    public function index()
    {
        $evaluations = Evaluation::withCount('questions')->orderBy('id', 'desc')->get();

        return view('evaluations.index', compact('evaluations'));
    }

    /**
     * Show form to create new evaluation with questions.
     */
    public function create()
    {
        return view('evaluations.create');
    }

    /**
     * Store new evaluation and its questions.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:COGNITIVE,DISC,SITUATIONAL',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:1|max:180',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.key' => 'required|string',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.trait' => 'nullable|string',
            'questions.*.correct_option' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $evaluation = Evaluation::create([
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'time_limit_minutes' => $validated['time_limit_minutes'],
                'rubric_config' => [
                    'created_by' => auth()->id(),
                ],
            ]);

            foreach ($validated['questions'] as $q) {
                $options = $this->normalizeQuestionOptions($validated['type'], $q['options']);
                Question::create([
                    'evaluation_id' => $evaluation->id,
                    'question_text' => $q['question_text'],
                    'options' => $options,
                    'correct_option' => $q['correct_option'] ?? null,
                    'points' => isset($q['points']) ? max(1, (int)$q['points']) : 1,
                ]);
            }
        });

        return redirect()->route('evaluations-manage.index')
            ->with('success', 'Evaluación y examen creados con éxito.');
    }

    /**
     * Display the specified evaluation and its questions.
     */
    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['questions', 'candidateSessions.candidate']);
        $totalQuestions = $evaluation->questions->count();
        $totalPoints = $evaluation->questions->sum('points');

        return view('evaluations.show', compact('evaluation', 'totalQuestions', 'totalPoints'));
    }

    /**
     * Show form to edit an existing evaluation.
     */
    public function edit(Evaluation $evaluation)
    {
        $evaluation->load('questions');

        return view('evaluations.edit', compact('evaluation'));
    }

    /**
     * Update the specified evaluation and its questions.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:COGNITIVE,DISC,SITUATIONAL',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:1|max:180',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.key' => 'required|string',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.trait' => 'nullable|string',
            'questions.*.correct_option' => 'nullable|string',
            'questions.*.points' => 'nullable|integer|min:1|max:50',
        ]);

        DB::transaction(function () use ($evaluation, $validated) {
            $evaluation->update([
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'time_limit_minutes' => $validated['time_limit_minutes'],
            ]);

            $keptIds = [];

            foreach ($validated['questions'] as $q) {
                $qId = !empty($q['id']) ? (int)$q['id'] : null;
                $options = $this->normalizeQuestionOptions($validated['type'], $q['options']);

                if ($qId && ($existingQuestion = $evaluation->questions()->find($qId))) {
                    $existingQuestion->update([
                        'question_text' => $q['question_text'],
                        'options' => $options,
                        'correct_option' => $q['correct_option'] ?? null,
                        'points' => isset($q['points']) ? max(1, (int)$q['points']) : 1,
                    ]);
                    $keptIds[] = $existingQuestion->id;
                } else {
                    $createdQuestion = Question::create([
                        'evaluation_id' => $evaluation->id,
                        'question_text' => $q['question_text'],
                        'options' => $options,
                        'correct_option' => $q['correct_option'] ?? null,
                        'points' => isset($q['points']) ? max(1, (int)$q['points']) : 1,
                    ]);
                    $keptIds[] = $createdQuestion->id;
                }
            }

            // Remove any questions that were discarded in the editor
            $evaluation->questions()->whereNotIn('id', $keptIds)->delete();
        });

        return redirect()->route('evaluations-manage.index')
            ->with('success', 'Evaluación actualizada con éxito.');
    }

    /**
     * Normalize options array ensuring valid traits for DISC behind the scenes.
     */
    private function normalizeQuestionOptions(string $type, array $options): array
    {
        $traitMap = ['D', 'I', 'S', 'C'];
        foreach ($options as $idx => &$opt) {
            if ($type === 'DISC' && empty($opt['trait'])) {
                $opt['trait'] = $traitMap[$idx % 4];
            }
        }
        unset($opt);
        return $options;
    }

    /**
     * Delete an evaluation.
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return redirect()->route('evaluations-manage.index')
            ->with('success', 'Evaluación eliminada correctamente.');
    }
}
