<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'               => 'required|string|max:255',
            'last_name'                => 'required|string|max:255',
            'bio'                      => 'nullable|string|max:1000',
            'phone'                    => 'nullable|string|max:20',
            'branch'                   => 'nullable|string|max:100',
            'degree'                   => 'nullable|string|max:100',
            'graduation_year'          => 'nullable|integer|min:1900|max:' . date('Y'),
            'job_title'                => 'nullable|string|max:255',
            'current_company'          => 'nullable|string|max:255',
            'city'                     => 'nullable|string|max:100',
            'state'                    => 'nullable|string|max:100',
            'country'                  => 'nullable|string|max:100',
            'linkedin_url'             => 'nullable|url|max:255',
            'github_url'               => 'nullable|url|max:255',
            'twitter_url'              => 'nullable|url|max:255',
            'website_url'              => 'nullable|url|max:255',
            'is_open_to_mentor'        => 'boolean',
            'is_seeking_opportunities' => 'boolean',
        ]);

        // Handle unchecked checkboxes
        $validated['is_open_to_mentor']        = $request->boolean('is_open_to_mentor');
        $validated['is_seeking_opportunities'] = $request->boolean('is_seeking_opportunities');

        auth()->user()->update($validated);
        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        $user = auth()->user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Profile photo updated successfully!');
    }

    public function removeAvatar(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return back()->with('success', 'Profile photo removed successfully!');
    }

    public function settings(): View
    {
        return view('profile.settings');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'privacy' => 'in:public,private,friends_only',
        ]);

        auth()->user()->update($validated);
        return back()->with('success', 'Settings updated successfully!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}
