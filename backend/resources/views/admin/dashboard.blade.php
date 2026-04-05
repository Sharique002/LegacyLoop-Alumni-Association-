@extends('layouts.app')

@section('title', 'Admin Dashboard - LegacyLoop')

@section('content')
<h2 class="serif" style="color:var(--cream);margin:0 0 8px;">Admin Dashboard</h2>
<p style="color:var(--gray);font-size:14px;margin-bottom:24px;">Platform management overview</p>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;margin-bottom:28px;">
    <div class="stat-card"><i class="fas fa-users" style="font-size:28px;color:var(--blue);"></i><div class="stat-value">{{ number_format($stats['total_users']) }}</div><div class="stat-label">Total Users</div></div>
    <div class="stat-card"><i class="fas fa-briefcase" style="font-size:28px;color:var(--green);"></i><div class="stat-value">{{ number_format($stats['total_jobs']) }}</div><div class="stat-label">Total Jobs</div></div>
    <div class="stat-card"><i class="fas fa-calendar" style="font-size:28px;color:var(--warning);"></i><div class="stat-value">{{ number_format($stats['total_events']) }}</div><div class="stat-label">Total Events</div></div>
    <div class="stat-card"><i class="fas fa-clock" style="font-size:28px;color:var(--danger);"></i><div class="stat-value">{{ number_format($stats['pending_stories']) }}</div><div class="stat-label">Pending Stories</div></div>
    <div class="stat-card"><i class="fas fa-rupee-sign" style="font-size:28px;color:var(--gold);"></i><div class="stat-value">₹{{ number_format($stats['total_donations'], 0) }}</div><div class="stat-label">Donations</div></div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    {{-- Recent Users --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header"><div style="display:flex;justify-content:space-between;align-items:center;padding:14px 20px;">
            <h5 style="color:var(--cream);margin:0;"><i class="fas fa-user-plus" style="color:var(--blue);margin-right:8px;"></i>Recent Users</h5>
            <a href="{{ route('admin.users') }}" style="color:var(--gold);font-size:13px;text-decoration:none;">View All →</a>
        </div></div>
        <div class="card-body" style="padding:0;">
            @foreach($recent_users as $u)
            <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid rgba(212,175,55,0.08);">
                <div class="avatar" style="width:36px;height:36px;font-size:14px;">{{ $u->getInitials() }}</div>
                <div style="flex:1;">
                    <div style="color:var(--cream);font-size:13px;font-weight:600;">{{ $u->first_name }} {{ $u->last_name }}</div>
                    <div style="color:var(--gray);font-size:11px;">{{ $u->email }}</div>
                </div>
                <span class="badge {{ $u->is_active ? 'badge-success' : 'badge-danger' }}" style="padding:4px 8px;border-radius:6px;font-size:11px;">{{ $u->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Pending Stories --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header"><div style="padding:14px 20px;"><h5 style="color:var(--cream);margin:0;"><i class="fas fa-book" style="color:var(--warning);margin-right:8px;"></i>Pending Stories</h5></div></div>
        <div class="card-body" style="padding:0;">
            @forelse($pending_stories as $story)
            <div style="padding:14px 20px;border-bottom:1px solid rgba(212,175,55,0.08);">
                <div style="color:var(--cream);font-size:14px;font-weight:600;margin-bottom:4px;">{{ $story->title }}</div>
                <div style="color:var(--gray);font-size:12px;margin-bottom:10px;">by {{ $story->user->first_name }} {{ $story->user->last_name }}</div>
                <div style="display:flex;gap:8px;">
                    <form action="{{ route('admin.stories.approve', $story->id) }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--green),#0d9668);border:none;color:white;font-weight:600;padding:5px 14px;border-radius:6px;font-size:12px;">Approve</button>
                    </form>
                    <form action="{{ route('admin.stories.reject', $story->id) }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="padding:5px 14px;font-size:12px;border-color:var(--danger);color:var(--danger);">Reject</button>
                    </form>
                </div>
            </div>
            @empty
            <p style="text-align:center;color:var(--gray);padding:24px;margin:0;">No pending stories</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
