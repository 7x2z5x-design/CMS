@extends('layouts.app')

@section('title', 'Editor Profile')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editor Profile</h2>
        <div class="text-muted">
            Manage your account information and security settings
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <i class="ph ph-user text-primary" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge bg-primary">{{ $user->role }}</span>
                    
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted d-block">
                            <i class="ph ph-calendar me-1"></i>
                            Member since {{ $user->created_at->format('M d, Y') }}
                        </small>
                        @if($user->updated_at->gt($user->created_at))
                        <small class="text-muted d-block mt-1">
                            <i class="ph ph-clock me-1"></i>
                            Last updated {{ $user->updated_at->format('M d, Y') }}
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Edit Profile Information</h5>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(40, 167, 69, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(40, 167, 69, 0.3); border-radius: 8px;">
                        <i class="ph ph-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('editor.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Personal Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Full Name</label>
                                    <input type="text" 
                                           class="form-control @error('name') ? 'is-invalid' : ''" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           required
                                           style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <input type="email" 
                                           class="form-control @error('email') ? 'is-invalid' : ''" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           required
                                           style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Change -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Change Password</h6>
                            <div class="alert alert-info" style="background: rgba(13, 202, 240, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(13, 202, 240, 0.3); border-radius: 8px;">
                                <i class="ph ph-info me-2"></i>
                                Leave password fields empty if you don't want to change your password.
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="current_password" class="form-label fw-semibold">Current Password</label>
                                    <input type="password" 
                                           class="form-control @error('current_password') ? 'is-invalid' : ''" 
                                           id="current_password" 
                                           name="current_password"
                                           style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                                    @error('current_password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="new_password" class="form-label fw-semibold">New Password</label>
                                    <input type="password" 
                                           class="form-control @error('new_password') ? 'is-invalid' : ''" 
                                           id="new_password" 
                                           name="new_password"
                                           style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                                    @error('new_password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                                    <input type="password" 
                                           class="form-control @error('new_password_confirmation') ? 'is-invalid' : ''" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation"
                                           style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Account Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Role</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-primary">{{ $user->role }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-success">
                                            {{ $user->status ?? 'Active' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('editor.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="ph ph-arrow-left me-2"></i>Back to Dashboard
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph ph-check me-2"></i>Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
