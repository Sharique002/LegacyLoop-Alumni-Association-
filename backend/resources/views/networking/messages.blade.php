@extends('layouts.app')

@section('title', 'Messages - LegacyLoop')

@section('content')
<h2 class="serif" style="color:var(--cream);margin:0 0 24px;">Messages</h2>

@php
$user = auth()->user();
$convUsers = \App\Models\Message::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)
    ->latest()->get()
    ->map(fn($m) => $m->sender_id == $user->id ? $m->receiver_id : $m->sender_id)
    ->unique()->values();
$partners = \App\Models\User::whereIn('id', $convUsers)->get()->keyBy('id');
@endphp

@if($convUsers->count() > 0)
<div class="card">
    <div class="card-body" style="padding:0;">
        @foreach($convUsers as $partnerId)
        @if(isset($partners[$partnerId]))
        @php $partner = $partners[$partnerId]; @endphp
        <a href="{{ route('networking.conversation', $partner->id) }}" style="text-decoration:none;">
            <div style="display:flex;align-items:center;gap:16px;padding:16px 20px;border-bottom:1px solid rgba(212,175,55,0.08);transition:background 0.2s;" onmouseover="this.style.background='rgba(212,175,55,0.05)'" onmouseout="this.style.background='transparent'">
                <div class="avatar" style="width:48px;height:48px;font-size:18px;flex-shrink:0;">{{ $partner->getInitials() }}</div>
                <div style="flex:1;">
                    <div style="color:var(--cream);font-weight:600;font-size:14px;">{{ $partner->first_name }} {{ $partner->last_name }}</div>
                    <div style="color:var(--gray);font-size:12px;">{{ $partner->branch }} · {{ $partner->graduation_year }}</div>
                </div>
                <i class="fas fa-chevron-right" style="color:var(--gray);font-size:12px;"></i>
            </div>
        </a>
        @endif
        @endforeach
    </div>
</div>
@else
<div class="card"><div class="card-body" style="text-align:center;padding:48px;">
    <i class="fas fa-comments" style="font-size:48px;color:var(--gray);margin-bottom:16px;"></i>
    <p style="color:var(--gray);margin:0;">No conversations yet. <a href="{{ route('alumni.index') }}" style="color:var(--gold);">Find alumni</a> and start a conversation.</p>
</div></div>
@endif
@endsection
