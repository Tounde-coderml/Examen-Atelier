<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    //
    use HasFactory , HasUuids;

    protected $fillable = [
        'category_id',
        'nom',
        'description',
        'numero_de_serie',
        'quantite_disponible',
        'etats',

    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    public function emprunts(): HasMany
    {
        return $this->hasMany(Emprunt::class, 'material_id');
    }
}
