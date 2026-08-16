<?php

namespace Database\Factories;

use App\Models\Emprunt;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpruntFactory extends Factory
{
    protected $model = Emprunt::class;

    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-20 days', '-2 days');

        return [
            'user_id' => User::factory(),
            'material_id' => Material::factory(),
            'Date_emprunt' => $date,
            'Date_prevue_de_retour' => fake()->dateTimeBetween($date, '+10 days'),
            'Date_effective_de_retour' => null,
            'status' => 'En cours',
        ];
    }
}
