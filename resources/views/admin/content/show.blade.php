@extends('admin.layout')
@section('title', 'Verify Content: ' . $content->title)

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#A78BFA',
                    primaryDark: '#8B5CF6',
                    secondary: '#EDE9FE',
                    deep: '#4C1D95',
                }
            }
        }
    }
</script>

<div class="content-header flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-deep">Content Verification</h1>
        <p class="text-sm text-primaryDark mt-1">Reviewing submission: <span class="font-bold underline">#{{ $content->id }} - {{ $content->title }}</span></p>
    </div>
    <a href="{{ route('admin.content.index') }}" class="btn bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 shadow-sm flex items-center gap-2">
        <i class="ph ph-arrow-left"></i> Back to List
    </a>
</div>

<div class="flex flex-col lg:flex-row gap-8 items-start">
    
    <!-- Left Hand Side: The Content Preview -->
    <div class="w-full lg:w-2/3 space-y-6">
        <div class="card overflow-hidden shadow-md border-border">
            <div class="bg-deep/5 p-4 border-b border-border flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="ph-bold ph-eye text-primaryDark text-xl"></i>
                    <h3 class="font-bold text-deep">Visual Preview</h3>
                </div>
                <span class="badge {{ $content->status == 'approved' ? 'badge-success' : ($content->status == 'pending' ? '!bg-amber-100 !text-amber-800' : 'badge-danger') }} uppercase text-[10px] tracking-widest">
                    {{ $content->status }}
                </span>
            </div>
            
            <div class="p-0 bg-zinc-900 flex items-center justify-center min-h-[400px]">
                @if($content->content_type == 'image')
                    <img src="{{ asset('storage/' . $content->file_path) }}" class="max-w-full max-h-[600px] object-contain" alt="{{ $content->title }}">
                @elseif($content->content_type == 'video')
                    <video src="{{ asset('storage/' . $content->file_path) }}" controls class="w-full max-h-[600px]"></video>
                @elseif($content->content_type == 'audio')
                    <div class="py-20 px-10 text-center w-full">
                         <div class="w-24 h-24 rounded-full bg-primary/20 flex items-center justify-center text-5xl text-primary mx-auto mb-6">
                            <i class="ph ph-waveform"></i>
                        </div>
                        <audio src="{{ asset('storage/' . $content->file_path) }}" controls class="w-full max-w-lg mx-auto"></audio>
                    </div>
                @else
                    <div class="p-10 bg-white w-full">
                        <div class="prose prose-purple max-w-none">
                            {!! nl2br(e($content->description)) !!}
                        </div>
                    </div>
                @endif
            </div>
            
            @if($content->content_type != 'post' && !empty($content->description))
                <div class="p-8 border-t border-border bg-white">
                    <h4 class="text-xs font-bold text-primaryDark uppercase tracking-widest mb-4">Description / Metadata</h4>
                    <div class="text-gray-600 leading-relaxed">
                        {!! nl2br(e($content->description)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Hand Side: Content Details & Moderation -->
    <div class="w-full lg:w-1/3 space-y-6">
        <div class="card p-6 shadow-md border-border">
            <h3 class="font-bold text-deep mb-6 flex items-center gap-2">
                <i class="ph ph-info text-primaryDark"></i>
                Moderation Actions
            </h3>
            
            <div class="space-y-4">
                <div class="flex flex-col gap-3">
                    @if($content->status == 'pending')
                        <form action="{{ route('admin.content.approve', $content) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn !bg-emerald-500 hover:!bg-emerald-600 text-white rounded-xl py-3 flex items-center justify-center gap-2 font-bold transform hover:scale-[1.02] transition">
                                <i class="ph-bold ph-check-circle text-xl"></i>
                                ACCEPT / APPROVE
                            </button>
                        </form>
                        <form action="{{ route('admin.content.reject', $content) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn !bg-rose-500 hover:!bg-rose-600 text-white rounded-xl py-3 flex items-center justify-center gap-2 font-bold transform hover:scale-[1.02] transition">
                                <i class="ph-bold ph-x-circle text-xl"></i>
                                REJECT CONTENT
                            </button>
                        </form>
                    @else
                        <div class="p-4 rounded-xl {{ $content->status == 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }} border {{ $content->status == 'approved' ? 'border-emerald-100' : 'border-rose-100' }} flex flex-col items-center text-center gap-2">
                             <i class="ph-fill {{ $content->status == 'approved' ? 'ph-check-circle' : 'ph-x-circle' }} text-3xl"></i>
                             <p class="font-bold">Content is already {{ ucfirst($content->status) }}</p>
                        </div>
                    @endif
                </div>
                
                <hr class="border-border">
                
                <div class="space-y-1">
                    <p class="text-[10px] text-primaryDark font-bold uppercase tracking-widest">Administrative Actions</p>
                    <div class="flex gap-2 pt-2">
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor() || auth()->user()->isPublisher() || (auth()->user()->isAuthor() && $content->user_id == auth()->id()))
                        <a href="{{ route('admin.content.edit', $content) }}" class="flex-1 btn bg-secondary text-primaryDark hover:bg-primary hover:text-white py-2.5 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition">
                            <i class="ph ph-pencil-simple"></i> Edit
                        </a>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                        <button onclick="confirmDestroy()" class="flex-1 btn bg-rose-50 text-rose-600 hover:bg-rose-100 py-2.5 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition">
                            <i class="ph ph-trash"></i> Delete
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6 shadow-md border-border bg-gray-50/50">
            <h3 class="font-bold text-deep mb-4 text-sm">Submission Details</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-400">Author:</span>
                    <span class="font-bold text-primaryDark">{{ $content->user->name ?? 'System' }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-400">Category:</span>
                    <span class="font-bold text-primaryDark">{{ $content->category->name ?? 'None' }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-400">Type:</span>
                    <span class="font-bold text-primaryDark uppercase">{{ $content->content_type }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-400">Submitted:</span>
                    <span class="font-bold text-primaryDark">{{ $content->created_at->format('M d, Y H:i') }}</span>
                </div>
                
                @if($content->tags->count() > 0)
                    <div class="pt-2">
                         <span class="text-[10px] text-gray-400 font-bold uppercase block mb-2">Tags</span>
                         <div class="flex flex-wrap gap-1">
                            @foreach($content->tags as $tag)
                                <span class="px-2 py-0.5 rounded-md bg-secondary text-primaryDark text-[10px] font-bold">{{ $tag->name }}</span>
                            @endforeach
                         </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<form id="delete-form" action="{{ route('admin.content.destroy', $content) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDestroy() {
        Swal.fire({
            title: 'Delete this asset?',
            text: "This will remove the content from the platform permanently (soft delete).",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#9CA3AF',
            confirmButtonText: 'Yes, Delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endsection
