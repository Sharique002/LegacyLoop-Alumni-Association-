<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuccessStoryController extends Controller
{
    /**
     * Get all success stories
     */
    public function index(Request $request)
    {
        $query = SuccessStory::with('user')->published();

        // Filters
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 15);
        $stories = $query->orderBy('published_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $stories
        ]);
    }

    /**
     * Get single success story
     */
    public function show($id)
    {
        $story = SuccessStory::with(['user', 'comments.user', 'likes'])->findOrFail($id);
        $story->incrementViews();

        return response()->json([
            'success' => true,
            'data' => $story
        ]);
    }

    /**
     * Create new success story
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $story = SuccessStory::create([
            'user_id' => $request->user()->id,
            'status' => 'pending_review',
            ...$request->all()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Success story submitted for review',
            'data' => $story
        ], 201);
    }

    /**
     * Update success story
     */
    public function update(Request $request, $id)
    {
        $story = SuccessStory::findOrFail($id);

        if ($story->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $story->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Success story updated',
            'data' => $story
        ]);
    }

    /**
     * Delete success story
     */
    public function destroy(Request $request, $id)
    {
        $story = SuccessStory::findOrFail($id);

        if ($story->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $story->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success story deleted'
        ]);
    }

    /**
     * Like a success story
     */
    public function like(Request $request, $id)
    {
        $story = SuccessStory::findOrFail($id);
        
        $like = $story->likes()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        if ($like->wasRecentlyCreated) {
            $story->incrementLikes();
            $message = 'Story liked';
        } else {
            $like->delete();
            $story->decrementLikes();
            $message = 'Story unliked';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => ['likes_count' => $story->fresh()->likes_count]
        ]);
    }

    /**
     * Get user's stories
     */
    public function myStories(Request $request)
    {
        $stories = SuccessStory::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $stories
        ]);
    }
}
