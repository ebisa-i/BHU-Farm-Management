<x-app-layout>
    @php
        $sortUrl = fn (string $column): string => route('breedings.index', [
            'search' => $search ?: null,
            'sort' => $column,
            'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'breedings'])

        <main class="min-w-0 flex-1">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>

                <div class="flex w-full flex-wrap items-center gap-4 sm:w-auto">
                    <form action="{{ route('breedings.index') }}" method="GET" class="min-w-0 flex-1 sm:w-64 sm:flex-none">
                        @if ($sort !== 'service_date' || $direction !== 'desc')
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                        @endif
                        <label for="breeding-search" class="sr-only">Search breeding records</label>
                        <div class="flex items-center gap-2 rounded-xl bg-[#f3f6f2] px-3 py-2.5 text-gray-500 focus-within:ring-2 focus-within:ring-green-700">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m20 20-4-4" />
                            </svg>
                            <input id="breeding-search" name="search" type="search" value="{{ $search }}" placeholder="Search this screen..." class="w-full border-0 bg-transparent p-0 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-0">
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

                @if ($errors->any())
                    <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Breeding</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Breeding</h1>
                        <p class="mt-2 text-sm text-gray-600">Follow services, pregnancies and expected calvings.</p>
                    </div>
                    <a href="{{ route('breedings.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#173f31] px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Record Breeding
                    </a>
                </section>

                <section aria-label="Breeding summary" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Pregnant cows</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($breedingSummary->pregnant_cows) }}</p>
                        <p class="mt-2 text-sm text-gray-500">Confirmed records</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Due within 30 days</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path d="M16 3v4M8 3v4M3 10h18" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($breedingSummary->due_within_30_days) }}</p>
                        <p class="mt-2 text-sm text-gray-500">Prepare for expected calvings</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Inseminations this month</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="5" y="4" width="14" height="17" rx="2" />
                                    <path d="M9 4.5V3h6v1.5M9 10h6M9 14h6M9 18h3" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($breedingSummary->inseminations_this_month) }}</p>
                        <p class="mt-2 text-sm text-gray-500">{{ now()->format('F Y') }}</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Calves born this year</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="7" cy="7" r="2" /><circle cx="15" cy="5" r="2" /><circle cx="19" cy="10" r="1.7" /><path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($breedingSummary->calves_born_this_year) }}</p>
                        <p class="mt-2 text-sm text-gray-500">Recorded calving events</p>
                    </article>
                </section>

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-5">
                        <h2 class="font-semibold text-[#20392f]">Breeding records</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ number_format($breedings->total()) }} matching {{ \Illuminate\Support\Str::plural('record', $breedings->total()) }} · click a heading to sort
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1000px] text-left text-sm">
                            <thead class="bg-[#f7f9f6] text-xs font-semibold uppercase tracking-wider text-gray-600">
                                <tr>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('record') }}">Record</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('animal_id') }}">Animal ID</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('service_date') }}">Service date</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('method') }}">Method</a></th>
                                    <th scope="col" class="px-5 py-4">Sire / bull</th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('expected_calving') }}">Expected calving</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('result') }}">Result</a></th>
                                    <th scope="col" class="px-5 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($breedings as $breeding)
                                    <tr class="transition hover:bg-[#fafcf9]">
                                        <td class="whitespace-nowrap px-5 py-4 font-medium text-[#20392f]">BRD-{{ str_pad((string) $breeding->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $breeding->femaleAnimal?->animal_id ?? 'Unknown animal' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $breeding->mating_date?->format('Y-m-d') ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $breeding->breeding_method }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $breeding->maleAnimal?->animal_id ?? 'Not specified' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $breeding->expected_calving_date?->format('Y-m-d') ?? 'Not set' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <span @class([
                                                'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                                'bg-blue-100 text-blue-800' => $breeding->status === 'Pregnant',
                                                'bg-amber-100 text-amber-800' => $breeding->status === 'Pending',
                                                'bg-green-100 text-green-800' => $breeding->status === 'Calved',
                                                'bg-red-100 text-red-800' => $breeding->status === 'Failed',
                                            ])>{{ $breeding->status }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right">
                                            <a href="{{ route('breedings.show', $breeding) }}" aria-label="View breeding record {{ $breeding->id }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('breedings.edit', $breeding) }}" aria-label="Edit breeding record {{ $breeding->id }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z" />
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('breedings.destroy', $breeding) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" aria-label="Delete breeding record {{ $breeding->id }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-red-50 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
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
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <p class="font-semibold text-gray-700">{{ $search ? 'No breeding records match your search.' : 'No breeding records have been added yet.' }}</p>
                                            <a href="{{ route('breedings.create') }}" class="mt-2 inline-block text-sm font-semibold text-green-800 underline">Record breeding</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($breedings->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">
                            {{ $breedings->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
