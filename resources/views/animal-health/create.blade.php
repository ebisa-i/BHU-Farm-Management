
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Register Animal Health
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('animal-health.index') }}"
                   class="text-sm font-semibold text-green-700 hover:text-green-900">
                    ← Back to Health Records
                </a>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm sm:p-8">
                <h3 class="mb-2 text-lg font-bold text-gray-900">
                    Animal Health Examination
                </h3>
                <p class="mb-6 text-sm text-gray-500">
                    Record the animal's health condition, symptoms, and treatment.
                </p>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-50 p-4 text-red-700">
                        <p class="mb-2 font-semibold">
                            Please correct the following errors:
                        </p>
                        <ul class="list-inside list-disc text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('animal-health.store') }}"
                      method="POST"
                      class="space-y-5">
                    @csrf

                    <div>
                        <label for="animal_id"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Select Animal *
                        </label>
                        <select id="animal_id" name="animal_id" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                            <option value="">-- Select Animal --</option>
                            @foreach ($animals as $animal)
                                <option value="{{ $animal->id }}"
                                    @selected(old('animal_id') == $animal->id)>
                                    {{ $animal->animal_id }}
                                    — {{ $animal->animal_type }}
                                    — {{ $animal->breed }}
                                </option>
                            @endforeach
                        </select>

                        @if ($animals->isEmpty())
                            <p class="mt-2 text-sm text-red-600">
                                No animals found. Please register an animal first.
                            </p>
                        @endif
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="checkup_date"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Checkup Date *
                            </label>
                            <input id="checkup_date" type="date"
                                   name="checkup_date"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ old('checkup_date', now()->toDateString()) }}"
                                   required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="health_status"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Health Status *
                            </label>
                            <select id="health_status" name="health_status" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                                @foreach (['Healthy', 'Sick', 'Under Treatment', 'Recovered'] as $status)
                                    <option value="{{ $status }}"
                                        @selected(old('health_status', 'Healthy') === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="disease"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Disease / Diagnosis
                        </label>
                        <input id="disease" type="text" name="disease"
                               value="{{ old('disease') }}"
                               placeholder="Enter disease or diagnosis"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                    </div>

                    <div>
                        <label for="symptoms"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Symptoms
                        </label>
                        <textarea id="symptoms" name="symptoms" rows="3"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600"
                                  placeholder="Describe observed symptoms">{{ old('symptoms') }}</textarea>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="treatment"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Treatment
                            </label>
                            <textarea id="treatment" name="treatment" rows="3"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600"
                                      placeholder="Treatment given">{{ old('treatment') }}</textarea>
                        </div>

                        <div>
                            <label for="medicine"
                                   class="mb-1 block text-sm font-medium text-gray-700">
                                Medicine
                            </label>
                            <input id="medicine" type="text" name="medicine"
                                   value="{{ old('medicine') }}"
                                   placeholder="Medicine name"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                        </div>
                    </div>

                    <div>
                        <label for="next_checkup_date"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Next Checkup Date
                        </label>
                        <input id="next_checkup_date" type="date"
                               name="next_checkup_date"
                               min="{{ now()->toDateString() }}"
                               value="{{ old('next_checkup_date') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600">
                    </div>

                    <div>
                        <label for="notes"
                               class="mb-1 block text-sm font-medium text-gray-700">
                            Additional Notes
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600"
                                  placeholder="Additional information">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex flex-wrap justify-end gap-3 border-t pt-5">
                        <a href="{{ route('animal-health.index') }}"
                           class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>

                        <button type="submit"
                                @disabled($animals->isEmpty())
                                class="rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-800 disabled:cursor-not-allowed disabled:opacity-50">
                            Save Health Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
