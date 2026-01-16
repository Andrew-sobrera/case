<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logradouro' => ['sometimes', 'string', 'max:255'],
            'numero' => ['sometimes', 'string', 'max:20'],
            'bairro' => ['sometimes', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'cep' => ['sometimes', 'string', 'regex:/^\d{5}-?\d{3}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'logradouro.max' => 'The street must not exceed 255 characters',
            'numero.max' => 'The number must not exceed 20 characters',
            'bairro.max' => 'The neighborhood must not exceed 255 characters',
            'complemento.max' => 'The complement must not exceed 255 characters',
            'cep.regex' => 'The zip code must be in the format 00000-000',
        ];
    }
}
