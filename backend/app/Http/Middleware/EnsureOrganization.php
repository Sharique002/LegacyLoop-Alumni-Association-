<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Organization;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganization
{
    /**
     * Handle an incoming request.
     * Ensures the authenticated user is an Organization (not a User).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !($user instanceof Organization)) {
            return response()->json([
                'success' => false,
                'message' => 'This action requires organization authentication.'
            ], 403);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your organization account is inactive.'
            ], 403);
        }

        return $next($request);
    }
}
