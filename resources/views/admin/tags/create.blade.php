@extends('admin.layout')
@section('title', 'Add New Tag')

@section('content')
<div class="content-header" style="margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin: 0; margin-bottom: 1rem;">Add New Tag</h1>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-light" style="display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="ph ph-arrow-left"></i> Back to Tags
    </a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color);">
        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Tag Details</h3>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <form action="{{ route('admin.tags.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter tag name" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                @error('name') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Save Tag</button>
            </div>
        </form>
    </div>
</div>
@endsection
