<?php

namespace App\Http\Requests\JobVacancies;

use Illuminate\Foundation\Http\FormRequest;

class JobVacanciesCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'type' => 'required|string|in:full_time,part_time,contract,remote,hybrid,other',
            'salary' => 'required|numeric',
            'status' => 'required|string|in:open,closed,pending',
            'technologies' => 'required',
            'application_deadline' => 'nullable|date|after_or_equal:today',
            'company_id' => 'required|exists:companies,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:job_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'title.max' => 'The job title cannot exceed 255 characters.',
            'title.string' => 'The job title must be a string.',
            'description.required' => 'The job description is required.',
            'description.string' => 'The job description must be a string.',
            'location.required' => 'The job location is required.',
            'location.string' => 'The job location must be a string.',
            'type.required' => 'The job type is required.',
            'type.string' => 'The job type must be a string.',
            'salary.required' => 'The job salary is required.',
            'salary.numeric' => 'The job salary must be a number.',
            'status.required' => 'The job status is required.',
            'status.string' => 'The job status must be a string.',
            'technologies.required' => 'The job technologies is required.',
            'application_deadline.required' => 'The job application deadline is required.',
            'application_deadline.date' => 'The job application deadline must be a date.',
            'application_deadline.after_or_equal' => 'The job application deadline must be a date after or equal to today.',
            'company_id.required' => 'The job company is required.',
            'company_id.exists' => 'The selected company is invalid.',
            'category_id.required' => 'The job category is required.',
            'category_id.exists' => 'The selected category is invalid.',
        ];
    }
}
