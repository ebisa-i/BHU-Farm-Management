<x-app-layout>
    <div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">
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

            <div class="space-y-6 p-5 sm:p-8">
                @if (session('success'))
                    <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Animal Health</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Health Record</h1>
                        <p class="mt-1 text-sm text-gray-600">Record #{{ $animalHealth->id }}</p>
                    </div>
                    <a href="{{ route('animal-health.edit', $animalHealth) }}"
                       class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                        Edit
                    </a>
                </div>

                <div class="rounded-2xl border border-[#dfe8e1] bg-white shadow-sm">
                    <div class="border-b border-[#dfe8e1] px-6 py-5">
                        <h2 class="font-semibold text-[#20392f]">Health Examination Details</h2>
                    </div>
                    <dl class="divide-y divide-[#f0f4f1]">
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Animal</dt>
                            <dd class="col-span-2 text-sm text-gray-900">
                                {{ $animalHealth->animal?->animal_id ?? '—' }}
                                @if ($animalHealth->animal?->animal_type)
                                    <span class="text-gray-500"> · {{ $animalHealth->animal->animal_type }}</span>
                                @endif
                                @if ($animalHealth->animal?->breed)
                                    <span class="text-gray-500"> · {{ $animalHealth->animal->breed }}</span>
                                @endif
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Checkup Date</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $animalHealth->checkup_date?->format('d M Y') ?? '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Health Status</dt>
                            <dd class="col-span-2">
                                @php
                                    $statusClass = match ($animalHealth->health_status) {
                                        'Healthy' => 'bg-green-100 text-green-800',
                                        'Sick' => 'bg-red-100 text-red-800',
                                        'Under Treatment' => 'bg-amber-100 text-amber-800',
                                        'Recovered' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $animalHealth->health_status }}
                                </span>
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Disease / Diagnosis</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $animalHealth->disease ?: '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Symptoms</dt>
                            <dd class="col-span-2 text-sm text-gray-900 whitespace-pre-wrap">{{ $animalHealth->symptoms ?: '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Treatment</dt>
                            <dd class="col-span-2 text-sm text-gray-900 whitespace-pre-wrap">{{ $animalHealth->treatment ?: '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Medicine</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $animalHealth->medicine ?: '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Next Checkup Date</dt>
                            <dd class="col-span-2 text-sm {{ $animalHealth->next_checkup_date?->lte(today()) ? 'font-semibold text-red-700' : 'text-gray-900' }}">
                                {{ $animalHealth->next_checkup_date?->format('d M Y') ?? 'Not scheduled' }}
                                @if ($animalHealth->next_checkup_date?->lte(today()))
                                    <span class="ml-2 text-xs text-red-600">Due</span>
                                @endif
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Notes</dt>
                            <dd class="col-span-2 text-sm text-gray-900 whitespace-pre-wrap">{{ $animalHealth->notes ?: '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <a href="{{ route('animal-health.index') }}"
                       class="font-semibold text-green-700 hover:text-green-900">
                        &larr; Back to Health Records
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
