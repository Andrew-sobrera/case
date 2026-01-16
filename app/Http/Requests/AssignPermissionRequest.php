<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permission_id' => ['required', 'integer', 'exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'permission_id.required' => 'The permission ID field is required',
            'permission_id.integer' => 'The permission ID must be an integer',
            'permission_id.exists' => 'The permission does not exist',
        ];
    }
}
