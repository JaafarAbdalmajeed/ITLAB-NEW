<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Models\Track;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display reports index page
     */
    public function index()
    {
        $stats = $this->reportService->getDashboardStats();
        $tracks = Track::all();
        
        return view('admin.reports.index', compact('stats', 'tracks'));
    }

    /**
     * Display users report
     */
    public function users(Request $request)
    {
        $filters = [
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'is_admin' => $request->input('is_admin'),
        ];

        $data = $this->reportService->getUsersReport($filters);

        if ($request->input('export') === 'pdf') {
            return $this->exportUsersPDF($data);
        }

        if ($request->input('export') === 'excel') {
            return $this->exportUsersExcel($data);
        }

        return view('admin.reports.users', $data);
    }

    /**
     * Display tracks report
     */
    public function tracks(Request $request)
    {
        $filters = [
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        $data = $this->reportService->getTracksReport($filters);

        if ($request->input('export') === 'pdf') {
            return $this->exportTracksPDF($data);
        }

        if ($request->input('export') === 'excel') {
            return $this->exportTracksExcel($data);
        }

        return view('admin.reports.tracks', $data);
    }

    /**
     * Display quizzes report
     */
    public function quizzes(Request $request)
    {
        $filters = [
            'track_id' => $request->input('track_id'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        $data = $this->reportService->getQuizzesReport($filters);
        $tracks = Track::all();

        if ($request->input('export') === 'pdf') {
            return $this->exportQuizzesPDF($data);
        }

        if ($request->input('export') === 'excel') {
            return $this->exportQuizzesExcel($data);
        }

        return view('admin.reports.quizzes', array_merge($data, ['tracks' => $tracks]));
    }

    /**
     * Display certificates report
     */
    public function certificates(Request $request)
    {
        $filters = [
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'type' => $request->input('type'),
        ];

        $data = $this->reportService->getCertificatesReport($filters);

        if ($request->input('export') === 'pdf') {
            return $this->exportCertificatesPDF($data);
        }

        if ($request->input('export') === 'excel') {
            return $this->exportCertificatesExcel($data);
        }

        return view('admin.reports.certificates', $data);
    }

    /**
     * Export users report as PDF
     */
    protected function exportUsersPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.exports.users-pdf', $data);
        return $pdf->download('users-report-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export users report as Excel
     */
    protected function exportUsersExcel($data)
    {
        $filename = 'users-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, ['Name', 'Email', 'Registration Date', 'Quiz Results', 'Progress Records', 'Is Admin']);
            
            // Data
            foreach ($data['users'] as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->created_at->format('Y-m-d'),
                    $user->quiz_results_count,
                    $user->progress_count,
                    $user->is_admin ? 'Yes' : 'No',
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export tracks report as PDF
     */
    protected function exportTracksPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.exports.tracks-pdf', $data);
        return $pdf->download('tracks-report-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export tracks report as Excel
     */
    protected function exportTracksExcel($data)
    {
        $filename = 'tracks-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, ['Track', 'Lessons', 'Quizzes', 'Labs', 'Users with Progress', 'Certificates', 'Completion Rate']);
            
            // Data
            foreach ($data['tracks'] as $track) {
                $completionRate = $data['completion_rates'][$track->id]['completion_rate'] ?? 0;
                fputcsv($file, [
                    $track->title,
                    $track->lessons_count,
                    $track->quizzes_count,
                    $track->labs_count,
                    $track->user_progress_count,
                    $track->certificates_count,
                    $completionRate . '%',
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export quizzes report as PDF
     */
    protected function exportQuizzesPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.exports.quizzes-pdf', $data);
        return $pdf->download('quizzes-report-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export quizzes report as Excel
     */
    protected function exportQuizzesExcel($data)
    {
        $filename = 'quizzes-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, ['Quiz', 'Track', 'Questions', 'Total Attempts', 'Avg Score', 'Max Score', 'Min Score', 'Pass Rate']);
            
            // Data
            foreach ($data['quizzes'] as $quiz) {
                $performance = $data['quiz_performance'][$quiz->id] ?? null;
                fputcsv($file, [
                    $quiz->title,
                    $quiz->track->title ?? 'N/A',
                    $quiz->questions_count,
                    $performance['total_attempts'] ?? 0,
                    ($performance['avg_score'] ?? 0) . '%',
                    ($performance['max_score'] ?? 0) . '%',
                    ($performance['min_score'] ?? 0) . '%',
                    ($performance['pass_rate'] ?? 0) . '%',
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export certificates report as PDF
     */
    protected function exportCertificatesPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.exports.certificates-pdf', $data);
        return $pdf->download('certificates-report-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export certificates report as Excel
     */
    protected function exportCertificatesExcel($data)
    {
        $filename = 'certificates-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, ['Certificate Number', 'User', 'Track', 'Quiz', 'Type', 'Issued Date']);
            
            // Data
            foreach ($data['certificates'] as $certificate) {
                fputcsv($file, [
                    $certificate->certificate_number,
                    $certificate->user->name ?? 'N/A',
                    $certificate->track->title ?? 'N/A',
                    $certificate->quiz->title ?? 'N/A',
                    $certificate->type,
                    $certificate->issued_at->format('Y-m-d'),
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

