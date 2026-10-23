<x-guest-layout>
    <p class="auth-eyebrow">Account recovery</p>
    <h2 class="auth-heading">Reset your password</h2>
    <p class="auth-sub">
        Enter your email and we'll send you a reset link.
        Remember it?
        <a href="{{ route('login') }}" class="auth-link">Sign in &rarr;</a>
    </p>

    @if (session('status'))
        <div style="margin-top:1.25rem; border-radius:0.75rem; border:1px solid #bbf7d0; background:#f0fdf4; padding:0.75rem 1rem; font-size:0.875rem; color:#166534;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" style="margin-top:2rem; display:flex; flex-direction:column; gap:1.25rem;">
        @csrf

        <div>
            <label for="email" class="auth-label">Email address</label>
            <input
                id="email"
                name="email"
                type="email"
                autocomplete="username"
                required
                autofocus
                value="{{ old('email') }}"
                placeholder="you@example.com"
                class="auth-input {{ $errors->has('email') ? 'auth-input-error' : '' }}"
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
            Send reset link
        </button>
    </form>

    <div class="auth-card" style="margin-top:1.5rem; display:flex; align-items:flex-start; gap:0.75rem;">
        <svg style="flex-shrink:0; margin-top:2px; color:#3d8555;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
        </svg>
        <p style="font-size:0.75rem; color:#64748b;">
            If your email is registered, you'll receive a reset link within a few minutes. Check your spam folder if it doesn't arrive.
        </p>
    </div>
</x-guest-layout>
