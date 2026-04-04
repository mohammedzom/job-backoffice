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
            'industry' => 'required|string|max:255|in:Technology,Healthcare,Finance,Education,Retail,Manufacturing,Other',
            'website' => 'nullable|string|url|max:255',

            // owner
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|string|email|max:255|unique:users,email',
            'owner_password' => 'required|string|min:8',

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
            'industry.in' => 'Company industry must be one of the following: Technology, Healthcare, Finance, Education, Retail, Manufacturing, Other',
            'website.string' => 'Company website must be a string',
            'website.max' => 'Company website must be less than 255 characters',
            'website.url' => 'Company website must be a valid URL',

            // owner
            'owner_name.required' => 'Owner name is required',
            'owner_name.string' => 'Owner name must be a string',
            'owner_name.max' => 'Owner name must be less than 255 characters',
            'owner_email.required' => 'Owner email is required',
            'owner_email.string' => 'Owner email must be a string',
            'owner_email.email' => 'Owner email must be a valid email',
            'owner_email.max' => 'Owner email must be less than 255 characters',
            'owner_email.unique' => 'Owner email has already been taken',
            'owner_password.required' => 'Owner password is required',
            'owner_password.string' => 'Owner password must be a string',
            'owner_password.min' => 'Owner password must be at least 8 characters',
        ];
    }
}
