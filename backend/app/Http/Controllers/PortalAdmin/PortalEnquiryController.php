<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ListingReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalEnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $query = ListingReport::with(['listing', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $enquiries = $query->latest()->paginate(15)->withQueryString();

        return view('portal-admin.enquiries.index', compact('enquiries'));
    }

    public function show(ListingReport $enquiry): View
    {
        $enquiry->load(['listing', 'listing.user', 'user']);

        return view('portal-admin.enquiries.show', compact('enquiry'));
    }

    public function update(Request $request, ListingReport $enquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,investigating,resolved,dismissed',
            'action_taken' => 'nullable|string|max:500',
        ]);

        $enquiry->update([
            'status' => $validated['status'],
            'action_taken' => $validated['action_taken'],
            'resolved_at' => in_array($validated['status'], ['resolved', 'dismissed']) ? now() : null,
        ]);

        AuditLog::record('portal.enquiry_resolved', ListingReport::class, $enquiry->id, $validated);

        return back()->with('success', "Enquiry/Report status updated to {$enquiry->status}.");
    }
}
