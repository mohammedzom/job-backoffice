<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CompaniesUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Auth::user()->role === 'company' ? Rule::unique('companies', 'name')->ignore(Auth::user()->company->id) : Rule::unique('companies', 'name')->ignore($this->route('company')),
            ],
            'address' => 'sometimes|string|max:255',
            'industry' => 'sometimes|string|max:255|in:Technology,Healthcare,Finance,Education,Retail,Manufacturing,Other',
            'website' => 'sometimes|string|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Company name must be a string',
            'name.max' => 'Company name must be less than 255 characters',
            'name.unique' => 'The company name has already been taken',
            'address.string' => 'Company address must be a string',
            'address.max' => 'Company address must be less than 255 characters',
            'industry.string' => 'Company industry must be a string',
            'industry.max' => 'Company industry must be less than 255 characters',
            'industry.in' => 'Company industry must be one of the following: Technology, Healthcare, Finance, Education, Retail, Manufacturing, Other',
            'website.string' => 'Company website must be a string',
            'website.max' => 'Company website must be less than 255 characters',
            'website.url' => 'Company website must be a valid URL',
        ];
    }
}
