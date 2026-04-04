<?php

namespace App\Http\Requests\JobApplication;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,accepted,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status is required',
            'status.in' => 'Status must be pending, accepted, or rejected',
        ];
    }
}
