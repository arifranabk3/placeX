@extends('portal-admin.layouts.app', ['title' => 'Homepage Content Management'])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Homepage Content Management</h1>
            <p class="text-xs text-slate-500 mt-1">Configure banner headlines, search trending pills, and promotional copy rendered on the Next.js homepage.</p>
        </div>
        <a href="http://localhost:3000" target="_blank" class="px-3.5 py-1.5 rounded-lg bg-orange-50 text-orange border border-orange/20 text-xs font-bold hover:bg-orange-100 transition flex items-center space-x-1">
            <span>Live Homepage</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
        </a>
    </div>

    <form method="POST" action="{{ route('portal-admin.homepage.update') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Hero Section Configuration
            </h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Hero Main Headline <span class="text-orange">*</span></label>
                <input type="text" name="hero_headline" value="{{ old('hero_headline', $heroHeadline) }}" required
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Hero Subheadline <span class="text-orange">*</span></label>
                <input type="text" name="hero_subheadline" value="{{ old('hero_subheadline', $heroSubheadline) }}" required
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Trending Search Keywords (Comma-separated)</label>
                <input type="text" name="trending_keywords" value="{{ old('trending_keywords', $trendingPills) }}" required
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                <p class="text-[10px] text-slate-400 mt-1">These pills appear directly underneath the homepage search bar on Next.js.</p>
            </div>

            <div class="pt-2">
                <label class="flex items-center space-x-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="banner_active" value="1" {{ $bannerActive == '1' ? 'checked' : '' }} class="rounded text-orange focus:ring-orange">
                    <span>Display Promotional Hero Banner</span>
                </label>
            </div>
        </div>

        <!-- Featured Carousel Preview -->
        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Current Homepage Featured Items ({{ $featuredListings->count() }})
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach($featuredListings as $fItem)
                    <div class="p-2.5 rounded-xl border border-slate-200 bg-slate-50 flex flex-col justify-between">
                        <div class="text-xs font-bold text-slate-900 truncate">{{ $fItem->title }}</div>
                        <div class="text-[10px] text-slate-500 mt-1">{{ $fItem->category->name ?? 'General' }} · PKR {{ number_format($fItem->price) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Save Homepage Content
            </button>
        </div>
    </form>

</div>
@endsection
