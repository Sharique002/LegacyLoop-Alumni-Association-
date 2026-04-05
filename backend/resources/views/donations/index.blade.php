@extends('layouts.app')

@section('title', 'Donate - LegacyLoop')

@section('content')
<h2 class="serif" style="color:var(--cream);margin:0 0 8px;">Give Back</h2>
<p style="color:var(--gray);font-size:14px;margin-bottom:24px;">Support scholarships and campus development</p>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;margin-bottom:28px;">
    <div class="stat-card">
        <i class="fas fa-rupee-sign" style="font-size:28px;color:var(--gold);"></i>
        <div class="stat-value">₹{{ number_format($stats['total_raised'], 0) }}</div>
        <div class="stat-label">Total Raised</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-users" style="font-size:28px;color:var(--blue);"></i>
        <div class="stat-value">{{ number_format($stats['total_donors']) }}</div>
        <div class="stat-label">Generous Donors</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    {{-- Make a Donation --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header"><div style="padding:14px 20px;"><h5 style="color:var(--cream);margin:0;"><i class="fas fa-heart" style="color:var(--danger);margin-right:8px;"></i>Make a Donation</h5></div></div>
        <div class="card-body">
            <form method="POST" action="{{ route('donations.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount (₹) *</label>
                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" min="100" placeholder="Minimum ₹100" required>
                    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div style="display:flex;gap:8px;margin-top:10px;">
                        @foreach([500, 1000, 5000, 10000] as $preset)
                        <button type="button" onclick="document.querySelector('[name=amount]').value={{ $preset }}" class="btn btn-outline" style="padding:5px 12px;font-size:12px;">₹{{ number_format($preset) }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message (optional)</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="Your dedication message...">{{ old('message') }}</textarea>
                </div>
                <div class="mb-4" style="display:flex;align-items:center;gap:10px;">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" style="width:20px;height:20px;cursor:pointer;">
                    <label for="is_anonymous" style="color:var(--gray);font-size:14px;cursor:pointer;margin:0;">Donate anonymously</label>
                </div>
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:12px;border-radius:8px;width:100%;">
                    <i class="fas fa-heart" style="margin-right:8px;"></i> Donate Now
                </button>
            </form>
        </div>
    </div>

    {{-- Recent Donations --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-header"><div style="padding:14px 20px;"><h5 style="color:var(--cream);margin:0;"><i class="fas fa-list" style="color:var(--green);margin-right:8px;"></i>Recent Donations</h5></div></div>
        <div class="card-body" style="padding:0;">
            @forelse($stats['latest_donations'] as $d)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 20px;border-bottom:1px solid rgba(212,175,55,0.08);">
                <div>
                    <div style="color:var(--cream);font-size:14px;font-weight:600;">
                        {{ $d->is_anonymous ? 'Anonymous Donor' : ($d->user?->first_name . ' ' . $d->user?->last_name) }}
                    </div>
                    <div style="color:var(--gray);font-size:12px;">{{ $d->created_at->diffForHumans() }}</div>
                    @if($d->message)<div style="color:var(--gray);font-size:12px;margin-top:2px;font-style:italic;">"{{ Str::limit($d->message, 60) }}"</div>@endif
                </div>
                <div style="color:var(--gold);font-weight:700;font-size:16px;">₹{{ number_format($d->amount) }}</div>
            </div>
            @empty
            <p style="text-align:center;color:var(--gray);padding:24px;">No donations yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
