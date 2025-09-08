<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ICT Serve') }} - Sistem Perkhidmatan ICT MOTAC</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Meta tags for SEO and social sharing -->
    <meta name="description" content="Sistem Perkhidmatan ICT MOTAC - Platform bersepadu untuk peminjaman peralatan ICT dan pengurusan helpdesk">
    <meta name="keywords" content="MOTAC, ICT, peminjaman, helpdesk, peralatan, teknologi">
    <meta name="author" content="MOTAC ICT Department">

    <!-- Open Graph tags -->
    <meta property="og:title" content="ICT Serve (iServe) - MOTAC">
    <meta property="og:description" content="Sistem Perkhidmatan ICT MOTAC yang mengikuti garis panduan MyGOVEA">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ms_MY">

    <!-- PWA support -->
    <meta name="theme-color" content="#1e40af">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <!-- Skip Links for Accessibility -->
    <style>
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #1e40af;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
            font-size: 14px;
        }
        .skip-link:focus {
            top: 6px;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Skip Links for Accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <a href="#navigation" class="skip-link">Skip to navigation</a>

    <!-- Livewire App Container -->
    @livewire('app')

    <!-- Fallback content for users with JavaScript disabled -->
    <noscript>
        <div style="text-align: center; padding: 50px; font-family: Arial, sans-serif;">
            <h1>ICT Serve (iServe)</h1>
            <p>Sistem Perkhidmatan ICT MOTAC</p>
            <p style="color: #dc2626; margin-top: 20px;">
                <strong>JavaScript is required to use this application.</strong>
            </p>
            <p>Sila aktifkan JavaScript dalam pelayar web anda untuk menggunakan sistem ini.</p>
            <p style="margin-top: 20px;">
                <a href="mailto:ict@motac.gov.my">Hubungi Jabatan ICT</a>
                jika anda memerlukan bantuan.
            </p>
        </div>
    </noscript>

    <!-- Loading indicator -->
    <style>
        .loading-indicator {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            display: none;
        }

        .loading-indicator.show {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f4f6;
            border-top: 4px solid #1e40af;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <div id="loading-indicator" class="loading-indicator">
        <div class="spinner"></div>
    </div>

    <script>
        // Show loading indicator initially
        document.getElementById('loading-indicator').classList.add('show');

        // Hide loading indicator when Livewire app is ready
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loading-indicator').classList.remove('show');
            }, 1000);
        });
    </script>

    @livewireScripts
</body>
</html>
