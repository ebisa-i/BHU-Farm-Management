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
                @if (session('error'))
                    <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Milk Production</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Edit Milk Production</h1>
                    <p class="mt-1 text-sm text-gray-600">Record #{{ $milkProduction->id }}</p>
                </div>

                <div class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-8">
                    @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                            <ul class="list-inside list-disc text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('milk-productions.update', $milkProduction) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="animal_id" class="mb-1 block text-sm font-medium text-gray-700">
                                Dairy Animal *
                            </label>
                            <select id="animal_id" name="animal_id" required
                                    class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                <option value="">Select animal</option>
                                @foreach ($animals as $animal)
                                    <option value="{{ $animal->id }}"
                                        @selected(old('animal_id', $milkProduction->animal_id) == $animal->id)>
                                        {{ $animal->animal_id }} — {{ $animal->breed ?? 'Breed not specified' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="production_date" class="mb-1 block text-sm font-medium text-gray-700">
                                Production Date *
                            </label>
                            <input id="production_date" name="production_date" type="date"
                                   max="{{ date('Y-m-d') }}"
                                   value="{{ old('production_date', $milkProduction->production_date?->format('Y-m-d')) }}"
                                   required
                                   class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="session" class="mb-1 block text-sm font-medium text-gray-700">
                                Milking Session *
                            </label>
                            <select id="session" name="session" required
                                    class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                <option value="">Select session</option>
                                @foreach (['Morning', 'Afternoon', 'Evening'] as $sessionOption)
                                    <option value="{{ $sessionOption }}"
                                        @selected(old('session', $milkProduction->session) === $sessionOption)>
                                        {{ $sessionOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="quantity_liters" class="mb-1 block text-sm font-medium text-gray-700">
                                Quantity (liters) *
                            </label>
                            <input id="quantity_liters" name="quantity_liters" type="number"
                                   min="0.01" max="999999.99" step="0.01"
                                   value="{{ old('quantity_liters', $milkProduction->quantity_liters) }}"
                                   placeholder="e.g. 8.50"
                                   required
                                   class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="notes" class="mb-1 block text-sm font-medium text-gray-700">
                                Notes
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600"
                                      placeholder="Optional notes">{{ old('notes', $milkProduction->notes) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3 border-t pt-5">
                            <a href="{{ route('milk-productions.index') }}"
                               class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                                Update Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
