<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategory\JobCategoryCreateRequest;
use App\Http\Requests\JobCategory\JobCategoryUpdateRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Active
        $query = JobCategory::latest();

        // Archived
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }
        $jobCategories = $query->paginate(5)->onEachSide(1)->withQueryString();

        return view('job-category.index', compact('jobCategories'));
    }

    public function create()
    {
        return view('job-category.create');
    }

    public function store(JobCategoryCreateRequest $request)
    {
        JobCategory::create($request->validated());

        return redirect()->route('job-category.index')
            ->with('success', __('Job Category added successfully'));
    }

    public function edit(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);

        return view('job-category.edit', compact('jobCategory'));
    }

    public function update(JobCategoryUpdateRequest $request, string $id)
    {

        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('job-category.index')
            ->with('success', 'Job Category updated successfully');
    }

    public function destroy(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->delete();

        return redirect()->route('job-category.index')
            ->with('success', 'Job Category deleted successfully');
    }

    public function restore(string $id)
    {
        $jobCategory = JobCategory::withTrashed()->findOrFail($id);
        $jobCategory->restore();

        return redirect()->route('job-category.index', ['archived' => 'true'])
            ->with('success', 'Job Category restored successfully');
    }
}
