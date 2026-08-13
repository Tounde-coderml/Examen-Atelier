<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'category'=>$this->category,
            'nom'=>$this->nom,
            'description'=>$this->description,
            'numero_de_serie'=>$this->numero_de_serie,
            'quantite_disponible'=>$this->quantite_disponible,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}



           
               