@extends('layouts.organization')

@section('title', 'Edit Event')

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
    .btn-danger-outline {
        background: transparent;
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #f87171;
        padding: 12px 24px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .btn-danger-outline:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
        color: #fca5a5;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Event</h1>
        <p class="page-subtitle">Update event details</p>
    </div>
    <a href="{{ route('organization.events') }}" class="btn btn-outline">
        ← Back to Events
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('organization.events.update', $event->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- Event Details -->
                <div class="col-12">
                    <h5 class="section-title">Event Details</h5>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Event Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $event->title) }}" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Event Type *</label>
                    <select name="event_type" class="form-select @error('event_type') is-invalid @enderror" required>
                        <option value="workshop" {{ old('event_type', $event->event_type) == 'workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="seminar" {{ old('event_type', $event->event_type) == 'seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="reunion" {{ old('event_type', $event->event_type) == 'reunion' ? 'selected' : '' }}>Reunion</option>
                        <option value="networking" {{ old('event_type', $event->event_type) == 'networking' ? 'selected' : '' }}>Networking</option>
                        <option value="webinar" {{ old('event_type', $event->event_type) == 'webinar' ? 'selected' : '' }}>Webinar</option>
                        <option value="other" {{ old('event_type', $event->event_type) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('event_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $event->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date & Time -->
                <div class="col-12 mt-4">
                    <h5 class="section-title">Date & Time</h5>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Start Date & Time *</label>
                    <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required>
                    @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">End Date & Time *</label>
                    <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" required>
                    @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Location -->
                <div class="col-12 mt-4">
                    <h5 class="section-title">Location</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Location Type *</label>
                    <select name="location_type" id="location_type" class="form-select @error('location_type') is-invalid @enderror" required onchange="toggleLocationFields()">
                        <option value="online" {{ old('location_type', $event->location_type) == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('location_type', $event->location_type) == 'offline' ? 'selected' : '' }}>Offline (In-Person)</option>
                        <option value="hybrid" {{ old('location_type', $event->location_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('location_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8" id="meeting_link_field">
                    <label class="form-label">Meeting Link</label>
                    <input type="url" name="meeting_link" class="form-control" value="{{ old('meeting_link', $event->meeting_link) }}" placeholder="https://zoom.us/j/...">
                </div>

                <div class="col-md-6" id="venue_name_field">
                    <label class="form-label">Venue Name</label>
                    <input type="text" name="venue_name" class="form-control" value="{{ old('venue_name', $event->venue_name) }}">
                </div>

                <div class="col-md-6" id="venue_address_field">
                    <label class="form-label">Venue Address</label>
                    <input type="text" name="venue_address" class="form-control" value="{{ old('venue_address', $event->venue_address) }}">
                </div>

                <!-- Registration -->
                <div class="col-12 mt-4">
                    <h5 class="section-title">Registration Settings</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Max Attendees</label>
                    <input type="number" name="max_attendees" class="form-control" value="{{ old('max_attendees', $event->max_attendees) }}" min="1" placeholder="Leave empty for unlimited">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Registration Fee</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="registration_fee" class="form-control" value="{{ old('registration_fee', $event->registration_fee) }}" min="0" step="0.01">
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <hr style="border-color: rgba(79,70,229,0.2);">
                    <div class="d-flex justify-content-between mt-4">
                        <form action="{{ route('organization.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-outline">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Event
                            </button>
                        </form>
                        <div class="d-flex gap-3">
                            <a href="{{ route('organization.events') }}" class="btn btn-outline">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Event</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleLocationFields() {
    const locationType = document.getElementById('location_type').value;
    const meetingLink = document.getElementById('meeting_link_field');
    const venueName = document.getElementById('venue_name_field');
    const venueAddress = document.getElementById('venue_address_field');

    if (locationType === 'online') {
        meetingLink.style.display = 'block';
        venueName.style.display = 'none';
        venueAddress.style.display = 'none';
    } else if (locationType === 'offline') {
        meetingLink.style.display = 'none';
        venueName.style.display = 'block';
        venueAddress.style.display = 'block';
    } else {
        meetingLink.style.display = 'block';
        venueName.style.display = 'block';
        venueAddress.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', toggleLocationFields);
</script>
@endsection
