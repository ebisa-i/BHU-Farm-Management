<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'inventory'])
        <main class="min-w-0 flex-1">
            @include('inventory._page-header')
            <div class="space-y-7 p-5 sm:p-8">
                <section>
                    <a href="{{ route('inventory.index') }}" class="text-sm font-semibold text-[#32634d] hover:text-[#173f31]">← Back to Inventory</a>
                    <p class="mt-5 text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Inventory</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Movement History</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ $selectedItem ? 'Stock changes for '.$selectedItem->name : 'Audit trail of inventory received and used.' }}
                    </p>
                </section>

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
                        <h2 class="text-lg font-bold text-[#20392f]">Stock movements</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ $movements->total() }} {{ \Illuminate\Support\Str::plural('movement', $movements->total()) }} recorded</p>
                    </div>

                    @if ($movements->isEmpty())
                        <div class="px-6 py-12 text-center">
                            <h2 class="text-lg font-semibold text-gray-900">No movements recorded</h2>
                            <p class="mt-2 text-sm text-gray-500">Stock changes will appear here when an item is added or adjusted.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-[#f8faf7]">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Date</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Item</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Movement</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Quantity</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Balance</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Reason</th>
                                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Recorded by</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($movements as $movement)
                                        <tr class="transition hover:bg-[#f8faf7]">
                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">{{ $movement->created_at->format('d M Y, H:i') }}</td>
                                            <td class="whitespace-nowrap px-5 py-4">
                                                <a href="{{ route('inventory.show', $movement->inventoryItem) }}" class="font-semibold text-[#285b43] hover:underline">{{ $movement->inventoryItem->name }}</a>
                                                <p class="mt-1 text-xs text-gray-500">{{ $movement->inventoryItem->sku }}</p>
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4">
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $movement->movement_type === 'in' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">{{ $movement->movement_type === 'in' ? 'Stock in' : 'Stock out' }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold {{ $movement->movement_type === 'in' ? 'text-green-700' : 'text-orange-700' }}">{{ $movement->movement_type === 'in' ? '+' : '−' }}{{ number_format((float) $movement->quantity, 2) }} {{ $movement->inventoryItem->unit }}</td>
                                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">{{ number_format((float) $movement->quantity_before, 2) }} → {{ number_format((float) $movement->quantity_after, 2) }} {{ $movement->inventoryItem->unit }}</td>
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
