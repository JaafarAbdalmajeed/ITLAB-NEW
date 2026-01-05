<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Certificate::with(['user', 'track']);

            // Filter by track
            if ($request->has('track_id') && $request->track_id) {
                $query->where('track_id', $request->track_id);
            }

            // Filter by user
            if ($request->has('user_id') && $request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            // Search by certificate number
            if ($request->has('search') && $request->search) {
                $query->where('certificate_number', 'like', '%' . $request->search . '%');
            }

            $certificates = $query->latest('issued_at')->paginate(20)->appends($request->query());
            $tracks = Track::all();
            $users = User::all();

            return view('admin.certificates.index', compact('certificates', 'tracks', 'users'));
        } catch (\Exception $e) {
            \Log::error('Certificate index error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Error loading certificates: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $tracks = Track::all();
        $users = User::all();
        return view('admin.certificates.create', compact('tracks', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'track_id' => 'required|exists:tracks,id',
            'certificate_number' => 'nullable|string|max:255|unique:certificates,certificate_number',
            'issued_at' => 'nullable|date',
        ]);

        // Generate certificate number if not provided
        if (empty($data['certificate_number'])) {
            $data['certificate_number'] = Certificate::generateCertificateNumber();
        }

        // Set issued_at to now if not provided
        if (empty($data['issued_at'])) {
            $data['issued_at'] = now();
        }

        Certificate::create($data);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate created successfully.');
    }

    public function show(Certificate $certificate)
    {
        $certificate->load(['user', 'track']);
        return view('admin.certificates.show', compact('certificate'));
    }

    /**
     * View certificate (without completion check)
     */
    public function view(Certificate $certificate)
    {
        $certificate->load(['user', 'track']);
        $user = $certificate->user;
        $track = $certificate->track;
        
        return view('certificates.show', compact('certificate', 'track', 'user'));
    }

    /**
     * Download certificate as PDF (without completion check)
     */
    public function download(Certificate $certificate)
    {
        $certificate->load(['user', 'track']);
        $user = $certificate->user;
        $track = $certificate->track;
        
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

    public function edit(Certificate $certificate)
    {
        $certificate->load(['user', 'track']);
        $tracks = Track::all();
        $users = User::all();
        return view('admin.certificates.edit', compact('certificate', 'tracks', 'users'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'track_id' => 'required|exists:tracks,id',
            'certificate_number' => 'required|string|max:255|unique:certificates,certificate_number,' . $certificate->id,
            'issued_at' => 'required|date',
        ]);

        $certificate->update($data);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully.');
    }
}
