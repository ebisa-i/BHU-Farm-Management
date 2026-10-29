<x-app-layout>
    <div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'milk-productions'])

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
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Milk Production</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Milk Production Record</h1>
                        <p class="mt-1 text-sm text-gray-600">Record #{{ $milkProduction->id }}</p>
                    </div>
                    <a href="{{ route('milk-productions.edit', $milkProduction) }}"
                       class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                        Edit
                    </a>
                </div>

                <div class="rounded-2xl border border-[#dfe8e1] bg-white shadow-sm">
                    <div class="border-b border-[#dfe8e1] px-6 py-5">
                        <h2 class="font-semibold text-[#20392f]">Production Details</h2>
                    </div>
                    <dl class="divide-y divide-[#f0f4f1]">
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Animal</dt>
                            <dd class="col-span-2 text-sm text-gray-900">
                                {{ $milkProduction->animal?->animal_id ?? '—' }}
                                @if ($milkProduction->animal?->breed)
                                    <span class="text-gray-500"> · {{ $milkProduction->animal->breed }}</span>
                                @endif
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Production Date</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $milkProduction->production_date?->format('d M Y') ?? '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Session</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $milkProduction->session }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Quantity (liters)</dt>
                            <dd class="col-span-2 text-sm font-semibold text-gray-900">{{ number_format((float) $milkProduction->quantity_liters, 2) }} L</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Notes</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $milkProduction->notes ?: '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <a href="{{ route('milk-productions.index') }}"
                       class="font-semibold text-green-700 hover:text-green-900">
                        &larr; Back to Milk Production Records
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
