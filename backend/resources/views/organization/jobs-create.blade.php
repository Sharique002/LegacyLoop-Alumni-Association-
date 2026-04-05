@extends('layouts.organization')

@section('title', 'Post New Job')

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
        <h1 class="page-title">{{ isset($job) ? 'Edit Job' : 'Post New Job' }}</h1>
        <p class="page-subtitle">{{ isset($job) ? 'Update job posting details' : 'Create a job posting for your alumni network' }}</p>
    </div>
    <a href="{{ route('organization.jobs') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Jobs
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($job) ? route('organization.jobs.update', $job->id) : route('organization.jobs.store') }}" method="POST">
            @csrf
            @if(isset($job))
            @method('PUT')
            @endif
            
            <div class="row g-4">
                <div class="col-12">
                    <h5 class="section-title">Job Information</h5>
                </div>

                <div class="col-md-8">
                    <label class="form-label">Job Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $job->title ?? '') }}" placeholder="e.g., Software Engineer" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Job Type <span class="text-danger">*</span></label>
                    <select name="job_type" class="form-select" required>
                        <option value="full-time" {{ old('job_type', $job->job_type ?? '') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('job_type', $job->job_type ?? '') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ old('job_type', $job->job_type ?? '') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="internship" {{ old('job_type', $job->job_type ?? '') == 'internship' ? 'selected' : '' }}>Internship</option>
                        <option value="remote" {{ old('job_type', $job->job_type ?? '') == 'remote' ? 'selected' : '' }}>Remote</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                    <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" 
                           value="{{ old('company', $job->company_name ?? $organization->name) }}" required>
                    @error('company')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Location <span class="text-danger">*</span></label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                           value="{{ old('location', $job->location ?? '') }}" placeholder="e.g., Mumbai, India or Remote" required>
                    @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Compensation & Requirements</h5>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Experience Level</label>
                    <select name="experience" class="form-select">
                        <option value="entry" {{ old('experience', $job->experience_level ?? '') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="mid" {{ old('experience', $job->experience_level ?? '') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                        <option value="senior" {{ old('experience', $job->experience_level ?? '') == 'senior' ? 'selected' : '' }}>Senior Level</option>
                        <option value="lead" {{ old('experience', $job->experience_level ?? '') == 'lead' ? 'selected' : '' }}>Lead/Manager</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="deadline" class="form-control" 
                           value="{{ old('deadline', isset($job) && $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}">
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Job Details</h5>
                </div>

                <div class="col-12">
                    <label class="form-label">Job Description <span class="text-danger">*</span></label>
                    <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" 
                              placeholder="Describe the role, responsibilities, and what you're looking for..." required>{{ old('description', $job->description ?? '') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Requirements</label>
                    <textarea name="requirements" rows="4" class="form-control" 
                              placeholder="List the skills, qualifications, and requirements...">{{ old('requirements', $job->requirements ?? '') }}</textarea>
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Application Settings</h5>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Application Email/Link</label>
                    <input type="text" name="apply_link" class="form-control" 
                           value="{{ old('apply_link', $job->application_url ?? '') }}" placeholder="Email or URL for applications">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $job->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="closed" {{ old('status', $job->status ?? '') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="filled" {{ old('status', $job->status ?? '') == 'filled' ? 'selected' : '' }}>Position Filled</option>
                    </select>
                </div>

                <div class="col-12 mt-4">
                    <hr style="border-color: rgba(79, 70, 229, 0.2);">
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ isset($job) ? 'Update Job' : 'Publish Job' }}
                        </button>
                        <a href="{{ route('organization.jobs') }}" class="btn btn-outline">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
