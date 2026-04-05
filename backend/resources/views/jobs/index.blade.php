@extends('layouts.app')

@section('title', 'Job Portal - LegacyLoop')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 style="color: var(--cream); margin: 0; font-family: 'DM Serif Display', serif; font-size: 32px;">
            <i class="fas fa-briefcase" style="margin-right: 12px; color: var(--green);"></i>
            Job Portal
        </h1>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Post a Job
        </a>
    </div>

    <!-- Search -->
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('jobs.index') }}" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 16px; align-items: end;">
                <div>
                    <label class="form-label">Search Jobs</label>
                    <input type="text" name="search" class="form-control" placeholder="Title, company, or keywords" value="{{ request('search') }}">
                </div>

                <div>
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="City or Remote" value="{{ request('location') }}">
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <!-- Jobs List -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        @forelse($jobs as $job)
        <div class="card" style="cursor: pointer; margin-bottom: 0;" onclick="window.location.href='{{ route('jobs.show', $job->id) }}';">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                    <div>
                        <h5 style="color: var(--cream); margin-bottom: 4px;">{{ $job->title }}</h5>
                        <p style="color: var(--gray); font-size: 14px; margin: 0;">{{ $job->company }} • {{ $job->location }}</p>
                    </div>
                    <span class="badge badge-success" style="padding: 6px 12px;">{{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</span>
                </div>

                <p style="color: var(--gray); font-size: 13px; margin-bottom: 12px;">{{ Str::limit($job->description, 150) }}</p>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; gap: 12px; font-size: 12px; color: var(--gray);">
                        @if($job->salary_min)
                        <span><i class="fas fa-rupee-sign"></i> {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}</span>
                        @endif
                        <span><i class="fas fa-calendar"></i> {{ $job->created_at->diffForHumans() }}</span>
                    </div>
                    <span style="font-size: 12px; color: var(--gold);">{{ $job->applications()->count() }} applications</span>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 60px 20px; color: var(--gray);">
            <i class="fas fa-search" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <p>No jobs found. Check back soon!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($jobs->hasPages())
    <div style="display: flex; justify-content: center; gap: 8px;">
        {{ $jobs->links() }}
    </div>
    @endif
</div>
@endsection
