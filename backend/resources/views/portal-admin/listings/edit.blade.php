@extends('portal-admin.layouts.app', ['title' => 'Edit Listing: ' . $listing->title])

@section('content')
@php
    $initialImages = $listing->images->map(function($img) {
        return [
            'id' => $img->id,
            'url' => $img->image_path ?: ($img->image_url ?: ''),
            'is_primary' => (bool)$img->is_primary,
            'is_new' => false,
            'is_removed' => false,
        ];
    })->values();

    $initialData = [
        'id' => $listing->id,
        'title' => $listing->title,
        'category_id' => $listing->category_id,
        'location_id' => $listing->location_id,
        'price' => (float)$listing->price,
        'currency' => $listing->currency ?? 'PKR',
        'description' => $listing->description ?? '',
        'listing_status' => $listing->listing_status,
        'moderation_status' => $listing->moderation_status,
        'is_featured' => (bool)$listing->is_featured,
        // Jobs
        'company_name' => $listing->jobDetail->company_name ?? '',
        'job_type' => $listing->jobDetail->employment_type ?? 'full-time',
        'experience_level' => $listing->jobDetail->experience_level ?? 'mid-level',
        'salary_min' => $listing->jobDetail->min_salary ?? null,
        'salary_max' => $listing->jobDetail->max_salary ?? null,
        // Property
        'property_purpose' => $listing->propertyDetail->purpose ?? 'sale',
        'property_type' => $listing->propertyDetail->property_type ?? 'house',
        'area_size' => $listing->propertyDetail->area_size ?? '5 Marla',
        'bedrooms' => $listing->propertyDetail->bedrooms ?? 3,
        'bathrooms' => $listing->propertyDetail->bathrooms ?? 3,
        // Classifieds
        'condition' => $listing->classifiedDetail->condition ?? 'used',
        'brand' => $listing->classifiedDetail->brand ?? '',
        'model' => $listing->classifiedDetail->model ?? '',
        // Vehicles
        'make' => $listing->vehicleDetail->make ?? 'Toyota',
        'vehicle_model' => $listing->vehicleDetail->model ?? 'Corolla',
        'year' => $listing->vehicleDetail->year ?? 2022,
        'mileage' => $listing->vehicleDetail->mileage ?? 45000,
        'transmission' => $listing->vehicleDetail->transmission ?? 'automatic',
        'fuel_type' => $listing->vehicleDetail->fuel_type ?? 'petrol',
        // Matrimonial
        'gender' => $listing->matrimonialProfile->gender ?? 'male',
        'age' => $listing->matrimonialProfile->age ?? 28,
        'marital_status' => $listing->matrimonialProfile->marital_status ?? 'single',
        'religion' => $listing->matrimonialProfile->religion ?? 'Islam',
        'education' => $listing->matrimonialProfile->education ?? 'Masters',
        'profession' => $listing->matrimonialProfile->profession ?? 'Professional',
    ];
@endphp

<div class="space-y-4" x-data="portalListingEditor({
    categories: {{ Js::from($categories) }},
    locations: {{ Js::from($locations) }},
    initial: {{ Js::from($initialData) }},
    initialImages: {{ Js::from($initialImages) }}
})">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-4 rounded-2xl border border-placex-line shadow-sm">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-orange"></i>
                    <span>Edit Marketplace Listing</span>
                </h1>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $listing->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-700' }}">
                    {{ ucfirst($listing->listing_status) }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-0.5">
                Slug: <code class="text-slate-700 font-mono">{{ $listing->slug }}</code> · 
                Live preview reflects unsaved edits in real time.
            </p>
        </div>

        <div class="flex items-center space-x-2">
            <!-- Mobile Switch Tabs -->
            <div class="flex lg:hidden bg-slate-100 p-0.5 rounded-lg text-xs font-bold mr-2">
                <button type="button" @click="mobileTab = 'form'" class="px-2.5 py-1 rounded" :class="mobileTab === 'form' ? 'bg-white shadow text-slate-900' : 'text-slate-600'">
                    Editor
                </button>
                <button type="button" @click="mobileTab = 'preview'" class="px-2.5 py-1 rounded" :class="mobileTab === 'preview' ? 'bg-white shadow text-slate-900' : 'text-slate-600'">
                    Live Preview
                </button>
            </div>

            <!-- Cancel / Discard Unsaved Changes -->
            <a href="{{ route('portal-admin.listings.index') }}" 
               onclick="return confirm('Discard all unsaved edits? Saved data on server will remain intact.')"
               class="px-3 py-1.5 border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
                Discard Edits
            </a>

            <!-- Save as Draft (keeps private) -->
            <button type="button" @click="saveListing('draft')" class="px-3 py-1.5 border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
                <i class="fa-regular fa-bookmark mr-1"></i> Save Draft
            </button>

            <!-- Save & Publish Live -->
            <button type="button" @click="saveListing('active')" class="btn-portal-primary px-4 py-1.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Update &amp; Publish
            </button>
        </div>
    </div>

    <!-- Quick State & Actions Bar -->
    <div class="bg-white p-3.5 rounded-xl shadow-xs border border-placex-line flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3 text-xs text-slate-600">
            <span>Publish state: <b class="text-slate-900" x-text="form.listing_status"></b></span>
            <span>·</span>
            <span>Category: <b class="text-slate-900" x-text="getCategoryName()"></b></span>
            <span>·</span>
            <a href="http://localhost:3000/listings/{{ $listing->slug }}" target="_blank" class="text-blue-600 font-bold hover:underline flex items-center gap-1">
                <span>View on Public Next.js</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </div>

        <div class="flex items-center space-x-2">
            @if($listing->listing_status !== 'active')
                <form method="POST" action="{{ route('portal-admin.listings.publish', $listing) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition">
                        <i class="fa-solid fa-globe mr-1"></i> Make Live (Publish)
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('portal-admin.listings.unpublish', $listing) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-2.5 py-1 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition">
                        <i class="fa-solid fa-eye-slash mr-1"></i> Unpublish (Hide)
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('portal-admin.listings.pause', $listing) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-2.5 py-1 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-bold transition">
                    {{ $listing->listing_status === 'paused' ? 'Resume' : 'Pause' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Split-Screen Editor Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- LEFT COLUMN: REACTIVE FORM (7 cols) -->
        <div class="lg:col-span-7 bg-white p-5 sm:p-6 rounded-2xl border border-placex-line shadow-sm space-y-6"
             :class="{ 'hidden lg:block': mobileTab === 'preview' }">

            <form id="listingForm" method="POST" action="{{ route('portal-admin.listings.update', $listing) }}" @submit.prevent="submitRealForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="listing_status" :value="form.listing_status">
                <input type="hidden" name="moderation_status" :value="form.moderation_status">

                @include('portal-admin.listings.partials.listing-form-fields')
            </form>
        </div>

        <!-- RIGHT COLUMN: MANDATORY REAL-TIME PREVIEW (5 cols) -->
        <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-20"
             :class="{ 'hidden lg:block': mobileTab === 'form' }">

            <!-- Preview Mode Switcher -->
            <div class="bg-white p-3 rounded-2xl border border-placex-line shadow-sm flex items-center justify-between">
                <span class="text-xs font-black uppercase text-slate-800 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Live Public Preview (Unsaved)</span>
                </span>

                <div class="bg-slate-100 p-0.5 rounded-lg flex items-center text-xs font-bold">
                    <button type="button" 
                            @click="previewMode = 'card'"
                            class="px-3 py-1 rounded transition"
                            :class="previewMode === 'card' ? 'bg-white shadow text-[#ff5a0a]' : 'text-slate-600 hover:text-slate-900'">
                        <i class="fa-solid fa-table-cells-large mr-1 text-[10px]"></i> Card Mode
                    </button>
                    <button type="button" 
                            @click="previewMode = 'detail'"
                            class="px-3 py-1 rounded transition"
                            :class="previewMode === 'detail' ? 'bg-white shadow text-[#ff5a0a]' : 'text-slate-600 hover:text-slate-900'">
                        <i class="fa-solid fa-newspaper mr-1 text-[10px]"></i> Detail Mode
                    </button>
                </div>
            </div>

            <!-- Preview Viewport Container -->
            <div class="transition-all duration-200">
                <template x-if="previewMode === 'card'">
                    @include('portal-admin.listings.partials.card-preview')
                </template>

                <template x-if="previewMode === 'detail'">
                    @include('portal-admin.listings.partials.detail-preview')
                </template>
            </div>

            <!-- Preview Status Notice -->
            <div class="p-3 bg-blue-50/70 border border-blue-100 rounded-xl text-[11px] text-blue-900 flex items-start space-x-2">
                <i class="fa-solid fa-circle-info text-blue-600 text-xs mt-0.5"></i>
                <div>
                    <span class="font-bold">Parity with Create Form:</span>
                    <p class="text-blue-800/80 mt-0.5">Existing images are preserved safely on server until you confirm deletion by saving. Removing or reordering in this form updates preview instantly without deleting server files.</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
@include('portal-admin.listings.partials.editor-script')
@endpush
