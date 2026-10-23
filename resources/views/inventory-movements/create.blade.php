<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'inventory'])
        <main class="min-w-0 flex-1">
            @include('inventory._page-header')
            <div class="p-5 sm:p-8">
                <div class="mx-auto max-w-3xl space-y-6">
                    <section>
                        <a href="{{ route('inventory.show', $inventoryItem) }}" class="text-sm font-semibold text-[#32634d] hover:text-[#173f31]">← Back to {{ $inventoryItem->name }}</a>
                        <p class="mt-5 text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Inventory</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Adjust Stock</h1>
                        <p class="mt-2 text-sm text-gray-600">Record stock received or used. Each change is saved to the movement history.</p>
                    </section>

                    <section class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm sm:p-7">
                        <div class="mb-6 rounded-xl bg-[#f8faf7] p-4">
                            <p class="font-semibold text-gray-900">{{ $inventoryItem->name }} <span class="font-normal text-gray-500">· {{ $inventoryItem->sku }}</span></p>
                            <p class="mt-1 text-sm text-gray-600">Available: {{ number_format((float) $inventoryItem->quantity, 2) }} {{ $inventoryItem->unit }}</p>
                        </div>

                        @if ($errors->any())
                            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                                <p class="font-semibold">Please correct the following errors:</p>
                                <ul class="mt-2 list-inside list-disc space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('inventory.movements.store', $inventoryItem) }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label for="movement_type" class="mb-1.5 block text-sm font-semibold text-gray-700">Movement type *</label>
                                <select id="movement_type" name="movement_type" required class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
                                    <option value="in" @selected(old('movement_type', 'in') === 'in')>Stock in — received or returned</option>
                                    <option value="out" @selected(old('movement_type') === 'out')>Stock out — used or removed</option>
                                </select>
                            </div>
                            <div>
                                <label for="quantity" class="mb-1.5 block text-sm font-semibold text-gray-700">Quantity ({{ $inventoryItem->unit }}) *</label>
                                <input id="quantity" name="quantity" type="number" value="{{ old('quantity') }}" required min="0.01" step="0.01" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
                            </div>
                            <div>
                                <label for="reason" class="mb-1.5 block text-sm font-semibold text-gray-700">Reason *</label>
                                <textarea id="reason" name="reason" rows="3" required maxlength="500" placeholder="e.g. Received from supplier, used for treatment" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">{{ old('reason') }}</textarea>
                            </div>
                            <div class="flex flex-wrap justify-end gap-3 border-t border-gray-100 pt-5">
                                <a href="{{ route('inventory.show', $inventoryItem) }}" class="rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Cancel</a>
                                <button type="submit" class="rounded-xl bg-[#173f31] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#285b43]">Save Movement</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
