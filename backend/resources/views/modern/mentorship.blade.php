@extends('layouts.modern')
@section('title', 'Mentorship')

@section('content')
<div class="animate-slide-up">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-heading font-bold text-gray-900">Mentorship</h1>
            <p class="text-gray-600 mt-1">Connect with experienced alumni mentors or become one yourself</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-3">
            <button class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                Find a Mentor
            </button>
            <button class="px-5 py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition">
                Become a Mentor
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php $stats = [
            ['value' => '500+', 'label' => 'Active Mentors', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'primary'],
            ['value' => '2,500+', 'label' => 'Mentees Helped', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'secondary'],
            ['value' => '15+', 'label' => 'Industries', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => 'yellow'],
            ['value' => '4.9', 'label' => 'Average Rating', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'color' => 'green'],
        ]; @endphp
        @foreach($stats as $stat)
        <div class="bg-white rounded-xl shadow-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                    <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-{{ $stat['color'] }}-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filter -->
    <div class="flex flex-wrap items-center gap-3 mb-8">
        <span class="text-sm font-medium text-gray-700">Expertise:</span>
        @foreach(['All', 'Engineering', 'Product', 'Design', 'Marketing', 'Finance', 'Leadership'] as $filter)
        <button class="px-4 py-2 text-sm font-medium rounded-full transition {{ $filter === 'All' ? 'bg-primary-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-primary-300 hover:text-primary-600' }}">
            {{ $filter }}
        </button>
        @endforeach
    </div>

    <!-- Mentors Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php $mentors = [
            ['name' => 'Sarah Johnson', 'role' => 'VP of Product', 'company' => 'Google', 'expertise' => ['Product Strategy', 'Leadership', 'Career Growth'], 'sessions' => 120, 'rating' => 4.9, 'available' => true],
            ['name' => 'Michael Chen', 'role' => 'Staff Engineer', 'company' => 'Meta', 'expertise' => ['System Design', 'Interviews', 'Career Switch'], 'sessions' => 85, 'rating' => 4.8, 'available' => true],
            ['name' => 'Emily Rodriguez', 'role' => 'Head of Data Science', 'company' => 'Amazon', 'expertise' => ['Data Science', 'ML/AI', 'Research'], 'sessions' => 64, 'rating' => 5.0, 'available' => false],
            ['name' => 'David Kim', 'role' => 'Founder & CEO', 'company' => 'TechStart', 'expertise' => ['Entrepreneurship', 'Fundraising', 'Startups'], 'sessions' => 95, 'rating' => 4.9, 'available' => true],
            ['name' => 'Lisa Wong', 'role' => 'Design Director', 'company' => 'Airbnb', 'expertise' => ['UX Design', 'Portfolio', 'Design Leadership'], 'sessions' => 72, 'rating' => 4.7, 'available' => true],
            ['name' => 'James Miller', 'role' => 'CMO', 'company' => 'Spotify', 'expertise' => ['Marketing', 'Growth', 'Brand Strategy'], 'sessions' => 58, 'rating' => 4.8, 'available' => false],
        ]; @endphp
        @foreach($mentors as $mentor)
        <div class="bg-white rounded-xl shadow-card p-6 hover:shadow-soft transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xl font-bold">
                            {{ substr($mentor['name'], 0, 1) . substr(explode(' ', $mentor['name'])[1], 0, 1) }}
                        </div>
                        @if($mentor['available'])
                        <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition">{{ $mentor['name'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $mentor['role'] }}</p>
                        <p class="text-sm text-primary-600 font-medium">{{ $mentor['company'] }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach($mentor['expertise'] as $skill)
                <span class="px-2.5 py-1 text-xs font-medium bg-primary-50 text-primary-700 rounded-full">{{ $skill }}</span>
                @endforeach
            </div>

            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{ $mentor['rating'] }}
                </div>
                <span>{{ $mentor['sessions'] }} sessions</span>
            </div>

            @if($mentor['available'])
            <button class="w-full py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition">
                Request Mentorship
            </button>
            @else
            <button class="w-full py-2.5 text-sm font-medium text-gray-500 bg-gray-100 rounded-xl cursor-not-allowed">
                Currently Unavailable
            </button>
            @endif
        </div>
        @endforeach
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 rounded-2xl p-8 mt-12 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h2 class="text-2xl font-heading font-bold mb-2">Ready to give back?</h2>
                <p class="text-secondary-100">Share your experience and help shape the next generation of leaders.</p>
            </div>
            <button class="px-8 py-3 text-base font-medium text-secondary-600 bg-white rounded-xl hover:bg-gray-100 transition shadow-lg">
                Apply to be a Mentor
            </button>
        </div>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}</style>
@endsection
