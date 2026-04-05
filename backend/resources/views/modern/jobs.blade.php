@extends('layouts.modern')
@section('title', 'Jobs')

@section('content')
<div class="animate-slide-up">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-heading font-bold text-gray-900">Job Board</h1>
        <p class="text-gray-600 mt-1">Discover exclusive opportunities from alumni and partner companies</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Filters Sidebar -->
        <aside class="lg:w-72 shrink-0">
            <div class="bg-white rounded-xl shadow-card p-6 sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-semibold text-gray-900">Filters</h3>
                    <button class="text-sm text-primary-500 hover:text-primary-600 transition">Reset</button>
                </div>

                <!-- Job Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Job Type</label>
                    <div class="space-y-2">
                        @foreach(['Full-time', 'Part-time', 'Contract', 'Remote'] as $type)
                        <label class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500">
                            <span class="ml-3 text-sm text-gray-600">{{ $type }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Experience Level -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Experience Level</label>
                    <div class="space-y-2">
                        @foreach(['Entry Level', 'Mid Level', 'Senior', 'Executive'] as $level)
                        <label class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500">
                            <span class="ml-3 text-sm text-gray-600">{{ $level }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Location</label>
                    <input type="text" placeholder="City or Remote" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                </div>

                <!-- Salary Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Salary Range</label>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" placeholder="Min" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        <input type="text" placeholder="Max" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    </div>
                </div>

                <button class="w-full mt-6 py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition">
                    Apply Filters
                </button>
            </div>
        </aside>

        <!-- Job Listings -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-gray-600"><span class="font-semibold text-gray-900">156</span> jobs found</p>
                <select class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                    <option>Most Relevant</option>
                    <option>Newest</option>
                    <option>Highest Salary</option>
                </select>
            </div>

            <div class="space-y-4">
                @php $jobs = [
                    ['title' => 'Senior Product Manager', 'company' => 'Google', 'location' => 'San Francisco, CA', 'type' => 'Full-time', 'salary' => '$150K - $200K', 'match' => 95, 'posted' => '2 days ago', 'description' => 'Lead product strategy for our cloud platform team. Work with engineering and design to ship features that impact millions of users.'],
                    ['title' => 'Software Engineer III', 'company' => 'Meta', 'location' => 'Remote', 'type' => 'Full-time', 'salary' => '$140K - $180K', 'match' => 88, 'posted' => '3 days ago', 'description' => 'Build scalable systems for our social platform. Strong experience with React and distributed systems required.'],
                    ['title' => 'Data Scientist', 'company' => 'Amazon', 'location' => 'Seattle, WA', 'type' => 'Full-time', 'salary' => '$130K - $170K', 'match' => 82, 'posted' => '1 week ago', 'description' => 'Apply ML models to improve customer experience. PhD or MS in quantitative field preferred.'],
                    ['title' => 'UX Designer', 'company' => 'Airbnb', 'location' => 'San Francisco, CA', 'type' => 'Full-time', 'salary' => '$120K - $160K', 'match' => 78, 'posted' => '1 week ago', 'description' => 'Design beautiful experiences for hosts and guests. Strong portfolio and Figma skills required.'],
                    ['title' => 'Engineering Manager', 'company' => 'Netflix', 'location' => 'Los Gatos, CA', 'type' => 'Full-time', 'salary' => '$180K - $250K', 'match' => 75, 'posted' => '2 weeks ago', 'description' => 'Lead a team of 8-12 engineers building our content delivery platform.'],
                ]; @endphp
                @foreach($jobs as $job)
                <div class="bg-white rounded-xl shadow-card p-6 hover:shadow-soft transition group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start">
                            <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center text-gray-700 font-bold text-lg shrink-0">
                                {{ substr($job['company'], 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition">{{ $job['title'] }}</h3>
                                <p class="text-gray-600">{{ $job['company'] }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1.5 text-sm font-semibold text-green-700 bg-green-100 rounded-full">{{ $job['match'] }}% Match</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $job['description'] }}</p>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $job['location'] }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $job['type'] }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $job['salary'] }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Posted {{ $job['posted'] }}</span>
                        <div class="flex items-center gap-3">
                            <button class="p-2 text-gray-400 hover:text-red-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                            <button class="px-5 py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-center gap-2 mt-8">
                <button class="p-2 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                @for($i = 1; $i <= 5; $i++)
                <button class="w-10 h-10 rounded-xl text-sm font-medium {{ $i === 1 ? 'bg-primary-500 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition">{{ $i }}</button>
                @endfor
                <button class="p-2 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}</style>
@endsection
