@extends('layouts.organization')

@section('title', 'Profile Settings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Profile Settings</h1>
        <p class="page-subtitle">Manage your organization's profile and settings</p>
    </div>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="org-avatar-large mx-auto mb-4" style="width: 100px; height: 100px; background: var(--university-accent); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 700;">
                    {{ strtoupper(substr($organization->name, 0, 2)) }}
                </div>
                <h4 style="color: var(--cream); margin-bottom: 4px;">{{ $organization->name }}</h4>
                <p style="color: var(--gray); font-size: 14px;">{{ ucfirst($organization->type) }}</p>
                
                <div class="d-flex justify-content-center gap-2 mt-3">
                    @if($organization->is_verified)
                    <span class="badge badge-success">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Verified
                    </span>
                    @else
                    <span class="badge badge-warning">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pending Verification
                    </span>
                    @endif
                </div>

                <div class="mt-4 pt-4" style="border-top: 1px solid rgba(79,70,229,0.15);">
                    <div class="row text-center">
                        <div class="col-6">
                            <div style="font-size: 24px; font-weight: 700; color: var(--cream);">{{ $organization->getAlumniCount() }}</div>
                            <div style="font-size: 12px; color: var(--gray);">Alumni</div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 24px; font-weight: 700; color: var(--cream);">{{ $organization->getEventsCount() }}</div>
                            <div style="font-size: 12px; color: var(--gray);">Events</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Quick Info</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Email</div>
                    <div style="color: var(--cream);">{{ $organization->email }}</div>
                </div>
                @if($organization->website)
                <div class="mb-3">
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Website</div>
                    <a href="{{ $organization->website }}" target="_blank" style="color: var(--university-accent);">{{ $organization->website }}</a>
                </div>
                @endif
                @if($organization->city || $organization->country)
                <div class="mb-3">
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Location</div>
                    <div style="color: var(--cream);">{{ $organization->city }}{{ $organization->city && $organization->country ? ', ' : '' }}{{ $organization->country }}</div>
                </div>
                @endif
                <div>
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Member Since</div>
                    <div style="color: var(--cream);">{{ $organization->created_at->format('F d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Profile</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('organization.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Organization Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $organization->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Website</label>
                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $organization->website) }}" placeholder="https://...">
                            @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Brief description of your organization">{{ old('description', $organization->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $organization->address) }}" placeholder="Street address">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $organization->city) }}">
                            @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $organization->country) }}">
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Phone</label>
                            <input type="tel" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $organization->contact_phone) }}">
                            @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $organization->contact_email) }}">
                            @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <hr style="border-color: rgba(79,70,229,0.2);">
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-label {
        color: var(--cream);
        font-weight: 500;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(79,70,229,0.3);
        color: var(--cream);
        border-radius: 8px;
        padding: 10px 14px;
    }
    .form-control:focus {
        background: rgba(255,255,255,0.08);
        border-color: var(--university-accent);
        color: var(--cream);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }
    .form-control::placeholder {
        color: var(--gray);
    }
    .invalid-feedback {
        color: #fca5a5;
    }
    .is-invalid {
        border-color: #ef4444 !important;
    }
</style>
@endsection
