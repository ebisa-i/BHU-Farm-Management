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
            /* Branding panel */
            .auth-panel-left {
                background: #0d2e22;
                position: relative;
                overflow: hidden;
            }
            .auth-panel-left::before {
                content: '';
                position: absolute;
                top: -6rem; left: -6rem;
                width: 24rem; height: 24rem;
                border-radius: 9999px;
                background: rgba(26,74,50,0.55);
                filter: blur(80px);
                pointer-events: none;
            }
            .auth-panel-left::after {
                content: '';
                position: absolute;
                bottom: -8rem; right: -4rem;
                width: 28rem; height: 28rem;
                border-radius: 9999px;
                background: rgba(22,64,48,0.65);
                filter: blur(80px);
                pointer-events: none;
            }
            .auth-panel-right {
                background: #f4f7f3;
            }
            .auth-stat-card {
                border: 1px solid rgba(255,255,255,0.12);
                background: rgba(255,255,255,0.06);
                border-radius: 1rem;
                padding: 1rem;
            }
            .auth-logo-box {
                width: 3rem; height: 3rem;
                border-radius: 0.75rem;
                border: 1px solid rgba(255,255,255,0.2);
                background: rgba(255,255,255,0.1);
                display: flex; align-items: center; justify-content: center;
                font-size: 0.7rem; font-weight: 800;
                letter-spacing: 0.1em; color: #fff;
            }
            .auth-feature-check {
                width: 1.25rem; height: 1.25rem;
                border-radius: 9999px;
                background: rgba(34,197,94,0.18);
                color: #4ade80;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            /* Form panel */
            .auth-input {
                display: block;
                width: 100%;
                border-radius: 0.75rem;
                border: 1px solid #d3e1d8;
                background: #fff;
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                color: #20392f;
                transition: border-color 0.15s, box-shadow 0.15s;
            }
            .auth-input:focus {
                outline: none;
                border-color: #3d8555;
                box-shadow: 0 0 0 3px rgba(61,133,85,0.15);
            }
            .auth-input::placeholder { color: #9ca3af; }
            .auth-input-error { border-color: #f87171; }
            .auth-btn-primary {
                display: flex;
                width: 100%;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                border-radius: 0.75rem;
                background: #123e31;
                padding: 0.875rem 1.25rem;
                font-size: 0.875rem;
                font-weight: 700;
                color: #fff;
                border: none;
                cursor: pointer;
                transition: background 0.15s;
            }
            .auth-btn-primary:hover { background: #205644; }
            .auth-btn-primary:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(61,133,85,0.4);
            }
            .auth-card {
                background: #fff;
                border: 1px solid #dfe8e1;
                border-radius: 1rem;
                padding: 1.25rem;
            }
            .auth-divider {
                border-top: 1px solid #e0e8e2;
            }
            .auth-link {
                font-weight: 600;
                color: #3d8555;
                text-decoration: none;
                transition: color 0.15s;
            }
            .auth-link:hover { color: #20392f; }
            .auth-label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #20392f;
                margin-bottom: 0.375rem;
            }
            .auth-error {
                margin-top: 0.375rem;
                font-size: 0.75rem;
                color: #dc2626;
            }
            .auth-eyebrow {
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.18em;
                color: #648277;
            }
            .auth-heading {
                margin-top: 0.5rem;
                font-size: 1.875rem;
                font-weight: 800;
                letter-spacing: -0.025em;
                color: #20392f;
            }
            .auth-sub {
                margin-top: 0.5rem;
                font-size: 0.875rem;
                color: #64748b;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div style="min-height:100vh; display:flex; flex-direction:column;" class="lg:flex lg:flex-row">

            {{-- ── Left branding panel (hidden on mobile) ── --}}
            <div class="auth-panel-left hidden lg:flex lg:flex-col lg:justify-between lg:w-5/12 xl:w-2/5" style="padding: 3rem 3.5rem;">

                {{-- Logo --}}
                <div style="position:relative; z-index:10;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div class="auth-logo-box">BHU</div>
                        <div>
                            <p style="font-size:0.9rem; font-weight:700; color:#fff; line-height:1.3;">Bule Hora University</p>
                            <p style="font-size:0.75rem; color:#86efac; margin-top:2px;">Agricultural Center</p>
                        </div>
                    </div>
                </div>

                {{-- Hero --}}
                <div style="position:relative; z-index:10; margin: auto 0;">
                    <p style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.2em; color:#4ade80;">Farm Management System</p>
                    <h1 style="margin-top:1rem; font-size:2.5rem; font-weight:800; line-height:1.15; color:#fff;">
                        Dairy &amp; Beef<br>Farm Management
                    </h1>
                    <p style="margin-top:1rem; max-width:22rem; font-size:0.95rem; line-height:1.75; color:rgba(220,252,231,0.8);">
                        Manage livestock, track milk production, monitor animal health, and review farm performance — all in one place.
                    </p>

                    {{-- Live stats --}}
                    @php
                        $panelStats = [
                            ['value' => \App\Models\Animal::count(), 'label' => 'Animals registered'],
                            ['value' => number_format((float) \App\Models\MilkProduction::whereDate('production_date', today())->sum('quantity_liters'), 1), 'label' => 'Litres today'],
                            ['value' => \App\Models\Sale::count(), 'label' => 'Sales recorded'],
                        ];
                    @endphp
                    <div style="margin-top:2rem; display:grid; grid-template-columns:repeat(3,1fr); gap:0.75rem;">
                        @foreach ($panelStats as $stat)
                            <div class="auth-stat-card">
                                <p style="font-size:1.5rem; font-weight:800; color:#fff;">{{ $stat['value'] }}</p>
                                <p style="margin-top:0.25rem; font-size:0.7rem; color:#86efac;">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Features --}}
                    <ul style="margin-top:1.75rem; list-style:none; padding:0; display:flex; flex-direction:column; gap:0.75rem;">
                        @foreach (['Animal population &amp; health tracking', 'Daily milk production records', 'Breeding &amp; calving management', 'Sales revenue reports'] as $feat)
                            <li style="display:flex; align-items:center; gap:0.75rem; font-size:0.875rem; color:rgba(220,252,231,0.85);">
                                <span class="auth-feature-check">
                                    <svg width="10" height="10" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 6l3 3 5-5"/></svg>
                                </span>
                                {!! $feat !!}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Footer --}}
                <div style="position:relative; z-index:10;">
                    <p style="font-size:0.75rem; color:rgba(134,239,172,0.5);">
                        Bule Hora University Agricultural Center &middot; Interactive academic system
                    </p>
                </div>
            </div>

            {{-- ── Right form panel ── --}}
            <div class="auth-panel-right flex flex-col justify-center flex-1" style="padding: 3rem 2rem;">

                {{-- Mobile logo --}}
                <div class="lg:hidden" style="margin-bottom:2rem; display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:2.5rem;height:2.5rem;border-radius:0.5rem;background:#10352a;border:1px solid #c4dac8;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:800;letter-spacing:0.1em;color:#fff;">BHU</div>
                    <div>
                        <p style="font-size:0.875rem;font-weight:700;color:#20392f;">Bule Hora University</p>
                        <p style="font-size:0.75rem;color:#648277;">Agricultural Center</p>
                    </div>
                </div>

                <div style="max-width:26rem; width:100%; margin:0 auto;">
                    {{ $slot }}
                </div>

                <p class="lg:hidden" style="margin-top:2.5rem; text-align:center; font-size:0.75rem; color:#94a3b8;">
                    Bule Hora University Agricultural Center
                </p>
            </div>

        </div>
    </body>
</html>
