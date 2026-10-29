<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BHU Agricultural Center') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        <link rel="alternate icon" href="/favicon.ico">
        <meta name="theme-color" content="#10352a">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- ── Global toast notification system ── --}}
        @php
            $toasts = array_filter([
                session('success') ? ['type' => 'success', 'message' => session('success')] : null,
                session('error')   ? ['type' => 'error',   'message' => session('error')]   : null,
                session('warning') ? ['type' => 'warning', 'message' => session('warning')] : null,
                session('info')    ? ['type' => 'info',    'message' => session('info')]     : null,
                session('profile_success') ? ['type' => 'success', 'message' => session('profile_success')] : null,
            ]);
        @endphp

        @if (count($toasts) > 0)
        <div
            id="toast-container"
            aria-live="polite"
            aria-atomic="false"
            style="position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999; display:flex; flex-direction:column; gap:0.75rem; width:22rem; max-width:calc(100vw - 2rem);"
        >
            @foreach ($toasts as $toast)
            @php
                $icons = [
                    'success' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
                    'error'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
                    'warning' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
                    'info'    => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
                ];
                $styles = [
                    'success' => ['bg' => '#f0fdf4', 'border' => '#86efac', 'icon_bg' => '#dcfce7', 'icon_color' => '#16a34a', 'title' => 'Success'],
                    'error'   => ['bg' => '#fff1f2', 'border' => '#fda4af', 'icon_bg' => '#ffe4e6', 'icon_color' => '#dc2626', 'title' => 'Error'],
                    'warning' => ['bg' => '#fffbeb', 'border' => '#fcd34d', 'icon_bg' => '#fef3c7', 'icon_color' => '#d97706', 'title' => 'Warning'],
                    'info'    => ['bg' => '#eff6ff', 'border' => '#93c5fd', 'icon_bg' => '#dbeafe', 'icon_color' => '#2563eb', 'title' => 'Info'],
                ];
                $s = $styles[$toast['type']] ?? $styles['info'];
                $icon = $icons[$toast['type']] ?? $icons['info'];
                $toastId = 'toast-' . uniqid();
            @endphp
            <div
                id="{{ $toastId }}"
                role="alert"
                style="
                    display:flex; align-items:flex-start; gap:0.875rem;
                    background:{{ $s['bg'] }};
                    border:1.5px solid {{ $s['border'] }};
                    border-radius:1rem;
                    padding:1rem 1rem 1rem 1rem;
                    box-shadow:0 8px 24px rgba(0,0,0,0.10);
                    animation: toastIn 0.3s ease;
                    position:relative;
                "
            >
                {{-- Icon --}}
                <span style="flex-shrink:0; width:2.25rem; height:2.25rem; border-radius:50%; background:{{ $s['icon_bg'] }}; color:{{ $s['icon_color'] }}; display:flex; align-items:center; justify-content:center;">
                    {!! $icon !!}
                </span>

                {{-- Content --}}
                <div style="min-width:0; flex:1; padding-top:2px;">
                    <p style="font-size:0.8rem; font-weight:700; color:#111827; margin:0;">{{ $s['title'] }}</p>
                    <p style="font-size:0.82rem; color:#374151; margin:0.2rem 0 0;">{{ $toast['message'] }}</p>
                </div>

                {{-- Close button --}}
                <button
                    onclick="dismissToast('{{ $toastId }}')"
                    style="flex-shrink:0; background:none; border:none; cursor:pointer; color:#9ca3af; padding:2px; border-radius:4px; line-height:1; margin-top:2px;"
                    aria-label="Dismiss notification"
                >
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Progress bar --}}
                <div
                    id="{{ $toastId }}-bar"
                    style="position:absolute; bottom:0; left:0; height:3px; background:{{ $s['icon_color'] }}; border-radius:0 0 0 1rem; width:100%; opacity:0.5; animation: toastBar 5s linear forwards;"
                ></div>
            </div>
            @endforeach
        </div>

        <style>
            @keyframes toastIn {
                from { opacity:0; transform:translateY(12px) scale(0.97); }
                to   { opacity:1; transform:translateY(0)    scale(1); }
            }
            @keyframes toastOut {
                from { opacity:1; transform:translateY(0)    scale(1);    max-height:200px; margin-bottom:0; }
                to   { opacity:0; transform:translateY(12px) scale(0.95); max-height:0;     margin-bottom:-0.75rem; }
            }
            @keyframes toastBar {
                from { width:100%; }
                to   { width:0%; }
            }
        </style>

        <script>
            function dismissToast(id) {
                const el = document.getElementById(id);
                if (!el) return;
                el.style.animation = 'toastOut 0.35s ease forwards';
                setTimeout(() => el.remove(), 350);
            }

            // Auto-dismiss all toasts after 5 seconds
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[id^="toast-"]').forEach(function (el) {
                    if (el.id === 'toast-container') return;
                    setTimeout(function () { dismissToast(el.id); }, 5000);
                });
            });
        </script>
        @endif

    </body>
</html>
