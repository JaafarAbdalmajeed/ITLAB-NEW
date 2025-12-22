<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => 'required|string|max:255|unique:tracks,slug',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.required' => 'الرابط (Slug) مطلوب',
            'slug.unique' => 'هذا الرابط مستخدم بالفعل',
            'title.required' => 'العنوان مطلوب',
        ];
    }
}

