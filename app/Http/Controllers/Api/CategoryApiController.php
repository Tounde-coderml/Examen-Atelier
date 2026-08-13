<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Http\Resources\CategorieResource;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Categorie::query()->latest()->paginate(10);

        return CategorieResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieRequest $request)
    {
        //
        $data = $request->validated();

        $categorie = Categorie::create($data);

        $data = [
            'message' => 'Catégorie créée avec succès',
            'data' => new CategorieResource($categorie)
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
        $data = new CategorieResource($categorie);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCategorieRequest $request,
        Categorie $categorie
    ) {
        //
        $categorie->update($request->validated());

        $data = [
            'message' => 'Catégorie mise à jour avec succès',
            'data' => new CategorieResource($categorie->fresh())
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        //
        $categorie->delete();

        $data = [
            'message' => 'Catégorie supprimée avec succès'
        ];

        return response()->json($data);
    }
}