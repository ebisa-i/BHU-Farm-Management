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
                @if (session('error'))
                    <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Animal Health</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Edit Health Record</h1>
                    <p class="mt-1 text-sm text-gray-600">Record #{{ $animalHealth->id }}</p>
                </div>

                <div class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-8">
                    @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                            <p class="mb-2 font-semibold text-sm">Please correct the following errors:</p>
                            <ul class="list-inside list-disc text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('animal-health.update', $animalHealth) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="animal_id" class="mb-1 block text-sm font-medium text-gray-700">
                                Select Animal *
                            </label>
                            <select id="animal_id" name="animal_id" required
                                    class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600">
                                <option value="">-- Select Animal --</option>
                                @foreach ($animals as $animal)
                                    <option value="{{ $animal->id }}"
                                        @selected(old('animal_id', $animalHealth->animal_id) == $animal->id)>
                                        {{ $animal->animal_id }} — {{ $animal->animal_type }} — {{ $animal->breed }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="checkup_date" class="mb-1 block text-sm font-medium text-gray-700">
                                    Checkup Date *
                                </label>
                                <input id="checkup_date" type="date" name="checkup_date"
                                       max="{{ now()->toDateString() }}"
                                       value="{{ old('checkup_date', $animalHealth->checkup_date?->format('Y-m-d')) }}"
                                       required
                                       class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600">
                            </div>

                            <div>
                                <label for="health_status" class="mb-1 block text-sm font-medium text-gray-700">
                                    Health Status *
                                </label>
                                <select id="health_status" name="health_status" required
                                        class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600">
                                    @foreach (['Healthy', 'Sick', 'Under Treatment', 'Recovered'] as $statusOption)
                                        <option value="{{ $statusOption }}"
                                            @selected(old('health_status', $animalHealth->health_status) === $statusOption)>
                                            {{ $statusOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="disease" class="mb-1 block text-sm font-medium text-gray-700">
                                Disease / Diagnosis
                            </label>
                            <input id="disease" type="text" name="disease"
                                   value="{{ old('disease', $animalHealth->disease) }}"
                                   placeholder="Enter disease or diagnosis"
                                   class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="symptoms" class="mb-1 block text-sm font-medium text-gray-700">
                                Symptoms
                            </label>
                            <textarea id="symptoms" name="symptoms" rows="3"
                                      class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600"
                                      placeholder="Describe observed symptoms">{{ old('symptoms', $animalHealth->symptoms) }}</textarea>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="treatment" class="mb-1 block text-sm font-medium text-gray-700">
                                    Treatment
                                </label>
                                <textarea id="treatment" name="treatment" rows="3"
                                          class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600"
                                          placeholder="Treatment given">{{ old('treatment', $animalHealth->treatment) }}</textarea>
                            </div>

                            <div>
                                <label for="medicine" class="mb-1 block text-sm font-medium text-gray-700">
                                    Medicine
                                </label>
                                <input id="medicine" type="text" name="medicine"
                                       value="{{ old('medicine', $animalHealth->medicine) }}"
                                       placeholder="Medicine name"
                                       class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600">
                            </div>
                        </div>

                        <div>
                            <label for="next_checkup_date" class="mb-1 block text-sm font-medium text-gray-700">
                                Next Checkup Date
                            </label>
                            <input id="next_checkup_date" type="date" name="next_checkup_date"
                                   value="{{ old('next_checkup_date', $animalHealth->next_checkup_date?->format('Y-m-d')) }}"
                                   class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="notes" class="mb-1 block text-sm font-medium text-gray-700">
                                Additional Notes
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full rounded-xl border border-[#d3e1d8] shadow-sm focus:border-green-600 focus:ring-green-600"
                                      placeholder="Additional information">{{ old('notes', $animalHealth->notes) }}</textarea>
                        </div>

                        <div class="flex flex-wrap justify-end gap-3 border-t pt-5">
                            <a href="{{ route('animal-health.index') }}"
                               class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                                Update Health Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
