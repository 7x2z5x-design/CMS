<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorMediaController extends Controller
{
    /**
     * Display the author's media library.
     */
    public function index()
    {
        $userId = auth()->id();
        
        // Get all content with file paths for the authenticated author
        $mediaFiles = Content::where('user_id', $userId)
            ->whereNotNull('file_path')
            ->where('content_type', '!=', 'video') // Exclude video posts as they use external URLs
            ->latest()
            ->paginate(12);

        return view('author.media.index', compact('mediaFiles'));
    }

    /**
     * Remove the specified media file.
     */
    public function destroy($id)
    {
        $media = Content::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Delete file from storage
        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        // Delete the content record
        $media->delete();

        return redirect()->route('author.media.index')
            ->with('success', 'Media file deleted successfully.');
    }
}
