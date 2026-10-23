
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            Record Milk Production
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h1 class="mb-2 text-2xl font-bold text-green-800">
                    Daily Milk Production
                </h1>
                <p class="mb-6 text-gray-600">
                    Enter the milk produced by an active dairy animal.
                </p>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($animals->isEmpty())
                    <div class="rounded-lg bg-amber-50 p-4 text-amber-800">
                        No active dairy animals are available.
                        Register an active Dairy animal first.
                    </div>
                @else
                    <form method="POST"
                          action="{{ route('milk-productions.store') }}">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label for="animal_id"
                                       class="mb-2 block font-medium text-gray-700">
                                    Dairy Animal *
                                </label>
                                <select id="animal_id" name="animal_id" required
                                        class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                    <option value="">Select animal</option>
                                    @foreach ($animals as $animal)
                                        <option value="{{ $animal->id }}"
                                            @selected(old('animal_id') == $animal->id)>
                                            {{ $animal->animal_id }}
                                            — {{ $animal->breed ?? 'Breed not specified' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="production_date"
                                       class="mb-2 block font-medium text-gray-700">
                                    Production Date *
                                </label>
                                <input id="production_date"
                                       name="production_date"
                                       type="date"
                                       max="{{ date('Y-m-d') }}"
                                       value="{{ old('production_date', date('Y-m-d')) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                            </div>

                            <div>
                                <label for="session"
                                       class="mb-2 block font-medium text-gray-700">
                                    Milking Session *
                                </label>
                                <select id="session" name="session" required
                                        class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                                    <option value="">Select session</option>
                                    <option value="Morning" @selected(old('session') === 'Morning')>Morning</option>
                                    <option value="Afternoon" @selected(old('session') === 'Afternoon')>Afternoon</option>
                                    <option value="Evening" @selected(old('session') === 'Evening')>Evening</option>
                                </select>
                            </div>

                            <div>
                                <label for="quantity_liters"
                                       class="mb-2 block font-medium text-gray-700">
                                    Quantity (liters) *
                                </label>
                                <input id="quantity_liters"
                                       name="quantity_liters"
                                       type="number"
                                       min="0.01"
                                       max="999999.99"
                                       step="0.01"
                                       value="{{ old('quantity_liters') }}"
                                       placeholder="e.g. 8.50"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">
                            </div>

                            <div>
                                <label for="notes"
                                       class="mb-2 block font-medium text-gray-700">
                                    Notes
                                </label>
                                <textarea id="notes" name="notes" rows="3"
                                          class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600"
                                          placeholder="Optional notes">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="submit"
                                    class="rounded-lg bg-green-700 px-6 py-3 font-semibold text-white hover:bg-green-800">
                                Save Production
                            </button>

                            <a href="{{ route('milk-productions.index') }}"
                               class="rounded-lg bg-gray-200 px-6 py-3 font-semibold text-gray-700">
                                Cancel
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
