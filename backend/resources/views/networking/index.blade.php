@extends('layouts.app')

@section('title', 'Networking Hub - LegacyLoop')

@section('content')
<h2 class="serif" style="color:var(--cream);margin:0 0 8px;">Networking Hub</h2>
<p style="color:var(--gray);font-size:14px;margin-bottom:28px;">Connect and collaborate with fellow alumni</p>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;margin-bottom:32px;">
    <a href="{{ route('networking.connections') }}" style="text-decoration:none;">
        <div class="card" style="margin-bottom:0;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
            <div class="card-body" style="text-align:center;padding:32px;">
                <i class="fas fa-users" style="font-size:40px;color:var(--blue);margin-bottom:16px;"></i>
                <h5 style="color:var(--cream);margin-bottom:8px;">My Connections</h5>
                <p style="color:var(--gray);font-size:13px;">View and manage your alumni connections</p>
            </div>
        </div>
    </a>
    <a href="{{ route('networking.messages') }}" style="text-decoration:none;">
        <div class="card" style="margin-bottom:0;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
            <div class="card-body" style="text-align:center;padding:32px;">
                <i class="fas fa-comments" style="font-size:40px;color:var(--green);margin-bottom:16px;"></i>
                <h5 style="color:var(--cream);margin-bottom:8px;">Messages</h5>
                <p style="color:var(--gray);font-size:13px;">Send and receive messages with alumni</p>
            </div>
        </div>
    </a>
    <a href="{{ route('alumni.index') }}" style="text-decoration:none;">
        <div class="card" style="margin-bottom:0;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
            <div class="card-body" style="text-align:center;padding:32px;">
                <i class="fas fa-search" style="font-size:40px;color:var(--gold);margin-bottom:16px;"></i>
                <h5 style="color:var(--cream);margin-bottom:8px;">Find Alumni</h5>
                <p style="color:var(--gray);font-size:13px;">Browse the directory and send connection requests</p>
            </div>
        </div>
    </a>
</div>

{{-- Pending Requests --}}
@php
$pending = auth()->user()->receivedConnections()->where('status','pending')->with('sender')->get();
@endphp
@if($pending->count() > 0)
<div class="card">
    <div class="card-header"><div style="padding:12px 20px;"><h5 style="color:var(--cream);margin:0;"><i class="fas fa-user-clock" style="color:var(--warning);margin-right:8px;"></i>Pending Requests ({{ $pending->count() }})</h5></div></div>
    <div class="card-body">
        @foreach($pending as $connection)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(212,175,55,0.08);">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="avatar" style="width:40px;height:40px;font-size:16px;">{{ $connection->sender->getInitials() }}</div>
                <div>
                    <div style="color:var(--cream);font-weight:600;font-size:14px;">{{ $connection->sender->first_name }} {{ $connection->sender->last_name }}</div>
                    <div style="color:var(--gray);font-size:12px;">{{ $connection->sender->branch }} · {{ $connection->sender->graduation_year }}</div>
                </div>
            </div>
            <div style="display:flex;gap:8px;">
                <form action="{{ route('networking.accept', $connection->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:6px 16px;border-radius:6px;font-size:13px;">Accept</button>
                </form>
                <form action="{{ route('networking.reject', $connection->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding:6px 16px;font-size:13px;">Reject</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
