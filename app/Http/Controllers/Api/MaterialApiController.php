<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterielRequest;
use App\Http\Requests\UpdateMaterielRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Material::query();

        // Recherche par nom ou numéro de série
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%'.$search.'%')
                    ->orWhere('numero_de_serie', 'like', '%'.$search.'%');
            });
        }

        // Filtrage par catégorie
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Pagination
        $materials = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return MaterialResource::collection($materials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterielRequest $request)
    {
        $data = $request->validated();

        $material = Material::create($data);

        $data = [
            'message' => 'Matériel créé avec succès',
            'data' => new MaterialResource($material),
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $materiel)
    {
        $data = new MaterialResource($materiel);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateMaterielRequest $request,
        Material $materiel
    ) {
        $materiel->update($request->validated());

        $data = [
            'message' => 'Matériel mis à jour avec succès',
            'data' => new MaterialResource($materiel->fresh()),
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $materiel)
    {
        $materiel->delete();

        $data = [
            'message' => 'Matériel supprimé avec succès',
        ];

        return response()->json($data);
    }
}
