@extends('layouts.modern')
@section('title', 'Events')

@section('content')
<div class="animate-slide-up">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-heading font-bold text-gray-900">Events</h1>
            <p class="text-gray-600 mt-1">Connect with alumni at exclusive networking events</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-3">
            <select class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                <option>All Events</option>
                <option>Virtual</option>
                <option>In-Person</option>
            </select>
            <button class="px-5 py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Event
            </button>
        </div>
    </div>

    <!-- Featured Event -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="lg:max-w-xl">
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-white/20 rounded-full mb-4">Featured Event</span>
                <h2 class="text-2xl sm:text-3xl font-heading font-bold mb-3">Annual Alumni Reunion 2024</h2>
                <p class="text-primary-100 mb-4">Join us for our biggest event of the year! Network with 500+ alumni, enjoy keynote speakers, and celebrate our community.</p>
                <div class="flex flex-wrap items-center gap-4 text-sm text-white/80 mb-6">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        May 15, 2024
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        6:00 PM - 10:00 PM
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Grand Ballroom, Downtown
                    </span>
                </div>
            </div>
            <div class="lg:text-right">
                <p class="text-sm text-primary-100 mb-2">250 / 500 spots remaining</p>
                <button class="px-8 py-3 text-base font-medium text-primary-600 bg-white rounded-xl hover:bg-gray-100 transition shadow-lg">
                    Register Now
                </button>
            </div>
        </div>
    </div>

    <!-- Event Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php $events = [
            ['title' => 'Tech Industry Panel', 'date' => 'Apr 20, 2024', 'time' => '2:00 PM', 'type' => 'Virtual', 'attendees' => 85, 'image' => null, 'description' => 'Industry leaders discuss trends in AI, cloud computing, and career growth.'],
            ['title' => 'Startup Pitch Night', 'date' => 'Apr 25, 2024', 'time' => '6:00 PM', 'type' => 'In-Person', 'attendees' => 120, 'image' => null, 'description' => 'Watch alumni founders pitch their startups to VCs and angel investors.'],
            ['title' => 'Career Mentorship Workshop', 'date' => 'May 1, 2024', 'time' => '10:00 AM', 'type' => 'Virtual', 'attendees' => 45, 'image' => null, 'description' => 'One-on-one sessions with senior alumni in your field of interest.'],
            ['title' => 'Alumni Golf Tournament', 'date' => 'May 8, 2024', 'time' => '8:00 AM', 'type' => 'In-Person', 'attendees' => 64, 'image' => null, 'description' => 'Annual charity golf tournament at Pine Valley Country Club.'],
            ['title' => 'Women in Tech Networking', 'date' => 'May 12, 2024', 'time' => '5:30 PM', 'type' => 'In-Person', 'attendees' => 90, 'image' => null, 'description' => 'Connect with successful women in technology and leadership.'],
            ['title' => 'Resume Review Session', 'date' => 'May 18, 2024', 'time' => '1:00 PM', 'type' => 'Virtual', 'attendees' => 30, 'image' => null, 'description' => 'Get your resume reviewed by HR professionals from top companies.'],
        ]; @endphp
        @foreach($events as $event)
        <div class="bg-white rounded-xl shadow-card overflow-hidden hover:shadow-soft transition group">
            <div class="h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $event['type'] === 'Virtual' ? 'bg-secondary-100 text-secondary-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $event['type'] }}</span>
                    <span class="text-xs text-gray-400">{{ $event['attendees'] }} attending</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-primary-600 transition">{{ $event['title'] }}</h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $event['description'] }}</p>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $event['date'] }} at {{ $event['time'] }}
                </div>
                <button class="w-full py-2.5 text-sm font-medium text-primary-600 bg-primary-50 rounded-xl hover:bg-primary-100 transition">
                    Register
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Load More -->
    <div class="text-center mt-10">
        <button class="px-8 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
            Load More Events
        </button>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}</style>
@endsection
