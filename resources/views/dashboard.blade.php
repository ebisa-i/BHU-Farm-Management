<x-app-layout>
    @php
        $totalAnimals = \App\Models\Animal::count();
        $dairyCows = \App\Models\Animal::where('animal_type', 'Dairy')->count();
        $beefCattle = \App\Models\Animal::where('animal_type', 'Beef')->count();
        $calves = \App\Models\Animal::where('animal_type', 'Calf')->count();
        $totalSales = \App\Models\Sale::count();
        $totalRevenue = \App\Models\Sale::sum('total_amount');
        $milkRecords = \App\Models\MilkProduction::count();
        $healthRecords = \App\Models\AnimalHealth::count();

        $metrics = [
            ['label' => 'Total Animals', 'value' => number_format($totalAnimals), 'detail' => 'Registered livestock', 'icon' => 'LIVESTOCK', 'route' => 'animals.index'],
            ['label' => 'Dairy Cows', 'value' => number_format($dairyCows), 'detail' => 'Dairy livestock', 'icon' => 'DAIRY', 'route' => 'animals.index'],
            ['label' => 'Beef Cattle', 'value' => number_format($beefCattle), 'detail' => 'Beef livestock', 'icon' => 'BEEF', 'route' => 'animals.index'],
            ['label' => 'Calves', 'value' => number_format($calves), 'detail' => 'Young livestock', 'icon' => 'CALVES', 'route' => 'animals.index'],
            ['label' => 'Total Sales', 'value' => number_format($totalSales), 'detail' => 'Recorded transactions', 'icon' => 'SALES', 'route' => 'sales.index'],
            ['label' => 'Total Revenue', 'value' => number_format((float) $totalRevenue, 2).' ETB', 'detail' => 'Recorded sales revenue', 'icon' => 'REVENUE', 'route' => 'sales.index'],
            ['label' => 'Milk Production', 'value' => number_format($milkRecords), 'detail' => 'Production records', 'icon' => 'MILK', 'route' => 'milk-productions.index'],
            ['label' => 'Animal Health', 'value' => number_format($healthRecords), 'detail' => 'Health and treatment records', 'icon' => 'HEALTH', 'route' => 'animal-health.index'],
        ];

        $modules = [
            ['name' => 'Animal Management', 'description' => 'Register animals and maintain livestock records.', 'route' => 'animals.index', 'icon' => 'A'],
            ['name' => 'Inventory', 'description' => 'Track farm supplies, stock levels, and expiry dates.', 'route' => 'inventory.index', 'icon' => 'I'],
            ['name' => 'Milk Production', 'description' => 'Record and review daily milk production.', 'route' => 'milk-productions.index', 'icon' => 'M'],
            ['name' => 'Sales Management', 'description' => 'Record sales and review farm revenue.', 'route' => 'sales.index', 'icon' => 'S'],
            ['name' => 'Breeding Management', 'description' => 'Track breeding activity and outcomes.', 'route' => 'breedings.index', 'icon' => 'B'],
            ['name' => 'Animal Health', 'description' => 'Maintain treatment and health records.', 'route' => 'animal-health.index', 'icon' => 'H'],
            ['name' => 'Reports', 'description' => 'Review farm performance and records.', 'route' => 'reports.index', 'icon' => 'R'],
            ['name' => 'User Management', 'description' => 'View registered users of the system.', 'route' => 'user-management.index', 'icon' => 'U'],
            ['name' => 'Staff & Activities', 'description' => 'Review staff activity records.', 'route' => 'staff-activities.index', 'icon' => 'T'],
            ['name' => 'Settings', 'description' => 'Manage farm system settings.', 'route' => 'settings.index', 'icon' => 'C'],
        ];
    @endphp

    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">
        <aside class="hidden w-64 shrink-0 flex-col bg-[#10352a] text-white lg:flex">
            <div class="border-b border-white/10 px-6 py-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full border border-white/40 text-xs font-bold tracking-wide">
                        BHU
                    </div>
                    <div>
                        <p class="text-sm font-bold leading-5">Bule Hora University</p>
                        <p class="mt-1 text-xs text-green-200">Agricultural Center</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg border-l-4 border-amber-300 bg-[#285b43] px-3 py-3 font-semibold text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('animals.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="7" cy="7" r="2" />
                        <circle cx="15" cy="5" r="2" />
                        <circle cx="19" cy="10" r="1.7" />
                        <path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z" />
                        <path d="M16 15c.6-.6 1.4-1 2.3-1 1.5 0 2.7.9 2.7 2.2 0 .7-.6 1.3-1.3 1.3H17" />
                    </svg>
                    Animal Management
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m12 3 9 5-9 5-9-5 9-5Z" />
                        <path d="M3 8v9l9 5 9-5V8M12 13v9" />
                    </svg>
                    Inventory
                </a>
                <a href="{{ route('milk-productions.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 3h6M10 3v4l-2 2v11h8V9l-2-2V3" />
                        <path d="M8 10h8M10 14h4" />
                    </svg>
                    Milk Production
                </a>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 3h14v18l-2-1.5L15 21l-3-1.5L9 21l-2-1.5L5 21V3Z" />
                        <path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3  .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5" />
                    </svg>
                    Sales Management
                </a>
                <a href="{{ route('breedings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" />
                    </svg>
                    Breeding Management
                </a>
                <a href="{{ route('animal-health.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" />
                        <path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2" />
                    </svg>
                    Animal Health
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3v18h18" />
                        <path d="m7 14 4-4 3 3 6-7" />
                        <path d="M16 6h4v4" />
                    </svg>
                    Reports
                </a>

                <p class="px-3 pb-2 pt-5 text-xs font-bold uppercase tracking-widest text-green-300">Administration</p>
                <a href="{{ route('user-management.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="10" cy="7" r="4" />
                        <path d="M20 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8" />
                    </svg>
                    User Management
                </a>
                <a href="{{ route('staff-activities.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="5" y="4" width="14" height="17" rx="2" />
                        <path d="M9 4.5V3h6v1.5M9 10h6M9 14h6M9 18h3" />
                    </svg>
                    Staff &amp; Activities
                </a>
                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" />
                        <path d="m19.4 15 .1.1a1.8 1.8 0 0 1-2.5 2.5l-.1-.1a1.8 1.8 0 0 0-3 .9v.2a1.8 1.8 0 0 1-3.6 0v-.2a1.8 1.8 0 0 0-3-.9l-.1.1a1.8 1.8 0 1 1-2.5-2.5l.1-.1a1.8 1.8 0 0 0-.9-3h-.2a1.8 1.8 0 0 1 0-3.6h.2a1.8 1.8 0 0 0 .9-3l-.1-.1a1.8 1.8 0 1 1 2.5-2.5l.1.1a1.8 1.8 0 0 0 3-.9v-.2a1.8 1.8 0 0 1 3.6 0v.2a1.8 1.8 0 0 0 3 .9l.1-.1a1.8 1.8 0 1 1 2.5 2.5l-.1.1a1.8 1.8 0 0 0 .9 3h.2a1.8 1.8 0 0 1 0 3.6h-.2a1.8 1.8 0 0 0-.9 3Z" />
                    </svg>
                    Settings
                </a>
            </nav>

            <div class="border-t border-white/15 px-6 py-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-green-200">Farm Management</p>
                <p class="mt-2 text-xs text-green-100/70">Dairy &amp; Beef Farm System</p>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>

                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ now()->format('D, d M Y') }}</span>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 rounded-lg px-2 py-1 text-left transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e2eddd] font-bold text-[#32634d]">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </span>
                                <span class="hidden sm:block">
                                    <span class="block text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Farm User' }}</span>
                                    <span class="block text-xs text-gray-500">Farm Management</span>
                                </span>
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

            <div class="space-y-8 p-5 sm:p-8">
                <section>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#66856f]">Agricultural Center / Dashboard</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f] sm:text-4xl">Dashboard</h1>
                    <p class="mt-2 text-sm text-gray-600">Your farm at a glance, with the work that matters today.</p>
                </section>

                <section class="overflow-hidden rounded-2xl bg-[#173f31] shadow-lg">
                    <div class="flex flex-col gap-6 p-6 sm:p-9 md:flex-row md:items-center md:justify-between">
                        <div class="max-w-2xl">
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#f3d994]">Farm status · Management overview</p>
                            <h2 class="mt-4 text-2xl font-bold text-white sm:text-3xl">
                                Welcome, {{ auth()->user()->name ?? 'Farm Team' }}!
                            </h2>
                            <p class="mt-3 text-sm leading-6 text-green-50">
                                Manage livestock, monitor milk production, record animal health, and review farm performance.
                            </p>
                        </div>
                        <a href="{{ route('animals.index') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-[#f0d28c] px-5 py-3 text-sm font-bold text-[#173f31] transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#173f31]">
                            Manage Animals <span class="ml-2" aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </section>

                <section aria-label="Farm statistics" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($metrics as $metric)
                        <a href="{{ route($metric['route']) }}" class="group rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#b8cbb9] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-gray-600">{{ $metric['label'] }}</p>
                                <span class="rounded-md bg-[#edf4e9] px-2 py-1 text-[10px] font-bold tracking-wider text-[#32634d]">{{ $metric['icon'] }}</span>
                            </div>
                            <p class="mt-4 break-words text-3xl font-bold tracking-tight text-[#20392f]">{{ $metric['value'] }}</p>
                            <p class="mt-2 text-xs text-gray-500">{{ $metric['detail'] }}</p>
                        </a>
                    @endforeach
                </section>

                <section>
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-[#20392f]">Farm management modules</h2>
                        <p class="mt-1 text-sm text-gray-600">Choose a module to manage your farm operations.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($modules as $module)
                            <a href="{{ route($module['route']) }}" class="group rounded-2xl border border-[#e2e9df] bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#b8cbb9] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <div class="flex items-start gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#edf4e9] text-sm font-bold text-[#285b43] transition group-hover:bg-[#dcebd6]">{{ $module['icon'] }}</span>
                                    <span>
                                        <span class="block font-semibold text-[#20392f]">{{ $module['name'] }}</span>
                                        <span class="mt-1 block text-sm leading-5 text-gray-600">{{ $module['description'] }}</span>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
