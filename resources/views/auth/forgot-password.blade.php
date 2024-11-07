<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>

    <!-- Fonts -->
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

        .form-container {
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 400px;
            text-align: left;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-label {
            font-size: 16px;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .text-input {
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .text-input:focus {
            border-color: #FF6B6B;
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
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
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .primary-button:hover {
            background-color: #e55b5b;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .error-message {
            color: #FF6B6B;
        }

        .logo {
            margin-bottom: 20px; 
            display: block; 
            margin-left: auto; 
            margin-right: auto; 
        }

    </style>
</head>
<body>
    <div class="form-container">
    <a href="http://127.0.0.1:8000/">
            <img src="{{ asset('logo/ideaspark.png') }}" width="200px" alt="Logo" class="logo">
        </a>

        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="input-container">
                <label for="email" class="input-label">{{ __('Email') }}</label>
                <input id="email" class="text-input" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="error-message" />
            </div>

            <div class="button-container">
                <button class="primary-button">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
