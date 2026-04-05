@extends('layouts.app')

@section('title', $alumni->first_name . ' ' . $alumni->last_name . ' - LegacyLoop')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('alumni.index') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Directory
    </a>

    <div class="card">
        <div class="card-body" style="padding:32px;">
            <div style="display:flex;align-items:flex-start;gap:20px;margin-bottom:24px;">
                @if($alumni->avatar)
                    <img src="{{ asset('storage/' . $alumni->avatar) }}" alt="{{ $alumni->first_name }}" 
                         class="avatar" style="width:80px;height:80px;object-fit:cover;flex-shrink:0;">
                @else
                    <div class="avatar" style="width:80px;height:80px;font-size:32px;flex-shrink:0;">{{ $alumni->getInitials() }}</div>
                @endif
                <div style="flex:1;">
                    <h2 class="serif" style="color:var(--cream);margin:0 0 4px;font-size:26px;">{{ $alumni->first_name }} {{ $alumni->last_name }}</h2>
                    @if($alumni->job_title)<p style="color:var(--gold);font-size:15px;margin:0 0 2px;">{{ $alumni->job_title }}@if($alumni->current_company) at {{ $alumni->current_company }}@endif</p>@endif
                    <p style="color:var(--gray);font-size:13px;margin:0;">{{ $alumni->branch }} · Class of {{ $alumni->graduation_year }}</p>
                    @if($alumni->city || $alumni->country)
                    <p style="color:var(--gray);font-size:13px;margin:4px 0 0;"><i class="fas fa-map-marker-alt" style="margin-right:4px;color:var(--gold);"></i>{{ implode(', ', array_filter([$alumni->city, $alumni->country])) }}</p>
                    @endif
                </div>
                @if($alumni->id !== auth()->id())
                <form action="{{ route('connections.send') }}" method="POST" style="margin:0;">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $alumni->id }}">
                    <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;">
                        <i class="fas fa-user-plus" style="margin-right:6px;"></i> Connect
                    </button>
                </form>
                @endif
            </div>

            @if($alumni->bio)
            <div style="margin-bottom:24px;">
                <h6 style="color:var(--gold);margin-bottom:8px;font-size:13px;text-transform:uppercase;letter-spacing:0.06em;">About</h6>
                <p style="color:var(--gray);line-height:1.8;font-size:14px;">{{ $alumni->bio }}</p>
            </div>
            @endif

            @if($alumni->skills && count($alumni->skills) > 0)
            <div style="margin-bottom:20px;">
                <h6 style="color:var(--gold);margin-bottom:10px;font-size:13px;text-transform:uppercase;letter-spacing:0.06em;">Skills</h6>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    @foreach($alumni->skills as $skill)
                    <span style="padding:5px 12px;background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);border-radius:6px;font-size:12px;color:#10b981;">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($alumni->linkedin_url || $alumni->github_url || $alumni->twitter_url)
            <div style="display:flex;gap:16px;padding-top:20px;border-top:1px solid rgba(212,175,55,0.15);">
                @if($alumni->linkedin_url)<a href="{{ $alumni->linkedin_url }}" target="_blank" style="color:var(--blue);text-decoration:none;font-size:14px;display:flex;align-items:center;gap:6px;"><i class="fab fa-linkedin"></i> LinkedIn</a>@endif
                @if($alumni->github_url)<a href="{{ $alumni->github_url }}" target="_blank" style="color:var(--gray);text-decoration:none;font-size:14px;display:flex;align-items:center;gap:6px;"><i class="fab fa-github"></i> GitHub</a>@endif
                @if($alumni->twitter_url)<a href="{{ $alumni->twitter_url }}" target="_blank" style="color:#1da1f2;text-decoration:none;font-size:14px;display:flex;align-items:center;gap:6px;"><i class="fab fa-twitter"></i> Twitter</a>@endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
