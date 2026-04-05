@extends('layouts.app')

@section('title', 'Post a Job - LegacyLoop')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('jobs.index') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Jobs
    </a>
    <div class="card">
        <div class="card-body" style="padding:32px;">
            <h2 class="serif" style="color:var(--cream);margin:0 0 24px;">Post a Job</h2>
            <form method="POST" action="{{ route('jobs.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Job Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Senior Software Engineer" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Job Type *</label>
                        <select name="job_type" class="form-control @error('job_type') is-invalid @enderror" required>
                            <option value="">Select...</option>
                            @foreach(['full-time','part-time','contract','internship'] as $t)
                            <option value="{{ $t }}" {{ old('job_type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                        @error('job_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Company *</label>
                        <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}" placeholder="Company Name" required>
                        @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location *</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="Bangalore / Remote" required>
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Min Salary (₹/year)</label>
                        <input type="number" name="salary_min" class="form-control" value="{{ old('salary_min') }}" placeholder="500000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Max Salary (₹/year)</label>
                        <input type="number" name="salary_max" class="form-control" value="{{ old('salary_max') }}" placeholder="800000">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="8" placeholder="Describe the role, requirements, and responsibilities..." required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:12px 32px;border-radius:8px;width:100%;">
                    <i class="fas fa-briefcase" style="margin-right:8px;"></i> Post Job
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
