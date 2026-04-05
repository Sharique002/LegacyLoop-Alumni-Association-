@extends('layouts.organization')

@section('title', 'Create Event')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Event</h1>
        <p class="page-subtitle">Create a new event for your alumni community</p>
    </div>
    <a href="{{ route('organization.events') }}" class="btn btn-outline">
        ← Back to Events
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('organization.events.store') }}">
            @csrf

            <div class="row g-4">
                <!-- Event Details -->
                <div class="col-12">
                    <h5 class="section-title">Event Details</h5>
                </div>

                <div class="col-md-8">
                    <label class="form-label">Event Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g., Annual Alumni Meetup 2026" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Event Type *</label>
                    <select name="event_type" class="form-select @error('event_type') is-invalid @enderror" required>
                        <option value="">Select type</option>
                        <option value="workshop" {{ old('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="seminar" {{ old('event_type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="reunion" {{ old('event_type') == 'reunion' ? 'selected' : '' }}>Reunion</option>
                        <option value="networking" {{ old('event_type') == 'networking' ? 'selected' : '' }}>Networking</option>
                        <option value="webinar" {{ old('event_type') == 'webinar' ? 'selected' : '' }}>Webinar</option>
                        <option value="other" {{ old('event_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('event_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Describe your event..." required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date & Time -->
                <div class="col-12 mt-4">
                    <h5 class="section-title">Date & Time</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Start Date & Time *</label>
                    <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                    @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">End Date & Time *</label>
                    <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                    @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Timezone</label>
                    <select name="timezone" class="form-select">
                        <option value="UTC">UTC</option>
                        <option value="Asia/Kolkata" selected>Asia/Kolkata (IST)</option>
                        <option value="America/New_York">America/New_York (EST)</option>
                        <option value="America/Los_Angeles">America/Los_Angeles (PST)</option>
                        <option value="Europe/London">Europe/London (GMT)</option>
                    </select>
                </div>

                <!-- Location -->
                <div class="col-12 mt-4">
                    <h5 class="section-title">Location</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Location Type *</label>
                    <select name="location_type" id="location_type" class="form-select @error('location_type') is-invalid @enderror" required onchange="toggleLocationFields()">
                        <option value="online" {{ old('location_type') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('location_type') == 'offline' ? 'selected' : '' }}>Offline (In-Person)</option>
                        <option value="hybrid" {{ old('location_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('location_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8" id="meeting_link_field">
                    <label class="form-label">Meeting Link</label>
                    <input type="url" name="meeting_link" class="form-control @error('meeting_link') is-invalid @enderror" value="{{ old('meeting_link') }}" placeholder="https://zoom.us/j/...">
                    @error('meeting_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6" id="venue_name_field" style="display: none;">
                    <label class="form-label">Venue Name</label>
                    <input type="text" name="venue_name" class="form-control" value="{{ old('venue_name') }}" placeholder="e.g., University Auditorium">
                </div>

                <div class="col-md-6" id="venue_address_field" style="display: none;">
                    <label class="form-label">Venue Address</label>
                    <input type="text" name="venue_address" class="form-control" value="{{ old('venue_address') }}" placeholder="Full address">
                </div>

                <div class="col-md-6" id="city_field" style="display: none;">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="City">
                </div>

                <div class="col-md-6" id="country_field" style="display: none;">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country') }}" placeholder="Country">
                </div>

                <!-- Registration -->
                <div class="col-12 mt-4">
                    <h5 class="section-title">Registration Settings</h5>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="requires_registration" value="1" class="form-check-input" id="requires_registration" {{ old('requires_registration', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="requires_registration">Require Registration</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Max Attendees</label>
                    <input type="number" name="max_attendees" class="form-control" value="{{ old('max_attendees') }}" placeholder="Leave empty for unlimited" min="1">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Registration Fee</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="registration_fee" class="form-control" value="{{ old('registration_fee', 0) }}" min="0" step="0.01">
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <hr style="border-color: rgba(79,70,229,0.2);">
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="{{ route('organization.events') }}" class="btn btn-outline">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Event</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .section-title {
        color: var(--university-accent);
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
        padding: 8px 12px;
        background: rgba(79, 70, 229, 0.1);
        border-left: 3px solid var(--university-accent);
        border-radius: 4px;
        display: inline-block;
    }
    .form-label {
        color: var(--cream);
        font-weight: 500;
        margin-bottom: 8px;
        font-size: 13px;
        display: block;
    }
    .form-control, .form-select {
        background: rgba(26, 31, 58, 0.8);
        border: 1px solid rgba(79,70,229,0.3);
        color: var(--cream);
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(26, 31, 58, 0.95);
        border-color: var(--university-accent);
        color: var(--cream);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2), 0 5px 20px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    .form-control::placeholder {
        color: var(--gray);
    }
    .form-select option {
        background: var(--primary);
        color: var(--cream);
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: rgba(79, 70, 229, 0.1);
        border: 1px solid rgba(79, 70, 229, 0.2);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .form-check:hover {
        background: rgba(79, 70, 229, 0.15);
        border-color: rgba(79, 70, 229, 0.3);
    }
    .form-check-input {
        width: 20px;
        height: 20px;
        background-color: rgba(255,255,255,0.1);
        border: 2px solid rgba(79,70,229,0.4);
        border-radius: 4px;
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
    }
    .form-check-input:checked {
        background-color: var(--university-accent);
        border-color: var(--university-accent);
    }
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
    }
    .form-check-label {
        color: var(--cream);
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        margin: 0;
    }
    .invalid-feedback {
        color: #fca5a5;
        font-size: 12px;
        margin-top: 6px;
    }
    .is-invalid {
        border-color: #ef4444 !important;
    }
    .input-group-text {
        background: rgba(79, 70, 229, 0.2);
        border: 1px solid rgba(79, 70, 229, 0.3);
        color: var(--cream);
        font-weight: 600;
        border-radius: 10px 0 0 10px;
    }
    .input-group .form-control {
        border-radius: 0 10px 10px 0;
    }
</style>
@endsection

@section('scripts')
<script>
function toggleLocationFields() {
    const locationType = document.getElementById('location_type').value;
    const meetingLink = document.getElementById('meeting_link_field');
    const venueName = document.getElementById('venue_name_field');
    const venueAddress = document.getElementById('venue_address_field');
    const city = document.getElementById('city_field');
    const country = document.getElementById('country_field');

    if (locationType === 'online') {
        meetingLink.style.display = 'block';
        venueName.style.display = 'none';
        venueAddress.style.display = 'none';
        city.style.display = 'none';
        country.style.display = 'none';
    } else if (locationType === 'offline') {
        meetingLink.style.display = 'none';
        venueName.style.display = 'block';
        venueAddress.style.display = 'block';
        city.style.display = 'block';
        country.style.display = 'block';
    } else { // hybrid
        meetingLink.style.display = 'block';
        venueName.style.display = 'block';
        venueAddress.style.display = 'block';
        city.style.display = 'block';
        country.style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', toggleLocationFields);
</script>
@endsection
