@extends('minimal.layout')

@section('title', 'LegacyLoop Minimal Frontend')

@section('content')
<div class="card">
    <h1>LegacyLoop Minimal Frontend</h1>
    <p>This is a lightweight Blade frontend that keeps your current Laravel structure and tech stack unchanged.</p>
    <p>Use this URL as a simple frontend entry point: <code>/minimal</code></p>
</div>

<div class="card">
    <h2>Quick Links</h2>
    <p><a href="{{ route('login') }}" style="color:#4ade80;">Login</a> and <a href="{{ route('register') }}" style="color:#4ade80;">Register</a> are still powered by your existing app routes.</p>
</div>
@endsection
