<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition(): array
    {
        return [
            'category_id' => Categorie::factory(),
            'nom' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'numero_de_serie' => fake()->unique()->numberBetween(100000, 999999),
            'quantite_disponible' => fake()->numberBetween(1, 10),
            'etats' => 'Disponible',
        ];
    }
}
