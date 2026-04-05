@extends('minimal.layout')

@section('title', 'System Status')

@section('content')
<div class="card">
    <h1>System Status</h1>
    <p class="ok">Application is running</p>
    <p class="meta">Server time: {{ now()->toDateTimeString() }}</p>
    <p class="meta">Environment: {{ config('app.env') }}</p>
</div>

<div class="card">
    <h2>API Health Endpoint</h2>
    <p>Backend health check is available at <code>/api/health</code>.</p>
</div>
@endsection
