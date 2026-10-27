<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyController extends Controller
{
    /**
     * Display listing of job vacancies with search and filters.
     */
    public function index(Request $request): View
    {
        $query = Vacancy::withCount('candidates');

        // SQL injection immune search with escaped LIKE special characters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
            $query->where(function ($q) use ($escaped) {
                $q->where('title', 'like', "%{$escaped}%")
                  ->orWhere('department', 'like', "%{$escaped}%")
                  ->orWhere('location', 'like', "%{$escaped}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        $vacancies = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Metrics for summary cards
        $totalOpen = Vacancy::where('status', 'OPEN')->count();
        $totalInReview = Vacancy::where('status', 'IN_REVIEW')->count();
        $totalClosed = Vacancy::where('status', 'CLOSED')->count();
        $departments = Vacancy::select('department')->distinct()->pluck('department');

        return view('vacancies.index', compact(
            'vacancies',
            'totalOpen',
            'totalInReview',
            'totalClosed',
            'departments'
        ));
    }

    /**
     * Show form to create a new vacancy.
     */
    public function create(): View
    {
        return view('vacancies.create');
    }

    /**
     * Store a newly created vacancy.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:100',
            'contract_type' => 'required|string|max:100',
            'openings_count' => 'required|integer|min:1|max:50',
            'status' => 'required|in:OPEN,IN_REVIEW,CLOSED',
            'salary_range' => 'nullable|string|max:100',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'closing_date' => 'nullable|date',
        ]);

        $validated['created_by'] = auth()->id();

        Vacancy::create($validated);

        return redirect()->route('vacancies.index')
            ->with('success', 'Convocatoria laboral publicada exitosamente.');
    }

    /**
     * Show form to edit an existing vacancy.
     */
    public function edit(Vacancy $vacancy): View
    {
        return view('vacancies.edit', compact('vacancy'));
    }

    /**
     * Update an existing vacancy.
     */
    public function update(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:100',
            'contract_type' => 'required|string|max:100',
            'openings_count' => 'required|integer|min:1|max:50',
            'status' => 'required|in:OPEN,IN_REVIEW,CLOSED',
            'salary_range' => 'nullable|string|max:100',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'closing_date' => 'nullable|date',
        ]);

        $vacancy->update($validated);

        return redirect()->route('vacancies.index')
            ->with('success', 'Convocatoria laboral actualizada correctamente.');
    }

    /**
     * Quick toggle vacancy status (OPEN <-> CLOSED).
     */
    public function toggleStatus(Vacancy $vacancy)
    {
        $newStatus = $vacancy->status === 'OPEN' ? 'CLOSED' : 'OPEN';
        $vacancy->update(['status' => $newStatus]);

        return back()->with('success', "Estado de la convocatoria modificado a {$newStatus}.");
    }

    /**
     * Delete a vacancy.
     */
    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()->route('vacancies.index')
            ->with('success', 'Convocatoria eliminada correctamente.');
    }
}
