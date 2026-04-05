<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SuccessStoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = SuccessStory::where('status', 'approved');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->input('search')}%");
        }

        $stories = $query->latest()->paginate(20);
        return view('stories.index', compact('stories'));
    }

    public function create(): View
    {
        return view('stories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        SuccessStory::create($validated);
        return redirect()->route('stories.index')->with('success', 'Success story submitted for approval!');
    }

    public function show(SuccessStory $story): View
    {
        if ($story->status !== 'approved' && $story->user_id !== auth()->id()) {
            abort(403);
        }

        $is_liked = $story->likes()->where('user_id', auth()->id())->exists();
        return view('stories.show', compact('story', 'is_liked'));
    }

    public function edit(SuccessStory $story): View
    {
        $this->authorize('update', $story);
        return view('stories.edit', compact('story'));
    }

    public function update(Request $request, SuccessStory $story): RedirectResponse
    {
        $this->authorize('update', $story);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $story->update($validated);
        return redirect()->route('stories.show', $story)->with('success', 'Story updated successfully!');
    }

    public function destroy(SuccessStory $story): RedirectResponse
    {
        $this->authorize('delete', $story);
        $story->delete();
        return redirect()->route('stories.index')->with('success', 'Story deleted successfully!');
    }
}
