@php
    $navigationLinks = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'key' => 'dashboard'],
        ['label' => 'Animal Management', 'route' => 'animals.index', 'key' => 'animals'],
        ['label' => 'Inventory', 'route' => 'inventory.index', 'key' => 'inventory'],
        ['label' => 'Milk Production', 'route' => 'milk-productions.index', 'key' => 'milk-productions'],
        ['label' => 'Sales Management', 'route' => 'sales.index', 'key' => 'sales'],
        ['label' => 'Breeding Management', 'route' => 'breedings.index', 'key' => 'breedings'],
        ['label' => 'Animal Health', 'route' => 'animal-health.index', 'key' => 'animal-health'],
        ['label' => 'Reports', 'route' => 'reports.index', 'key' => 'reports'],
    ];

    $administrationLinks = [
        ['label' => 'User Management', 'route' => 'user-management.index', 'key' => 'user-management'],
        ['label' => 'Staff & Activities', 'route' => 'staff-activities.index', 'key' => 'staff-activities'],
        ['label' => 'Settings', 'route' => 'settings.index', 'key' => 'settings'],
    ];
@endphp

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
        @foreach ($navigationLinks as $link)
            <a href="{{ route($link['route']) }}" @class([
                'flex items-center gap-3 rounded-lg px-3 py-3 transition',
                'border-l-4 border-amber-300 bg-[#285b43] font-semibold text-white' => $active === $link['key'],
                'text-green-100 hover:bg-white/10' => $active !== $link['key'],
            ])>
                @switch($link['key'])
                    @case('dashboard')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" rx="1" /><rect x="14" y="3" width="7" height="7" rx="1" /><rect x="3" y="14" width="7" height="7" rx="1" /><rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        @break
                    @case('animals')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="7" cy="7" r="2" /><circle cx="15" cy="5" r="2" /><circle cx="19" cy="10" r="1.7" /><path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z" /><path d="M16 15c.6-.6 1.4-1 2.3-1 1.5 0 2.7.9 2.7 2.2 0 .7-.6 1.3-1.3 1.3H17" />
                        </svg>
                        @break
                    @case('inventory')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="M3 8v9l9 5 9-5V8M12 13v9M7.5 5.5l9 5" />
                        </svg>
                        @break
                    @case('milk-productions')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9 3h6M10 3v4l-2 2v11h8V9l-2-2V3" /><path d="M8 10h8M10 14h4" />
                        </svg>
                        @break
                    @case('sales')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 3h14v18l-2-1.5L15 21l-3-1.5L9 21l-2-1.5L5 21V3Z" /><path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3 .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5" />
                        </svg>
                        @break
                    @case('breedings')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" />
                        </svg>
                        @break
                    @case('animal-health')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" /><path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2" />
                        </svg>
                        @break
                    @case('reports')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M3 3v18h18" /><path d="m7 14 4-4 3 3 6-7" /><path d="M16 6h4v4" />
                        </svg>
                        @break
                @endswitch
                {{ $link['label'] }}
            </a>
        @endforeach

        <p class="px-3 pb-2 pt-5 text-xs font-bold uppercase tracking-widest text-green-300">Administration</p>

        @foreach ($administrationLinks as $link)
            <a href="{{ route($link['route']) }}" @class([
                'flex items-center gap-3 rounded-lg px-3 py-3 transition',
                'border-l-4 border-amber-300 bg-[#285b43] font-semibold text-white' => $active === $link['key'],
                'text-green-100 hover:bg-white/10' => $active !== $link['key'],
            ])>
                @switch($link['key'])
                    @case('user-management')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="10" cy="7" r="4" /><path d="M20 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8" />
                        </svg>
                        @break
                    @case('staff-activities')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="5" y="4" width="14" height="17" rx="2" /><path d="M9 4.5V3h6v1.5M9 10h6M9 14h6M9 18h3" />
                        </svg>
                        @break
                    @case('settings')
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" /><path d="m19.4 15 .1.1a1.8 1.8 0 0 1-2.5 2.5l-.1-.1a1.8 1.8 0 0 0-3 .9v.2a1.8 1.8 0 0 1-3.6 0v-.2a1.8 1.8 0 0 0-3-.9l-.1.1a1.8 1.8 0 1 1-2.5-2.5l.1-.1a1.8 1.8 0 0 0-.9-3h-.2a1.8 1.8 0 0 1 0-3.6h.2a1.8 1.8 0 0 0 .9-3l-.1-.1a1.8 1.8 0 1 1 2.5-2.5l.1.1a1.8 1.8 0 0 0 3-.9v-.2a1.8 1.8 0 0 1 3.6 0v.2a1.8 1.8 0 0 0 3 .9l.1-.1a1.8 1.8 0 1 1 2.5 2.5l-.1.1a1.8 1.8 0 0 0 .9 3h.2a1.8 1.8 0 0 1 0 3.6h-.2a1.8 1.8 0 0 0-.9 3Z" />
                        </svg>
                        @break
                @endswitch
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="border-t border-white/15 px-6 py-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-green-200">Farm Management</p>
        <p class="mt-2 text-xs text-green-100/70">Dairy &amp; Beef Farm System</p>
    </div>
</aside>
