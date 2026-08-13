<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Material::query();

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('numero_de_serie', 'like', '%' . $search . '%');
            });
        }

        // Filtrage par catégorie
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Pagination
        $materials = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return response()->json($materials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialRequest $request)
    {
        $data = $request->validated();

        $material = Material::create($data);

        return response()->json([
            'message' => 'Matériel créé avec succès',
            'data' => $material
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return response()->json([
            'data' => $material
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateMaterialRequest $request,
        Material $material
    ) {
        $material->update($request->validated());

        return response()->json([
            'message' => 'Matériel mis à jour avec succès',
            'data' => $material->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return response()->json([
            'message' => 'Matériel supprimé avec succès'
        ]);
    }
}