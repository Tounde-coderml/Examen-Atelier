<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    use HasFactory , HasUuids ;

    protected $fillable = [
               'category',
               'nom',
               'description',
               'numero_de_serie',
               'quantite_disponible',
               'etats'
            
    ];

}
