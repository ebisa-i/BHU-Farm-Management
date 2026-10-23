<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'DairyBeefFarm') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { background: #f0f3ee; }

            .auth-input {
                display: block;
                width: 100%;
                box-sizing: border-box;
                border-radius: 0.75rem;
                border: 1.5px solid #d6e4d8;
                background: #fff;
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
                color: #1a3328;
                font-family: inherit;
                transition: border-color 0.15s, box-shadow 0.15s;
                outline: none;
            }
            .auth-input:focus {
                border-color: #3d8555;
                box-shadow: 0 0 0 3px rgba(61,133,85,0.15);
            }
            .auth-input::placeholder { color: #b0bdb8; }
            .auth-input-error { border-color: #f87171 !important; }

            .auth-btn {
                display: flex;
                width: 100%;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                border-radius: 0.85rem;
                background: #0f3d2e;
                padding: 0.9rem 1.25rem;
                font-size: 0.9rem;
                font-weight: 700;
                color: #fff;
                border: none;
                cursor: pointer;
                font-family: inherit;
                transition: background 0.15s;
                letter-spacing: 0.01em;
            }
            .auth-btn:hover { background: #1a5540; }
            .auth-btn:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(61,133,85,0.35);
            }

            .auth-eyebrow {
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.18em;
                color: #5a7a68;
            }
            .auth-heading {
                margin-top: 0.4rem;
                font-size: 1.85rem;
                font-weight: 800;
                letter-spacing: -0.02em;
                color: #142e22;
                line-height: 1.15;
            }
            .auth-sub {
                margin-top: 0.45rem;
                font-size: 0.875rem;
                color: #6b7f76;
            }
            .auth-link {
                font-weight: 600;
                color: #3d8555;
                text-decoration: none;
            }
            .auth-link:hover { color: #142e22; }

            .auth-label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #1a3328;
                margin-bottom: 0.4rem;
            }
            .auth-error {
                margin-top: 0.35rem;
                font-size: 0.75rem;
                color: #dc2626;
            }
            .auth-status {
                border-radius: 0.65rem;
                border: 1px solid #bbf7d0;
                background: #f0fdf4;
                padding: 0.7rem 1rem;
                font-size: 0.875rem;
                color: #166534;
                margin-bottom: 1.25rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding: 1.5rem;">
        <div style="width:100%; max-width:27rem;">
            {{ $slot }}
        </div>
    </body>
</html>
