<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'cpf' => ['sometimes', 'required', 'cpf', Rule::unique('users', 'cpf')->ignore($userId)],
            'telefone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required',
            'name.max' => 'The name must not exceed 255 characters',
            'email.required' => 'The email field is required',
            'email.email' => 'The email must be a valid address',
            'email.unique' => 'This email is already registered',
            'cpf.required' => 'The CPF field is required',
            'cpf.cpf' => 'The CPF is invalid',
            'cpf.unique' => 'This CPF is already registered',
            'telefone.max' => 'The phone must not exceed 20 characters',
            'password.min' => 'The password must be at least 6 characters',
            'password.confirmed' => 'The password confirmation does not match',
        ];
    }
}
