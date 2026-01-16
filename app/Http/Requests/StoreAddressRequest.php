<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'bairro' => ['required', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'cep' => ['required', 'string', 'regex:/^\d{5}-?\d{3}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID field is required',
            'user_id.integer' => 'The user ID must be an integer',
            'user_id.exists' => 'The user does not exist',
            'logradouro.required' => 'The street field is required',
            'logradouro.max' => 'The street must not exceed 255 characters',
            'numero.required' => 'The number field is required',
            'numero.max' => 'The number must not exceed 20 characters',
            'bairro.required' => 'The neighborhood field is required',
            'bairro.max' => 'The neighborhood must not exceed 255 characters',
            'complemento.max' => 'The complement must not exceed 255 characters',
            'cep.required' => 'The zip code field is required',
            'cep.regex' => 'The zip code must be in the format 00000-000',
        ];
    }
}
