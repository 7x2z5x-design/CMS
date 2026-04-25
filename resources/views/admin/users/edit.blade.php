@extends('admin.layout')
@section('title', 'Edit User')

@section('content')
<div class="content-header">
    <h1 class="page-title">Edit User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">
        <i class="ph ph-arrow-left"></i> Back to Users
    </a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Update User Details</h3>
        <div class="avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
            {{ $user->initials }}
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control form-select" required>
                    <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                    <option value="Editor" {{ old('role', $user->role) == 'Editor' ? 'selected' : '' }}>Editor (Full Management)</option>
                    <option value="Publisher" {{ old('role', $user->role) == 'Publisher' ? 'selected' : '' }}>Publisher (Approve & Publish)</option>
                    <option value="Author" {{ old('role', $user->role) == 'Author' ? 'selected' : '' }}>Author (Create Content)</option>
                    <option value="Viewer" {{ old('role', $user->role) == 'Viewer' ? 'selected' : '' }}>Viewer (Read Only)</option>

                </select>
                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Account Status</label>
                <select name="status" class="form-control form-select" required>
                    <option value="Active" {{ old('status', $user->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $user->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div style="background: rgba(248, 250, 252, 0.8); border-radius: 0.5rem; padding: 1.5rem; margin-top: 2rem; border: 1px dashed var(--border-color);">
                <p style="margin-top: 0; font-size: 0.85rem; color: var(--text-secondary);">Leave passwords blank to keep the current password.</p>
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter new password">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat the new password">
                </div>
            </div>

            <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection