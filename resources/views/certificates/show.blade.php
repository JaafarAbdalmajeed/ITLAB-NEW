@extends('layouts.app')

@section('title', 'Certificate - ' . (isset($quiz) ? $quiz->title : $track->title) . ' — ITLAB')
@section('body-class', 'page-certificate-show')

@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    body.page-certificate-show {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 40px 20px;
        font-family: 'Arial', 'Tahoma', sans-serif;
    }

    .certificate-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .certificate-wrapper {
        background: white;
        border-radius: 20px;
        padding: 60px 50px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }

    /* Decorative border */
    .certificate-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 8px solid #667eea;
        border-radius: 20px;
        pointer-events: none;
    }

    /* Decorative background pattern */
    .certificate-wrapper::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .certificate-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
        z-index: 1;
    }

    /* ITLAB Logo */
    .certificate-logo {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
        padding: 15px 25px;
        background: linear-gradient(135deg, #04aa6d 0%, #00c26e 100%);
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(4, 170, 109, 0.3);
    }

    .certificate-logo-square {
        background: white;
        color: #04aa6d;
        padding: 10px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 24px;
        letter-spacing: 0.1em;
    }

    .certificate-logo-text {
        color: white;
        font-weight: 700;
        font-size: 32px;
        letter-spacing: 0.1em;
    }

    .certificate-title {
        font-size: 48px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .certificate-subtitle {
        font-size: 20px;
        color: #666;
        margin-bottom: 0;
        font-style: italic;
    }

    .certificate-body {
        text-align: center;
        margin: 60px 0;
        position: relative;
        z-index: 1;
    }

    .certificate-text {
        font-size: 22px;
        color: #555;
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .certificate-name {
        font-size: 42px;
        font-weight: 700;
        color: #667eea;
        margin: 35px 0;
        padding: 25px 40px;
        border-bottom: 4px solid #667eea;
        border-top: 4px solid #667eea;
        display: inline-block;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border-radius: 10px;
        letter-spacing: 1px;
    }

    .certificate-track {
        font-size: 32px;
        font-weight: 600;
        color: #333;
        margin: 25px 0;
        padding: 15px 30px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-radius: 8px;
        display: inline-block;
    }

    .certificate-footer {
        margin-top: 70px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
        border-top: 2px solid #eee;
        padding-top: 25px;
    }

    .certificate-number {
        font-size: 14px;
        color: #999;
        font-family: 'Courier New', monospace;
        font-weight: 600;
    }

    .certificate-date {
        font-size: 14px;
        color: #999;
        font-weight: 600;
    }

    .certificate-actions {
        text-align: center;
        margin-top: 40px;
        position: relative;
        z-index: 1;
    }

    .btn-action {
        padding: 15px 35px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        margin: 0 10px;
        font-size: 16px;
    }

    .btn-download {
        background: #28a745;
        color: white;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-download:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    }

    .btn-back {
        background: #6c757d;
        color: white;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-back:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
    }

    /* Decorative elements */
    .certificate-decoration {
        position: absolute;
        width: 150px;
        height: 150px;
        opacity: 0.1;
        z-index: 0;
    }

    .decoration-top-left {
        top: -50px;
        left: -50px;
        background: radial-gradient(circle, #667eea 0%, transparent 70%);
        border-radius: 50%;
    }

    .decoration-bottom-right {
        bottom: -50px;
        right: -50px;
        background: radial-gradient(circle, #764ba2 0%, transparent 70%);
        border-radius: 50%;
    }

    @media print {
        body.page-certificate-show {
            background: white;
            padding: 0;
        }

        .certificate-actions {
            display: none;
        }

        .certificate-wrapper {
            box-shadow: none;
            padding: 40px;
        }
    }

    @media (max-width: 768px) {
        .certificate-wrapper {
            padding: 40px 30px;
        }

        .certificate-title {
            font-size: 36px;
        }

        .certificate-name {
            font-size: 32px;
            padding: 20px 25px;
        }

        .certificate-track {
            font-size: 24px;
        }

        .certificate-logo-text {
            font-size: 24px;
        }

        .certificate-logo-square {
            font-size: 20px;
            padding: 8px 12px;
        }
    }
</style>
@endpush

<div class="certificate-container">
    <div class="certificate-wrapper">
        <!-- Decorative elements -->
        <div class="certificate-decoration decoration-top-left"></div>
        <div class="certificate-decoration decoration-bottom-right"></div>

        <div class="certificate-header">
            <!-- ITLAB Logo -->
            <div class="certificate-logo">
                <span class="certificate-logo-square">IT</span>
                <span class="certificate-logo-text">LAB</span>
            </div>
            <h1 class="certificate-title">Certificate of Completion</h1>
            <p class="certificate-subtitle">Certificate of Completion</p>
        </div>

        <div class="certificate-body">
            <p class="certificate-text">
                This is to certify that
            </p>
            <div class="certificate-name">
                {{ $user->name }}
            </div>
            <p class="certificate-text">
                @if(isset($quiz))
                    has successfully passed the quiz
                @else
                    has successfully completed the track
                @endif
            </p>
            <div class="certificate-track">
                @if(isset($quiz))
                    {{ $quiz->title }}
                    @if($quiz->track)
                        <span style="display: block; font-size: 20px; color: #666; margin-top: 10px;">
                            ({{ $quiz->track->title }} Track)
                        </span>
                    @endif
                @else
                    {{ $track->title }}
                @endif
            </div>
            <p class="certificate-text" style="margin-top: 35px; font-size: 18px; color: #777;">
                on {{ $certificate->issued_at->format('F d, Y') }}
            </p>
        </div>

        <div class="certificate-footer">
            <div class="certificate-number">
                Certificate No: {{ $certificate->certificate_number }}
            </div>
            <div class="certificate-date">
                {{ $certificate->issued_at->format('M d, Y') }}
            </div>
        </div>
    </div>

    <div class="certificate-actions">
        @if(isset($quiz))
            <a href="{{ route('quizzes.certificate.download', [$track, $quiz]) }}" class="btn-action btn-download" target="_blank">
                <i class="fas fa-download"></i> Download PDF
            </a>
        @else
            <a href="{{ route('tracks.certificate.download', $track) }}" class="btn-action btn-download" target="_blank">
                <i class="fas fa-download"></i> Download PDF
            </a>
        @endif
        <a href="{{ route('certificates.index') }}" class="btn-action btn-back">
            <i class="fas fa-arrow-left"></i> Back to Certificates
        </a>
    </div>
</div>
@endsection
