@extends('admin.layouts.app')

@section('title', 'Edit Listing: ' . $listing->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Listing</h1>
            <p class="text-sm text-slate-500 mt-1">Modify ad parameters, title, pricing, and moderation states.</p>
        </div>
        <a href="{{ route('admin.listings.show', $listing) }}" class="px-3 py-2 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('admin.listings.update', $listing) }}" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Listing Title</label>
            <input type="text" name="title" value="{{ old('title', $listing->title) }}" required
                   class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            @error('title') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $listing->price) }}"
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                @error('price') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Currency</label>
                <input type="text" name="currency" value="{{ old('currency', $listing->currency) }}" required
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                @error('currency') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Description</label>
            <textarea name="description" rows="6" required
                      class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', $listing->description) }}</textarea>
            @error('description') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Listing Status</label>
                <select name="listing_status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="active" {{ old('listing_status', $listing->listing_status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('listing_status', $listing->listing_status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="expired" {{ old('listing_status', $listing->listing_status) === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="draft" {{ old('listing_status', $listing->listing_status) === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Moderation Status</label>
                <select name="moderation_status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="pending" {{ old('moderation_status', $listing->moderation_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('moderation_status', $listing->moderation_status) === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('moderation_status', $listing->moderation_status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.listings.show', $listing) }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2 bg-primary-900 text-white text-sm font-semibold rounded-lg hover:bg-primary-800 transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
