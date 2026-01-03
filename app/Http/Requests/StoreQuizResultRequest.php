<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow submission, but controller will check authentication
        return true;
    }

    public function rules(): array
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'nullable|in:a,b,c',
        ];
    }

    public function messages(): array
    {
        return [
            'answers.required' => 'Answers must be submitted',
            'answers.*.in' => 'Answer must be a, b, or c',
        ];
    }
}

