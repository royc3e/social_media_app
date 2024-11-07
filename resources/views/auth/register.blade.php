<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <title>Register</title>
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

        .form-container {
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.7);
            width: 150%;
            max-width: 400px;
            text-align: left;
            display: flex;
            flex-direction: column; 
            align-items: center; 
        }

        .logo {
            margin-bottom: 20px; /* Space between logo and form */
            display: block; /* Make the logo a block element */
        }

        .input-container {
            display: flex;
            flex-direction: column; 
            margin-bottom: 1.5rem;
             
        }

        .input-label {
            font-size: 16px;
            color: #ffffff; /* Label color */
            margin-bottom: 5px;
        }

        .already-registered-link {
            font-size: 0.875rem;
            margin-bottom: 10px;
            color: #87CEEB; 
            text-decoration: underline;
            transition: color 0.3s ease; 
        }

        .already-registered-link:hover {
            color: #FFFFFF; /* Change to white on hover */
        }

        .name-input,
        .email-input,
        .password-input,
        .password-confirmation-input {
            padding: 12px;
            width: 300px;
            border-radius: 5px; 
            border: 1px solid rgba(255, 255, 255, 0.3); 
            background-color: rgba(255, 255, 255, 0.1); 
            color: #ffffff; 
            font-size: 16px; 
            transition: border-color 0.3s ease; 
        }

        .name-input:focus,
        .email-input:focus,
        .password-input:focus,
        .password-confirmation-input:focus {
            border-color: #FF6B6B; /* Change border color on focus */
            outline: none; /* Remove the default outline */
            background-color: rgba(255, 255, 255, 0.2); /* Darker background on focus */
        }

        .error-message {
            color: #FF6B6B; /* Error message color */
            margin-top: 0.5rem;
        }

        .button-container {
            margin-top: 10px; /* Adjust space above the button/link */
            display: flex; /* Align items horizontally */
            flex-direction: column; /* Stack items vertically */
            align-items: left;
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
            margin: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .primary-button:hover {
            background-color: #e55b5b;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
        <div class="form-container">
        <a href="http://127.0.0.1:8000/">
            <img src="{{ asset('logo/ideaspark.png') }}" width="200px" alt="Logo" class="logo">
        </a>
            <h1>{{ __('Create your account') }}</h1>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="input-container">
                    <x-input-label for="name" :value="__('Name')" class="input-label" />
                    <x-text-input id="name" class="name-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 error-message" />
                </div>

                <!-- Email Address -->
                <div class="input-container">
                    <x-input-label for="email" :value="__('Email')" class="input-label" />
                    <x-text-input id="email" class="email-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 error-message" />
                </div>

                <!-- Password -->
                <div class="input-container">
                    <x-input-label for="password" :value="__('Password')" class="input-label" />
                    <x-text-input id="password" class="password-input" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 error-message" />
                </div>

                <!-- Confirm Password -->
                <div class="input-container">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="input-label" />
                    <x-text-input id="password_confirmation" class="password-confirmation-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 error-message" />
                </div>

                <div class="button-container">
                    <a class="already-registered-link" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="primary-button">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>


        </div>
</body>
</html>
