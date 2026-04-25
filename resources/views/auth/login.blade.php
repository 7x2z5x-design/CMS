{{-- ═══════════════════════════════════════════
     LOGIN PAGE — Standalone auth layout
════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — BlogCMS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect fill='%230D9488' width='32' height='32' rx='8'/><text x='16' y='22' font-size='18' font-weight='900' text-anchor='middle' fill='white' font-family='Inter,sans-serif'>B</text></svg>">
    <link rel="stylesheet" href="{{ asset('css/admin-saas.css') }}">
</head>
<body>
<div class="auth-page" style="background-color: var(--bg-color);">

    <div class="auth-container">

        {{-- Logo --}}
        <div class="auth-logo" style="color: var(--primary); font-weight: 800; font-size: 2rem; letter-spacing: -1px;">
            <i class="ph-fill ph-circles-four" style="margin-right: 0.5rem; color: var(--accent);"></i>
            CMS Hub
        </div>



        {{-- Header --}}
        <div class="auth-header">
            <h1 style="color: var(--primary); font-weight: 900; letter-spacing: -0.5px;">Welcome Home</h1>
            <p style="color: var(--text-muted);">Ready to curate something amazing today?</p>
        </div>



        {{-- Alerts --}}
        @if($errors->any())
            <div class="alert alert-danger fade-slide-in">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div>
                    <strong>Login failed.</strong>
                    <ul style="margin-top:0.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success fade-slide-in">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                <div><strong>Success!</strong> {{ session('success') }}</div>
            </div>
        @endif

        {{-- Card --}}
        <div class="auth-card" style="background: var(--card-bg); border-color: var(--border-color);">
            <form method="POST" action="{{ route('login.post') }}" novalidate>

                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="Email">Email Address</label>
                    <input
                        type="email"
                        class="form-control {{ $errors->has('Email') ? 'is-invalid' : '' }}"
                        id="Email"
                        name="Email"
                        value="{{ old('Email') }}"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required>
                    @error('Email')
                        <div class="form-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div class="flex-between mb-sm">
                        <label for="password" style="margin-bottom:0;">Password</label>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs" style="color:var(--clr-primary); font-weight:600;">Forgot password?</a>
                        @endif
                    </div>
                    <input
                        type="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        id="password"
                        name="password"
                        placeholder="Your password"
                        autocomplete="current-password"
                        required>
                    @error('password')
                        <div class="form-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="form-group" style="margin-bottom: var(--sp-6);">
                    <label style="display:flex; align-items:center; gap:var(--sp-2); cursor:pointer; font-weight:400; margin-bottom:0; font-size:0.9rem; color:var(--clr-text-2);">
                        <input type="checkbox" name="remember" id="remember"
                            style="width:16px;height:16px;border-radius:4px; cursor:pointer; accent-color:var(--clr-primary);">
                        Keep me signed in
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-accent btn-block btn-lg" style="border-radius: var(--radius-lg); font-weight: 900; letter-spacing: 1px; py: 1rem; color: var(--primary);">
                    SIGN IN
                </button>


            </form>
        </div>

        {{-- Footer --}}
        <div class="auth-footer" style="font-size: 0.9rem; color: var(--clr-text-2);">
            Need an account? Please contact an administrator.
        </div>
    </div>
</div>
</body>
</html>