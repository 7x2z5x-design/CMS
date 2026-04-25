<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $mediaFiles = Media::latest()->paginate(12);
        return view('admin.media.index', compact('mediaFiles'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media_type' => 'required|in:image,video,video_link,document,resource_link',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'alt_text' => 'nullable|string|max:255',
            'file' => 'required_if:media_type,image,video,document|file|mimes:jpg,jpeg,png,gif,mp4,avi,mov,pdf,doc,docx|max:10240', // 10MB limit
            'url' => 'required_if:media_type,video_link,resource_link|url',
        ]);

        $data = [
            'media_type' => $request->media_type,
            'title' => $request->title,
            'description' => $request->description,
            'alt_text' => $request->alt_text,
            'uploaded_by' => auth()->id(),
        ];

        if (in_array($request->media_type, ['video_link', 'resource_link'])) {
            // Handle URL-based media
            $data['url'] = $request->url;
            $data['file_type'] = 'url';
            $data['size'] = 0;
            $data['original_name'] = $request->title;
            $data['mime_type'] = 'url';
            $data['extension'] = 'url';
            
            // Extract thumbnail for video links if needed
            if ($request->media_type === 'video_link' && $request->thumbnail) {
                $data['thumbnail'] = $request->thumbnail;
            }
        } else {
            // Handle file uploads
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            
            $data['file_path'] = $path;
            $data['file_type'] = $file->getClientMimeType();
            $data['size'] = $file->getSize();
            $data['original_name'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getClientMimeType();
            $data['extension'] = $file->getClientOriginalExtension();
        }

        Media::create($data);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        abort(404);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Media deleted successfully.');
    }
}
