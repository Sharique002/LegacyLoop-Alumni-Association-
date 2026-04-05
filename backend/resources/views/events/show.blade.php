@extends('layouts.app')

@section('title', $event->title . ' - LegacyLoop')

@section('content')
<div style="max-width:800px;">
    <a href="{{ route('events.index') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Events
    </a>

    <div class="card">
        <div class="card-body" style="padding:32px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
                <div>
                    <h2 class="serif" style="color:var(--cream);margin:0 0 8px;font-size:28px;">{{ $event->title }}</h2>
                    <div style="display:flex;gap:16px;flex-wrap:wrap;">
                        <span style="color:var(--gold);font-size:14px;"><i class="fas fa-calendar" style="margin-right:6px;"></i>{{ $event->start_date->format('F d, Y \a\t g:i A') }}</span>
                        <span style="color:var(--gray);font-size:14px;"><i class="fas fa-map-marker-alt" style="margin-right:6px;"></i>{{ $event->venue_name ?? $event->location_type }}</span>
                        @if($event->max_attendees)
                        <span style="color:var(--gray);font-size:14px;"><i class="fas fa-users" style="margin-right:6px;"></i>Max {{ $event->max_attendees }} attendees</span>
                        @endif
                    </div>
                </div>
                <div>
                    @if($is_registered)
                        <form action="{{ route('events.unregister', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline" style="padding:10px 20px;">
                                <i class="fas fa-times" style="margin-right:6px;"></i> Cancel Registration
                            </button>
                        </form>
                    @else
                        <form action="{{ route('events.register', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;">
                                <i class="fas fa-check" style="margin-right:6px;"></i> Register Now
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <hr style="border-color:rgba(212,175,55,0.15);margin-bottom:24px;">

            <h5 style="color:var(--gold);margin-bottom:12px;">About This Event</h5>
            <p style="color:var(--gray);line-height:1.8;white-space:pre-wrap;">{{ $event->description }}</p>
        </div>
    </div>
</div>
@endsection
