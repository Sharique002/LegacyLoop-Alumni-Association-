@extends('layouts.organization')

@section('title', 'Create Announcement')

@section('styles')
<style>
    .section-title {
        color: var(--university-accent);
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
        padding: 8px 12px;
        background: rgba(79, 70, 229, 0.1);
        border-left: 3px solid var(--university-accent);
        border-radius: 4px;
        display: inline-block;
    }
    .form-label {
        color: var(--cream);
        font-weight: 500;
        margin-bottom: 8px;
        font-size: 13px;
        display: block;
    }
    .form-control, .form-select {
        background: rgba(26, 31, 58, 0.8);
        border: 1px solid rgba(79, 70, 229, 0.3);
        color: var(--cream);
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(26, 31, 58, 0.95);
        border-color: var(--university-accent);
        color: var(--cream);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2), 0 5px 20px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    .form-control::placeholder {
        color: var(--gray);
    }
    .form-select option {
        background: var(--primary);
        color: var(--cream);
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: rgba(79, 70, 229, 0.1);
        border: 1px solid rgba(79, 70, 229, 0.2);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .form-check:hover {
        background: rgba(79, 70, 229, 0.15);
    }
    .form-check-input {
        width: 20px;
        height: 20px;
        background-color: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(79, 70, 229, 0.4);
        border-radius: 4px;
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
    }
    .form-check-input:checked {
        background-color: var(--university-accent);
        border-color: var(--university-accent);
    }
    .form-check-label {
        color: var(--cream);
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        margin: 0;
    }
    .invalid-feedback {
        color: #fca5a5;
        font-size: 12px;
        margin-top: 6px;
    }
    .text-danger {
        color: #f87171 !important;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ isset($announcement) ? 'Edit Announcement' : 'Create Announcement' }}</h1>
        <p class="page-subtitle">{{ isset($announcement) ? 'Update your announcement' : 'Send a new announcement to your alumni network' }}</p>
    </div>
    <a href="{{ route('organization.announcements') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Announcements
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($announcement) ? route('organization.announcements.update', $announcement->id) : route('organization.announcements.store') }}" method="POST">
            @csrf
            @if(isset($announcement))
            @method('PUT')
            @endif
            
            <div class="row g-4">
                <div class="col-12">
                    <h5 class="section-title">Announcement Details</h5>
                </div>

                <div class="col-12">
                    <label class="form-label">Announcement Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $announcement->title ?? '') }}" placeholder="e.g., Alumni Reunion 2026" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" rows="6" class="form-control @error('content') is-invalid @enderror" 
                              placeholder="Write your announcement message here..." required>{{ old('content', $announcement->content ?? '') }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Targeting & Priority</h5>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Target Audience</label>
                    <select name="target_audience" class="form-select">
                        <option value="all" {{ old('target_audience', $announcement->target_audience ?? '') == 'all' ? 'selected' : '' }}>All Alumni</option>
                        <option value="recent" {{ old('target_audience', $announcement->target_audience ?? '') == 'recent' ? 'selected' : '' }}>Recent Graduates (Last 5 years)</option>
                        <option value="donors" {{ old('target_audience', $announcement->target_audience ?? '') == 'donors' ? 'selected' : '' }}>Donors</option>
                        <option value="mentors" {{ old('target_audience', $announcement->target_audience ?? '') == 'mentors' ? 'selected' : '' }}>Mentors</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="normal" {{ old('priority', $announcement->priority ?? '') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ old('priority', $announcement->priority ?? '') == 'high' ? 'selected' : '' }}>High Priority</option>
                        <option value="urgent" {{ old('priority', $announcement->priority ?? '') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Notification Settings</h5>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="send_email" value="1" class="form-check-input" id="sendEmail" {{ old('send_email') ? 'checked' : '' }}>
                        <label class="form-check-label" for="sendEmail">
                            Also send as email notification to alumni
                        </label>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <hr style="border-color: rgba(79, 70, 229, 0.2);">
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" name="action" value="publish" class="btn btn-primary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            {{ isset($announcement) && $announcement->is_published ? 'Update & Publish' : 'Publish Now' }}
                        </button>
                        <button type="submit" name="action" value="draft" class="btn btn-outline">
                            Save as Draft
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
