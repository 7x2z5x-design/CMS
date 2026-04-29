@extends('admin.layout')

@section('title', 'Create Category - CMS Admin')

@section('page-title', 'Create New Category')
@section('page-subtitle', 'Add a new category to organize your content')
@section('page-action')
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
    <i class="ph ph-arrow-left"></i> Back to Categories
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Category Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Category Name *</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter category name"
                                       required>
                                @error('name') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug" class="form-label">Slug *</label>
                                <input type="text" 
                                       name="slug" 
                                       id="slug" 
                                       class="form-control" 
                                       value="{{ old('slug') }}" 
                                       placeholder="category-slug"
                                       required>
                                @error('slug') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_group" class="form-label">Category Group *</label>
                                <select name="category_group" id="category_group" class="form-select" required>
                                    <option value="">Select a group</option>
                                    @foreach($categoryGroups as $group => $subcategories)
                                        <option value="{{ $group }}" {{ old('category_group') == $group ? 'selected' : '' }}>
                                            {{ $group }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_group') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select name="parent_id" id="parent_id" class="form-select">
                                    <option value="">No Parent (Root Level)</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          class="form-control" 
                                          rows="4" 
                                          placeholder="Brief description of the category">{{ old('description') }}</textarea>
                                @error('description') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color" class="form-label">Color</label>
                                <input type="color" 
                                       name="color" 
                                       id="color" 
                                       class="form-control form-control-color"
                                       value="{{ old('color', '#6B7B3A') }}">
                                @error('color') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        
                                                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Featured Image</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="featured_image" class="form-label">Category Image</label>
                    <input type="file" 
                           name="featured_image" 
                           id="featured_image" 
                           class="form-control" 
                           accept="image/*">
                    <div class="form-text">Upload an image to represent this category (optional)</div>
                    @error('featured_image') 
                        <div class="invalid-feedback d-block">{{ $message }}</div> 
                    @enderror
                </div>
                
                <div id="imagePreview" class="mt-3" style="display: none;">
                    <img id="previewImg" src="#" alt="Preview" style="max-width: 100%; height: auto; border-radius: 8px;">
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="d-flex gap-2">
                    <button type="submit" form="categoryForm" class="btn btn-primary flex-grow-1">
                        <i class="ph ph-check"></i> Create Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-generate slug from name
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                slugInput.value = this.value.toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^a-z0-9-]/g, '');
                slugInput.dataset.autoGenerated = 'true';
            }
        });
        
        slugInput.addEventListener('input', function() {
            this.dataset.autoGenerated = 'false';
        });
    }
    
    // Image preview
    const imageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    }
    
    // Update parent categories when group changes
    const groupSelect = document.getElementById('category_group');
    const parentSelect = document.getElementById('parent_id');
    
    if (groupSelect && parentSelect) {
        groupSelect.addEventListener('change', function() {
            const selectedGroup = this.value;
            
            // Filter parent categories by selected group
            const options = parentSelect.querySelectorAll('option');
            options.forEach(option => {
                if (option.value === '') return; // Keep "No Parent" option
                
                // You would need to add data attributes to options to filter by group
                // For now, just show all parent categories
                option.style.display = 'block';
            });
        });
    }
});
</script>
@endpush
