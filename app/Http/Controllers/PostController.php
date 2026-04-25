<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['author', 'category']);

        // Filters
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->latest()->paginate(15);
        $posts->appends($request->all());

        $categories = Cache::remember('categories_dropdown', 3600, function() {
            return Category::orderBy('name')->get();
        });

        $totalPosts = Post::count();

        return view('admin.content.index', compact('posts', 'categories', 'totalPosts'));
    }

    public function create()
    {
        $categories = Cache::remember('categories_dropdown', 3600, function() {
            return Category::orderBy('name')->get();
        });

        return view('admin.content.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:content_posts',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:Draft,Published,Rejected',
            'content' => 'nullable|string',
            'seo_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160'
        ]);

        $data = $request->all();
        $data['author_id'] = auth()->id();
        
        Post::create($data);

        return redirect()->route('admin.content.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $content) // route resource defines variable as $content
    {
        $post = $content; // Reassign for clarity
        $categories = Cache::remember('categories_dropdown', 3600, function() {
            return Category::orderBy('name')->get();
        });
        return view('admin.content.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $content)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:content_posts,slug,' . $content->id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:Draft,Published,Rejected',
            'content' => 'nullable|string',
            'seo_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160'
        ]);

        $content->update($request->all());

        return redirect()->route('admin.content.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            return response()->json(['success' => true, 'message' => 'Post deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete post.'], 500);
        }
    }
}
