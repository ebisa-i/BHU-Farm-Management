<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'inventory'])

        <main class="min-w-0 flex-1">
            @include('inventory._page-header')

            <div class="space-y-7 p-5 sm:p-8">
                @if (session('success'))
                    <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Farm Supplies</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Inventory</h1>
                        <p class="mt-2 text-sm text-gray-600">Monitor farm supplies, stock levels, and expiry.</p>
                    </div>
                    @canDo('create')
                    <a href="{{ route('inventory.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#173f31] px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Add Item
                    </a>
                    @endCanDo
                </section>

                <section aria-label="Inventory statistics" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Total items</h2>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="M3 8v9l9 5 9-5V8M12 13v9" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold tracking-tight text-[#20392f]">{{ number_format($inventorySummary->total_items) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Catalogued products</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Low-stock items</h2>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M10.3 4.3 2.5 18a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3L13.7 4.3a2 2 0 0 0-3.4 0Z" /><path d="M12 9v4M12 17h.01" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold tracking-tight text-[#20392f]">{{ number_format($inventorySummary->low_stock_items) }}</p>
                        <p class="mt-1 text-sm text-gray-500">At or below reorder level</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Expiring medicines</h2>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2" /><path d="M16 3v4M8 3v4M3 10h18M12 13v4M10 15h4" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-3xl font-bold tracking-tight text-[#20392f]">{{ number_format($inventorySummary->expiring_medicines) }}</p>
                        <p class="mt-1 text-sm text-gray-500">Medicine expiring in the next 90 days</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Inventory value</h2>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="14" rx="2" /><path d="M3 9h18M16 14h2" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 break-words text-2xl font-bold tracking-tight text-[#20392f]">{{ number_format((float) $inventorySummary->inventory_value, 2) }} ETB</p>
                        <p class="mt-1 text-sm text-gray-500">Current quantity × unit cost</p>
                    </article>
                </section>

                <section class="flex flex-col gap-3 rounded-2xl border border-[#e2e9df] bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:px-5">
                    <label for="stock-filter" class="shrink-0 text-sm font-semibold text-gray-700">Stock filter</label>
                    <form action="{{ route('inventory.index') }}" method="GET" class="flex w-full flex-col gap-3 sm:flex-row sm:items-center">
                        <select id="stock-filter" name="stock" class="rounded-xl border-gray-200 bg-white text-sm focus:border-green-700 focus:ring-green-700 sm:w-56">
                            <option value="all" @selected($stock === 'all')>All items</option>
                            <option value="low" @selected($stock === 'low')>Low stock</option>
                            <option value="out" @selected($stock === 'out')>Out of stock</option>
                            <option value="expiring" @selected($stock === 'expiring')>Expiring in 90 days</option>
                            <option value="expired" @selected($stock === 'expired')>Expired</option>
                        </select>
                        <label for="inventory-search" class="sr-only">Search inventory</label>
                        <input id="inventory-search" name="search" type="search" value="{{ $search }}" placeholder="Search items, SKU, supplier..." class="min-w-0 rounded-xl border-gray-200 bg-white text-sm focus:border-green-700 focus:ring-green-700 sm:ml-auto sm:w-64">
                        <button type="submit" class="rounded-xl bg-[#173f31] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">Apply</button>
                    </form>
                </section>

                @if ($lowStockNames->isNotEmpty())
                    <p class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm text-amber-800">
                        <span class="font-semibold">Low stock:</span> {{ $lowStockNames->implode(', ') }}{{ $inventorySummary->low_stock_items > $lowStockNames->count() ? ', and more' : '' }}.
                    </p>
                @endif

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div>
                            <h2 class="text-lg font-bold text-[#20392f]">Inventory records</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ $items->total() }} matching {{ \Illuminate\Support\Str::plural('item', $items->total()) }} · click a heading to sort</p>
                        </div>
                        <a href="{{ route('inventory-movements.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#edf4e9] px-4 py-2.5 text-sm font-semibold text-[#285b43] transition hover:bg-[#dcebd6]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 12a9 9 0 1 0 2.6-6.4L3 8" /><path d="M3 3v5h5M12 7v5l3 2" />
                            </svg>
                            Movement history
                        </a>
                    </div>

                    @if ($items->isEmpty())
                        <div class="px-6 py-14 text-center">
                            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="M3 8v9l9 5 9-5V8M12 13v9" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $search !== '' || $stock !== 'all' ? 'No matching inventory items' : 'No inventory items yet' }}</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $search !== '' || $stock !== 'all' ? 'Try a different search or stock filter.' : 'Add farm supplies to start tracking stock and expiry dates.' }}</p>
                            @if ($search === '' && $stock === 'all')
                                @canDo('create')
                                <a href="{{ route('inventory.create') }}" class="mt-5 inline-flex items-center rounded-xl bg-[#173f31] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#285b43]">Add First Item</a>
                                @endCanDo
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-[#f8faf7]">
                                    <tr>
                                        @foreach ([
                                            'name' => 'Item',
                                            'category' => 'Category',
                                            'sku' => 'SKU',
                                            'quantity' => 'Quantity',
                                            'reorder_level' => 'Reorder at',
                                            'expiry_date' => 'Expiry',
                                            'supplier' => 'Supplier',
                                        ] as $column => $label)
                                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                                <a href="{{ route('inventory.index', [
                                                    'search' => $search ?: null,
                                                    'stock' => $stock !== 'all' ? $stock : null,
                                                    'sort' => $column,
                                                    'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
                                                ]) }}" class="inline-flex items-center gap-1.5 hover:text-[#173f31]">
                                                    {{ $label }}
                                                    @if ($sort === $column)
                                                        <span aria-label="{{ $direction === 'asc' ? 'ascending' : 'descending' }}">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                                    @endif
                                                </a>
                                            </th>
                                        @endforeach
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($items as $item)
                                        @php
                                            $isExpired = $item->expiry_date && $item->expiry_date->lt(today());
                                            $isExpiring = $item->expiry_date
                                                && $item->expiry_date->gte(today())
                                                && $item->expiry_date->lte(today()->addDays(90));
                                            $isOutOfStock = (float) $item->quantity === 0.0;
                                            $isLowStock = (float) $item->quantity <= (float) $item->reorder_level;
                                            [$statusLabel, $statusClass] = match (true) {
                                                $isExpired => ['Expired', 'bg-red-100 text-red-800'],
                                                $isOutOfStock => ['Out of stock', 'bg-gray-100 text-gray-800'],
                                                $isLowStock => ['Low stock', 'bg-amber-100 text-amber-800'],
                                                $isExpiring => ['Expiring', 'bg-orange-100 text-orange-800'],
                                                default => ['In stock', 'bg-green-100 text-green-800'],
                                            };
                                        @endphp
                                        <tr class="transition hover:bg-[#f8faf7]">
                                            <td class="whitespace-nowrap px-4 py-4">
                                                <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                                <p class="mt-1 text-xs text-gray-500">{{ number_format((float) $item->unit_cost, 2) }} ETB / {{ $item->unit }}</p>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">{{ $item->category }}</td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">{{ $item->sku }}</td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-gray-800">{{ number_format((float) $item->quantity, 2) }} <span class="font-normal text-gray-500">{{ $item->unit }}</span></td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">{{ number_format((float) $item->reorder_level, 2) }} {{ $item->unit }}</td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm {{ $isExpired ? 'font-semibold text-red-700' : 'text-gray-700' }}">{{ $item->expiry_date?->format('d M Y') ?? '—' }}</td>
                                            <td class="max-w-40 px-4 py-4 text-sm text-gray-700">{{ $item->supplier ?: '—' }}</td>
                                            <td class="whitespace-nowrap px-4 py-4">
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4">
                                                <div class="flex justify-end gap-1">
                                                    <a href="{{ route('inventory.show', $item) }}" aria-label="View {{ $item->name }}" title="View item" class="rounded-lg p-2 text-[#32634d] transition hover:bg-[#edf4e9] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" /><circle cx="12" cy="12" r="3" />
                                                        </svg>
                                                    </a>
                                                    @canDo('edit')
                                                    <a href="{{ route('inventory.edit', $item) }}" aria-label="Edit {{ $item->name }}" title="Edit item" class="rounded-lg p-2 text-[#32634d] transition hover:bg-[#edf4e9] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="m16 5 3 3M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z" />
                                                        </svg>
                                                    </a>
                                                    @endCanDo
                                                    @canDo('create')
                                                    <a href="{{ route('inventory.movements.create', $item) }}" aria-label="Adjust stock for {{ $item->name }}" title="Adjust stock" class="rounded-lg p-2 text-[#32634d] transition hover:bg-[#edf4e9] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="M3 8v9l9 5 9-5V8M12 13v9M19 3v6M16 6h6" />
                                                        </svg>
                                                    </a>
                                                    @endCanDo
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="border-t border-gray-100 px-5 py-4 sm:px-6">
                            {{ $items->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
