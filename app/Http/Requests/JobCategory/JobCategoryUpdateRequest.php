<?php

namespace App\Http\Requests\JobCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobCategoryUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('job_categories', 'name')->ignore($this->route('job_category')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'Category name already exists',
            'name.max' => 'Category name must be less than 255 characters',
            'name.string' => 'Category name must be a string',
        ];
    }
}
