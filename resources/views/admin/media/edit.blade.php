@extends('admin.layout')

@section('title', 'Edit Media')

@section('page-title', 'Edit Media')

@section('content')
<div style="max-width: 600px;">
    <form action="{{ route('admin.media.update', $id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Description Field -->
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-input" rows="4" placeholder="Enter file description...">{{ old('description', 'Company logo for website') }}</textarea>
            @error('description')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Current File Info -->
        <div class="form-group">
            <label class="form-label">Current File</label>
            <div style="padding: 1rem; background: #F9FAFB; border-radius: 8px; border: 1px solid #E5E7EB;">
                <div style="font-weight: 500; color: #111827;">logo.png</div>
                <div style="font-size: 0.875rem; color: #6B7280;">245 KB - Uploaded on Apr 10, 2024</div>
            </div>
        </div>

        <!-- Form Actions -->
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Update Media
            </button>
            <a href="{{ route('admin.media.index') }}" style="padding: 0.875rem 1.5rem; border: 1px solid #E5E7EB; border-radius: 12px; text-decoration: none; color: #6B7280; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
