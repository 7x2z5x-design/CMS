@extends('admin.layout')
@section('title', 'Add New Content')

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
        <h1 class="text-3xl font-extrabold text-primaryDark tracking-tight">Create Something New</h1>
        <p class="text-[0.95rem] text-[#105666] mt-1">Transform your ideas into posts or multimedia assets.</p>
    </div>
    <a href="{{ route('admin.content.index') }}" class="px-5 py-2.5 rounded-2xl bg-white/20 border border-[#0A3323]/20 text-[#0A3323] font-bold text-sm hover:bg-white/40 transition flex items-center gap-2">
        <i class="ph ph-arrow-left"></i> Back to Hub
    </a>
</div>


<form action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data" class="max-w-[1200px]">
    @csrf
    
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
                        <i class="ph-bold ph-note-pencil text-xl"></i>
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-tighter">The Essentials</h3>
                </div>

                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Content Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="w-full px-6 py-4 rounded-[1.5rem] border-2 border-[#839958]/30 bg-[#F7F4D5] focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition text-lg font-bold placeholder-[#105666]/30" 
                               placeholder="What's on your mind today?" required>
                    </div>

                    </div>

                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Description / Story Block</label>
                        <textarea name="description" rows="12" 
                                  class="w-full px-6 py-4 rounded-[1.5rem] border-2 border-[#839958]/30 bg-[#F7F4D5] focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition font-medium text-[#0A3323] placeholder-[#105666]/30" 
                                  placeholder="Dive into the details here...">{{ old('description') }}</textarea>
                    </div>

                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div id="file-upload-section" class="card p-8 bg-[#F7F4D5] border-[#839958] shadow-2xl hidden transition-all">
                <div class="flex items-center gap-3 mb-8 text-primaryDark">
                    <div class="w-10 h-10 rounded-xl bg-[#0A3323]/10 flex items-center justify-center">
                        <i class="ph-bold ph-image-square text-xl"></i>
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-tighter">Multimedia File</h3>
                </div>

                
                <div class="relative group">
                    <input type="file" name="file" id="file-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-4 border-dashed border-[#839958]/50 bg-[#839958]/10 rounded-[2rem] p-12 text-center group-hover:bg-[#839958]/20 group-hover:border-primary transition duration-300">
                        <div class="w-20 h-20 rounded-full bg-[#F7F4D5] text-primary flex items-center justify-center text-4xl mb-6 mx-auto shadow-md group-hover:scale-110 transition">
                            <i class="ph-bold ph-cloud-arrow-up"></i>
                        </div>
                        <p class="text-primaryDark font-black text-xl mb-1">Drop your file here</p>
                        <p class="text-sm text-[#105666] font-medium" id="file-name-display">Images, High-Res Videos, or Audio Clips (Max 20MB)</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-8">
            <div class="card p-8 bg-[#F7F4D5] border-[#839958] shadow-2xl text-[#0A3323]">
                <div class="flex items-center gap-3 mb-8 text-primaryDark">
                    <div class="w-10 h-10 rounded-xl bg-accent/20 flex items-center justify-center text-accent">
                        <i class="ph-bold ph-rocket-launch text-xl"></i>
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-tighter">Publishing</h3>
                </div>


                <div class="space-y-6">
                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Context Type <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="content_type" id="content-type-selector" class="w-full px-5 py-4 rounded-2xl border-2 border-[#839958]/30 bg-[#F7F4D5] appearance-none focus:border-primary outline-none transition font-bold text-[#0A3323]" required>
                                <option value="post" {{ old('content_type') == 'post' ? 'selected' : '' }}>📝 Standard Post</option>
                                <option value="image" {{ old('content_type') == 'image' ? 'selected' : '' }}>🖼️ Visual Image</option>
                                <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>🎥 Dynamic Video</option>
                                <option value="audio" {{ old('content_type') == 'audio' ? 'selected' : '' }}>🎵 Audio Track</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-5 top-1/2 -translate-y-1/2 text-[#105666] pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-3">Lifecycle Status <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="status" class="w-full px-5 py-4 rounded-2xl border-2 border-[#839958]/30 bg-[#F7F4D5] appearance-none focus:border-primary outline-none transition font-bold text-[#0A3323]" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Working Draft</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Ready for Review</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Active & Public</option>
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
                                                       {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
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
                        <label class="block text-[0.7rem] font-black text-primaryDark uppercase tracking-widest mb-4">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden peer"
                                           {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                                    <span class="px-3 py-1.5 rounded-xl border-2 border-[#839958]/30 text-xs font-bold text-[#105666] peer-checked:bg-primary peer-checked:text-[#F7F4D5] peer-checked:border-primary transition duration-200 hover:border-primary hover:text-primary">
                                        #{{ $tag->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full mt-10 btn-accent py-5 rounded-[1.5rem] shadow-2xl text-lg font-black uppercase tracking-widest hover:scale-[1.03] active:scale-95 transition-all text-[#0A3323] cursor-pointer border-none" style="background: var(--btn-accent)">
                    <i class="ph-fill ph-paper-plane-tilt mr-2"></i> Deploy Content
                </button>
            </div>
        </div>

    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selector = document.getElementById('content-type-selector');
        const section = document.getElementById('file-upload-section');
        const fileInput = document.getElementById('file-input');
        const fileDisplay = document.getElementById('file-name-display');

        function toggleUpload() {
            if (selector.value !== 'post') {
                section.classList.remove('hidden');
                section.classList.add('animate-in', 'fade-in', 'slide-in-from-top-4');
            } else {
                section.classList.add('hidden');
            }
        }

        selector.addEventListener('change', toggleUpload);
        toggleUpload();

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileDisplay.textContent = "Selected: " + this.files[0].name;
                fileDisplay.classList.remove('text-[#8496A6]');
                fileDisplay.classList.add('text-primary', 'font-black', 'text-lg');
            }
        });
    });
</script>
@endsection
