<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    //
    use HasFactory , HasUuids ;

    protected $fillable = [
            
            'utilisateur',
            'materiel',
            'Date_emprunt',
            'Date_prevue_de_retour',
            'Date_effective_de_retour'
    ];

}
