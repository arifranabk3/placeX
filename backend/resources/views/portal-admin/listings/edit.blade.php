@extends('portal-admin.layouts.app', ['title' => 'Edit Listing: ' . $listing->title])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Listing</h1>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $listing->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-700' }}">
                    {{ ucfirst($listing->listing_status) }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Slug: <code class="text-slate-700 font-mono">{{ $listing->slug }}</code> · Category: <b>{{ $listing->category->name ?? 'General' }}</b></p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="http://localhost:3000/listings/{{ $listing->slug }}" target="_blank" class="px-3.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold hover:bg-blue-100 transition flex items-center space-x-1">
                <span>View on Next.js</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
            <a href="{{ route('portal-admin.listings.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
                Back
            </a>
        </div>
    </div>

    <!-- Quick State Control Bar -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-placex-line flex items-center justify-between">
        <div class="text-xs text-slate-600">
            Publish state: <span class="font-bold text-slate-900">{{ ucfirst($listing->listing_status) }}</span> · 
            Moderation: <span class="font-bold text-slate-900">{{ ucfirst($listing->moderation_status) }}</span>
        </div>
        <div class="flex items-center space-x-2">
            @if($listing->listing_status !== 'active')
                <form method="POST" action="{{ route('portal-admin.listings.publish', $listing) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition">
                        <i class="fa-solid fa-globe mr-1"></i> Make Live (Publish)
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('portal-admin.listings.unpublish', $listing) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition">
                        <i class="fa-solid fa-eye-slash mr-1"></i> Unpublish (Hide)
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('portal-admin.listings.pause', $listing) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-bold transition">
                    {{ $listing->listing_status === 'paused' ? 'Resume' : 'Pause' }}
                </button>
            </form>
        </div>
    </div>

    <form method="POST" action="{{ route('portal-admin.listings.update', $listing) }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-6">
        @csrf
        @method('PUT')

        <!-- Overview Fields -->
        <div class="space-y-4">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Listing Content
            </h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Listing Title <span class="text-orange">*</span></label>
                <input type="text" name="title" value="{{ old('title', $listing->title) }}" required
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Category <span class="text-orange">*</span></label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        @foreach($categories as $cat)
                            <optgroup label="{{ $cat->name }}">
                                <option value="{{ $cat->id }}" {{ old('category_id', $listing->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }} (Main)</option>
                                @foreach($cat->children as $sub)
                                    <option value="{{ $sub->id }}" {{ old('category_id', $listing->category_id) == $sub->id ? 'selected' : '' }}>&nbsp;&nbsp;&bull; {{ $sub->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Location City</label>
                    <select name="location_id" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id', $listing->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $listing->price) }}"
                           class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Currency</label>
                    <input type="text" name="currency" value="{{ old('currency', $listing->currency) }}"
                           class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Description <span class="text-orange">*</span></label>
                <textarea name="description" rows="5" required
                          class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 leading-relaxed">{{ old('description', $listing->description) }}</textarea>
            </div>

            @php $primaryImg = $listing->images->where('is_primary', true)->first() ?? $listing->images->first(); @endphp
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Primary Image URL</label>
                <input type="url" name="image_url" value="{{ old('image_url', $primaryImg ? $primaryImg->image_url : '') }}"
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
            </div>
        </div>

        <!-- Vertical Specific Specs (If applicable) -->
        @if($listing->jobDetail)
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                    Job Specifications
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Company / Employer</label>
                        <input type="text" name="company_name" value="{{ old('company_name', $listing->jobDetail->company_name) }}"
                               class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Job Type</label>
                        <input type="text" name="job_type" value="{{ old('job_type', $listing->jobDetail->job_type) }}"
                               class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    </div>
                </div>
            </div>
        @endif

        @if($listing->vehicleDetail)
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                    Vehicle Specifications
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Make</label>
                        <input type="text" name="make" value="{{ old('make', $listing->vehicleDetail->make) }}"
                               class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Model</label>
                        <input type="text" name="vehicle_model" value="{{ old('vehicle_model', $listing->vehicleDetail->model) }}"
                               class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Model Year</label>
                        <input type="number" name="year" value="{{ old('year', $listing->vehicleDetail->year) }}"
                               class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    </div>
                </div>
            </div>
        @endif

        <!-- Lifecycle Controls -->
        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Publication Status
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Listing Status</label>
                    <select name="listing_status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        <option value="active" {{ old('listing_status', $listing->listing_status) === 'active' ? 'selected' : '' }}>Active (Live on Next.js)</option>
                        <option value="draft" {{ old('listing_status', $listing->listing_status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="paused" {{ old('listing_status', $listing->listing_status) === 'paused' ? 'selected' : '' }}>Paused</option>
                        <option value="inactive" {{ old('listing_status', $listing->listing_status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="closed" {{ old('listing_status', $listing->listing_status) === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Moderation Status</label>
                    <select name="moderation_status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                        <option value="approved" {{ old('moderation_status', $listing->moderation_status) === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ old('moderation_status', $listing->moderation_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ old('moderation_status', $listing->moderation_status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('portal-admin.listings.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                Discard
            </a>
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Update Listing
            </button>
        </div>
    </form>

</div>
@endsection
