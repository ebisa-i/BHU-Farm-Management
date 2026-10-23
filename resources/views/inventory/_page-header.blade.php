<header class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:px-8">
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#66856f]">Bule Hora University · Ethiopia</p>
        <p class="mt-1 text-xs text-gray-500">Agricultural Center</p>
    </div>

    <div class="flex w-full flex-wrap items-center gap-4 sm:w-auto">
        <span class="hidden whitespace-nowrap text-sm text-gray-600 md:inline">{{ now()->format('l, d F Y') }}</span>
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center gap-2 rounded-full px-2 py-1 text-left transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e2eddd] font-bold text-[#32634d]">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                    <span class="hidden text-sm font-semibold text-gray-800 sm:inline">{{ auth()->user()->name ?? 'Farm User' }}</span>
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
