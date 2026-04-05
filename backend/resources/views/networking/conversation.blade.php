@extends('layouts.app')

@section('title', 'Chat with ' . $user->first_name . ' - LegacyLoop')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('networking.messages') }}" style="color:var(--gold);text-decoration:none;font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Messages
    </a>

    <div class="card" style="margin-bottom:0;">
        <div class="card-header" style="padding:0;">
            <div style="display:flex;align-items:center;gap:12px;padding:16px 20px;">
                <div class="avatar" style="width:44px;height:44px;font-size:17px;">{{ $user->getInitials() }}</div>
                <div>
                    <div style="color:var(--cream);font-weight:600;">{{ $user->first_name }} {{ $user->last_name }}</div>
                    <div style="color:var(--gray);font-size:12px;">{{ $user->branch }} · Class of {{ $user->graduation_year }}</div>
                </div>
            </div>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:12px;min-height:380px;max-height:480px;overflow-y:auto;padding:20px;" id="chat-body">
            @forelse($messages as $msg)
            @php $mine = $msg->sender_id === auth()->id(); @endphp
            <div style="display:flex;justify-content:{{ $mine ? 'flex-end' : 'flex-start' }};">
                <div style="max-width:72%;padding:12px 16px;border-radius:{{ $mine ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }};background:{{ $mine ? 'linear-gradient(135deg,var(--gold),#c9a027)' : 'rgba(255,255,255,0.06)' }};color:{{ $mine ? 'var(--dark)' : 'var(--cream)' }};font-size:14px;line-height:1.6;">
                    {{ $msg->message }}
                    <div style="font-size:11px;opacity:0.6;margin-top:4px;text-align:right;">{{ $msg->created_at->format('h:i A') }}</div>
                </div>
            </div>
            @empty
            <p style="text-align:center;color:var(--gray);margin:auto;">No messages yet. Say hello! 👋</p>
            @endforelse
        </div>
        <div class="card-footer" style="padding:16px 20px;border-top:1px solid rgba(212,175,55,0.1);">
            <form method="POST" action="{{ route('networking.send-message', $user->id) }}" style="display:flex;gap:10px;">
                @csrf
                <input type="text" name="message" class="form-control" placeholder="Type a message..." style="flex:1;" required autocomplete="off">
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    const chatBody = document.getElementById('chat-body');
    if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
</script>
@endsection
