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
            'user_id.required' => 'معرف المستخدم مطلوب',
            'user_id.exists' => 'المستخدم غير موجود',
            'progress_percent.required' => 'نسبة التقدم مطلوبة',
            'progress_percent.min' => 'نسبة التقدم يجب أن تكون 0 أو أكثر',
            'progress_percent.max' => 'نسبة التقدم يجب أن تكون 100 أو أقل',
        ];
    }
}

