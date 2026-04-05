<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * Get all jobs with filters
     */
    public function index(Request $request)
    {
        $query = Job::with('postedBy')->active();

        // Filters
        if ($request->has('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        if ($request->has('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        if ($request->has('is_remote')) {
            $query->where('is_remote', $request->boolean('is_remote'));
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        $perPage = $request->get('per_page', 15);
        $jobs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $jobs
        ]);
    }

    /**
     * Get single job
     */
    public function show($id)
    {
        $job = Job::with(['postedBy', 'applications'])->findOrFail($id);
        $job->incrementViews();

        return response()->json([
            'success' => true,
            'data' => $job
        ]);
    }

    /**
     * Create new job
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'experience_level' => 'required|in:entry,mid,senior,lead',
            'location' => 'required|string',
            'is_remote' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $job = Job::create([
            'posted_by' => $request->user()->id,
            ...$request->all()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job posted successfully',
            'data' => $job
        ], 201);
    }

    /**
     * Update job
     */
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        // Check authorization
        if ($job->posted_by !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $job->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Job updated successfully',
            'data' => $job
        ]);
    }

    /**
     * Delete job
     */
    public function destroy(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if ($job->posted_by !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job deleted successfully'
        ]);
    }

    /**
     * Apply for a job
     */
    public function apply(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'cover_letter' => 'nullable|string',
            'resume_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if already applied
        $existingApplication = JobApplication::where('job_id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied for this job'
            ], 400);
        }

        $application = JobApplication::create([
            'job_id' => $id,
            'user_id' => $request->user()->id,
            'cover_letter' => $request->cover_letter,
            'resume_url' => $request->resume_url,
            'portfolio_url' => $request->portfolio_url,
        ]);

        $job->incrementApplications();

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully',
            'data' => $application
        ], 201);
    }

    /**
     * Get user's job applications
     */
    public function myApplications(Request $request)
    {
        $applications = JobApplication::with('job')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $applications
        ]);
    }

    /**
     * Get applications for a job (job poster only)
     */
    public function jobApplications(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if ($job->posted_by !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $applications = JobApplication::with('user')
            ->where('job_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $applications
        ]);
    }
}
