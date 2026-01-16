<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required',
            'name.max' => 'The name must not exceed 255 characters',
            'name.unique' => 'This permission name already exists',
            'description.max' => 'The description must not exceed 500 characters',
        ];
    }
}
