<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Track;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    /**
     * Display certificate for a track
     */
    public function show(Track $track)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login')
                ->with('error', 'You must be logged in to view the certificate');
        }

        // Check if track is completed
        if (!$this->isTrackCompleted($user, $track)) {
            return redirect()->back()
                ->with('error', 'You must complete the track first to get the certificate');
        }

        // Get or create certificate
        $certificate = Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'track_id' => $track->id,
            ],
            [
                'certificate_number' => Certificate::generateCertificateNumber(),
                'issued_at' => now(),
            ]
        );

        return view('certificates.show', compact('certificate', 'track', 'user'));
    }

    /**
     * Download certificate as PDF
     */
    public function download(Track $track)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login')
                ->with('error', 'You must be logged in to download the certificate');
        }

        // Check if track is completed
        if (!$this->isTrackCompleted($user, $track)) {
            return redirect()->back()
                ->with('error', 'You must complete the track first to get the certificate');
        }

        // Get or create certificate
        $certificate = Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'track_id' => $track->id,
            ],
            [
                'certificate_number' => Certificate::generateCertificateNumber(),
                'issued_at' => now(),
            ]
        );

        // Generate PDF
        try {
            $pdf = Pdf::loadView('certificates.pdf', compact('certificate', 'track', 'user'));
            $pdf->setPaper('a4', 'landscape');
            
            return $pdf->download('certificate-' . $certificate->certificate_number . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    /**
     * Display certificate for a quiz
     */
    public function showQuiz(Track $track, Quiz $quiz)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login')
                ->with('error', 'You must be logged in to view the certificate');
        }

        // Check if certificate exists for this quiz
        $certificate = Certificate::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->first();

        if (!$certificate) {
            return redirect()->back()
                ->with('error', 'You must pass the quiz with 70% or higher to get the certificate');
        }

        return view('certificates.show', compact('certificate', 'track', 'quiz', 'user'));
    }

    /**
     * Download certificate as PDF for a quiz
     */
    public function downloadQuiz(Track $track, Quiz $quiz)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login')
                ->with('error', 'You must be logged in to download the certificate');
        }

        // Check if certificate exists for this quiz
        $certificate = Certificate::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->first();

        if (!$certificate) {
            return redirect()->back()
                ->with('error', 'You must pass the quiz with 70% or higher to get the certificate');
        }

        // Generate PDF
        try {
            $pdf = Pdf::loadView('certificates.pdf', compact('certificate', 'track', 'quiz', 'user'));
            $pdf->setPaper('a4', 'landscape');
            
            return $pdf->download('certificate-' . $certificate->certificate_number . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    /**
     * List all user certificates
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.login')
                ->with('error', 'You must be logged in to view certificates');
        }

        $certificates = $user->certificates()
            ->with(['track', 'quiz'])
            ->latest('issued_at')
            ->get();

        return view('certificates.index', compact('certificates'));
    }

    /**
     * Check if user has completed the track
     */
    private function isTrackCompleted($user, Track $track): bool
    {
        $progress = $track->getUserProgress($user->id);
        
        return $progress && $progress->progress_percent >= 100;
    }
}
