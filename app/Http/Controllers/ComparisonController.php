<?php

namespace App\Http\Controllers;

use App\Services\CandidateComparisonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ComparisonController extends Controller
{
    protected CandidateComparisonService $comparisonService;

    public function __construct(CandidateComparisonService $comparisonService)
    {
        $this->comparisonService = $comparisonService;
    }

    /**
     * Render the HR Candidate Comparison & Competency Radar dashboard.
     */
    public function index(Request $request): View|JsonResponse
    {
        $candidateIds = $request->input('candidates', []);

        // Support both array query candidates[] and comma-separated string candidates=1,2,3
        if (is_string($candidateIds)) {
            $candidateIds = array_filter(array_map('intval', explode(',', $candidateIds)));
        } elseif (is_array($candidateIds)) {
            $candidateIds = array_filter(array_map('intval', $candidateIds));
        }

        $department = $request->input('department');
        $dateRange = $request->input('date_range', 'Últimos 365 días');

        $comparisonData = $this->comparisonService->getComparisonData($candidateIds, $department, $dateRange);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($comparisonData);
        }

        return view('hr.compare', [
            'comparisonData' => $comparisonData,
            'selectedCandidateIds' => $candidateIds,
            'selectedDepartment' => $department ?? 'All',
            'selectedDateRange' => $dateRange,
        ]);
    }

    /**
     * Export comparison matrix into a downloadable CSV file stream.
     */
    public function export(Request $request): StreamedResponse
    {
        $candidateIds = $request->input('candidates', []);

        if (is_string($candidateIds)) {
            $candidateIds = array_filter(array_map('intval', explode(',', $candidateIds)));
        } elseif (is_array($candidateIds)) {
            $candidateIds = array_filter(array_map('intval', $candidateIds));
        }

        $department = $request->input('department');
        $dateRange = $request->input('date_range', 'Últimos 365 días');

        $data = $this->comparisonService->getComparisonData($candidateIds, $department, $dateRange);
        $axes = $data['axes_labels'];
        $candidates = $data['selected_candidates'];

        $fileName = 'comparativa_candidatos_kullakita_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($axes, $candidates) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header Row
            $headerRow = array_merge([
                'ID',
                'Candidato',
                'Email',
                'Puesto / Departamento',
                'Puntaje General (%)',
            ], $axes);

            fputcsv($file, $headerRow);

            // CSV Data Rows
            foreach ($candidates as $cand) {
                $row = array_merge([
                    $cand['id'],
                    $cand['name'],
                    $cand['email'],
                    $cand['applied_position'],
                    $cand['overall_score'] . '%',
                ], array_map(fn($s) => $s . '%', $cand['scores']));

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
