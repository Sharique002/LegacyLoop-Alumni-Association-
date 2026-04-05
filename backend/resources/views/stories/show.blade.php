@extends('layouts.app')

@section('title', $story->title . ' - LegacyLoop')

@section('content')
<div style="max-width:800px;">
    <a href="{{ route('stories.index') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Stories
    </a>

    <div class="card">
        <div class="card-body" style="padding:36px;">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
                <div class="avatar" style="width:60px;height:60px;font-size:24px;">{{ $story->user->getInitials() }}</div>
                <div>
                    <h3 class="serif" style="color:var(--cream);margin:0 0 4px;font-size:26px;">{{ $story->title }}</h3>
                    <span style="color:var(--gold);font-size:14px;">{{ $story->user->first_name }} {{ $story->user->last_name }}</span>
                    <span style="color:var(--gray);font-size:13px;"> · Class of {{ $story->user->graduation_year }} · {{ $story->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <hr style="border-color:rgba(212,175,55,0.15);margin-bottom:24px;">

            <div style="color:var(--gray);font-size:15px;line-height:1.9;white-space:pre-wrap;">{{ $story->content }}</div>

            <hr style="border-color:rgba(212,175,55,0.15);margin-top:28px;margin-bottom:20px;">

            <div style="display:flex;align-items:center;gap:16px;">
                <form action="{{ route('stories.destroy', $story->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this story?')">
                    @csrf @method('DELETE')
                    @if(auth()->id() === $story->user_id)
                    <button type="submit" class="btn btn-outline" style="padding:8px 16px;font-size:13px;border-color:var(--danger);color:var(--danger);">
                        <i class="fas fa-trash" style="margin-right:6px;"></i> Delete
                    </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
