<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow if user is updating their own progress or is admin
        $userId = $this->input('user_id');
        return auth()->check() && (auth()->id() == $userId || auth()->user()->is_admin);
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'progress_percent' => 'required|integer|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required',
            'user_id.exists' => 'User does not exist',
            'progress_percent.required' => 'Progress percentage is required',
            'progress_percent.min' => 'Progress percentage must be 0 or more',
            'progress_percent.max' => 'Progress percentage must be 100 or less',
        ];
    }
}

