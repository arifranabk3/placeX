@extends('portal-admin.layouts.app', ['title' => 'SEO & OpenGraph'])

@section('content')
<div class="space-y-6 w-full">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">SEO &amp; OpenGraph Management</h1>
            <p class="text-xs text-slate-500 mt-1">Configure meta tags, title prefixes, and social media cards consumed by Next.js.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('portal-admin.seo.update') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
                Global Metadata Defaults
            </h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Default Meta Title <span class="text-orange">*</span></label>
                <input type="text" name="default_title" value="{{ old('default_title', $siteTitle) }}" required
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Default Meta Description <span class="text-orange">*</span></label>
                <textarea name="default_description" rows="3" required
                          class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 leading-relaxed">{{ old('default_description', $siteDescription) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">OpenGraph Social Share Image URL</label>
                <input type="url" name="default_og_image" value="{{ old('default_og_image', $ogImage) }}"
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Save SEO Metadata
            </button>
        </div>
    </form>

</div>
@endsection
