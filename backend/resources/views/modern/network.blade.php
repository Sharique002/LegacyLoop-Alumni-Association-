@extends('layouts.modern')
@section('title', 'Network')

@section('content')
<div class="animate-slide-up">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-heading font-bold text-gray-900">Alumni Network</h1>
            <p class="text-gray-600 mt-1">Connect with {{ $totalAlumni ?? '50,000+' }} alumni worldwide</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Search by name, company, skill..." class="w-full sm:w-80 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
            </div>
        </div>
    </div>

    <!-- Filter Tags -->
    <div class="flex flex-wrap items-center gap-3 mb-8">
        <span class="text-sm font-medium text-gray-700">Filter by:</span>
        @foreach(['All', 'Class of 2024', 'Class of 2023', 'Engineering', 'Business', 'Design', 'Remote'] as $filter)
        <button class="px-4 py-2 text-sm font-medium rounded-full transition {{ $filter === 'All' ? 'bg-primary-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-primary-300 hover:text-primary-600' }}">
            {{ $filter }}
        </button>
        @endforeach
    </div>

    <!-- Alumni Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @php $alumni = [
            ['name' => 'Sarah Johnson', 'role' => 'Product Manager', 'company' => 'Google', 'year' => '2018', 'location' => 'San Francisco', 'skills' => ['Product', 'UX', 'Strategy'], 'connected' => false],
            ['name' => 'Michael Chen', 'role' => 'Senior Developer', 'company' => 'Meta', 'year' => '2017', 'location' => 'Seattle', 'skills' => ['React', 'Node.js', 'AWS'], 'connected' => true],
            ['name' => 'Emily Rodriguez', 'role' => 'Data Scientist', 'company' => 'Amazon', 'year' => '2019', 'location' => 'New York', 'skills' => ['Python', 'ML', 'SQL'], 'connected' => false],
            ['name' => 'David Kim', 'role' => 'Founder & CEO', 'company' => 'TechStart', 'year' => '2015', 'location' => 'Austin', 'skills' => ['Startup', 'Sales', 'Leadership'], 'connected' => false],
            ['name' => 'Lisa Wong', 'role' => 'UX Designer', 'company' => 'Airbnb', 'year' => '2020', 'location' => 'San Francisco', 'skills' => ['Figma', 'Research', 'Prototyping'], 'connected' => true],
            ['name' => 'James Miller', 'role' => 'Engineering Manager', 'company' => 'Netflix', 'year' => '2016', 'location' => 'Los Angeles', 'skills' => ['Java', 'Architecture', 'Team Lead'], 'connected' => false],
            ['name' => 'Anna Park', 'role' => 'Marketing Director', 'company' => 'Spotify', 'year' => '2014', 'location' => 'New York', 'skills' => ['Digital Marketing', 'Growth', 'Brand'], 'connected' => false],
            ['name' => 'Robert Taylor', 'role' => 'VP of Sales', 'company' => 'Salesforce', 'year' => '2012', 'location' => 'Chicago', 'skills' => ['Enterprise Sales', 'Strategy', 'CRM'], 'connected' => true],
        ]; @endphp
        @foreach($alumni as $person)
        <div class="bg-white rounded-xl shadow-card p-6 hover:shadow-soft transition group">
            <div class="text-center mb-4">
                <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-2xl font-bold mb-4">
                    {{ substr($person['name'], 0, 1) . substr(explode(' ', $person['name'])[1], 0, 1) }}
                </div>
                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition">{{ $person['name'] }}</h3>
                <p class="text-sm text-gray-600">{{ $person['role'] }}</p>
                <p class="text-sm text-primary-600 font-medium">{{ $person['company'] }}</p>
            </div>
            <div class="text-center text-xs text-gray-500 mb-4">
                <span>Class of {{ $person['year'] }}</span>
                <span class="mx-2">•</span>
                <span>{{ $person['location'] }}</span>
            </div>
            <div class="flex flex-wrap justify-center gap-1.5 mb-5">
                @foreach(array_slice($person['skills'], 0, 3) as $skill)
                <span class="px-2.5 py-1 text-xs font-medium bg-primary-50 text-primary-700 rounded-full">{{ $skill }}</span>
                @endforeach
            </div>
            @if($person['connected'])
            <button class="w-full py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl cursor-default flex items-center justify-center">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Connected
            </button>
            @else
            <button class="w-full py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Connect
            </button>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Empty State (if no results) -->
    {{-- 
    <div class="text-center py-16">
        <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No alumni found</h3>
        <p class="text-gray-600 mb-6">Try adjusting your filters or search query</p>
        <button class="px-6 py-2.5 text-sm font-medium text-primary-500 hover:text-primary-600 transition">Clear all filters</button>
    </div>
    --}}

    <!-- Pagination -->
    <div class="flex items-center justify-center gap-2 mt-10">
        <button class="p-2 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        @for($i = 1; $i <= 5; $i++)
        <button class="w-10 h-10 rounded-xl text-sm font-medium {{ $i === 1 ? 'bg-primary-500 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition">{{ $i }}</button>
        @endfor
        <span class="text-gray-400">...</span>
        <button class="w-10 h-10 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition">24</button>
        <button class="p-2 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}</style>
@endsection
