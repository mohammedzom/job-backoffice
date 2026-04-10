<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancies\JobVacanciesCreateRequest;
use App\Http\Requests\JobVacancies\JobVacanciesUpdateRequest;
use App\Models\Companies;
use App\Models\JobCategory;
use App\Models\JobVacancies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacanciesController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancies::with('company')->latest();

        if (Auth::user()->role === 'company') {
            $query->where('company_id', Auth::user()->company->id);
        }

        if ($request->input('archived') === 'true') {
            $query->onlyTrashed();
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $jobVacancies = $query->paginate(10)->onEachSide(1)->withQueryString();
        $isAdmin = Auth::user()->role === 'admin';

        return view('job-vacancies.index', compact('jobVacancies', 'isAdmin'));
    }

    public function create()
    {
        $isCompany = Auth::user()->role === 'company';
        $categories = JobCategory::orderBy('name')->get();

        if ($isCompany) {
            $company = Auth::user()->company;

            return view('job-vacancies.create', compact('isCompany', 'categories', 'company'));
        }

        $companies = Companies::orderBy('name')->get();

        return view('job-vacancies.create', compact('isCompany', 'categories', 'companies'));
    }

    public function store(JobVacanciesCreateRequest $request)
    {
        $validated = $request->validated();

        $categories = $validated['categories'] ?? [];
        unset($validated['categories']);

        if (isset($validated['technologies'])) {
            $techs = is_array($validated['technologies']) ? $validated['technologies'] : explode(',', $validated['technologies']);
            $validated['technologies'] = array_values(array_filter(array_map('trim', $techs)));
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
        $isCompany = Auth::user()->role === 'company';
        $categories = JobCategory::orderBy('name')->get();

        if ($isCompany) {
            $company = Auth::user()->company;
            $jobVacancy = JobVacancies::where('company_id', $company->id)->findOrFail($id);

            return view('job-vacancies.edit', compact('isCompany', 'categories', 'company', 'jobVacancy'));
        }

        $companies = Companies::orderBy('name')->get();
        $jobVacancy = JobVacancies::findOrFail($id);

        return view('job-vacancies.edit', compact('isCompany', 'categories', 'companies', 'jobVacancy'));
    }

    public function update(JobVacanciesUpdateRequest $request, string $id)
    {
        $jobVacancy = JobVacancies::findOrFail($id);
        $validated = $request->validated();

        $categories = $validated['categories'] ?? [];
        unset($validated['categories']);

        if (isset($validated['technologies'])) {
            $techs = is_array($validated['technologies']) ? $validated['technologies'] : explode(',', $validated['technologies']);
            $validated['technologies'] = array_values(array_filter(array_map('trim', $techs)));
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
        $applyCount = $jobVacancy->applications()->whereNull('deleted_at')->count();
        $jobVacancy->decrement('apply_count', $applyCount);
        $jobVacancy->applications()->delete();
        $jobVacancy->delete();

        return redirect()->route('job-vacancy.index')
            ->with('success', 'Job Vacancy archived successfully');
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancies::withTrashed()->findOrFail($id);
        $deletedAt = $jobVacancy->deleted_at;
        $jobVacancy->restore();
        $trashedApplications = $jobVacancy->applications()->withTrashed()->get();

        foreach ($trashedApplications as $application) {
            if ($application->deleted_at && $application->deleted_at->diffInSeconds($deletedAt) <= 5) {
                $application->restore();
                $jobVacancy->increment('apply_count');
            }
        }

        return redirect()->route('job-vacancy.index', ['archived' => 'true'])
            ->with('success', 'Job Vacancy restored successfully');
    }
}
