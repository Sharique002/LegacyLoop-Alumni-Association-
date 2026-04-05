@extends('layouts.app')

@section('title', 'Share Your Story - LegacyLoop')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('stories.index') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Stories
    </a>
    <div class="card">
        <div class="card-body" style="padding:32px;">
            <h2 class="serif" style="color:var(--cream);margin:0 0 8px;">Share Your Success Story</h2>
            <p style="color:var(--gray);font-size:14px;margin-bottom:28px;">Your story will be reviewed before being published.</p>
            <form method="POST" action="{{ route('stories.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Story Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="From Engineer to Entrepreneur..." required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Your Story *</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="12" placeholder="Share your journey, achievements, challenges and lessons..." required>{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:12px 32px;border-radius:8px;width:100%;">
                    <i class="fas fa-paper-plane" style="margin-right:8px;"></i> Submit for Review
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
