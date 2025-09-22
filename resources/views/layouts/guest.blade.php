<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Coffee Paradise') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☕</text></svg>">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --bakery-primary: #D4A574;
                --bakery-secondary: #F4E4C1;
                --bakery-accent: #E8B4B8;
                --bakery-warm: #F7E7CE;
                --bakery-cream: #FFF8E7;
                --bakery-brown: #7A543E;
                --bakery-pink: #F5D5D0;
            }

            body {
                background: linear-gradient(135deg, 
                    rgba(247, 239, 231, 0.8) 0%, 
                    rgba(230, 201, 168, 0.6) 50%,
                    rgba(255, 248, 231, 0.9) 100%);
                min-height: 100vh;
                font-family: 'Inter', sans-serif;
                padding: 0;
                margin: 0;
                position: relative;
            }

            body::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: url('https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=1920&h=1080&fit=crop') center/cover;
                opacity: 0.05;
                z-index: -1;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Playfair Display', serif;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(212, 165, 116, 0.1);
            }

            ::-webkit-scrollbar-thumb {
                background: var(--bakery-primary);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: var(--bakery-secondary);
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <!-- Back to Home Link -->
        <div class="position-fixed top-0 start-0 m-3" style="z-index: 1050;">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="bi bi-arrow-left me-1"></i>
                Back to Home
            </a>
        </div>

        <main>
            {{ $slot }}
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        @stack('scripts')
    </body>
</html>
