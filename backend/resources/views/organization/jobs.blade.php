@extends('layouts.organization')

@section('title', 'Job Postings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Job Postings</h1>
        <p class="page-subtitle">Post job opportunities for your alumni network</p>
    </div>
    <a href="{{ route('organization.jobs.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Post New Job
    </a>
</div>

@if(!$organization->is_verified)
<div class="alert alert-warning mb-4">
    <strong>⚠️ Verification Required:</strong> Your institution must be verified before job postings are visible to alumni.
</div>
@endif

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                <div class="stat-label">Total Jobs</div>
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
                <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
                <div class="stat-label">Active Jobs</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(251, 191, 36, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fbbf24;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['views'] ?? 0 }}</div>
                <div class="stat-label">Total Views</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139, 92, 246, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #8b5cf6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['applications'] ?? 0 }}</div>
                <div class="stat-label">Applications</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Job Listings</h5>
    </div>
    <div class="card-body p-0">
        @if(isset($jobs) && $jobs->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Applications</th>
                        <th>Status</th>
                        <th>Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $job->title }}</div>
                            <small class="text-muted">{{ $job->location }}</small>
                        </td>
                        <td>{{ $job->company_name }}</td>
                        <td><span class="badge badge-info">{{ ucfirst($job->job_type) }}</span></td>
                        <td>{{ $job->applications_count ?? 0 }}</td>
                        <td>
                            @if($job->status == 'active')
                            <span class="badge badge-success">Active</span>
                            @elseif($job->status == 'closed')
                            <span class="badge badge-warning">Closed</span>
                            @else
                            <span class="badge badge-info">{{ ucfirst($job->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('organization.jobs.edit', $job->id) }}" class="btn btn-sm btn-outline">Edit</a>
                                <a href="{{ route('organization.jobs.applications', $job->id) }}" class="btn btn-sm btn-outline">Applications</a>
                                <form action="{{ route('organization.jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this job posting?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline" style="color: #fca5a5;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-3" style="opacity: 0.5; color: #a5b4fc;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h5 style="color: #f5f5dc; font-weight: 600; margin-bottom: 8px;">No job postings yet</h5>
            <p style="color: #a5b4fc; margin-bottom: 20px;">Post your first job opportunity for alumni</p>
            <a href="{{ route('organization.jobs.create') }}" class="btn btn-primary">Post a Job</a>
        </div>
        @endif
    </div>
</div>
@endsection
