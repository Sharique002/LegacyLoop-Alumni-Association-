@extends('layouts.organization')

@section('title', 'Announcements')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Announcements</h1>
        <p class="page-subtitle">Create and manage announcements for your alumni</p>
    </div>
    <a href="{{ route('organization.announcements.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        New Announcement
    </a>
</div>

@if(!$organization->is_verified)
<div class="alert alert-warning mb-4">
    <strong>⚠️ Verification Required:</strong> Your institution must be verified before you can send announcements to alumni.
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Announcements</h5>
        <span class="badge badge-info">{{ $announcements->total() ?? 0 }} Total</span>
    </div>
    <div class="card-body p-0">
        @if(isset($announcements) && $announcements->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Target Audience</th>
                        <th>Status</th>
                        <th>Sent At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($announcements as $announcement)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $announcement->title }}</div>
                            <small class="text-muted">{{ Str::limit($announcement->content, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($announcement->target_audience ?? 'All') }}</span>
                        </td>
                        <td>
                            @if($announcement->is_published)
                            <span class="badge badge-success">Published</span>
                            @else
                            <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>{{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('organization.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-outline">Edit</a>
                            <form action="{{ route('organization.announcements.destroy', $announcement->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline" onclick="return confirm('Delete this announcement?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-3" style="opacity: 0.5; color: #a5b4fc;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <h5 style="color: #f5f5dc; font-weight: 600; margin-bottom: 8px;">No announcements yet</h5>
            <p style="color: #a5b4fc; margin-bottom: 20px;">Create your first announcement to reach your alumni</p>
            <a href="{{ route('organization.announcements.create') }}" class="btn btn-primary">Create Announcement</a>
        </div>
        @endif
    </div>
</div>

@if(isset($announcements) && $announcements->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $announcements->links() }}
</div>
@endif
@endsection
