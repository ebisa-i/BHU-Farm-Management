<x-guest-layout>
    <p class="auth-eyebrow">Account recovery</p>
    <h2 class="auth-heading">Reset your password</h2>
    <p class="auth-sub">
        Enter your email and we'll send you a reset link.
        Remember it? <a href="{{ route('login') }}" class="auth-link">Sign in &rarr;</a>
    </p>

    @if (session('status'))
        <div class="auth-status" style="margin-top:1.25rem;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" style="margin-top:1.75rem; display:flex; flex-direction:column; gap:1.1rem;">
        @csrf

        <div>
            <label for="email" class="auth-label">Email address</label>
            <input
                id="email" name="email" type="email"
                autocomplete="username" required autofocus
                value="{{ old('email') }}"
                placeholder="you@example.com"
                class="auth-input {{ $errors->has('email') ? 'auth-input-error' : '' }}"
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-btn" style="margin-top:0.25rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
            Send reset link
        </button>
    </form>

    <div style="margin-top:1.5rem; border-radius:0.75rem; border:1.5px solid #d6e4d8; background:#fff; padding:1rem 1.1rem; display:flex; align-items:flex-start; gap:0.65rem;">
        <svg style="flex-shrink:0; margin-top:1px; color:#3d8555;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
        </svg>
        <p style="font-size:0.78rem; color:#6b7f76; line-height:1.55;">
            If your email is registered, you'll receive a reset link within a few minutes. Check your spam folder if it doesn't arrive.
        </p>
    </div>
</x-guest-layout>
