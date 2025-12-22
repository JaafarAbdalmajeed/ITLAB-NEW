<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $trackId = $this->route('track')->id ?? null;
        
        return [
            'slug' => 'required|string|max:255|unique:tracks,slug,' . $trackId,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}

