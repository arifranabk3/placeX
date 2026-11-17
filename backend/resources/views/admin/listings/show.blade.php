@extends('admin.layouts.app')

@section('title', 'Listing: ' . $listing->title)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="text-2xl font-bold text-slate-900">{{ $listing->title }}</h1>
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $listing->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($listing->listing_status) }}
                </span>
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $listing->moderation_status === 'approved' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                    {{ ucfirst($listing->moderation_status) }}
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">
                Category: <span class="font-medium text-slate-800">{{ $listing->category->name ?? 'None' }}</span> · 
                Posted by: <a href="{{ route('admin.users.show', $listing->user) }}" class="font-medium text-primary-600 hover:underline">{{ $listing->user->name ?? 'Unknown' }}</a> · 
                Date: {{ $listing->created_at->format('M d, Y') }}
            </p>
        </div>
        <div class="flex items-center space-x-2">
            @if(auth()->user()->hasPermission('listings.edit'))
                <a href="{{ route('admin.listings.edit', $listing) }}" class="px-4 py-2 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                    Edit Ad
                </a>
            @endif
            <a href="{{ route('admin.listings.index') }}" class="px-4 py-2 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                Back
            </a>
        </div>
    </div>

    <!-- Quick Moderation Bar -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">Moderation Decision</div>
            <p class="text-xs text-slate-500">Current status is <span class="font-bold text-slate-800">{{ ucfirst($listing->moderation_status) }}</span></p>
        </div>
        <form method="POST" action="{{ route('admin.listings.update-moderation', $listing) }}" class="flex items-center space-x-2">
            @csrf
            @method('PATCH')
            <input type="text" name="rejection_reason" placeholder="Rejection reason (if rejecting)..." class="px-3 py-1.5 text-xs border border-slate-200 rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <button type="submit" name="status" value="approved" class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-semibold rounded-lg hover:bg-emerald-700 transition">
                Approve Ad
            </button>
            <button type="submit" name="status" value="rejected" class="px-3 py-1.5 bg-rose-600 text-white text-xs font-semibold rounded-lg hover:bg-rose-700 transition">
                Reject Ad
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Details Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Description & Overview</h3>
                <div class="prose max-w-none text-sm text-slate-700 leading-relaxed">
                    {!! nl2br(e($listing->description)) !!}
                </div>
            </div>

            <!-- Specific Category Specs -->
            @if($listing->jobDetail)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Job Specifications</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-xs text-slate-500 block">Company:</span> <span class="font-medium text-slate-900">{{ $listing->jobDetail->company_name ?? '—' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Job Type:</span> <span class="font-medium text-slate-900">{{ $listing->jobDetail->job_type ?? '—' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Experience:</span> <span class="font-medium text-slate-900">{{ $listing->jobDetail->experience_level ?? '—' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Salary Range:</span> <span class="font-medium text-slate-900">{{ $listing->jobDetail->salary_min ? number_format($listing->jobDetail->salary_min) . ' - ' . number_format($listing->jobDetail->salary_max) : 'Negotiable' }}</span></div>
                    </div>
                </div>
            @endif

            @if($listing->propertyDetail)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Property Specifications</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                        <div><span class="text-xs text-slate-500 block">Purpose:</span> <span class="font-medium text-slate-900 uppercase">{{ $listing->propertyDetail->property_purpose ?? 'Sale' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Type:</span> <span class="font-medium text-slate-900">{{ $listing->propertyDetail->property_type ?? '—' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Area Size:</span> <span class="font-medium text-slate-900">{{ $listing->propertyDetail->area_size ?? '—' }} {{ $listing->propertyDetail->area_unit ?? '' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Bedrooms:</span> <span class="font-medium text-slate-900">{{ $listing->propertyDetail->bedrooms ?? '—' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Bathrooms:</span> <span class="font-medium text-slate-900">{{ $listing->propertyDetail->bathrooms ?? '—' }}</span></div>
                    </div>
                </div>
            @endif

            @if($listing->vehicleDetail)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Vehicle Specifications</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                        <div><span class="text-xs text-slate-500 block">Make & Model:</span> <span class="font-medium text-slate-900">{{ $listing->vehicleDetail->make ?? '' }} {{ $listing->vehicleDetail->model ?? '' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Year:</span> <span class="font-medium text-slate-900">{{ $listing->vehicleDetail->year ?? '—' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Mileage:</span> <span class="font-medium text-slate-900">{{ number_format($listing->vehicleDetail->mileage ?? 0) }} km</span></div>
                        <div><span class="text-xs text-slate-500 block">Transmission:</span> <span class="font-medium text-slate-900 capitalize">{{ $listing->vehicleDetail->transmission ?? '—' }}</span></div>
                        <div><span class="text-xs text-slate-500 block">Fuel Type:</span> <span class="font-medium text-slate-900 capitalize">{{ $listing->vehicleDetail->fuel_type ?? '—' }}</span></div>
                    </div>
                </div>
            @endif

            <!-- Matrimonial Profile with Strict Privacy Protection -->
            @if($isMatrimonial)
                <div class="bg-amber-50/60 p-6 rounded-xl border border-amber-200 space-y-3">
                    <div class="flex items-center justify-between border-b border-amber-200 pb-2">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-amber-900">Matrimonial Protected Profile</h3>
                        </div>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-amber-200 text-amber-900">Restricted Privacy</span>
                    </div>

                    @if($canViewMatrimonial && $listing->matrimonialProfile)
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm pt-2">
                            <div><span class="text-xs text-amber-800 block">Gender:</span> <span class="font-medium text-slate-900 capitalize">{{ $listing->matrimonialProfile->gender ?? '—' }}</span></div>
                            <div><span class="text-xs text-amber-800 block">Age:</span> <span class="font-medium text-slate-900">{{ $listing->matrimonialProfile->age ?? '—' }}</span></div>
                            <div><span class="text-xs text-amber-800 block">Marital Status:</span> <span class="font-medium text-slate-900 capitalize">{{ $listing->matrimonialProfile->marital_status ?? '—' }}</span></div>
                            <div><span class="text-xs text-amber-800 block">Religion/Sect:</span> <span class="font-medium text-slate-900">{{ $listing->matrimonialProfile->religion ?? '—' }}</span></div>
                            <div><span class="text-xs text-amber-800 block">Education:</span> <span class="font-medium text-slate-900">{{ $listing->matrimonialProfile->education ?? '—' }}</span></div>
                            <div><span class="text-xs text-amber-800 block">Profession:</span> <span class="font-medium text-slate-900">{{ $listing->matrimonialProfile->profession ?? '—' }}</span></div>
                        </div>
                    @else
                        <p class="text-xs text-amber-800 py-2">
                            Access to confidential matrimonial profile data is restricted to authorized administrators and moderators with the <code>matrimonial.manage</code> permission.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Right Side: Gallery & Meta -->
        <div class="space-y-6">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Price & Location</h3>
                <div class="text-2xl font-black text-slate-900">
                    {{ $listing->currency }} {{ number_format($listing->price) }}
                </div>
                <div class="text-sm text-slate-600">
                    <span class="text-xs text-slate-400 block">Location:</span>
                    <span class="font-medium">{{ $listing->location->name ?? 'Pakistan' }}</span>
                </div>
                <div class="text-xs text-slate-400 pt-2 border-t border-slate-100 space-y-1">
                    <div>Slug: <code class="text-slate-600">{{ $listing->slug }}</code></div>
                    <div>Created: {{ $listing->created_at->format('M d, Y H:i') }}</div>
                    <div>Expires: {{ $listing->expires_at ? $listing->expires_at->format('M d, Y') : 'Never' }}</div>
                </div>
            </div>

            <!-- Photos -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Gallery ({{ $listing->images->count() }})</h3>
                <div class="grid grid-cols-2 gap-2">
                    @forelse($listing->images as $img)
                        <img src="{{ $img->image_url }}" alt="Ad Image" class="w-full h-24 object-cover rounded-lg border border-slate-100">
                    @empty
                        <div class="col-span-2 py-6 text-center text-xs text-slate-400">No images attached</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
