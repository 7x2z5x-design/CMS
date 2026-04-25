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
    <link rel="stylesheet" href="{{ asset('css/admin-saas.css') }}">
</head>
<body>
<div class="auth-page" style="padding: var(--sp-8) var(--sp-6); align-items: flex-start; background-color: var(--bg-color);">
    <div class="auth-container" style="max-width: 600px;">


        {{-- Logo --}}
        <div class="auth-logo" style="color: var(--primary); font-weight: 800; font-size: 2rem; letter-spacing: -1px;">
            <i class="ph-fill ph-circles-four" style="margin-right: 0.5rem; color: var(--accent);"></i>
            CMS Hub
        </div>



        {{-- Header --}}
        <div class="auth-header">
            <h1 style="color: var(--primary); font-weight: 900; letter-spacing: -1px;">Join the Hub</h1>
            <p style="color: var(--text-muted);">Become part of a elite circle of creators and curators.</p>
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
        <div class="auth-card" style="background: var(--card-bg); border-color: var(--border-color);">

            <form method="POST" action="{{ route('register.post') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label" style="font-weight: 500; font-size: 0.9rem; color: var(--clr-text-1);">Role</label>
                    <select class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}" id="role" name="role" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--clr-border); border-radius: 0.5rem;">
                        <option value="" disabled selected>Select a Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                @if($role == 'Admin') Admin (Master Controller)
                                @elseif($role == 'Editor') Editor (Full Management)
                                @elseif($role == 'Publisher') Publisher (Quality Control)
                                @elseif($role == 'Author') Author (Content Creator)
                                @else Viewer (Read Only View)
                                @endif
                            </option>
                        @endforeach

                    </select>
                    @error('role')
                        <div class="form-error" style="color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-accent btn-block btn-lg" style="border-radius: var(--radius-lg); font-weight: 900; letter-spacing: 1px; color: var(--primary);">
                    GET STARTED
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