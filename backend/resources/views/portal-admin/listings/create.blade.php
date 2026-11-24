@extends('portal-admin.layouts.app', ['title' => 'Create Listing (Live Preview)'])

@section('content')
<div class="space-y-4" x-data="portalListingEditor({
    categories: {{ Js::from($categories) }},
    locations: {{ Js::from($locations) }},
    initial: {
        title: '',
        category_id: {{ $categories->first()->id ?? 1 }},
        location_id: {{ $locations->first()->id ?? 1 }},
        price: 50000,
        currency: 'PKR',
        description: '',
        listing_status: 'draft',
        moderation_status: 'approved',
        is_featured: false,
        // Jobs
        company_name: '',
        job_type: 'full-time',
        experience_level: 'mid-level',
        salary_min: 80000,
        salary_max: 150000,
        // Property
        property_purpose: 'sale',
        property_type: 'house',
        area_size: '5 Marla',
        bedrooms: 3,
        bathrooms: 3,
        // Classifieds
        condition: 'used',
        brand: '',
        model: '',
        // Vehicles
        make: 'Honda',
        vehicle_model: 'Civic',
        year: 2022,
        mileage: 38000,
        transmission: 'automatic',
        fuel_type: 'petrol',
        // Matrimonial
        gender: 'male',
        age: 28,
        marital_status: 'single',
        religion: 'Islam - Sunni',
        education: 'Masters',
        profession: 'Software Engineer',
    },
    initialImages: []
})">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-4 rounded-2xl border border-placex-line shadow-sm">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-pen-ruler text-orange"></i>
                <span>Create Marketplace Listing</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Real-time split-screen synchronization matching PlaceX Next.js card and detail components.</p>
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

            <a href="{{ route('portal-admin.listings.index') }}" class="px-3.5 py-1.5 border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
                Cancel
            </a>

            <button type="button" @click="saveListing('draft')" class="px-3.5 py-1.5 border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
                <i class="fa-regular fa-bookmark mr-1"></i> Save Draft
            </button>
            <button type="button" @click="saveListing('active')" class="btn-portal-primary px-4 py-1.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                <i class="fa-solid fa-paper-plane mr-1"></i> Publish Live
            </button>
        </div>
    </div>

    <!-- Split-Screen Editor Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- LEFT COLUMN: REACTIVE FORM (7 cols) -->
        <div class="lg:col-span-7 bg-white p-5 sm:p-6 rounded-2xl border border-placex-line shadow-sm space-y-6"
             :class="{ 'hidden lg:block': mobileTab === 'preview' }">

            <form id="listingForm" method="POST" action="{{ route('portal-admin.listings.store') }}" @submit.prevent="submitRealForm">
                @csrf
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
                    <span>Real-Time Public Preview</span>
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
                    <span class="font-bold">Next.js Client Synchronization:</span>
                    <p class="text-blue-800/80 mt-0.5">This preview renders instant reactive Blade elements reflecting the public PlaceX design tokens without persisting to the database until you click Publish or Save.</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
@include('portal-admin.listings.partials.editor-script')
@endpush
