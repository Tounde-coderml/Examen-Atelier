<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpruntRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Date_prevue_de_retour' => ['sometimes', 'required', 'date'],
            'material_id' => ['prohibited'],
            'Date_emprunt' => ['prohibited'],
            'Date_effective_de_retour' => ['prohibited'],
            'status' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'Date_prevue_de_retour.required' => 'La date prévue de retour est obligatoire.',
            'Date_prevue_de_retour.date' => 'La date prévue de retour doit être une date valide.',
            'material_id.prohibited' => "Le matériel d'un emprunt ne peut pas être modifié.",
            'Date_emprunt.prohibited' => "La date d'emprunt ne peut pas être modifiée.",
            'Date_effective_de_retour.prohibited' => 'Utilisez la route de retour pour renseigner cette date.',
            'status.prohibited' => 'Utilisez la route de retour pour modifier le statut.',
        ];
    }
}
