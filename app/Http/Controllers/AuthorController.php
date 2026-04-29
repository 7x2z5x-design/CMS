<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Show the author dashboard.
     */
    public function dashboard()
    {
        $userId = auth()->id();
        
        // Retrieve statistics for the logged-in author
        $stats = [
            'total_posts' => Content::where('user_id', $userId)->where('content_type', 'post')->count(),
            'draft_posts' => Content::where('user_id', $userId)->where('content_type', 'post')->where('status', 'draft')->count(),
            'approved_posts' => Content::where('user_id', $userId)->where('content_type', 'post')->where('status', 'approved')->count(),
            'total_views' => Content::where('user_id', $userId)->where('content_type', 'post')->sum('views_count'),
        ];

        // Get latest posts by the author
        $latestPosts = Content::where('user_id', $userId)
            ->where('content_type', 'post')
            ->latest()
            ->take(5)
            ->get();

        return view('author.dashboard', compact('stats', 'latestPosts'));
    }
}
