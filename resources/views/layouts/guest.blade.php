<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sare Kene') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Style Stack -->
    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(to bottom, #fff0e5, #fffaf7);
            font-family: 'Fredoka', sans-serif;
            color: #3B2F2F;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .auth-card {
            background-color: #fff8ef;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.6s ease-out both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                <a href="/">
                    <img src="{{ asset('build/assets/icon/logo_web2.png') }}" alt="Logo" style="height: 60px;">
                </a>
            </div>


            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
</body>

</html>
