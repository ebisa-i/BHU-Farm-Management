<x-guest-layout>
    <p class="auth-eyebrow">Welcome back</p>
    <h2 class="auth-heading">Sign in to your account</h2>
    <p class="auth-sub">
        Don't have an account?
        <a href="{{ route('register') }}" class="auth-link">Create one &rarr;</a>
    </p>

    @if (session('status'))
        <div style="margin-top:1.25rem; border-radius:0.75rem; border:1px solid #bbf7d0; background:#f0fdf4; padding:0.75rem 1rem; font-size:0.875rem; color:#166534;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="margin-top:2rem; display:flex; flex-direction:column; gap:1.25rem;">
        @csrf

        {{-- Email --}}
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

        {{-- Password --}}
        <div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.375rem;">
                <label for="password" class="auth-label" style="margin-bottom:0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link" style="font-size:0.75rem;">Forgot password?</a>
                @endif
            </div>
            <input
                id="password" name="password" type="password"
                autocomplete="current-password" required
                placeholder="••••••••"
                class="auth-input {{ $errors->has('password') ? 'auth-input-error' : '' }}"
            >
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div style="display:flex; align-items:center; gap:0.625rem;">
            <input
                id="remember_me" name="remember" type="checkbox"
                style="width:1rem; height:1rem; border-radius:0.25rem; border:1px solid #d3e1d8; accent-color:#3d8555;"
            >
            <label for="remember_me" style="font-size:0.875rem; color:#475569;">Remember me for 30 days</label>
        </div>

        <button type="submit" class="auth-btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Sign in to Farm System
        </button>
    </form>

    {{-- Module hints --}}
    <div style="margin-top:2rem;">
        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
            <div class="auth-divider" style="flex:1;"></div>
            <span style="font-size:0.75rem; color:#94a3b8; white-space:nowrap;">System modules</span>
            <div class="auth-divider" style="flex:1;"></div>
        </div>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:0.5rem; text-align:center;">
            @foreach ([['🐄','Animals'],['🥛','Milk'],['📊','Reports']] as $mod)
                <div class="auth-card" style="padding:0.625rem;">
                    <span style="font-size:1.25rem;">{{ $mod[0] }}</span>
                    <p style="margin-top:0.25rem; font-size:0.7rem; font-weight:600; color:#648277;">{{ $mod[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-guest-layout>
