@extends('layouts.organization')

@section('title', 'Dashboard')

@section('styles')
<style>
    .welcome-text {
        animation: fadeInUp 0.6s ease-out;
    }

    .progress-bar-animated {
        animation: progressFill 1.5s ease-out forwards;
        transform-origin: left;
    }

    @keyframes progressFill {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }

    .chart-bar {
        position: relative;
        overflow: hidden;
    }

    .chart-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmerBar 2s ease-in-out infinite;
    }

    @keyframes shimmerBar {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: rgba(79, 70, 229, 0.1);
        border: 1px solid rgba(79, 70, 229, 0.2);
        border-radius: 12px;
        color: var(--cream);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .quick-action:hover {
        background: rgba(79, 70, 229, 0.2);
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(79, 70, 229, 0.2);
        color: var(--cream);
    }

    .quick-action svg {
        width: 24px;
        height: 24px;
        color: var(--university-accent);
    }

    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(79, 70, 229, 0.1);
        animation: fadeIn 0.5s ease-out;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--university-accent);
        margin-top: 5px;
        flex-shrink: 0;
        animation: pulse 2s ease-in-out infinite;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="welcome-text">
        <h1 class="page-title">Welcome back, {{ $organization->name }}</h1>
        <p class="page-subtitle">Here's an overview of your alumni network</p>
    </div>
    <a href="{{ route('organization.events.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Create Event
    </a>
</div>

@if (!$organization->is_verified)
<div class="alert alert-warning mb-4">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span><strong>Verification Pending:</strong> Your organization account is being reviewed. Some features like creating events are restricted until verification is complete. This usually takes 24-48 hours.</span>
</div>
@endif

<!-- Stats Grid -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_alumni']) }}</div>
                <div class="stat-label">Total Alumni</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['active_alumni']) }}</div>
                <div class="stat-label">Active Alumni</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_events']) }}</div>
                <div class="stat-label">Total Events</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['upcoming_events']) }}</div>
                <div class="stat-label">Upcoming Events</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('organization.alumni') }}" class="quick-action">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span>Search Alumni</span>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('organization.messages.create') }}" class="quick-action">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span>Send Message</span>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('organization.analytics') }}" class="quick-action">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span>View Analytics</span>
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Alumni -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Recent Alumni</h3>
                <a href="{{ route('organization.alumni') }}" class="btn btn-outline btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
                @if(count($recentAlumni) > 0)
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Graduation</th>
                            <th>Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAlumni as $index => $alumni)
                        <tr style="animation-delay: {{ $index * 0.1 }}s;">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar">{{ strtoupper(substr($alumni->first_name, 0, 1) . substr($alumni->last_name, 0, 1)) }}</div>
                                    <div>
                                        <div style="font-weight: 500;">{{ $alumni->first_name }} {{ $alumni->last_name }}</div>
                                        <div style="font-size: 12px; color: var(--gray);">{{ $alumni->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $alumni->graduation_year }}</td>
                            <td><span class="badge badge-info">{{ $alumni->branch }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h3>No alumni registered yet</h3>
                    <p>Alumni will appear here once they register</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Upcoming Events</h3>
                <a href="{{ route('organization.events') }}" class="btn btn-outline btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
                @if(count($upcomingEvents) > 0)
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingEvents as $index => $event)
                        <tr style="animation-delay: {{ $index * 0.1 }}s;">
                            <td>
                                <div style="font-weight: 500;">{{ $event->title }}</div>
                                <div style="font-size: 12px; color: var(--gray);">{{ $event->event_type }}</div>
                            </td>
                            <td>{{ $event->start_date->format('M d, Y') }}</td>
                            <td><span class="badge badge-success">{{ ucfirst($event->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3>No upcoming events</h3>
                    <p>Create your first event to engage with alumni</p>
                    @if($organization->is_verified)
                    <a href="{{ route('organization.events.create') }}" class="btn btn-primary mt-3">Create Your First Event</a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Alumni by Year & Branch -->
<div class="row g-4 mt-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Alumni by Graduation Year</h3>
            </div>
            <div class="card-body">
                @if(count($alumniByYear) > 0)
                @foreach($alumniByYear as $index => $item)
                <div class="d-flex justify-content-between align-items-center mb-3" style="animation: fadeInUp 0.5s ease-out {{ $index * 0.1 }}s both;">
                    <span style="font-weight: 500;">{{ $item->graduation_year }}</span>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 140px; height: 10px; background: rgba(79, 70, 229, 0.15); border-radius: 5px; overflow: hidden;">
                            <div class="chart-bar progress-bar-animated" style="width: {{ min(($item->count / max($alumniByYear->max('count'), 1)) * 100, 100) }}%; height: 100%; background: linear-gradient(90deg, var(--university-accent), #6366f1); border-radius: 5px; animation-delay: {{ $index * 0.1 }}s;"></div>
                        </div>
                        <span style="min-width: 40px; text-align: right; font-weight: 600; color: var(--university-accent);">{{ $item->count }}</span>
                    </div>
                </div>
                @endforeach
                @else
                <div class="empty-state" style="padding: 30px;">
                    <p style="color: var(--gray);">No data available yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Alumni by Branch</h3>
            </div>
            <div class="card-body">
                @if(count($alumniByBranch) > 0)
                @foreach($alumniByBranch as $index => $item)
                <div class="d-flex justify-content-between align-items-center mb-3" style="animation: fadeInUp 0.5s ease-out {{ $index * 0.1 }}s both;">
                    <span style="font-weight: 500;">{{ $item->branch }}</span>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 140px; height: 10px; background: rgba(212, 175, 55, 0.15); border-radius: 5px; overflow: hidden;">
                            <div class="chart-bar progress-bar-animated" style="width: {{ min(($item->count / max($alumniByBranch->max('count'), 1)) * 100, 100) }}%; height: 100%; background: linear-gradient(90deg, var(--gold), #f59e0b); border-radius: 5px; animation-delay: {{ $index * 0.1 }}s;"></div>
                        </div>
                        <span style="min-width: 40px; text-align: right; font-weight: 600; color: var(--gold);">{{ $item->count }}</span>
                    </div>
                </div>
                @endforeach
                @else
                <div class="empty-state" style="padding: 30px;">
                    <p style="color: var(--gray);">No data available yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
