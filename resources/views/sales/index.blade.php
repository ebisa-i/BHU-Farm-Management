<x-app-layout>
    @php
        $sortUrl = fn (string $column): string => route('sales.index', [
            'type' => $type,
            'search' => $search ?: null,
            'sort' => $column,
            'direction' => $sort === $column && $direction === 'asc' ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'sales'])

        <main class="min-w-0 flex-1">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>

                <div class="flex w-full flex-wrap items-center gap-4 sm:w-auto">
                    <form action="{{ route('sales.index') }}" method="GET" class="min-w-0 flex-1 sm:w-64 sm:flex-none">
                        <input type="hidden" name="type" value="{{ $type }}">
                        @if ($sort !== 'date' || $direction !== 'desc')
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="direction" value="{{ $direction }}">
                        @endif
                        <label for="sales-search" class="sr-only">Search sales</label>
                        <div class="flex items-center gap-2 rounded-xl bg-[#f3f6f2] px-3 py-2.5 text-gray-500 focus-within:ring-2 focus-within:ring-green-700">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m20 20-4-4" />
                            </svg>
                            <input id="sales-search" name="search" type="search" value="{{ $search }}" placeholder="Search this screen..." class="w-full border-0 bg-transparent p-0 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-0">
                        </div>
                    </form>

                    <span class="hidden whitespace-nowrap text-sm text-gray-600 md:inline">{{ now()->format('l, d F Y') }}</span>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 rounded-full px-2 py-1 text-left transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e2eddd] font-bold text-[#32634d]">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </span>
                                <span class="hidden text-sm font-semibold text-gray-800 sm:inline">{{ auth()->user()->name ?? 'Farm User' }}</span>
                                <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                                </svg>
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

            <div class="space-y-6 p-5 sm:space-y-8 sm:p-8">
                @if (session('success'))
                    <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Sales Management</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Sales Management</h1>
                        <p class="mt-2 text-sm text-gray-600">Review milk and cattle sales in Ethiopian birr.</p>
                    </div>
                    @canDo('create')
                    <a href="{{ route('sales.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#173f31] px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-[#285b43] focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Add Sale
                    </a>
                    @endCanDo
                </section>

                <nav aria-label="Sale type" class="inline-flex rounded-xl border border-[#e2e9df] bg-white p-1">
                    <a href="{{ route('sales.index', ['type' => 'Milk']) }}" @class([
                        'rounded-lg px-4 py-2.5 text-sm font-semibold transition',
                        'bg-[#173f31] text-white shadow-sm' => $type === 'Milk',
                        'text-gray-600 hover:bg-[#f3f5f1]' => $type !== 'Milk',
                    ]) @if ($type === 'Milk') aria-current="page" @endif>
                        Milk Sales
                    </a>
                    <a href="{{ route('sales.index', ['type' => 'Animal']) }}" @class([
                        'rounded-lg px-4 py-2.5 text-sm font-semibold transition',
                        'bg-[#173f31] text-white shadow-sm' => $type === 'Animal',
                        'text-gray-600 hover:bg-[#f3f5f1]' => $type !== 'Animal',
                    ]) @if ($type === 'Animal') aria-current="page" @endif>
                        Cattle Sales
                    </a>
                </nav>

                <section aria-label="Sales summary" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Monthly revenue</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="6" width="18" height="14" rx="2" />
                                    <path d="M16 14h2M3 10h18M7 6V4h10v2" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 break-words text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">{{ number_format($monthlyRevenue, 2) }} ETB</p>
                        <p class="mt-2 text-sm text-gray-500">{{ now()->format('F Y') }} · {{ $type === 'Milk' ? 'milk sales' : 'cattle sales' }}</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Sales in view</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 3h14v18l-2-1.5L15 21l-3-1.5L9 21l-2-1.5L5 21V3Z" />
                                    <path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3 .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 text-4xl font-bold tracking-tight text-[#20392f]">{{ number_format($sales->total()) }}</p>
                        <p class="mt-2 text-sm text-gray-500">Matching {{ $type === 'Milk' ? 'milk' : 'cattle' }} sale records</p>
                    </article>

                    <article class="rounded-2xl border border-[#e2e9df] bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-sm font-semibold text-gray-600">Average sale value</h2>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf4e9] text-[#32634d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3 .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-5 break-words text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">{{ number_format($averageSaleValue, 2) }} ETB</p>
                        <p class="mt-2 text-sm text-gray-500">Average for {{ now()->format('F') }}</p>
                    </article>
                </section>

                <section class="overflow-hidden rounded-2xl border border-[#e2e9df] bg-white shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 px-6 py-5">
                        <div>
                            <h2 class="font-semibold text-[#20392f]">Sales management records</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ number_format($sales->total()) }} matching {{ \Illuminate\Support\Str::plural('record', $sales->total()) }} · click a heading to sort
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1050px] text-left text-sm">
                            <thead class="bg-[#f7f9f6] text-xs font-semibold uppercase tracking-wider text-gray-600">
                                <tr>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('sale_number') }}">Sale no.</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('date') }}">Date</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('customer') }}">Customer</a></th>
                                    <th scope="col" class="px-5 py-4"><a class="hover:text-[#173f31]" href="{{ $sortUrl('product') }}">Product / animal</a></th>
                                    <th scope="col" class="px-5 py-4 text-right"><a class="hover:text-[#173f31]" href="{{ $sortUrl('quantity') }}">Quantity</a></th>
                                    <th scope="col" class="px-5 py-4 text-right"><a class="hover:text-[#173f31]" href="{{ $sortUrl('unit_price') }}">Unit price (ETB)</a></th>
                                    <th scope="col" class="px-5 py-4 text-right"><a class="hover:text-[#173f31]" href="{{ $sortUrl('total') }}">Total (ETB)</a></th>
                                    <th scope="col" class="px-5 py-4">Sale type</th>
                                    <th scope="col" class="px-5 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($sales as $sale)
                                    <tr class="transition hover:bg-[#fafcf9]">
                                        <td class="whitespace-nowrap px-5 py-4 font-medium text-[#20392f]">{{ $sale->sale_number }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-gray-700">{{ $sale->sale_date?->format('Y-m-d') ?? '—' }}</td>
                                        <td class="px-5 py-4 text-gray-700">
                                            {{ $sale->buyer_name }}
                                            @if ($sale->buyer_phone)
                                                <span class="mt-1 block text-xs text-gray-500">{{ $sale->buyer_phone }}</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            {{ $sale->item_description }}
                                            @if ($sale->animal)
                                                <span class="mt-1 block text-xs text-gray-500">Animal ID: {{ $sale->animal->animal_id }}</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right text-gray-700">{{ number_format((float) $sale->quantity, 2) }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right text-gray-700">{{ number_format((float) $sale->unit_price, 2) }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right font-semibold text-[#20392f]">{{ number_format((float) $sale->total_amount, 2) }} ETB</td>
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <span @class([
                                                'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                                'bg-blue-100 text-blue-800' => $sale->sale_type === 'Animal',
                                                'bg-green-100 text-green-800' => $sale->sale_type === 'Milk',
                                            ])>{{ $sale->sale_type === 'Animal' ? 'Cattle' : 'Milk' }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right">
                                            <a href="{{ route('sales.show', $sale) }}" aria-label="View sale {{ $sale->sale_number }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </a>
                                            @canDo('edit')
                                            <a href="{{ route('sales.edit', $sale) }}" aria-label="Edit sale {{ $sale->sale_number }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-[#edf4e9] hover:text-[#173f31] focus:outline-none focus:ring-2 focus:ring-green-700">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z" />
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('sales.destroy', $sale) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" aria-label="Delete sale {{ $sale->sale_number }}" class="inline-flex rounded-lg p-2 text-gray-600 transition hover:bg-red-50 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <polyline points="3 6 5 6 21 6" />
                                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                        <path d="M10 11v6M14 11v6" />
                                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endCanDo
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <p class="font-semibold text-gray-700">{{ $search ? 'No sales match your search.' : 'No '.strtolower($type === 'Milk' ? 'milk' : 'cattle').' sales have been recorded yet.' }}</p>
                                            @canDo('create')
                                            <a href="{{ route('sales.create') }}" class="mt-2 inline-block text-sm font-semibold text-green-800 underline">Add a sale</a>
                                            @endCanDo
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($sales->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">
                            {{ $sales->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
