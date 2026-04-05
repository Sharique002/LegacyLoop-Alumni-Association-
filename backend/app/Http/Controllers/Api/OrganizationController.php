<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    /**
     * Get organization dashboard with statistics
     */
    public function dashboard(Request $request)
    {
        $organization = $request->user();

        $totalAlumni = $organization->alumni()->count();
        $activeAlumni = $organization->alumni()->where('is_active', true)->count();
        $totalEvents = $organization->events()->count();
        $upcomingEvents = $organization->events()
            ->where('start_date', '>', now())
            ->where('status', 'published')
            ->count();
        
        $recentAlumni = $organization->alumni()
            ->select('id', 'first_name', 'last_name', 'email', 'graduation_year', 'branch', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $upcomingEventsList = $organization->events()
            ->where('start_date', '>', now())
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();

        // Alumni by graduation year
        $alumniByYear = $organization->alumni()
            ->selectRaw('graduation_year, COUNT(*) as count')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'desc')
            ->limit(10)
            ->get();

        // Alumni by branch
        $alumniByBranch = $organization->alumni()
            ->selectRaw('branch, COUNT(*) as count')
            ->groupBy('branch')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'statistics' => [
                    'total_alumni' => $totalAlumni,
                    'active_alumni' => $activeAlumni,
                    'total_events' => $totalEvents,
                    'upcoming_events' => $upcomingEvents,
                ],
                'recent_alumni' => $recentAlumni,
                'upcoming_events' => $upcomingEventsList,
                'alumni_by_year' => $alumniByYear,
                'alumni_by_branch' => $alumniByBranch,
            ]
        ]);
    }

    /**
     * Get all alumni belonging to the organization
     */
    public function alumni(Request $request)
    {
        $organization = $request->user();
        
        $query = $organization->alumni()
            ->select([
                'id', 'first_name', 'last_name', 'email', 'phone', 'avatar',
                'graduation_year', 'degree', 'branch', 'current_company', 
                'job_title', 'city', 'country', 'is_active', 'created_at'
            ]);

        // Filters
        if ($request->has('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        if ($request->has('branch')) {
            $query->where('branch', 'like', '%' . $request->branch . '%');
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('current_company', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = min($request->get('per_page', 15), 100);
        $alumni = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $alumni
        ]);
    }

    /**
     * Get a single alumni detail
     */
    public function showAlumni(Request $request, $id)
    {
        $organization = $request->user();
        
        $alumni = $organization->alumni()->find($id);

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'Alumni not found or does not belong to your organization.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $alumni
        ]);
    }

    /**
     * Get organization events
     */
    public function events(Request $request)
    {
        $organization = $request->user();

        $query = $organization->events();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('upcoming') && $request->upcoming) {
            $query->where('start_date', '>', now());
        }

        $sortBy = $request->get('sort_by', 'start_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = min($request->get('per_page', 15), 100);
        $events = $query->with('attendees')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Create a new event
     */
    public function createEvent(Request $request)
    {
        $organization = $request->user();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|string|in:workshop,seminar,reunion,networking,webinar,other',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location_type' => 'required|in:online,offline,hybrid',
            'venue_name' => 'required_if:location_type,offline,hybrid|nullable|string',
            'venue_address' => 'required_if:location_type,offline,hybrid|nullable|string',
            'meeting_link' => 'required_if:location_type,online,hybrid|nullable|url',
            'max_attendees' => 'nullable|integer|min:1',
            'registration_fee' => 'nullable|numeric|min:0',
            'registration_deadline' => 'nullable|date|before:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::create([
            'organization_id' => $organization->id,
            'created_by' => null, // Created by organization, not a user
            'title' => $request->title,
            'description' => $request->description,
            'event_type' => $request->event_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'timezone' => $request->timezone ?? 'UTC',
            'location_type' => $request->location_type,
            'venue_name' => $request->venue_name,
            'venue_address' => $request->venue_address,
            'city' => $request->city,
            'country' => $request->country,
            'meeting_link' => $request->meeting_link,
            'requires_registration' => $request->requires_registration ?? true,
            'max_attendees' => $request->max_attendees,
            'registration_fee' => $request->registration_fee ?? 0,
            'registration_deadline' => $request->registration_deadline,
            'speakers' => $request->speakers,
            'agenda' => $request->agenda,
            'target_audience' => $request->target_audience,
            'status' => 'published',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }

    /**
     * Update an event
     */
    public function updateEvent(Request $request, $id)
    {
        $organization = $request->user();
        
        $event = $organization->events()->find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found or does not belong to your organization.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'event_type' => 'sometimes|string|in:workshop,seminar,reunion,networking,webinar,other',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'location_type' => 'sometimes|in:online,offline,hybrid',
            'max_attendees' => 'nullable|integer|min:1',
            'status' => 'sometimes|in:draft,published,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $event->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $event
        ]);
    }

    /**
     * Delete an event
     */
    public function deleteEvent(Request $request, $id)
    {
        $organization = $request->user();
        
        $event = $organization->events()->find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found or does not belong to your organization.'
            ], 404);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    /**
     * Get event attendees
     */
    public function eventAttendees(Request $request, $id)
    {
        $organization = $request->user();
        
        $event = $organization->events()->find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found or does not belong to your organization.'
            ], 404);
        }

        $attendees = $event->attendees()
            ->with(['user:id,first_name,last_name,email,graduation_year,branch'])
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $attendees
        ]);
    }
}
