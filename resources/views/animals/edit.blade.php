
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Edit Animal Information
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 rounded-xl bg-green-800 p-6 text-white shadow">
                <h1 class="text-2xl font-bold">Update Animal Record</h1>
                <p class="mt-2 text-green-100">
                    Animal ID: {{ $animal->animal_id }}
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
                    <p class="font-bold">Please correct these errors:</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <form action="{{ route('animals.update', $animal) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block font-medium text-gray-700">
                                Animal ID
                            </label>
                            <input type="text"
                                   value="{{ $animal->animal_id }}"
                                   readonly
                                   class="w-full rounded-lg border-gray-300 bg-gray-100 text-gray-600">
                            <p class="mt-1 text-xs text-gray-500">
                                The animal ID cannot be changed.
                            </p>
                        </div>

                        <div>
                            <label for="animal_type" class="mb-2 block font-medium text-gray-700">
                                Animal Type *
                            </label>
                            <select id="animal_type" name="animal_type" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                @foreach (['Dairy', 'Beef', 'Calf'] as $type)
                                    <option value="{{ $type }}"
                                        @selected(old('animal_type', $animal->animal_type) === $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="breed" class="mb-2 block font-medium text-gray-700">
                                Breed
                            </label>
                            <input id="breed" name="breed" type="text"
                                   value="{{ old('breed', $animal->breed) }}"
                                   placeholder="e.g. Boran, Holstein"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="sex" class="mb-2 block font-medium text-gray-700">
                                Sex *
                            </label>
                            <select id="sex" name="sex" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                <option value="Male"
                                    @selected(old('sex', $animal->sex) === 'Male')>Male</option>
                                <option value="Female"
                                    @selected(old('sex', $animal->sex) === 'Female')>Female</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_of_birth" class="mb-2 block font-medium text-gray-700">
                                Date of Birth
                            </label>
                            <input id="date_of_birth" name="date_of_birth" type="date"
                                   max="{{ date('Y-m-d') }}"
                                   value="{{ old('date_of_birth', $animal->date_of_birth?->format('Y-m-d')) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="weight" class="mb-2 block font-medium text-gray-700">
                                Weight (kg)
                            </label>
                            <input id="weight" name="weight" type="number"
                                   min="0" max="999999.99" step="0.01"
                                   value="{{ old('weight', $animal->weight) }}"
                                   placeholder="Weight in kilograms"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="status" class="mb-2 block font-medium text-gray-700">
                                Status *
                            </label>
                            <select id="status" name="status" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                @foreach (['Active', 'Sold', 'Deceased', 'Transferred'] as $status)
                                    <option value="{{ $status }}"
                                        @selected(old('status', $animal->status) === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="mb-2 block font-medium text-gray-700">
                                Notes
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                      placeholder="Additional information..."
                                      class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">{{ old('notes', $animal->notes) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <button type="submit"
                                class="rounded-lg bg-green-700 px-6 py-3 font-semibold text-white hover:bg-green-800">
                            Save Changes
                        </button>

                        <a href="{{ route('animals.index') }}"
                           class="rounded-lg bg-gray-200 px-6 py-3 font-semibold text-gray-700 hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
