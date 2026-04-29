@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Modern Glassmorphism Profile Card -->
            <div class="profile-glass-card">
                <div class="profile-header">
                    <div class="profile-avatar-section">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" class="profile-avatar">
                        @else
                            <div class="profile-avatar-initials">
                                {{ $user->initials }}
                            </div>
                        @endif
                        <div class="profile-info">
                            <h2 class="profile-name">{{ $user->name }}</h2>
                            <span class="profile-role">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <a href="{{ route('author.profile.edit') }}" class="btn-edit-profile">
                            Edit Profile
                        </a>
                    </div>
                </div>

                <div class="profile-content-grid">
                    <div class="info-section">
                        <div class="section-header">
                            <svg class="section-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <h3 class="section-title">Contact Information</h3>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Email Address</label>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="section-header">
                            <svg class="section-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <h3 class="section-title">About</h3>
                        </div>
                        <div class="bio-content">
                            @if($user->bio)
                                <p>{{ $user->bio }}</p>
                            @else
                                <p class="text-muted">No bio added yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="section-header">
                            <svg class="section-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <h3 class="section-title">Account Details</h3>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <label class="info-label">Member Since</label>
                                <div class="info-value">{{ $user->created_at->format('F j, Y') }}</div>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Account Status</label>
                                <div class="info-value">
                                    <span class="status-badge status-{{ strtolower($user->status) }}">
                                        {{ $user->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Import modern font */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

* {
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

/* Main glassmorphism profile card */
.profile-glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2);
    padding: 40px;
    margin: 0 auto 32px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.profile-glass-card:hover {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Profile header */
.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    padding-bottom: 24px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.profile-avatar-section {
    display: flex;
    align-items: center;
    gap: 24px;
}

.profile-avatar {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(26, 158, 122, 0.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-avatar-initials {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a9e7a, #157347);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 700;
    border: 4px solid rgba(26, 158, 122, 0.1);
    box-shadow: 0 4px 12px rgba(26, 158, 122, 0.2);
}

.profile-info {
    flex: 1;
}

.profile-name {
    color: #111827;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
}

.profile-role {
    color: #6b7280;
    font-size: 16px;
    font-weight: 500;
    text-transform: capitalize;
}

.profile-actions {
    position: relative;
}

/* Edit Profile Button */
.btn-edit-profile {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    background: linear-gradient(135deg, #1a9e7a, #157347);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(26, 158, 122, 0.3);
}

.btn-edit-profile:hover {
    background: linear-gradient(135deg, #157347, #0f5f3a);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(26, 158, 122, 0.4);
}

/* Content Grid Layout */
.profile-content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 32px;
}

.info-section {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.info-section:hover {
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.section-icon {
    color: #1a9e7a;
    flex-shrink: 0;
}

.section-title {
    color: #111827;
    font-size: 18px;
    font-weight: 600;
    margin: 0;
}

.info-grid {
    display: grid;
    gap: 16px;
}

.info-item {
    background: rgba(255, 255, 255, 0.8);
    padding: 16px;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.info-item:hover {
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.info-label {
    color: #6b7280;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
}

.info-value {
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
}

.bio-content {
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    min-height: 80px;
}

.bio-content p {
    color: #374151;
    line-height: 1.6;
    margin: 0;
    font-size: 14px;
}

.text-muted {
    color: #9ca3af !important;
    font-style: italic;
}

/* Status badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 1px solid #6ee7b7;
}

.status-inactive {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.status-pending {
    background: linear-gradient(135deg, #fef3c7, #fed7aa);
    color: #92400e;
    border: 1px solid #fbbf24;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .profile-glass-card {
        padding: 24px;
        margin: 0 16px 24px;
        border-radius: 20px;
    }
    
    .profile-header {
        flex-direction: column;
        gap: 20px;
        align-items: flex-start;
    }
    
    .profile-avatar-section {
        gap: 16px;
    }
    
    .profile-avatar,
    .profile-avatar-initials {
        width: 80px;
        height: 80px;
        font-size: 24px;
    }
    
    .profile-name {
        font-size: 28px;
    }
    
    .profile-role {
        font-size: 14px;
    }
    
    .btn-edit-profile {
        width: 100%;
        justify-content: center;
    }
    
    .profile-content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .info-section {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .profile-glass-card {
        padding: 20px;
        margin: 0 12px 20px;
    }
    
    .profile-avatar-section {
        flex-direction: column;
        text-align: center;
        gap: 12px;
    }
    
    .profile-info {
        text-align: center;
    }
    
    .section-header {
        justify-content: center;
        text-align: center;
    }
}
</style>
@endpush
@endsection
