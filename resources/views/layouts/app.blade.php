<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ITLAB')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.svg') }}?v=2">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
    <style>
        :root {
            --primary-color: #04aa6d;
        }
        
        /* Theme Styles */
        body.theme-dark {
            background-color: #1a1a1a;
            color: #e0e0e0;
        }
        body.theme-dark .preference-section,
        body.theme-dark .admin-card {
            background: #2a2a2a !important;
            color: #e0e0e0;
        }
        
        /* Font Size Styles */
        body.font-small {
            font-size: 14px;
        }
        body.font-medium {
            font-size: 16px;
        }
        body.font-large {
            font-size: 18px;
        }
        body.font-xlarge {
            font-size: 20px;
        }
        
        /* Layout Styles */
        body.layout-compact .container {
            max-width: 1000px;
        }
        body.layout-compact .page-wrapper {
            padding: 20px;
        }
        body.layout-wide .container {
            max-width: 1400px;
        }
        
        /* Apply primary color */
        .btn-primary,
        a.btn-primary,
        button.btn-primary {
            background-color: var(--primary-color) !important;
        }
        a:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body class="@yield('body-class')">

    @include('partials.navbar')
    @include('partials.auth-modal')

    @if(session('status'))
        <div class="container">
            <div class="alert alert-success">{{ session('status') }}</div>
        </div>
    @endif

    @yield('content')

    @include('partials.footer')

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // Load and apply user preferences
        (function() {
            @auth
                const preferences = @json(auth()->user()->getPreferences());
            @else
                const sessionPrefs = @json(session('preferences', []));
                const defaults = {
                    theme: 'light',
                    primary_color: '#04aa6d',
                    font_size: 'medium',
                    language: 'en',
                    layout: 'default',
                };
                const preferences = Object.assign({}, defaults, sessionPrefs);
            @endauth

            // Apply theme
            if (preferences.theme) {
                document.body.classList.add('theme-' + preferences.theme);
            }

            // Apply primary color
            if (preferences.primary_color) {
                document.documentElement.style.setProperty('--primary-color', preferences.primary_color);
            }

            // Apply font size
            if (preferences.font_size) {
                document.body.classList.add('font-' + preferences.font_size);
            }

            // Apply language
            if (preferences.language) {
                document.documentElement.setAttribute('lang', preferences.language);
                document.documentElement.setAttribute('dir', preferences.language === 'ar' ? 'rtl' : 'ltr');
            }

            // Apply layout
            if (preferences.layout) {
                document.body.classList.add('layout-' + preferences.layout);
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
