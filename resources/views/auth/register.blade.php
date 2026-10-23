<x-guest-layout>
    <p class="auth-eyebrow">Get started</p>
    <h2 class="auth-heading">Create your account</h2>
    <p class="auth-sub">
        Already have an account?
        <a href="{{ route('login') }}" class="auth-link">Sign in &rarr;</a>
    </p>

    <form method="POST" action="{{ route('register') }}" style="margin-top:1.75rem; display:flex; flex-direction:column; gap:1.1rem;">
        @csrf

        <div>
            <label for="name" class="auth-label">Full name</label>
            <input
                id="name" name="name" type="text"
                autocomplete="name" required autofocus
                value="{{ old('name') }}"
                placeholder="Your full name"
                class="auth-input {{ $errors->has('name') ? 'auth-input-error' : '' }}"
            >
            @error('name')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="auth-label">Email address</label>
            <input
                id="email" name="email" type="email"
                autocomplete="username" required
                value="{{ old('email') }}"
                placeholder="you@example.com"
                class="auth-input {{ $errors->has('email') ? 'auth-input-error' : '' }}"
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="auth-label">Password</label>
            <input
                id="password" name="password" type="password"
                autocomplete="new-password" required
                placeholder="Min. 8 characters"
                class="auth-input {{ $errors->has('password') ? 'auth-input-error' : '' }}"
            >
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="auth-label">Confirm password</label>
            <input
                id="password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" required
                placeholder="Re-enter your password"
                class="auth-input {{ $errors->has('password_confirmation') ? 'auth-input-error' : '' }}"
            >
            @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-btn" style="margin-top:0.25rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="19" y1="8" x2="19" y2="14"/>
                <line x1="22" y1="11" x2="16" y2="11"/>
            </svg>
            Create account
        </button>
    </form>
</x-guest-layout>
