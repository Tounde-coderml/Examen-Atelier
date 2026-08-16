<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Categorie;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Categorie::query()->latest()->paginate(10);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        $data = $request->validated();

        $categorie = Categorie::create($data);

        $data = [
            'message' => 'Catégorie créée avec succès',
            'data' => new CategoryResource($categorie),
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
        $data = new CategoryResource($categorie);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCategoryRequest $request,
        Categorie $categorie
    ) {
        //
        $categorie->update($request->validated());

        $data = [
            'message' => 'Catégorie mise à jour avec succès',
            'data' => new CategoryResource($categorie->fresh()),
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
            'message' => 'Catégorie supprimée avec succès',
        ];

        return response()->json($data);
    }
}
