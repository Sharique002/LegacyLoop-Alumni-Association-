@extends('layouts.organization')

@section('title', 'Story Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Success Story</h1>
        <p class="page-subtitle">Review and manage alumni success story</p>
    </div>
    <a href="{{ route('organization.stories') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Stories
    </a>
</div>

<!-- Story Header -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar" style="width: 60px; height: 60px; font-size: 24px;">
                        {{ strtoupper(substr($story->user->name ?? 'A', 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="mb-1" style="color: var(--cream);">{{ $story->user->name ?? 'Unknown Alumni' }}</h4>
                        <p class="text-muted mb-0">
                            {{ $story->user->graduation_year ?? '' }} • {{ $story->user->branch ?? '' }}
                        </p>
                    </div>
                </div>
                <h3 style="color: var(--gold); margin-bottom: 16px;">{{ $story->title }}</h3>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge badge-info">{{ ucfirst($story->category ?? 'General') }}</span>
                    @if($story->is_featured)
                    <span class="badge badge-warning">⭐ Featured</span>
                    @elseif($story->status == 'approved' || $story->status == 'published')
                    <span class="badge badge-success">Approved</span>
                    @elseif($story->status == 'rejected')
                    <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #ef4444;">Rejected</span>
                    @else
                    <span class="badge badge-info">Pending Review</span>
                    @endif
                </div>
                <p class="text-muted">
                    Submitted on {{ $story->created_at->format('F d, Y') }}
                    @if($story->published_at)
                    • Published on {{ $story->published_at->format('F d, Y') }}
                    @endif
                </p>
            </div>
            <div class="col-md-4">
                <div class="d-flex flex-column gap-2">
                    @if($story->status != 'approved' && $story->status != 'published')
                    <form action="{{ route('organization.stories.approve', $story->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve Story
                        </button>
                    </form>
                    @endif
                    @if(!$story->is_featured && ($story->status == 'approved' || $story->status == 'published'))
                    <form action="{{ route('organization.stories.feature', $story->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline w-100" style="color: #fbbf24; border-color: #fbbf24;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Feature Story
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Story Content -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Story Content</h5>
    </div>
    <div class="card-body">
        @if($story->featured_image)
        <div class="mb-4">
            <img src="{{ $story->featured_image }}" alt="Story Image" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
        </div>
        @endif
        <div class="story-content" style="color: var(--cream); line-height: 1.9; font-size: 16px;">
            {!! nl2br(e($story->content)) !!}
        </div>
    </div>
</div>

<!-- Story Stats -->
<div class="row g-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $story->views_count ?? 0 }}</div>
                <div class="stat-label">Views</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ef4444;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $story->likes_count ?? 0 }}</div>
                <div class="stat-label">Likes</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #3b82f6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $story->shares_count ?? 0 }}</div>
                <div class="stat-label">Shares</div>
            </div>
        </div>
    </div>
</div>
@endsection
