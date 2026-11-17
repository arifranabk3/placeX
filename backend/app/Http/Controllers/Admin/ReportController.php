<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ListingReport;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = ListingReport::with(['listing', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $reports = $query->latest()->paginate(15)->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function show(ListingReport $report): View
    {
        $report->load(['listing', 'listing.user', 'user']);
        $moderators = User::whereHas('roles', fn ($q) => $q->whereIn('slug', ['super-admin', 'admin', 'moderator']))->get();

        return view('admin.reports.show', compact('report', 'moderators'));
    }

    public function update(Request $request, ListingReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,investigating,resolved,dismissed',
            'action_taken' => 'nullable|string|max:500',
        ]);

        $report->update([
            'status' => $validated['status'],
            'action_taken' => $validated['action_taken'],
            'resolved_at' => in_array($validated['status'], ['resolved', 'dismissed']) ? now() : null,
        ]);

        AuditLog::record(
            'report.updated',
            ListingReport::class,
            $report->id,
            ['status' => $report->status, 'action_taken' => $report->action_taken]
        );

        return back()->with('success', "Report status updated to {$report->status}.");
    }
}
