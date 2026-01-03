@extends('layouts.app')

@section('title', 'My Certificates — ITLAB')
@section('body-class', 'page-certificates')

@section('content')
@push('styles')
<style>
    body.page-certificates {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    .certificates-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .certificates-header {
        text-align: center;
        color: white;
        margin-bottom: 40px;
    }

    .certificates-header h1 {
        font-size: 36px;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .certificates-header p {
        font-size: 18px;
        opacity: 0.9;
    }

    .certificates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .certificate-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
    }

    .certificate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0,0,0,0.3);
    }

    .certificate-icon {
        font-size: 64px;
        color: #667eea;
        margin-bottom: 20px;
    }

    .certificate-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .certificate-number {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
        font-family: monospace;
    }

    .certificate-date {
        font-size: 14px;
        color: #999;
        margin-bottom: 20px;
    }

    .certificate-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-view, .btn-download {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-view {
        background: #667eea;
        color: white;
    }

    .btn-view:hover {
        background: #5568d3;
    }

    .btn-download {
        background: #28a745;
        color: white;
    }

    .btn-download:hover {
        background: #218838;
    }

    .no-certificates {
        text-align: center;
        background: white;
        padding: 60px 20px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .no-certificates-icon {
        font-size: 80px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .no-certificates h2 {
        color: #333;
        margin-bottom: 10px;
    }

    .no-certificates p {
        color: #666;
        margin-bottom: 30px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
@endpush

<div class="certificates-container">
    <div class="certificates-header">
        <h1>My Certificates</h1>
        <p>All certificates you have earned</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($certificates->count() > 0)
        <div class="certificates-grid">
            @foreach($certificates as $certificate)
                <div class="certificate-card">
                    <div class="certificate-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="certificate-title">{{ $certificate->track->title }}</div>
                    <div class="certificate-number">Certificate No: {{ $certificate->certificate_number }}</div>
                    <div class="certificate-date">
                        Issued on: {{ $certificate->issued_at->format('Y/m/d') }}
                    </div>
                    <div class="certificate-actions">
                        <a href="{{ route('tracks.certificate.show', $certificate->track) }}" class="btn-view">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('tracks.certificate.download', $certificate->track) }}" class="btn-download" target="_blank">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-certificates">
            <div class="no-certificates-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <h2>No Certificates Yet</h2>
            <p>Complete tracks to earn certificates</p>
            <a href="{{ route('home') }}" class="btn-view" style="text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    @endif
</div>
@endsection

