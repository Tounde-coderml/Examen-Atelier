<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Emprunt;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => [
                'utilisateurs' => User::count(),

                'categories' => Categorie::count(),

                'materiels' => Material::count(),

                'materiels_disponibles' => Material::where(
                    'etats',
                    'Disponible'
                )->count(),

                'materiels_en_maintenance' => Material::where(
                    'etats',
                    'En maintenance'
                )->count(),

                'materiels_hors_service' => Material::where(
                    'etats',
                    'Hors service'
                )->count(),

                'quantite_disponible' => Material::sum(
                    'quantite_disponible'
                ),

                'emprunts_en_cours' => Emprunt::where(
                    'status',
                    'En cours'
                )->count(),

                'emprunts_retournes' => Emprunt::where(
                    'status',
                    'Retourné'
                )->count(),

                'retours_en_retard' => Emprunt::query()
                    ->where('status', 'En cours')
                    ->whereDate(
                        'Date_prevue_de_retour',
                        '<',
                        today()
                    )
                    ->count(),
            ],
        ]);
    }
}