<?php

namespace App\Http\Controllers;

use App\Models\CandidateSession;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;

class CandidatePortalController extends Controller
{
    /**
     * Display the candidate portal dashboard showing candidate info, position, and assigned tests.
     */
    public function index()
    {
        $user = Auth::user();
        $candidate = $user->candidate;

        if (!$candidate) {
            abort(403, 'No existe un perfil de candidato asociado a esta cuenta.');
        }

        $evaluations = Evaluation::withCount('questions')->get();
        $sessions = CandidateSession::where('candidate_id', $candidate->id)
            ->get()
            ->keyBy('evaluation_id');

        return view('portal.index', compact('candidate', 'evaluations', 'sessions'));
    }
}
