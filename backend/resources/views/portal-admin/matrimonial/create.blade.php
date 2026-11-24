@extends('portal-admin.layouts.app', ['title' => 'Register Matrimonial Candidate'])

@section('content')
<div class="space-y-6 w-full">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Register Matrimonial Profile</h1>
            <p class="text-xs text-slate-500 mt-1">Add a confidential matchmaking candidate profile to <code>/matrimonial</code>.</p>
        </div>
        <a href="{{ route('portal-admin.matrimonial.index') }}" class="px-3.5 py-1.5 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('portal-admin.matrimonial.store') }}" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-placex-line space-y-5">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id ?? 5 }}">

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Profile Heading / Alias <span class="text-orange">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Well Settled Software Engineer (MSc CS), Lahore"
                   class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Candidate Gender</label>
                <select name="gender" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="male">Male (Groom)</option>
                    <option value="female">Female (Bride)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Age (Years)</label>
                <input type="number" name="age" value="28" required class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Marital Status</label>
                <select name="marital_status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="single">Never Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Religion / Sect</label>
                <input type="text" name="religion" value="Islam - Sunni" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Highest Education</label>
                <input type="text" name="education" value="MS Computer Science" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Profession</label>
                <input type="text" name="profession" value="Software Architect" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">City Location</label>
                <select name="location_id" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Publication Status</label>
                <select name="listing_status" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl text-slate-900 font-medium">
                    <option value="active">Active (Publish Live on Next.js)</option>
                    <option value="draft">Draft (Private)</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Family Background &amp; Partner Preferences <span class="text-orange">*</span></label>
            <textarea name="description" rows="5" required placeholder="Detail religious practice, family values, caste/community, partner requirements..."
                      class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 leading-relaxed"></textarea>
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('portal-admin.matrimonial.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                Discard
            </a>
            <button type="submit" class="btn-portal-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-orange-500/20">
                Register Matrimonial Profile
            </button>
        </div>
    </form>

</div>
@endsection
