@extends('portal-admin.layouts.app', ['title' => 'Post Job Vacancy'])

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Post Job Listing</h1>
            <p class="text-xs text-slate-500 mt-1">Publish an employment opening to the Next.js careers portal.</p>
        </div>
        <a href="{{ route('portal-admin.jobs.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('portal-admin.jobs.store') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-5">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id ?? 1 }}">

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Job Title <span class="text-orange">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Lead Full-Stack Architect (Next.js / Laravel)"
                   class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Company / Hiring Entity <span class="text-orange">*</span></label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" required placeholder="e.g. Systems Limited, Careem, Techlogix"
                       class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">City Location</label>
                <select name="location_id" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Employment Type</label>
                <select name="job_type" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                    <option value="full-time">Full-time</option>
                    <option value="part-time">Part-time</option>
                    <option value="contract">Contract</option>
                    <option value="remote">Remote</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Experience Level</label>
                <select name="experience_level" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                    <option value="entry">Entry Level</option>
                    <option value="mid-level" selected>Mid Level</option>
                    <option value="senior">Senior Level</option>
                    <option value="lead">Lead / Director</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Minimum Monthly Salary (PKR)</label>
                <input type="number" name="salary_min" placeholder="100000" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Maximum Monthly Salary (PKR)</label>
                <input type="number" name="salary_max" placeholder="250000" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Job Description &amp; Responsibilities <span class="text-orange">*</span></label>
            <textarea name="description" rows="5" required placeholder="Detail the duties, requirements, required tools, and perks..."
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
            <a href="{{ route('portal-admin.jobs.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                Discard
            </a>
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Publish Vacancy
            </button>
        </div>
    </form>

</div>
@endsection
