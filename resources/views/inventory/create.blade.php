<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        @include('layouts.farm-sidebar', ['active' => 'inventory'])
        <main class="min-w-0 flex-1">
            @include('inventory._page-header')
            <div class="p-5 sm:p-8">
                <div class="mx-auto max-w-4xl space-y-6">
                    <section>
                        <a href="{{ route('inventory.index') }}" class="text-sm font-semibold text-[#32634d] hover:text-[#173f31]">← Back to Inventory</a>
                        <p class="mt-5 text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Inventory</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Add Inventory Item</h1>
                        <p class="mt-2 text-sm text-gray-600">Register a supply, set its reorder level, and record its current stock.</p>
                    </section>

                    <section class="rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm sm:p-7">
                        @include('inventory._form', ['isEditing' => false])
                    </section>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
