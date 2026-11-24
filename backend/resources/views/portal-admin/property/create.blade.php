@extends('portal-admin.layouts.app', ['title' => 'Post Real Estate Property'])

@section('content')
<div class="space-y-6 w-full">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Post Real Estate Listing</h1>
            <p class="text-xs text-slate-500 mt-1">Publish a house, flat, commercial space or plot to <code>/property</code>.</p>
        </div>
        <a href="{{ route('portal-admin.property.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('portal-admin.property.store') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-5">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id ?? 2 }}">

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Property Heading / Title <span class="text-orange">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. 1 Kanal Modern Designer House in DHA Phase 6"
                   class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Purpose</label>
                <select name="property_purpose" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="sale">For Sale</option>
                    <option value="rent">For Rent</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Property Type</label>
                <select name="property_type" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="house">House</option>
                    <option value="flat">Apartment / Flat</option>
                    <option value="plot">Plot</option>
                    <option value="commercial">Commercial</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">City Location</label>
                <select name="location_id" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Price (PKR) <span class="text-orange">*</span></label>
                <input type="number" step="0.01" name="price" required placeholder="35000000" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Area Size</label>
                <input type="text" name="area_size" placeholder="10 Marla or 1 Kanal" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Bedrooms / Baths</label>
                <div class="flex space-x-2">
                    <input type="number" name="bedrooms" placeholder="Beds: 4" class="w-1/2 px-3 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <input type="number" name="bathrooms" placeholder="Baths: 4" class="w-1/2 px-3 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Property Description <span class="text-orange">*</span></label>
            <textarea name="description" rows="5" required placeholder="Describe prime location features, fixtures, nearby schools, amenities..."
                      class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 leading-relaxed"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
            <select name="listing_status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                <option value="active">Active (Publish Live on Next.js)</option>
                <option value="draft">Draft (Private)</option>
            </select>
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('portal-admin.property.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                Discard
            </a>
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Publish Property
            </button>
        </div>
    </form>

</div>
@endsection
