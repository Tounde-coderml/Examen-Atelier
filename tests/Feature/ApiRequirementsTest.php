<?php

namespace Tests\Feature;

use App\Models\Categorie;
use App\Models\Emprunt;
use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRequirementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authentication_flow_for_active_user(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Alice Admin',
            'email' => 'alice@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.email', 'alice@example.com')
            ->assertJsonStructure(['token', 'data']);

        $token = $response->json('token');

        $this->withToken($token)
            ->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('email', 'alice@example.com');

        $this->withToken($token)
            ->postJson('/api/logout')
            ->assertOk()
            ->assertJsonPath('message', 'Déconnexion réussie.');
    }

    public function test_inactive_user_cannot_access_protected_routes(): void
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'status' => 'Inactive',
            'role' => 'Employé',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/dashboard')
            ->assertStatus(403)
            ->assertJsonPath('message', 'Ce compte est inactif.');
    }

    public function test_material_can_be_created_updated_and_deleted(): void
    {
        $admin = User::factory()->create([
            'role' => 'Administrateur',
            'status' => 'Active',
        ]);

        $category = Categorie::factory()->create();

        $createResponse = $this->actingAs($admin, 'sanctum')->postJson('/api/materiels', [
            'category_id' => $category->id,
            'nom' => 'Laptop Dell',
            'description' => 'Ordinateur portable pour dev',
            'numero_de_serie' => 123456,
            'quantite_disponible' => 3,
            'etats' => 'Disponible',
        ]);

        $createResponse->assertStatus(201)
            ->assertJsonPath('data.nom', 'Laptop Dell');

        $material = Material::query()->first();

        $this->actingAs($admin, 'sanctum')->patchJson('/api/materiels/'.$material->id, [
            'category_id' => $category->id,
            'nom' => 'Laptop Dell Pro',
            'description' => 'Ordinateur portable mise à jour',
            'numero_de_serie' => 123457,
            'quantite_disponible' => 5,
            'etats' => 'Disponible',
        ])->assertOk()->assertJsonPath('data.nom', 'Laptop Dell Pro');

        $this->actingAs($admin, 'sanctum')->deleteJson('/api/materiels/'.$material->id)
            ->assertOk()
            ->assertJsonPath('message', 'Matériel supprimé avec succès');
    }

    public function test_emprunt_can_be_created_and_returned(): void
    {
        $user = User::factory()->create([
            'role' => 'Employé',
            'status' => 'Active',
        ]);

        $category = Categorie::factory()->create();
        $material = Material::factory()->create([
            'category_id' => $category->id,
            'quantite_disponible' => 1,
            'etats' => 'Disponible',
        ]);

        $createResponse = $this->actingAs($user, 'sanctum')->postJson('/api/emprunts', [
            'material_id' => $material->id,
            'Date_prevue_de_retour' => now()->addDays(7)->toDateString(),
        ]);

        $createResponse->assertStatus(201)
            ->assertJsonPath('data.status', 'En cours');

        $material->refresh();
        $this->assertSame(0, $material->quantite_disponible);

        $emprunt = Emprunt::query()->first();

        $returnResponse = $this->actingAs($user, 'sanctum')->patchJson('/api/emprunts/'.$emprunt->id.'/retour', [
            'Date_effective_de_retour' => now()->addDays(2)->toDateString(),
        ]);

        $returnResponse->assertOk()->assertJsonPath('data.status', 'Retourné');

        $material->refresh();
        $this->assertSame(1, $material->quantite_disponible);
    }
}
