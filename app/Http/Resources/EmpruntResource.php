<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpruntResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'material_id' => $this->material_id,
            'Date_emprunt' => $this->Date_emprunt,
            'Date_prevue_de_retour' => $this->Date_prevue_de_retour,
            'Date_effective_de_retour' => $this->Date_effective_de_retour,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
