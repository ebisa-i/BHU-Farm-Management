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
                                <x-user-avatar />
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

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Sales Management</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Sale Record</h1>
                        <p class="mt-1 text-sm text-gray-600">{{ $sale->sale_number }}</p>
                    </div>
                    <a href="{{ route('sales.edit', $sale) }}"
                       class="rounded-xl bg-[#123e31] px-5 py-3 font-semibold text-white hover:bg-[#205644]">
                        Edit
                    </a>
                </div>

                <div class="rounded-2xl border border-[#dfe8e1] bg-white shadow-sm">
                    <div class="border-b border-[#dfe8e1] px-6 py-5">
                        <h2 class="font-semibold text-[#20392f]">Sale Details</h2>
                    </div>
                    <dl class="divide-y divide-[#f0f4f1]">
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Sale Number</dt>
                            <dd class="col-span-2 text-sm font-medium text-gray-900">{{ $sale->sale_number }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Sale Type</dt>
                            <dd class="col-span-2">
                                <span @class([
                                    'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-blue-100 text-blue-800' => $sale->sale_type === 'Animal',
                                    'bg-green-100 text-green-800' => $sale->sale_type === 'Milk',
                                ])>{{ $sale->sale_type === 'Animal' ? 'Cattle' : 'Milk' }}</span>
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Animal</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $sale->animal?->animal_id ?? '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Buyer Name</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $sale->buyer_name }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Buyer Phone</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $sale->buyer_phone ?: '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Item Description</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $sale->item_description }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ number_format((float) $sale->quantity, 2) }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Unit Price</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ number_format((float) $sale->unit_price, 2) }} ETB</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                            <dd class="col-span-2 text-sm font-semibold text-gray-900">{{ number_format((float) $sale->total_amount, 2) }} ETB</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Sale Date</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $sale->sale_date?->format('d M Y') ?? '—' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <dt class="text-sm font-medium text-gray-500">Notes</dt>
                            <dd class="col-span-2 text-sm text-gray-900">{{ $sale->notes ?: '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <a href="{{ route('sales.index') }}"
                       class="font-semibold text-green-700 hover:text-green-900">
                        &larr; Back to Sales Records
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
