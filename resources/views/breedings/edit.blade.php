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
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Breeding</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Edit Breeding Record</h1>
                    <p class="mt-1 text-sm text-gray-600">BRD-{{ str_pad((string) $breeding->id, 3, '0', STR_PAD_LEFT) }}</p>
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

                    <form action="{{ route('breedings.update', $breeding) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="female_animal_id" class="mb-1 block text-sm font-medium text-gray-700">
                                Female Animal *
                            </label>
                            <select name="female_animal_id" id="female_animal_id" required
                                    class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                <option value="">-- Select Female Animal --</option>
                                @foreach ($females as $animal)
                                    <option value="{{ $animal->id }}"
                                        @selected(old('female_animal_id', $breeding->female_animal_id) == $animal->id)>
                                        {{ $animal->animal_id }} — {{ $animal->animal_type }} — {{ $animal->breed }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="male_animal_id" class="mb-1 block text-sm font-medium text-gray-700">
                                Male Animal (optional)
                            </label>
                            <select name="male_animal_id" id="male_animal_id"
                                    class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                <option value="">-- Select Male Animal --</option>
                                @foreach ($males as $animal)
                                    <option value="{{ $animal->id }}"
                                        @selected(old('male_animal_id', $breeding->male_animal_id) == $animal->id)>
                                        {{ $animal->animal_id }} — {{ $animal->animal_type }} — {{ $animal->breed }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">For artificial insemination, the male animal record may be left blank.</p>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="mating_date" class="mb-1 block text-sm font-medium text-gray-700">
                                    Mating Date *
                                </label>
                                <input type="date" name="mating_date" id="mating_date"
                                       max="{{ now()->toDateString() }}"
                                       value="{{ old('mating_date', $breeding->mating_date?->format('Y-m-d')) }}"
                                       required
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>

                            <div>
                                <label for="breeding_method" class="mb-1 block text-sm font-medium text-gray-700">
                                    Breeding Method *
                                </label>
                                <select name="breeding_method" id="breeding_method" required
                                        class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                    <option value="Natural"
                                        @selected(old('breeding_method', $breeding->breeding_method) === 'Natural')>
                                        Natural
                                    </option>
                                    <option value="Artificial Insemination"
                                        @selected(old('breeding_method', $breeding->breeding_method) === 'Artificial Insemination')>
                                        Artificial Insemination
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="expected_calving_date" class="mb-1 block text-sm font-medium text-gray-700">
                                    Expected Calving Date
                                </label>
                                <input type="date" name="expected_calving_date" id="expected_calving_date"
                                       value="{{ old('expected_calving_date', $breeding->expected_calving_date?->format('Y-m-d')) }}"
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>

                            <div>
                                <label for="actual_calving_date" class="mb-1 block text-sm font-medium text-gray-700">
                                    Actual Calving Date
                                </label>
                                <input type="date" name="actual_calving_date" id="actual_calving_date"
                                       max="{{ now()->toDateString() }}"
                                       value="{{ old('actual_calving_date', $breeding->actual_calving_date?->format('Y-m-d')) }}"
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>
                        </div>

                        <div>
                            <label for="status" class="mb-1 block text-sm font-medium text-gray-700">
                                Breeding Status *
                            </label>
                            <select name="status" id="status" required
                                    class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                @foreach (['Pending', 'Pregnant', 'Calved', 'Failed'] as $statusOption)
                                    <option value="{{ $statusOption }}"
                                        @selected(old('status', $breeding->status) === $statusOption)>
                                        {{ $statusOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="notes" class="mb-1 block text-sm font-medium text-gray-700">
                                Notes
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                      class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600"
                                      placeholder="Add breeding observations or other details">{{ old('notes', $breeding->notes) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3 border-t pt-5">
                            <a href="{{ route('breedings.index') }}"
                               class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                                Update Breeding Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
