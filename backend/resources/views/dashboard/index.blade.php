@extends('layouts.app')

@section('title', 'Dashboard - LegacyLoop')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Welcome Banner -->
    <div style="
        background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-light) 100%);
        border: 1px solid rgba(212, 175, 55, 0.15);
        border-radius: 20px;
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    ">
        <div style="position: absolute; right: -30px; top: -30px; width: 200px; height: 200px; border-radius: 50%; background: rgba(212, 175, 55, 0.08);"></div>

        <div>
            <div style="font-size: 13px; color: var(--gold); margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em;">
                {{ $greeting ?? 'Welcome Back' }} 👋
            </div>
            <h2 style="font-family: 'DM Serif Display', serif; font-size: 28px; color: var(--cream); margin: 0 0 8px; font-weight: 400;">
                {{ $user->first_name }} {{ $user->last_name }}
            </h2>
            <p style="color: var(--gray); font-size: 14px; margin: 0;">
                {{ $user->branch }} Batch {{ $user->graduation_year }}
                @if($user->job_title) · {{ $user->job_title }} @endif
                @if($user->company) at {{ $user->company }} @endif
            </p>
        </div>

        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->first_name }}" 
                 class="avatar" style="width: 72px; height: 72px; object-fit: cover;">
        @else
            <div class="avatar" style="width: 72px; height: 72px; font-size: 28px;">
                {{ $user->getInitials() }}
            </div>
        @endif
    </div>

    <!-- Statistics Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;">
        <div class="stat-card">
            <i class="fas fa-users" style="font-size: 28px; color: var(--blue);"></i>
            <div class="stat-value">{{ number_format($stats['total_alumni']) }}</div>
            <div class="stat-label">Active Alumni</div>
        </div>

        <div class="stat-card">
            <i class="fas fa-briefcase" style="font-size: 28px; color: var(--green);"></i>
            <div class="stat-value">{{ number_format($stats['active_jobs']) }}</div>
            <div class="stat-label">Job Openings</div>
        </div>

        <div class="stat-card">
            <i class="fas fa-calendar" style="font-size: 28px; color: var(--warning);"></i>
            <div class="stat-value">{{ number_format($stats['upcoming_events']) }}</div>
            <div class="stat-label">Upcoming Events</div>
        </div>

        <div class="stat-card">
            <i class="fas fa-heart" style="font-size: 28px; color: var(--danger);"></i>
            <div class="stat-value">₹{{ number_format($stats['total_donations'] ?? 0, 0) }}</div>
            <div class="stat-label">Total Donations</div>
        </div>
    </div>

    <!-- Recent Jobs Section -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px;">
                <h5 style="margin: 0; color: var(--cream);">
                    <i class="fas fa-briefcase" style="margin-right: 8px; color: var(--green);"></i>
                    Recent Job Openings
                </h5>
                <a href="{{ route('jobs.index') }}" style="color: var(--gold); text-decoration: none; font-size: 14px;">View All →</a>
            </div>
        </div>
        <div class="card-body">
            @if($recent_jobs->count() > 0)
                <table class="table table-hover" style="margin-bottom: 0;">
                    <tbody>
                        @foreach($recent_jobs as $job)
                        <tr style="cursor: pointer;" onclick="window.location.href='{{ route('jobs.show', $job->id) }}';">
                            <td style="vertical-align: middle;">
                                <strong style="color: var(--gold);">{{ $job->title }}</strong>
                                <br>
                                <small style="color: var(--gray);">{{ $job->company }}</small>
                            </td>
                            <td style="text-align: right; vertical-align: middle;">
                                <span class="badge badge-success" style="padding: 6px 12px;">{{ $job->location }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: var(--gray); margin: 0;">No active jobs at the moment</p>
            @endif
        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px;">
                <h5 style="margin: 0; color: var(--cream);">
                    <i class="fas fa-calendar" style="margin-right: 8px; color: var(--warning);"></i>
                    Upcoming Events
                </h5>
                <a href="{{ route('events.index') }}" style="color: var(--gold); text-decoration: none; font-size: 14px;">View All →</a>
            </div>
        </div>
        <div class="card-body">
            @if($upcoming_events->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px;">
                    @foreach($upcoming_events as $event)
                    <div style="background: rgba(212, 175, 55, 0.05); border: 1px solid rgba(212, 175, 55, 0.1); border-radius: 12px; padding: 16px; cursor: pointer;" onclick="window.location.href='{{ route('events.show', $event->id) }}';">
                        <div style="font-size: 12px; color: var(--gold); text-transform: uppercase; margin-bottom: 8px;">
                            {{ $event->start_date->format('M d, Y') }}
                        </div>
                        <h6 style="color: var(--cream); margin-bottom: 8px;">{{ $event->title }}</h6>
                        <p style="font-size: 13px; color: var(--gray); margin-bottom: 12px;">{{ Str::limit($event->description, 50) }}</p>
                        <span class="badge badge-primary" style="padding: 4px 8px; font-size: 12px;">{{ $event->attendees_count ?? 0 }} Attending</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: var(--gray); margin: 0;">No upcoming events</p>
            @endif
        </div>
    </div>

    <!-- Suggested Alumni to Connect -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px;">
                <h5 style="margin: 0; color: var(--cream);">
                    <i class="fas fa-users" style="margin-right: 8px; color: var(--blue);"></i>
                    Suggested Alumni
                </h5>
                <a href="{{ route('alumni.index') }}" style="color: var(--gold); text-decoration: none; font-size: 14px;">View All →</a>
            </div>
        </div>
        <div class="card-body">
            @if($suggested_alumni->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                    @foreach($suggested_alumni as $alumni)
                    <div style="background: rgba(212, 175, 55, 0.05); border: 1px solid rgba(212, 175, 55, 0.1); border-radius: 12px; padding: 16px; text-align: center;">
                        <div class="avatar" style="margin: 0 auto 12px; width: 56px; height: 56px; font-size: 22px;">
                            {{ $alumni->getInitials() }}
                        </div>
                        <h6 style="color: var(--cream); margin-bottom: 4px;">{{ $alumni->first_name }} {{ $alumni->last_name }}</h6>
                        <p style="font-size: 12px; color: var(--gray); margin-bottom: 12px;">
                            {{ $alumni->branch }} {{ $alumni->graduation_year }}
                        </p>
                        <form action="{{ route('connections.send') }}" method="POST" style="margin: 0;">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $alumni->id }}">
                            <button type="submit" class="btn btn-outline" style="width: 100%; font-size: 13px; padding: 8px 12px;">
                                <i class="fas fa-user-plus"></i> Connect
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: var(--gray); margin: 0;">No suggestions available</p>
            @endif
        </div>
    </div>
</div>

<script>
    // Set greeting based on time
    (function() {
        const hour = new Date().getHours();
        let greeting = 'Welcome Back';
        if (hour < 12) greeting = 'Good Morning';
        else if (hour < 17) greeting = 'Good Afternoon';
        else greeting = 'Good Evening';

        // Update greeting if element exists
        const greetingEl = document.querySelector('[data-greeting]');
        if (greetingEl) greetingEl.textContent = greeting;
    })();
</script>
@endsection
