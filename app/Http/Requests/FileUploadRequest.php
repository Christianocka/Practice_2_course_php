<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            
            'files' => ['required', 'array'],
            'files.*' => ['file', 'max:2048'],
            'task_id' => ['required', 'exists:tasks,id'],
        ];
    }
}
