<?php

namespace App\Http\Requests\JobVacancies;

use Illuminate\Foundation\Http\FormRequest;

class JobVacanciesUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string',
            'type' => 'sometimes|string|in:full_time,part_time,contract,remote,hybrid,other',
            'salary' => 'sometimes|numeric',
            'status' => 'sometimes|string|in:open,closed,pending',
            'technologies' => 'sometimes',
            'application_deadline' => 'sometimes|date|after_or_equal:today',
            'company_id' => 'sometimes|exists:companies,id',
            'categories' => 'sometimes|array|min:1',
            'categories.*' => 'exists:job_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'The job title cannot exceed 255 characters.',
            'title.string' => 'The job title must be a string.',
            'description.string' => 'The job description must be a string.',
            'location.string' => 'The job location must be a string.',
            'type.string' => 'The job type must be a string.',
            'salary.numeric' => 'The job salary must be a number.',
            'status.string' => 'The job status must be a string.',

            'application_deadline.date' => 'The job application deadline must be a date.',
            'company_id.exists' => 'The selected company is invalid.',
            'categories.array' => 'The job categories must be an array.',
            'categories.min' => 'At least one job category must be selected.',
            'categories.*.exists' => 'The selected category is invalid.',
        ];
    }
}
