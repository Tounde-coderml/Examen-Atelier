<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterielRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'exists:categories,id'],
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'numero_de_serie' => ['required', 'string', 'max:255', 'unique:materials,numero_de_serie'],
            'quantite_disponible' => ['required', 'integer', 'min:0'],
            'etat' => ['required', 'in:Disponible,En maintenance,Hors service'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => "vous devriez choisir une catégorie",
            'category.string' => "La catégorie doit être une chaine de caractère",
            'category.exists' => "La catégorie sélectionnée n'existe pas.",

            'nom.required' => "Le nom du matériel est obligatoire.",
            'nom.string' => "Le nom doit être une chaîne de caractères.",
            'nom.max' => "Le nom ne doit pas dépasser 255 caractères.",

            'description.string' => "La description doit être une chaîne de caractères.",

            'numero_de_serie.required' => "Le numéro de série est obligatoire.",
            'numero_de_serie.string' => "Le numéro de série doit être une chaîne de caractères.",
            'numero_de_serie.max' => "Le numéro de série ne doit pas dépasser 255 caractères.",
            'numero_de_serie.unique' => "Ce numéro de série existe déjà.",

            'quantite_disponible.required' => "La quantité disponible est obligatoire.",
            'quantite_disponible.integer' => "La quantité disponible doit être un nombre entier.",
            'quantite_disponible.min' => "La quantité disponible ne peut pas être négative.",

            'etat.required' => "L'état du matériel est obligatoire.",
            'etat.in' => "L'état doit être : Disponible, En maintenance ou Hors service.",
        ];
    }
}
