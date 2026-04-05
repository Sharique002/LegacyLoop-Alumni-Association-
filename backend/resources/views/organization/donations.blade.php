@extends('layouts.organization')

@section('title', 'Donation Campaigns')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Donation Campaigns</h1>
        <p class="page-subtitle">Create and manage fundraising campaigns for your institution</p>
    </div>
    <a href="{{ route('organization.donations.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        New Campaign
    </a>
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
                <div class="stat-value">₹{{ number_format($stats['total_raised'] ?? 0) }}</div>
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
                <div class="stat-value">{{ $stats['total_donors'] ?? 0 }}</div>
                <div class="stat-label">Total Donors</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(251, 191, 36, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fbbf24;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $stats['active_campaigns'] ?? 0 }}</div>
                <div class="stat-label">Active Campaigns</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139, 92, 246, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #8b5cf6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₹{{ number_format($stats['avg_donation'] ?? 0) }}</div>
                <div class="stat-label">Avg. Donation</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">All Campaigns</h5>
    </div>
    <div class="card-body p-0">
        @if(isset($campaigns) && $campaigns->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Campaign</th>
                        <th>Goal</th>
                        <th>Raised</th>
                        <th>Progress</th>
                        <th>Donors</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaigns as $campaign)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $campaign->title }}</div>
                            <small class="text-muted">{{ $campaign->end_date ? 'Ends ' . $campaign->end_date->format('M d, Y') : 'Ongoing' }}</small>
                        </td>
                        <td>₹{{ number_format($campaign->goal_amount) }}</td>
                        <td>₹{{ number_format($campaign->raised_amount ?? 0) }}</td>
                        <td>
                            <div class="progress" style="width: 100px; height: 8px; background: rgba(79, 70, 229, 0.2);">
                                @php $progress = $campaign->goal_amount > 0 ? min(100, ($campaign->raised_amount / $campaign->goal_amount) * 100) : 0; @endphp
                                <div class="progress-bar" style="width: {{ $progress }}%; background: linear-gradient(90deg, #4f46e5, #6366f1);"></div>
                            </div>
                            <small class="text-muted">{{ round($progress) }}%</small>
                        </td>
                        <td>{{ $campaign->donors_count ?? 0 }}</td>
                        <td>
                            @if($campaign->status == 'active')
                            <span class="badge badge-success">Active</span>
                            @elseif($campaign->status == 'completed')
                            <span class="badge badge-info">Completed</span>
                            @else
                            <span class="badge badge-warning">{{ ucfirst($campaign->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('organization.donations.edit', $campaign->id) }}" class="btn btn-sm btn-outline">Edit</a>
                            <a href="{{ route('organization.donations.show', $campaign->id) }}" class="btn btn-sm btn-outline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-3" style="opacity: 0.5; color: #22c55e;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h5 style="color: #f5f5dc; font-weight: 600; margin-bottom: 8px;">No donation campaigns yet</h5>
            <p style="color: #a5b4fc; margin-bottom: 20px;">Create your first fundraising campaign</p>
            <a href="{{ route('organization.donations.create') }}" class="btn btn-primary">Create Campaign</a>
        </div>
        @endif
    </div>
</div>
@endsection
