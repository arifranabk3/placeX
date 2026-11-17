@extends('portal-admin.layouts.app', ['title' => 'Create Marketplace Listing'])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Create Marketplace Listing</h1>
            <p class="text-xs text-slate-500 mt-1">Compose a draft or immediately publish content to the public PlaceX portal.</p>
        </div>
        <a href="{{ route('portal-admin.listings.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('portal-admin.listings.store') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-6">
        @csrf

        <!-- Core Fields -->
        <div class="space-y-4">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Listing Overview
            </h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Listing Title <span class="text-orange">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Senior Laravel Engineer or 2022 Toyota Corolla Altis"
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                @error('title') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Category <span class="text-orange">*</span></label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <optgroup label="{{ $cat->name }}">
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }} (Main)</option>
                                @foreach($cat->children as $sub)
                                    <option value="{{ $sub->id }}" {{ old('category_id') == $sub->id ? 'selected' : '' }}>&nbsp;&nbsp;&bull; {{ $sub->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Location City</label>
                    <select name="location_id" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', 0) }}"
                           class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Currency</label>
                    <input type="text" name="currency" value="{{ old('currency', 'PKR') }}"
                           class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Description <span class="text-orange">*</span></label>
                <textarea name="description" rows="5" required placeholder="Write a thorough overview describing the listing, condition, or specifications..."
                          class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 leading-relaxed">{{ old('description') }}</textarea>
                @error('description') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Primary Image URL</label>
                <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/... or /storage/uploads/..."
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                <p class="text-[10px] text-slate-400 mt-1">Accepts live public CDN images or local storage URLs.</p>
            </div>
        </div>

        <!-- Lifecycle & Publishing -->
        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Publication Workflow
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Listing Status</label>
                    <select name="listing_status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        <option value="active" {{ old('listing_status') === 'active' ? 'selected' : '' }}>Active (Publish Live on Next.js)</option>
                        <option value="draft" {{ old('listing_status') === 'draft' ? 'selected' : '' }}>Save as Draft (Private)</option>
                        <option value="inactive" {{ old('listing_status') === 'inactive' ? 'selected' : '' }}>Inactive / Offline</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Moderation Status</label>
                    <select name="moderation_status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        <option value="approved" {{ old('moderation_status') === 'approved' ? 'selected' : '' }}>Approved (Authorized)</option>
                        <option value="pending" {{ old('moderation_status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('portal-admin.listings.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                Discard
            </a>
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Save &amp; Process Listing
            </button>
        </div>
    </form>

</div>
@endsection
