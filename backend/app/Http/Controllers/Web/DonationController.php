<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function index(): View
    {
        $donations = Donation::with('user')
            ->where('payment_status', 'completed')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_raised' => Donation::where('payment_status', 'completed')->sum('amount'),
            'total_donors' => Donation::where('payment_status', 'completed')->distinct('user_id')->count(),
            'latest_donations' => Donation::where('payment_status', 'completed')->latest()->limit(5)->get(),
        ];

        return view('donations.index', compact('donations', 'stats'));
    }

    public function show(Donation $donation): View
    {
        return view('donations.show', compact('donation'));
    }

    public function create(): View
    {
        return view('donations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'campaign_name' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'boolean',
        ]);

        $donation = Donation::create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'campaign_name' => $validated['campaign_name'] ?? 'general',
            'message' => $validated['message'] ?? null,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'payment_method' => 'manual',
            'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
            'payment_status' => 'completed',
            'payment_completed_at' => now(),
        ]);

        return redirect()->route('donations.index')->with('success', 'Donation submitted! Thank you for your generosity.');
    }
}
