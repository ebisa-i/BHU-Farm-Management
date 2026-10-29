<x-app-layout>
    <div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'breedings'])

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
                                <x-user-avatar />
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
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Breeding</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Breeding Record</h1>
                        <p class="mt-1 text-sm text-gray-600">BRD-{{ str_pad((string) $breeding->id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('breedings.edit', $breeding) }}"
                           class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                            Edit
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-[#dfe8e1] bg-white shadow-sm">
                    <div class="border-b border-[#dfe8e1] px-6 py-5">
                        <h2 class="font-semibold text-[#20392f]">Breeding Details</h2>
                    </div>
                    <dl class="divide-y divide-[#f0f4f1]">
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Female Animal</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $breeding->femaleAnimal?->animal_id ?? '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Male Animal / Sire</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $breeding->maleAnimal?->animal_id ?? 'Not specified' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Mating Date</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $breeding->mating_date?->format('d M Y') ?? '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Breeding Method</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $breeding->breeding_method }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Expected Calving Date</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $breeding->expected_calving_date?->format('d M Y') ?? 'Not set' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Actual Calving Date</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $breeding->actual_calving_date?->format('d M Y') ?? 'Not recorded' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="col-span-2">
                                <span @class([
                                    'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-blue-100 text-blue-800' => $breeding->status === 'Pregnant',
                                    'bg-amber-100 text-amber-800' => $breeding->status === 'Pending',
                                    'bg-green-100 text-green-800' => $breeding->status === 'Calved',
                                    'bg-red-100 text-red-800' => $breeding->status === 'Failed',
                                ])>{{ $breeding->status }}</span>
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Notes</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $breeding->notes ?: '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <a href="{{ route('breedings.index') }}"
                       class="font-semibold text-green-700 hover:text-green-900">
                        &larr; Back to Breeding Records
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
