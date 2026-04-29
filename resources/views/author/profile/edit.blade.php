@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Edit Profile Card with Glassmorphism -->
            <div class="profile-card glassmorphism-card">
                <div class="profile-header">
                    <h2 class="profile-title">Edit Profile</h2>
                    <a href="{{ route('author.profile.show') }}" class="btn btn-outline-secondary">
                        <i class="ph ph-arrow-left"></i> Back to Profile
                    </a>
                </div>

                <div class="profile-body">
                    @if(session('success'))
                        <div class="alert alert-success fade-slide-in">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            <div><strong>Success!</strong> {{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('author.profile.update') }}" enctype="multipart/form-data" class="profile-form">
                        @csrf
                        @method('PUT')

                        <!-- Profile Photo Section -->
                        <div class="profile-section">
                            <h3 class="section-title">Profile Photo</h3>
                            <div class="photo-upload-section">
                                <div class="current-photo">
                                    @if($user->profile_photo)
                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Current Profile" class="current-avatar">
                                    @else
                                        <div class="current-avatar-placeholder">
                                            {{ $user->initials }}
                                        </div>
                                    @endif
                                </div>
                                <div class="upload-controls">
                                    <label for="profile_photo" class="upload-btn">
                                        <i class="ph ph-upload"></i> Choose New Photo
                                    </label>
                                    <input type="file" id="profile_photo" name="profile_photo" class="file-input" accept="image/*">
                                    <small class="form-text text-muted">JPEG, PNG, GIF up to 2MB</small>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information Section -->
                        <div class="profile-section">
                            <h3 class="section-title">Personal Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Bio Section -->
                        <div class="profile-section">
                            <h3 class="section-title">About Me</h3>
                            <div class="form-group">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea id="bio" name="bio" class="form-control" rows="5" 
                                          placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                <small class="form-text text-muted">Maximum 1000 characters</small>
                                @error('bio')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="ph ph-check"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.profile-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.profile-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.profile-section {
    margin-bottom: 2rem;
}

.section-title {
    color: white;
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.photo-upload-section {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.current-photo {
    flex-shrink: 0;
}

.current-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255, 255, 255, 0.2);
}

.current-avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a9e7a, #158765);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    border: 3px solid rgba(255, 255, 255, 0.2);
}

.upload-controls {
    flex: 1;
}

.upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: rgba(26, 158, 122, 0.2);
    color: #1a9e7a;
    border: 1px solid rgba(26, 158, 122, 0.3);
    border-radius: 10px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.upload-btn:hover {
    background: rgba(26, 158, 122, 0.3);
    border-color: #1a9e7a;
}

.file-input {
    display: none;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: white;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #1a9e7a;
    background: rgba(255, 255, 255, 0.08);
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.form-text {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

.text-danger {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    justify-content: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-lg {
    padding: 0.875rem 2rem;
    font-size: 1.125rem;
}

.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #22c55e;
}

.text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
}
</style>
@endpush
@endsection
