<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required',
            'name.string' => 'Company name must be a string',
            'name.max' => 'Company name must be less than 255 characters',
            'name.unique' => 'The company name has already been taken',
            'address.required' => 'Company address is required',
            'address.string' => 'Company address must be a string',
            'address.max' => 'Company address must be less than 255 characters',
            'industry.required' => 'Company industry is required',
            'industry.string' => 'Company industry must be a string',
            'industry.max' => 'Company industry must be less than 255 characters',
            'website.string' => 'Company website must be a string',
            'website.max' => 'Company website must be less than 255 characters',
            'website.url' => 'Company website must be a valid URL',
        ];
    }
}
