<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmpruntRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'material_id' => ['required', 'uuid', 'exists:materials,id'],
            'Date_prevue_de_retour' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'material_id.required' => 'Le matériel est obligatoire.',
            'material_id.uuid' => "L'identifiant du matériel doit être un UUID valide.",
            'material_id.exists' => "Le matériel sélectionné n'existe pas.",
            'Date_prevue_de_retour.required' => ' la date du retour du matériel est obligatoire  ',
        ];
    }
}
