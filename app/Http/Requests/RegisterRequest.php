<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Entrez vôtre nom',
            'name.string' => 'Le nom doit être une chaine de caractère',
            'name.max' => 'le nom ne doit pas dépasser 100 ',
            'email.required' => 'Entrez votre email',
            'email.string' => "l'email doit être une chaine de caractère",
            'email.email' => " l'email doit être une addresse email valide",
            'email.max' => "l'email ne doit pas dépasser 100 caractères",
            'email.unique' => 'vôtre email a déjà été enrégistrer',
            'password.required' => 'mot de passe invalide',
            'password.string' => 'le mot de passe doit être une chaine de caractère',
            'password.min' => 'le mot de passe doit contenir au moins 8 caractères ',
            'password.confirmed' => ' mot de passe doit être identique',
        ];
    }

    public function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'les données sont invalides',
                'errors' => $validator->errors(),
            ])
        );
    }
}
