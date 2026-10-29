<section>
    <header>
        <h2 class="text-base font-semibold text-[#20392f]">Profile Information</h2>
        <p class="mt-1 text-sm text-[#3d8555]">
            Update your account's profile information, photo and email address.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- ── Profile photo ── --}}
        <div>
            <p class="text-sm font-semibold text-[#20392f]">Profile photo</p>

            <div class="mt-3 flex items-center gap-5">
                {{-- Live avatar preview --}}
                <div class="relative flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#e2eddd] text-xl font-bold text-[#32634d] ring-2 ring-[#c4dac8]">
                    @if (auth()->user()->profilePhotoUrl())
                        <img id="avatar-img"
                             src="{{ auth()->user()->profilePhotoUrl() }}"
                             alt="{{ auth()->user()->name }}"
                             class="h-full w-full object-cover">
                        <span id="avatar-initials" class="hidden">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    @else
                        <span id="avatar-initials">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <img id="avatar-img" src="" alt="" class="hidden h-full w-full object-cover">
                    @endif
                </div>

                <div class="flex flex-col gap-2">
                    <label for="profile_photo"
                           class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-[#d3e1d8] bg-white px-4 py-2 text-sm font-semibold text-[#20392f] shadow-sm transition hover:bg-[#f0f7f1]">
                        <svg class="h-4 w-4 text-[#3d8555]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        Upload photo
                        <input id="profile_photo" name="profile_photo" type="file"
                               accept="image/jpeg,image/png,image/webp"
                               class="sr-only"
                               onchange="previewPhoto(this)">
                    </label>
                    <p class="text-xs text-gray-400">JPG, PNG or WebP &middot; max 2 MB</p>

                    @if (auth()->user()->profilePhotoUrl())
                        <form method="post" action="{{ route('profile.photo.destroy') }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs font-medium text-red-500 hover:text-red-700 transition"
                                    onclick="return confirm('Remove your profile photo?')">
                                Remove photo
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            @error('profile_photo')
                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-[#20392f]">Name</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                   class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-2 focus:ring-[#3d8555]/20 @error('name') border-red-400 @enderror">
            @error('name')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-[#20392f]">Email</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email', $user->email) }}" required autocomplete="username"
                   class="mt-1.5 block w-full rounded-xl border border-[#d3e1d8] px-4 py-2.5 text-sm text-[#20392f] shadow-sm focus:border-[#3d8555] focus:outline-none focus:ring-2 focus:ring-[#3d8555]/20 @error('email') border-red-400 @enderror">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="mt-2 text-sm text-gray-800">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#123e31] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#205644] focus:outline-none focus:ring-2 focus:ring-[#3d8555] focus:ring-offset-2">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Save &amp; return to dashboard
            </button>
        </div>
    </form>
</section>

<script>
function previewPhoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        const img = document.getElementById('avatar-img');
        const initials = document.getElementById('avatar-initials');
        img.src = e.target.result;
        img.classList.remove('hidden');
        if (initials) initials.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
