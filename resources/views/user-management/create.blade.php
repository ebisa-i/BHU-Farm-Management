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

            <main class="px-5 py-8 sm:px-8">
                <div class="mx-auto max-w-2xl">
                    <div class="mb-6">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#648277]">Agricultural Center / User Management</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#20392f]">Add New User</h1>
                        <p class="mt-1 text-sm text-slate-500">Create a new account for a farm system user.</p>
                    </div>

                    @if (session('error'))
                        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-800">{{ session('error') }}</div>
                    @endif

                    <div class="rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm sm:p-8">
                        <form method="POST" action="{{ route('user-management.store') }}" class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-[#20392f]">Full name</label>
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                        class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:ring-green-600 @error('name') border-red-400 @enderror">
                                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-[#20392f]">Email address</label>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                        class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:ring-green-600 @error('email') border-red-400 @enderror">
                                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-semibold text-[#20392f]">Role</label>
                                    <select id="role" name="role" required
                                        class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:ring-green-600">
                                        <option value="">Select role…</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-semibold text-[#20392f]">Status</label>
                                    <select id="status" name="status" required
                                        class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:ring-green-600">
                                        <option value="Active" @selected(old('status', 'Active') === 'Active')>Active</option>
                                        <option value="Inactive" @selected(old('status') === 'Inactive')>Inactive</option>
                                    </select>
                                    @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-semibold text-[#20392f]">Password</label>
                                    <input id="password" name="password" type="password" required
                                        class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:ring-green-600 @error('password') border-red-400 @enderror"
                                        placeholder="Min. 8 characters">
                                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-[#20392f]">Confirm password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required
                                        class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm focus:border-green-600 focus:ring-green-600"
                                        placeholder="Re-enter password">
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-2">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#123e31] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    Create user
                                </button>
                                <a href="{{ route('user-management.index') }}" class="rounded-xl border border-[#d3e1d8] bg-white px-5 py-2.5 text-sm font-semibold text-[#173d31] transition hover:bg-[#f8fbf8]">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
