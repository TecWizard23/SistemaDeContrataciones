<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\CandidateSession;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class RecruitmentDashboardController extends Controller
{
    /**
     * Display HR Recruitment Dashboard with candidate filter metrics.
     */
    public function index(Request $request)
    {
        $query = Candidate::with(['sessions.evaluation']);

        if ($request->filled('position')) {
            $query->where('applied_position', $request->input('position'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_fit')) {
            $minFit = (float) $request->input('min_fit');
            $query->whereHas('sessions', function ($q) use ($minFit) {
                $q->where('status', 'COMPLETED')->where('fit_percentage', '>=', $minFit);
            });
        }

        if ($request->filled('max_fit')) {
            $maxFit = (float) $request->input('max_fit');
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

        return view('dashboard.index', compact(
            'candidates',
            'positions',
            'evaluations',
            'totalCandidatesCount',
            'completedSessionsCount',
            'avgFitPercentage'
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
