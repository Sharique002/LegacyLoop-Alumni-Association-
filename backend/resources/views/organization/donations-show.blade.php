@extends('layouts.organization')

@section('title', 'Campaign Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $campaign->title }}</h1>
        <p class="page-subtitle">Campaign details and donations</p>
    </div>
    <a href="{{ route('organization.donations') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Campaigns
    </a>
</div>

<!-- Campaign Progress -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="mb-3">Fundraising Progress</h5>
                <div class="progress mb-3" style="height: 20px; background: rgba(79, 70, 229, 0.2); border-radius: 10px;">
                    @php $progress = $campaign->goal_amount > 0 ? min(100, ($campaign->raised_amount / $campaign->goal_amount) * 100) : 0; @endphp
                    <div class="progress-bar" style="width: {{ $progress }}%; background: linear-gradient(90deg, #4f46e5, #6366f1); border-radius: 10px; transition: width 1s ease;"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Raised: <strong style="color: var(--gold);">₹{{ number_format($campaign->raised_amount) }}</strong></span>
                    <span class="text-muted">Goal: <strong>₹{{ number_format($campaign->goal_amount) }}</strong></span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="stat-value" style="font-size: 48px; color: var(--gold);">{{ round($progress) }}%</div>
                <div class="stat-label">Complete</div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #22c55e;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₹{{ number_format($campaign->raised_amount) }}</div>
                <div class="stat-label">Total Raised</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $campaign->donors_count }}</div>
                <div class="stat-label">Total Donors</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(251, 191, 36, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fbbf24;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $campaign->end_date ? $campaign->end_date->diffInDays(now()) : '∞' }}</div>
                <div class="stat-label">Days Remaining</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139, 92, 246, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #8b5cf6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₹{{ $campaign->donors_count > 0 ? number_format($campaign->raised_amount / $campaign->donors_count) : 0 }}</div>
                <div class="stat-label">Avg. Donation</div>
            </div>
        </div>
    </div>
</div>

<!-- Campaign Description -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Campaign Description</h5>
    </div>
    <div class="card-body">
        <p style="color: var(--cream); line-height: 1.8;">{{ $campaign->description }}</p>
        <div class="mt-3">
            <span class="badge badge-info me-2">{{ ucfirst($campaign->category) }}</span>
            @if($campaign->status == 'active')
            <span class="badge badge-success">Active</span>
            @elseif($campaign->status == 'completed')
            <span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #22c55e;">Completed</span>
            @else
            <span class="badge badge-warning">{{ ucfirst($campaign->status) }}</span>
            @endif
        </div>
    </div>
</div>

<!-- Recent Donations -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Donations</h5>
        <span class="badge badge-info">{{ $donations->total() }} Total</span>
    </div>
    <div class="card-body p-0">
        @if($donations->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">{{ strtoupper(substr($donation->is_anonymous ? 'A' : ($donation->donor_name ?? 'D'), 0, 2)) }}</div>
                                <div>
                                    <div class="fw-semibold">{{ $donation->is_anonymous ? 'Anonymous Donor' : $donation->donor_name }}</div>
                                    <small class="text-muted">{{ $donation->donor_email }}</small>
                                </div>
                            </div>
                        </td>
                        <td><strong style="color: var(--gold);">₹{{ number_format($donation->amount) }}</strong></td>
                        <td>{{ $donation->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @if($donation->payment_status == 'completed')
                            <span class="badge badge-success">Completed</span>
                            @elseif($donation->payment_status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                            @else
                            <span class="badge badge-info">{{ ucfirst($donation->payment_status) }}</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($donation->message, 30) ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-muted mb-3" style="opacity: 0.3">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h5 class="text-muted">No donations yet</h5>
            <p class="text-muted">Share this campaign to start receiving donations</p>
        </div>
        @endif
    </div>
</div>

@if($donations->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $donations->links() }}
</div>
@endif
@endsection
