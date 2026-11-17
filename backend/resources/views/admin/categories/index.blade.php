@extends('admin.layouts.app')

@section('title', 'Categories & Taxonomy')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Categories & Taxonomies</h1>
            <p class="text-sm text-slate-500 mt-1">Structure the 5 PlaceX core categories (Jobs, Property, Classifieds, Vehicles, Matrimonial) and their subcategories.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Category Form -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Add New Category</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Category Name</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Slug (leave blank to auto-generate)</label>
                    <input type="text" name="slug" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Parent Category</label>
                    <select name="parent_id" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">None (Top-Level Category)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Icon Identifier</label>
                    <input type="text" name="icon" placeholder="e.g. car, brief-case, home" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div class="flex items-center space-x-2 pt-2">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-primary-900 focus:ring-primary-500">
                    <span class="text-sm text-slate-700">Active and visible</span>
                </div>
                <button type="submit" class="w-full py-2 bg-primary-900 text-white text-sm font-semibold rounded-lg hover:bg-primary-800 transition">
                    Create Category
                </button>
            </form>
        </div>

        <!-- Categories Tree & List -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">Existing Categories & Tree</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($categories as $category)
                    <div class="p-4 hover:bg-slate-50 transition" x-data="{ open: false }">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <button @click="open = !open" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                                <div>
                                    <span class="font-bold text-slate-900">{{ $category->name }}</span>
                                    <span class="text-xs text-slate-400 ml-2">/{{ $category->slug }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-medium">
                                    {{ $category->listings_count }} ads
                                </span>
                                <span class="px-2 py-0.5 rounded-full {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $category->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </div>
                        </div>

                        <!-- Subcategories Accordion -->
                        <div x-show="open" x-cloak class="mt-3 ml-7 pl-3 border-l-2 border-slate-200 space-y-2">
                            @forelse($category->children as $child)
                                <div class="flex items-center justify-between py-1 text-sm">
                                    <span class="text-slate-700">{{ $child->name }}</span>
                                    <div class="flex items-center space-x-2 text-xs text-slate-400">
                                        <span>{{ $child->listings_count }} ads</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-xs text-slate-400 py-1">No child categories created.</div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
