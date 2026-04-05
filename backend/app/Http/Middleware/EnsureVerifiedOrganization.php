<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Organization;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerifiedOrganization
{
    /**
     * Handle an incoming request.
     * Ensures the organization is verified.
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

        if (!$user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Your organization must be verified to perform this action.'
            ], 403);
        }

        return $next($request);
    }
}
