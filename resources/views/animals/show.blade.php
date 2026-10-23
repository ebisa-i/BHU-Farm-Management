<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'animals'])

        <main class="min-w-0 flex-1">
            <header class="flex items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>
                <a href="{{ route('animals.index') }}" class="text-sm font-semibold text-[#285b43] hover:underline">Back to animals</a>
            </header>

            <div class="space-y-6 p-5 sm:p-8">
                <section>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Animal Management / Record</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">{{ $animal->animal_id }}</h1>
                    <p class="mt-2 text-sm text-gray-600">Animal record and latest recorded health check.</p>
                </section>

                <section class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex flex-wrap items-start justify-between gap-4 border-b border-gray-100 pb-6">
                        <div>
                            <span @class([
                                'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                'bg-green-100 text-green-800' => $animal->status === 'Active',
                                'bg-amber-100 text-amber-800' => $animal->status === 'Transferred',
                                'bg-gray-100 text-gray-700' => $animal->status === 'Sold',
                                'bg-red-100 text-red-800' => $animal->status === 'Deceased',
                            ])>{{ $animal->status }}</span>
                            <h2 class="mt-3 text-xl font-bold text-[#20392f]">{{ $animal->animal_type }} · {{ $animal->breed ?: 'Breed not recorded' }}</h2>
                        </div>
                        <a href="{{ route('animals.edit', $animal) }}" class="inline-flex items-center gap-2 rounded-xl bg-[#173f31] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m16 5 3 3M4 20l4.5-1 11-11a2.1 2.1 0 0 0-3-3l-11 11L4 20Z" />
                            </svg>
                            Edit animal
                        </a>
                    </div>

                    <dl class="grid gap-6 py-6 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Animal ID</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $animal->animal_id }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Type</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $animal->animal_type }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Breed</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $animal->breed ?: 'Not recorded' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Sex</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $animal->sex }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Date of birth</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $animal->date_of_birth?->format('Y-m-d') ?? 'Not recorded' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Weight</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $animal->weight !== null ? number_format((float) $animal->weight, 2).' kg' : 'Not recorded' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Registered</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $animal->created_at?->format('Y-m-d') ?? 'Not recorded' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Latest health check</dt>
                            <dd class="mt-2 font-medium text-gray-900">{{ $latestHealthRecord?->checkup_date?->format('Y-m-d') ?? 'No health check recorded' }}</dd>
                        </div>
                        @if ($animal->notes)
                            <div class="sm:col-span-2 lg:col-span-3">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">Notes</dt>
                                <dd class="mt-2 whitespace-pre-line text-gray-700">{{ $animal->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
