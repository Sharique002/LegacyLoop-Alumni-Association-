@extends('layouts.app')

@section('title', 'Settings - LegacyLoop')

@section('content')
<div style="max-width:640px;">
    <h2 class="serif" style="color:var(--cream);margin:0 0 24px;">Account Settings</h2>

    {{-- Change Password --}}
    <div class="card">
        <div class="card-header"><div style="padding:14px 20px;"><h5 style="color:var(--cream);margin:0;"><i class="fas fa-lock" style="color:var(--gold);margin-right:8px;"></i>Change Password</h5></div></div>
        <div class="card-body" style="padding:24px;">
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 28px;border-radius:8px;">
                    Update Password
                </button>
            </form>
        </div>
    </div>

    {{-- Danger Zone --}}
    <div class="card" style="border-color:rgba(239,68,68,0.3);">
        <div class="card-header" style="background:rgba(239,68,68,0.05);"><div style="padding:14px 20px;"><h5 style="color:#ef4444;margin:0;"><i class="fas fa-exclamation-triangle" style="margin-right:8px;"></i>Danger Zone</h5></div></div>
        <div class="card-body" style="padding:24px;">
            <p style="color:var(--gray);font-size:14px;margin-bottom:16px;">To sign out of your account on this device:</p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline" style="border-color:#ef4444;color:#ef4444;padding:10px 24px;border-radius:8px;">
                    <i class="fas fa-sign-out-alt" style="margin-right:8px;"></i> Sign Out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
