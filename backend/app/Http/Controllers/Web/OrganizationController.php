<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\SuccessStory;
use App\Models\OrganizationAnnouncement;
use App\Models\DonationCampaign;
use App\Models\OrganizationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    /**
     * Get the authenticated organization
     */
    protected function organization()
    {
        return Auth::guard('organization')->user();
    }

    /**
     * Dashboard with statistics
     */
    public function dashboard()
    {
        $organization = $this->organization();

        $stats = [
            'total_alumni' => $organization->alumni()->count(),
            'active_alumni' => $organization->alumni()->where('is_active', true)->count(),
            'total_events' => $organization->events()->count(),
            'upcoming_events' => $organization->events()
                ->where('start_date', '>', now())
                ->where('status', 'published')
                ->count(),
        ];

        $recentAlumni = $organization->alumni()
            ->select('id', 'first_name', 'last_name', 'email', 'graduation_year', 'branch', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $upcomingEvents = $organization->events()
            ->where('start_date', '>', now())
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();

        $alumniByYear = $organization->alumni()
            ->selectRaw('graduation_year, COUNT(*) as count')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'desc')
            ->limit(10)
            ->get();

        $alumniByBranch = $organization->alumni()
            ->selectRaw('branch, COUNT(*) as count')
            ->groupBy('branch')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return view('organization.dashboard', compact(
            'organization',
            'stats',
            'recentAlumni',
            'upcomingEvents',
            'alumniByYear',
            'alumniByBranch'
        ));
    }

    /**
     * Alumni list
     */
    public function alumni(Request $request)
    {
        $organization = $this->organization();

        $query = $organization->alumni()
            ->select([
                'id', 'first_name', 'last_name', 'email', 'phone', 'avatar',
                'graduation_year', 'degree', 'branch', 'current_company',
                'job_title', 'city', 'country', 'is_active', 'created_at'
            ]);

        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        if ($request->filled('branch')) {
            $query->where('branch', 'like', '%' . $request->branch . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $alumni = $query->paginate(15)->withQueryString();

        // Get unique values for filters
        $graduationYears = $organization->alumni()
            ->distinct()
            ->pluck('graduation_year')
            ->sort()
            ->reverse();

        $branches = $organization->alumni()
            ->distinct()
            ->pluck('branch')
            ->filter()
            ->sort();

        return view('organization.alumni', compact('organization', 'alumni', 'graduationYears', 'branches'));
    }

    /**
     * Events list
     */
    public function events(Request $request)
    {
        $organization = $this->organization();

        $query = $organization->events()->withCount('attendees');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('upcoming')) {
            $query->where('start_date', '>', now());
        }

        $events = $query->orderBy('start_date', 'desc')->paginate(10)->withQueryString();

        return view('organization.events', compact('organization', 'events'));
    }

    /**
     * Create event form
     */
    public function createEvent()
    {
        $organization = $this->organization();

        if (!$organization->is_verified) {
            return redirect()->route('organization.dashboard')
                ->with('warning', 'Your organization must be verified to create events.');
        }

        return view('organization.events-create', compact('organization'));
    }

    /**
     * Store new event
     */
    public function storeEvent(Request $request)
    {
        $organization = $this->organization();

        if (!$organization->is_verified) {
            return redirect()->route('organization.dashboard')
                ->with('warning', 'Your organization must be verified to create events.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|string|in:workshop,seminar,reunion,networking,webinar,other',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location_type' => 'required|in:online,offline,hybrid',
            'venue_name' => 'nullable|string',
            'venue_address' => 'nullable|string',
            'meeting_link' => 'nullable|url',
            'max_attendees' => 'nullable|integer|min:1',
            'registration_fee' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $event = Event::create([
            'organization_id' => $organization->id,
            'created_by' => null,
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
            'requires_registration' => $request->has('requires_registration'),
            'max_attendees' => $request->max_attendees,
            'registration_fee' => $request->registration_fee ?? 0,
            'status' => 'published',
        ]);

        return redirect()->route('organization.events')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Edit event form
     */
    public function editEvent($id)
    {
        $organization = $this->organization();
        $event = $organization->events()->findOrFail($id);

        return view('organization.events-edit', compact('organization', 'event'));
    }

    /**
     * Update event
     */
    public function updateEvent(Request $request, $id)
    {
        $organization = $this->organization();
        $event = $organization->events()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location_type' => 'required|in:online,offline,hybrid',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $event->update($request->only([
            'title', 'description', 'event_type', 'start_date', 'end_date',
            'location_type', 'venue_name', 'venue_address', 'meeting_link',
            'max_attendees', 'registration_fee', 'status'
        ]));

        return redirect()->route('organization.events')
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Delete event
     */
    public function deleteEvent($id)
    {
        $organization = $this->organization();
        $event = $organization->events()->findOrFail($id);

        $event->delete();

        return redirect()->route('organization.events')
            ->with('success', 'Event deleted successfully!');
    }

    /**
     * Profile settings
     */
    public function profile()
    {
        $organization = $this->organization();
        return view('organization.profile', compact('organization'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $organization = $this->organization();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $organization->update($request->only([
            'name', 'description', 'website', 'address',
            'city', 'country', 'contact_phone', 'contact_email'
        ]));

        return back()->with('success', 'Profile updated successfully!');
    }

    // ==================== ANNOUNCEMENTS ====================
    
    /**
     * Announcements list
     */
    public function announcements()
    {
        $organization = $this->organization();
        $announcements = OrganizationAnnouncement::where('organization_id', $organization->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('organization.announcements', compact('organization', 'announcements'));
    }

    /**
     * Create announcement form
     */
    public function createAnnouncement()
    {
        $organization = $this->organization();
        return view('organization.announcements-create', compact('organization'));
    }

    /**
     * Store announcement
     */
    public function storeAnnouncement(Request $request)
    {
        $organization = $this->organization();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'nullable|string',
            'priority' => 'nullable|string|in:normal,high,urgent',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isPublished = $request->action === 'publish';

        OrganizationAnnouncement::create([
            'organization_id' => $organization->id,
            'title' => $request->title,
            'content' => $request->content,
            'target_audience' => $request->target_audience ?? 'all',
            'priority' => $request->priority ?? 'normal',
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
            'expires_at' => $request->expires_at,
        ]);
        
        $message = $isPublished ? 'Announcement published successfully!' : 'Announcement saved as draft!';
        return redirect()->route('organization.announcements')
            ->with('success', $message);
    }

    /**
     * Edit announcement
     */
    public function editAnnouncement($id)
    {
        $organization = $this->organization();
        $announcement = OrganizationAnnouncement::where('organization_id', $organization->id)->findOrFail($id);
        return view('organization.announcements-create', compact('organization', 'announcement'));
    }

    /**
     * Update announcement
     */
    public function updateAnnouncement(Request $request, $id)
    {
        $organization = $this->organization();
        $announcement = OrganizationAnnouncement::where('organization_id', $organization->id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'nullable|string',
            'priority' => 'nullable|string|in:normal,high,urgent',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isPublished = $request->action === 'publish';

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'target_audience' => $request->target_audience ?? 'all',
            'priority' => $request->priority ?? 'normal',
            'is_published' => $isPublished,
            'published_at' => $isPublished && !$announcement->published_at ? now() : $announcement->published_at,
        ]);
        
        return redirect()->route('organization.announcements')
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Delete announcement
     */
    public function deleteAnnouncement($id)
    {
        $organization = $this->organization();
        OrganizationAnnouncement::where('organization_id', $organization->id)->findOrFail($id)->delete();
        
        return redirect()->route('organization.announcements')
            ->with('success', 'Announcement deleted successfully!');
    }

    // ==================== JOB POSTINGS ====================

    /**
     * Job postings list
     */
    public function jobs()
    {
        $organization = $this->organization();
        
        $jobs = \App\Models\Job::where('organization_id', $organization->id)
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => \App\Models\Job::where('organization_id', $organization->id)->count(),
            'active' => \App\Models\Job::where('organization_id', $organization->id)->where('status', 'active')->count(),
            'views' => \App\Models\Job::where('organization_id', $organization->id)->sum('views_count'),
            'applications' => \App\Models\Job::where('organization_id', $organization->id)->sum('applications_count'),
        ];

        return view('organization.jobs', compact('organization', 'jobs', 'stats'));
    }

    /**
     * Create job form
     */
    public function createJob()
    {
        $organization = $this->organization();
        return view('organization.jobs-create', compact('organization'));
    }

    /**
     * Store job posting
     */
    public function storeJob(Request $request)
    {
        $organization = $this->organization();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        \App\Models\Job::create([
            'organization_id' => $organization->id,
            'posted_by' => null, // Organization posting, not user
            'title' => $request->title,
            'company_name' => $request->company,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'experience_level' => $request->experience ?? 'entry',
            'description' => $request->description,
            'requirements' => $request->requirements,
            'application_url' => $request->apply_link,
            'application_deadline' => $request->deadline,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('organization.jobs')
            ->with('success', 'Job posted successfully!');
    }

    /**
     * Edit job form
     */
    public function editJob($id)
    {
        $organization = $this->organization();
        $job = \App\Models\Job::where('organization_id', $organization->id)->findOrFail($id);
        return view('organization.jobs-create', compact('organization', 'job'));
    }

    /**
     * Update job posting
     */
    public function updateJob(Request $request, $id)
    {
        $organization = $this->organization();
        $job = \App\Models\Job::where('organization_id', $organization->id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $job->update([
            'title' => $request->title,
            'company_name' => $request->company,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'experience_level' => $request->experience ?? $job->experience_level,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'application_url' => $request->apply_link,
            'application_deadline' => $request->deadline,
            'status' => $request->status ?? $job->status,
        ]);

        return redirect()->route('organization.jobs')
            ->with('success', 'Job updated successfully!');
    }

    /**
     * Delete job posting
     */
    public function deleteJob($id)
    {
        $organization = $this->organization();
        $job = \App\Models\Job::where('organization_id', $organization->id)->findOrFail($id);
        $job->delete();

        return redirect()->route('organization.jobs')
            ->with('success', 'Job deleted successfully!');
    }

    /**
     * Job applications
     */
    public function jobApplications($id)
    {
        $organization = $this->organization();
        $job = \App\Models\Job::where('organization_id', $organization->id)->findOrFail($id);
        $applications = $job->applications()->with('user')->paginate(20);
        return view('organization.jobs-applications', compact('organization', 'job', 'applications'));
    }

    // ==================== DONATION CAMPAIGNS ====================

    /**
     * Donation campaigns list
     */
    public function donations()
    {
        $organization = $this->organization();
        $campaigns = DonationCampaign::where('organization_id', $organization->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_raised' => DonationCampaign::where('organization_id', $organization->id)->sum('raised_amount'),
            'total_donors' => DonationCampaign::where('organization_id', $organization->id)->sum('donors_count'),
            'active_campaigns' => DonationCampaign::where('organization_id', $organization->id)->where('status', 'active')->count(),
            'avg_donation' => DonationCampaign::where('organization_id', $organization->id)->where('donors_count', '>', 0)->avg(DB::raw('raised_amount / donors_count')) ?? 0,
        ];

        return view('organization.donations', compact('organization', 'campaigns', 'stats'));
    }

    /**
     * Create donation campaign form
     */
    public function createDonation()
    {
        $organization = $this->organization();
        return view('organization.donations-create', compact('organization'));
    }

    /**
     * Store donation campaign
     */
    public function storeDonation(Request $request)
    {
        $organization = $this->organization();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:1000',
            'start_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DonationCampaign::create([
            'organization_id' => $organization->id,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category ?? 'general',
            'goal_amount' => $request->goal_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status ?? 'draft',
        ]);

        return redirect()->route('organization.donations')
            ->with('success', 'Campaign created successfully!');
    }

    /**
     * Edit donation campaign
     */
    public function editDonation($id)
    {
        $organization = $this->organization();
        $campaign = DonationCampaign::where('organization_id', $organization->id)->findOrFail($id);
        return view('organization.donations-create', compact('organization', 'campaign'));
    }

    /**
     * Show donation campaign details
     */
    public function showDonation($id)
    {
        $organization = $this->organization();
        $campaign = DonationCampaign::where('organization_id', $organization->id)->findOrFail($id);
        $donations = $campaign->donations()->with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('organization.donations-show', compact('organization', 'campaign', 'donations'));
    }

    // ==================== ALUMNI MESSAGES ====================

    /**
     * Alumni messages list
     */
    public function messages()
    {
        $organization = $this->organization();
        $messages = OrganizationMessage::where('organization_id', $organization->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalSent = OrganizationMessage::where('organization_id', $organization->id)->where('status', 'sent')->count();
        $totalOpens = OrganizationMessage::where('organization_id', $organization->id)->sum('opens_count');
        $totalRecipients = OrganizationMessage::where('organization_id', $organization->id)->sum('recipients_count');

        $stats = [
            'total_sent' => $totalSent,
            'open_rate' => $totalRecipients > 0 ? round(($totalOpens / $totalRecipients) * 100, 1) : 0,
            'recipients' => $organization->alumni()->count(),
        ];

        return view('organization.messages', compact('organization', 'messages', 'stats'));
    }

    /**
     * Create message form
     */
    public function createMessage()
    {
        $organization = $this->organization();
        return view('organization.messages-create', compact('organization'));
    }

    /**
     * Send message
     */
    public function storeMessage(Request $request)
    {
        $organization = $this->organization();

        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|string',
            'target_value' => 'required_if:target_audience,batch,branch',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Validate that at least one delivery method is selected
        if (!$request->send_email && !$request->send_notification) {
            return back()
                ->withErrors(['delivery' => 'Please select at least one delivery method (Email or In-app Notification).'])
                ->withInput();
        }

        // Count recipients based on target audience
        $recipientsCount = $organization->alumni()->count();
        $targetValue = null;
        
        if ($request->target_audience === 'batch') {
            $targetValue = $request->target_value;
            if ($targetValue) {
                $recipientsCount = $organization->alumni()->where('graduation_year', $targetValue)->count();
            }
        } elseif ($request->target_audience === 'branch') {
            $targetValue = $request->target_value;
            if ($targetValue) {
                $recipientsCount = $organization->alumni()->where('branch', $targetValue)->count();
            }
        } elseif ($request->target_audience === 'recent') {
            $targetValue = now()->subYears(2)->year;
            $recipientsCount = $organization->alumni()->where('graduation_year', '>=', $targetValue)->count();
        } elseif ($request->target_audience === 'donors') {
            // Filter alumni who have made donations
            $recipientsCount = $organization->alumni()
                ->whereHas('donations')
                ->count();
        } elseif ($request->target_audience === 'event_attendees') {
            // Filter alumni who have attended events
            $recipientsCount = $organization->alumni()
                ->whereHas('eventRegistrations')
                ->count();
        }

        // Determine status based on scheduled_at
        $status = 'sent';
        $sentAt = now();
        
        if ($request->scheduled_at && strtotime($request->scheduled_at) > time()) {
            $status = 'scheduled';
            $sentAt = null;
        }
        
        // Handle draft action
        if ($request->action === 'draft') {
            $status = 'draft';
            $sentAt = null;
        }

        OrganizationMessage::create([
            'organization_id' => $organization->id,
            'subject' => $request->subject,
            'content' => $request->content,
            'target_audience' => $request->target_audience,
            'target_value' => $targetValue,
            'recipients_count' => $recipientsCount,
            'status' => $status,
            'scheduled_at' => $request->scheduled_at,
            'sent_at' => $sentAt,
        ]);

        // Prepare success message based on action
        $successMessage = 'Message sent successfully to ' . $recipientsCount . ' alumni!';
        
        if ($request->action === 'draft') {
            $successMessage = 'Message saved as draft.';
        } elseif ($status === 'scheduled') {
            $successMessage = 'Message scheduled successfully for ' . $recipientsCount . ' alumni!';
        }
        
        return redirect()->route('organization.messages')
            ->with('success', $successMessage);
    }

    /**
     * View sent message
     */
    public function showMessage($id)
    {
        $organization = $this->organization();
        $message = OrganizationMessage::where('organization_id', $organization->id)->findOrFail($id);
        return view('organization.messages-show', compact('organization', 'message'));
    }

    // ==================== SUCCESS STORIES ====================

    /**
     * Success stories list
     */
    public function stories(Request $request)
    {
        $organization = $this->organization();
        
        $query = SuccessStory::whereHas('user', function($q) use ($organization) {
            $q->where('organization_id', $organization->id);
        })->with('user');

        // Apply filters
        if ($request->filter == 'pending') {
            $query->where('status', 'pending');
        } elseif ($request->filter == 'approved') {
            $query->where('status', 'approved');
        } elseif ($request->filter == 'featured') {
            $query->where('is_featured', true);
        }

        $stories = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $stats = [
            'total' => SuccessStory::whereHas('user', fn($q) => $q->where('organization_id', $organization->id))->count(),
            'pending' => SuccessStory::whereHas('user', fn($q) => $q->where('organization_id', $organization->id))->where('status', 'pending')->count(),
            'approved' => SuccessStory::whereHas('user', fn($q) => $q->where('organization_id', $organization->id))->where('status', 'approved')->count(),
            'featured' => SuccessStory::whereHas('user', fn($q) => $q->where('organization_id', $organization->id))->where('is_featured', true)->count(),
        ];

        return view('organization.stories', compact('organization', 'stories', 'stats'));
    }

    /**
     * View success story
     */
    public function showStory($id)
    {
        $organization = $this->organization();
        $story = SuccessStory::whereHas('user', fn($q) => $q->where('organization_id', $organization->id))
            ->with('user')
            ->findOrFail($id);
        
        return view('organization.stories-show', compact('organization', 'story'));
    }

    /**
     * Approve success story
     */
    public function approveStory($id)
    {
        $organization = $this->organization();
        $story = SuccessStory::whereHas('user', fn($q) => $q->where('organization_id', $organization->id))
            ->findOrFail($id);
        
        $story->update(['status' => 'approved']);

        return back()->with('success', 'Story approved successfully!');
    }

    /**
     * Feature success story
     */
    public function featureStory($id)
    {
        $organization = $this->organization();
        $story = SuccessStory::whereHas('user', fn($q) => $q->where('organization_id', $organization->id))
            ->findOrFail($id);
        
        $story->update(['is_featured' => true]);

        return back()->with('success', 'Story featured successfully!');
    }

    // ==================== ANALYTICS ====================

    /**
     * Analytics dashboard
     */
    public function analytics()
    {
        $organization = $this->organization();

        // Basic stats
        $totalAlumni = $organization->alumni()->count();
        $newAlumniMonth = $organization->alumni()->whereMonth('created_at', now()->month)->count();

        // Alumni by graduation year for chart
        $alumniByYear = $organization->alumni()
            ->selectRaw('graduation_year, COUNT(*) as count')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'desc')
            ->limit(10)
            ->get();

        // Monthly growth
        $monthlyGrowth = $organization->alumni()
            ->selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->get();

        // Top companies
        $topCompanies = $organization->alumni()
            ->selectRaw('current_company as name, COUNT(*) as count')
            ->whereNotNull('current_company')
            ->groupBy('current_company')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();

        // Top locations
        $topLocations = $organization->alumni()
            ->selectRaw('city as name, COUNT(*) as count')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();

        // Events data
        $totalEvents = $organization->events()->count();
        $upcomingEvents = $organization->events()->where('start_date', '>', now())->count();

        $analytics = [
            'total_alumni' => $totalAlumni,
            'new_alumni_month' => $newAlumniMonth,
            'total_donations' => 0, // Would need donation tracking
            'donation_growth' => 0,
            'total_events' => $totalEvents,
            'upcoming_events' => $upcomingEvents,
            'engagement_rate' => $totalAlumni > 0 ? round(($organization->alumni()->where('is_active', true)->count() / $totalAlumni) * 100) : 0,
            'engagement_change' => 5, // Placeholder
            'growth_labels' => $monthlyGrowth->pluck('month')->toArray(),
            'growth_data' => $monthlyGrowth->pluck('count')->toArray(),
            'grad_labels' => ['2020-2024', '2015-2019', '2010-2014', 'Before 2010'],
            'grad_data' => [
                $organization->alumni()->whereBetween('graduation_year', [2020, 2024])->count(),
                $organization->alumni()->whereBetween('graduation_year', [2015, 2019])->count(),
                $organization->alumni()->whereBetween('graduation_year', [2010, 2014])->count(),
                $organization->alumni()->where('graduation_year', '<', 2010)->count(),
            ],
            'top_industries' => [], // Would need industry tracking
            'top_companies' => $topCompanies,
            'top_locations' => $topLocations,
            'event_labels' => $organization->events()->orderBy('created_at', 'desc')->limit(5)->pluck('title')->toArray(),
            'event_data' => $organization->events()->withCount('attendees')->orderBy('created_at', 'desc')->limit(5)->pluck('attendees_count')->toArray(),
            'donation_labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'donation_data' => [0, 0, 0, 0, 0, 0], // Placeholder
        ];

        return view('organization.analytics', compact('organization', 'analytics'));
    }

    /**
     * Export analytics data to PDF
     */
    public function exportAnalytics()
    {
        $organization = $this->organization();

        // Get all analytics data
        $totalAlumni = $organization->alumni()->count();
        $newAlumniMonth = $organization->alumni()->whereMonth('created_at', now()->month)->count();

        // Monthly growth
        $monthlyGrowth = $organization->alumni()
            ->selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->get();

        // Top companies
        $topCompanies = $organization->alumni()
            ->selectRaw('current_company as name, COUNT(*) as count')
            ->whereNotNull('current_company')
            ->groupBy('current_company')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();

        // Top locations
        $topLocations = $organization->alumni()
            ->selectRaw('city as name, COUNT(*) as count')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();

        $totalEvents = $organization->events()->count();
        $upcomingEvents = $organization->events()->where('start_date', '>', now())->count();

        $analytics = [
            'total_alumni' => $totalAlumni,
            'new_alumni_month' => $newAlumniMonth,
            'total_donations' => 0,
            'donation_growth' => 0,
            'total_events' => $totalEvents,
            'upcoming_events' => $upcomingEvents,
            'engagement_rate' => $totalAlumni > 0 ? round(($organization->alumni()->where('is_active', true)->count() / $totalAlumni) * 100) : 0,
            'engagement_change' => 5,
            'growth_labels' => $monthlyGrowth->pluck('month')->toArray(),
            'growth_data' => $monthlyGrowth->pluck('count')->toArray(),
            'grad_labels' => ['2020-2024', '2015-2019', '2010-2014', 'Before 2010'],
            'grad_data' => [
                $organization->alumni()->whereBetween('graduation_year', [2020, 2024])->count(),
                $organization->alumni()->whereBetween('graduation_year', [2015, 2019])->count(),
                $organization->alumni()->whereBetween('graduation_year', [2010, 2014])->count(),
                $organization->alumni()->where('graduation_year', '<', 2010)->count(),
            ],
            'top_industries' => [],
            'top_companies' => $topCompanies,
            'top_locations' => $topLocations,
            'event_labels' => $organization->events()->orderBy('created_at', 'desc')->limit(5)->pluck('title')->toArray(),
            'event_data' => $organization->events()->withCount('attendees')->orderBy('created_at', 'desc')->limit(5)->pluck('attendees_count')->toArray(),
        ];

        $html = view('organization.analytics-pdf', compact('organization', 'analytics'))->render();

        // Use wkhtmltopdf-based generation or fallback to browser print
        $filename = 'analytics_' . str_replace(' ', '_', $organization->name) . '_' . now()->format('Y-m-d') . '.pdf';
        
        // Try to use wkhtmltopdf if available, otherwise return HTML for browser PDF generation
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return $pdf->download($filename);
        }
        
        // Fallback: Return HTML with print stylesheet for browser PDF
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }
}

