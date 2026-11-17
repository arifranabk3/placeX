@extends('portal-admin.layouts.app', ['title' => 'Post Classified Item'])

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Post Classified Ad</h1>
            <p class="text-xs text-slate-500 mt-1">Publish a consumer product, mobile phone, electronics or general item to <code>/classifieds</code>.</p>
        </div>
        <a href="{{ route('portal-admin.classifieds.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('portal-admin.classifieds.store') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-5">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id ?? 3 }}">

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Item Title <span class="text-orange">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Apple iPhone 15 Pro Max 256GB Natural Titanium (PTA Approved)"
                   class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Price (PKR) <span class="text-orange">*</span></label>
                <input type="number" step="0.01" name="price" required placeholder="395000" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Condition</label>
                <select name="condition" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="new">Brand New</option>
                    <option value="like-new">Open Box / Like New</option>
                    <option value="used" selected>Used</option>
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

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Product Description <span class="text-orange">*</span></label>
            <textarea name="description" rows="5" required placeholder="Include details on warranty, accessories included, cosmetic marks, battery health..."
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
            <a href="{{ route('portal-admin.classifieds.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                Discard
            </a>
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Publish Classified
            </button>
        </div>
    </form>

</div>
@endsection
