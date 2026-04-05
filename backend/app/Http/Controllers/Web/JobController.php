<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('company', 'like', "%$search%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', $request->input('location'));
        }

        $jobs = $query->latest()->paginate(20);
        return view('jobs.index', compact('jobs'));
    }

    public function create(): View
    {
        return view('jobs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
        ]);

        $validated['posted_by'] = auth()->id();
        $validated['status'] = 'active';

        Job::create($validated);
        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }

    public function show(Job $job): View
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job): View
    {
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
        ]);

        $job->update($validated);
        return redirect()->route('jobs.show', $job)->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $this->authorize('delete', $job);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }

    public function apply(Request $request, Job $job): RedirectResponse
    {
        $request->validate([
            'cover_letter' => 'required|string',
        ]);

        JobApplication::updateOrCreate(
            ['job_id' => $job->id, 'applicant_id' => auth()->id()],
            ['cover_letter' => $request->input('cover_letter'), 'status' => 'pending']
        );

        return back()->with('success', 'Application submitted successfully!');
    }

    public function applications(Job $job): View
    {
        $this->authorize('update', $job);
        $applications = $job->applications()->with('applicant')->paginate(20);
        return view('jobs.applications', compact('job', 'applications'));
    }

    public function updateApplicationStatus(Request $request, Job $job, JobApplication $application): RedirectResponse
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application->update($validated);
        return back()->with('success', 'Application status updated!');
    }
}
