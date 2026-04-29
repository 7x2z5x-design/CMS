<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display category management page.
     */
    public function index(Request $request)
    {
        $query = Category::with(['parent', 'children'])->withCount('posts');

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by group
        if ($request->filled('group')) {
            $query->where('category_group', $request->group);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Order by display order and name
        $categories = $query->ordered()->paginate(20);

        // Get category counts by group for sidebar
        $categoryCounts = Category::getCountByGroup();
        
        // Get parent categories for modal dropdown
        $parentCategories = Category::active()->ordered()->get();

        return view('admin.categories.index', compact('categories', 'categoryCounts', 'parentCategories'));
    }

    /**
     * Show form to create new category.
     */
    public function create()
    {
        $parentCategories = Category::active()->ordered()->get();
        $categoryGroups = Category::CATEGORY_GROUPS;

        return view('admin.categories.create', compact('parentCategories', 'categoryGroups'));
    }

    /**
     * Store new category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
            'category_group' => 'required|string|in:' . implode(',', array_keys(Category::CATEGORY_GROUPS)),
            'color' => 'nullable|string|max:7',
            'status' => 'required|in:active,inactive',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();
        
        // Generate slug
        $data['slug'] = Str::slug($request->name);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/categories', $imageName);
            $data['featured_image'] = 'storage/categories/' . $imageName;
        }

        // Remove display_order references as column doesn't exist

        $category = Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category "' . $category->name . '" created successfully!');
    }

    /**
     * Show form to edit category.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::active()
            ->where('id', '!=', $category->id)
            ->where(function($query) use ($category) {
                $query->whereNull('parent_id')
                      ->orWhere('parent_id', '!=', $category->id);
            })
            ->ordered()
            ->get();

        $categoryGroups = Category::CATEGORY_GROUPS;

        return view('admin.categories.edit', compact('category', 'parentCategories', 'categoryGroups'));
    }

    /**
     * Update category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id|different:id',
            'category_group' => 'required|string|in:' . implode(',', array_keys(Category::CATEGORY_GROUPS)),
            'color' => 'nullable|string|max:7',
            'status' => 'required|in:active,inactive',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'display_order' => 'nullable|integer|min:0',
        ]);

        // Check if category has children and parent is being changed
        if ($request->filled('parent_id') && $category->hasChildren()) {
            return redirect()
                ->back()
                ->withErrors(['parent_id' => 'Cannot change parent category because this category has child categories.']);
        }

        $data = $request->all();
        
        // Update slug if name changed
        if ($request->name !== $category->name) {
            $data['slug'] = Str::slug($request->name);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($category->featured_image) {
                $oldImagePath = str_replace('storage/', 'public/', $category->featured_image);
                Storage::delete($oldImagePath);
            }

            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/categories', $imageName);
            $data['featured_image'] = 'storage/categories/' . $imageName;
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category "' . $category->name . '" updated successfully!');
    }

    /**
     * Toggle category status.
     */
    public function toggleStatus(Category $category)
    {
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        $action = $category->status === 'active' ? 'activated' : 'deactivated';

        return redirect()
            ->back()
            ->with('success', 'Category "' . $category->name . '" ' . $action . ' successfully!');
    }

    /**
     * Delete category.
     */
    public function destroy(Category $category)
    {
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return redirect()
                ->back()
                ->withErrors(['delete' => 'Cannot delete category "' . $category->name . '" because it has ' . $category->posts()->count() . ' associated posts.']);
        }

        // Check if category has children
        if ($category->hasChildren()) {
            return redirect()
                ->back()
                ->withErrors(['delete' => 'Cannot delete category "' . $category->name . '" because it has child categories.']);
        }

        // Delete featured image if exists
        if ($category->featured_image) {
            $imagePath = str_replace('storage/', 'public/', $category->featured_image);
            Storage::delete($imagePath);
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category "' . $categoryName . '" deleted successfully!');
    }

    /**
     * Bulk delete categories.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $deletedCount = 0;
        $errors = [];

        foreach ($request->categories as $categoryId) {
            $category = Category::find($categoryId);
            
            if ($category) {
                if ($category->posts()->count() > 0) {
                    $errors[] = 'Cannot delete "' . $category->name . '" because it has posts.';
                    continue;
                }

                if ($category->hasChildren()) {
                    $errors[] = 'Cannot delete "' . $category->name . '" because it has child categories.';
                    continue;
                }

                // Delete featured image if exists
                if ($category->featured_image) {
                    $imagePath = str_replace('storage/', 'public/', $category->featured_image);
                    Storage::delete($imagePath);
                }

                $category->delete();
                $deletedCount++;
            }
        }

        $message = $deletedCount . ' categories deleted successfully!';
        
        if (!empty($errors)) {
            $message .= ' However, some categories could not be deleted: ' . implode(' ', $errors);
            return redirect()->back()->with('warning', $message);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Bulk toggle status.
     */
    public function bulkToggleStatus(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        $updatedCount = Category::whereIn('id', $request->categories)
            ->update(['status' => $request->status]);

        $action = $request->status === 'active' ? 'activated' : 'deactivated';

        return redirect()
            ->back()
            ->with('success', $updatedCount . ' categories ' . $action . ' successfully!');
    }

    /**
     * Get categories by group for AJAX requests.
     */
    public function getByGroup($group)
    {
        if (!array_key_exists($group, Category::CATEGORY_GROUPS)) {
            return response()->json(['error' => 'Invalid group'], 400);
        }

        $categories = Category::byGroup($group)
            ->active()
            ->ordered()
            ->get(['id', 'name', 'slug', 'color']);

        return response()->json($categories);
    }

    /**
     * Get category counts by group for sidebar.
     */
    public function getCounts()
    {
        $counts = Category::getCountByGroup();
        return response()->json($counts);
    }

    /**
     * Reorder categories.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->categories as $categoryData) {
            Category::where('id', $categoryData['id'])
                ->update(['display_order' => $categoryData['order']]);
        }

        return response()->json(['success' => true]);
    }
}
