<?php

namespace App\Http\Controllers;

use App\Http\Requests\Companies\CompaniesCreateRequest;
use App\Http\Requests\Companies\CompaniesUpdateRequest;
use App\Models\Companies;
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
        return view('company.create');
    }

    public function store(CompaniesCreateRequest $request)
    {
        Companies::create($request->validated());

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
        $company->update([
            'name' => $request->name,
        ]);

        return redirect()->route('company.index')
            ->with('success', 'Company updated successfully');
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
