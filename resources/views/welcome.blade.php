<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SocMed</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Style -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #1a1a2e; 
                color: #e0e0e0; 
                margin: 0;
                padding: 0;
                line-height: 1.6;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh; 
                background-image: linear-gradient(120deg, #0f0c29, #302b63, #24243e); 
            }
            
            .header {
                display: flex;
                justify-content: flex-end;
                padding: 20px;
            }
            
            .header img {
                max-width: 200px;
            }
            
            .button {
                padding: 10px 20px;
                margin-left: 10px;
                border-radius: 5px;
                border: none;
                cursor: pointer;
                font-size: 16px;
                font-weight: 600;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                text-decoration: none;
            }

            .login-button, .register-button {
                background-color: #FF6B6B; 
                color: #fff; 
            }

            .login-button:hover, .register-button:hover {
                background-color: #e55b5b;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); 
            }

            .button:focus {
                outline: 2px solid #FF6B6B; 
            }


        </style>

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <img src="{{ asset('logo/ideaspark.png') }}" width="200px">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    
                    @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="button login-button">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="button login-button">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="button register-button">Register</a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>
                </div>
            </div>
        </div>
    </body>
</html>
