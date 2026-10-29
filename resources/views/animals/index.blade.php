<x-app-layout>
    @php
        $sortUrl = fn (string $column): string => route('animals.index', [
            'search' => $search ?: null,
            'sort' => $column,
            'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'animals'])

        <main class="min-w-0 flex-1">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>

                <div class="flex w-full flex-wrap items-center gap-4 sm:w-auto">
                    <form action="{{ route('animals.index') }}" method="GET" class="min-w-0 flex-1 sm:w-64 sm:flex-none">
                        <label for="animal-search" class="sr-only">Search animals</label>
                        <div class="flex items-center gap-2 rounded-xl bg-[#f3f6f2] px-3 py-2.5 text-gray-500 focus-within:ring-2 focus-within:ring-green-700">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m20 20-4-4" />
                            </svg>
                            <input id="animal-search" name="search" type="search" value="{{ $search }}" placeholder="Search animals..." class="w-full border-0 bg-transparent p-0 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-0">
                            @if ($sort !== 'registered' || $direction !== 'desc')
                                <input type="hidden" name="sort" value="{{ $sort }}">
                                <input type="hidden" name="direction" value="{{ $direction }}">
                            @endif
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

            <div class="space-y-8 p-5 sm:p-8">
                @if (session('success'))
                    <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Animal Management</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Animal Management</h1>
                        <p class="mt-2 text-sm text-gray-600">Track every animal from registration to daily care.</p>
                    </div>
                    @canDo('create')
                    <a href="{{ route('animals.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#173f31] px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Register Animal
                    </a>
                    @endCanDo
                </section>

                <section aria-label="Animal statistics" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Registered animals</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="7" cy="7" r="2" /><circle cx="15" cy="5" r="2" /><circle cx="19" cy="10" r="1.7" /><path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($animalSummary->total_animals) }}</p>
                        <p class="mt-2 text-sm text-gray-500">{{ $animalSummary->dairy_animals }} dairy · {{ $animalSummary->beef_animals }} beef · {{ $animalSummary->calves }} calves</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Health reviews due</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" />
                                    <path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($dueHealthReviews) }}</p>
                        <p class="mt-2 text-sm text-gray-500">Animals with a check-up due</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Active animals</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" />
                                    <circle cx="12" cy="11" r="2.5" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($animalSummary->active_animals) }}</p>
                        <p class="mt-2 text-sm text-gray-500">Currently marked active</p>
                    </article>
                </section>

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="flex flex-col gap-1 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="font-semibold text-[#20392f]">Animal management records</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ number_format($animals->total()) }} matching {{ \Illuminate\Support\Str::plural('record', $animals->total()) }} · select a heading to sort
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1050px] text-left text-sm">
                            <thead class="bg-[#f7f9f6] text-xs font-semibold uppercase tracking-wider text-gray-600">
                                <tr>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('animal_id') }}">Animal ID</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('type') }}">Type</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('breed') }}">Breed</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('sex') }}">Sex</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('born') }}">Born</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('weight') }}">Weight</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('status') }}">Status</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('health_check') }}">Health check</a></th>
                                    <th scope="col" class="px-5 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($animals as $animal)
                                    <tr class="transition hover:bg-[#fafcf9]">
                                        <td class="whitespace-nowrap px-5 py-4 font-medium text-[#20392f]">{{ $animal->animal_id }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $animal->animal_type }}</td>
                                        <td class="px-5 py-4 text-gray-700">{{ $animal->breed ?: '—' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $animal->sex }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $animal->date_of_birth?->format('Y-m-d') ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $animal->weight !== null ? number_format((float) $animal->weight, 2).' kg' : '—' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <span @class([
                                                'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                                'bg-green-100 text-green-800' => $animal->status === 'Active',
                                                'bg-amber-100 text-amber-800' => $animal->status === 'Transferred',
                                                'bg-gray-100 text-gray-700' => $animal->status === 'Sold',
                                                'bg-red-100 text-red-800' => $animal->status === 'Deceased',
                                            ])>{{ $animal->status }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $animal->health_records_max_checkup_date ? \Illuminate\Support\Carbon::parse($animal->health_records_max_checkup_date)->format('Y-m-d') : '—' }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('animals.show', $animal) }}" aria-label="View {{ $animal->animal_id }}" class="rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                                        <circle cx="12" cy="12" r="3" />
                                                    </svg>
                                                </a>
                                                @canDo('edit')
                                                <a href="{{ route('animals.edit', $animal) }}" aria-label="Edit {{ $animal->animal_id }}" class="rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="m16 5 3 3M4 20l4.5-1 11-11a2.1 2.1 0 0 0-3-3l-11 11L4 20Z" />
                                                    </svg>
                                                </a>
                                                @endCanDo
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <p class="font-semibold text-gray-700">{{ $search ? 'No animals match your search.' : 'No animals registered yet.' }}</p>
                                            @if ($search)
                                                <a href="{{ route('animals.index') }}" class="mt-2 inline-block text-sm font-semibold text-green-800 underline">Clear search</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($animals->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">
                            {{ $animals->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
