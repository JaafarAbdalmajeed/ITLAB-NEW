<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate - {{ $track->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 0;
            size: A4 landscape;
        }

        body {
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', sans-serif;
            background: white;
            padding: 0;
            margin: 0;
        }

        .certificate-wrapper {
            width: 100%;
            min-height: 100vh;
            background: white;
            border: 15px solid #667eea;
            padding: 50px 40px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Decorative border */
        .certificate-wrapper::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 5px solid #04aa6d;
            pointer-events: none;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        /* ITLAB Logo */
        .certificate-logo {
            display: inline-block;
            margin-bottom: 25px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #04aa6d 0%, #00c26e 100%);
            border-radius: 10px;
        }

        .certificate-logo-content {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .certificate-logo-square {
            background: white;
            color: #04aa6d;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 0.1em;
        }

        .certificate-logo-text {
            color: white;
            font-weight: 700;
            font-size: 28px;
            letter-spacing: 0.1em;
        }

        .certificate-title {
            font-size: 42px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .certificate-subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 0;
            font-style: italic;
        }

        .certificate-body {
            text-align: center;
            margin: 40px 0;
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .certificate-text {
            font-size: 20px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .certificate-name {
            font-size: 38px;
            font-weight: 700;
            color: #667eea;
            margin: 30px 0;
            padding: 20px 35px;
            border-bottom: 4px solid #667eea;
            border-top: 4px solid #667eea;
            display: inline-block;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
            letter-spacing: 1px;
        }

        .certificate-track {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin: 20px 0;
            padding: 12px 25px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 6px;
            display: inline-block;
        }

        .certificate-footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
            border-top: 2px solid #eee;
            padding-top: 20px;
        }

        .certificate-number {
            font-size: 12px;
            color: #999;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .certificate-date {
            font-size: 12px;
            color: #999;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="certificate-header">
            <!-- ITLAB Logo -->
            <div class="certificate-logo">
                <div class="certificate-logo-content">
                    <span class="certificate-logo-square">IT</span>
                    <span class="certificate-logo-text">LAB</span>
                </div>
            </div>
            <h1 class="certificate-title">Certificate of Completion</h1>
            <p class="certificate-subtitle">شهادة إتمام</p>
        </div>

        <div class="certificate-body">
            <p class="certificate-text">
                This is to certify that
            </p>
            <div class="certificate-name">
                {{ $user->name }}
            </div>
            <p class="certificate-text">
                has successfully completed the track
            </p>
            <div class="certificate-track">
                {{ $track->title }}
            </div>
            <p class="certificate-text" style="margin-top: 30px; font-size: 16px; color: #777;">
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
</body>
</html>
