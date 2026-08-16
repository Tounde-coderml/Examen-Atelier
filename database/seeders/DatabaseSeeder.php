<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Emprunt;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrateur Atelier',
            'email' => 'admin@atelier.test',
            'role' => 'Administrateur',
            'status' => 'Active',
        ]);

        $employees = User::factory(10)->create(['role' => 'Employé', 'status' => 'Active']);
        $categories = Categorie::factory(5)->create();
        $materials = Material::factory(30)->recycle($categories)->create();

        Emprunt::factory(5)->recycle($employees)->recycle($materials)->create();
    }
}
