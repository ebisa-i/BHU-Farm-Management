<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'animal-health'])

        <main class="min-w-0 flex-1">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>

                <div class="flex w-full flex-wrap items-center gap-4 sm:w-auto">
                    <span class="hidden whitespace-nowrap text-sm text-gray-600 md:inline">{{ now()->format('l, d F Y') }}</span>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 rounded-full px-2 py-1 text-left transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e2eddd] font-bold text-[#32634d]">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </span>
                                <span class="hidden text-sm font-semibold text-gray-800 sm:inline">{{ auth()->user()->name ?? 'Farm User' }}</span>
                                <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
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

            <div class="space-y-8 p-5 sm:p-8">
                @if (session('success'))
                    <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Animal Health</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Animal Health</h1>
                        <p class="mt-2 text-sm text-gray-600">Review health records, treatments, and upcoming checkups.</p>
                    </div>
                    <a href="{{ route('animal-health.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#173f31] px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Record Health Check
                    </a>
                </section>

                <section aria-label="Animal health statistics" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Health records</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" /><path d="M14 3v5h5M9 14h6M12 11v6" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold tracking-tight text-[#20392f]">{{ number_format($healthSummary->total_records) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Recorded examinations</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Sick records</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" /><path d="M12 9v4M12 16h.01" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold tracking-tight text-[#20392f]">{{ number_format($healthSummary->sick_records) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Records marked sick</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Under treatment</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m10 14 4-4M8 16l-2 2a3 3 0 0 1-4-4l6-6a3 3 0 0 1 4 0M16 8l2-2a3 3 0 0 1 4 4l-6 6a3 3 0 0 1-4 0" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold tracking-tight text-[#20392f]">{{ number_format($healthSummary->treatment_records) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Records marked in treatment</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Follow-ups due</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2M8 3 5 5M16 3l3 2" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold tracking-tight text-[#20392f]">{{ number_format($healthSummary->follow_ups_due) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Scheduled for today or earlier</p>
                    </article>
                </section>

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div>
                            <h2 class="text-lg font-bold text-[#20392f]">Health Records</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ $records->total() }} matching {{ \Illuminate\Support\Str::plural('record', $records->total()) }}</p>
                        </div>

                        <form action="{{ route('animal-health.index') }}" method="GET" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                            <label for="health-search" class="sr-only">Search health records</label>
                            <input id="health-search" name="search" type="search" value="{{ $search }}" placeholder="Search animal, diagnosis..." class="min-w-0 rounded-xl border-gray-200 bg-[#f8faf7] text-sm focus:border-green-700 focus:ring-green-700 sm:w-56">
                            <label for="health-status" class="sr-only">Filter by health status</label>
                            <select id="health-status" name="status" class="rounded-xl border-gray-200 bg-[#f8faf7] text-sm focus:border-green-700 focus:ring-green-700">
                                <option value="">All statuses</option>
                                @foreach ($statuses as $healthStatus)
                                    <option value="{{ $healthStatus }}" @selected($status === $healthStatus)>{{ $healthStatus }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="rounded-xl bg-[#173f31] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                Search
                            </button>
                        </form>
                    </div>

                    @if ($records->isEmpty())
                        <div class="px-6 py-14 text-center">
                            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" /><path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $search !== '' || $status !== '' ? 'No matching health records' : 'No health records yet' }}</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $search !== '' || $status !== '' ? 'Try a different search or status filter.' : 'Record a health check to start tracking animal care.' }}</p>
                            @if ($search === '' && $status === '')
                                <a href="{{ route('animal-health.create') }}" class="mt-5 inline-flex items-center rounded-xl bg-[#173f31] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#285b43]">
                                    Record First Health Check
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-[#f8faf7]">
                                    <tr>
                                        @foreach ([
                                            'animal' => 'Animal',
                                            'checkup' => 'Checkup date',
                                            'condition' => 'Diagnosis',
                                            'treatment' => 'Treatment',
                                            'follow_up' => 'Follow-up',
                                            'status' => 'Status',
                                        ] as $column => $label)
                                            <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                                @if ($column === 'treatment')
                                                    {{ $label }}
                                                @else
                                                    <a href="{{ route('animal-health.index', [
                                                        'search' => $search ?: null,
                                                        'status' => $status ?: null,
                                                        'sort' => $column,
                                                        'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
                                                    ]) }}" class="inline-flex items-center gap-1.5 hover:text-[#173f31]">
                                                        {{ $label }}
                                                        @if ($sort === $column)
                                                            <span aria-label="{{ $direction === 'asc' ? 'ascending' : 'descending' }}">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                                        @endif
                                                    </a>
                                                @endif
                                            </th>
                                        @endforeach
                                        <th scope="col" class="whitespace-nowrap px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($records as $record)
                                        @php
                                            $statusClass = match ($record->health_status) {
                                                'Healthy' => 'bg-green-100 text-green-800',
                                                'Sick' => 'bg-red-100 text-red-800',
                                                'Under Treatment' => 'bg-amber-100 text-amber-800',
                                                'Recovered' => 'bg-blue-100 text-blue-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <tr class="transition hover:bg-[#f8faf7]">
                                            <td class="whitespace-nowrap px-5 py-4">
                                                <p class="font-semibold text-gray-900">{{ $record->animal->animal_id }}</p>
                                                <p class="mt-1 text-xs text-gray-500">{{ $record->animal->animal_type }} · {{ $record->animal->breed }}</p>
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">{{ $record->checkup_date->format('d M Y') }}</td>
                                            <td class="max-w-xs px-5 py-4">
                                                <p class="truncate text-sm font-medium text-gray-800">{{ $record->disease ?: 'No diagnosis recorded' }}</p>
                                                <p class="mt-1 truncate text-xs text-gray-500">{{ $record->symptoms ?: 'No symptoms recorded' }}</p>
                                            </td>
                                            <td class="max-w-xs px-5 py-4">
                                                <p class="truncate text-sm text-gray-700">{{ $record->treatment ?: 'No treatment recorded' }}</p>
                                                @if ($record->medicine)
                                                    <p class="mt-1 truncate text-xs text-gray-500">Medicine: {{ $record->medicine }}</p>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm {{ $record->next_checkup_date && $record->next_checkup_date->lte(today()) ? 'font-semibold text-red-700' : 'text-gray-700' }}">
                                                {{ $record->next_checkup_date?->format('d M Y') ?? 'Not scheduled' }}
                                                @if ($record->next_checkup_date && $record->next_checkup_date->lte(today()))
                                                    <span class="mt-1 block text-xs font-medium text-red-600">Due</span>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4">
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">{{ $record->health_status }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                                <a href="{{ route('animal-health.show', $record) }}" aria-label="View health record {{ $record->id }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                                        <circle cx="12" cy="12" r="3" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('animal-health.edit', $record) }}" aria-label="Edit health record {{ $record->id }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z" />
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('animal-health.destroy', $record) }}" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" aria-label="Delete health record {{ $record->id }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-red-50 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <polyline points="3 6 5 6 21 6" />
                                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                            <path d="M10 11v6M14 11v6" />
                                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="border-t border-gray-100 px-5 py-4 sm:px-6">
                            {{ $records->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
