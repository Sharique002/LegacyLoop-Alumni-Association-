<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LegacyLoop</title>
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
    <style>.gradient-blur{position:absolute;width:400px;height:400px;border-radius:50%;filter:blur(120px);opacity:0.3;}</style>
</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    <div class="min-h-full flex">
        <!-- Left Panel - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-500 to-primary-700 relative overflow-hidden">
            <div class="gradient-blur bg-white/20 top-20 -left-20"></div>
            <div class="gradient-blur bg-secondary-300/30 bottom-20 right-0"></div>
            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="text-2xl font-heading font-bold text-white">LegacyLoop</span>
                </a>
                <div class="max-w-md">
                    <h1 class="text-4xl font-heading font-bold text-white mb-6">Connect with your alumni network</h1>
                    <p class="text-lg text-primary-100 mb-8">Join thousands of alumni who are building meaningful connections and advancing their careers.</p>
                    <div class="space-y-4">
                        <div class="flex items-center text-white">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Discover exclusive job opportunities</span>
                        </div>
                        <div class="flex items-center text-white">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Find mentors in your field</span>
                        </div>
                        <div class="flex items-center text-white">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Attend exclusive alumni events</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex -space-x-3">
                        @for($i = 0; $i < 4; $i++)
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-primary-300 to-primary-500 flex items-center justify-center text-white text-xs font-bold">{{ chr(65 + $i) }}</div>
                        @endfor
                    </div>
                    <div class="text-white"><p class="font-semibold">50,000+ alumni</p><p class="text-sm text-primary-100">have already joined</p></div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8 text-center">
                    <a href="/" class="inline-flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-2xl font-heading font-bold text-gray-900">LegacyLoop</span>
                    </a>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
