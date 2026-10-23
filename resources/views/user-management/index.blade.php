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
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1" /><rect x="14" y="3" width="7" height="7" rx="1" /><rect x="3" y="14" width="7" height="7" rx="1" /><rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>

                {{-- Animal Management --}}
                <a href="{{ route('animals.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="7" cy="7" r="2" /><circle cx="15" cy="5" r="2" /><circle cx="19" cy="10" r="1.7" /><path d="M5 15.5c0-2.1 2-3.5 4.5-3.5s4.5 1.4 4.5 3.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2Z" /><path d="M16 15c.6-.6 1.4-1 2.3-1 1.5 0 2.7.9 2.7 2.2 0 .7-.6 1.3-1.3 1.3H17" />
                    </svg>
                    Animal Management
                </a>

                {{-- Milk Production --}}
                <a href="{{ route('milk-productions.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 3h6M10 3v4l-2 2v11h8V9l-2-2V3" /><path d="M8 10h8M10 14h4" />
                    </svg>
                    Milk Production
                </a>

                {{-- Sales Management --}}
                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 3h14v18l-2-1.5L15 21l-3-1.5L9 21l-2-1.5L5 21V3Z" /><path d="M12 7v10M15 9.5c0-1-1.2-1.5-3-1.5s-3 .5-3 1.5 1.2 1.5 3 1.5 3 .5 3 1.5-1.2 1.5-3 1.5-3-.5-3-1.5" />
                    </svg>
                    Sales Management
                </a>

                {{-- Breeding --}}
                <a href="{{ route('breedings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" />
                    </svg>
                    Breeding
                </a>

                {{-- Animal Health --}}
                <a href="{{ route('animal-health.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.8 8.8c0 4.1-8.8 10-8.8 10s-8.8-5.9-8.8-10A4.8 4.8 0 0 1 12 6.2a4.8 4.8 0 0 1 8.8 2.6Z" /><path d="M7.5 12h2l1.3-2.2 2.4 4.4 1.3-2.2h2" />
                    </svg>
                    Animal Health
                </a>

                {{-- Inventory --}}
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="M3 8v9l9 5 9-5V8M12 13v9M7.5 5.5l9 5" />
                    </svg>
                    Inventory
                </a>

                {{-- Reports --}}
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3v18h18" /><path d="m7 14 4-4 3 3 6-7" /><path d="M16 6h4v4" />
                    </svg>
                    Reports
                </a>

                <p class="px-3 pb-2 pt-5 text-xs font-bold uppercase tracking-widest text-green-300">Administration</p>

                {{-- User Management — active --}}
                <a href="{{ route('user-management.index') }}" class="flex items-center gap-3 rounded-lg border-l-4 border-amber-300 bg-[#285b43] px-3 py-3 font-semibold text-white" aria-current="page">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="10" cy="7" r="4" /><path d="M20 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8" />
                    </svg>
                    User Management
                </a>

                {{-- Staff & Activities --}}
                <a href="{{ route('staff-activities.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="5" y="4" width="14" height="17" rx="2" /><path d="M9 4.5V3h6v1.5M9 10h6M9 14h6M9 18h3" />
                    </svg>
                    Staff &amp; Activities
                </a>

                {{-- Settings --}}
                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-3 text-green-100 transition hover:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" /><path d="m19.4 15 .1.1a1.8 1.8 0 0 1-2.5 2.5l-.1-.1a1.8 1.8 0 0 0-3 .9v.2a1.8 1.8 0 0 1-3.6 0v-.2a1.8 1.8 0 0 0-3-.9l-.1.1a1.8 1.8 0 1 1-2.5-2.5l.1-.1a1.8 1.8 0 0 0-.9-3h-.2a1.8 1.8 0 0 1 0-3.6h.2a1.8 1.8 0 0 0 .9-3l-.1-.1a1.8 1.8 0 1 1 2.5-2.5l.1.1a1.8 1.8 0 0 0 3-.9v-.2a1.8 1.8 0 0 1 3.6 0v.2a1.8 1.8 0 0 0 3 .9l.1-.1a1.8 1.8 0 1 1 2.5 2.5l-.1.1a1.8 1.8 0 0 0 .9 3h.2a1.8 1.8 0 0 1 0 3.6h-.2a1.8 1.8 0 0 0-.9 3Z" />
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

                    <button type="button" class="relative flex h-9 w-9 items-center justify-center rounded-full text-gray-500 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2" aria-label="Notifications">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" /><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
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
                <div class="mx-auto max-w-6xl">

                    {{-- Page heading + Add User button --}}
                    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / User Management</p>
                            <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#20392f] sm:text-5xl">User Management</h1>
                            <p class="mt-2 text-base text-slate-500">Preview roles and access rules for the future system.</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123e31] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Add User
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ── Permissions matrix card ── --}}
                    <section class="mb-6 overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm" aria-labelledby="permissions-title">
                        <div class="px-6 py-5 sm:px-8">
                            <h2 id="permissions-title" class="text-base font-semibold text-[#20392f]">Access and permissions preview</h2>
                            <p class="mt-1 text-sm text-[#3d8555]">
                                This demonstration does not enforce real authentication. User provisioning and password reset require a secure future backend.
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-y border-[#e8eee9]">
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Role</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">View</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Create</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Edit</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Approve</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Export</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Manage Users</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f1] text-[#20392f]">
                                    @php
                                        $permMatrix = [
                                            ['role' => 'System Administrator', 'view' => true,  'create' => true,  'edit' => true,  'approve' => true,  'export' => true,  'manage' => true],
                                            ['role' => 'Team Leader',          'view' => true,  'create' => true,  'edit' => true,  'approve' => true,  'export' => true,  'manage' => false],
                                            ['role' => 'Vocational Worker',    'view' => true,  'create' => true,  'edit' => true,  'approve' => false, 'export' => false, 'manage' => false],
                                            ['role' => 'Student/Researcher',   'view' => true,  'create' => false, 'edit' => false, 'approve' => false, 'export' => false, 'manage' => false],
                                            ['role' => 'University Management','view' => true,  'create' => false, 'edit' => false, 'approve' => true,  'export' => true,  'manage' => false],
                                        ];
                                    @endphp
                                    @foreach ($permMatrix as $row)
                                        <tr class="hover:bg-[#f8faf8]">
                                            <td class="px-6 py-4 font-medium text-[#20392f]">{{ $row['role'] }}</td>
                                            @foreach (['view','create','edit','approve','export','manage'] as $perm)
                                                <td class="px-6 py-4 text-[#3d8555]">
                                                    @if ($row[$perm])
                                                        <span aria-label="allowed">&#10003;</span>
                                                    @else
                                                        <span class="text-gray-400" aria-label="not allowed">&mdash;</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                    {{-- ── User records card ── --}}
                    <section class="overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm" aria-labelledby="users-table-title">
                        <div class="px-6 py-5 sm:px-8">
                            <h2 id="users-table-title" class="text-base font-semibold text-[#20392f]">User Management records</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $users->total() }} matching {{ Str::plural('record', $users->total()) }} &middot; click a heading to sort
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-y border-[#e8eee9]">
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Display name</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Username</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Role</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Status</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Last login</th>
                                        <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f1]">
                                    @php
                                        $demoRoles = ['System Administrator', 'Team Leader', 'Vocational Worker', 'Student/Researcher', 'University Management'];
                                    @endphp
                                    @forelse ($users as $user)
                                        @php
                                            // Derive a display username from email prefix
                                            $username = Str::before($user->email, '@');
                                            // Cycle roles for display purposes
                                            $role = $demoRoles[$loop->index % count($demoRoles)];
                                            // Treat the most recent user as inactive for variety
                                            $isActive = $loop->index !== ($users->count() - 1);
                                            $lastLogin = $user->updated_at?->format('d M Y') ?? $user->created_at?->format('d M Y') ?? '—';
                                        @endphp
                                        <tr class="hover:bg-[#f8faf8]">
                                            {{-- Display name --}}
                                            <td class="px-6 py-4 font-medium text-[#3d8555]">{{ $user->name }}</td>

                                            {{-- Username --}}
                                            <td class="px-6 py-4 text-[#3d8555]">{{ $username }}</td>

                                            {{-- Role --}}
                                            <td class="px-6 py-4 text-[#20392f]">{{ $role }}</td>

                                            {{-- Status badge --}}
                                            <td class="px-6 py-4">
                                                @if ($isActive)
                                                    <span class="inline-flex items-center rounded-full bg-[#e3f5e8] px-3 py-1 text-xs font-semibold text-[#2d7a46]">Active</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-[#fef3e2] px-3 py-1 text-xs font-semibold text-[#a16207]">Inactive</span>
                                                @endif
                                            </td>

                                            {{-- Last login --}}
                                            <td class="px-6 py-4 text-[#20392f]">{{ $lastLogin }}</td>

                                            {{-- Actions --}}
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    {{-- View --}}
                                                    <button type="button" title="View user" class="text-[#4a7c6a] transition hover:text-[#20392f] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1 rounded">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" /><circle cx="12" cy="12" r="3" />
                                                        </svg>
                                                        <span class="sr-only">View {{ $user->name }}</span>
                                                    </button>

                                                    {{-- Edit --}}
                                                    <button type="button" title="Edit user" class="text-[#4a7c6a] transition hover:text-[#20392f] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-1 rounded">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" /><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z" />
                                                        </svg>
                                                        <span class="sr-only">Edit {{ $user->name }}</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-500">
                                                No registered users found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination footer --}}
                        <div class="flex flex-col items-center justify-between gap-4 border-t border-[#e8eee9] px-6 py-5 sm:flex-row sm:px-8">
                            <p class="text-sm text-slate-500">
                                Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                            </p>
                            <div class="flex items-center gap-2">
                                @if ($users->onFirstPage())
                                    <span class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-gray-400 cursor-not-allowed select-none">Previous</span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}" class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#173d31] shadow-sm transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">Previous</a>
                                @endif

                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}" class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#173d31] shadow-sm transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">Next</a>
                                @else
                                    <span class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-gray-400 cursor-not-allowed select-none">Next</span>
                                @endif
                            </div>
                        </div>
                    </section>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
