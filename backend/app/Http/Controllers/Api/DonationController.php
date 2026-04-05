<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    /**
     * Get all donations
     */
    public function index(Request $request)
    {
        $query = Donation::with('user')->completed();

        // Filters
        if ($request->has('campaign_name')) {
            $query->byCampaign($request->campaign_name);
        }

        // Only show non-anonymous donations or user's own donations
        if (!$request->user() || !$request->user()->isAdmin()) {
            $query->where(function($q) use ($request) {
                $q->where('is_anonymous', false)
                  ->orWhere('user_id', $request->user()?->id);
            });
        }

        $perPage = $request->get('per_page', 15);
        $donations = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $donations
        ]);
    }

    /**
     * Create new donation
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'campaign_name' => 'nullable|string',
            'payment_method' => 'required|in:stripe,paypal,bank_transfer',
            'is_anonymous' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // In a real application, you would integrate with Stripe/PayPal here
        $transactionId = 'TXN-' . strtoupper(Str::random(16));

        $donation = Donation::create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'campaign_name' => $request->campaign_name,
            'purpose' => $request->purpose,
            'message' => $request->message,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'payment_method' => $request->payment_method,
            'transaction_id' => $transactionId,
            'payment_status' => 'completed', // Would be 'pending' in real implementation
        ]);

        // Determine recognition level based on amount
        if ($donation->amount >= 10000) {
            $donation->recognition_level = 'platinum';
        } elseif ($donation->amount >= 5000) {
            $donation->recognition_level = 'gold';
        } elseif ($donation->amount >= 1000) {
            $donation->recognition_level = 'silver';
        } else {
            $donation->recognition_level = 'bronze';
        }
        $donation->save();

        return response()->json([
            'success' => true,
            'message' => 'Donation processed successfully',
            'data' => $donation
        ], 201);
    }

    /**
     * Get donation statistics
     */
    public function statistics()
    {
        $stats = [
            'total_raised' => Donation::completed()->sum('amount'),
            'total_donors' => Donation::completed()->distinct('user_id')->count(),
            'by_campaign' => Donation::completed()
                ->selectRaw('campaign_name, SUM(amount) as total, COUNT(*) as count')
                ->groupBy('campaign_name')
                ->get(),
            'recent_donors' => Donation::with('user')
                ->completed()
                ->where('show_in_donors_wall', true)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get user's donation history
     */
    public function myDonations(Request $request)
    {
        $donations = Donation::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $donations
        ]);
    }
}
