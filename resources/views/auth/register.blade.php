{{-- ═══════════════════════════════════════════
     REGISTER PAGE — Standalone auth layout
════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — BlogCMS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect fill='%230D9488' width='32' height='32' rx='8'/><text x='16' y='22' font-size='18' font-weight='900' text-anchor='middle' fill='white' font-family='Inter,sans-serif'>B</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="auth-page" style="padding: var(--sp-8) var(--sp-6); align-items: flex-start;">
    <div class="auth-container" style="max-width: 600px;">

        {{-- Logo --}}
        <div class="auth-logo">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                <rect width="32" height="32" rx="8" fill="#0D9488"/>
                <path d="M8 10h16M8 16h12M8 22h8" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
            BlogCMS
        </div>

        {{-- Header --}}
        <div class="auth-header">
            <h1>Create your account</h1>
            <p>Join our community and start publishing amazing content</p>
        </div>

        {{-- Alerts --}}
        @if($errors->any())
            <div class="alert alert-danger fade-slide-in">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div>
                    <strong>Please fix the following errors.</strong>
                    <ul style="margin-top:0.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Card --}}
        <div class="auth-card">
            <form method="POST" action="/register" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- ── Section: Account Credentials ── --}}
                <div style="margin-bottom: var(--sp-8);">
                    <h5 style="color:var(--clr-primary); margin-bottom:var(--sp-5); display:flex; align-items:center; gap:var(--sp-2);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Account Credentials
                    </h5>

                    {{-- Username --}}
                    <div class="form-group">
                        <label for="Username">Username <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('Username') ? 'is-invalid' : '' }}"
                            id="Username" name="Username" value="{{ old('Username') }}"
                            placeholder="Choose a unique username" maxlength="50" autocomplete="username" required>
                        <span class="form-hint">3–50 characters, unique across the platform</span>
                        @error('Username')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="Email">Email Address <span style="color:var(--clr-danger);">*</span></label>
                        <input type="email" class="form-control {{ $errors->has('Email') ? 'is-invalid' : '' }}"
                            id="Email" name="Email" value="{{ old('Email') }}"
                            placeholder="you@example.com" maxlength="100" autocomplete="email" required>
                        <span class="form-hint">Used for account recovery and notifications</span>
                        @error('Email')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password (side by side on wider screens) --}}
                    <div class="grid grid-cols-2 gap-md">
                        <div class="form-group">
                            <label for="password">Password <span style="color:var(--clr-danger);">*</span></label>
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                id="password" name="password" placeholder="Min 8 characters" required>
                            @error('password')
                                <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span style="color:var(--clr-danger);">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>

                {{-- ── Section: Personal Information ── --}}
                <div style="padding-top: var(--sp-6); border-top: 1px solid var(--clr-border); margin-bottom: var(--sp-8);">
                    <h5 style="color:var(--clr-primary); margin-bottom:var(--sp-5); display:flex; align-items:center; gap:var(--sp-2);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Personal Information
                    </h5>

                    {{-- Full Name --}}
                    <div class="form-group">
                        <label for="FullName">Full Name <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('FullName') ? 'is-invalid' : '' }}"
                            id="FullName" name="FullName" value="{{ old('FullName') }}"
                            placeholder="Your full name" maxlength="100" required>
                        @error('FullName')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bio --}}
                    <div class="form-group">
                        <label for="Bio">Bio <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea class="form-control {{ $errors->has('Bio') ? 'is-invalid' : '' }}"
                            id="Bio" name="Bio" rows="3" maxlength="5000"
                            placeholder="Tell us a bit about yourself...">{{ old('Bio') }}</textarea>
                        <span class="form-hint">Max 5000 characters</span>
                        @error('Bio')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Profile Picture --}}
                    <div class="form-group">
                        <label>Profile Picture <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="file" class="form-control {{ $errors->has('ProfilePictureFile') ? 'is-invalid' : '' }}"
                            id="ProfilePictureFile" name="ProfilePictureFile"
                            accept="image/jpeg,image/png,image/jpg,image/gif"
                            onchange="previewImage(this)">
                        @error('ProfilePictureFile')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror

                        <div class="auth-divider">or paste an image URL</div>

                        <input type="url" class="form-control {{ $errors->has('ProfilePictureUrl') ? 'is-invalid' : '' }}"
                            id="ProfilePictureUrl" name="ProfilePictureUrl"
                            value="{{ old('ProfilePictureUrl') }}"
                            placeholder="https://example.com/avatar.jpg" maxlength="255">
                        @error('ProfilePictureUrl')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror

                        {{-- Preview --}}
                        <div id="imagePreview" style="text-align:center; margin-top:var(--sp-4);"></div>
                    </div>
                </div>

                {{-- ── Section: Role ── --}}
                <div style="padding-top: var(--sp-6); border-top: 1px solid var(--clr-border); margin-bottom: var(--sp-6);">
                    <h5 style="color:var(--clr-primary); margin-bottom:var(--sp-5); display:flex; align-items:center; gap:var(--sp-2);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Account Role
                    </h5>

                    <div class="form-group">
                        <label for="role">Select Your Role <span style="color:var(--clr-danger);">*</span></label>
                        <select class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}"
                            id="role" name="role" required>
                            <option value="">— Choose a role —</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        <span class="form-hint"><strong>Author:</strong> Create &amp; manage posts &nbsp;·&nbsp; <strong>Editor:</strong> Edit &amp; review &nbsp;·&nbsp; <strong>Approver:</strong> Publish content</span>
                        @error('role')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Terms --}}
                <div style="background:var(--clr-surface-2); border:1px solid var(--clr-border); border-radius:var(--r-lg); padding:var(--sp-4); margin-bottom:var(--sp-6);">
                    <label style="display:flex; align-items:flex-start; gap:var(--sp-3); cursor:pointer; font-weight:400; margin-bottom:0; font-size:0.9rem; color:var(--clr-text-2);">
                        <input type="checkbox" id="terms" name="terms" required
                            style="width:16px;height:16px;margin-top:2px;border-radius:4px;cursor:pointer;flex-shrink:0; accent-color:var(--clr-primary);">
                        <span>
                            I agree to the <a href="#" style="color:var(--clr-primary);font-weight:600;">Terms of Service</a>
                            and <a href="#" style="color:var(--clr-primary);font-weight:600;">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    Create Account
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in here</a>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview"
                         style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--clr-primary);box-shadow:var(--shadow-md);">
                    <p class="text-xs" style="color:var(--clr-success);font-weight:600;margin-top:0.5rem;">✓ Image ready</p>`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>