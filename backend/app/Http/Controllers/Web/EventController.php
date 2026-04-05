<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Event::where('start_date', '>=', now());

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->input('search')}%");
        }

        $events = $query->orderBy('start_date')->paginate(20);
        return view('events.index', compact('events'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|string',
            'location_type' => 'required|string',
            'venue_name' => 'nullable|string|max:255',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'max_attendees' => 'nullable|integer|min:1',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'published';
        Event::create($validated);
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function show(Event $event): View
    {
        $is_registered = $event->attendees()->where('user_id', auth()->id())->exists();
        return view('events.show', compact('event', 'is_registered'));
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|string',
            'location_type' => 'required|string',
            'venue_name' => 'nullable|string|max:255',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'max_attendees' => 'nullable|integer|min:1',
        ]);

        $event->update($validated);
        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function register(Event $event): RedirectResponse
    {
        EventAttendee::updateOrCreate(
            ['event_id' => $event->id, 'user_id' => auth()->id()],
            ['registered_at' => now()]
        );

        return back()->with('success', 'Registered for event!');
    }

    public function unregister(Event $event): RedirectResponse
    {
        $event->attendees()->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Unregistered from event!');
    }
}
