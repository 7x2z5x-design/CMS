<!-- BlogCMS Theme - Quick Reference & Code Snippets -->

# 🎨 BlogCMS Theme - Quick Reference Guide

A collection of ready-to-use code snippets and patterns for the BlogCMS theme.

## 📌 Core Snippets

### Page Template
```blade
@extends('layouts.app')

@section('title', 'Page Name')

@section('content')
<div class="container-lg">
    <!-- Page Header -->
    <div class="mb-2xl">
        <h1 class="mb-sm">Page Title</h1>
        <p class="text-secondary">Page description or subheading</p>
    </div>

    <!-- Main Content -->
    
</div>
@endsection
```

### Responsive Card Grid
```blade
<div class="grid grid-cols-4 gap-lg">
    <!-- Card 1 -->
    <div class="card">
        <div class="card-body">
            <h5 class="mb-md">Title</h5>
            <p class="text-secondary">Description here</p>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="card">
        <div class="card-body">
            <!-- More content -->
        </div>
    </div>
</div>

<!-- Automatically responsive:
     - 4 columns on desktop (>1200px)
     - 2 columns on tablet (768px-1199px)
     - 1 column on mobile (<768px)
-->
```

### Header with Action Button
```blade
<div class="flex-between mb-xl">
    <div>
        <h1 class="mb-sm">List Title</h1>
        <p class="text-secondary">Description</p>
    </div>
    <a href="{{ route('create') }}" class="btn btn-primary">Add New</a>
</div>
```

---

## 🎯 Form Patterns

### Basic Create Form
```blade
<div class="card">
    <div class="card-header">
        <h2 class="mb-0">Create New Item</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('store') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-select" id="category" name="category_id" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>

            <div class="flex gap-md">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
```

### Form with Checkboxes
```blade
<div class="form-group">
    <label>Features</label>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-md); margin-top: var(--space-sm);">
        <label style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; margin-bottom: 0; font-weight: normal;">
            <input type="checkbox" name="features" value="feature1" {{ old('features') ? 'checked' : '' }}>
            <span>Enable Feature 1</span>
        </label>
        <label style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; margin-bottom: 0; font-weight: normal;">
            <input type="checkbox" name="features" value="feature2" {{ old('features') ? 'checked' : '' }}>
            <span>Enable Feature 2</span>
        </label>
    </div>
</div>
```

### Form with Toggle
```blade
<div class="form-group">
    <label style="display: flex; align-items: center; gap: var(--space-md); cursor: pointer; margin-bottom: 0;">
        <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}>
        <span>Activate this item</span>
    </label>
</div>
```

---

## 📊 Table Patterns

### Data Table with Actions
```blade
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><strong>{{ $item->title }}</strong></td>
                <td>{{ $item->author->name }}</td>
                <td>{{ $item->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="badge badge-{{ $item->status === 'active' ? 'success' : 'warning' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('edit', $item) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('delete', $item) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted" style="padding: var(--space-2xl);">
                    No items found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

---

## 🎨 Status & Statistics Cards

### Stat Card
```blade
<div class="card">
    <div class="card-body">
        <div class="flex-between">
            <div>
                <p class="text-xsmall text-muted mb-sm">Total Views</p>
                <h2 class="mb-0" style="color: var(--color-primary); font-size: 2.5rem;">2,847</h2>
            </div>
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
        </div>
        <p class="text-small mt-lg" style="color: var(--color-success);">↑ 12% from last month</p>
    </div>
</div>
```

### Status Badge Colors
```blade
<!-- Post Status -->
<span class="badge badge-success">Published</span>    <!-- Green -->
<span class="badge badge-warning">Pending</span>      <!-- Amber -->
<span class="badge badge-danger">Rejected</span>      <!-- Red -->
<span class="badge badge-primary">Draft</span>        <!-- Teal -->
<span class="badge badge-info">Scheduled</span>       <!-- Blue -->
```

---

## ⚠️ Alert Patterns

### Flash Messages in Blade
```blade
@if(session('success'))
    <div class="alert alert-success">
        <strong>✓ Success!</strong> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <strong>✗ Error!</strong> {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">
        <strong>⚠ Warning!</strong> {{ session('warning') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <strong>✗ Validation Error!</strong>
        <ul style="margin: var(--space-sm) 0 0 var(--space-lg); padding-left: var(--space-lg);">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

---

## 🔘 Button Groups

### Button Combination
```html
<div class="flex gap-md">
    <button class="btn btn-primary">Save</button>
    <button class="btn btn-secondary">Cancel</button>
</div>
```

### Inline Actions
```html
<div style="display: flex; gap: var(--space-sm); align-items: center;">
    <a href="{{ route('edit') }}" class="btn btn-sm btn-secondary">Edit</a>
    <button class="btn btn-sm btn-danger" onclick="getDeleteConfirm()">Delete</button>
</div>
```

---

## 🔍 Search & Filter Patterns

### Search Bar
```blade
<div class="card mb-lg">
    <div class="card-body">
        <form method="GET" action="{{ route('items') }}">
            <div class="flex gap-md">
                <div style="flex: 1;">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Search by title..." 
                           value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('items') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>
```

### Filter Sidebar
```blade
<div class="card" style="position: sticky; top: var(--space-xl);">
    <div class="card-header">
        <h5 class="mb-0">Filters</h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" id="status" name="status" onchange="this.form.submit();">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-select" id="category" name="category" onchange="this.form.submit();">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <a href="{{ route('items') }}" class="btn btn-secondary btn-block">Reset Filters</a>
        </form>
    </div>
</div>
```

---

## 📱 Responsive Layout Patterns

### Two-Column Desktop, Single Mobile
```blade
<div class="grid grid-cols-2 gap-xl">
    <!-- Left Column -->
    <div>
        <div class="card">
            <!-- Content -->
        </div>
    </div>
    
    <!-- Right Column -->
    <div>
        <div class="card">
            <!-- Content -->
        </div>
    </div>
</div>

<!-- Automatically: 2 cols on desktop, 1 col on tablet & mobile -->
```

### Three-Column Grid
```blade
<div class="grid grid-cols-3 gap-lg">
    <!-- Item 1 -->
    <div class="card">...</div>
    
    <!-- Item 2 -->
    <div class="card">...</div>
    
    <!-- Item 3 -->
    <div class="card">...</div>
</div>

<!-- Automatically: 3 cols on desktop, 2 cols on tablet, 1 col on mobile -->
```

---

## 🎯 Modal Patterns

### Confirmation Modal
```html
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="mb-0">Confirm Delete</h4>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this item? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <form method="POST" action="{{ route('delete') }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('deleteModal').classList.add('active');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('active');
}
</script>
```

---

## 🎨 Custom Styling Tips

### Using CSS Variables
```html
<div style="color: var(--color-primary); font-weight: 600; letter-spacing: 0.05em;">
    Custom styled element
</div>
```

### Spacing Utilities
```html
<div class="mt-xl mb-lg p-lg">
    <!-- margin-top: xl, margin-bottom: lg, padding: lg -->
</div>
```

### Text Utilities
```html
<p class="text-center">Centered text</p>
<p class="text-right">Right aligned text</p>
<p class="text-muted">Muted/secondary text</p>
<p class="fw-bold">Bold text</p>
```

---

## 📝 Common Patterns Checklist

- ✅ Always use `@extends('layouts.app')` for consistent layout
- ✅ Wrap forms in `.card` with `.card-header` for title
- ✅ Use `.container-lg` for main content width
- ✅ Add flash message displays at top of content
- ✅ Use `.flex-between` for header + action button
- ✅ Place buttons in `.flex` container with `.gap-md`
- ✅ Use grid system for responsive layouts
- ✅ Show badges for status indicators
- ✅ Wrap tables in `.card` for consistency
- ✅ Use appropriate button colors (primary/secondary/danger)

---

## 🚀 Performance Tips

1. **Batch API calls** - Minimize flash messages and redirects
2. **Use CSS variables** - Already optimized, no custom calculations
3. **Lazy load images** - Add `loading="lazy"` to images
4. **Minimize JavaScript** - Use native HTML features when possible
5. **Cache layouts** - Laravel Blade caching is already enabled

---

## 🎓 Final Tips

- Visit `/components-showcase` to see all components live (if route configured)
- Refer to `THEME_DOCUMENTATION.md` for complete API reference
- Keep consistency across all pages
- Test responsiveness on mobile before deployment
- Validate form inputs on both client and server
- Use semantic HTML for accessibility

**Happy Coding! 🎉**
