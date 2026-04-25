@extends('admin.layout')

@section('title', 'Category Management - CMS Admin')

@section('page-title', 'Category Management')
@section('page-subtitle', 'Organize and manage your content categories')
@section('page-action')
<button type="button" class="btn btn-primary" onclick="openCategoryModal()">
    <i class="ph ph-plus"></i> Add Category
</button>
@endsection

@section('content')
<!-- Stats Cards Section -->
<section class="stats-section mb-xl">
    <div class="grid grid-cols-4 gap-md">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--clr-primary-bg);">
                <i class="ph ph-faders" style="color: var(--clr-primary); font-size: 1.5rem;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Categories</div>
                <div class="stat-number">{{ $categories->total() }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--clr-success-bg);">
                <i class="ph ph-check-circle" style="color: var(--clr-success); font-size: 1.5rem;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Active Categories</div>
                <div class="stat-number">{{ $categories->where('status', 'active')->count() }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--clr-warning-bg);">
                <i class="ph ph-moon" style="color: var(--clr-warning); font-size: 1.5rem;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Inactive Categories</div>
                <div class="stat-number">{{ $categories->where('status', 'inactive')->count() }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--clr-info-bg);">
                <i class="ph ph-chart-bar" style="color: var(--clr-info); font-size: 1.5rem;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Posts</div>
                <div class="stat-number">{{ $categories->sum('posts_count') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Filters and Search Section -->
<section class="filters-section mb-lg">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="filters-form">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search" class="form-label">Search Categories</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ph ph-magnifying-glass"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       class="form-control" 
                                       placeholder="Search by name or slug..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="group" class="form-label">Category Group</label>
                            <select name="group" id="group" class="form-select">
                                <option value="">All Groups</option>
                                @foreach(\App\Models\Category::CATEGORY_GROUPS as $group => $subcategories)
                                    <option value="{{ $group }}" {{ request('group') == $group ? 'selected' : '' }}>
                                        {{ $group }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph ph-funnel"></i> Filter
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                    <i class="ph ph-x"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Categories Table Section -->
<section class="categories-section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Categories</h5>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkDelete()" id="bulkDeleteBtn" style="display: none;">
                    <i class="ph ph-trash"></i> Delete Selected
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="bulkToggleStatus('active')" id="bulkActivateBtn" style="display: none;">
                    <i class="ph ph-check"></i> Activate Selected
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="bulkToggleStatus('inactive')" id="bulkDeactivateBtn" style="display: none;">
                    <i class="ph ph-moon"></i> Deactivate Selected
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table" id="categoriesTable">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Group</th>
                            <th>Parent</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr data-category-id="{{ $category->id }}">
                                <td>
                                    <input type="checkbox" class="category-checkbox" value="{{ $category->id }}" onchange="updateBulkActions()">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($category->featured_image)
                                            <img src="{{ asset($category->featured_image) }}" alt="{{ $category->name }}" class="me-2" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div class="category-avatar me-2" style="background: {{ $category->color ?? '#6B7B3A' }}; width: 32px; height: 32px; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                {{ strtoupper(substr($category->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $category->name }}</div>
                                            @if($category->description)
                                                <div class="text-muted small">{{ Str::limit($category->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="text-muted">{{ $category->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge" style="background: {{ $category->group_color }}; color: white;">
                                        {{ $category->category_group }}
                                    </span>
                                </td>
                                <td>
                                    @if($category->parent)
                                        <span class="text-muted">{{ $category->parent->name }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $category->posts_count }}</span>
                                </td>
                                <td>
                                    @if($category->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $category->formatted_created_at }}</small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                onclick="editCategory({{ $category->id }})"
                                                title="Edit">
                                            <i class="ph ph-pencil-simple"></i>
                                        </button>
                                        
                                        <form method="POST" action="{{ route('admin.categories.toggle-status', $category->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-{{ $category->status == 'active' ? 'warning' : 'success' }}" 
                                                    title="{{ $category->status == 'active' ? 'Deactivate' : 'Activate' }}">
                                                <i class="ph ph-{{ $category->status == 'active' ? 'moon' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="ph ph-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="ph ph-faders" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p class="text-muted mb-3">No categories found.</p>
                                    <button type="button" class="btn btn-primary" onclick="openCategoryModal()">
                                        <i class="ph ph-plus"></i> Create Your First Category
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($categories->hasPages())
        <div class="card-footer">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</section>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="categoryFormMethod" value="POST">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Category Name *</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control" 
                                       required
                                       placeholder="Enter category name">
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
                                       required
                                       placeholder="category-slug">
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
                                    @foreach(\App\Models\Category::CATEGORY_GROUPS as $group => $subcategories)
                                        <option value="{{ $group }}">{{ $group }}</option>
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
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
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
                                          rows="3" 
                                          placeholder="Brief description of the category"></textarea>
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
                                       value="#6B7B3A">
                                @error('color')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                                                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seo_title" class="form-label">SEO Title</label>
                                <input type="text" 
                                       name="seo_title" 
                                       id="seo_title" 
                                       class="form-control" 
                                       placeholder="SEO title">
                                @error('seo_title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="featured_image" class="form-label">Featured Image</label>
                                <input type="file" 
                                       name="featured_image" 
                                       id="featured_image" 
                                       class="form-control" 
                                       accept="image/*">
                                @error('featured_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label for="seo_description" class="form-label">SEO Description</label>
                                <textarea name="seo_description" 
                                          id="seo_description" 
                                          class="form-control" 
                                          rows="2" 
                                          placeholder="SEO description"></textarea>
                                @error('seo_description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeCategoryModal()">Cancel</button>
                <button type="submit" form="categoryForm" class="btn btn-primary">
                    <i class="ph ph-check"></i> Save Category
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Category Management JavaScript
let currentEditId = null;

// Open category modal
function openCategoryModal(categoryId = null) {
    currentEditId = categoryId;
    const modal = document.getElementById('categoryModal');
    const form = document.getElementById('categoryForm');
    const title = document.getElementById('categoryModalTitle');
    const method = document.getElementById('categoryFormMethod');
    
    // Reset form
    form.reset();
    
    if (categoryId) {
        // Edit mode
        title.textContent = 'Edit Category';
        method.value = 'PUT';
        form.action = '{{ route("admin.categories.update", ":id") }}'.replace(':id', categoryId);
        
        // Load category data (simplified - just show modal for now)
        // For now, we'll handle edit by redirecting to edit page
        window.location.href = '{{ route("admin.categories.edit", ":id") }}'.replace(':id', categoryId);
    } else {
        // Create mode
        title.textContent = 'Add Category';
        method.value = 'POST';
        form.action = '{{ route("admin.categories.store") }}';
        
        // Load all parent categories
        loadParentCategories();
    }
    
    // Show modal
    showCategoryModal();
}

// Edit category
function editCategory(categoryId) {
    openCategoryModal(categoryId);
}

// Load parent categories (simplified - using existing data)
function loadParentCategories(excludeId = null) {
    // For now, parent categories are already loaded in the HTML
    // This function can be enhanced later if needed
    console.log('Parent categories loaded from HTML');
}

// Toggle select all checkboxes
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.category-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

// Update bulk actions visibility
function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
    const hasChecked = checkedBoxes.length > 0;
    
    document.getElementById('bulkDeleteBtn').style.display = hasChecked ? 'inline-block' : 'none';
    document.getElementById('bulkActivateBtn').style.display = hasChecked ? 'inline-block' : 'none';
    document.getElementById('bulkDeactivateBtn').style.display = hasChecked ? 'inline-block' : 'none';
}

// Bulk delete
function bulkDelete() {
    if (!confirm('Are you sure you want to delete the selected categories? This action cannot be undone.')) {
        return;
    }
    
    const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
    const categoryIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    fetch('{{ route("admin.categories.bulk-delete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            categories: categoryIds
        })
    })
    .then(response => response.json())
    .then(data => {
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Bulk toggle status
function bulkToggleStatus(status) {
    const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
    const categoryIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    fetch('{{ route("admin.categories.bulk-toggle-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            categories: categoryIds,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

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
});

// Close modal function
function closeCategoryModal() {
    const modal = document.getElementById('categoryModal');
    modal.classList.remove('show');
    modal.style.display = 'none';
}

// Show modal function
function showCategoryModal() {
    const modal = document.getElementById('categoryModal');
    modal.classList.add('show');
    modal.style.display = 'block';
}

// Handle modal close
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('categoryModal');
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeCategoryModal();
        }
    });
    
    // Handle form submission
    const form = document.getElementById('categoryForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Let the form submit normally
            // The browser will handle the POST request
            console.log('Form submitted to:', form.action);
        });
    }
});
</script>
@endpush
