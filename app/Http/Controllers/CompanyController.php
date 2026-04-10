<?php

namespace App\Http\Controllers;

use App\Http\Requests\Companies\CompaniesCreateRequest;
use App\Http\Requests\Companies\CompaniesUpdateRequest;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Companies::latest();

        if ($request->input('archived') === 'true') {
            $query->onlyTrashed();
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('industry', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $companies = $query->paginate(10)->onEachSide(1)->withQueryString();

        return view('company.index', compact('companies'));
    }

    public function create()
    {
        $industries = ['Technology', 'Healthcare', 'Finance', 'Education', 'Retail', 'Manufacturing', 'Other'];

        return view('company.create', compact('industries'));
    }

    public function store(CompaniesCreateRequest $request)
    {
        $owner = User::create([
            'name' => $request->owner_name,
            'email' => $request->owner_email,
            'password' => $request->owner_password,
            'role' => 'company',
        ]);
        if (! $owner) {
            return redirect()->route('company.create')
                ->with('error', __('Failed to create company owner'));
        }
        $company = Companies::create([
            'name' => $request->name,
            'industry' => $request->industry,
            'website' => $request->website,
            'address' => $request->address,
            'owner_id' => $owner->id,
        ]);
        if (! $company) {
            return redirect()->route('company.create')
                ->with('error', __('Failed to create company'));
        }

        return redirect()->route('company.index')
            ->with('success', __('Company added successfully'));
    }

    public function edit(?string $id = null)
    {
        if (Auth::user()->role === 'company') {
            $company = Auth::user()->company()->first();
        } else {
            $company = Companies::findOrFail($id);
        }
        $industries = ['Technology', 'Healthcare', 'Finance', 'Education', 'Retail', 'Manufacturing', 'Other'];

        return view('company.edit', compact('company', 'industries'));
    }

    public function update(CompaniesUpdateRequest $request, ?string $id = null)
    {
        if (Auth::user()->role === 'company') {
            $company = Auth::user()->company()->first();
        } else {
            $company = Companies::findOrFail($id);
        }
        $company->update($request->validated());

        if (Auth::user()->role === 'company') {
            return redirect()->route('my-company.show')
                ->with('success', 'Company updated successfully');
        } else {
            return redirect()->route('company.index')
                ->with('success', 'Company updated successfully');
        }
    }

    public function show(?string $id = null)
    {
        if (Auth::user()->role === 'company') {
            $company = Auth::user()->company()->with(['jobs.applications.user', 'jobs.applications.job'])->first();
        } else {
            if ($id === null) {
                return redirect()->route('company.index')
                    ->with('error', __('Company not found'));
            }
            $company = Companies::with(['jobs.applications.user', 'jobs.applications.job'])->findOrFail($id);
        }

        return view('company.show', compact('company'));
    }

    public function destroy(string $id)
    {
        $company = Companies::findOrFail($id);

        if ($company->owner()->exists()) {
            $company->owner()->delete();
        }

        foreach ($company->jobs as $job) {
            $job->applications()->delete();
            $job->delete();
        }

        $company->delete();

        return redirect()->route('company.index')
            ->with('success', 'Company deleted successfully');
    }

    public function restore(string $id)
    {
        $company = Companies::withTrashed()->findOrFail($id);

        $deletedAt = $company->deleted_at;

        $company->restore();

        if ($company->owner()->withTrashed()->exists()) {
            $company->owner()->withTrashed()->restore();
        }

        $trashedJobs = $company->jobs()->withTrashed()->get();

        foreach ($trashedJobs as $job) {
            if ($job->deleted_at && $job->deleted_at->diffInSeconds($deletedAt) <= 5) {

                $trashedApplications = $job->applications()->withTrashed()->get();

                foreach ($trashedApplications as $application) {
                    if ($application->deleted_at && $application->deleted_at->diffInSeconds($deletedAt) <= 5) {
                        $application->restore();
                    }
                }
                $job->restore();
            }
        }

        return redirect()->route('company.index', ['archived' => 'true'])
            ->with('success', 'Company restored successfully');
    }
}
