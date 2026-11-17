<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::with(['user', 'listing']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingCount = Payment::where('status', 'pending')->count();

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'pendingCount'));
    }

    public function updateStatus(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->update($validated);

        AuditLog::record(
            "payment.status_{$validated['status']}",
            Payment::class,
            $payment->id,
            ['status' => $validated['status'], 'notes' => $validated['notes'] ?? null]
        );

        return back()->with('success', "Payment status marked as {$validated['status']}.");
    }
}
