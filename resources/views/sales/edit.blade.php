<x-app-layout>
    <div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'sales'])

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
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Sales Management</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Edit Sale</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $sale->sale_number }}</p>
                </div>

                <div class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-8">
                    @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                            <p class="mb-2 font-semibold text-sm">Please correct the following errors:</p>
                            <ul class="list-disc ml-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sales.update', $sale) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Sale Type --}}
                            <div>
                                <label for="sale_type" class="block text-sm font-medium text-gray-700 mb-1">
                                    Sale Type *
                                </label>
                                <select name="sale_type" id="sale_type" required
                                        class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                    <option value="">Select sale type</option>
                                    <option value="Animal" @selected(old('sale_type', $sale->sale_type) === 'Animal')>Animal Sale</option>
                                    <option value="Milk" @selected(old('sale_type', $sale->sale_type) === 'Milk')>Milk Sale</option>
                                </select>
                            </div>

                            {{-- Animal Selection --}}
                            <div>
                                <label for="animal_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Select Animal <span id="animal-required-label">*</span>
                                </label>
                                <select name="animal_id" id="animal_id" required
                                        class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                    <option value="">Select animal</option>
                                    @foreach ($animals as $animal)
                                        <option value="{{ $animal->id }}"
                                                data-sex="{{ $animal->sex }}"
                                                @selected((string) old('animal_id', $sale->animal_id) === (string) $animal->id)>
                                            {{ $animal->animal_id }} — {{ $animal->animal_type }} ({{ $animal->sex }})
                                        </option>
                                    @endforeach
                                </select>
                                <p id="animal-help" class="mt-2 text-xs text-gray-500">Select the animal related to this sale.</p>
                            </div>

                            {{-- Buyer Name --}}
                            <div>
                                <label for="buyer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Buyer Name *
                                </label>
                                <input type="text" name="buyer_name" id="buyer_name"
                                       value="{{ old('buyer_name', $sale->buyer_name) }}"
                                       required maxlength="255"
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>

                            {{-- Buyer Phone --}}
                            <div>
                                <label for="buyer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Buyer Phone
                                </label>
                                <input type="text" name="buyer_phone" id="buyer_phone"
                                       value="{{ old('buyer_phone', $sale->buyer_phone) }}"
                                       maxlength="30"
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>

                            {{-- Item Description --}}
                            <div class="md:col-span-2">
                                <label for="item_description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Item Description *
                                </label>
                                <input type="text" name="item_description" id="item_description"
                                       value="{{ old('item_description', $sale->item_description) }}"
                                       placeholder="Example: Fresh milk or dairy cow"
                                       required maxlength="255"
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>

                            {{-- Quantity --}}
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                    Quantity *
                                </label>
                                <input type="number" name="quantity" id="quantity"
                                       value="{{ old('quantity', $sale->quantity) }}"
                                       min="0.01" step="0.01" required
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                                <p id="quantity-help" class="mt-1 text-xs text-gray-500">Enter the quantity being sold.</p>
                            </div>

                            {{-- Unit Price --}}
                            <div>
                                <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Unit Price (ETB) *
                                </label>
                                <input type="number" name="unit_price" id="unit_price"
                                       value="{{ old('unit_price', $sale->unit_price) }}"
                                       min="0" step="0.01" required
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>

                            {{-- Sale Date --}}
                            <div>
                                <label for="sale_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Sale Date *
                                </label>
                                <input type="date" name="sale_date" id="sale_date"
                                       value="{{ old('sale_date', $sale->sale_date?->format('Y-m-d')) }}"
                                       max="{{ now()->toDateString() }}"
                                       required
                                       class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">
                            </div>

                            {{-- Total Preview --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                                <div class="w-full rounded-xl bg-green-50 border border-green-200 px-4 py-2.5">
                                    <span id="total-preview" class="font-bold text-green-800">ETB 0.00</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Quantity × Unit Price</p>
                            </div>

                            {{-- Notes --}}
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea name="notes" id="notes" rows="3" maxlength="5000"
                                          placeholder="Additional information..."
                                          class="w-full rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600">{{ old('notes', $sale->notes) }}</textarea>
                            </div>

                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <button type="submit"
                                    class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                                Update Sale
                            </button>
                            <a href="{{ route('sales.index') }}"
                               class="rounded-xl border border-gray-300 px-5 py-3 font-semibold text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

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
                    if (option.value === '') { option.hidden = false; return; }
                    const isFemale = option.dataset.sex === 'Female';
                    option.hidden = isMilkSale && !isFemale;
                });
                const selectedOption = animalSelect.options[animalSelect.selectedIndex];
                if (selectedOption && selectedOption.value !== '' && isMilkSale && selectedOption.dataset.sex !== 'Female') {
                    animalSelect.value = '';
                }
                animalSelect.required = true;
                if (isMilkSale) {
                    animalHelp.textContent = 'Milk sale: only female animals are available for selection.';
                    description.placeholder = 'Example: Fresh milk';
                    quantityHelp.textContent = 'Enter the milk quantity in liters.';
                } else {
                    animalHelp.textContent = 'Animal sale: select the animal being sold.';
                    description.placeholder = 'Example: Dairy cow or beef cattle';
                    quantityHelp.textContent = 'Enter the number of animals sold.';
                }
                animalRequiredLabel.textContent = '*';
            }

            function calculateTotal() {
                const qty = parseFloat(quantity.value) || 0;
                const price = parseFloat(unitPrice.value) || 0;
                const total = qty * price;
                totalPreview.textContent = 'ETB ' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            saleType.addEventListener('change', filterAnimals);
            quantity.addEventListener('input', calculateTotal);
            unitPrice.addEventListener('input', calculateTotal);

            filterAnimals();
            calculateTotal();
        });
    </script>
</x-app-layout>
