@extends('layouts.organization')

@section('title', 'Alumni Messages')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Alumni Messages</h1>
        <p class="page-subtitle">Send bulk messages and communicate with your alumni</p>
    </div>
    <a href="{{ route('organization.messages.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        New Message
    </a>
</div>

@if(!$organization->is_verified)
<div class="alert alert-warning mb-4">
    <strong>⚠️ Verification Required:</strong> Your institution must be verified before you can send messages to alumni.
</div>
@endif

<!-- Quick Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['total_sent'] ?? 0 }}</div>
                <div class="stat-label">Messages Sent</div>
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
                <div class="stat-value">{{ $stats['open_rate'] ?? 0 }}%</div>
                <div class="stat-label">Avg. Open Rate</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(251, 191, 36, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fbbf24;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['recipients'] ?? 0 }}</div>
                <div class="stat-label">Total Recipients</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Sent Messages</h5>
    </div>
    <div class="card-body p-0">
        @if(isset($messages) && $messages->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Recipients</th>
                        <th>Sent</th>
                        <th>Opens</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $message->subject }}</div>
                            <small class="text-muted">{{ Str::limit($message->content, 40) }}</small>
                        </td>
                        <td>{{ $message->recipients_count ?? 0 }}</td>
                        <td>{{ $message->sent_at ? $message->sent_at->format('M d, Y H:i') : '-' }}</td>
                        <td>
                            @php $openRate = $message->recipients_count > 0 ? round(($message->opens_count / $message->recipients_count) * 100) : 0; @endphp
                            {{ $message->opens_count ?? 0 }} ({{ $openRate }}%)
                        </td>
                        <td>
                            @if($message->status == 'sent')
                            <span class="badge badge-success">Sent</span>
                            @elseif($message->status == 'scheduled')
                            <span class="badge badge-info">Scheduled</span>
                            @else
                            <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('organization.messages.show', $message->id) }}" class="btn btn-sm btn-outline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-3" style="opacity: 0.5; color: #a5b4fc;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h5 style="color: #f5f5dc; font-weight: 600; margin-bottom: 8px;">No messages sent yet</h5>
            <p style="color: #a5b4fc; margin-bottom: 20px;">Start communicating with your alumni network</p>
            <a href="{{ route('organization.messages.create') }}" class="btn btn-primary">Compose Message</a>
        </div>
        @endif
    </div>
</div>
@endsection
