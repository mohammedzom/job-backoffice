<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancies\JobVacanciesCreateRequest;
use App\Http\Requests\JobVacancies\JobVacanciesUpdateRequest;
use App\Models\Companies;
use App\Models\JobCategory;
use App\Models\JobVacancies;
use Illuminate\Http\Request;

class JobVacanciesController extends Controller
{
    public function index(Request $request)
    {
        // Active
        $query = JobVacancies::latest();

        // Archived
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }
        $jobVacancies = $query->paginate(5)->onEachSide(1)->withQueryString();

        return view('job-vacancies.index', compact('jobVacancies'));
    }

    public function create()
    {
        $companies = Companies::orderBy('name')->get();
        $categories = JobCategory::orderBy('name')->get();

        return view('job-vacancies.create', compact('companies', 'categories'));
    }

    public function store(JobVacanciesCreateRequest $request)
    {
        $validated = $request->validated();

        $categories = $validated['categories'] ?? [];
        unset($validated['categories']);

        if (isset($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        $jobVacancy = JobVacancies::create($validated);

        if (! empty($categories)) {
            $jobVacancy->categories()->syncWithoutDetaching($categories);
        }

        return redirect()->route('job-vacancy.index')
            ->with('success', __('Job Vacancy added successfully'));
    }

    public function edit(string $id)
    {
        $companies = Companies::orderBy('name')->get();
        $categories = JobCategory::orderBy('name')->get();
        $jobVacancy = JobVacancies::findOrFail($id);

        return view('job-vacancies.edit', compact('jobVacancy', 'companies', 'categories'));
    }

    public function update(JobVacanciesUpdateRequest $request, string $id)
    {
        $jobVacancy = JobVacancies::findOrFail($id);
        $validated = $request->validated();

        $categories = $validated['categories'] ?? [];
        unset($validated['categories']);

        if (isset($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        $jobVacancy->update($validated);

        if (! empty($categories)) {
            $jobVacancy->categories()->sync($categories);
        } else {
            $jobVacancy->categories()->detach();
        }

        return redirect()->route('job-vacancy.index')
            ->with('success', 'Job Vacancy updated successfully');
    }

    public function show(string $id)
    {
        $jobVacancy = JobVacancies::with(['company', 'categories'])->findOrFail($id);

        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function destroy(string $id)
    {
        $jobVacancy = JobVacancies::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('job-vacancy.index')
            ->with('success', 'Job Vacancy archived successfully');
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancies::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('job-vacancy.index', ['archived' => 'true'])
            ->with('success', 'Job Vacancy restored successfully');
    }
}
