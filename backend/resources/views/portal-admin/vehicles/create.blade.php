@extends('portal-admin.layouts.app', ['title' => 'Post Vehicle Listing'])

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Post Vehicle Listing</h1>
            <p class="text-xs text-slate-500 mt-1">Publish an automobile or motorcycle to <code>/vehicles</code>.</p>
        </div>
        <a href="{{ route('portal-admin.vehicles.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('portal-admin.vehicles.store') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-5">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id ?? 4 }}">

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Vehicle Listing Title <span class="text-orange">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. 2022 Honda Civic RS Turbo Oriel White"
                   class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Make <span class="text-orange">*</span></label>
                <input type="text" name="make" value="{{ old('make', 'Honda') }}" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Model <span class="text-orange">*</span></label>
                <input type="text" name="vehicle_model" value="{{ old('vehicle_model', 'Civic') }}" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Year</label>
                <input type="number" name="year" value="{{ old('year', 2022) }}" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Price (PKR) <span class="text-orange">*</span></label>
                <input type="number" step="0.01" name="price" required placeholder="8500000" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Mileage (km)</label>
                <input type="number" name="mileage" value="{{ old('mileage', 35000) }}" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
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

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Transmission</label>
                <select name="transmission" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="automatic">Automatic</option>
                    <option value="manual">Manual</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Fuel Type</label>
                <select name="fuel_type" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="petrol">Petrol</option>
                    <option value="diesel">Diesel</option>
                    <option value="hybrid">Hybrid</option>
                    <option value="electric">Electric</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Vehicle Details &amp; Condition <span class="text-orange">*</span></label>
            <textarea name="description" rows="5" required placeholder="Detail the car features, maintenance history, bumper-to-bumper condition..."
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
            <a href="{{ route('portal-admin.vehicles.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                Discard
            </a>
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Publish Vehicle
            </button>
        </div>
    </form>

</div>
@endsection
