<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegacyLoop - Connect with Your Alumni Network</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#2563EB', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                        secondary: { 50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4', 400: '#2dd4bf', 500: '#14B8A6', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Poppins', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        .gradient-blur { position: absolute; width: 400px; height: 400px; border-radius: 50%; filter: blur(120px); opacity: 0.4; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-lg z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="text-xl font-heading font-bold text-gray-900">LegacyLoop</span>
                </a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition">Features</a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition">Testimonials</a>
                    <a href="#about" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition">About</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition">Sign in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition shadow-sm">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16">
        <div class="gradient-blur bg-primary-300 top-20 -left-20"></div>
        <div class="gradient-blur bg-secondary-300 bottom-20 right-0"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center px-4 py-2 bg-primary-50 rounded-full mb-6">
                        <span class="w-2 h-2 bg-primary-500 rounded-full mr-2"></span>
                        <span class="text-sm font-medium text-primary-600">Join 50,000+ alumni worldwide</span>
                    </div>
                    <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Reconnect with Your <span class="text-primary-500">Alumni</span> Network
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-xl">
                        Build meaningful connections, discover career opportunities, find mentors, and give back to your community—all in one powerful platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="px-8 py-4 text-base font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition shadow-lg shadow-primary-500/25">
                            Join Your Network
                            <svg class="inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="#features" class="px-8 py-4 text-base font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                            Explore Features
                        </a>
                    </div>
                    <div class="flex items-center gap-8 mt-12 justify-center lg:justify-start">
                        <div><span class="block text-3xl font-bold text-gray-900">50K+</span><span class="text-sm text-gray-500">Active Alumni</span></div>
                        <div class="w-px h-12 bg-gray-200"></div>
                        <div><span class="block text-3xl font-bold text-gray-900">1.2K+</span><span class="text-sm text-gray-500">Job Postings</span></div>
                        <div class="w-px h-12 bg-gray-200"></div>
                        <div><span class="block text-3xl font-bold text-gray-900">500+</span><span class="text-sm text-gray-500">Mentors</span></div>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <div class="animate-float">
                        <div class="bg-white rounded-2xl shadow-xl p-6 mb-4 max-w-sm ml-auto">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold">JD</div>
                                <div class="ml-4"><p class="font-semibold text-gray-900">Jane Doe</p><p class="text-sm text-gray-500">Software Engineer @ Google</p></div>
                            </div>
                            <p class="text-gray-600 text-sm">"LegacyLoop helped me find my dream job through alumni connections!"</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-xl p-6 max-w-xs">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-gray-500">Connection Request</span>
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center text-white text-sm font-bold">MS</div>
                                <div class="ml-3 flex-1"><p class="font-medium text-gray-900 text-sm">Mike Smith</p><p class="text-xs text-gray-500">Class of 2018</p></div>
                                <button class="px-3 py-1.5 text-xs font-medium text-white bg-primary-500 rounded-lg">Accept</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-heading text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Everything you need to stay connected</h2>
                <p class="text-lg text-gray-600">Powerful features designed to help alumni build lasting relationships and advance their careers.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php $features = [
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Alumni Network', 'desc' => 'Connect with thousands of alumni from your institution across the globe.'],
                    ['icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Job Board', 'desc' => 'Discover exclusive job opportunities posted by fellow alumni and companies.'],
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Mentorship', 'desc' => 'Learn from experienced alumni or guide the next generation of graduates.'],
                    ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Events', 'desc' => 'Stay updated on reunions, webinars, networking events, and meetups.'],
                    ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'title' => 'Messaging', 'desc' => 'Connect directly with alumni through secure private messaging.'],
                    ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Give Back', 'desc' => 'Support your alma mater through donations and scholarships.'],
                ]; @endphp
                @foreach($features as $f)
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition group">
                    <div class="w-14 h-14 rounded-xl bg-primary-50 flex items-center justify-center mb-6 group-hover:bg-primary-100 transition">
                        <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-heading text-xl font-semibold text-gray-900 mb-3">{{ $f['title'] }}</h3>
                    <p class="text-gray-600">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-heading text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Loved by alumni worldwide</h2>
                <p class="text-lg text-gray-600">See what our community members have to say about LegacyLoop.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @php $testimonials = [
                    ['name' => 'Sarah Johnson', 'role' => 'Product Manager @ Meta', 'year' => '2016', 'text' => 'LegacyLoop transformed how I network. Found my current job through an alumni connection!'],
                    ['name' => 'David Chen', 'role' => 'Founder, TechStart', 'year' => '2012', 'text' => 'As a mentor, I've helped 20+ recent grads launch their careers. This platform makes it easy.'],
                    ['name' => 'Emily Rodriguez', 'role' => 'Data Scientist @ Amazon', 'year' => '2019', 'text' => 'The job board is incredible. Quality opportunities from companies that value our alumni network.'],
                ]; @endphp
                @foreach($testimonials as $t)
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                    <div class="flex items-center mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 mb-6">"{{ $t['text'] }}"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold">{{ substr($t['name'], 0, 1) . substr(explode(' ', $t['name'])[1] ?? '', 0, 1) }}</div>
                        <div class="ml-4"><p class="font-semibold text-gray-900">{{ $t['name'] }}</p><p class="text-sm text-gray-500">{{ $t['role'] }} • Class of {{ $t['year'] }}</p></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-br from-primary-500 to-primary-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-white mb-6">Ready to reconnect with your alumni network?</h2>
            <p class="text-lg text-primary-100 mb-8">Join thousands of alumni who are already building meaningful connections and advancing their careers.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 text-base font-medium text-primary-600 bg-white rounded-xl hover:bg-gray-100 transition shadow-lg">Get Started Free</a>
                <a href="#features" class="px-8 py-4 text-base font-medium text-white border-2 border-white/30 rounded-xl hover:bg-white/10 transition">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <a href="/" class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-xl font-heading font-bold text-white">LegacyLoop</span>
                    </a>
                    <p class="text-gray-400 text-sm">Connecting alumni worldwide to build meaningful relationships and advance careers.</p>
                </div>
                <div><h4 class="font-semibold text-white mb-4">Platform</h4><ul class="space-y-3"><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Network</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Jobs</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Events</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Mentorship</a></li></ul></div>
                <div><h4 class="font-semibold text-white mb-4">Company</h4><ul class="space-y-3"><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">About Us</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Careers</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Contact</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Blog</a></li></ul></div>
                <div><h4 class="font-semibold text-white mb-4">Legal</h4><ul class="space-y-3"><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Privacy Policy</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Terms of Service</a></li><li><a href="#" class="text-gray-400 hover:text-white text-sm transition">Cookie Policy</a></li></ul></div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} LegacyLoop. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
