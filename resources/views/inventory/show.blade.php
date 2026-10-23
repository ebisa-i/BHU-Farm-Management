<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'inventory'])
        <main class="min-w-0 flex-1">
            @include('inventory._page-header')
            <div class="space-y-7 p-5 sm:p-8">
                @if (session('success'))
                    <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">{{ session('success') }}</div>
                @endif

                <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <a href="{{ route('inventory.index') }}" class="text-sm font-semibold text-[#32634d] hover:text-[#173f31]">← Back to Inventory</a>
                        <p class="mt-5 text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Inventory Item / {{ $inventoryItem->sku }}</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">{{ $inventoryItem->name }}</h1>
                        <p class="mt-2 text-sm text-gray-600">{{ $inventoryItem->category }} · {{ $inventoryItem->supplier ?: 'Supplier not recorded' }}</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('inventory.edit', $inventoryItem) }}" class="rounded-xl border border-[#dce6d9] bg-white px-4 py-2.5 text-sm font-semibold text-[#285b43] transition hover:bg-[#f8faf7]">Edit details</a>
                        <a href="{{ route('inventory.movements.create', $inventoryItem) }}" class="rounded-xl bg-[#173f31] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#285b43]">Adjust stock</a>
                    </div>
                </section>

                <section aria-label="Item details" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold text-gray-600">Quantity on hand</p>
                        <p class="mt-4 text-3xl font-bold text-[#20392f]">{{ number_format((float) $inventoryItem->quantity, 2) }} <span class="text-base font-medium text-gray-500">{{ $inventoryItem->unit }}</span></p>
                    </article>
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold text-gray-600">Reorder level</p>
                        <p class="mt-4 text-3xl font-bold text-[#20392f]">{{ number_format((float) $inventoryItem->reorder_level, 2) }} <span class="text-base font-medium text-gray-500">{{ $inventoryItem->unit }}</span></p>
                    </article>
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold text-gray-600">Unit cost</p>
                        <p class="mt-4 text-3xl font-bold text-[#20392f]">{{ number_format((float) $inventoryItem->unit_cost, 2) }} <span class="text-base font-medium text-gray-500">ETB</span></p>
                    </article>
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold text-gray-600">Expiry date</p>
                        <p class="mt-4 text-2xl font-bold text-[#20392f]">{{ $inventoryItem->expiry_date?->format('d M Y') ?? 'Not recorded' }}</p>
                    </article>
                </section>

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 sm:px-6">
                        <div>
                            <h2 class="text-lg font-bold text-[#20392f]">Recent stock movements</h2>
                            <p class="mt-1 text-sm text-gray-500">An audit trail of recorded stock changes.</p>
                        </div>
                        <a href="{{ route('inventory-movements.index', ['item' => $inventoryItem->id]) }}" class="text-sm font-semibold text-[#32634d] hover:text-[#173f31]">View all history</a>
                    </div>
                    @if ($movements->isEmpty())
                        <p class="px-6 py-10 text-center text-sm text-gray-500">No stock movements have been recorded.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-[#f8faf7]">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Date</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Movement</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Change</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Balance</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Reason</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Recorded by</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($movements as $movement)
                                        <tr>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">{{ $movement->created_at->format('d M Y, H:i') }}</td>
                                            <td class="whitespace-nowrap px-5 py-4">
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $movement->movement_type === 'in' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                                    {{ $movement->movement_type === 'in' ? 'Stock in' : 'Stock out' }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold {{ $movement->movement_type === 'in' ? 'text-green-700' : 'text-orange-700' }}">
                                                {{ $movement->movement_type === 'in' ? '+' : '−' }}{{ number_format((float) $movement->quantity, 2) }} {{ $inventoryItem->unit }}
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">{{ number_format((float) $movement->quantity_after, 2) }} {{ $inventoryItem->unit }}</td>
                                            <td class="max-w-xs px-5 py-4 text-sm text-gray-700">{{ $movement->reason }}</td>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">{{ $movement->user?->name ?? 'System' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="border-t border-gray-100 px-5 py-4 sm:px-6">{{ $movements->links() }}</div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
