<x-guest-layout>
    <p class="auth-eyebrow">Account recovery</p>
    <h2 class="auth-heading">Choose a new password</h2>
    <p class="auth-sub">Enter your email and a strong new password below.</p>

    <form method="POST" action="{{ route('password.store') }}" style="margin-top:1.75rem; display:flex; flex-direction:column; gap:1.1rem;">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="auth-label">Email address</label>
            <input
                id="email" name="email" type="email"
                autocomplete="username" required autofocus
                value="{{ old('email', $request->email) }}"
                placeholder="you@example.com"
                class="auth-input {{ $errors->has('email') ? 'auth-input-error' : '' }}"
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="auth-label">New password</label>
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
            <label for="password_confirmation" class="auth-label">Confirm new password</label>
            <input
                id="password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" required
                placeholder="Re-enter your new password"
                class="auth-input {{ $errors->has('password_confirmation') ? 'auth-input-error' : '' }}"
            >
            @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-btn" style="margin-top:0.25rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Reset password
        </button>
    </form>
</x-guest-layout>
