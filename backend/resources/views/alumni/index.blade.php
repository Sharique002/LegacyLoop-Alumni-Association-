@extends('layouts.app')

@section('title', 'Alumni Directory - LegacyLoop')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 style="color: var(--cream); margin: 0; font-family: 'DM Serif Display', serif; font-size: 32px;">
            <i class="fas fa-users" style="margin-right: 12px; color: var(--blue);"></i>
            Alumni Directory
        </h1>
    </div>

    <!-- Search & Filters -->
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('alumni.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
                <div>
                    <label class="form-label">Search by Name or Company</label>
                    <input type="text" name="search" class="form-control" placeholder="Enter name or company" value="{{ request('search') }}">
                </div>

                <div>
                    <label class="form-label">Branch</label>
                    <select name="branch" class="form-control">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch }}" @if(request('branch') == $branch) selected @endif>
                            {{ $branch }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Graduation Year</label>
                    <select name="graduation_year" class="form-control">
                        <option value="">All Years</option>
                        @foreach($years->sort()->reverse() as $year)
                        <option value="{{ $year }}" @if(request('graduation_year') == $year) selected @endif>
                            {{ $year }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alumni Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @forelse($alumni as $member)
        <div class="card" style="cursor: pointer; transition: all 0.3s ease; height: 100%;" onclick="window.location.href='{{ route('alumni.show', $member->id) }}';" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 16px;">
                    @if($member->avatar)
                        <img src="{{ asset('storage/' . $member->avatar) }}" alt="{{ $member->first_name }}" 
                             class="avatar" style="width: 80px; height: 80px; margin: 0 auto 12px; object-fit: cover;">
                    @else
                        <div class="avatar" style="width: 80px; height: 80px; margin: 0 auto 12px; font-size: 32px;">
                            {{ $member->getInitials() }}
                        </div>
                    @endif
                    <h5 style="color: var(--cream); margin-bottom: 4px;">
                        {{ $member->first_name }} {{ $member->last_name }}
                    </h5>
                    <p style="color: var(--gray); font-size: 13px; margin-bottom: 8px;">
                        {{ $member->branch }} • {{ $member->graduation_year }}
                    </p>
                </div>

                @if($member->job_title || $member->company)
                <div style="background: rgba(212, 175, 55, 0.05); border-radius: 8px; padding: 12px; margin-bottom: 16px; border-top: 2px solid var(--gold);">
                    @if($member->job_title)
                    <p style="font-size: 13px; color: var(--gold); margin: 0 0 4px; font-weight: 600;">
                        {{ $member->job_title }}
                    </p>
                    @endif
                    @if($member->company)
                    <p style="font-size: 12px; color: var(--gray); margin: 0;">
                        <i class="fas fa-building"></i> {{ $member->company }}
                    </p>
                    @endif
                </div>
                @endif

                @if($member->bio)
                <p style="font-size: 13px; color: var(--gray); margin-bottom: 16px; min-height: 40px;">
                    {{ Str::limit($member->bio, 60) }}
                </p>
                @endif

                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('alumni.show', $member->id) }}" class="btn btn-primary" style="flex: 1; text-align: center; text-decoration: none; padding: 8px;">
                        View Profile
                    </a>
                    @if(auth()->user()->id !== $member->id)
                    <form action="{{ route('connections.send') }}" method="POST" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $member->id }}">
                        <button type="submit" class="btn btn-outline" style="width: 100%; padding: 8px;">
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--gray);">
            <i class="fas fa-search" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <p>No alumni found matching your criteria</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($alumni->hasPages())
    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 24px;">
        {{ $alumni->links() }}
    </div>
    @endif
</div>
@endsection
