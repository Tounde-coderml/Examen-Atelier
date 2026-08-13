<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

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
            'utilisateur'=>['required', 'string', 'max:100' ],
            'materiel' => ['required', 'uuid', 'exists:materiels,id'],
            'Date_prevue_de_retour'=>['required', 'string' ],
            'Date_effective_de_retour'=>['required', 'string' ],
        ];
    }

  
    public function messages():array
    {
        return [
            'utilisateur.required'=>"Entrez vôtre nom d'utilisateur ",
            'utilisateur.string'=>" vôtre nom doit être une chaine de caratères ",
            'materiel.required'=>" Entrez le nom du matériel a emprunter",
            'materiel.string'=>" vôtre matériel doit être chaine de caractère",
            'materiel.exists' => "Le matériel sélectionné n'existe pas.",
            'Date_prevue_de_retour.required'=>" la date du retour du matériel est obligatoire  ",

        ];
    }
}
