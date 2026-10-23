<x-app-layout>
    @php
        $sortUrl = fn (string $column): string => route('milk-productions.index', [
            'date' => $selectedDate,
            'search' => $search ?: null,
            'sort' => $column,
            'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'milk-productions'])

        <main class="min-w-0 flex-1">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>

                <div class="flex w-full flex-wrap items-center gap-4 sm:w-auto">
                    <form action="{{ route('milk-productions.index') }}" method="GET" class="min-w-0 flex-1 sm:w-64 sm:flex-none">
                        <input type="hidden" name="date" value="{{ $selectedDate }}">
                        @if ($sort !== 'date' || $direction !== 'desc')
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                        @endif
                        <label for="production-search" class="sr-only">Search by cow ID or breed</label>
                        <div class="flex items-center gap-2 rounded-xl bg-[#f3f6f2] px-3 py-2.5 text-gray-500 focus-within:ring-2 focus-within:ring-green-700">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m20 20-4-4" />
                            </svg>
                            <input id="production-search" name="search" type="search" value="{{ $search }}" placeholder="Search this screen..." class="w-full border-0 bg-transparent p-0 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-0">
                        </div>
                    </form>

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

            <div class="space-y-6 p-5 sm:space-y-8 sm:p-8">
                @if (session('success'))
                    <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Milk Production</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Milk Production</h1>
                        <p class="mt-2 text-sm text-gray-600">Capture yields and spot production changes early.</p>
                    </div>
                    <a href="{{ route('milk-productions.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#173f31] px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Record Milk
                    </a>
                </section>

                <section aria-label="Milk production summary" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Farm total · {{ \Illuminate\Support\Carbon::parse($selectedDate)->format('d M Y') }}</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 3s7 7.2 7 12a7 7 0 0 1-14 0c0-4.8 7-12 7-12Z" />
                                    <path d="M9 16a3 3 0 0 0 3 3" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format((float) $todayTotal, 1) }} L</p>
                        <p class="mt-2 text-sm text-gray-500">Total recorded for the selected date</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Average per active dairy cow</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 3v18h18" />
                                    <path d="m7 14 4-4 3 3 6-7" />
                                    <path d="M16 6h4v4" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($averagePerCow, 1) }} L</p>
                        <p class="mt-2 text-sm text-gray-500">Across {{ number_format($activeDairyCows) }} active dairy {{ \Illuminate\Support\Str::plural('cow', $activeDairyCows) }}</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Highest producing</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="8" r="6" />
                                    <path d="m8.2 13-1.1 8 4.9-2.5 4.9 2.5-1.1-8" />
                                </svg>
                            </span>
                        </div>
                        @if ($highestProduction)
                            <p class="mt-5 break-all text-3xl font-bold tracking-tight text-[#20392f]">{{ $highestProduction->animal->animal_id ?? 'Unknown animal' }}</p>
                            <p class="mt-2 text-sm text-gray-500">{{ number_format((float) $highestProduction->daily_total_liters, 1) }} L for the selected date</p>
                        @else
                            <p class="mt-5 text-3xl font-bold tracking-tight text-[#20392f]">No records</p>
                            <p class="mt-2 text-sm text-gray-500">No production recorded for this date</p>
                        @endif
                    </article>
                </section>

                <section class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm sm:flex sm:items-center sm:gap-4 sm:p-6">
                    <form action="{{ route('milk-productions.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
                        <input type="hidden" name="search" value="{{ $search }}">
                        @if ($sort !== 'date' || $direction !== 'desc')
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                        @endif
                        <div>
                            <label for="production-date" class="mb-2 block text-sm font-semibold text-gray-700">Production date</label>
                            <input id="production-date" name="date" type="date" max="{{ today()->toDateString() }}" value="{{ $selectedDate }}" required class="rounded-xl border-gray-300 text-gray-800 focus:border-green-700 focus:ring-green-700">
                        </div>
                        <button type="submit" class="rounded-xl bg-[#edf4e9] px-4 py-2.5 text-sm font-semibold text-[#285b43] transition hover:bg-[#dcebd6] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">View date</button>
                        <p class="text-sm text-gray-500">Daily totals are grouped by cow and milking session.</p>
                    </form>
                </section>

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-5">
                        <h2 class="font-semibold text-[#20392f]">Milk production records</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ number_format($productions->total()) }} matching {{ \Illuminate\Support\Str::plural('cow', $productions->total()) }} · click a heading to sort
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1000px] text-left text-sm">
                            <thead class="bg-[#f7f9f6] text-xs font-semibold uppercase tracking-wider text-gray-600">
                                <tr>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('date') }}">Date</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('animal_id') }}">Cow ID</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('morning') }}">Morning (L)</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('afternoon') }}">Afternoon (L)</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('evening') }}">Evening (L)</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('daily_total') }}">Daily total (L)</a></th>
                                    <th scope="col" class="px-5 py-4">Sessions</th>
                                    <th scope="col" class="px-5 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($productions as $production)
                                    <tr class="transition hover:bg-[#fafcf9]">
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $production->production_date->format('Y-m-d') }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 font-medium text-[#20392f]">
                                            {{ $production->animal->animal_id ?? 'Unknown animal' }}
                                            @if ($production->animal?->breed)
                                                <span class="mt-1 block text-xs font-normal text-gray-500">{{ $production->animal->breed }}</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ number_format((float) $production->morning_liters, 2) }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ number_format((float) $production->afternoon_liters, 2) }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ number_format((float) $production->evening_liters, 2) }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-[#20392f]">{{ number_format((float) $production->daily_total_liters, 2) }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $production->sessions_recorded }} / 3</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right">
                                            @if ($production->animal)
                                                <a href="{{ route('milk-productions.show', $production->representative_id) }}" aria-label="View production record" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                                        <circle cx="12" cy="12" r="3" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('milk-productions.edit', $production->representative_id) }}" aria-label="Edit production record" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z" />
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('milk-productions.destroy', $production->representative_id) }}" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" aria-label="Delete production record" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-red-50 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <polyline points="3 6 5 6 21 6" />
                                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                            <path d="M10 11v6M14 11v6" />
                                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <p class="font-semibold text-gray-700">{{ $search ? 'No production matches your search for this date.' : 'No milk production records for this date.' }}</p>
                                            <a href="{{ route('milk-productions.create') }}" class="mt-2 inline-block text-sm font-semibold text-green-800 underline">Record milk production</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($productions->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">
                            {{ $productions->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
