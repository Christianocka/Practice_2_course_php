<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'min:1', 'max:255'],
            'priority' => ['nullable', 'integer', 'min:1'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
        ];
    }
}
