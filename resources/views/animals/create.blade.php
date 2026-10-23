
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Register New Animal
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl bg-white p-6 shadow">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-green-800">
                        Animal Registration Form
                    </h3>
                    <p class="mt-2 text-gray-600">
                        Enter the animal information below.
                        The Animal ID will be generated automatically.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
                        <p class="font-semibold">Please correct these errors:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('animals.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        <div>
                            <label for="animal_type"
                                   class="mb-2 block font-medium text-gray-700">
                                Animal Type *
                            </label>
                            <select id="animal_type" name="animal_type" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                <option value="">Select animal type</option>
                                <option value="Dairy" @selected(old('animal_type') === 'Dairy')>Dairy Cattle</option>
                                <option value="Beef" @selected(old('animal_type') === 'Beef')>Beef Cattle</option>
                                <option value="Calf" @selected(old('animal_type') === 'Calf')>Calf</option>
                            </select>
                        </div>

                        <div>
                            <label for="breed"
                                   class="mb-2 block font-medium text-gray-700">
                                Breed
                            </label>
                            <input id="breed" name="breed" type="text"
                                   value="{{ old('breed') }}"
                                   placeholder="e.g. Boran, Holstein"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="sex"
                                   class="mb-2 block font-medium text-gray-700">
                                Sex *
                            </label>
                            <select id="sex" name="sex" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                <option value="">Select sex</option>
                                <option value="Male" @selected(old('sex') === 'Male')>Male</option>
                                <option value="Female" @selected(old('sex') === 'Female')>Female</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_of_birth"
                                   class="mb-2 block font-medium text-gray-700">
                                Date of Birth
                            </label>
                            <input id="date_of_birth" name="date_of_birth"
                                   type="date" max="{{ date('Y-m-d') }}"
                                   value="{{ old('date_of_birth') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="weight"
                                   class="mb-2 block font-medium text-gray-700">
                                Weight (kg)
                            </label>
                            <input id="weight" name="weight" type="number"
                                   min="0" max="999999.99" step="0.01"
                                   value="{{ old('weight') }}"
                                   placeholder="Enter weight in kilograms"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                        </div>

                        <div>
                            <label for="status"
                                   class="mb-2 block font-medium text-gray-700">
                                Status *
                            </label>
                            <select id="status" name="status" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                <option value="Active" @selected(old('status', 'Active') === 'Active')>Active</option>
                                <option value="Sold" @selected(old('status') === 'Sold')>Sold</option>
                                <option value="Deceased" @selected(old('status') === 'Deceased')>Deceased</option>
                                <option value="Transferred" @selected(old('status') === 'Transferred')>Transferred</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes"
                                   class="mb-2 block font-medium text-gray-700">
                                Notes
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                      placeholder="Additional information about the animal..."
                                      class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">{{ old('notes') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <button type="submit"
                                class="rounded-lg bg-green-700 px-6 py-3 font-semibold text-white hover:bg-green-800">
                            Register Animal
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
