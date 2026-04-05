@extends('layouts.modern')
@section('title', 'Profile')

@section('content')
<div class="animate-slide-up">
    @php 
    $user = auth()->user() ?? (object)[
        'name' => 'John Doe', 
        'email' => 'john.doe@example.com',
        'graduation_year' => 2018,
        'bio' => 'Senior Software Engineer passionate about building scalable systems and mentoring junior developers.',
        'location' => 'San Francisco, CA',
        'company' => 'Google',
        'role' => 'Senior Software Engineer'
    ];
    @endphp

    <!-- Profile Header -->
    <div class="bg-white rounded-2xl shadow-card overflow-hidden mb-8">
        <div class="h-32 bg-gradient-to-r from-primary-500 to-primary-700 relative">
            <button class="absolute top-4 right-4 px-4 py-2 text-sm font-medium text-white bg-white/20 backdrop-blur rounded-xl hover:bg-white/30 transition">
                Edit Cover
            </button>
        </div>
        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row sm:items-end -mt-16 sm:-mt-12">
                <div class="relative">
                    <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-lg">
                        {{ strtoupper(substr($user->name ?? 'JD', 0, 2)) }}
                    </div>
                    <button class="absolute bottom-2 right-2 w-8 h-8 bg-white rounded-lg shadow flex items-center justify-center text-gray-600 hover:text-primary-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </button>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-6 flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-heading font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-600">{{ $user->role ?? 'Software Engineer' }} at <span class="text-primary-600 font-medium">{{ $user->company ?? 'Tech Company' }}</span></p>
                            <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    {{ $user->location ?? 'San Francisco, CA' }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                    Class of {{ $user->graduation_year ?? '2018' }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0 flex gap-3">
                            <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition">
                                Edit Profile
                            </a>
                            <button class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- About -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <h2 class="text-lg font-heading font-semibold text-gray-900 mb-4">About</h2>
                <p class="text-gray-600 leading-relaxed">
                    {{ $user->bio ?? 'Senior Software Engineer passionate about building scalable systems and mentoring junior developers. Previously worked at startups and fortune 500 companies. Love contributing to open source and speaking at tech conferences.' }}
                </p>
            </div>

            <!-- Experience -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-heading font-semibold text-gray-900">Experience</h2>
                    <button class="text-sm font-medium text-primary-500 hover:text-primary-600 transition">+ Add</button>
                </div>
                @php $experiences = [
                    ['role' => 'Senior Software Engineer', 'company' => 'Google', 'duration' => 'Jan 2021 - Present', 'description' => 'Leading a team of 5 engineers building cloud infrastructure services. Improved system reliability by 40%.'],
                    ['role' => 'Software Engineer', 'company' => 'Meta', 'duration' => 'Jun 2018 - Dec 2020', 'description' => 'Developed React components for the main feed. Optimized performance reducing load time by 30%.'],
                ]; @endphp
                <div class="space-y-6">
                    @foreach($experiences as $exp)
                    <div class="flex">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm shrink-0">
                            {{ substr($exp['company'], 0, 2) }}
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $exp['role'] }}</h3>
                            <p class="text-sm text-primary-600 font-medium">{{ $exp['company'] }}</p>
                            <p class="text-sm text-gray-500 mb-2">{{ $exp['duration'] }}</p>
                            <p class="text-sm text-gray-600">{{ $exp['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Education -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-heading font-semibold text-gray-900">Education</h2>
                    <button class="text-sm font-medium text-primary-500 hover:text-primary-600 transition">+ Add</button>
                </div>
                <div class="flex">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">B.S. Computer Science</h3>
                        <p class="text-sm text-primary-600 font-medium">Stanford University</p>
                        <p class="text-sm text-gray-500">Class of {{ $user->graduation_year ?? '2018' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Profile Strength -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Profile Strength</h3>
                <div class="relative pt-1">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-primary-600">85% Complete</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2.5 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600">Profile photo</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600">Work experience</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 text-gray-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="text-gray-400">Add resume</span>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900">Skills</h3>
                    <button class="text-sm font-medium text-primary-500 hover:text-primary-600 transition">+ Add</button>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach(['JavaScript', 'React', 'Node.js', 'Python', 'AWS', 'Docker', 'Kubernetes', 'GraphQL', 'TypeScript'] as $skill)
                    <span class="px-3 py-1.5 text-sm font-medium bg-primary-50 text-primary-700 rounded-full">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Contact Information</h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="text-gray-600">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <a href="#" class="text-primary-600 hover:text-primary-700">linkedin.com/in/johndoe</a>
                    </div>
                    <div class="flex items-center text-sm">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        <a href="#" class="text-primary-600 hover:text-primary-700">github.com/johndoe</a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-white rounded-xl shadow-card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Network Stats</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">142</p>
                        <p class="text-xs text-gray-500">Connections</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">28</p>
                        <p class="text-xs text-gray-500">Profile Views</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">5</p>
                        <p class="text-xs text-gray-500">Mentees</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}</style>
@endsection
