<x-app-layout>
    <div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">

        @include('layouts.farm-sidebar', ['active' => ''])

        <div class="min-w-0 flex-1">

            {{-- Top header --}}
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ now()->format('l, d F Y') }}</span>
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

            {{-- Permission denied content --}}
            <main class="flex min-h-[calc(100vh-73px)] items-center justify-center px-5 py-16 sm:px-8">
                <div class="mx-auto max-w-lg text-center">

                    {{-- Icon --}}
                    <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-red-50 text-red-400">
                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M4.93 4.93l14.14 14.14"/>
                        </svg>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-2xl font-bold tracking-tight text-[#20392f] sm:text-3xl">
                        Access not allowed
                    </h1>

                    {{-- Role badge --}}
                    <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-[#dfe8e1] bg-white px-4 py-1.5">
                        <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                        <span class="text-sm font-semibold text-[#20392f]">{{ $role ?? auth()->user()->role ?? 'Your role' }}</span>
                    </div>

                    {{-- Message --}}
                    <p class="mt-4 text-base text-slate-500 leading-relaxed">
                        Your role does not have permission to
                        <strong class="text-[#20392f]">
                            @switch($permission ?? '')
                                @case('create') create new records @break
                                @case('edit') edit or delete records @break
                                @case('export') export data @break
                                @case('manage_users') manage users @break
                                @case('approve') approve records @break
                                @default perform this action @break
                            @endswitch
                        </strong>
                        in this system.
                    </p>

                    {{-- Permission table for the user's role --}}
                    @php
                        $userRole = $role ?? auth()->user()->role ?? 'Team Leader';
                        $userPerms = \App\Helpers\PermissionHelper::forRole($userRole);
                    @endphp

                    @if ($userPerms)
                        <div class="mt-6 overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white text-left shadow-sm">
                            <div class="border-b border-[#e8eee9] px-5 py-3">
                                <p class="text-xs font-bold uppercase tracking-wider text-[#648277]">Your permissions as {{ $userRole }}</p>
                            </div>
                            <div class="divide-y divide-[#f0f4f1]">
                                @foreach ($userPerms as $perm => $allowed)
                                    <div class="flex items-center justify-between px-5 py-3">
                                        <span class="text-sm text-[#20392f]">{{ $perm }}</span>
                                        @if ($allowed)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#e3f5e8] px-2.5 py-0.5 text-xs font-semibold text-[#2d7a46]">
                                                <svg class="h-3 w-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 6l3 3 5-5"/></svg>
                                                Allowed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-500">
                                                <svg class="h-3 w-3" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 2l8 8M10 2l-8 8"/></svg>
                                                Not allowed
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}"
                           class="inline-flex items-center gap-2 rounded-xl border border-[#d3e1d8] bg-white px-5 py-2.5 text-sm font-semibold text-[#173d31] shadow-sm transition hover:bg-[#f0f7f1]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                            Go back
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-[#123e31] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            Back to Dashboard
                        </a>
                    </div>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
