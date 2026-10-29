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
                                <x-user-avatar />
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
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / Staff &amp; Activities / Edit Activity</p>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight text-[#20392f]">Edit Staff Activity</h1>
                        <p class="mt-2 text-sm text-slate-500">Update the assignment or activity details for this staff member.</p>
                    </div>

                    {{-- Flash messages --}}
                    @if (session('success'))
                        <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                            <p class="mb-2 font-semibold">Please fix the following errors:</p>
                            <ul class="list-inside list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form card --}}
                    <div class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-8">
                        <form action="{{ route('staff-activities.update', $staffActivity) }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid gap-5 sm:grid-cols-2">
                                {{-- Staff Name --}}
                                <div>
                                    <label for="staff_name" class="mb-1 block text-sm font-medium text-[#20392f]">Staff Member Name <span class="text-red-600">*</span></label>
                                    <input type="text" name="staff_name" id="staff_name"
                                           value="{{ old('staff_name', $staffActivity->staff_name) }}"
                                           required
                                           placeholder="e.g. John Doe"
                                           class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                                </div>

                                {{-- Role --}}
                                <div>
                                    <label for="role" class="mb-1 block text-sm font-medium text-[#20392f]">Role <span class="text-red-600">*</span></label>
                                    <select name="role" id="role" required
                                            class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                                        <option value="">-- Select Role --</option>
                                        @foreach (['Veterinarian', 'Technician', 'Vocational Worker', 'Team Leader', 'Other'] as $r)
                                            <option value="{{ $r }}" @selected(old('role', $staffActivity->role) === $r)>{{ $r }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                {{-- Assignment --}}
                                <div>
                                    <label for="assignment" class="mb-1 block text-sm font-medium text-[#20392f]">Assignment <span class="text-red-600">*</span></label>
                                    <input type="text" name="assignment" id="assignment"
                                           value="{{ old('assignment', $staffActivity->assignment) }}"
                                           required
                                           placeholder="e.g. Dairy A, Breeding unit"
                                           class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                                </div>

                                {{-- Shift --}}
                                <div>
                                    <label for="shift" class="mb-1 block text-sm font-medium text-[#20392f]">Shift <span class="text-red-600">*</span></label>
                                    <input type="text" name="shift" id="shift"
                                           value="{{ old('shift', $staffActivity->shift) }}"
                                           required
                                           placeholder="e.g. 06:00–14:00"
                                           class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                                </div>
                            </div>

                            {{-- Activity --}}
                            <div>
                                <label for="activity" class="mb-1 block text-sm font-medium text-[#20392f]">Activity <span class="text-red-600">*</span></label>
                                <input type="text" name="activity" id="activity"
                                       value="{{ old('activity', $staffActivity->activity) }}"
                                       required
                                       placeholder="e.g. Morning milking, Pregnancy checks"
                                       class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                {{-- Status --}}
                                <div>
                                    <label for="status" class="mb-1 block text-sm font-medium text-[#20392f]">Status <span class="text-red-600">*</span></label>
                                    <select name="status" id="status" required
                                            class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                                        @foreach (['Scheduled', 'In Progress', 'Completed', 'Cancelled'] as $s)
                                            <option value="{{ $s }}" @selected(old('status', $staffActivity->status) === $s)>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Activity Date --}}
                                <div>
                                    <label for="activity_date" class="mb-1 block text-sm font-medium text-[#20392f]">Activity Date <span class="text-red-600">*</span></label>
                                    <input type="date" name="activity_date" id="activity_date"
                                           value="{{ old('activity_date', $staffActivity->activity_date->format('Y-m-d')) }}"
                                           required
                                           class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div>
                                <label for="notes" class="mb-1 block text-sm font-medium text-[#20392f]">Notes</label>
                                <textarea name="notes" id="notes" rows="4"
                                          placeholder="Any additional details or observations…"
                                          class="w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">{{ old('notes', $staffActivity->notes) }}</textarea>
                            </div>

                            {{-- Actions --}}
                            <div class="flex justify-end gap-3 border-t border-[#dfe8e1] pt-5">
                                <a href="{{ route('staff-activities.index') }}"
                                   class="inline-flex items-center rounded-xl border border-[#d3e1d8] bg-white px-5 py-2.5 text-sm font-semibold text-[#173d31] transition hover:bg-[#f8fbf8] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center rounded-xl bg-[#123e31] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                    Update Activity
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
