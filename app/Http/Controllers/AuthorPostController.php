<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Category;
use App\Models\PostRevision;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthorPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Content::where('user_id', auth()->id())->where('content_type', 'post');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filtering
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Tag filtering
        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        $posts = $query->latest()->paginate(10);
        $posts->appends($request->all());

        // Get categories and tags for filter dropdowns
        $categories = \App\Models\Category::orderBy('name')->get();
        $tags = \App\Models\Tag::orderBy('name')->get();

        return view('author.posts.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('author.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date|after:now',
            'content_type' => 'required|in:post,image,video,audio',
            'media_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,doc|max:10240',
            'external_url' => 'nullable|url',
            'media_id' => 'nullable|integer|exists:contents,id'
        ]);

        // Determine status and published_at based on user input
$status = $request->status;
$publishedAt = null;

if ($request->filled('published_at')) {
    $publishedAt = $request->published_at;
    $status = 'scheduled'; // Set status to scheduled if date is provided
}

// Handle file upload
$filePath = null;
if ($request->hasFile('media_file')) {
    $file = $request->file('media_file');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $filePath = $file->storeAs('uploads/media', $fileName, 'public');
}

$post = Content::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'description' => $request->content,
            'content_type' => $request->content_type,
            'user_id' => auth()->id(),
            'status' => $status,
            'published_at' => $publishedAt,
            'file_path' => $filePath,
            'external_url' => $request->external_url,
            'media_id' => $request->media_id
        ]);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        // Process tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(['name' => $tagName, 'slug' => Str::slug($tagName)]);
                    $tagIds[] = $tag->id;
                }
            }
            
            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('author.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find post ensuring it belongs to the logged-in author
        $post = Content::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->firstOrFail();

        return view('author.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find post ensuring it belongs to the logged-in author
        $post = Content::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->firstOrFail();

        $categories = Category::orderBy('name')->get();
        return view('author.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Content::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date|after:now',
            'content_type' => 'required|in:post,image,video,audio',
            'media_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,doc|max:10240',
            'external_url' => 'nullable|url',
            'media_id' => 'nullable|integer|exists:contents,id'
        ]);

        // Determine status and published_at based on user input
$status = $request->status;
$publishedAt = null;

if ($request->filled('published_at')) {
    $publishedAt = $request->published_at;
    $status = 'scheduled'; // Set status to scheduled if date is provided
}

// Create revision before updating if content has changed
if ($post->title != $request->title || $post->description != $request->content) {
    PostRevision::create([
        'post_id' => $post->id,
        'title' => $post->title,
        'content' => $post->description,
        'user_id' => auth()->id()
    ]);
}

// Handle file upload
$filePath = $post->file_path; // Keep existing file path
if ($request->hasFile('media_file')) {
    $file = $request->file('media_file');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $filePath = $file->storeAs('uploads/media', $fileName, 'public');
}

$post->update([
            'title' => $request->title,
            'description' => $request->content,
            'content_type' => $request->content_type,
            'status' => $status,
            'published_at' => $publishedAt,
            'file_path' => $filePath,
            'external_url' => $request->external_url,
            'media_id' => $request->media_id
        ]);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        } else {
            $post->categories()->detach();
        }

        // Process tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(['name' => $tagName, 'slug' => Str::slug($tagName)]);
                    $tagIds[] = $tag->id;
                }
            }
            
            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('author.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Show revision details.
     */
    public function showRevision($id)
    {
        $revision = PostRevision::where('id', $id)
            ->whereHas('post', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->firstOrFail();

        return response()->json([
            'id' => $revision->id,
            'title' => $revision->title,
            'content' => $revision->content,
            'created_at' => $revision->formatted_created_at,
            'user' => $revision->user->name ?? 'Unknown'
        ]);
    }

    /**
     * Display revision history for a post.
     */
    public function revisions($postId)
    {
        $post = Content::where('id', $postId)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->firstOrFail();

        $revisions = $post->revisions()->with('user')->get();

        return view('author.posts.revisions.index', compact('post', 'revisions'));
    }

    /**
     * Compare a revision with the current post.
     */
    public function compare($postId, $revisionId)
    {
        $post = Content::where('id', $postId)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->firstOrFail();

        $revision = PostRevision::where('id', $revisionId)
            ->where('post_id', $postId)
            ->firstOrFail();

        // Simple diff logic without external packages
        $titleDiff = $this->simpleDiff($revision->title, $post->title);
        $contentDiff = $this->simpleDiff($revision->content, $post->description);

        return view('author.posts.revisions.compare', compact('post', 'revision', 'titleDiff', 'contentDiff'));
    }

    /**
     * Simple text diff implementation
     */
    private function simpleDiff($oldText, $newText)
    {
        $oldLines = explode("\n", $oldText);
        $newLines = explode("\n", $newText);
        
        $diff = [];
        $oldIndex = 0;
        $newIndex = 0;
        
        while ($oldIndex < count($oldLines) || $newIndex < count($newLines)) {
            if ($oldIndex >= count($oldLines)) {
                // Only new lines remain
                $diff[] = ['type' => 'added', 'line' => $newLines[$newIndex]];
                $newIndex++;
            } elseif ($newIndex >= count($newLines)) {
                // Only old lines remain
                $diff[] = ['type' => 'removed', 'line' => $oldLines[$oldIndex]];
                $oldIndex++;
            } elseif ($oldLines[$oldIndex] === $newLines[$newIndex]) {
                // Lines are the same
                $diff[] = ['type' => 'unchanged', 'line' => $newLines[$newIndex]];
                $oldIndex++;
                $newIndex++;
            } else {
                // Lines are different
                $diff[] = ['type' => 'removed', 'line' => $oldLines[$oldIndex]];
                $diff[] = ['type' => 'added', 'line' => $newLines[$newIndex]];
                $oldIndex++;
                $newIndex++;
            }
        }
        
        return $diff;
    }

    /**
     * Restore a post from a revision.
     */
    public function restoreRevision($postId, $revisionId)
    {
        $post = Content::where('id', $postId)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->firstOrFail();

        $revision = PostRevision::where('id', $revisionId)
            ->where('post_id', $postId)
            ->firstOrFail();

        // Create a new revision with current content before restoring
        PostRevision::create([
            'post_id' => $post->id,
            'title' => $post->title,
            'content' => $post->description,
            'user_id' => auth()->id()
        ]);

        // Restore the revision content
        $post->update([
            'title' => $revision->title,
            'description' => $revision->content
        ]);

        // Check if request expects JSON (for AJAX calls) or redirect
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Post restored successfully',
                'redirect' => route('author.posts.edit', $postId)
            ]);
        }

        return redirect()->route('author.posts.edit', $postId)
            ->with('success', "Post restored to version from {$revision->formatted_created_at}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Content::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->firstOrFail();

        $post->delete();

        return redirect()->route('author.posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Show analytics for a specific post
     */
    public function analytics($id)
    {
        // Find the post belonging to the authenticated author
        $post = Content::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('content_type', 'post')
            ->with(['categories', 'tags'])
            ->firstOrFail();

        // Calculate engagement metrics
        $totalViews = $post->views_count ?? 0;
        
        // Simple engagement level calculation based on views
        $engagementLevel = $this->calculateEngagementLevel($totalViews);
        
        // Additional metrics (can be expanded later)
        $metrics = [
            'total_views' => $totalViews,
            'engagement_level' => $engagementLevel,
            'views_per_day' => $this->calculateViewsPerDay($post),
            'performance_score' => $this->calculatePerformanceScore($totalViews),
        ];

        return view('author.posts.analytics', compact('post', 'metrics'));
    }

    /**
     * Calculate engagement level based on view count
     */
    private function calculateEngagementLevel($views)
    {
        if ($views >= 1000) {
            return ['level' => 'High', 'color' => '#1a9e7a', 'icon' => 'fas fa-fire'];
        } elseif ($views >= 100) {
            return ['level' => 'Medium', 'color' => '#f39c12', 'icon' => 'fas fa-chart-line'];
        } else {
            return ['level' => 'Low', 'color' => '#95a5a6', 'icon' => 'fas fa-eye'];
        }
    }

    /**
     * Calculate average views per day
     */
    private function calculateViewsPerDay($post)
    {
        if (!$post->created_at || $post->views_count == 0) {
            return 0;
        }
        
        $daysSinceCreation = $post->created_at->diffInDays(now());
        return $daysSinceCreation > 0 ? round($post->views_count / $daysSinceCreated, 2) : $post->views_count;
    }

    /**
     * Calculate performance score (0-100)
     */
    private function calculatePerformanceScore($views)
    {
        // Simple scoring based on view count
        if ($views >= 1000) return 100;
        if ($views >= 500) return 80;
        if ($views >= 100) return 60;
        if ($views >= 50) return 40;
        if ($views >= 10) return 20;
        return 10;
    }
}
