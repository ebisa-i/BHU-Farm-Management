
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Register Animal Breeding
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('breedings.index') }}"
               class="mb-6 inline-block font-semibold text-green-700 hover:text-green-900">
                &larr; Back to Breeding Records
            </a>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <h3 class="text-lg font-bold text-gray-900">
                    Breeding Information
                </h3>
                <p class="mb-6 mt-1 text-sm text-gray-500">
                    Enter mating details and monitor the expected calving date.
                </p>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-50 p-4 text-red-700">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('breedings.store') }}"
                      method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="female_animal_id"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Female Animal *
                        </label>
                        <select name="female_animal_id" id="female_animal_id"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                            <option value="">-- Select Female Animal --</option>
                            @foreach ($females as $animal)
                                <option value="{{ $animal->id }}"
                                    @selected(old('female_animal_id') == $animal->id)>
                                    {{ $animal->animal_id }} — {{ $animal->animal_type }} — {{ $animal->breed }}
                                </option>
                            @endforeach
                        </select>
                        @if ($females->isEmpty())
                            <p class="mt-1 text-sm text-red-600">
                                No active female animals found. Register an active female animal first.
                            </p>
                        @endif
                    </div>

                    <div>
                        <label for="male_animal_id"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Male Animal (optional)
                        </label>
                        <select name="male_animal_id" id="male_animal_id"
                                class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                            <option value="">-- Select Male Animal --</option>
                            @foreach ($males as $animal)
                                <option value="{{ $animal->id }}"
                                    @selected(old('male_animal_id') == $animal->id)>
                                    {{ $animal->animal_id }} — {{ $animal->animal_type }} — {{ $animal->breed }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            For artificial insemination, the male animal record may be left blank.
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="mating_date"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Mating Date *
                            </label>
                            <input type="date" name="mating_date" id="mating_date"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ old('mating_date') }}"
                                   required
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="breeding_method"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Breeding Method *
                            </label>
                            <select name="breeding_method" id="breeding_method"
                                    required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                <option value="Natural" @selected(old('breeding_method', 'Natural') === 'Natural')>
                                    Natural
                                </option>
                                <option value="Artificial Insemination"
                                    @selected(old('breeding_method') === 'Artificial Insemination')>
                                    Artificial Insemination
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="expected_calving_date"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Expected Calving Date
                            </label>
                            <input type="date" name="expected_calving_date"
                                   id="expected_calving_date"
                                   min="{{ now()->toDateString() }}"
                                   value="{{ old('expected_calving_date') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="actual_calving_date"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Actual Calving Date
                            </label>
                            <input type="date" name="actual_calving_date"
                                   id="actual_calving_date"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ old('actual_calving_date') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>
                    </div>

                    <div>
                        <label for="status"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Breeding Status *
                        </label>
                        <select name="status" id="status" required
                                class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                            @foreach (['Pending', 'Pregnant', 'Calved', 'Failed'] as $status)
                                <option value="{{ $status }}"
                                    @selected(old('status', 'Pending') === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="notes"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600"
                                  placeholder="Add breeding observations or other details">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 border-t pt-5">
                        <a href="{{ route('breedings.index') }}"
                           class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                @disabled($females->isEmpty())
                                class="rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-800 disabled:opacity-50">
                            Save Breeding Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
