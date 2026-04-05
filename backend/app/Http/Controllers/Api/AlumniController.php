<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Get all alumni with filters
     */
    public function index(Request $request)
    {
        $query = User::where('is_active', true);

        // Filters
        if ($request->has('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        if ($request->has('branch')) {
            $query->where('branch', $request->branch);
        }

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        if ($request->has('country')) {
            $query->where('country', $request->country);
        }

        if ($request->has('company')) {
            $query->where('current_company', 'like', '%' . $request->company . '%');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('open_to_mentor')) {
            $query->where('is_open_to_mentor', true);
        }

        $perPage = $request->get('per_page', 15);
        $alumni = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $alumni
        ]);
    }

    /**
     * Get single alumni profile
     */
    public function show($id)
    {
        $alumni = User::with([
            'jobs', 
            'events', 
            'successStories' => function($q) {
                $q->published();
            }
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $alumni
        ]);
    }

    /**
     * Get alumni statistics
     */
    public function statistics()
    {
        $stats = [
            'total_alumni' => User::where('is_active', true)->count(),
            'by_graduation_year' => User::selectRaw('graduation_year, COUNT(*) as count')
                ->groupBy('graduation_year')
                ->orderBy('graduation_year', 'desc')
                ->get(),
            'by_branch' => User::selectRaw('branch, COUNT(*) as count')
                ->groupBy('branch')
                ->get(),
            'by_country' => User::selectRaw('country, COUNT(*) as count')
                ->whereNotNull('country')
                ->groupBy('country')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'mentors_available' => User::where('is_open_to_mentor', true)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
