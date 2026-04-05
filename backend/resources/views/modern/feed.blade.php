@extends('layouts.modern')
@section('title', 'Feed')

@section('content')
<div class="animate-slide-up max-w-3xl mx-auto">
    <!-- Create Post -->
    <div class="bg-white rounded-xl shadow-card p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold shrink-0">
                {{ auth()->check() ? strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) : 'JD' }}
            </div>
            <div class="flex-1">
                <textarea placeholder="Share an update, achievement, or question with the community..." rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none"></textarea>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center gap-2">
                        <button class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Photo
                        </button>
                        <button class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            Link
                        </button>
                        <button class="flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Event
                        </button>
                    </div>
                    <button class="px-5 py-2.5 text-sm font-medium text-white bg-primary-500 rounded-xl hover:bg-primary-600 transition">
                        Post
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Feed -->
    @php $posts = [
        [
            'author' => 'Sarah Johnson',
            'role' => 'Product Manager @ Google',
            'time' => '2 hours ago',
            'content' => "Excited to announce that I've just been promoted to Senior Product Manager! 🎉 Grateful for all the mentorship and support from our amazing alumni community. Special thanks to @JohnDoe for the career advice that helped me get here!",
            'likes' => 124,
            'comments' => 18,
            'liked' => true,
        ],
        [
            'author' => 'Michael Chen',
            'role' => 'Senior Developer @ Meta',
            'time' => '5 hours ago',
            'content' => "Looking for talented engineers to join my team! We're building the next generation of social features. DM me if you're interested or know someone who would be a great fit.\n\n#hiring #engineering #opportunity",
            'likes' => 89,
            'comments' => 32,
            'liked' => false,
        ],
        [
            'author' => 'Emily Rodriguez',
            'role' => 'Data Scientist @ Amazon',
            'time' => '1 day ago',
            'content' => "Just published my first research paper on machine learning optimization techniques! It's been a long journey but so worth it. Happy to share insights with anyone working on similar problems. Link in comments 📚",
            'likes' => 256,
            'comments' => 45,
            'liked' => false,
        ],
        [
            'author' => 'David Kim',
            'role' => 'Founder & CEO @ TechStart',
            'time' => '2 days ago',
            'content' => "We just closed our Series A! $15M to revolutionize how small businesses manage their operations. Couldn't have done it without the incredible network of alumni investors and advisors. Looking to hire across all functions - reach out!",
            'likes' => 312,
            'comments' => 67,
            'liked' => true,
        ],
    ]; @endphp

    <div class="space-y-6">
        @foreach($posts as $post)
        <div class="bg-white rounded-xl shadow-card overflow-hidden">
            <!-- Post Header -->
            <div class="p-6 pb-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                            {{ substr($post['author'], 0, 1) . substr(explode(' ', $post['author'])[1], 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $post['author'] }}</p>
                            <p class="text-sm text-gray-500">{{ $post['role'] }}</p>
                            <p class="text-xs text-gray-400">{{ $post['time'] }}</p>
                        </div>
                    </div>
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                    </button>
                </div>
                <!-- Post Content -->
                <p class="mt-4 text-gray-800 whitespace-pre-line">{{ $post['content'] }}</p>
            </div>

            <!-- Post Stats -->
            <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center gap-1">
                    <span class="w-5 h-5 bg-primary-500 rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg>
                    </span>
                    <span>{{ $post['likes'] }} likes</span>
                </div>
                <span>{{ $post['comments'] }} comments</span>
            </div>

            <!-- Post Actions -->
            <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-around">
                <button class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition {{ $post['liked'] ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-2" fill="{{ $post['liked'] ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                    Like
                </button>
                <button class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Comment
                </button>
                <button class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    Share
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Load More -->
    <div class="text-center mt-8">
        <button class="px-8 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
            Load More Posts
        </button>
    </div>
</div>
<style>@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}.animate-slide-up{animation:slideUp 0.5s ease-out;}</style>
@endsection
