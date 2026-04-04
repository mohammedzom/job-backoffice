<?php

namespace App\Http\Controllers;

use App\Http\Requests\Companies\CompaniesCreateRequest;
use App\Http\Requests\Companies\CompaniesUpdateRequest;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        // Active
        $query = Companies::latest();

        // Archived
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }
        $companies = $query->paginate(5)->onEachSide(1)->withQueryString();

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

    public function edit(string $id)
    {
        $company = Companies::findOrFail($id);
        $industries = ['Technology', 'Healthcare', 'Finance', 'Education', 'Retail', 'Manufacturing', 'Other'];

        return view('company.edit', compact('company', 'industries'));
    }

    public function update(CompaniesUpdateRequest $request, string $id)
    {
        $company = Companies::findOrFail($id);
        $company->update($request->validated());

        return redirect()->route('company.index')
            ->with('success', 'Company updated successfully');
    }

    public function show(string $id)
    {
        $company = Companies::with(['jobs.applications.user', 'jobs.applications.job'])->findOrFail($id);

        return view('company.show', compact('company'));
    }

    public function destroy(string $id)
    {
        $company = Companies::findOrFail($id);
        $company->delete();

        return redirect()->route('company.index')
            ->with('success', 'Company deleted successfully');
    }

    public function restore(string $id)
    {
        $company = Companies::withTrashed()->findOrFail($id);
        $company->restore();

        return redirect()->route('company.index', ['archived' => 'true'])
            ->with('success', 'Company restored successfully');
    }
}
