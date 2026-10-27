<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PublicJobController extends Controller
{
    /**
     * Display public listing of open job vacancies.
     */
    public function index(Request $request): View
    {
        $search = (string) $request->input('search');
        $department = (string) $request->input('department');

        $query = Vacancy::where('status', 'OPEN');

        if ($request->filled('search')) {
            $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
            $query->where(function ($q) use ($escaped) {
                $q->where('title', 'like', "%{$escaped}%")
                  ->orWhere('department', 'like', "%{$escaped}%")
                  ->orWhere('location', 'like', "%{$escaped}%")
                  ->orWhere('description', 'like', "%{$escaped}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $department);
        }

        $vacancies = $query->orderBy('created_at', 'desc')->paginate(9)->withQueryString();
        $departments = Vacancy::where('status', 'OPEN')->distinct()->pluck('department')->filter();

        return view('public.vacancies.index', compact('vacancies', 'departments', 'search', 'department'));
    }

    /**
     * Display a specific public vacancy (QR destination URL).
     */
    public function show(Vacancy $vacancy): View
    {
        return view('public.vacancies.show', compact('vacancy'));
    }

    /**
     * Handle public candidate application to a vacancy.
     */
    public function apply(Request $request, Vacancy $vacancy)
    {
        if ($vacancy->status !== 'OPEN') {
            return back()->with('error', 'Esta convocatoria ya no se encuentra abierta para postulaciones.');
        }

        // If user is already logged in as candidate
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isHR()) {
                return redirect()->route('vacancies.index')
                    ->with('error', 'Los usuarios administradores de RRHH no pueden postularse a vacantes.');
            }

            $candidate = $user->candidate;
            if (!$candidate) {
                $candidate = Candidate::create([
                    'full_name' => $user->name,
                    'email' => $user->email,
                    'applied_position' => $vacancy->title,
                    'vacancy_id' => $vacancy->id,
                    'hiring_stage' => 'POSTULADO',
                ]);
                $user->update(['candidate_id' => $candidate->id]);
            } else {
                $candidate->update([
                    'applied_position' => $vacancy->title,
                    'vacancy_id' => $vacancy->id,
                    'hiring_stage' => 'POSTULADO',
                ]);
            }

            return redirect()->route('portal.index')
                ->with('success', "¡Tu postulación para '{$vacancy->title}' se ha registrado exitosamente! Ya puedes rendir tus evaluaciones.");
        }

        // If user is a guest, validate application and registration fields
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:50',
            'city' => 'nullable|string|max:100',
            'education_level' => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'linkedin_url' => 'nullable|url|max:255',
            'summary' => 'nullable|string|max:2000',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = DB::transaction(function () use ($validated, $vacancy) {
            // Find existing candidate by email or create new
            $candidate = Candidate::where('email', $validated['email'])->first();

            if ($candidate) {
                $candidate->update([
                    'full_name' => $validated['full_name'],
                    'phone' => $validated['phone'],
                    'city' => $validated['city'] ?? $candidate->city,
                    'education_level' => $validated['education_level'] ?? $candidate->education_level,
                    'experience_years' => $validated['experience_years'] ?? $candidate->experience_years,
                    'linkedin_url' => $validated['linkedin_url'] ?? $candidate->linkedin_url,
                    'summary' => $validated['summary'] ?? $candidate->summary,
                    'applied_position' => $vacancy->title,
                    'vacancy_id' => $vacancy->id,
                    'hiring_stage' => 'POSTULADO',
                ]);
            } else {
                $candidate = Candidate::create([
                    'full_name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'city' => $validated['city'] ?? null,
                    'education_level' => $validated['education_level'] ?? null,
                    'experience_years' => $validated['experience_years'] ?? 0,
                    'linkedin_url' => $validated['linkedin_url'] ?? null,
                    'summary' => $validated['summary'] ?? null,
                    'applied_position' => $vacancy->title,
                    'vacancy_id' => $vacancy->id,
                    'hiring_stage' => 'POSTULADO',
                ]);
            }

            $user = User::where('email', $validated['email'])->first();
            if ($user) {
                $user->update([
                    'candidate_id' => $candidate->id,
                    'role' => 'CANDIDATE',
                ]);
            } else {
                $user = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'CANDIDATE',
                    'candidate_id' => $candidate->id,
                ]);
            }

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('portal.index')
            ->with('success', "¡Bienvenido(a) a Fundación Munasim Kullakita! Tu postulación para '{$vacancy->title}' se registró con éxito. Te invitamos a completar tus evaluaciones psicométricas asignadas.");
    }
}
