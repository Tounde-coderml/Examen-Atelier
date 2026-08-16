<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnEmpruntRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Date_effective_de_retour' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'Date_effective_de_retour.date' => 'La date effective de retour doit être une date valide.',
        ];
    }
}
