<x-app-layout>
    <div class="min-h-screen bg-[#f3f5f1] text-[#20392f] lg:flex">

        {{-- ── Sidebar ── --}}
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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('animals.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="7" cy="7" r="2"/><circle cx="15" cy="5" r="2"/><circle cx="19" cy="10" r="1.7"/><path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z"/><path d="M16 15c.6-.6 1.4-1 2.3-1 1.5 0 2.7.9 2.7 2.2 0 .7-.6 1.3-1.3 1.3H17"/>
                    </svg>
                    Animal Management
                </a>
                <a href="{{ route('milk-productions.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 3h6M10 3v4l-2 2v11h8V9l-2-2V3"/><path d="M8 10h8M10 14h4"/>
                    </svg>
                    Milk Production
                </a>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 3h14v18l-2-1.5L15 21l-3-1.5L9 21l-2-1.5L5 21V3Z"/><path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3 .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5"/>
                    </svg>
                    Sales Management
                </a>
                <a href="{{ route('breedings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z"/>
                    </svg>
                    Breeding
                </a>
                <a href="{{ route('animal-health.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z"/><path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2"/>
                    </svg>
                    Animal Health
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="M3 8v9l9 5 9-5V8M12 13v9M7.5 5.5l9 5"/>
                    </svg>
                    Inventory
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 6-7"/><path d="M16 6h4v4"/>
                    </svg>
                    Reports
                </a>

                <p class="px-3 pb-2 pt-5 text-xs font-bold uppercase tracking-widest text-green-300">Administration</p>

                <a href="{{ route('user-management.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>
                    </svg>
                    User Management
                </a>
                <a href="{{ route('staff-activities.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5V3h6v1.5M9 10h6M9 14h6M9 18h3"/>
                    </svg>
                    Staff &amp; Activities
                </a>

                {{-- Settings — active --}}
                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 rounded-lg border-l-4 border-amber-300 bg-[#285b43] px-3 py-3 font-semibold text-white" aria-current="page">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z"/><path d="m19.4 15 .1.1a1.8 1.8 0 0 1-2.5 2.5l-.1-.1a1.8 1.8 0 0 0-3 .9v.2a1.8 1.8 0 0 1-3.6 0v-.2a1.8 1.8 0 0 0-3-.9l-.1.1a1.8 1.8 0 1 1-2.5-2.5l.1-.1a1.8 1.8 0 0 0-.9-3h-.2a1.8 1.8 0 0 1 0-3.6h.2a1.8 1.8 0 0 0 .9-3l-.1-.1a1.8 1.8 0 1 1 2.5-2.5l.1.1a1.8 1.8 0 0 0 3-.9v-.2a1.8 1.8 0 0 1 3.6 0v.2a1.8 1.8 0 0 0 3 .9l.1-.1a1.8 1.8 0 1 1 2.5 2.5l-.1.1a1.8 1.8 0 0 0 .9 3h.2a1.8 1.8 0 0 1 0 3.6h-.2a1.8 1.8 0 0 0-.9 3Z"/>
                    </svg>
                    Settings
                </a>
            </nav>

            <div class="border-t border-white/15 px-6 py-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-green-200">Farm Management</p>
                <p class="mt-2 text-xs text-green-100/70">Dairy &amp; Beef Farm System</p>
            </div>
        </aside>

        {{-- ── Main content ── --}}
        <div class="min-w-0 flex-1">

            {{-- Top header bar --}}
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ now()->format('l, d F Y') }}</span>
                    <button type="button" aria-label="Notifications" class="relative flex h-9 w-9 items-center justify-center rounded-full text-gray-500 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                        </svg>
                    </button>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 rounded-lg px-2 py-1 text-left transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e2eddd] font-bold text-[#32634d]">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </span>
                                <span class="hidden sm:block">
                                    <span class="block text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Farm User' }}</span>
                                    <span class="block text-xs text-gray-500">{{ auth()->user()->role ?? 'Team Leader' }}</span>
                                </span>
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/>
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

            {{-- Page body --}}
            <main class="min-h-screen bg-[#f4f7f3] px-5 py-8 text-[#173d31] sm:px-8">
                <div class="mx-auto max-w-6xl space-y-8">

                    {{-- Page heading --}}
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / Settings</p>
                        <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#20392f] sm:text-5xl">Settings</h1>
                        <p class="mt-2 text-base text-slate-500">Farm details and demonstration preferences.</p>
                    </div>

                    {{-- ── Row 1: Farm information + System preferences ── --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                        {{-- Farm information --}}
                        <section class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-7" aria-labelledby="farm-info-title">
                            <h2 id="farm-info-title" class="text-base font-semibold text-[#20392f]">Farm information</h2>

                            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="farm-name" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Farm name</label>
                                    <input id="farm-name" type="text" value="Bule Hora University Agricu" readonly
                                        class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                </div>
                                <div>
                                    <label for="location" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Location</label>
                                    <input id="location" type="text" value="Ethiopia" readonly
                                        class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                </div>
                                <div>
                                    <label for="farm-type" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Farm type</label>
                                    <input id="farm-type" type="text" value="Dairy and beef farm" readonly
                                        class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                </div>
                                <div>
                                    <label for="contact" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Contact placeholder</label>
                                    <input id="contact" type="text" placeholder="Add center contact later"
                                        class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] placeholder-gray-400 shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                </div>
                                <div>
                                    <label for="timezone" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Timezone</label>
                                    <input id="timezone" type="text" value="Africa/Nairobi" readonly
                                        class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                </div>
                                <div>
                                    <label for="currency" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Currency</label>
                                    <input id="currency" type="text" value="ETB" readonly
                                        class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                </div>
                            </div>

                            <button type="button" class="mt-6 inline-flex items-center justify-center rounded-xl bg-[#123e31] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                Apply in this session
                            </button>
                        </section>

                        {{-- System preferences --}}
                        <section class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-7" aria-labelledby="sys-pref-title">
                            <h2 id="sys-pref-title" class="text-base font-semibold text-[#20392f]">System preferences</h2>

                            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="date-format" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Date format</label>
                                    <select id="date-format" class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                        <option selected>DD MMM YYYY</option>
                                        <option>YYYY-MM-DD</option>
                                        <option>MM/DD/YYYY</option>
                                        <option>DD/MM/YYYY</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="units" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Units</label>
                                    <select id="units" class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                        <option selected>Liters and kilograms</option>
                                        <option>Gallons and pounds</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="report-period" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Default report period</label>
                                    <select id="report-period" class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                        <option>Daily</option>
                                        <option>Weekly</option>
                                        <option selected>Monthly</option>
                                        <option>Yearly</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="language" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Language placeholder</label>
                                    <select id="language" class="block w-full rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                        <option selected>English</option>
                                        <option>Amharic</option>
                                        <option>Afaan Oromoo</option>
                                    </select>
                                </div>
                            </div>

                            <label class="mt-5 flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" checked class="h-4 w-4 rounded border-[#d3e1d8] text-[#3d8555] accent-[#3d8555] focus:ring-[#3d8555]">
                                <span class="text-sm text-[#3d8555]">Show health and stock notifications in this demo</span>
                            </label>
                        </section>
                    </div>

                    {{-- ── Row 2: Users & roles + Backup & restore ── --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                        {{-- Users & roles --}}
                        <section class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-7" aria-labelledby="users-roles-title">
                            <h2 id="users-roles-title" class="text-base font-semibold text-[#20392f]">Users &amp; roles</h2>
                            <p class="mt-3 text-sm text-slate-500">Explore example roles and their permission matrix.</p>
                            <div class="mt-5">
                                <a href="{{ route('user-management.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#c4dac8] bg-[#f0f7f1] px-5 py-2.5 text-sm font-semibold text-[#20392f] transition hover:bg-[#e3f0e5] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                    Open User Management
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </section>

                        {{-- Backup & restore --}}
                        <section class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-7" aria-labelledby="backup-title">
                            <h2 id="backup-title" class="text-base font-semibold text-[#20392f]">Backup &amp; restore</h2>
                            <p class="mt-3 text-sm text-slate-500">
                                Automated backups require a future server. No backup exists in this session-only prototype.
                            </p>
                            <div class="mt-4">
                                <label for="backup-schedule" class="mb-1.5 block text-sm font-semibold text-[#20392f]">Suggested future schedule</label>
                                <select id="backup-schedule" class="block w-48 rounded-xl border border-[#d3e1d8] bg-white px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-1 focus:ring-[#3d8555]">
                                    <option selected>Daily</option>
                                    <option>Weekly</option>
                                    <option>Monthly</option>
                                </select>
                            </div>
                            <button type="button" disabled class="mt-4 inline-flex cursor-not-allowed items-center justify-center rounded-xl border border-[#d3e1d8] bg-white px-5 py-2.5 text-sm font-semibold text-gray-400 shadow-sm select-none">
                                Restore backup unavailable
                            </button>
                        </section>
                    </div>

                    {{-- ── Row 3: Audit log preview + Demonstration access ── --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                        {{-- Audit log preview --}}
                        <section class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-7" aria-labelledby="audit-log-title">
                            <h2 id="audit-log-title" class="text-base font-semibold text-[#20392f]">Audit log preview</h2>

                            <ul class="mt-4 space-y-3" role="list">
                                <li class="text-sm text-[#20392f]">
                                    {{ now()->subDays(2)->format('d M Y') }} &middot; Example: <span class="text-[#3d8555]">milk production reviewed</span>
                                </li>
                                <li class="text-sm text-[#20392f]">
                                    {{ now()->subDays(3)->format('d M Y') }} &middot; Example: <span class="text-[#3d8555]">inventory reorder flagged</span>
                                </li>
                            </ul>

                            <p class="mt-5 text-xs text-slate-400">Live audit logging requires server-side storage.</p>
                        </section>

                        {{-- Demonstration access --}}
                        <section class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-7" aria-labelledby="demo-access-title">
                            <h2 id="demo-access-title" class="text-base font-semibold text-[#20392f]">Demonstration access</h2>
                            <p class="mt-3 text-sm text-slate-500">
                                This academic preview opens without a login. Secure accounts, password resets and logout must be built in the future authenticated application.
                            </p>
                        </section>
                    </div>

                    {{-- Footer note --}}
                    <p class="pb-4 text-center text-xs text-slate-400">
                        Bule Hora University Agricultural Center &middot; Interactive academic prototype &middot; Changes reset on refresh.
                    </p>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
