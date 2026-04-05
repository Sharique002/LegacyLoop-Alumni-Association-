<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SuccessStory;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => \App\Models\Job::count(),
            'total_events' => \App\Models\Event::count(),
            'pending_stories' => SuccessStory::where('status', 'pending')->count(),
            'total_donations' => \App\Models\Donation::where('status', 'completed')->sum('amount'),
        ];

        $recent_users = User::latest()->limit(10)->get();
        $pending_stories = SuccessStory::where('status', 'pending')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'pending_stories'));
    }

    public function users(Request $request): View
    {
        $query = User::where('is_admin', false);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->input('search')}%")
                  ->orWhere('last_name', 'like', "%{$request->input('search')}%")
                  ->orWhere('email', 'like', "%{$request->input('search')}%");
            });
        }

        $users = $query->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function toggleUserStatus(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            abort(403);
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'enabled' : 'disabled';
        return back()->with('success', "User status $status!");
    }

    public function approveStory(SuccessStory $story): RedirectResponse
    {
        $story->update(['status' => 'approved']);
        return back()->with('success', 'Story approved!');
    }

    public function rejectStory(SuccessStory $story): RedirectResponse
    {
        $story->update(['status' => 'rejected']);
        return back()->with('success', 'Story rejected!');
    }

    public function analytics(): View
    {
        return view('admin.analytics');
    }
}
