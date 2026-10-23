<x-app-layout>
    @php
        $maximumChartValue = max(collect($chart)->pluck('value')->map(fn ($value) => (float) $value)->push(1)->all());
        $exportUrl = route('reports.export', ['report' => $selectedReport, 'period' => $selectedPeriod]);
    @endphp

    <style>
        @media print {
            @page {
                size: landscape;
                margin: 12mm;
            }

            body {
                background: #fff !important;
            }

            .report-no-print {
                display: none !important;
            }

            .report-print-surface {
                box-shadow: none !important;
            }
        }
    </style>

    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">

        {{-- ── Sidebar ── --}}
        <aside class="hidden w-64 shrink-0 flex-col bg-[#10352a] text-white lg:flex">
            <div class="border-b border-white/10 px-6 py-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full border border-white/40 text-xs font-bold tracking-wide">
                        BHU
                    </div>
                    <div>
                        <p class="text-sm font-bold leading-5">Bule Hora University</p>
                        <p class="mt-1 text-xs text-green-200">Agricultural Center</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5 text-sm">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1" /><rect x="14" y="3" width="7" height="7" rx="1" /><rect x="3" y="14" width="7" height="7" rx="1" /><rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>

                {{-- Animal Management --}}
                <a href="{{ route('animals.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="7" cy="7" r="2" /><circle cx="15" cy="5" r="2" /><circle cx="19" cy="10" r="1.7" /><path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z" /><path d="M16 15c.6-.6 1.4-1 2.3-1 1.5 0 2.7.9 2.7 2.2 0 .7-.6 1.3-1.3 1.3H17" />
                    </svg>
                    Animal Management
                </a>

                {{-- Milk Production --}}
                <a href="{{ route('milk-productions.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 3h6M10 3v4l-2 2v11h8V9l-2-2V3" /><path d="M8 10h8M10 14h4" />
                    </svg>
                    Milk Production
                </a>

                {{-- Sales Management --}}
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 3h14v18l-2-1.5L15 21l-3-1.5L9 21l-2-1.5L5 21V3Z" /><path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3 .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5" />
                    </svg>
                    Sales Management
                </a>

                {{-- Breeding --}}
                <a href="{{ route('breedings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" />
                    </svg>
                    Breeding
                </a>

                {{-- Animal Health --}}
                <a href="{{ route('animal-health.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" /><path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2" />
                    </svg>
                    Animal Health
                </a>

                {{-- Inventory --}}
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="M3 8v9l9 5 9-5V8M12 13v9M7.5 5.5l9 5" />
                    </svg>
                    Inventory
                </a>

                {{-- Reports — active --}}
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 rounded-lg border-l-4 border-amber-300 bg-[#285b43] px-3 py-3 font-semibold text-white" aria-current="page">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3v18h18" /><path d="m7 14 4-4 3 3 6-7" /><path d="M16 6h4v4" />
                    </svg>
                    Reports
                </a>

                <p class="px-3 pb-2 pt-5 text-xs font-bold uppercase tracking-widest text-green-300">Administration</p>

                {{-- User Management --}}
                <a href="{{ route('user-management.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="10" cy="7" r="4" /><path d="M20 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8" />
                    </svg>
                    User Management
                </a>

                {{-- Staff & Activities --}}
                <a href="{{ route('staff-activities.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="5" y="4" width="14" height="17" rx="2" /><path d="M9 4.5V3h6v1.5M9 10h6M9 14h6M9 18h3" />
                    </svg>
                    Staff &amp; Activities
                </a>

                {{-- Settings --}}
                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" /><path d="m19.4 15 .1.1a1.8 1.8 0 0 1-2.5 2.5l-.1-.1a1.8 1.8 0 0 0-3 .9v.2a1.8 1.8 0 0 1-3.6 0v-.2a1.8 1.8 0 0 0-3-.9l-.1.1a1.8 1.8 0 1 1-2.5-2.5l.1-.1a1.8 1.8 0 0 0-.9-3h-.2a1.8 1.8 0 0 1 0-3.6h.2a1.8 1.8 0 0 0 .9-3l-.1-.1a1.8 1.8 0 1 1 2.5-2.5l.1.1a1.8 1.8 0 0 0 3-.9v-.2a1.8 1.8 0 0 1 3.6 0v.2a1.8 1.8 0 0 0 3 .9l.1-.1a1.8 1.8 0 1 1 2.5 2.5l-.1.1a1.8 1.8 0 0 0 .9 3h.2a1.8 1.8 0 0 1 0 3.6h-.2a1.8 1.8 0 0 0-.9 3Z" />
                    </svg>
                    Settings
                </a>
            </nav>

            <div class="border-t border-white/15 px-6 py-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-green-200">Farm Management</p>
                <p class="mt-2 text-xs text-green-100/70">Dairy &amp; Beef Farm System</p>
            </div>
        </aside>

        {{-- ── Main content ── --}}
        <div class="min-w-0 flex-1">

            {{-- Top header bar --}}
            <header class="report-no-print flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>

                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ now()->format('l, d F Y') }}</span>

                    {{-- Notification bell --}}
                    <button type="button" class="relative flex h-9 w-9 items-center justify-center rounded-full text-gray-500 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2" aria-label="Notifications">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" /><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                        </svg>
                    </button>

                    {{-- User dropdown --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 rounded-lg px-2 py-1 text-left transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e2eddd] font-bold text-[#32634d]">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </span>
                                <span class="hidden sm:block">
                                    <span class="block text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Farm User' }}</span>
                                    <span class="block text-xs text-gray-500">{{ auth()->user()->role ?? 'Team Leader' }}</span>
                                </span>
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            {{-- Page body --}}
            <main class="min-h-screen bg-[#f4f7f3] px-5 py-8 text-[#173d31] sm:px-8">
                <div class="mx-auto max-w-6xl">

                    {{-- Page heading --}}
                    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / Reports</p>
                            <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#20392f] sm:text-5xl">Reports</h1>
                            <p class="mt-2 text-base text-slate-500">Explore and export a snapshot of farm performance.</p>
                        </div>

                        <button type="button" onclick="window.print()" class="report-no-print inline-flex items-center justify-center gap-2 rounded-xl border border-[#d3e1d8] bg-white px-5 py-3 text-sm font-semibold text-[#173d31] shadow-sm transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3c8055] focus:ring-offset-2">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M6 9V3h12v6M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                <path d="M6 14h12v7H6zM18 12h.01" />
                            </svg>
                            Print preview
                        </button>
                    </div>

                    {{-- Report selector + date range --}}
                    <form method="GET" action="{{ route('reports.index') }}" class="report-no-print">
                        <fieldset>
                            <legend class="sr-only">Choose a report to preview</legend>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                @foreach ($reports as $reportKey => $label)
                                    <label class="group cursor-pointer">
                                        <input class="peer sr-only" type="radio" name="report" value="{{ $reportKey }}" @checked($selectedReport === $reportKey)>
                                        <span class="flex min-h-[136px] flex-col justify-center rounded-2xl border border-[#dfe8e1] bg-white px-5 py-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#a8c5b1] peer-checked:border-2 peer-checked:border-[#3d8555] peer-focus-visible:ring-2 peer-focus-visible:ring-[#3d8555] peer-focus-visible:ring-offset-2">
                                            <svg class="mb-3 h-6 w-6 text-[#4b9461]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M6 3h8l5 5v13H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                                                <path d="M14 3v6h5M8 17v-3M12 17v-6M16 17v-2" />
                                            </svg>
                                            <span class="font-semibold text-[#162c24]">{{ $label }}</span>
                                            <span class="mt-1 text-sm text-slate-500">Preview report <span aria-hidden="true">→</span></span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>

                        <div class="mt-6 flex flex-col gap-4 rounded-2xl border border-[#dfe8e1] bg-white p-5 shadow-sm sm:flex-row sm:items-end sm:px-7 sm:py-6">
                            <div class="w-full sm:w-40">
                                <label for="period" class="mb-2 block text-sm font-semibold text-[#263a31]">Date range</label>
                                <select id="period" name="period" class="block w-full rounded-xl border-[#d3e1d8] bg-white px-4 py-3 text-base text-[#20392f] shadow-sm focus:border-[#3d8555] focus:ring-[#3d8555]">
                                    @foreach ($periods as $periodKey => $label)
                                        <option value="{{ $periodKey }}" @selected($selectedPeriod === $periodKey)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="inline-flex min-h-[50px] items-center justify-center gap-2 rounded-xl bg-[#123e31] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 7v5h-5M4 17v-5h5" />
                                    <path d="M5.6 9A7 7 0 0 1 18 6l2 6M4 12l2 6a7 7 0 0 0 12.4-3" />
                                </svg>
                                Generate preview
                            </button>
                        </div>
                    </form>

                    {{-- Report preview card --}}
                    <section class="report-print-surface mt-8 overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm" aria-labelledby="report-preview-title">
                        <div class="border-b border-[#e6ece7] px-6 py-6 sm:px-8">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#648277]">Report Preview · {{ $periodLabel }}</p>
                            <h2 id="report-preview-title" class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">{{ $reportTitle }} Report</h2>
                            <p class="mt-2 text-sm text-slate-500">Bule Hora University Agricultural Center · Live farm records · Generated {{ now()->format('M j, Y') }}</p>
                        </div>

                        <div class="px-6 py-6 sm:px-8">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                @foreach ($metrics as $metric)
                                    <article class="rounded-2xl border border-[#e0e9e2] bg-white p-6 shadow-sm">
                                        <div class="flex items-start justify-between gap-3">
                                            <p class="pt-1 text-sm font-semibold text-[#62766d]">{{ $metric['label'] }}</p>
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#edf5ed] text-[#356b48]" aria-hidden="true">
                                                @if ($selectedReport === 'milk-production' && $loop->first)
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M9 3h6M10 3v4l-2 2v11h8V9l-2-2V3" /><path d="M8 10h8M10 14h4" />
                                                    </svg>
                                                @elseif ($selectedReport === 'milk-production' && $loop->iteration === 2)
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 3c-2 3-6 6.2-6 10a6 6 0 0 0 12 0c0-3.8-4-7-6-10Z" /><path d="M9 14a3 3 0 0 0 3 3" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                        <rect x="3" y="5" width="18" height="14" rx="2" /><path d="M3 10h18M7 15h3" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ $metric['value'] }}</p>
                                        <p class="mt-2 text-sm text-slate-500">{{ $metric['detail'] }}</p>
                                    </article>
                                @endforeach
                            </div>

                            <div class="mt-10" role="img" aria-label="{{ $reportTitle }} chart">
                                @if (count($chart) > 0)
                                    <div class="relative h-64 border-b border-[#dfe7e1] pl-14 sm:h-72">
                                        <div class="absolute inset-x-14 top-0 flex h-full flex-col justify-between pb-0" aria-hidden="true">
                                            @foreach ([100, 75, 50, 25, 0] as $gridline)
                                                <div class="relative border-t border-[#edf1ed]">
                                                    <span class="absolute -left-14 -top-2.5 w-11 text-right text-xs text-slate-500">{{ number_format($maximumChartValue * $gridline / 100, 0) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="absolute inset-x-14 bottom-0 top-0 flex items-end justify-around gap-4">
                                            @foreach ($chart as $row)
                                                <div class="flex h-full min-w-0 flex-1 flex-col items-center justify-end">
                                                    <span class="mb-2 text-xs font-medium text-slate-500">{{ number_format((float) $row['value'], 2) }}</span>
                                                    <div class="w-full max-w-32 rounded-t-md bg-[#2f704d] transition-all" style="height: {{ max(1, (float) $row['value'] / $maximumChartValue * 100) }}%"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="ml-14 mt-3 flex justify-around gap-4">
                                        @foreach ($chart as $row)
                                            <span class="min-w-0 flex-1 truncate text-center text-xs text-slate-500">{{ $row['label'] }}</span>
                                        @endforeach
                                    </div>
                                    <div class="mt-5 flex items-center justify-center gap-2 text-sm text-slate-500">
                                        <span class="h-3 w-8 rounded-sm bg-[#2f704d]" aria-hidden="true"></span>
                                        {{ $reportTitle }}
                                    </div>
                                @else
                                    <p class="rounded-2xl bg-[#f8faf8] px-6 py-14 text-center text-sm text-slate-500">No records are available for this report yet.</p>
                                @endif
                            </div>
                        </div>

                        <footer class="report-no-print flex flex-col gap-3 border-t border-[#e6ece7] px-6 py-5 sm:flex-row sm:px-8">
                            <button type="button" onclick="window.print()" class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#d3e1d8] bg-white px-5 py-3 text-sm font-semibold text-[#173d31] transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M6 9V3h12v6M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                    <path d="M6 14h12v7H6zM18 12h.01" />
                                </svg>
                                Print
                            </button>
                            <button type="button" onclick="window.print()" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123e31] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 3v12m0 0 4-4m-4 4-4-4" /><path d="M5 17v3h14v-3" />
                                </svg>
                                Export PDF
                            </button>
                            <a href="{{ $exportUrl }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#d3e1d8] bg-white px-5 py-3 text-sm font-semibold text-[#173d31] transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="2" /><path d="M3 9h18M3 15h18M9 3v18M15 3v18" />
                                </svg>
                                Export Excel (CSV)
                            </a>
                        </footer>
                    </section>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
