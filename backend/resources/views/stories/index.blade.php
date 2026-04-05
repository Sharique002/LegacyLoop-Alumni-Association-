@extends('layouts.app')

@section('title', 'Success Stories - LegacyLoop')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div>
        <h2 class="serif" style="color:var(--cream);margin:0 0 4px;">Success Stories</h2>
        <p style="color:var(--gray);font-size:14px;margin:0;">Inspiring journeys of our alumni community</p>
    </div>
    <a href="{{ route('stories.create') }}" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;text-decoration:none;">
        <i class="fas fa-pen" style="margin-right:6px;"></i> Share Your Story
    </a>
</div>

<div class="card" style="margin-bottom:24px;">
    <div class="card-body">
        <form method="GET" action="{{ route('stories.index') }}" style="display:flex;gap:12px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search stories..." class="form-control" style="flex:1;">
            <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;">Search</button>
        </form>
    </div>
</div>

@if($stories->count() > 0)
<div style="display:flex;flex-direction:column;gap:20px;">
    @foreach($stories as $story)
    <div class="card" style="margin-bottom:0;">
        <div class="card-body" style="display:flex;gap:20px;align-items:flex-start;">
            <div class="avatar" style="width:56px;height:56px;font-size:22px;flex-shrink:0;">{{ $story->user->getInitials() }}</div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:8px;margin-bottom:8px;">
                    <div>
                        <h5 style="color:var(--cream);margin:0 0 4px;">
                            <a href="{{ route('stories.show', $story->id) }}" style="color:inherit;text-decoration:none;">{{ $story->title }}</a>
                        </h5>
                        <span style="color:var(--gold);font-size:13px;">{{ $story->user->first_name }} {{ $story->user->last_name }}</span>
                        <span style="color:var(--gray);font-size:12px;"> · Class of {{ $story->user->graduation_year }}</span>
                    </div>
                    <span style="font-size:12px;color:var(--gray);">{{ $story->created_at->diffForHumans() }}</span>
                </div>
                <p style="color:var(--gray);font-size:14px;line-height:1.7;margin-bottom:12px;">{{ Str::limit(strip_tags($story->content), 200) }}</p>
                <a href="{{ route('stories.show', $story->id) }}" style="color:var(--gold);text-decoration:none;font-size:13px;font-weight:600;">Read Full Story →</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div style="margin-top:24px;">{{ $stories->links() }}</div>
@else
<div class="card"><div class="card-body" style="text-align:center;padding:48px;">
    <i class="fas fa-book" style="font-size:48px;color:var(--gray);margin-bottom:16px;"></i>
    <p style="color:var(--gray);margin:0 0 16px;">No success stories yet.</p>
    <a href="{{ route('stories.create') }}" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-block;">Be the First!</a>
</div></div>
@endif
@endsection
