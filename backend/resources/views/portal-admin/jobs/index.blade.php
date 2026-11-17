@extends('portal-admin.layouts.app', ['title' => 'Jobs CMS'])

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="w-7 h-7 rounded-lg bg-[#edf4ff] text-[#0874ef] flex items-center justify-center text-xs">
                    <i class="fa-solid fa-briefcase"></i>
                </span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Jobs &amp; Careers Management</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">Manage employer postings, vacancies, company profiles, and applicant listings appearing on <code>/jobs</code>.</p>
        </div>
        <a href="{{ route('portal-admin.jobs.create') }}" class="btn-portal-primary px-4 py-2 rounded-lg text-xs font-bold flex items-center space-x-2 self-start sm:self-auto shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>Post Vacancy</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-placex-line overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 uppercase font-black text-slate-600 text-[10px] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Job Title</th>
                        <th class="px-5 py-3.5">Company</th>
                        <th class="px-5 py-3.5">Type / Level</th>
                        <th class="px-5 py-3.5">Salary Range</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($listings as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('portal-admin.listings.edit', $item) }}" class="font-bold text-slate-900 hover:text-orange block truncate">
                                    {{ $item->title }}
                                </a>
                                <span class="text-[10px] text-slate-400">{{ $item->location->name ?? 'Pakistan' }} · {{ $item->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">
                                {{ $item->jobDetail->company_name ?? 'Confidential' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="capitalize px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-semibold text-[10px]">
                                    {{ $item->jobDetail->job_type ?? 'Full Time' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                @if($item->jobDetail && $item->jobDetail->salary_min)
                                    PKR {{ number_format($item->jobDetail->salary_min) }} - {{ number_format($item->jobDetail->salary_max) }}
                                @else
                                    PKR {{ number_format($item->price) }}
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->listing_status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($item->listing_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1">
                                <a href="{{ route('portal-admin.listings.edit', $item) }}" class="p-1.5 text-slate-400 hover:text-orange rounded inline-block" title="Edit Job">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">No job listings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($listings->hasPages())
            <div class="px-5 py-4 border-t border-placex-line">
                {{ $listings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
