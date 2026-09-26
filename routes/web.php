<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidatePortalController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\EvaluationManagementController;
use App\Http\Controllers\ExamTakingController;
use App\Http\Controllers\RecruitmentDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Guest authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated shared routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return Auth::user()->isHR()
            ? redirect()->route('dashboard.index')
            : redirect()->route('portal.index');
    });
});

// HR Restricted Routes
Route::middleware(['auth', 'role:HR'])->group(function () {
    Route::get('/dashboard', [RecruitmentDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/sessions/{session}', [RecruitmentDashboardController::class, 'showSession'])->name('dashboard.sessions.show');

    Route::resource('evaluations-manage', EvaluationManagementController::class)->except(['show', 'edit', 'update']);

    // HR Candidate Comparison & Radar Routes
    Route::get('/hr/compare', [ComparisonController::class, 'index'])->name('hr.compare');
    Route::get('/hr/compare/export', [ComparisonController::class, 'export'])->name('hr.compare.export');

    // FMK Analytics & Candidates Routes
    Route::get('/estadisticas', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
});

// Candidate Restricted Routes
Route::middleware(['auth', 'role:CANDIDATE'])->group(function () {
    Route::get('/portal', [CandidatePortalController::class, 'index'])->name('portal.index');
    Route::get('/exam/{evaluation}', [ExamTakingController::class, 'show'])->name('exam.show');
    Route::post('/exam/sessions/{session}/submit', [ExamTakingController::class, 'submit'])->name('exam.submit');
    Route::get('/exam/sessions/{session}/completed', [ExamTakingController::class, 'completed'])->name('exam.completed');
});
