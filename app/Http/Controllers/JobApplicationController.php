<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplication\JobApplicationUpdateRequest;
use App\Models\JobApplications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isCompany = $user->role === 'company';

        $query = JobApplications::latest();

        if ($isCompany) {
            $query->whereHas('job', fn ($q) => $q->where('company_id', $user->company->id));
        } else {
            if ($request->input('archived') == 'true') {
                $query->onlyTrashed();
            }
        }

        $jobApplications = $query->with(['user', 'job'])->paginate(5)->onEachSide(1)->withQueryString();

        return view('job-application.index', compact('jobApplications', 'isCompany'));
    }

    public function edit(string $id)
    {
        $user = Auth::user();
        $isCompany = $user->role === 'company';

        $jobApplication = JobApplications::with(['user', 'job'])->findOrFail($id);

        if ($isCompany && $jobApplication->job->company_id !== $user->company->id) {
            abort(403);
        }

        return view('job-application.edit', compact('jobApplication'));
    }

    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = JobApplications::findOrFail($id);
        $validated = $request->validated();

        $jobApplication->update($validated);

        return redirect()->route('job-application.show', $id)
            ->with('success', 'Job Application updated successfully');
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $isCompany = $user->role === 'company';

        $jobApplication = JobApplications::with(['user', 'job', 'resume'])->findOrFail($id);

        if ($isCompany && $jobApplication->job->company_id !== $user->company->id) {
            abort(403);
        }

        return view('job-application.show', compact('jobApplication', 'isCompany'));
    }

    public function destroy(string $id)
    {
        $jobApplication = JobApplications::findOrFail($id);
        $jobApplication->job()->decrement('apply_count');
        $jobApplication->delete();

        return redirect()->route('job-application.index')
            ->with('success', 'Job Application archived successfully');
    }

    public function restore(string $id)
    {
        $jobApplication = JobApplications::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        $jobApplication->job()->increment('apply_count');

        return redirect()->route('job-application.index')
            ->with('success', 'Job Application restored successfully');
    }
}
