<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Listing;
use App\Models\ModerationCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ModerationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'pending');

        $query = Listing::with(['user', 'category', 'location', 'images'])
            ->where('moderation_status', $status);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $pendingCount = Listing::where('moderation_status', 'pending')->count();
        $approvedCount = Listing::where('moderation_status', 'approved')->count();
        $rejectedCount = Listing::where('moderation_status', 'rejected')->count();

        $listings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.moderation.index', compact(
            'listings',
            'status',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function process(Request $request, Listing $listing): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:500',
        ]);

        $action = $request->input('action');
        $status = $action === 'approve' ? 'approved' : 'rejected';
        $notes = $request->input('notes') ?? "Moderated by " . Auth::user()->name;

        DB::transaction(function () use ($listing, $status, $action, $notes) {
            $listing->update([
                'moderation_status' => $status,
                'listing_status' => $status === 'approved' ? 'active' : 'inactive',
                'published_at' => $status === 'approved' ? ($listing->published_at ?? now()) : null,
            ]);

            ModerationCase::create([
                'listing_id' => $listing->id,
                'moderator_id' => Auth::id(),
                'action' => $status,
                'notes' => $notes,
            ]);

            AuditLog::record(
                "moderation.{$action}",
                Listing::class,
                $listing->id,
                ['status' => $status, 'notes' => $notes]
            );
        });

        return back()->with('success', "Listing '{$listing->title}' has been {$status}.");
    }
}
