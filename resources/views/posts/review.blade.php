@extends('layouts.app')

@section('title', 'Review Posts')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-inner">
        <div>
            <h1 class="page-title">Content Review</h1>
            <p class="page-subtitle">Review submitted posts and decide whether to approve or reject them.</p>
        </div>
    </div>
</div>

{{-- Filter Tabs --}}
<div class="card mb-lg">
    <div class="card-body" style="padding:var(--sp-3) var(--sp-6);">
        <div class="flex gap-sm" style="overflow-x:auto; white-space:nowrap;">
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}"
               class="btn btn-sm {{ request('filter','all') === 'all' ? 'btn-primary' : 'btn-ghost' }}">
                All Posts
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'pending']) }}"
               class="btn btn-sm {{ request('filter') === 'pending' ? 'btn-primary' : 'btn-ghost' }}">
                ⏳ Pending
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'published']) }}"
               class="btn btn-sm {{ request('filter') === 'published' ? 'btn-primary' : 'btn-ghost' }}">
                ✅ Published
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'rejected']) }}"
               class="btn btn-sm {{ request('filter') === 'rejected' ? 'btn-primary' : 'btn-ghost' }}">
                ❌ Rejected
            </a>
        </div>
    </div>
</div>

{{-- Posts Table --}}
<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Post Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Sample rows for theme demonstration --}}
                <tr>
                    <td>
                        <div>
                            <p class="fw-semibold mb-xs" style="color:var(--clr-text);">How to Master Web Design in 2026</p>
                            <p class="text-xs text-muted mb-0">A comprehensive guide for modern developers...</p>
                        </div>
                    </td>
                    <td>
                        <div class="flex gap-sm" style="align-items:center;">
                            <div style="width:30px;height:30px;border-radius:50%;background:var(--clr-primary-bg);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:var(--clr-primary);flex-shrink:0;">J</div>
                            <span class="text-sm fw-medium">John Doe</span>
                        </div>
                    </td>
                    <td><span class="text-sm">Technology</span></td>
                    <td><span class="text-sm text-muted">2 hours ago</span></td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <div class="flex gap-sm" style="justify-content:flex-end;">
                            <button class="btn btn-success btn-xs" onclick="openApproveModal(1, 'How to Master Web Design')">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                Approve
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="openRejectModal(1)">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Reject
                            </button>
                            <a href="#" class="btn btn-secondary btn-xs">View</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>
                            <p class="fw-semibold mb-xs" style="color:var(--clr-text);">10 Tips for Better Content Writing</p>
                            <p class="text-xs text-muted mb-0">Improve your writing with these proven techniques...</p>
                        </div>
                    </td>
                    <td>
                        <div class="flex gap-sm" style="align-items:center;">
                            <div style="width:30px;height:30px;border-radius:50%;background:var(--clr-info-bg);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:var(--clr-info);flex-shrink:0;">S</div>
                            <span class="text-sm fw-medium">Sara Ali</span>
                        </div>
                    </td>
                    <td><span class="text-sm">Writing</span></td>
                    <td><span class="text-sm text-muted">1 day ago</span></td>
                    <td><span class="badge badge-success">Published</span></td>
                    <td>
                        <div class="flex gap-sm" style="justify-content:flex-end;">
                            <a href="#" class="btn btn-secondary btn-xs">View</a>
                            <a href="#" class="btn btn-ghost btn-xs text-danger">Unpublish</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>
                            <p class="fw-semibold mb-xs" style="color:var(--clr-text);">Latest SEO Trends for Bloggers</p>
                            <p class="text-xs text-muted mb-0">Stay ahead with these 2026 SEO strategies...</p>
                        </div>
                    </td>
                    <td>
                        <div class="flex gap-sm" style="align-items:center;">
                            <div style="width:30px;height:30px;border-radius:50%;background:var(--clr-warning-bg);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:var(--clr-warning);flex-shrink:0;">A</div>
                            <span class="text-sm fw-medium">Ahmed Khan</span>
                        </div>
                    </td>
                    <td><span class="text-sm">SEO</span></td>
                    <td><span class="text-sm text-muted">3 days ago</span></td>
                    <td><span class="badge badge-danger">Rejected</span></td>
                    <td>
                        <div class="flex gap-sm" style="justify-content:flex-end;">
                            <a href="#" class="btn btn-secondary btn-xs">View</a>
                            <button class="btn btn-primary btn-xs">Re-review</button>
                        </div>
                    </td>
                </tr>

                {{-- Dynamic rows from controller --}}
                @isset($posts)
                    @forelse($posts as $post)
                    <tr>
                        <td>
                            <div>
                                <p class="fw-semibold mb-xs" style="color:var(--clr-text);">{{ $post->title }}</p>
                                <p class="text-xs text-muted mb-0">{{ Str::limit($post->excerpt ?? $post->content, 60) }}</p>
                            </div>
                        </td>
                        <td><span class="text-sm">{{ $post->user->FullName ?? $post->user->Username ?? 'N/A' }}</span></td>
                        <td><span class="text-sm">{{ $post->category->name ?? 'N/A' }}</span></td>
                        <td><span class="text-sm text-muted">{{ $post->created_at?->diffForHumans() }}</span></td>
                        <td>
                            @php
                                $badgeClass = match($post->status) {
                                    'published' => 'badge-success',
                                    'pending'   => 'badge-warning',
                                    'rejected'  => 'badge-danger',
                                    default     => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($post->status) }}</span>
                        </td>
                        <td>
                            <div class="flex gap-sm" style="justify-content:flex-end;">
                                @if($post->status === 'pending')
                                <form method="POST" action="{{ route('posts.approve', $post) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-xs">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('posts.reject', $post) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-xs">Reject</button>
                                </form>
                                @endif
                                <a href="{{ Route::has('posts.show') ? route('posts.show', $post) : '#' }}" class="btn btn-secondary btn-xs">View</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                @endisset
            </tbody>
        </table>
    </div>

    {{-- Empty state if needed --}}
    @isset($posts)
        @if($posts->isEmpty())
        <div style="text-align:center; padding:var(--sp-12); color:var(--clr-text-3);">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto var(--sp-4);display:block;opacity:0.4;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <p class="fw-semibold" style="margin-bottom:var(--sp-1);">No posts to review</p>
            <p class="text-sm text-muted mb-0">All posts have been reviewed or none have been submitted yet.</p>
        </div>
        @endif
    @endisset
</div>

{{-- Approve Modal --}}
<div class="modal" id="approveModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="mb-0">Approve Post</h4>
            <button class="modal-close" onclick="document.getElementById('approveModal').classList.remove('active')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" style="margin-bottom:var(--sp-4);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <div>This post will be published and visible to all readers.</div>
            </div>
            <p>You are about to approve: <strong id="approvePostTitle"></strong></p>
            <div class="form-group mb-0">
                <label for="approvalNote">Note for Author <span class="text-muted fw-normal">(optional)</span></label>
                <textarea class="form-control" id="approvalNote" name="note" rows="2" placeholder="Optional feedback for the author..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('approveModal').classList.remove('active')">Cancel</button>
            <button type="button" class="btn btn-success">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                Confirm Approval
            </button>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="mb-0">Reject Post</h4>
            <button class="modal-close" onclick="document.getElementById('rejectModal').classList.remove('active')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-warning" style="margin-bottom:var(--sp-4);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <div>The author will be notified with your reason for rejection.</div>
            </div>
            <div class="form-group mb-0">
                <label for="rejectionReason">Reason for Rejection <span style="color:var(--clr-danger);">*</span></label>
                <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3"
                    placeholder="Explain why this post is being rejected so the author can improve it..." required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('rejectModal').classList.remove('active')">Cancel</button>
            <button type="button" class="btn btn-danger">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Reject Post
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openApproveModal(id, title) {
        document.getElementById('approvePostTitle').textContent = title;
        document.getElementById('approveModal').classList.add('active');
    }
    function openRejectModal(id) {
        document.getElementById('rejectModal').classList.add('active');
    }
    // Close modals on backdrop click
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.classList.remove('active');
        });
    });
</script>
@endpush
