@extends('portal-admin.layouts.app', ['title' => 'Categories & Taxonomies'])

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Marketplace Taxonomies</h1>
            <p class="text-xs text-slate-500 mt-1">Structure the 5 public verticals (Jobs, Property, Classifieds, Vehicles, Matrimonial) and sub-tags.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Category Form -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-placex-line space-y-4">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Add Subcategory / Tag
            </h2>
            <form method="POST" action="{{ route('portal-admin.categories.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Category Name <span class="text-orange">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Graphic Designers or Commercial Plots"
                           class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Parent Vertical</label>
                    <select name="parent_id" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                        <option value="">None (Top-Level Vertical)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slug (auto-generated if empty)</label>
                    <input type="text" name="slug" placeholder="e.g. commercial-plots"
                           class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Icon (FontAwesome class)</label>
                    <input type="text" name="icon" placeholder="fa-solid fa-tag"
                           class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                </div>
                <div class="pt-2">
                    <label class="flex items-center space-x-2 text-xs font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-orange focus:ring-orange">
                        <span>Active on public website</span>
                    </label>
                </div>
                <button type="submit" class="w-full btn-portal-primary py-2.5 rounded-xl text-xs font-bold shadow-sm mt-2">
                    Create Taxonomy
                </button>
            </form>
        </div>

        <!-- Category Tree -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-placex-line overflow-hidden p-6 space-y-4">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Current Marketplace Taxonomy Tree
            </h2>

            <div class="divide-y divide-slate-100">
                @foreach($categories as $category)
                    <div class="py-3" x-data="{ open: true }">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <button @click="open = !open" class="text-slate-400 hover:text-slate-600">
                                    <i class="fa-solid fa-chevron-right text-xs transition-transform" :class="{ 'rotate-90': open }"></i>
                                </button>
                                <span class="font-bold text-xs text-slate-900">{{ $category->name }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">/{{ $category->slug }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                {{ $category->listings_count }} ads
                            </span>
                        </div>

                        <div x-show="open" class="ml-6 pl-3 border-l-2 border-slate-200 mt-2 space-y-1">
                            @forelse($category->children as $child)
                                <div class="flex items-center justify-between text-xs py-1 text-slate-600">
                                    <span>&bull; {{ $child->name }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $child->listings_count }} ads</span>
                                </div>
                            @empty
                                <div class="text-[11px] text-slate-400 py-1">No subcategories created.</div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
