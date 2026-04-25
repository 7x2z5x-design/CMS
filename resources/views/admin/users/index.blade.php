@extends('admin.layout')
@section('title', 'Users Management')

@section('content')
<div class="content-header">
    <h1 class="page-title">Users Management</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="ph ph-plus"></i> Add New User
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="avatar">{{ $user->initials }}</div>
                                <div>
                                    <div style="font-weight: 700; color: var(--text-primary);">{{ $user->name }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $user->email }}</div>

                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role == 'Admin')
                              <span class="badge badge-primary">Admin</span>
                            @elseif($user->role == 'Editor')
                              <span class="badge badge-warning">Editor</span>
                            @else
                              <span class="badge " style="background: var(--border-color); color: var(--text-primary);">Viewer</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status == 'Active')
                              <span class="badge badge-success">Active</span>
                            @else
                              <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            <div style="display: flex; gap: 0.25rem;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon" title="Edit"><i class="ph ph-pencil-simple"></i></a>
                                
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Delete"><i class="ph ph-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <i class="ph ph-users" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
                            <p>No users found in the system.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($users->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--border-color);">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection