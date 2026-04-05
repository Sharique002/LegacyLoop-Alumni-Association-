<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Event;
use App\Models\SuccessStory;
use App\Models\Donation;
use App\Models\Organization;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function dashboard()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::where('is_active', true)->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
            ],
            'organizations' => [
                'total' => Organization::count(),
                'verified' => Organization::where('is_verified', true)->count(),
                'pending_verification' => Organization::where('is_verified', false)->count(),
            ],
            'jobs' => [
                'total' => Job::count(),
                'active' => Job::active()->count(),
                'applications' => \App\Models\JobApplication::count(),
            ],
            'events' => [
                'total' => Event::count(),
                'upcoming' => Event::upcoming()->count(),
                'total_attendees' => \App\Models\EventAttendee::count(),
            ],
            'stories' => [
                'total' => SuccessStory::count(),
                'published' => SuccessStory::published()->count(),
                'pending' => SuccessStory::where('status', 'pending_review')->count(),
            ],
            'donations' => [
                'total_amount' => Donation::completed()->sum('amount'),
                'total_donors' => Donation::completed()->distinct('user_id')->count(),
                'this_month' => Donation::completed()
                    ->whereMonth('created_at', now()->month)
                    ->sum('amount'),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get all users with filters
     */
    public function users(Request $request)
    {
        $query = User::with('roles');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated',
            'data' => $user
        ]);
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles([$request->role]);

        return response()->json([
            'success' => true,
            'message' => 'User role updated',
            'data' => $user->load('roles')
        ]);
    }

    /**
     * Get pending success stories for review
     */
    public function pendingStories()
    {
        $stories = SuccessStory::with('user')
            ->where('status', 'pending_review')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $stories
        ]);
    }

    /**
     * Approve success story
     */
    public function approveStory($id)
    {
        $story = SuccessStory::findOrFail($id);
        $story->publish();

        return response()->json([
            'success' => true,
            'message' => 'Success story published',
            'data' => $story
        ]);
    }

    /**
     * Reject success story
     */
    public function rejectStory(Request $request, $id)
    {
        $story = SuccessStory::findOrFail($id);
        $story->update([
            'status' => 'rejected',
            'admin_feedback' => $request->feedback
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Success story rejected',
            'data' => $story
        ]);
    }

    /**
     * Get recent activities
     */
    public function activities()
    {
        $activities = [
            'recent_users' => User::orderBy('created_at', 'desc')->limit(5)->get(),
            'recent_jobs' => Job::with('postedBy')->orderBy('created_at', 'desc')->limit(5)->get(),
            'recent_events' => Event::with('creator')->orderBy('created_at', 'desc')->limit(5)->get(),
            'recent_donations' => Donation::with('user')
                ->where('is_anonymous', false)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    /**
     * Get analytics data
     */
    public function analytics(Request $request)
    {
        $period = $request->get('period', '30'); // days

        $analytics = [
            'user_registrations' => User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays($period))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'job_postings' => Job::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays($period))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'event_registrations' => \App\Models\EventAttendee::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays($period))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'donation_trends' => Donation::selectRaw('DATE(created_at) as date, SUM(amount) as total')
                ->where('created_at', '>=', now()->subDays($period))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Get all organizations
     */
    public function organizations(Request $request)
    {
        $query = Organization::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_verified')) {
            $query->where('is_verified', $request->boolean('is_verified'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $organizations = $query->withCount('users')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $organizations
        ]);
    }

    /**
     * Verify an organization
     */
    public function verifyOrganization($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->is_verified = true;
        $organization->save();

        return response()->json([
            'success' => true,
            'message' => 'Organization verified successfully',
            'data' => $organization
        ]);
    }

    /**
     * Toggle organization active status
     */
    public function toggleOrganizationStatus($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->is_active = !$organization->is_active;
        $organization->save();

        return response()->json([
            'success' => true,
            'message' => 'Organization status updated',
            'data' => $organization
        ]);
    }
}
