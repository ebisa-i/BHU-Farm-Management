<x-app-layout>
    @php
        $statusColors = [
            'In Progress' => ['bg' => 'bg-[#fef3e2]', 'text' => 'text-[#a16207]'],
            'Scheduled'   => ['bg' => 'bg-[#e0f0ff]', 'text' => 'text-[#1d4ed8]'],
            'Completed'   => ['bg' => 'bg-[#e3f5e8]', 'text' => 'text-[#2d7a46]'],
            'Cancelled'   => ['bg' => 'bg-[#fee2e2]', 'text' => 'text-red-700'],
        ];
    @endphp

    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">

        {{-- Sidebar --}}
        @include('layouts.farm-sidebar', ['active' => 'staff-activities'])

        {{-- Main content --}}
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

                    {{-- Flash messages --}}
                    @if (session('success'))
                        <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Page heading --}}
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / Staff &amp; Activities</p>
                            <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#20392f] sm:text-5xl">Staff &amp; Activities</h1>
                            <p class="mt-2 text-base text-slate-500">Coordinate assignments and daily farm activities.</p>
                        </div>
                        <a href="{{ route('staff-activities.create') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123e31] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add Activity
                        </a>
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
                            <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ $todayCount }}</p>
                            <p class="mt-2 text-sm text-[#3d8555]">Scheduled for today</p>
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
                            <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ $completedCount }}/{{ $totalCount }}</p>
                            <p class="mt-2 text-sm text-[#3d8555]">Farm-wide total</p>
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
                            <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ $upcomingRecord?->shift ?? '—' }}</p>
                            <p class="mt-2 text-sm text-[#3d8555]">{{ $upcomingRecord?->activity ?? 'No upcoming shifts' }}</p>
                        </article>
                    </div>

                    {{-- ── Schedule view toggle ── --}}
                    <div class="flex items-center gap-3 rounded-2xl border border-[#dfe8e1] bg-white px-6 py-4 shadow-sm">
                        <span class="text-sm font-semibold text-[#20392f]">Schedule view</span>
                        <div class="flex items-center rounded-lg bg-[#f0f4f1] p-1" role="group" aria-label="Schedule view options">
                            <button type="button" class="rounded-md bg-[#123e31] px-4 py-1.5 text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1">
                                All
                            </button>
                        </div>
                        <span class="text-sm text-slate-500">{{ $activities->total() }} total records</span>
                    </div>

                    {{-- ── Staff schedule table ── --}}
                    <section class="overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm" aria-labelledby="schedule-title">
                        <div class="px-6 py-5 sm:px-8">
                            <h2 id="schedule-title" class="text-base font-semibold text-[#20392f]">Staff schedule</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $activities->total() }} {{ Str::plural('record', $activities->total()) }}</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-y border-[#e8eee9]">
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Staff member</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Role</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Assignment</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Shift</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Activity</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Date</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Status</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f1]">
                                    @forelse ($activities as $activity)
                                        @php
                                            $color = $statusColors[$activity->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
                                        @endphp
                                        <tr class="hover:bg-[#f8faf8]">
                                            <td class="px-6 py-4 font-medium text-[#20392f]">{{ $activity->staff_name }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $activity->role }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $activity->assignment }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $activity->shift }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $activity->activity }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $activity->activity_date->format('d M Y') }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-full {{ $color['bg'] }} px-3 py-1 text-xs font-semibold {{ $color['text'] }}">
                                                    {{ $activity->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    {{-- Edit --}}
                                                    <a href="{{ route('staff-activities.edit', $activity) }}"
                                                       title="Edit"
                                                       class="text-[#4a7c6a] transition hover:text-[#20392f] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1 rounded">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z"/>
                                                        </svg>
                                                        <span class="sr-only">Edit {{ $activity->staff_name }}</span>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form method="POST" action="{{ route('staff-activities.destroy', $activity) }}"
                                                          onsubmit="return confirm('Delete this activity record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete"
                                                                class="text-red-400 transition hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1 rounded">
                                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                                                            </svg>
                                                            <span class="sr-only">Delete {{ $activity->staff_name }}</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-10 text-center text-sm text-slate-400">
                                                No activities found. <a href="{{ route('staff-activities.create') }}" class="font-semibold text-[#3d8555] hover:underline">Add the first one.</a>
                                            </td>
                                        </tr>
                                    @endforelse
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
                                        {{ $activity->activity_date->format('Y-m-d') }}
                                        &middot; {{ $activity->activity }}
                                        &middot; {{ $activity->assignment }}
                                        &middot; {{ $activity->staff_name }}
                                    </span>
                                    @php $logColor = $statusColors[$activity->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600']; @endphp
                                    <span class="inline-flex items-center rounded-full {{ $logColor['bg'] }} px-3 py-1 text-xs font-semibold {{ $logColor['text'] }}">
                                        {{ $activity->status }}
                                    </span>
                                </div>
                            @empty
                                <div class="flex flex-wrap items-center gap-3 px-6 py-4 sm:px-8">
                                    <span class="text-sm text-slate-400">No activity log entries yet.</span>
                                </div>
                            @endforelse
                        </div>
                    </section>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
