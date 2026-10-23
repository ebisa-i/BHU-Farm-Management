<x-app-layout>
    <div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">

        {{-- Sidebar --}}
        @include('layouts.farm-sidebar', ['active' => 'staff-activities'])

        {{-- Main content --}}
        <div class="min-w-0 flex-1">

            {{-- Top header bar --}}
            <header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
                    <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ now()->format('l, d F Y') }}</span>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 rounded-lg px-2 py-1 text-left transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e2eddd] font-bold text-[#32634d]">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </span>
                                <span class="hidden sm:block">
                                    <span class="block text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Farm User' }}</span>
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
                <div class="mx-auto max-w-3xl space-y-6">

                    {{-- Breadcrumb / heading --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / Staff &amp; Activities / View</p>
                            <h1 class="mt-3 text-3xl font-bold tracking-tight text-[#20392f]">Activity Detail</h1>
                        </div>
                        <a href="{{ route('staff-activities.index') }}"
                           class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#173d31] transition hover:bg-[#f8fbf8]">
                            &larr; Back
                        </a>
                    </div>

                    {{-- Detail card --}}
                    <div class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-8">
                        <dl class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Staff Member</dt>
                                <dd class="mt-1 text-sm font-medium text-[#20392f]">{{ $staffActivity->staff_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Role</dt>
                                <dd class="mt-1 text-sm text-[#20392f]">{{ $staffActivity->role }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Assignment</dt>
                                <dd class="mt-1 text-sm text-[#20392f]">{{ $staffActivity->assignment }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Shift</dt>
                                <dd class="mt-1 text-sm text-[#20392f]">{{ $staffActivity->shift }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Activity</dt>
                                <dd class="mt-1 text-sm text-[#20392f]">{{ $staffActivity->activity }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Activity Date</dt>
                                <dd class="mt-1 text-sm text-[#20392f]">{{ $staffActivity->activity_date->format('d M Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Status</dt>
                                <dd class="mt-1 text-sm text-[#20392f]">{{ $staffActivity->status }}</dd>
                            </div>
                            @if ($staffActivity->notes)
                            <div class="sm:col-span-2">
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#62776d]">Notes</dt>
                                <dd class="mt-1 text-sm text-[#20392f] whitespace-pre-line">{{ $staffActivity->notes }}</dd>
                            </div>
                            @endif
                        </dl>

                        <div class="mt-8 flex gap-3 border-t border-[#dfe8e1] pt-5">
                            <a href="{{ route('staff-activities.edit', $staffActivity) }}"
                               class="inline-flex items-center rounded-xl bg-[#123e31] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644]">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('staff-activities.destroy', $staffActivity) }}"
                                  onsubmit="return confirm('Delete this activity record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
