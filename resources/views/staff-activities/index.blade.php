<x-app-layout>
    @php
        // Demo schedule data — matches the image
        $scheduleRows = [
            [
                'member'     => 'Dairy unit worker',
                'role'       => 'Vocational Worker',
                'assignment' => 'Dairy A',
                'shift'      => '06:00–14:00',
                'activity'   => 'Morning milking',
                'status'     => 'In progress',
            ],
            [
                'member'     => 'Farm technician',
                'role'       => 'Technician',
                'assignment' => 'Breeding unit',
                'shift'      => '08:00–16:00',
                'activity'   => 'Pregnancy checks',
                'status'     => 'Scheduled',
            ],
            [
                'member'     => 'Center veterinarian',
                'role'       => 'Veterinarian',
                'assignment' => 'Health bay',
                'shift'      => '09:00–17:00',
                'activity'   => 'Health follow-ups',
                'status'     => 'Scheduled',
            ],
        ];

        $statusColors = [
            'In progress' => ['bg' => 'bg-[#fef3e2]', 'text' => 'text-[#a16207]'],
            'Scheduled'   => ['bg' => 'bg-[#fef3e2]', 'text' => 'text-[#a16207]'],
            'Completed'   => ['bg' => 'bg-[#e3f5e8]', 'text' => 'text-[#2d7a46]'],
            'Cancelled'   => ['bg' => 'bg-[#fee2e2]', 'text' => 'text-red-700'],
        ];

        $todayOnSchedule   = count($scheduleRows);
        $tasksCompleted    = 8;
        $tasksTotal        = 12;
        $upcomingShift     = '14:00';
        $upcomingShiftName = 'Dairy unit handover';
    @endphp

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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('animals.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="7" cy="7" r="2"/><circle cx="15" cy="5" r="2"/><circle cx="19" cy="10" r="1.7"/><path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z"/><path d="M16 15c.6-.6 1.4-1 2.3-1 1.5 0 2.7.9 2.7 2.2 0 .7-.6 1.3-1.3 1.3H17"/>
                    </svg>
                    Animal Management
                </a>

                <a href="{{ route('milk-productions.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 3h6M10 3v4l-2 2v11h8V9l-2-2V3"/><path d="M8 10h8M10 14h4"/>
                    </svg>
                    Milk Production
                </a>

                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 3h14v18l-2-1.5L15 21l-3-1.5L9 21l-2-1.5L5 21V3Z"/><path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3 .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5"/>
                    </svg>
                    Sales Management
                </a>

                <a href="{{ route('breedings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z"/>
                    </svg>
                    Breeding
                </a>

                <a href="{{ route('animal-health.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z"/><path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2"/>
                    </svg>
                    Animal Health
                </a>

                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="M3 8v9l9 5 9-5V8M12 13v9M7.5 5.5l9 5"/>
                    </svg>
                    Inventory
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 6-7"/><path d="M16 6h4v4"/>
                    </svg>
                    Reports
                </a>

                <p class="px-3 pb-2 pt-5 text-xs font-bold uppercase tracking-widest text-green-300">Administration</p>

                <a href="{{ route('user-management.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>
                    </svg>
                    User Management
                </a>

                {{-- Staff & Activities — active --}}
                <a href="{{ route('staff-activities.index') }}" class="flex items-center gap-3 rounded-lg border-l-4 border-amber-300 bg-[#285b43] px-3 py-3 font-semibold text-white" aria-current="page">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5V3h6v1.5M9 10h6M9 14h6M9 18h3"/>
                    </svg>
                    Staff &amp; Activities
                </a>

                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z"/><path d="m19.4 15 .1.1a1.8 1.8 0 0 1-2.5 2.5l-.1-.1a1.8 1.8 0 0 0-3 .9v.2a1.8 1.8 0 0 1-3.6 0v-.2a1.8 1.8 0 0 0-3-.9l-.1.1a1.8 1.8 0 1 1-2.5-2.5l.1-.1a1.8 1.8 0 0 0-.9-3h-.2a1.8 1.8 0 0 1 0-3.6h.2a1.8 1.8 0 0 0 .9-3l-.1-.1a1.8 1.8 0 1 1 2.5-2.5l.1.1a1.8 1.8 0 0 0 3-.9v-.2a1.8 1.8 0 0 1 3.6 0v.2a1.8 1.8 0 0 0 3 .9l.1-.1a1.8 1.8 0 1 1 2.5 2.5l-.1.1a1.8 1.8 0 0 0 .9 3h.2a1.8 1.8 0 0 1 0 3.6h-.2a1.8 1.8 0 0 0-.9 3Z"/>
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
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ now()->format('l, d F Y') }}</span>
                    <button type="button" aria-label="Notifications" class="relative flex h-9 w-9 items-center justify-center rounded-full text-gray-500 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                        </svg>
                    </button>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/>
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
                <div class="mx-auto max-w-6xl space-y-6">

                    {{-- Page heading --}}
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / Staff &amp; Activities</p>
                            <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#20392f] sm:text-5xl">Staff &amp; Activities</h1>
                            <p class="mt-2 text-base text-slate-500">Coordinate assignments and daily farm activities.</p>
                        </div>
                        <button type="button" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123e31] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add Activity
                        </button>
                    </div>

                    {{-- ── Stat cards ── --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        {{-- On today's schedule --}}
                        <article class="flex flex-col justify-between rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-sm font-semibold text-[#62766d]">On today's schedule</p>
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#edf5ed] text-[#356b48]" aria-hidden="true">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ $todayOnSchedule }}</p>
                            <p class="mt-2 text-sm text-[#3d8555]">Sample assignments</p>
                        </article>

                        {{-- Tasks completed --}}
                        <article class="flex flex-col justify-between rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-sm font-semibold text-[#62766d]">Tasks completed</p>
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#edf5ed] text-[#356b48]" aria-hidden="true">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ $tasksCompleted }}/{{ $tasksTotal }}</p>
                            <p class="mt-2 text-sm text-[#3d8555]">Farm-wide example</p>
                        </article>

                        {{-- Upcoming shift --}}
                        <article class="flex flex-col justify-between rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-sm font-semibold text-[#62766d]">Upcoming shift</p>
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#edf5ed] text-[#356b48]" aria-hidden="true">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ $upcomingShift }}</p>
                            <p class="mt-2 text-sm text-[#3d8555]">{{ $upcomingShiftName }}</p>
                        </article>
                    </div>

                    {{-- ── Schedule view toggle ── --}}
                    <div class="flex items-center gap-3 rounded-2xl border border-[#dfe8e1] bg-white px-6 py-4 shadow-sm">
                        <span class="text-sm font-semibold text-[#20392f]">Schedule view</span>
                        <div class="flex items-center rounded-lg bg-[#f0f4f1] p-1" role="group" aria-label="Schedule view options">
                            <button type="button" class="rounded-md bg-[#123e31] px-4 py-1.5 text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1">
                                Day
                            </button>
                            <button type="button" class="rounded-md px-4 py-1.5 text-sm font-medium text-[#4a7c6a] transition hover:bg-white/60 focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1">
                                Week
                            </button>
                        </div>
                        <span class="text-sm text-slate-500">{{ now()->format('l') }}'s assignments</span>
                    </div>

                    {{-- ── Today's staff schedule card ── --}}
                    <section class="overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm" aria-labelledby="schedule-title">
                        <div class="px-6 py-5 sm:px-8">
                            <h2 id="schedule-title" class="text-base font-semibold text-[#20392f]">Today's staff schedule</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $todayOnSchedule }} matching sample records &middot; click a heading to sort</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-y border-[#e8eee9]">
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Staff member</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Role</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Assignment</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Shift</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Today's activity</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Status</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f1]">
                                    @foreach ($scheduleRows as $row)
                                        @php
                                            $color = $statusColors[$row['status']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
                                            $isFirst = $loop->first;
                                        @endphp
                                        <tr class="hover:bg-[#f8faf8]">
                                            <td class="px-6 py-4 font-medium {{ $isFirst ? 'text-[#20392f]' : 'text-[#3d8555]' }}">
                                                {{ $row['member'] }}
                                            </td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $row['role'] }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $row['assignment'] }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $row['shift'] }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $row['activity'] }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-full {{ $color['bg'] }} px-3 py-1 text-xs font-semibold {{ $color['text'] }}">
                                                    {{ $row['status'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <button type="button" title="View" class="text-[#4a7c6a] transition hover:text-[#20392f] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1 rounded">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                                                        </svg>
                                                        <span class="sr-only">View {{ $row['member'] }}</span>
                                                    </button>
                                                    <button type="button" title="Edit" class="text-[#4a7c6a] transition hover:text-[#20392f] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1 rounded">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z"/>
                                                        </svg>
                                                        <span class="sr-only">Edit {{ $row['member'] }}</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination footer --}}
                        <div class="flex flex-col items-center justify-between gap-4 border-t border-[#e8eee9] px-6 py-5 sm:flex-row sm:px-8">
                            <p class="text-sm text-slate-500">
                                Page {{ $activities->currentPage() }} of {{ $activities->lastPage() ?: 1 }}
                            </p>
                            <div class="flex items-center gap-2">
                                @if ($activities->onFirstPage())
                                    <span class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-gray-400 cursor-not-allowed select-none">Previous</span>
                                @else
                                    <a href="{{ $activities->previousPageUrl() }}" class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#173d31] shadow-sm transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">Previous</a>
                                @endif
                                @if ($activities->hasMorePages())
                                    <a href="{{ $activities->nextPageUrl() }}" class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#173d31] shadow-sm transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">Next</a>
                                @else
                                    <span class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-gray-400 cursor-not-allowed select-none">Next</span>
                                @endif
                            </div>
                        </div>
                    </section>

                    {{-- ── Activity log card ── --}}
                    <section class="overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm" aria-labelledby="activity-log-title">
                        <div class="px-6 py-5 sm:px-8">
                            <h2 id="activity-log-title" class="text-base font-semibold text-[#20392f]">Activity log</h2>
                        </div>

                        <div class="divide-y divide-[#f0f4f1]">
                            @forelse ($activities as $activity)
                                <div class="flex flex-wrap items-center gap-3 px-6 py-4 sm:px-8">
                                    <span class="text-sm text-[#20392f]">
                                        {{ $activity->created_at?->format('Y-m-d') ?? now()->format('Y-m-d') }}
                                        &middot; Activity record #{{ $activity->id }}
                                    </span>
                                    <span class="inline-flex items-center rounded-full bg-[#e3f5e8] px-3 py-1 text-xs font-semibold text-[#2d7a46]">Completed</span>
                                </div>
                            @empty
                                {{-- Show a demo entry so the card is never empty --}}
                                <div class="flex flex-wrap items-center gap-3 px-6 py-4 sm:px-8">
                                    <span class="text-sm text-[#20392f]">
                                        {{ now()->format('Y-m-d') }} &middot; Feeding &middot; Dairy A &middot; Dairy unit worker
                                    </span>
                                    <span class="inline-flex items-center rounded-full bg-[#e3f5e8] px-3 py-1 text-xs font-semibold text-[#2d7a46]">Completed</span>
                                </div>
                            @endforelse
                        </div>
                    </section>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
