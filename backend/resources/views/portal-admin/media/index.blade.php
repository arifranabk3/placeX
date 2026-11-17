@extends('portal-admin.layouts.app', ['title' => 'Media Library'])

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Marketplace Media Library</h1>
            <p class="text-xs text-slate-500 mt-1">Upload, inspect, and organize photographs, vehicle galleries, and listing assets.</p>
        </div>
    </div>

    <!-- Upload Box -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-placex-line">
        <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 mb-3">Upload New Image Asset</h2>
        <form method="POST" action="{{ route('portal-admin.media.upload') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-3">
            @csrf
            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" required
                   class="w-full sm:flex-1 text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#fff3e8] file:text-orange hover:file:bg-[#ffe7d1]">
            <button type="submit" class="w-full sm:w-auto btn-portal-primary px-5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shadow-sm">
                <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Upload Image
            </button>
        </form>
        <p class="text-[10px] text-slate-400 mt-2">Max allowed image file size is 5MB (JPEG, PNG, WebP). Files are stored safely in local public storage.</p>
    </div>

    <!-- Media Grid -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-placex-line">
        <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 mb-4">Stored Media Assets ({{ $images->total() }})</h2>

        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
            @forelse($images as $img)
                <div class="group relative rounded-xl border border-slate-200 overflow-hidden bg-slate-50 aspect-square">
                    <img src="{{ $img->image_url }}" alt="Media" class="w-full h-full object-cover">
                    
                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-2 text-white">
                        <span class="text-[9px] font-mono truncate">{{ basename($img->image_url) }}</span>
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold">{{ $img->is_primary ? 'Primary' : 'Gallery' }}</span>
                            <form method="POST" action="{{ route('portal-admin.media.destroy', $img) }}" onsubmit="return confirm('Delete image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-rose-600 rounded text-white hover:bg-rose-700 text-[10px]">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-6 py-8 text-center text-slate-400 text-xs">
                    No images stored in library.
                </div>
            @endforelse
        </div>

        @if($images->hasPages())
            <div class="pt-6 mt-6 border-t border-slate-100">
                {{ $images->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
