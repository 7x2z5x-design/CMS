@extends('admin.layout')
@section('title', 'Add New User')

@section('content')
<div class="content-header">
    <h1 class="page-title">Add New User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">
        <i class="ph ph-arrow-left"></i> Back to Users
    </a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">User Details</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="John Doe" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="john@example.com" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control form-select" required>
                    <option value="" disabled selected>Select a role...</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                    <option value="Editor" {{ old('role') == 'Editor' ? 'selected' : '' }}>Editor (Full Management)</option>
                    <option value="Publisher" {{ old('role') == 'Publisher' ? 'selected' : '' }}>Publisher (Approve & Publish)</option>
                    <option value="Author" {{ old('role') == 'Author' ? 'selected' : '' }}>Author (Create Content)</option>
                    <option value="Viewer" {{ old('role') == 'Viewer' ? 'selected' : '' }}>Viewer (Read Only)</option>

                </select>
                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Account Status</label>
                <select name="status" class="form-control form-select" required>
                    <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-top: 2rem;">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat the password" required>
            </div>

            <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Create User</button>
            </div>
        </form>
    </div>
</div>
@endsection