<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrganizationAuthController extends Controller
{
    /**
     * List verified universities for alumni registration dropdown
     */
    public function listUniversities(Request $request)
    {
        $query = Organization::verified()
            ->active()
            ->universities()
            ->select('id', 'name', 'city', 'country', 'logo');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $universities = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $universities
        ]);
    }

    /**
     * Register a new organization
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:organizations',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'sometimes|string|in:university,company,ngo,other',
            'description' => 'sometimes|nullable|string',
            'website' => 'sometimes|nullable|url',
            'city' => 'sometimes|nullable|string',
            'country' => 'sometimes|nullable|string',
            'contact_phone' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $organization = Organization::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => $request->type ?? 'university',
            'description' => $request->description,
            'website' => $request->website,
            'city' => $request->city,
            'country' => $request->country,
            'contact_phone' => $request->contact_phone,
            'is_verified' => false, // Requires admin verification
        ]);

        $token = $organization->createToken('org_auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Organization registered successfully. Awaiting verification.',
            'data' => [
                'organization' => $organization,
                'token' => $token,
            ]
        ], 201);
    }

    /**
     * Login organization
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $organization = Organization::where('email', $request->email)->first();

        if (!$organization || !Hash::check($request->password, $organization->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
                'errors' => ['email' => ['The provided credentials are incorrect.']]
            ], 401);
        }

        if (!$organization->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your organization account is inactive. Please contact admin.'
            ], 403);
        }

        $token = $organization->createToken('org_auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'organization' => $organization,
                'token' => $token,
                'is_verified' => $organization->is_verified,
            ]
        ]);
    }

    /**
     * Logout organization
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get authenticated organization
     */
    public function me(Request $request)
    {
        $organization = $request->user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'organization' => $organization,
                'statistics' => [
                    'total_alumni' => $organization->getAlumniCount(),
                    'total_events' => $organization->getEventsCount(),
                ]
            ]
        ]);
    }

    /**
     * Update organization profile
     */
    public function updateProfile(Request $request)
    {
        $organization = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'website' => 'sometimes|nullable|url',
            'logo' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string',
            'state' => 'sometimes|nullable|string',
            'country' => 'sometimes|nullable|string',
            'contact_phone' => 'sometimes|nullable|string',
            'contact_email' => 'sometimes|nullable|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $organization->update($request->only([
            'name', 'description', 'website', 'logo', 'address',
            'city', 'state', 'country', 'contact_phone', 'contact_email'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $organization
        ]);
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $organization = $request->user();

        if (!Hash::check($request->current_password, $organization->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $organization->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
