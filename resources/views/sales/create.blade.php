
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800">
                Record New Sale
            </h2>

            <a href="{{ route('sales.index') }}"
               class="text-sm font-semibold text-green-700 hover:text-green-900">
                ← View All Sales
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-xl shadow-sm">

                <h3 class="text-lg font-bold text-gray-800 mb-2">
                    Sales Information
                </h3>

                <p class="text-sm text-gray-500 mb-6">
                    Record animal or milk sales at the farm.
                </p>

                @if ($errors->any())
                    <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-700">
                        <p class="font-semibold">
                            Please correct the following errors:
                        </p>

                        <ul class="list-disc ml-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('sales.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Sale Type --}}
                        <div>
                            <label for="sale_type"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Sale Type *
                            </label>

                            <select name="sale_type"
                                    id="sale_type"
                                    required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">

                                <option value="">Select sale type</option>

                                <option value="Animal"
                                    @selected(old('sale_type') === 'Animal')>
                                    Animal Sale
                                </option>

                                <option value="Milk"
                                    @selected(old('sale_type') === 'Milk')>
                                    Milk Sale
                                </option>
                            </select>
                        </div>

                        {{-- Animal Selection --}}
                        <div>
                            <label for="animal_id"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Select Animal
                                <span id="animal-required-label">*</span>
                            </label>

                            <select name="animal_id"
                                    id="animal_id"
                                    required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">

                                <option value="">Select animal</option>

                                @foreach ($animals as $animal)
                                    <option
                                        value="{{ $animal->id }}"
                                        data-sex="{{ $animal->sex }}"
                                        @selected((string) old('animal_id') === (string) $animal->id)>

                                        {{ $animal->animal_id }}
                                        — {{ $animal->animal_type }}
                                        ({{ $animal->sex }})

                                    </option>
                                @endforeach
                            </select>

                            <p id="animal-help"
                               class="mt-2 text-xs text-gray-500">
                                Select the animal related to this sale.
                            </p>
                        </div>

                        {{-- Buyer Name --}}
                        <div>
                            <label for="buyer_name"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Buyer Name *
                            </label>

                            <input type="text"
                                   name="buyer_name"
                                   id="buyer_name"
                                   value="{{ old('buyer_name') }}"
                                   required
                                   maxlength="255"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Buyer Phone --}}
                        <div>
                            <label for="buyer_phone"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Buyer Phone
                            </label>

                            <input type="text"
                                   name="buyer_phone"
                                   id="buyer_phone"
                                   value="{{ old('buyer_phone') }}"
                                   maxlength="30"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Item Description --}}
                        <div class="md:col-span-2">
                            <label for="item_description"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Item Description *
                            </label>

                            <input type="text"
                                   name="item_description"
                                   id="item_description"
                                   value="{{ old('item_description') }}"
                                   placeholder="Example: Fresh milk or dairy cow"
                                   required
                                   maxlength="255"
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label for="quantity"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Quantity *
                            </label>

                            <input type="number"
                                   name="quantity"
                                   id="quantity"
                                   value="{{ old('quantity') }}"
                                   min="0.01"
                                   step="0.01"
                                   required
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">

                            <p id="quantity-help"
                               class="mt-1 text-xs text-gray-500">
                                Enter the quantity being sold.
                            </p>
                        </div>

                        {{-- Unit Price --}}
                        <div>
                            <label for="unit_price"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Unit Price (ETB) *
                            </label>

                            <input type="number"
                                   name="unit_price"
                                   id="unit_price"
                                   value="{{ old('unit_price') }}"
                                   min="0"
                                   step="0.01"
                                   required
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Sale Date --}}
                        <div>
                            <label for="sale_date"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Sale Date *
                            </label>

                            <input type="date"
                                   name="sale_date"
                                   id="sale_date"
                                   value="{{ old('sale_date', now()->toDateString()) }}"
                                   max="{{ now()->toDateString() }}"
                                   required
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        </div>

                        {{-- Total Preview --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Total Amount
                            </label>

                            <div class="w-full rounded-lg bg-green-50 border border-green-200 px-4 py-2.5">
                                <span id="total-preview"
                                      class="font-bold text-green-800">
                                    ETB 0.00
                                </span>
                            </div>

                            <p class="mt-1 text-xs text-gray-500">
                                Quantity × Unit Price
                            </p>
                        </div>

                        {{-- Notes --}}
                        <div class="md:col-span-2">
                            <label for="notes"
                                   class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>

                            <textarea name="notes"
                                      id="notes"
                                      rows="3"
                                      maxlength="5000"
                                      placeholder="Additional information..."
                                      class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">{{ old('notes') }}</textarea>
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="mt-6 flex flex-wrap gap-3">

                        <button type="submit"
                                class="px-5 py-2.5 bg-green-700 text-white rounded-lg font-semibold hover:bg-green-800">
                            Save Sale
                        </button>

                        <a href="{{ route('sales.index') }}"
                           class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300">
                            Cancel
                        </a>

                    </div>
                </form>
            </div>

            <div class="mt-5">
                <a href="{{ route('dashboard') }}"
                   class="text-green-700 hover:text-green-900 font-medium">
                    ← Back to Dashboard
                </a>
            </div>

        </div>
    </div>

    {{-- Dynamic Animal Filtering and Total Calculation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const saleType = document.getElementById('sale_type');
            const animalSelect = document.getElementById('animal_id');
            const animalHelp = document.getElementById('animal-help');
            const animalRequiredLabel = document.getElementById('animal-required-label');

            const description = document.getElementById('item_description');
            const quantity = document.getElementById('quantity');
            const unitPrice = document.getElementById('unit_price');
            const quantityHelp = document.getElementById('quantity-help');
            const totalPreview = document.getElementById('total-preview');

            function filterAnimals() {
                const isMilkSale = saleType.value === 'Milk';

                Array.from(animalSelect.options).forEach(function (option) {
                    if (option.value === '') {
                        option.hidden = false;
                        return;
                    }

                    const isFemale = option.dataset.sex === 'Female';

                    option.hidden = isMilkSale && !isFemale;
                });

                const selectedOption = animalSelect.options[animalSelect.selectedIndex];

                if (
                    selectedOption &&
                    selectedOption.value !== '' &&
                    isMilkSale &&
                    selectedOption.dataset.sex !== 'Female'
                ) {
                    animalSelect.value = '';
                }

                animalSelect.required = true;

                if (isMilkSale) {
                    animalHelp.textContent =
                        'Milk sale: only female animals are available for selection.';

                    description.placeholder = 'Example: Fresh milk';
                    quantityHelp.textContent = 'Enter the milk quantity in liters.';
                } else {
                    animalHelp.textContent =
                        'Animal sale: select the animal being sold.';

                    description.placeholder = 'Example: Dairy cow or beef cattle';
                    quantityHelp.textContent = 'Enter the number of animals sold.';
                }

                animalRequiredLabel.textContent = '*';
            }

            function calculateTotal() {
                const qty = parseFloat(quantity.value) || 0;
                const price = parseFloat(unitPrice.value) || 0;
                const total = qty * price;

                totalPreview.textContent = 'ETB ' + total.toLocaleString(
                    'en-US',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );
            }

            saleType.addEventListener('change', filterAnimals);
            quantity.addEventListener('input', calculateTotal);
            unitPrice.addEventListener('input', calculateTotal);

            filterAnimals();
            calculateTotal();
        });
    </script>
</x-app-layout>
