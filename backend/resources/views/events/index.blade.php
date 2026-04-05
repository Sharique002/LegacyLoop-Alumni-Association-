@extends('layouts.app')

@section('title', 'Events & Reunions - LegacyLoop')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div>
        <h2 class="serif" style="color:var(--cream);margin:0 0 4px;">Events & Reunions</h2>
        <p style="color:var(--gray);font-size:14px;margin:0;">Join upcoming alumni events and reunions</p>
    </div>
    <a href="{{ route('events.create') }}" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;text-decoration:none;">
        <i class="fas fa-plus" style="margin-right:6px;"></i> Create Event
    </a>
</div>

{{-- Search --}}
<div class="card" style="margin-bottom:24px;">
    <div class="card-body">
        <form method="GET" action="{{ route('events.index') }}" style="display:flex;gap:12px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..." class="form-control" style="flex:1;">
            <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;">Search</button>
        </form>
    </div>
</div>

@if($events->count() > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;">
    @foreach($events as $event)
    <div class="card" style="margin-bottom:0;cursor:pointer;" onclick="window.location='{{ route('events.show', $event->id) }}'">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <div style="width:56px;height:56px;border-radius:14px;background:rgba(212,175,55,0.15);display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0;">📅</div>
                <div style="flex:1;">
                    <h5 style="color:var(--cream);margin:0 0 4px;font-size:16px;">{{ $event->title }}</h5>
                    <span style="font-size:12px;color:var(--gold);font-weight:600;">{{ $event->start_date->format('M d, Y') }}</span>
                </div>
            </div>
            <p style="color:var(--gray);font-size:13px;margin-bottom:14px;line-height:1.6;">{{ Str::limit($event->description, 100) }}</p>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
                <span style="font-size:12px;color:var(--gray);display:flex;align-items:center;gap:4px;"><i class="fas fa-map-marker-alt" style="color:var(--gold);"></i> {{ $event->venue_name ?? $event->location_type }}</span>
                @if($event->max_attendees)
                <span style="font-size:12px;color:var(--gray);display:flex;align-items:center;gap:4px;"><i class="fas fa-users" style="color:var(--blue);"></i> Max {{ $event->max_attendees }}</span>
                @endif
            </div>
            <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline" style="display:block;text-align:center;text-decoration:none;padding:8px 16px;font-size:13px;">View Details</a>
        </div>
    </div>
    @endforeach
</div>
<div style="margin-top:24px;">{{ $events->links() }}</div>
@else
<div class="card"><div class="card-body" style="text-align:center;padding:48px;">
    <i class="fas fa-calendar" style="font-size:48px;color:var(--gray);margin-bottom:16px;"></i>
    <p style="color:var(--gray);margin:0;">No upcoming events found.</p>
    <a href="{{ route('events.create') }}" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-block;margin-top:16px;">Create First Event</a>
</div></div>
@endif
@endsection
