@extends('layouts.organization')

@section('title', 'Message Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Message Details</h1>
        <p class="page-subtitle">View sent message and statistics</p>
    </div>
    <a href="{{ route('organization.messages') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Messages
    </a>
</div>

<!-- Message Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $message->recipients_count }}</div>
                <div class="stat-label">Recipients</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #22c55e;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $message->opens_count }}</div>
                <div class="stat-label">Opens</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(251, 191, 36, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fbbf24;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $message->recipients_count > 0 ? round(($message->opens_count / $message->recipients_count) * 100, 1) : 0 }}%</div>
                <div class="stat-label">Open Rate</div>
            </div>
        </div>
    </div>
</div>

<!-- Message Content -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-1">{{ $message->subject }}</h5>
                <small class="text-muted">
                    Sent {{ $message->sent_at ? $message->sent_at->format('M d, Y \a\t H:i') : 'Not sent yet' }}
                    • Target: {{ ucfirst($message->target_audience) }}
                    @if($message->target_value) ({{ $message->target_value }}) @endif
                </small>
            </div>
            @if($message->status == 'sent')
            <span class="badge badge-success">Sent</span>
            @elseif($message->status == 'scheduled')
            <span class="badge badge-info">Scheduled</span>
            @else
            <span class="badge badge-warning">Draft</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="message-content" style="background: rgba(26, 31, 58, 0.5); padding: 24px; border-radius: 10px; border: 1px solid rgba(79, 70, 229, 0.2);">
            <div style="color: var(--cream); line-height: 1.8; white-space: pre-wrap;">{{ $message->content }}</div>
        </div>
    </div>
</div>

<style>
.message-content {
    font-size: 15px;
}
</style>
@endsection
