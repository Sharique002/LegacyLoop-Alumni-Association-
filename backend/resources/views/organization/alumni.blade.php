@extends('layouts.organization')

@section('title', 'Alumni Directory')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Alumni Directory</h1>
        <p class="page-subtitle">{{ $alumni->total() }} alumni registered from your institution</p>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('organization.alumni') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}" style="background: rgba(255,255,255,0.05); border-color: rgba(79,70,229,0.3); color: var(--cream);">
            </div>
            <div class="col-md-2">
                <select name="graduation_year" class="form-select" style="background: rgba(255,255,255,0.05); border-color: rgba(79,70,229,0.3); color: var(--cream);">
                    <option value="">All Years</option>
                    @foreach($graduationYears as $year)
                    <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="branch" class="form-select" style="background: rgba(255,255,255,0.05); border-color: rgba(79,70,229,0.3); color: var(--cream);">
                    <option value="">All Branches</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch }}" {{ request('branch') == $branch ? 'selected' : '' }}>{{ $branch }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('organization.alumni') }}" class="btn btn-outline w-100">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Alumni Table -->
<div class="card">
    <div class="card-body p-0">
        @if($alumni->count() > 0)
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Alumni</th>
                    <th>Graduation</th>
                    <th>Branch/Degree</th>
                    <th>Current Role</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumni as $alum)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                @if($alum->avatar)
                                <img src="{{ $alum->avatar }}" alt="" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                @else
                                {{ strtoupper(substr($alum->first_name, 0, 1) . substr($alum->last_name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $alum->first_name }} {{ $alum->last_name }}</div>
                                <div style="font-size: 12px; color: var(--gray);">{{ $alum->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $alum->graduation_year }}</td>
                    <td>
                        <div>{{ $alum->branch }}</div>
                        <div style="font-size: 12px; color: var(--gray);">{{ $alum->degree }}</div>
                    </td>
                    <td>
                        @if($alum->job_title || $alum->current_company)
                        <div>{{ $alum->job_title ?? 'N/A' }}</div>
                        <div style="font-size: 12px; color: var(--gray);">{{ $alum->current_company ?? '' }}</div>
                        @else
                        <span style="color: var(--gray);">Not specified</span>
                        @endif
                    </td>
                    <td>
                        @if($alum->city || $alum->country)
                        {{ $alum->city }}{{ $alum->city && $alum->country ? ', ' : '' }}{{ $alum->country }}
                        @else
                        <span style="color: var(--gray);">Not specified</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $alum->is_active ? 'badge-success' : 'badge-warning' }}">
                            {{ $alum->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center p-3" style="border-top: 1px solid rgba(79,70,229,0.15);">
            <div style="color: var(--gray); font-size: 14px;">
                Showing {{ $alumni->firstItem() ?? 0 }} to {{ $alumni->lastItem() ?? 0 }} of {{ $alumni->total() }} alumni
            </div>
            <div>
                {{ $alumni->links() }}
            </div>
        </div>
        @else
        <div class="text-center py-5" style="color: var(--gray);">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 16px; opacity: 0.5;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <h4>No Alumni Found</h4>
            <p>No alumni have registered with your institution yet, or no results match your filters.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.08) !important;
        border-color: var(--university-accent) !important;
        color: var(--cream) !important;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }
    .form-select option {
        background: var(--primary);
        color: var(--cream);
    }
    .pagination {
        margin: 0;
    }
    .page-link {
        background: rgba(79,70,229,0.1);
        border-color: rgba(79,70,229,0.2);
        color: var(--cream);
    }
    .page-link:hover {
        background: rgba(79,70,229,0.2);
        border-color: var(--university-accent);
        color: var(--cream);
    }
    .page-item.active .page-link {
        background: var(--university-accent);
        border-color: var(--university-accent);
    }
    .page-item.disabled .page-link {
        background: rgba(79,70,229,0.05);
        color: var(--gray);
    }
</style>
@endsection
