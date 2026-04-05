<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display alumni directory
     */
    public function index(Request $request): View
    {
        $query = User::where('is_admin', false);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('current_company', 'like', "%$search%");
            });
        }

        // Branch filter
        if ($request->filled('branch')) {
            $query->where('branch', $request->input('branch'));
        }

        // Graduation year filter
        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->input('graduation_year'));
        }

        $alumni = $query->paginate(20);
        $branches = User::distinct('branch')->pluck('branch');
        $years = User::distinct('graduation_year')->pluck('graduation_year');

        return view('alumni.index', compact('alumni', 'branches', 'years'));
    }

    /**
     * Show alumni profile
     */
    public function show(User $alumni): View
    {
        if ($alumni->is_admin) {
            abort(404);
        }

        /** @var User|null $currentUser */
        $currentUser = auth()->user();
        if (!$currentUser) {
            abort(403);
        }

        $is_connected = $currentUser->connections()->where('receiver_id', $alumni->id)->exists();
        $connection_request_sent = $currentUser->sentConnections()
            ->where('receiver_id', $alumni->id)
            ->where('status', 'pending')
            ->exists();

        return view('alumni.show', compact('alumni', 'is_connected', 'connection_request_sent'));
    }
}
