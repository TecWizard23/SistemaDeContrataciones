<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isHR()
                ? redirect()->route('dashboard.index')
                : redirect()->route('portal.index');
        }

        return view('auth.login');
    }

    /**
     * Process login request with rate limiting and SQL injection protection.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        // Rate limiting key by normalized email and client IP
        $throttleKey = Str::transliterate(Str::lower($credentials['email']) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Demasiados intentos fallidos. Por seguridad, tu acceso se ha bloqueado temporalmente por {$seconds} segundos.",
            ])->onlyInput('email');
        }

        // Safe authenticated attempt with PDO parameterized binding
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isHR()) {
                return redirect()->intended(route('dashboard.index'))
                    ->with('success', '¡Bienvenido de nuevo al Panel de RRHH!');
            }

            return redirect()->intended(route('portal.index'))
                ->with('success', '¡Bienvenido al Portal del Postulante!');
        }

        // Increment failed attempt counter with 60s cooldown
        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Show candidate registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->isHR()
                ? redirect()->route('dashboard.index')
                : redirect()->route('portal.index');
        }

        return view('auth.register');
    }

    /**
     * Process candidate registration with safe transactional insertion.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email|unique:candidates,email',
            'phone' => 'nullable|string|max:50',
            'applied_position' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = DB::transaction(function () use ($validated) {
            $candidate = Candidate::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'applied_position' => $validated['applied_position'],
            ]);

            return User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'CANDIDATE',
                'candidate_id' => $candidate->id,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('portal.index')
            ->with('success', '¡Cuenta de postulante creada con éxito! Ya puedes iniciar tus evaluaciones.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}
