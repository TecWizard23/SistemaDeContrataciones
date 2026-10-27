<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class RecruitmentDashboardController extends Controller
{
    /**
     * Display HR Recruitment Dashboard with candidate filter metrics and SQL injection-immune queries.
     */
    public function index(Request $request)
    {
        $query = Candidate::with(['sessions.evaluation']);

        if ($request->filled('position')) {
            $query->where('applied_position', (string) $request->input('position'));
        }

        // SQL Injection-immune search escaping LIKE wildcard characters
        if ($request->filled('search')) {
            $search = (string) $request->input('search');
            $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
            $query->where(function ($q) use ($escaped) {
                $q->where('full_name', 'like', "%{$escaped}%")
                  ->orWhere('email', 'like', "%{$escaped}%")
                  ->orWhere('applied_position', 'like', "%{$escaped}%");
            });
        }

        if ($request->filled('min_fit')) {
            $minFit = max(0, min(100, (float) $request->input('min_fit')));
            $query->whereHas('sessions', function ($q) use ($minFit) {
                $q->where('status', 'COMPLETED')->where('fit_percentage', '>=', $minFit);
            });
        }

        if ($request->filled('max_fit')) {
            $maxFit = max(0, min(100, (float) $request->input('max_fit')));
            $query->whereHas('sessions', function ($q) use ($maxFit) {
                $q->where('status', 'COMPLETED')->where('fit_percentage', '<=', $maxFit);
            });
        }

        $candidates = $query->orderBy('id', 'desc')->get();

        $positions = Candidate::select('applied_position')->distinct()->pluck('applied_position');
        $evaluations = Evaluation::all();

        $completedSessions = CandidateSession::where('status', 'COMPLETED')->get();
        $totalCandidatesCount = Candidate::count();
        $completedSessionsCount = $completedSessions->count();
        $avgFitPercentage = $completedSessionsCount > 0 ? round($completedSessions->avg('fit_percentage'), 1) : 0;

        // Enhanced Metrics
        $openVacanciesCount = Vacancy::where('status', 'OPEN')->count();
        $highFitCount = $completedSessions->where('fit_percentage', '>=', 70)->count();
        $midFitCount = $completedSessions->whereBetween('fit_percentage', [40, 69.99])->count();
        $lowFitCount = $completedSessions->where('fit_percentage', '<', 40)->count();

        $recentSessions = CandidateSession::with(['candidate', 'evaluation'])
            ->where('status', 'COMPLETED')
            ->orderBy('completed_at', 'desc')
            ->take(6)
            ->get();

        return view('dashboard.index', compact(
            'candidates',
            'positions',
            'evaluations',
            'totalCandidatesCount',
            'completedSessionsCount',
            'avgFitPercentage',
            'openVacanciesCount',
            'highFitCount',
            'midFitCount',
            'lowFitCount',
            'recentSessions'
        ));
    }

    /**
     * Display detailed individual report for an evaluation session.
     */
    public function showSession(CandidateSession $session)
    {
        $session->load(['candidate', 'evaluation', 'answers.question']);

        return view('dashboard.session_detail', compact('session'));
    }
}
