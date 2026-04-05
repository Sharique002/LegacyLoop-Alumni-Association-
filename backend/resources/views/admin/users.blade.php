@extends('layouts.app')

@section('title', 'Manage Users - LegacyLoop Admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h2 class="serif" style="color:var(--cream);margin:0;">Manage Users</h2>
    <a href="{{ route('admin.dashboard') }}" style="color:var(--gold);text-decoration:none;font-size:14px;"><i class="fas fa-arrow-left" style="margin-right:6px;"></i> Admin Dashboard</a>
</div>

<div class="card" style="margin-bottom:24px;"><div class="card-body">
    <form method="GET" action="{{ route('admin.users') }}" style="display:flex;gap:12px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="form-control" style="flex:1;">
        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,var(--gold),#c9a027);border:none;color:var(--dark);font-weight:600;padding:10px 20px;border-radius:8px;">Search</button>
    </form>
</div></div>

<div class="card"><div class="card-body" style="padding:0;">
    <table class="table" style="margin:0;">
        <thead><tr>
            <th>User</th><th>Email</th><th>Batch / Branch</th><th>Joined</th><th>Status</th><th>Action</th>
        </tr></thead>
        <tbody>
            @forelse($users as $u)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div class="avatar" style="width:34px;height:34px;font-size:13px;">{{ $u->getInitials() }}</div>
                        <span style="color:var(--cream);font-weight:600;">{{ $u->first_name }} {{ $u->last_name }}</span>
                    </div>
                </td>
                <td style="color:var(--gray);font-size:13px;">{{ $u->email }}</td>
                <td style="color:var(--gray);font-size:13px;">{{ $u->graduation_year }} · {{ $u->branch }}</td>
                <td style="color:var(--gray);font-size:13px;">{{ $u->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="badge {{ $u->is_active ? 'badge-success' : 'badge-danger' }}" style="padding:5px 10px;border-radius:6px;">{{ $u->is_active ? 'Active' : 'Inactive' }}</span>
                </td>
                <td>
                    <form action="{{ route('admin.users.status', $u->id) }}" method="POST" style="margin:0;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-outline" style="padding:5px 14px;font-size:12px;border-color:{{ $u->is_active ? 'var(--danger)' : 'var(--green)' }};color:{{ $u->is_active ? 'var(--danger)' : 'var(--green)' }};">
                            {{ $u->is_active ? 'Disable' : 'Enable' }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--gray);padding:32px;">No users found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $users->links() }}</div>
</div></div>
@endsection
