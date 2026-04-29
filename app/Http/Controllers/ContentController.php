<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::with(['user', 'categories', 'tags']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('content_type')) {
            $query->where('content_type', $request->content_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }
        
        // Author filtering
        if ($request->filled('author_id')) {
            $query->where('user_id', $request->author_id);
        }


        $contents = $query->latest()->paginate(12); // Smaller pagination for grid
        $contents->appends($request->all());

        $categories = Category::orderBy('name')->get();
        
        // Get authors who have posts for dropdown
        $authors = \App\Models\User::whereHas('contents', function($q) {
                $q->where('content_type', 'post');
            })
            ->orderBy('name')
            ->get();
        
        // Stats for the header
        $stats = [
            'total' => Content::count(),
            'posts' => Content::where('content_type', 'post')->count(),
            'media' => Content::whereIn('content_type', ['image', 'video', 'audio'])->count(),
            'pending' => Content::where('status', 'pending')->count(),
        ];
        
        return view('admin.content.index', compact('contents', 'categories', 'stats'));
    }

    public function show(Content $content)
    {
        $content->load(['user', 'categories', 'tags']);
        return view('admin.content.show', compact('content'));
    }


    public function create()

    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        
        return view('admin.content.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'content_type' => 'required|in:post,image,video,audio',
            'file' => 'nullable|file|max:20480',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,pending,approved,rejected'
        ]);


        $data = $request->except(['file', 'tags']);
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('content_media', 'public');
        }

        $content = Content::create($data);

        if ($request->has('categories')) {
            $content->categories()->sync($request->categories);
        }

        if ($request->has('tags')) {
            $content->tags()->sync($request->tags);
        }


        return redirect()->route('admin.content.index')->with('success', 'Content created successfully.');
    }

    public function edit(Content $content)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        
        return view('admin.content.edit', compact('content', 'categories', 'tags'));
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'content_type' => 'required|in:post,image,video,audio',
            'file' => 'nullable|file|max:20480',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,pending,approved,rejected'
        ]);


        $data = $request->except(['file', 'tags']);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('content_media', 'public');
        }

        $content->update($data);

        if ($request->has('categories')) {
            $content->categories()->sync($request->categories);
        } else {
            $content->categories()->detach();
        }

        if ($request->has('tags')) {
            $content->tags()->sync($request->tags);
        } else {

            $content->tags()->detach();
        }

        return redirect()->route('admin.content.index')->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        $content->delete(); // Soft delete
        return redirect()->route('admin.content.index')->with('success', 'Content deleted successfully.');
    }

    public function approve(Content $content)
    {
        $content->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Content approved.');
    }

    public function reject(Content $content)
    {
        $content->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Content rejected.');
    }
}
