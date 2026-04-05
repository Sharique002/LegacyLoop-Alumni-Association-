@extends('layouts.organization')

@section('title', 'Job Applications')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Applications for {{ $job->title }}</h1>
        <p class="page-subtitle">{{ $job->company }} • {{ $job->location }}</p>
    </div>
    <a href="{{ route('organization.jobs') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Jobs
    </a>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $applications->total() }}</div>
                <div class="stat-label">Total Applications</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(251, 191, 36, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fbbf24;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $applications->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Pending Review</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #22c55e;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $applications->where('status', 'shortlisted')->count() }}</div>
                <div class="stat-label">Shortlisted</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139, 92, 246, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #8b5cf6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ ucfirst($job->job_type) }}</div>
                <div class="stat-label">Job Type</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">All Applications</h5>
    </div>
    <div class="card-body p-0">
        @if($applications->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Experience</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Resume</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">{{ strtoupper(substr($application->user->name ?? 'A', 0, 2)) }}</div>
                                <div>
                                    <div class="fw-semibold">{{ $application->user->name ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $application->user->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $application->experience ?? '-' }}</td>
                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($application->status == 'shortlisted')
                            <span class="badge badge-success">Shortlisted</span>
                            @elseif($application->status == 'rejected')
                            <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #ef4444;">Rejected</span>
                            @elseif($application->status == 'hired')
                            <span class="badge" style="background: rgba(34, 197, 94, 0.3); color: #22c55e;">Hired</span>
                            @else
                            <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($application->resume_url)
                            <a href="{{ $application->resume_url }}" target="_blank" class="btn btn-sm btn-outline">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                View
                            </a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($application->status == 'pending')
                                <button class="btn btn-sm btn-outline" style="color: #22c55e;" title="Shortlist">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                                <button class="btn btn-sm btn-outline" style="color: #ef4444;" title="Reject">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                @endif
                                <a href="mailto:{{ $application->user->email ?? '' }}" class="btn btn-sm btn-outline" title="Contact">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-muted mb-3" style="opacity: 0.3">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h5 class="text-muted">No applications yet</h5>
            <p class="text-muted">Applications will appear here when alumni apply for this position</p>
        </div>
        @endif
    </div>
</div>

@if($applications->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $applications->links() }}
</div>
@endif
@endsection
