@extends('layouts.app')

@section('title', 'Edit Profile - LegacyLoop')

@section('content')
<div style="max-width:760px;">
    <h2 class="serif" style="color:var(--cream);margin:0 0 24px;">My Profile</h2>

    {{-- Profile Image Section --}}
    <div class="card" style="margin-bottom:24px;">
        <div class="card-body" style="padding:32px;">
            <h5 style="color:var(--cream);margin:0 0 20px;font-weight:600;">Profile Photo</h5>
            <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
                {{-- Current Avatar --}}
                <div style="position:relative;">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Photo" 
                             style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid var(--gold);"
                             id="avatar-preview">
                    @else
                        <div style="width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,var(--gold),#c9a027);display:flex;align-items:center;justify-content:center;font-size:48px;font-weight:bold;color:var(--dark);border:4px solid var(--gold);" id="avatar-initials">
                            {{ strtoupper(substr($user->first_name ?? 'A', 0, 1) . substr($user->last_name ?? 'L', 0, 1)) }}
                        </div>
                        <img src="" alt="Profile Photo" 
                             style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid var(--gold);display:none;"
                             id="avatar-preview">
                    @endif
                </div>

                {{-- Upload Form --}}
                <div style="flex:1;min-width:200px;">
                    <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" id="avatar-form">
                        @csrf
                        <input type="file" name="avatar" id="avatar-input" accept="image/jpeg,image/png,image/gif,image/webp" style="display:none;">
                        
                        <div style="display:flex;gap:12px;flex-wrap:wrap;">
                            <button type="button" onclick="document.getElementById('avatar-input').click()" 
                                    class="btn" style="background:rgba(255,255,255,0.1);border:1px solid var(--gray);color:var(--cream);padding:10px 20px;border-radius:8px;cursor:pointer;transition:all 0.2s;">
                                <i class="fas fa-camera" style="margin-right:8px;"></i> Upload Photo
                            </button>
                            @if($user->avatar)
                            <button type="button" onclick="removeAvatar()" 
                                    class="btn" style="background:rgba(220,53,69,0.2);border:1px solid #dc3545;color:#dc3545;padding:10px 20px;border-radius:8px;cursor:pointer;transition:all 0.2s;">
                                <i class="fas fa-trash" style="margin-right:8px;"></i> Remove
                            </button>
                            @endif
                        </div>
                        
                        <p style="color:var(--gray);font-size:12px;margin-top:12px;margin-bottom:0;">
                            Supported formats: JPG, PNG, GIF, WebP. Max size: 2MB
                        </p>
                        @error('avatar')
                            <p style="color:#dc3545;font-size:13px;margin-top:8px;margin-bottom:0;">{{ $message }}</p>
                        @enderror
                    </form>

                    {{-- Remove Avatar Form (hidden) --}}
                    <form method="POST" action="{{ route('profile.avatar.remove') }}" id="remove-avatar-form" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Details Section --}}
    <div class="card">
        <div class="card-body" style="padding:32px;">
            <h5 style="color:var(--cream);margin:0 0 20px;font-weight:600;">Profile Details</h5>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name *</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" required>
                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" required>
                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled style="opacity:0.6;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+91 98765 43210">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Graduation Year</label>
                        <input type="number" name="graduation_year" class="form-control" value="{{ old('graduation_year', $user->graduation_year) }}" min="1960" max="{{ date('Y') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Degree</label>
                        <input type="text" name="degree" class="form-control" value="{{ old('degree', $user->degree) }}" placeholder="B.Tech">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Branch</label>
                        <input type="text" name="branch" class="form-control" value="{{ old('branch', $user->branch) }}" placeholder="CSE">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $user->job_title) }}" placeholder="Senior Engineer">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <input type="text" name="current_company" class="form-control" value="{{ old('current_company', $user->current_company) }}" placeholder="Google">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}" placeholder="Bangalore">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $user->state) }}" placeholder="Karnataka">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $user->country) }}" placeholder="India">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" rows="4" placeholder="Tell your story...">{{ old('bio', $user->bio) }}</textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $user->linkedin_url) }}" placeholder="https://linkedin.com/in/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">GitHub URL</label>
                        <input type="url" name="github_url" class="form-control" value="{{ old('github_url', $user->github_url) }}" placeholder="https://github.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" name="twitter_url" class="form-control" value="{{ old('twitter_url', $user->twitter_url) }}" placeholder="https://twitter.com/...">
                    </div>
                </div>
                <div style="display:flex;gap:16px;align-items:center;margin-bottom:24px;flex-wrap:wrap;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;color:var(--gray);font-size:14px;">
                        <input type="checkbox" name="is_open_to_mentor" value="1" {{ $user->is_open_to_mentor ? 'checked' : '' }}> Open to mentor
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;color:var(--gray);font-size:14px;">
                        <input type="checkbox" name="is_seeking_opportunities" value="1" {{ $user->is_seeking_opportunities ? 'checked' : '' }}> Seeking opportunities
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:12px 32px;border-radius:8px;">
                    <i class="fas fa-save" style="margin-right:8px;"></i> Save Changes
                </button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            return;
        }
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            const initials = document.getElementById('avatar-initials');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initials) initials.style.display = 'none';
        };
        reader.readAsDataURL(file);
        
        // Auto-submit form
        document.getElementById('avatar-form').submit();
    }
});

function removeAvatar() {
    if (confirm('Are you sure you want to remove your profile photo?')) {
        document.getElementById('remove-avatar-form').submit();
    }
}
</script>
@endsection
@endsection
