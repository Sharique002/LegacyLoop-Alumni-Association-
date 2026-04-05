@extends('layouts.app')

@section('title', 'My Connections - LegacyLoop')

@section('content')
<h2 class="serif" style="color:var(--cream);margin:0 0 24px;">My Connections</h2>

@if($connections->count() > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">
    @foreach($connections as $conn)
    @php $person = $conn->receiver; @endphp
    <div class="card" style="margin-bottom:0;">
        <div class="card-body" style="text-align:center;padding:24px;">
            <div class="avatar" style="width:60px;height:60px;font-size:24px;margin:0 auto 12px;">{{ $person->getInitials() }}</div>
            <h6 style="color:var(--cream);margin-bottom:4px;">{{ $person->first_name }} {{ $person->last_name }}</h6>
            <p style="color:var(--gray);font-size:12px;margin-bottom:12px;">{{ $person->branch }} · Class of {{ $person->graduation_year }}</p>
            @if($person->job_title)<p style="color:var(--gold);font-size:12px;margin-bottom:12px;">{{ $person->job_title }} @if($person->current_company) at {{ $person->current_company }}@endif</p>@endif
            <a href="{{ route('networking.conversation', $person->id) }}" class="btn btn-outline" style="display:block;text-align:center;text-decoration:none;padding:8px;font-size:13px;">
                <i class="fas fa-comments" style="margin-right:6px;"></i> Message
            </a>
        </div>
    </div>
    @endforeach
</div>
<div style="margin-top:24px;">{{ $connections->links() }}</div>
@else
<div class="card"><div class="card-body" style="text-align:center;padding:48px;">
    <i class="fas fa-users" style="font-size:48px;color:var(--gray);margin-bottom:16px;"></i>
    <p style="color:var(--gray);margin:0;">No connections yet. <a href="{{ route('alumni.index') }}" style="color:var(--gold);">Browse alumni</a> to connect.</p>
</div></div>
@endif
@endsection
