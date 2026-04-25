@extends('admin.layout')
@section('title', 'Edit Content')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#0A3323',
                    primaryDark: '#105666',
                    secondary: '#F7F4D5',
                    deep: '#0A3323',
                    accent: '#D3968C',
                }

            }
        }
    }
</script>

<div class="content-header flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h1 class="text-3xl font-extrabold text-primaryDark tracking-tight">Refine Content</h1>
        <p class="text-[0.95rem] text-[#105666] mt-1">Update your story, adjust media, or pivot categories.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.content.index') }}" class="px-5 py-2.5 rounded-2xl bg-white/20 border border-[#0A3323]/20 text-[#0A3323] font-bold text-sm hover:bg-white/40 transition flex items-center gap-2">
            <i class="ph ph-arrow-left"></i> Hub
        </a>
    </div>
</div>


<form action="{{ route('admin.content.update', $content) }}" method="POST" enctype="multipart/form-data" class="max-w-[1200px]">
    @csrf
    @method('PUT')
    
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mb-8 animate-in fade-in slide-in-from-top-4">
            <div class="flex items-center gap-3 text-red-700 font-bold mb-2">
                <i class="ph-bold ph-warning-circle text-xl"></i>
                <span>Action Required</span>
            </div>
            <ul class="list-disc pl-10 text-red-600 text-sm font-medium space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-8">
            <div class="card p-8 bg-[#F7F4D5] border-[#839958] shadow-2xl">
                <div class="flex items-center gap-3 mb-8 text-primaryDark">
                    <div class="w-10 h-10 rounded-xl bg-[#0A3323]/10 flex items-center justify-center">
                        <i class="ph-bold ph-pencil-line text-xl"></i>
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-tighter">Edit Basics</h3>
                </div>

                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Content Title</label>
                        <input type="text" name="title" value="{{ old('title', $content->title) }}" 
                               class="w-full px-6 py-4 rounded-[1.5rem] border-2 border-[#839958]/30 bg-[#F7F4D5] focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition text-lg font-bold text-[#0A3323]" 
                               required>
                    </div>

                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Narrative</label>
                        <textarea name="description" rows="12" 
                                  class="w-full px-6 py-4 rounded-[1.5rem] border-2 border-[#839958]/30 bg-[#F7F4D5] focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition font-medium text-[#0A3323]">{{ old('description', $content->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div id="file-upload-section" class="card p-8 bg-[#F7F4D5] border-[#839958] shadow-2xl {{ in_array($content->content_type, ['image', 'video', 'audio']) ? '' : 'hidden' }} transition-all">
                <div class="flex items-center gap-3 mb-8 text-primaryDark">
                    <div class="w-10 h-10 rounded-xl bg-[#0A3323]/10 flex items-center justify-center">
                        <i class="ph-bold ph-folder-open text-xl"></i>
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-tighter">Media Assets</h3>
                </div>
                
                @if($content->file_path)
                    <div class="mb-8 rounded-[2rem] overflow-hidden border-2 border-[#D1DBE2] bg-[#F2F4F7]/30 p-6">
                        <p class="text-[0.6rem] font-black uppercase tracking-widest text-[#8496A6] mb-4">Current Active Asset</p>
                        <div class="flex flex-col md:flex-row gap-6 items-center">
                            <div class="w-full md:w-64 aspect-video bg-black rounded-[1.5rem] overflow-hidden shadow-lg flex items-center justify-center">
                                @if($content->content_type == 'image')
                                    <img src="{{ asset('storage/' . $content->file_path) }}" class="w-full h-full object-cover">
                                @elseif($content->content_type == 'video')
                                    <video src="{{ asset('storage/' . $content->file_path) }}" controls class="w-full h-full"></video>
                                @elseif($content->content_type == 'audio')
                                    <div class="w-full h-full flex items-center justify-center text-primary text-4xl">
                                        <i class="ph-fill ph-waveform"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <p class="text-primaryDark font-black text-lg mb-1 italic truncate">{{ basename($content->file_path) }}</p>
                                @if($content->content_type == 'audio')
                                    <audio src="{{ asset('storage/' . $content->file_path) }}" controls class="w-full mt-4"></audio>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="relative group">
                    <input type="file" name="file" id="file-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-4 border-dashed border-[#839958]/50 bg-[#839958]/10 rounded-[2rem] p-12 text-center group-hover:bg-[#839958]/20 group-hover:border-primary transition duration-300">
                        <div class="w-20 h-20 rounded-full bg-[#F7F4D5] text-primary flex items-center justify-center text-4xl mb-6 mx-auto shadow-md group-hover:scale-110 transition">
                            <i class="ph-bold ph-upload-simple"></i>
                        </div>
                        <p class="text-primaryDark font-black text-xl mb-1">Replace Current Asset</p>
                        <p class="text-sm text-[#105666] font-medium" id="file-name-display">Click or drag to swap files</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-8">
            <div class="card p-8 bg-[#F7F4D5] border-[#839958] shadow-2xl text-[#0A3323]">
                <div class="flex items-center gap-3 mb-8 text-primaryDark">
                    <div class="w-10 h-10 rounded-xl bg-accent/20 flex items-center justify-center text-accent">
                        <i class="ph-bold ph-broadcast text-xl"></i>
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-tighter">Update Lifecycle</h3>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3 text-red-500">Asset Type (Immutable)</label>
                        <div class="px-5 py-4 rounded-2xl bg-[#F2F4F7] border-2 border-[#D1DBE2] text-[#8496A6] font-black uppercase text-xs tracking-widest flex items-center gap-2">
                             @if($content->content_type == 'post') <i class="ph ph-article"></i> Blog Post
                             @elseif($content->content_type == 'image') <i class="ph ph-image"></i> Image Asset
                             @elseif($content->content_type == 'video') <i class="ph ph-video"></i> Video Asset
                             @else <i class="ph ph-music-notes"></i> Audio Asset @endif
                        </div>
                        <input type="hidden" name="content_type" value="{{ $content->content_type }}">
                    </div>

                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Lifecycle Status <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="content_type" id="content-type-selector" class="w-full px-5 py-4 rounded-2xl border-2 border-[#839958]/30 bg-[#F7F4D5] appearance-none focus:border-primary outline-none transition font-bold text-[#0A3323]" required>
                                <option value="post" {{ old('content_type', $content->content_type) == 'post' ? 'selected' : '' }}>📝 Post</option>
                                <option value="image" {{ old('content_type', $content->content_type) == 'image' ? 'selected' : '' }}>🖼️ Image</option>
                                <option value="video" {{ old('content_type', $content->content_type) == 'video' ? 'selected' : '' }}>🎥 Video</option>
                                <option value="audio" {{ old('content_type', $content->content_type) == 'audio' ? 'selected' : '' }}>🎵 Audio</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-5 top-1/2 -translate-y-1/2 text-[#105666] pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Status Workflow</label>
                        <div class="relative">
                            <select name="status" class="w-full px-5 py-4 rounded-2xl border-2 border-[#839958]/30 bg-[#F7F4D5] appearance-none focus:border-primary outline-none transition font-bold text-[#0A3323]" required>
                                <option value="draft" {{ old('status', $content->status) == 'draft' ? 'selected' : '' }}>Working Draft</option>
                                <option value="pending" {{ old('status', $content->status) == 'pending' ? 'selected' : '' }}>Ready for Review</option>
                                <option value="approved" {{ old('status', $content->status) == 'approved' ? 'selected' : '' }}>Active & Final</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-5 top-1/2 -translate-y-1/2 text-[#105666] pointer-events-none"></i>
                        </div>
                    </div>

                    <hr class="border-[#839958]/20 my-6">

                    <!-- NEW: MULTI-CATEGORY SELECTION -->
                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-4">Categories</label>
                        <div class="p-5 border-2 border-[#839958]/30 rounded-[1.5rem] bg-[#839958]/10 max-h-60 overflow-y-auto space-y-4">
                            @foreach($categories->groupBy('category_group') as $groupName => $groupCategories)
                                <div>
                                    <p class="text-[0.6rem] font-black uppercase tracking-widest text-[#105666] mb-3">{{ $groupName }}</p>
                                    <div class="space-y-2">
                                        @foreach($groupCategories as $category)
                                            <label class="flex items-center gap-3 cursor-pointer group p-2 rounded-xl hover:bg-[#F7F4D5] transition shadow-sm border border-transparent hover:border-[#839958]/30">
                                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                                       class="w-5 h-5 rounded-lg border-[#839958]/30 text-primary focus:ring-primary transition cursor-pointer"
                                                       {{ in_array($category->id, old('categories', $content->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-primaryDark group-hover:text-primary transition">{{ $category->name }}</span>
                                                    @if($category->parent)
                                                        <span class="text-[10px] text-[#105666] font-medium italic">Under {{ $category->parent->name }}</span>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                @if(!$loop->last) <div class="h-px bg-[#839958]/20 my-4"></div> @endif
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-4">Meta Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden peer"
                                           {{ in_array($tag->id, old('tags', $content->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="px-3 py-1.5 rounded-xl border-2 border-[#839958]/30 text-xs font-bold text-[#105666] peer-checked:bg-primary peer-checked:text-[#F7F4D5] peer-checked:border-primary transition duration-200 hover:border-primary hover:text-primary">
                                        #{{ $tag->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full mt-10 btn-accent py-5 rounded-[1.5rem] shadow-2xl text-lg font-black uppercase tracking-widest hover:scale-[1.03] active:scale-95 transition-all text-[#0A3323] border-none cursor-pointer" style="background: var(--btn-accent)">
                    <i class="ph-bold ph-floppy-disk mr-2"></i> Commit Changes
                </button>
                
                <button type="button" onclick="confirmDelete()" class="w-full mt-4 py-4 text-[#EF4444] font-black uppercase text-xs tracking-widest hover:bg-red-50 rounded-2xl transition">
                    <i class="ph ph-trash-simple mr-2 text-lg align-middle"></i> Permanently Delete
                </button>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('admin.content.destroy', $content) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Delete Asset?',
            text: "This item will be moved to trash and can be restored later.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#9CA3AF',
            confirmButtonText: 'Yes, Delete',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                cancelButton: 'rounded-xl px-6 py-3 font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-input');
        const fileDisplay = document.getElementById('file-name-display');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileDisplay.textContent = "New: " + this.files[0].name;
                fileDisplay.classList.remove('text-[#8496A6]');
                fileDisplay.classList.add('text-primary', 'font-black', 'text-lg');
            }
        });
    });
</script>
@endsection
