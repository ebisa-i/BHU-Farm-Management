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

<form action="{{ $isEditing ? route('inventory.update', $inventoryItem) : route('inventory.store') }}" method="POST" class="space-y-6">
    @csrf
    @if ($isEditing)
        @method('PUT')
    @endif

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="name" class="mb-1.5 block text-sm font-semibold text-gray-700">Item name *</label>
            <input id="name" name="name" type="text" value="{{ old('name', $inventoryItem->name ?? '') }}" required maxlength="255" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
        </div>
        <div>
            <label for="category" class="mb-1.5 block text-sm font-semibold text-gray-700">Category *</label>
            <input id="category" name="category" type="text" value="{{ old('category', $inventoryItem->category ?? '') }}" required maxlength="100" placeholder="e.g. Feed & nutrition, Veterinary medicine" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
        </div>
        <div>
            <label for="sku" class="mb-1.5 block text-sm font-semibold text-gray-700">SKU *</label>
            <input id="sku" name="sku" type="text" value="{{ old('sku', $inventoryItem->sku ?? '') }}" required maxlength="100" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
        </div>
        <div>
            <label for="unit" class="mb-1.5 block text-sm font-semibold text-gray-700">Unit *</label>
            <input id="unit" name="unit" type="text" value="{{ $isEditing && $unitLocked ? $inventoryItem->unit : old('unit', $inventoryItem->unit ?? '') }}" required maxlength="50" placeholder="e.g. bags, vials, kg" @if ($isEditing && $unitLocked) readonly @endif class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700 read-only:bg-gray-100 read-only:text-gray-500">
            @if ($isEditing && $unitLocked)
                <p class="mt-1.5 text-xs text-gray-500">The unit cannot change after stock movements are recorded.</p>
            @endif
        </div>
        @if ($isEditing)
            <div class="rounded-xl bg-[#f8faf7] p-4 sm:col-span-2">
                <p class="text-sm font-semibold text-gray-700">Current stock</p>
                <p class="mt-1 text-sm text-gray-600">{{ number_format((float) $inventoryItem->quantity, 2) }} {{ $inventoryItem->unit }}</p>
                <p class="mt-1 text-xs text-gray-500">Use Adjust stock to record quantity changes and keep the movement history accurate.</p>
            </div>
        @else
            <div>
                <label for="initial_quantity" class="mb-1.5 block text-sm font-semibold text-gray-700">Initial quantity *</label>
                <input id="initial_quantity" name="initial_quantity" type="number" value="{{ old('initial_quantity', '0') }}" required min="0" step="0.01" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
            </div>
        @endif
        <div>
            <label for="reorder_level" class="mb-1.5 block text-sm font-semibold text-gray-700">Reorder at *</label>
            <input id="reorder_level" name="reorder_level" type="number" value="{{ old('reorder_level', $inventoryItem->reorder_level ?? '0') }}" required min="0" step="0.01" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
        </div>
        <div>
            <label for="unit_cost" class="mb-1.5 block text-sm font-semibold text-gray-700">Unit cost (ETB) *</label>
            <input id="unit_cost" name="unit_cost" type="number" value="{{ old('unit_cost', $inventoryItem->unit_cost ?? '0') }}" required min="0" step="0.01" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
        </div>
        <div>
            <label for="expiry_date" class="mb-1.5 block text-sm font-semibold text-gray-700">Expiry date</label>
            <input id="expiry_date" name="expiry_date" type="date" value="{{ old('expiry_date', isset($inventoryItem) ? $inventoryItem->expiry_date?->toDateString() : '') }}" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
        </div>
        <div>
            <label for="supplier" class="mb-1.5 block text-sm font-semibold text-gray-700">Supplier</label>
            <input id="supplier" name="supplier" type="text" value="{{ old('supplier', $inventoryItem->supplier ?? '') }}" maxlength="255" class="w-full rounded-xl border-gray-200 focus:border-green-700 focus:ring-green-700">
        </div>
    </div>

    <div class="flex flex-wrap justify-end gap-3 border-t border-gray-100 pt-5">
        <a href="{{ isset($inventoryItem) ? route('inventory.show', $inventoryItem) : route('inventory.index') }}" class="rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Cancel</a>
        <button type="submit" class="rounded-xl bg-[#173f31] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
            {{ $isEditing ? 'Save Changes' : 'Add Inventory Item' }}
        </button>
    </div>
</form>
