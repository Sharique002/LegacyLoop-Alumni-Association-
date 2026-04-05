<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email'    => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with(strtolower($value), '@legacyloop.in')) {
                        $fail('Only @legacyloop.in email addresses are allowed.');
                    }
                },
            ],
            'password' => 'required|string',
        ]);

        if (auth()->attempt($validated, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => [
                'required',
                'email',
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with(strtolower($value), '@legacyloop.in')) {
                        $fail('Only institutional emails ending with @legacyloop.in are allowed to register.');
                    }
                },
            ],
            'password'        => 'required|string|min:8|confirmed',
            'branch'          => 'required|string',
            'graduation_year' => 'required|integer|min:1900|max:' . date('Y') + 5,
        ]);

        $validated['password']  = Hash::make($validated['password']);
        $validated['is_active'] = true;

        $user = User::create($validated);

        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Welcome to LegacyLoop!');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have logged out successfully.');
    }
}
