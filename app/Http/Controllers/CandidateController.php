<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends Controller
{
    /**
     * Display a listing of candidates with FMK table styling.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $query = Candidate::with('sessions.evaluation');

        if ($search) {
            $query->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('applied_position', 'LIKE', "%{$search}%");
        }

        $candidates = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('candidates.index', [
            'candidates' => $candidates,
            'search' => $search,
        ]);
    }
}
