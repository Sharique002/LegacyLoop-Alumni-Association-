@extends('layouts.app')

@section('title', 'Create Event - LegacyLoop')

@section('content')
<div style="max-width:640px;">
    <a href="{{ route('events.index') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Events
    </a>

    <div class="card">
        <div class="card-body" style="padding:32px;">
            <h2 class="serif" style="color:var(--cream);margin:0 0 24px;">Create New Event</h2>

            <form method="POST" action="{{ route('events.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Event Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Annual Alumni Reunion 2025" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Describe the event..." required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Event Type *</label>
                        <select name="event_type" class="form-control @error('event_type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="reunion" {{ old('event_type') == 'reunion' ? 'selected' : '' }}>Reunion</option>
                            <option value="networking" {{ old('event_type') == 'networking' ? 'selected' : '' }}>Networking</option>
                            <option value="webinar" {{ old('event_type') == 'webinar' ? 'selected' : '' }}>Webinar</option>
                            <option value="workshop" {{ old('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                            <option value="conference" {{ old('event_type') == 'conference' ? 'selected' : '' }}>Conference</option>
                        </select>
                        @error('event_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location Type *</label>
                        <select name="location_type" class="form-control @error('location_type') is-invalid @enderror" required>
                            <option value="">Select Location Type</option>
                            <option value="physical" {{ old('location_type') == 'physical' ? 'selected' : '' }}>Physical</option>
                            <option value="virtual" {{ old('location_type') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="hybrid" {{ old('location_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('location_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Venue Name</label>
                        <input type="text" name="venue_name" class="form-control @error('venue_name') is-invalid @enderror" value="{{ old('venue_name') }}" placeholder="Campus Auditorium / Zoom Meeting">
                        @error('venue_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Max Attendees</label>
                        <input type="number" name="max_attendees" class="form-control" value="{{ old('max_attendees') }}" placeholder="500" min="1">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Start Date & Time *</label>
                        <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date & Time *</label>
                        <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:12px 32px;border-radius:8px;width:100%;">
                    <i class="fas fa-calendar-plus" style="margin-right:8px;"></i> Create Event
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
