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
                Question::create([
                    'evaluation_id' => $evaluation->id,
                    'question_text' => $q['question_text'],
                    'options' => $q['options'],
                    'correct_option' => $q['correct_option'] ?? null,
                    'points' => 1,
                ]);
            }
        });

        return redirect()->route('evaluations-manage.index')
            ->with('success', '¡Evaluación y preguntas creadas con éxito!');
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
