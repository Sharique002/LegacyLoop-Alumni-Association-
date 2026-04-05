<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Get all events with filters
     */
    public function index(Request $request)
    {
        $query = Event::with('creator')->published();

        // Filters
        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->has('location_type')) {
            $query->where('location_type', $request->location_type);
        }

        if ($request->has('upcoming')) {
            $query->upcoming();
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 15);
        $events = $query->orderBy('start_date', 'asc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Get single event
     */
    public function show($id)
    {
        $event = Event::with(['creator', 'attendees.user'])->findOrFail($id);
        $event->incrementViews();

        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    /**
     * Create new event
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|in:reunion,networking,webinar,workshop,conference',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location_type' => 'required|in:physical,virtual,hybrid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::create([
            'created_by' => $request->user()->id,
            ...$request->all()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }

    /**
     * Update event
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->created_by !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $event->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $event
        ]);
    }

    /**
     * Delete event
     */
    public function destroy(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->created_by !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    /**
     * Register for an event
     */
    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if (!$event->isRegistrationOpen()) {
            return response()->json([
                'success' => false,
                'message' => 'Registration is closed for this event'
            ], 400);
        }

        // Check if already registered
        $existingAttendee = EventAttendee::where('event_id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingAttendee) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event'
            ], 400);
        }

        $status = $event->isFull() ? 'waitlisted' : 'registered';

        $attendee = EventAttendee::create([
            'event_id' => $id,
            'user_id' => $request->user()->id,
            'status' => $status,
            'ticket_number' => 'TKT-' . strtoupper(Str::random(10)),
            'amount_paid' => $event->registration_fee ?? 0,
        ]);

        if ($status === 'registered') {
            $event->incrementAttendees();
        }

        return response()->json([
            'success' => true,
            'message' => $status === 'registered' ? 'Registration successful' : 'Added to waitlist',
            'data' => $attendee
        ], 201);
    }

    /**
     * Cancel event registration
     */
    public function cancelRegistration(Request $request, $id)
    {
        $attendee = EventAttendee::where('event_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $attendee->cancel();

        return response()->json([
            'success' => true,
            'message' => 'Registration cancelled successfully'
        ]);
    }

    /**
     * Get user's registered events
     */
    public function myEvents(Request $request)
    {
        $events = EventAttendee::with('event')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }
}
