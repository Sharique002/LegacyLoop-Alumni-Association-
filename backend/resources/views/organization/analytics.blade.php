@extends('layouts.organization')

@section('title', 'Analytics')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Analytics Dashboard</h1>
        <p class="page-subtitle">Detailed insights about your alumni network</p>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select bg-dark text-light border-secondary" style="width: auto;" id="timePeriod">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
            <option value="365">Last year</option>
        </select>
        <button class="btn btn-outline" onclick="exportToPDF()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </button>
    </div>
</div>

<!-- Key Metrics -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ number_format($analytics['total_alumni'] ?? 0) }}</div>
                <div class="stat-label">Total Alumni</div>
                <small class="text-success">+{{ $analytics['new_alumni_month'] ?? 0 }} this month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #22c55e;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₹{{ number_format($analytics['total_donations'] ?? 0) }}</div>
                <div class="stat-label">Total Donations</div>
                <small class="text-success">{{ $analytics['donation_growth'] ?? 0 }}% growth</small>
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
                <div class="stat-value">{{ $analytics['total_events'] ?? 0 }}</div>
                <div class="stat-label">Events Hosted</div>
                <small class="text-muted">{{ $analytics['upcoming_events'] ?? 0 }} upcoming</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139, 92, 246, 0.2);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #8b5cf6;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $analytics['engagement_rate'] ?? 0 }}%</div>
                <div class="stat-label">Engagement Rate</div>
                <small class="text-success">+{{ $analytics['engagement_change'] ?? 0 }}% vs last month</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Alumni Growth Chart -->
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Alumni Growth</h5>
            </div>
            <div class="card-body">
                <canvas id="alumniGrowthChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Alumni by Graduation Year -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">By Graduation Year</h5>
            </div>
            <div class="card-body">
                <canvas id="graduationYearChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Top Industries -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Industries</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="background: transparent;">
                    @foreach($analytics['top_industries'] ?? [] as $industry)
                    <div class="list-group-item d-flex justify-content-between align-items-center" style="background: transparent; border-color: rgba(79, 70, 229, 0.1); color: var(--cream);">
                        {{ $industry['name'] }}
                        <span class="badge badge-info">{{ $industry['count'] }}</span>
                    </div>
                    @endforeach
                    @if(empty($analytics['top_industries']))
                    <div class="text-center py-4 text-muted">No data available</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Companies -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Companies</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="background: transparent;">
                    @foreach($analytics['top_companies'] ?? [] as $company)
                    <div class="list-group-item d-flex justify-content-between align-items-center" style="background: transparent; border-color: rgba(79, 70, 229, 0.1); color: var(--cream);">
                        {{ $company['name'] }}
                        <span class="badge badge-info">{{ $company['count'] }}</span>
                    </div>
                    @endforeach
                    @if(empty($analytics['top_companies']))
                    <div class="text-center py-4 text-muted">No data available</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Locations -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Alumni Locations</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="background: transparent;">
                    @foreach($analytics['top_locations'] ?? [] as $location)
                    <div class="list-group-item d-flex justify-content-between align-items-center" style="background: transparent; border-color: rgba(79, 70, 229, 0.1); color: var(--cream);">
                        {{ $location['name'] }}
                        <span class="badge badge-info">{{ $location['count'] }}</span>
                    </div>
                    @endforeach
                    @if(empty($analytics['top_locations']))
                    <div class="text-center py-4 text-muted">No data available</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Analytics -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Event Attendance</h5>
            </div>
            <div class="card-body">
                <canvas id="eventAttendanceChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Donation Trends</h5>
            </div>
            <div class="card-body">
                <canvas id="donationTrendsChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Alumni Growth Chart
const alumniCtx = document.getElementById('alumniGrowthChart').getContext('2d');
new Chart(alumniCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($analytics['growth_labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'New Alumni',
            data: {!! json_encode($analytics['growth_data'] ?? [10, 25, 15, 30, 20, 35]) !!},
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(79, 70, 229, 0.1)' }, ticks: { color: '#a0a9b8' } },
            x: { grid: { display: false }, ticks: { color: '#a0a9b8' } }
        }
    }
});

// Graduation Year Chart
const gradCtx = document.getElementById('graduationYearChart').getContext('2d');
new Chart(gradCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($analytics['grad_labels'] ?? ['2020-2024', '2015-2019', '2010-2014', 'Before 2010']) !!},
        datasets: [{
            data: {!! json_encode($analytics['grad_data'] ?? [35, 30, 20, 15]) !!},
            backgroundColor: ['#4f46e5', '#22c55e', '#fbbf24', '#8b5cf6']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { color: '#a0a9b8' } } }
    }
});

// Event Attendance Chart
const eventCtx = document.getElementById('eventAttendanceChart').getContext('2d');
new Chart(eventCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($analytics['event_labels'] ?? ['Event 1', 'Event 2', 'Event 3', 'Event 4', 'Event 5']) !!},
        datasets: [{
            label: 'Attendees',
            data: {!! json_encode($analytics['event_data'] ?? [50, 75, 120, 90, 150]) !!},
            backgroundColor: 'rgba(79, 70, 229, 0.6)',
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(79, 70, 229, 0.1)' }, ticks: { color: '#a0a9b8' } },
            x: { grid: { display: false }, ticks: { color: '#a0a9b8' } }
        }
    }
});

// Donation Trends Chart
const donationCtx = document.getElementById('donationTrendsChart').getContext('2d');
new Chart(donationCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($analytics['donation_labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'Donations (₹)',
            data: {!! json_encode($analytics['donation_data'] ?? [5000, 8000, 12000, 7000, 15000, 20000]) !!},
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(79, 70, 229, 0.1)' }, ticks: { color: '#a0a9b8' } },
            x: { grid: { display: false }, ticks: { color: '#a0a9b8' } }
        }
    }
});
// Export to PDF function
function exportToPDF() {
    // Open the export route in a new window which will show the print-friendly version
    const exportWindow = window.open('{{ route("organization.analytics.export") }}', '_blank');
    
    // Wait for the page to load, then trigger print
    if (exportWindow) {
        exportWindow.onload = function() {
            setTimeout(function() {
                exportWindow.print();
            }, 500);
        };
    }
}
</script>
@endsection
