@extends('layouts.app')

@section('title', $job->title . ' - LegacyLoop')

@section('content')
<div style="max-width:800px;">
    <a href="{{ route('jobs.index') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Jobs
    </a>
    <div class="card">
        <div class="card-body" style="padding:32px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
                <div>
                    <h2 class="serif" style="color:var(--cream);margin:0 0 8px;font-size:26px;">{{ $job->title }}</h2>
                    <div style="display:flex;gap:16px;flex-wrap:wrap;">
                        <span style="color:var(--gold);font-size:14px;"><i class="fas fa-building" style="margin-right:6px;"></i>{{ $job->company }}</span>
                        <span style="color:var(--gray);font-size:14px;"><i class="fas fa-map-marker-alt" style="margin-right:6px;"></i>{{ $job->location }}</span>
                        <span style="color:var(--gray);font-size:14px;"><i class="fas fa-briefcase" style="margin-right:6px;"></i>{{ ucfirst($job->job_type) }}</span>
                        @if($job->salary_min || $job->salary_max)
                        <span style="color:var(--green);font-size:14px;"><i class="fas fa-rupee-sign" style="margin-right:4px;"></i>{{ $job->salary_min ? number_format($job->salary_min/100000,1).'L' : '' }}{{ ($job->salary_min && $job->salary_max) ? ' – ' : '' }}{{ $job->salary_max ? number_format($job->salary_max/100000,1).'L PA' : '' }}</span>
                        @endif
                    </div>
                </div>
                <span class="badge badge-success" style="padding:6px 14px;border-radius:8px;font-size:13px;">{{ ucfirst($job->status) }}</span>
            </div>
            <hr style="border-color:rgba(212,175,55,0.15);margin-bottom:24px;">
            <h5 style="color:var(--gold);margin-bottom:12px;">Job Description</h5>
            <div style="color:var(--gray);font-size:14px;line-height:1.9;white-space:pre-wrap;margin-bottom:28px;">{{ $job->description }}</div>

            <div class="card" style="margin-bottom:0;background:rgba(212,175,55,0.05);border-color:rgba(212,175,55,0.2);">
                <div class="card-body" style="padding:20px;">
                    <h5 style="color:var(--cream);margin-bottom:16px;">Apply Now</h5>
                    <form method="POST" action="{{ route('jobs.apply', $job->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Cover Letter *</label>
                            <textarea name="cover_letter" class="form-control @error('cover_letter') is-invalid @enderror" rows="5" placeholder="Explain why you're a great fit..." required>{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 28px;border-radius:8px;">
                            <i class="fas fa-paper-plane" style="margin-right:8px;"></i> Submit Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
