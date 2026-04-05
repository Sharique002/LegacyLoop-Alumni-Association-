@extends('layouts.organization')

@section('title', 'Success Stories')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Success Stories</h1>
        <p class="page-subtitle">Manage and feature alumni success stories</p>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                <div class="stat-label">Total Stories</div>
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
                <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
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
                <div class="stat-value">{{ $stats['approved'] ?? 0 }}</div>
                <div class="stat-label">Published</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139, 92, 246, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #8b5cf6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['featured'] ?? 0 }}</div>
                <div class="stat-label">Featured</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ request('filter', 'all') == 'all' ? 'active' : '' }}" href="{{ route('organization.stories', ['filter' => 'all']) }}" 
           style="background: {{ request('filter', 'all') == 'all' ? 'var(--university-accent)' : 'transparent' }}; color: var(--cream);">All</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('filter') == 'pending' ? 'active' : '' }}" href="{{ route('organization.stories', ['filter' => 'pending']) }}"
           style="background: {{ request('filter') == 'pending' ? 'var(--university-accent)' : 'transparent' }}; color: var(--cream);">Pending</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('filter') == 'approved' ? 'active' : '' }}" href="{{ route('organization.stories', ['filter' => 'approved']) }}"
           style="background: {{ request('filter') == 'approved' ? 'var(--university-accent)' : 'transparent' }}; color: var(--cream);">Approved</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('filter') == 'featured' ? 'active' : '' }}" href="{{ route('organization.stories', ['filter' => 'featured']) }}"
           style="background: {{ request('filter') == 'featured' ? 'var(--university-accent)' : 'transparent' }}; color: var(--cream);">Featured</a>
    </li>
</ul>

<div class="card">
    <div class="card-body p-0">
        @if(isset($stories) && $stories->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Alumni</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stories as $story)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">{{ strtoupper(substr($story->user->name ?? 'A', 0, 2)) }}</div>
                                <div>
                                    <div class="fw-semibold">{{ $story->user->name ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $story->user->graduation_year ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $story->title }}</td>
                        <td><span class="badge badge-info">{{ ucfirst($story->category ?? 'General') }}</span></td>
                        <td>{{ $story->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($story->is_featured)
                            <span class="badge badge-warning">⭐ Featured</span>
                            @elseif($story->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                            @elseif($story->status == 'rejected')
                            <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #ef4444;">Rejected</span>
                            @else
                            <span class="badge badge-info">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('organization.stories.show', $story->id) }}" class="btn btn-sm btn-outline">View</a>
                                @if($story->status != 'approved')
                                <form action="{{ route('organization.stories.approve', $story->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline" style="color: #22c55e;">Approve</button>
                                </form>
                                @endif
                                @if(!$story->is_featured && $story->status == 'approved')
                                <form action="{{ route('organization.stories.feature', $story->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline" style="color: #fbbf24;">Feature</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-3" style="opacity: 0.5; color: #fbbf24;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
            <h5 style="color: #f5f5dc; font-weight: 600; margin-bottom: 8px;">No success stories yet</h5>
            <p style="color: #a5b4fc; margin-bottom: 20px;">Alumni success stories will appear here once submitted</p>
        </div>
        @endif
    </div>
</div>

@if(isset($stories) && $stories->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $stories->links() }}
</div>
@endif
@endsection
