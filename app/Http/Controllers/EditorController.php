<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Content;
use App\Models\Category;
use App\Models\Tag;
use App\Models\PostRevision;
use App\Models\User;
use App\Services\ReadabilityService;
use App\Services\SEOComplianceService;

class EditorController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Editor');
    }

    /**
     * Show editor dashboard.
     */
    public function dashboard(Request $request)
    {
        // Get post counts for summary cards
        $submittedCount = Content::where('status', 'pending')->count();
        $approvedCount = Content::where('status', 'approved')->count();
        $rejectedCount = Content::where('status', 'rejected')->count();
        $scheduledCount = Content::where('status', 'draft')->whereNotNull('scheduled_at')->count();

        // Build query for submitted posts with search functionality
        $query = Content::where('status', 'pending')
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }]);

        // Apply keyword search if provided
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Apply tag filter if provided
        if ($request->filled('tag_id')) {
            $tagId = $request->input('tag_id');
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        // Apply category filter if provided
        if ($request->filled('category_id')) {
            $categoryId = $request->input('category_id');
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Apply author filter if provided
        if ($request->filled('author_id')) {
            $authorId = $request->input('author_id');
            $query->where('user_id', $authorId);
        }

        // Get submitted posts with filters applied
        $submittedPosts = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get all tags for filter dropdown
        $tags = Tag::orderBy('name')->get();
        
        // Get all categories for filter dropdown
        $categories = Category::active()->orderBy('name')->get();
        
        // Get all authors who have submitted posts for filter dropdown
        $authors = User::whereHas('posts', function ($q) {
                $q->where('status', 'pending');
            })
            ->orderBy('name')
            ->get();

        return view('editor.dashboard', compact(
            'submittedCount',
            'approvedCount', 
            'rejectedCount',
            'scheduledCount',
            'submittedPosts',
            'tags',
            'categories',
            'authors'
        ));
    }

    /**
     * Show the editor's profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('editor.profile', compact('user'));
    }

    /**
     * Update the editor's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify current password if changing password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'The current password is incorrect.'])
                    ->withInput();
            }

            $user->password = Hash::make($request->new_password);
        }

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('editor.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show editor preferences.
     */
    public function preferences()
    {
        return view('editor.preferences');
    }

    /**
     * Show scheduled content.
     */
    public function scheduled()
    {
        return view('editor.scheduled.index');
    }

    /**
     * Show drafts.
     */
    public function drafts()
    {
        return view('editor.drafts.index');
    }

    /**
     * Show reviews.
     */
    public function reviews()
    {
        return view('editor.reviews.index');
    }

    /**
     * Show approved content.
     */
    public function approved()
    {
        return view('editor.approved.index');
    }

    /**
     * Show rejected content.
     */
    public function rejected()
    {
        return view('editor.rejected.index');
    }

    /**
     * Show analytics.
     */
    public function analytics()
    {
        return view('editor.analytics');
    }

    /**
     * Show reports.
     */
    public function reports()
    {
        return view('editor.reports.index');
    }

    /**
     * Show engagement metrics.
     */
    public function engagement()
    {
        return view('editor.engagement.index');
    }

    /**
     * Show SEO tools.
     */
    public function seo()
    {
        return view('editor.seo.index');
    }

    /**
     * Show keywords management.
     */
    public function keywords()
    {
        return view('editor.keywords.index');
    }

    /**
     * Show import tools.
     */
    public function import()
    {
        return view('editor.import.index');
    }

    /**
     * Show export tools.
     */
    public function export()
    {
        return view('editor.export.index');
    }

    /**
     * Show backup management.
     */
    public function backup()
    {
        return view('editor.backup.index');
    }

    /**
     * Approve a post and notify the author.
     */
    public function approvePost(Content $content)
    {
        // Validate that the content is in submitted status
        if ($content->status !== 'submitted') {
            return redirect()->route('editor.dashboard')->with('error', 'Only submitted posts can be approved.');
        }

        // Update content status to published
        $content->update(['status' => 'published']);

        // Create notification for the author
        $notification = \App\Models\Notification::create([
            'user_id' => $content->user_id,
            'title' => 'Post Approved',
            'message' => "Your post '{$content->title}' has been approved and is now published.",
            'type' => 'success',
            'read' => false,
        ]);

        return redirect()->route('editor.dashboard')->with('success', 'Post approved successfully. Author has been notified.');
    }

    /**
     * Reject a post with feedback and notify the author.
     */
    public function rejectPost(Request $request, Content $content)
    {
        // Validate that the content is in submitted status
        if ($content->status !== 'submitted') {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Only submitted posts can be rejected.']);
            }
            return redirect()->route('editor.dashboard')->with('error', 'Only submitted posts can be rejected.');
        }

        // Validate feedback
        $request->validate([
            'feedback' => 'required|string|min:10|max:500',
        ]);

        // Update content status to rejected
        $content->update(['status' => 'rejected']);

        // Create notification for the author with feedback
        $notification = \App\Models\Notification::create([
            'user_id' => $content->user_id,
            'title' => 'Post Rejected',
            'message' => "Your post '{$content->title}' has been rejected. Feedback: " . $request->feedback,
            'type' => 'warning',
            'read' => false,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Post rejected successfully. Author has been notified with feedback.']);
        }

        return redirect()->route('editor.dashboard')->with('success', 'Post rejected successfully. Author has been notified with feedback.');
    }

    /**
     * Show the edit post form.
     */
    public function editPost(Content $content)
    {
        // Load relationships
        $content->load(['categories', 'tags']);
        
        // Get all categories and tags for the form
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        
        // Calculate readability analysis
        $readability = ReadabilityService::analyzeText($content->content ?? '');
        
        // Calculate SEO compliance
        $seoCompliance = SEOComplianceService::validateCompliance(
            $content->title ?? '',
            $content->content ?? '',
            $content->focus_keyword ?? null
        );
        
        return view('editor.posts.edit', compact('content', 'categories', 'tags', 'readability', 'seoCompliance'));
    }

    /**
     * Update the post and save revision.
     */
    public function updatePost(Request $request, Content $content)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|min:10',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        // Create revision before updating
        PostRevision::create([
            'post_id' => $content->id,
            'title' => $content->title,
            'content' => $content->content ?? '',
            'user_id' => auth()->id(),
        ]);

        // Handle scheduling
        $status = 'published'; // Default status
        $updateData = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        if ($request->has('schedule_post') && $request->schedule_post && $request->filled('scheduled_at')) {
            // Schedule the post
            $status = 'scheduled';
            $updateData['scheduled_at'] = $request->scheduled_at;
            $updateData['status'] = 'scheduled';
        } else {
            // Publish immediately
            $updateData['status'] = 'published';
            $updateData['published_at'] = now();
            $updateData['scheduled_at'] = null; // Clear any existing schedule
        }

        // Update the content
        $content->update($updateData);

        // Sync categories
        if ($request->has('categories')) {
            $content->categories()->sync($request->categories);
        } else {
            $content->categories()->detach();
        }

        // Sync tags
        if ($request->has('tags')) {
            $content->tags()->sync($request->tags);
        } else {
            $content->tags()->detach();
        }

        return redirect()->route('editor.dashboard')->with('success', 'Post updated successfully. Revision saved.');
    }

    /**
     * Show revision history for a post.
     */
    public function revisions(Content $content)
    {
        // Load revisions with user relationships
        $revisions = $content->revisions()->with('user')->latest()->get();
        
        return view('editor.posts.revisions', compact('content', 'revisions'));
    }

    /**
     * View a specific revision.
     */
    public function viewRevision(Content $content, PostRevision $revision)
    {
        // Verify this revision belongs to this content
        if ($revision->post_id !== $content->id) {
            abort(404);
        }

        // Calculate readability analysis for the revision content
        $readability = ReadabilityService::analyzeText($revision->content ?? '');

        return view('editor.posts.revision-view', compact('content', 'revision', 'readability'));
    }

    /**
     * Restore a specific revision.
     */
    public function restoreRevision(Content $content, PostRevision $revision)
    {
        // Verify this revision belongs to this content
        if ($revision->post_id !== $content->id) {
            abort(404);
        }

        // Create a revision of the current state before restoring
        PostRevision::create([
            'post_id' => $content->id,
            'title' => $content->title,
            'content' => $content->content ?? '',
            'user_id' => auth()->id(),
        ]);

        // Restore the revision
        $content->update([
            'title' => $revision->title,
            'content' => $revision->content,
        ]);

        return redirect()->route('editor.posts.revisions', $content->id)
            ->with('success', 'Revision restored successfully. A backup of the current version was saved.');
    }

    /**
     * Compare two revisions side by side.
     */
    public function compareRevisions(Content $content, PostRevision $revision1, PostRevision $revision2)
    {
        // Verify both revisions belong to this content
        if ($revision1->post_id !== $content->id || $revision2->post_id !== $content->id) {
            abort(404);
        }

        // Generate diff
        $diff = $this->generateDiff($revision1->content, $revision2->content);

        return view('editor.posts.revision-compare', compact('content', 'revision1', 'revision2', 'diff'));
    }

    /**
     * Generate a simple text diff between two strings.
     */
    private function generateDiff($old, $new)
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        
        $diff = [];
        $maxLines = max(count($oldLines), count($newLines));
        
        for ($i = 0; $i < $maxLines; $i++) {
            $oldLine = $oldLines[$i] ?? '';
            $newLine = $newLines[$i] ?? '';
            
            if ($oldLine !== $newLine) {
                $diff[] = [
                    'type' => 'changed',
                    'old' => $oldLine,
                    'new' => $newLine
                ];
            } else {
                $diff[] = [
                    'type' => 'unchanged',
                    'old' => $oldLine,
                    'new' => $newLine
                ];
            }
        }
        
        return $diff;
    }
}
