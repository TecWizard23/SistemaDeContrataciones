<?php

namespace App\Http\Controllers;

use App\Models\CandidateSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CandidateProfileController extends Controller
{
    /**
     * Display candidate profile view.
     */
    public function show(): View
    {
        $user = Auth::user();
        $candidate = $user->candidate;

        if (!$candidate) {
            abort(404, 'Perfil de postulante no encontrado.');
        }

        return view('portal.profile', compact('user', 'candidate'));
    }

    /**
     * Update candidate profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $candidate = $user->candidate;

        if (!$candidate) {
            abort(404, 'Perfil de postulante no encontrado.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'education_level' => 'nullable|string|max:100',
            'linkedin_url' => 'nullable|url|max:255',
            'summary' => 'nullable|string|max:1000',
        ]);

        $candidate->update($validated);

        // Keep User name in sync
        $user->update(['name' => $validated['full_name']]);

        return redirect()->route('portal.profile')
            ->with('success', '¡Tu perfil profesional ha sido actualizado correctamente!');
    }

    /**
     * Display candidate's completed results and assessment feedback.
     */
    public function myResults(): View
    {
        $user = Auth::user();
        $candidate = $user->candidate;

        if (!$candidate) {
            abort(404, 'Perfil de postulante no encontrado.');
        }

        $completedSessions = CandidateSession::with('evaluation')
            ->where('candidate_id', $candidate->id)
            ->where('status', 'COMPLETED')
            ->orderBy('completed_at', 'desc')
            ->get();

        $inProgressSessions = CandidateSession::with('evaluation')
            ->where('candidate_id', $candidate->id)
            ->where('status', '!=', 'COMPLETED')
            ->get();

        $overallFit = $completedSessions->count() > 0 
            ? round($completedSessions->avg('fit_percentage'), 1) 
            : 0;

        return view('portal.my_results', compact('candidate', 'completedSessions', 'inProgressSessions', 'overallFit'));
    }
}
