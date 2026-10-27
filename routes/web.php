<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidatePortalController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CandidateReportController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\EvaluationManagementController;
use App\Http\Controllers\ExamTakingController;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\RecruitmentDashboardController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public job board and QR application routes
Route::get('/convocatorias', [PublicJobController::class, 'index'])->name('public.vacancies.index');
Route::get('/convocatorias/{vacancy}', [PublicJobController::class, 'show'])->name('public.vacancies.show');
Route::post('/convocatorias/{vacancy}/postular', [PublicJobController::class, 'apply'])->name('public.vacancies.apply');

// Guest authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Root route: Smart redirect for both guest and authenticated users
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isHR()
            ? redirect()->route('dashboard.index')
            : redirect()->route('portal.index');
    }
    return redirect()->route('public.vacancies.index');
});

// Authenticated shared routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// HR Restricted Routes
Route::middleware(['auth', 'role:HR'])->group(function () {
    Route::get('/dashboard', [RecruitmentDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/sessions/{session}', [RecruitmentDashboardController::class, 'showSession'])->name('dashboard.sessions.show');
    Route::get('/dashboard/sesiones/{session}/pdf', [CandidateReportController::class, 'exportPdf'])->name('candidate.session.pdf');

    // Vacancies Management Module
    Route::resource('vacancies', VacancyController::class);
    Route::patch('vacancies/{vacancy}/toggle-status', [VacancyController::class, 'toggleStatus'])->name('vacancies.toggle-status');

    Route::resource('evaluations-manage', EvaluationManagementController::class)->parameters([
        'evaluations-manage' => 'evaluation',
    ]);

    // HR Candidate Comparison & Radar Routes
    Route::get('/hr/compare', [ComparisonController::class, 'index'])->name('hr.compare');
    Route::get('/hr/compare/export', [ComparisonController::class, 'export'])->name('hr.compare.export');

    // FMK Analytics & Candidates Routes
    Route::get('/estadisticas', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::patch('/candidates/{candidate}/stage', [CandidateController::class, 'updateStage'])->name('candidates.update-stage');
    Route::post('/candidates/{candidate}/hire', [CandidateController::class, 'hire'])->name('candidates.hire');
});

// Candidate Restricted Routes
Route::middleware(['auth', 'role:CANDIDATE'])->group(function () {
    Route::get('/portal', [CandidatePortalController::class, 'index'])->name('portal.index');
    Route::get('/portal/perfil', [CandidateProfileController::class, 'show'])->name('portal.profile');
    Route::put('/portal/perfil', [CandidateProfileController::class, 'update'])->name('portal.profile.update');
    Route::get('/portal/mis-resultados', [CandidateProfileController::class, 'myResults'])->name('portal.my-results');

    Route::get('/exam/{evaluation}', [ExamTakingController::class, 'show'])->name('exam.show');
    Route::post('/exam/sessions/{session}/submit', [ExamTakingController::class, 'submit'])->name('exam.submit');
    Route::get('/exam/sessions/{session}/completed', [ExamTakingController::class, 'completed'])->name('exam.completed');
});

