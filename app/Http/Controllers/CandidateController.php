<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends Controller
{
    /**
     * Display a listing of candidates with FMK table styling, hiring pipeline KPIs, and SQL injection immune search.
     */
    public function index(Request $request): View
    {
        $search = (string) $request->input('search');
        $stage = (string) $request->input('stage');
        $vacancyId = $request->input('vacancy_id');

        $query = Candidate::with(['sessions.evaluation', 'vacancy']);

        // Search filter with wildcard escaping
        if ($request->filled('search')) {
            $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
            $query->where(function ($q) use ($escaped) {
                $q->where('full_name', 'like', "%{$escaped}%")
                  ->orWhere('email', 'like', "%{$escaped}%")
                  ->orWhere('applied_position', 'like', "%{$escaped}%")
                  ->orWhere('city', 'like', "%{$escaped}%");
            });
        }

        // Hiring stage filter
        if ($request->filled('stage') && in_array($stage, ['POSTULADO', 'EVALUADO', 'ENTREVISTA', 'OFERTA', 'CONTRATADO', 'DESCARTADO'])) {
            $query->where('hiring_stage', $stage);
        }

        // Vacancy filter
        if ($request->filled('vacancy_id') && is_numeric($vacancyId)) {
            $query->where('vacancy_id', (int) $vacancyId);
        }

        $candidates = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Hiring Funnel Metrics
        $totalCandidates = Candidate::count();
        $totalPostulados = Candidate::where('hiring_stage', 'POSTULADO')->count();
        $totalEvaluados = Candidate::where('hiring_stage', 'EVALUADO')->count();
        $totalEntrevista = Candidate::where('hiring_stage', 'ENTREVISTA')->count();
        $totalOferta = Candidate::where('hiring_stage', 'OFERTA')->count();
        $totalContratados = Candidate::where('hiring_stage', 'CONTRATADO')->count();
        $totalDescartados = Candidate::where('hiring_stage', 'DESCARTADO')->count();
        $hireRate = $totalCandidates > 0 ? round(($totalContratados / $totalCandidates) * 100, 1) : 0;

        $vacancies = Vacancy::orderBy('title')->get();

        return view('candidates.index', compact(
            'candidates',
            'search',
            'stage',
            'vacancyId',
            'totalCandidates',
            'totalPostulados',
            'totalEvaluados',
            'totalEntrevista',
            'totalOferta',
            'totalContratados',
            'totalDescartados',
            'hireRate',
            'vacancies'
        ));
    }

    /**
     * Update candidate hiring stage in the recruitment pipeline.
     */
    public function updateStage(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'hiring_stage' => 'required|string|in:POSTULADO,EVALUADO,ENTREVISTA,OFERTA,CONTRATADO,DESCARTADO',
            'hiring_notes' => 'nullable|string|max:1000',
            'interview_scheduled_at' => 'nullable|date',
        ]);

        $updates = [
            'hiring_stage' => $validated['hiring_stage'],
        ];

        if (array_key_exists('hiring_notes', $validated)) {
            $updates['hiring_notes'] = $validated['hiring_notes'];
        }

        if (array_key_exists('interview_scheduled_at', $validated)) {
            $updates['interview_scheduled_at'] = $validated['interview_scheduled_at'];
        }

        if ($validated['hiring_stage'] === 'CONTRATADO') {
            $updates['hired_at'] = now();
        }

        $candidate->update($updates);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Estado de contratación actualizado a {$validated['hiring_stage']}",
                'candidate' => $candidate,
            ]);
        }

        return back()->with('success', "Estado del candidato {$candidate->full_name} actualizado a '{$validated['hiring_stage']}'.");
    }

    /**
     * Formalize hiring of a candidate.
     */
    public function hire(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'hiring_notes' => 'nullable|string|max:2000',
        ]);

        $candidate->update([
            'hiring_stage' => 'CONTRATADO',
            'hired_at' => now(),
            'hiring_notes' => $validated['hiring_notes'] ?? $candidate->hiring_notes,
        ]);

        return back()->with('success', "¡Excelente decisión! Se ha formalizado la contratación de {$candidate->full_name}. El candidato ya figura en el registro oficial de contratados.");
    }
}
