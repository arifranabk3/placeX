@extends('admin.layouts.app')

@section('title', 'User: ' . $user->name)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 rounded-full bg-primary-100 text-primary-800 font-bold text-lg flex items-center justify-center">
                {{ $user->initials() }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
                <p class="text-sm text-slate-500">{{ $user->email }} · Member since {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            @if(auth()->user()->hasPermission('users.edit'))
                <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-primary-900 text-white text-sm font-medium rounded-lg hover:bg-primary-800 transition">
                    Edit User
                </a>
            @endif
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Details Card -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">Profile Overview</h2>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-slate-500 block">Full Name</span>
                    <span class="font-medium text-slate-900">{{ $user->name }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Email Address</span>
                    <span class="font-medium text-slate-900">{{ $user->email }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Phone</span>
                    <span class="font-medium text-slate-900">{{ $user->phone ?? 'Not provided' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Account Status</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Assigned Roles</span>
                    <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($user->roles as $role)
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-800 rounded text-xs font-medium">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
                @if($user->sellerProfile)
                    <div class="pt-3 border-t border-slate-100">
                        <span class="text-xs text-slate-500 block">Seller Profile</span>
                        <span class="font-medium text-slate-900 block mt-0.5">{{ $user->sellerProfile->business_name }}</span>
                        <span class="text-xs text-slate-500">Verified: {{ $user->sellerProfile->is_verified ? 'Yes' : 'No' }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Listings -->
        <div class="lg:col-span-2 bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">User Listings ({{ $user->listings->count() }})</h2>
            <div class="divide-y divide-slate-100">
                @forelse($user->listings as $listing)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <a href="{{ route('admin.listings.show', $listing) }}" class="font-medium text-sm text-slate-900 hover:text-primary-600">
                                {{ $listing->title }}
                            </a>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $listing->category->name ?? 'General' }} · {{ $listing->currency }} {{ number_format($listing->price) }} · {{ $listing->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 rounded text-xs font-medium {{ $listing->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($listing->listing_status) }}
                            </span>
                            <span class="px-2 py-0.5 rounded text-xs font-medium {{ $listing->moderation_status === 'approved' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ ucfirst($listing->moderation_status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 py-4">No listings posted by this user yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
