<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Categorie::query()->latest()->paginate(10);

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieRequest $request)
    {
        //
        $data = $request->validated();

        $categorie = Categorie::create($data);

        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'data' => $categorie
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
        return response()->json([
            'data' => $categorie
        ]);
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

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'data' => $categorie->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        //
        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ]);
    }
}