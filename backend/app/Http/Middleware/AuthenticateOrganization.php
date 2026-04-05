<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateOrganization
{
    /**
     * Handle an incoming request.
     * Ensures the user is authenticated as an Organization via the web guard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('organization')->check()) {
            return redirect()->route('organization.login')
                ->with('warning', 'Please login to access this page.');
        }

        $organization = Auth::guard('organization')->user();

        if (!$organization->is_active) {
            Auth::guard('organization')->logout();
            return redirect()->route('organization.login')
                ->with('warning', 'Your organization account is inactive.');
        }

        return $next($request);
    }
}
