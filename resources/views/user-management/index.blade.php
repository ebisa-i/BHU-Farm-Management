<x-app-layout>
    <div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">

        @include('layouts.farm-sidebar', ['active' => 'user-management'])

        <div class="min-w-0 flex-1">
            {{-- Top header --}}
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ now()->format('l, d F Y') }}</span>
                    <button type="button" aria-label="Notifications" class="flex h-9 w-9 items-center justify-center rounded-full text-gray-500 transition hover:bg-gray-100">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    </button>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 rounded-lg px-2 py-1 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <x-user-avatar />
                                <span class="hidden sm:block">
                                    <span class="block text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</span>
                                    <span class="block text-xs text-gray-500">{{ auth()->user()->role ?? 'Team Leader' }}</span>
                                </span>
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">Log Out</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <main class="min-h-screen bg-[#f4f7f3] px-5 py-8 sm:px-8">
                <div class="mx-auto max-w-6xl">

                    {{-- Page heading --}}
                    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / User Management</p>
                            <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#20392f] sm:text-5xl">User Management</h1>
                            <p class="mt-2 text-base text-slate-500">Manage farm system accounts, roles and access.</p>
                        </div>
                        @canDo('manage_users')
                        <a href="{{ route('user-management.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123e31] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                            Add User
                        </a>
                        @endCanDo
                    </div>

                    {{-- Flash messages --}}
                    @if (session('success'))
                        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-800">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-800">{{ session('error') }}</div>
                    @endif

                    {{-- Stats row --}}
                    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-[#dfe8e1] bg-white p-5 shadow-sm">
                            <p class="text-sm font-semibold text-[#62766d]">Total users</p>
                            <p class="mt-3 text-4xl font-bold text-[#20392f]">{{ $totalUsers }}</p>
                        </div>
                        <div class="rounded-2xl border border-[#dfe8e1] bg-white p-5 shadow-sm">
                            <p class="text-sm font-semibold text-[#62766d]">Active users</p>
                            <p class="mt-3 text-4xl font-bold text-[#20392f]">{{ $activeUsers }}</p>
                        </div>
                        <div class="rounded-2xl border border-[#dfe8e1] bg-white p-5 shadow-sm">
                            <p class="text-sm font-semibold text-[#62766d]">Inactive users</p>
                            <p class="mt-3 text-4xl font-bold text-[#20392f]">{{ $totalUsers - $activeUsers }}</p>
                        </div>
                    </div>

                    {{-- Permissions matrix --}}
                    <section class="mb-6 overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm">
                        <div class="px-6 py-5 sm:px-8">
                            <h2 class="text-base font-semibold text-[#20392f]">Access and permissions preview</h2>
                            <p class="mt-1 text-sm text-[#3d8555]">This demonstration does not enforce real authentication. User provisioning and password reset require a secure backend.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-y border-[#e8eee9]">
                                        @foreach (['Role','View','Create','Edit','Approve','Export','Manage Users'] as $col)
                                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f1]">
                                    @php
                                        $matrix = [
                                            ['System Administrator', true,  true,  true,  true,  true,  true],
                                            ['Team Leader',          true,  true,  true,  true,  true,  false],
                                            ['Vocational Worker',    true,  true,  true,  false, false, false],
                                            ['Student/Researcher',   true,  false, false, false, false, false],
                                            ['University Management',true,  false, false, true,  true,  false],
                                        ];
                                    @endphp
                                    @foreach ($matrix as [$role, $v, $c, $e, $a, $ex, $m])
                                        <tr class="hover:bg-[#f8faf8]">
                                            <td class="px-6 py-3 font-medium text-[#20392f]">{{ $role }}</td>
                                            @foreach ([$v,$c,$e,$a,$ex,$m] as $allowed)
                                                <td class="px-6 py-3 {{ $allowed ? 'text-[#3d8555]' : 'text-gray-300' }}">{{ $allowed ? '✓' : '—' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                    {{-- Users table --}}
                    <section class="overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm">
                        <div class="px-6 py-5 sm:px-8">
                            <h2 class="text-base font-semibold text-[#20392f]">User Management records</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $users->total() }} {{ Str::plural('record', $users->total()) }}</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-y border-[#e8eee9]">
                                        @foreach (['Display name','Username','Role','Status','Last login','Actions'] as $col)
                                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-widest text-[#62776d]">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f1]">
                                    @forelse ($users as $user)
                                        <tr class="hover:bg-[#f8faf8]">
                                            <td class="px-6 py-4 font-medium text-[#20392f]">{{ $user->name }}</td>
                                            <td class="px-6 py-4 text-[#3d8555]">{{ Str::before($user->email, '@') }}</td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $user->role }}</td>
                                            <td class="px-6 py-4">
                                                @if ($user->status === 'Active')
                                                    <span class="inline-flex items-center rounded-full bg-[#e3f5e8] px-3 py-1 text-xs font-semibold text-[#2d7a46]">Active</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-[#fef3e2] px-3 py-1 text-xs font-semibold text-[#a16207]">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-[#20392f]">{{ $user->updated_at?->format('d M Y') ?? '—' }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @canDo('manage_users')
                                                    <a href="{{ route('user-management.edit', $user) }}" title="Edit" class="text-[#4a7c6a] transition hover:text-[#20392f]">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z"/></svg>
                                                        <span class="sr-only">Edit {{ $user->name }}</span>
                                                    </a>
                                                    @if ($user->id !== auth()->id())
                                                        <form method="POST" action="{{ route('user-management.destroy', $user) }}" onsubmit="return confirm('Delete {{ addslashes($user->name) }}?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" title="Delete" class="text-red-400 transition hover:text-red-600">
                                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                                                <span class="sr-only">Delete {{ $user->name }}</span>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span title="Cannot delete own account" class="text-gray-300 cursor-not-allowed">
                                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                                        </span>
                                                    @endif
                                                    @endCanDo
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-500">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="flex flex-col items-center justify-between gap-4 border-t border-[#e8eee9] px-6 py-5 sm:flex-row sm:px-8">
                            <p class="text-sm text-slate-500">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</p>
                            <div class="flex items-center gap-2">
                                @if ($users->onFirstPage())
                                    <span class="cursor-not-allowed rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-gray-400 select-none">Previous</span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}" class="rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#173d31] transition hover:bg-[#f8fbf8]">Previous</a>
                                @endif
                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}" class="rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#173d31] transition hover:bg-[#f8fbf8]">Next</a>
                                @else
                                    <span class="cursor-not-allowed rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-gray-400 select-none">Next</span>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
