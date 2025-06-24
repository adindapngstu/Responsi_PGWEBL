<x-guest-layout>
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(to bottom, #fff0e5, #fffaf7);
                font-family: 'Fredoka', sans-serif;
                color: #3B2F2F;
            }

            .auth-card {
                background-color: #fff8ef;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
                padding: 40px;
                margin: 60px auto;
                max-width: 450px;
                animation: fadeInUp 0.6s ease-out both;
            }

            .auth-card h1 {
                text-align: center;
                color: #A26769;
                font-weight: 700;
                margin-bottom: 24px;
                font-size: 1.8rem;
            }

            label {
                color: #5E3D2B;
                font-weight: 600;
            }

            input[type="email"], input[type="password"] {
                background-color: #fff;
                border: 1px solid #e3c1ba;
                color: #3B2F2F;
                border-radius: 12px;
                padding: 10px;
            }

            input::placeholder {
                color: #bfa6a1;
            }

            .btn-login {
                background-color: #A26769;
                color: white;
                border: none;
                font-weight: 600;
                border-radius: 12px;
                padding: 10px 20px;
                transition: 0.3s ease;
            }

            .btn-login:hover {
                background-color: #8C5B5C;
            }

            .text-muted {
                font-size: 0.9rem;
                color: #a58e86;
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
    @endpush

    <div class="auth-card">
        <h1>Masuk ke Akun</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password"
                    name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label text-muted" for="remember_me">{{ __('Remember me') }}</label>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                @if (Route::has('password.request'))
                    <a class="text-muted" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="btn-login">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
