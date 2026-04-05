@extends('layouts.organization')

@section('title', 'Events')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Events</h1>
        <p class="page-subtitle">Manage events for your alumni community</p>
    </div>
    @if($organization->is_verified)
    <a href="{{ route('organization.events.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Create Event
    </a>
    @endif
</div>

@if(!$organization->is_verified)
<div class="alert alert-warning mb-4">
    <strong>⏳ Verification Required:</strong> Your organization must be verified to create events. Please wait for admin approval.
</div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('organization.events') }}" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select" style="background: rgba(255,255,255,0.05); border-color: rgba(79,70,229,0.3); color: var(--cream);">
                    <option value="">All Statuses</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-check" style="padding-top: 8px; display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="upcoming" value="1" class="form-check-input" id="upcoming" {{ request('upcoming') ? 'checked' : '' }} style="width: 20px; height: 20px; margin: 0;">
                    <label class="form-check-label" for="upcoming" style="color: var(--cream); font-weight: 500; cursor: pointer;">Upcoming Only</label>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('organization.events') }}" class="btn btn-outline w-100">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Events List -->
<div class="card">
    <div class="card-body p-0">
        @if($events->count() > 0)
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Date & Time</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Attendees</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $event->title }}</div>
                        <div style="font-size: 12px; color: var(--gray); max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Str::limit($event->description, 50) }}
                        </div>
                    </td>
                    <td>
                        <div>{{ $event->start_date->format('M d, Y') }}</div>
                        <div style="font-size: 12px; color: var(--gray);">{{ $event->start_date->format('h:i A') }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($event->event_type) }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $event->location_type == 'online' ? 'badge-success' : ($event->location_type == 'hybrid' ? 'badge-warning' : 'badge-info') }}">
                            {{ ucfirst($event->location_type) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $event->attendees_count }}
                            @if($event->max_attendees)
                            / {{ $event->max_attendees }}
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($event->status == 'published')
                        <span class="badge badge-success">Published</span>
                        @elseif($event->status == 'draft')
                        <span class="badge badge-warning">Draft</span>
                        @else
                        <span class="badge" style="background: rgba(239,68,68,0.2); color: #fca5a5;">Cancelled</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('organization.events.edit', $event->id) }}" class="btn btn-outline btn-sm" title="Edit">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('organization.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm" style="border-color: rgba(239,68,68,0.3); color: #fca5a5;" title="Delete">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center p-3" style="border-top: 1px solid rgba(79,70,229,0.15);">
            <div style="color: var(--gray); font-size: 14px;">
                Showing {{ $events->firstItem() ?? 0 }} to {{ $events->lastItem() ?? 0 }} of {{ $events->total() }} events
            </div>
            <div>
                {{ $events->links() }}
            </div>
        </div>
        @else
        <div class="text-center py-5" style="color: var(--gray);">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 16px; opacity: 0.5;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h4>No Events Yet</h4>
            <p>You haven't created any events yet.</p>
            @if($organization->is_verified)
            <a href="{{ route('organization.events.create') }}" class="btn btn-primary mt-2">Create Your First Event</a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-select:focus {
        background: rgba(255,255,255,0.08) !important;
        border-color: var(--university-accent) !important;
        color: var(--cream) !important;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }
    .form-select option {
        background: var(--primary);
        color: var(--cream);
    }
    .form-check-input {
        background-color: rgba(255,255,255,0.1);
        border-color: rgba(79,70,229,0.3);
    }
    .form-check-input:checked {
        background-color: var(--university-accent);
        border-color: var(--university-accent);
    }
    .form-check-label {
        color: var(--cream) !important;
        font-weight: 500;
    }
    .pagination { margin: 0; }
    .page-link {
        background: rgba(79,70,229,0.1);
        border-color: rgba(79,70,229,0.2);
        color: var(--cream);
    }
    .page-link:hover {
        background: rgba(79,70,229,0.2);
        border-color: var(--university-accent);
        color: var(--cream);
    }
    .page-item.active .page-link {
        background: var(--university-accent);
        border-color: var(--university-accent);
    }
</style>
@endsection
