<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Event;
use App\Models\User;
use App\Models\SuccessStory;
use App\Models\Donation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index(): View
    {
        $user = auth()->user();

        // Get statistics
        $stats = [
            'total_alumni' => User::where('is_admin', false)->count(),
            'active_jobs' => Job::where('status', 'active')->count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'total_donations' => Donation::sum('amount'),
        ];

        // Get recent jobs
        $recent_jobs = Job::where('status', 'active')
            ->latest()
            ->limit(4)
            ->get();

        // Get upcoming events
        $upcoming_events = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        // Get suggested alumni to connect
        $suggested_alumni = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $user->connections->pluck('receiver_id'))
            ->limit(4)
            ->get();

        return view('dashboard.index', compact('user', 'stats', 'recent_jobs', 'upcoming_events', 'suggested_alumni'));
    }
}
