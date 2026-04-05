@extends('layouts.modern')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-8 animate-slide-up">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-2xl p-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10">
            <h1 class="text-2xl font-heading font-bold mb-2">Welcome back, {{ auth()->user()->name ?? 'Alumni' }}! 👋</h1>
            <p class="text-primary-100 mb-4">Your alumni network is thriving. Here's what's happening today.</p>
            <div class="flex flex-wrap gap-6 mt-6">
                <div class="bg-white/20 backdrop-blur rounded-xl px-5 py-3">
                    <p class="text-2xl font-bold">12</p>
                    <p class="text-sm text-primary-100">New connections</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-xl px-5 py-3">
                    <p class="text-2xl font-bold">5</p>
                    <p class="text-sm text-primary-100">Job matches</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-xl px-5 py-3">
                    <p class="text-2xl font-bold">3</p>
                    <p class="text-sm text-primary-100">Upcoming events</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Suggested Connections -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-card">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-heading font-semibold text-gray-900">Suggested Connections</h2>
                    <a href="{{ route('alumni.index') }}" class="text-sm font-medium text-primary-500 hover:text-primary-600 transition">View all</a>
                </div>
                <div class="p-6 grid sm:grid-cols-2 gap-4">
                    @php $suggestions = [
                        ['name' => 'Sarah Johnson', 'role' => 'Product Manager @ Google', 'year' => '2018', 'skills' => ['Product', 'UX']],
                        ['name' => 'Michael Chen', 'role' => 'Senior Developer @ Meta', 'year' => '2017', 'skills' => ['React', 'Node.js']],
                        ['name' => 'Emily Rodriguez', 'role' => 'Data Scientist @ Amazon', 'year' => '2019', 'skills' => ['Python', 'ML']],
                        ['name' => 'David Kim', 'role' => 'Founder @ TechStart', 'year' => '2015', 'skills' => ['Startup', 'Sales']],
                    ]; @endphp
                    @foreach($suggestions as $person)
                    <div class="flex items-start p-4 rounded-xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50/30 transition group">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm shrink-0">
                            {{ substr($person['name'], 0, 1) . substr(explode(' ', $person['name'])[1], 0, 1) }}
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $person['name'] }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $person['role'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Class of {{ $person['year'] }}</p>
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($person['skills'] as $skill)
                                <span class="px-2 py-0.5 text-xs font-medium bg-primary-100 text-primary-700 rounded-full">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                        <button class="ml-2 p-2 text-gray-400 hover:text-primary-500 opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="space-y-6">
            <!-- Profile Strength -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Profile Strength</h3>
                <div class="relative pt-1">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-primary-600">75% Complete</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Add your work experience to boost your profile visibility.</p>
                <a href="{{ route('profile.edit') }}" class="mt-3 inline-flex items-center text-sm font-medium text-primary-500 hover:text-primary-600 transition">
                    Complete Profile
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900">Upcoming Events</h3>
                    <a href="{{ route('events.index') }}" class="text-xs font-medium text-primary-500 hover:text-primary-600">View all</a>
                </div>
                @php $events = [
                    ['title' => 'Alumni Networking Mixer', 'date' => 'Apr 15', 'type' => 'In-Person'],
                    ['title' => 'Career Workshop', 'date' => 'Apr 20', 'type' => 'Virtual'],
                ]; @endphp
                <div class="space-y-3">
                    @foreach($events as $event)
                    <div class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition cursor-pointer">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 flex flex-col items-center justify-center text-primary-600">
                            <span class="text-xs font-medium">{{ explode(' ', $event['date'])[0] }}</span>
                            <span class="text-lg font-bold leading-none">{{ explode(' ', $event['date'])[1] }}</span>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $event['title'] }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $event['type'] === 'Virtual' ? 'bg-secondary-100 text-secondary-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $event['type'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Job Recommendations -->
    <div class="bg-white rounded-xl shadow-card">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-heading font-semibold text-gray-900">Job Recommendations</h2>
            <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-primary-500 hover:text-primary-600 transition">View all jobs</a>
        </div>
        <div class="p-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php $jobs = [
                ['title' => 'Senior Product Manager', 'company' => 'Google', 'location' => 'San Francisco, CA', 'match' => 95, 'type' => 'Full-time'],
                ['title' => 'Software Engineer', 'company' => 'Meta', 'location' => 'Remote', 'match' => 88, 'type' => 'Full-time'],
                ['title' => 'Data Analyst', 'company' => 'Amazon', 'location' => 'Seattle, WA', 'match' => 82, 'type' => 'Full-time'],
            ]; @endphp
            @foreach($jobs as $job)
            <div class="p-5 rounded-xl border border-gray-100 hover:border-primary-200 hover:shadow-soft transition group">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm">
                        {{ substr($job['company'], 0, 2) }}
                    </div>
                    <span class="px-2.5 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">{{ $job['match'] }}% Match</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-primary-600 transition">{{ $job['title'] }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $job['company'] }}</p>
                <div class="flex items-center text-xs text-gray-500 mb-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $job['location'] }}
                    <span class="mx-2">•</span>
                    {{ $job['type'] }}
                </div>
                <button class="w-full py-2.5 text-sm font-medium text-primary-600 bg-primary-50 rounded-xl hover:bg-primary-100 transition">
                    Apply Now
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-card">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-heading font-semibold text-gray-900">Recent Activity</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @php $activities = [
                    ['user' => 'Jane Doe', 'action' => 'started a new position', 'detail' => 'Senior Engineer at Netflix', 'time' => '2h ago'],
                    ['user' => 'John Smith', 'action' => 'posted a success story', 'detail' => 'From Intern to CEO: My Journey', 'time' => '5h ago'],
                    ['user' => 'Lisa Wong', 'action' => 'is looking for', 'detail' => 'Mentees in Data Science', 'time' => '1d ago'],
                ]; @endphp
                @foreach($activities as $activity)
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center text-white font-semibold text-sm shrink-0">
                        {{ substr($activity['user'], 0, 1) . substr(explode(' ', $activity['user'])[1], 0, 1) }}
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">{{ $activity['user'] }}</span>
                            {{ $activity['action'] }}
                        </p>
                        <p class="text-sm text-primary-600 font-medium">{{ $activity['detail'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}</style>
@endsection
