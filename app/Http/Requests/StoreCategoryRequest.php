<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class StoreCategoryRequest extends FormRequest
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
            //
            'name'=>['required', 'string', 'max:100' ],
            'description'=>['required', 'string', 'max:255' ],

            
        ];
    }

  
    public function messages():array
    {
        return [
            'name.required'=>'Entrez vôtre nom',
            'name.string'=>'Le nom doit être une chaine de caractère',
            'name.max'=>'le nom ne doit pas dépasser 100 ',
            'description.required'=>' la descrittion est obligatoire',
            'description.string'=>'La description doit être une chain de caractère doit être une chaine de caractère',
            'description.max'=>'la description ne doit pas dépasser 100 '
        ];
    }

   public function failedValidation(Validator $validator){
        throw new HttpResponseException(
            response()->json([
                'message'=>'les données pour la catégorie sont invalides',
                'errors'=>$validator->errors(),
            ])
        );
    }
}
