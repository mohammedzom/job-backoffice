<?php

namespace App\Http\Controllers;

use App\Http\Requests\Companies\CompaniesCreateRequest;
use App\Http\Requests\Companies\CompaniesUpdateRequest;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

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
        return view('company.create');
    }

    public function store(CompaniesCreateRequest $request)
    {
        Companies::create([
            'name' => $request->name,
            'industry' => $request->industry,
            'website' => $request->website,
            'address' => $request->address,
            'owner_id' => FacadesAuth::id(),
        ]);

        return redirect()->route('company.index')
            ->with('success', __('Company added successfully'));
    }

    public function edit(string $id)
    {
        $company = Companies::findOrFail($id);

        return view('company.edit', compact('company'));
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
