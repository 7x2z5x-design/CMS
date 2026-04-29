<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    /**
     * Display a public post and increment view count
     */
    public function show($slug)
    {
        // Find the published post by slug
        $post = Content::where('slug', $slug)
            ->where('content_type', 'post')
            ->where('status', 'approved')
            ->with(['user', 'categories', 'tags'])
            ->firstOrFail();

        // Increment view count (simple and secure)
        $post->increment('views_count');

        return view('public.post', compact('post'));
    }
}
