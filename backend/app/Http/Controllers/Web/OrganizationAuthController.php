<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrganizationAuthController extends Controller
{
    /**
     * Show organization login form
     */
    public function showLoginForm()
    {
        return view('auth.organization-login');
    }

    /**
     * Handle organization login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $organization = Organization::where('email', $request->email)->first();

        if (!$organization || !Hash::check($request->password, $organization->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ])->withInput();
        }

        if (!$organization->is_active) {
            return back()->withErrors([
                'email' => 'Your organization account is inactive. Please contact admin.',
            ])->withInput();
        }

        // Login the organization using the 'organization' guard
        Auth::guard('organization')->login($organization, $request->filled('remember'));

        $request->session()->regenerate();

        // Check if organization is verified
        if (!$organization->is_verified) {
            return redirect()->route('organization.dashboard')
                ->with('warning', 'Your organization is pending verification. Some features may be limited.');
        }

        return redirect()->intended(route('organization.dashboard'));
    }

    /**
     * Show organization registration form
     */
    public function showRegisterForm()
    {
        return view('auth.organization-register');
    }

    /**
     * Handle organization registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:organizations',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|string|in:university,college,institute,other',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $organization = Organization::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => $request->type,
            'description' => $request->description,
            'website' => $request->website,
            'city' => $request->city,
            'country' => $request->country,
            'contact_phone' => $request->contact_phone,
            'is_verified' => false,
            'is_active' => true,
        ]);

        // Login the organization
        Auth::guard('organization')->login($organization);

        return redirect()->route('organization.dashboard')
            ->with('success', 'Registration successful! Your account is pending verification.');
    }

    /**
     * Logout organization
     */
    public function logout(Request $request)
    {
        Auth::guard('organization')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('organization.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
