<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(120deg, #0f0c29, #302b63, #24243e);
            color: rgba(255, 255, 255, 0.8);
            margin: 0; 
            height: 100vh;
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }

        .logo {
            margin-bottom: 20px; 
            display: block; 
            margin-left: auto; 
            margin-right: auto; 
        }


        .form-container {
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: left;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .primary-button {
            padding: 12px 24px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #FF6B6B;
            color: #fff;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .primary-button:hover {
            background-color: #e55b5b;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .forgot-password-link {
            font-size: 0.875rem; 
            color: #87CEEB; 
            transition: color 0.3s ease; 
        }

        .forgot-password-link:hover {
            color: #FFFFFF; 
        }


        .input-container {
            display: flex;
            flex-direction: column; /* Stack label and input vertically */
            margin-bottom: 2rem; /* Add space between each input */
        }

        .input-label {
            font-size: 16px;
            color: #ffffff;
            margin-bottom: 5px; /* Spacing below the label */
        }

        .email-input,
        .password-input {
            padding: 12px;
            width: 300px;
            border-radius: 5px; 
            border: 1px solid rgba(255, 255, 255, 0.3); 
            background-color: rgba(255, 255, 255, 0.1); 
            color: #ffffff; 
            font-size: 16px; 
            transition: border-color 0.3s ease; 
        }

        .email-input:focus,
        .password-input:focus {
            border-color: #FF6B6B; /* Change border color on focus */
            outline: none; /* Remove the default outline */
            background-color: rgba(255, 255, 255, 0.2); /* Darker background on focus */
        }

        .error-message {
            color: #FF6B6B; /* Error message color */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <a href="http://127.0.0.1:8000/">
            <img src="{{ asset('logo/ideaspark.png') }}" width="200px" alt="Logo" class="logo">
        </a>
        <h2>{{ __('Log in to your account') }}</h2>
        <form method="POST" action="{{ route('login') }}">
        @csrf

            <!-- Email Address -->
            <div class="input-container">
                <x-input-label for="email" :value="__('Email')" class="input-label" />
                <x-text-input id="email" class="email-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="error-message" />
            </div>

            <!-- Password -->
            <div class="input-container">
                <x-input-label for="password" :value="__('Password')" class="input-label" />
                <x-text-input id="password" class="password-input" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="error-message" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</label>
            </div>

            <div class="flex items-center mt-4">
                @if (Route::has('password.request'))
                    <a class="forgot-password-link" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <div class="ms-3">
                    <x-primary-button class="primary-button">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>


        </form>
    </div>
</body>
</html>
