@extends('layouts.modern')
@section('title', 'Messages')

@section('content')
<div class="animate-slide-up h-[calc(100vh-10rem)]">
    <div class="bg-white rounded-xl shadow-card h-full flex overflow-hidden">
        <!-- Chat List -->
        <div class="w-80 border-r border-gray-200 flex flex-col shrink-0">
            <div class="p-4 border-b border-gray-100">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Search messages..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                </div>
            </div>
            <div class="flex-1 overflow-y-auto">
                @php $conversations = [
                    ['name' => 'Sarah Johnson', 'message' => 'That sounds great! Let me know when...', 'time' => '2m', 'unread' => 2, 'online' => true],
                    ['name' => 'Michael Chen', 'message' => 'Thanks for the mentorship session!', 'time' => '1h', 'unread' => 0, 'online' => true],
                    ['name' => 'Emily Rodriguez', 'message' => 'I saw your post about the job opening', 'time' => '3h', 'unread' => 0, 'online' => false],
                    ['name' => 'David Kim', 'message' => 'Would love to connect about startups', 'time' => '1d', 'unread' => 0, 'online' => false],
                    ['name' => 'Lisa Wong', 'message' => 'The design feedback was really helpful', 'time' => '2d', 'unread' => 0, 'online' => true],
                    ['name' => 'James Miller', 'message' => 'See you at the networking event!', 'time' => '3d', 'unread' => 0, 'online' => false],
                ]; @endphp
                @foreach($conversations as $i => $chat)
                <div class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer transition {{ $i === 0 ? 'bg-primary-50 border-l-2 border-primary-500' : '' }}">
                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr($chat['name'], 0, 1) . substr(explode(' ', $chat['name'])[1], 0, 1) }}
                        </div>
                        @if($chat['online'])
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        @endif
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $chat['name'] }}</p>
                            <span class="text-xs text-gray-400">{{ $chat['time'] }}</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">{{ $chat['message'] }}</p>
                    </div>
                    @if($chat['unread'] > 0)
                    <span class="ml-2 w-5 h-5 bg-primary-500 text-white text-xs font-medium rounded-full flex items-center justify-center">{{ $chat['unread'] }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex flex-col">
            <!-- Chat Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm">SJ</div>
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Sarah Johnson</p>
                        <p class="text-xs text-green-500">Online</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <div class="text-center">
                    <span class="px-3 py-1 text-xs text-gray-500 bg-gray-100 rounded-full">Today</span>
                </div>
                
                <!-- Received Message -->
                <div class="flex items-end gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-semibold shrink-0">SJ</div>
                    <div class="max-w-md">
                        <div class="bg-gray-100 rounded-2xl rounded-bl-md px-4 py-3">
                            <p class="text-sm text-gray-800">Hey! I saw your profile and I think we have a lot in common. Would love to connect and chat about your experience at Google!</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block">10:32 AM</span>
                    </div>
                </div>

                <!-- Sent Message -->
                <div class="flex items-end gap-3 justify-end">
                    <div class="max-w-md">
                        <div class="bg-primary-500 text-white rounded-2xl rounded-br-md px-4 py-3">
                            <p class="text-sm">Hi Sarah! Thanks for reaching out. I'd be happy to chat. What would you like to know?</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block text-right">10:35 AM</span>
                    </div>
                </div>

                <!-- Received Message -->
                <div class="flex items-end gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-semibold shrink-0">SJ</div>
                    <div class="max-w-md">
                        <div class="bg-gray-100 rounded-2xl rounded-bl-md px-4 py-3">
                            <p class="text-sm text-gray-800">I'm currently interviewing for a PM role there. Any tips on the interview process? Also, how do you like the team culture?</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block">10:38 AM</span>
                    </div>
                </div>

                <!-- Sent Message -->
                <div class="flex items-end gap-3 justify-end">
                    <div class="max-w-md">
                        <div class="bg-primary-500 text-white rounded-2xl rounded-br-md px-4 py-3">
                            <p class="text-sm">The interview process is pretty standard - behavioral + case studies. Make sure you practice structured problem solving. Team culture is amazing, very collaborative!</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block text-right">10:42 AM</span>
                    </div>
                </div>

                <!-- Received Message -->
                <div class="flex items-end gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-semibold shrink-0">SJ</div>
                    <div class="max-w-md">
                        <div class="bg-gray-100 rounded-2xl rounded-bl-md px-4 py-3">
                            <p class="text-sm text-gray-800">That sounds great! Let me know when you're free for a quick call. I'd love to hear more details. 🙌</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block">Just now</span>
                    </div>
                </div>
            </div>

            <!-- Message Input -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    </button>
                    <div class="flex-1 relative">
                        <input type="text" placeholder="Type a message..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition pr-24">
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">
                            <button class="p-2 text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </div>
                    </div>
                    <button class="p-3 text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}</style>
@endsection
