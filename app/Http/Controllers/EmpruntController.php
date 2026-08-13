<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpruntRequest;
use App\Http\Requests\UpdateEmpruntRequest;
use App\Models\Emprunt;
use Illuminate\Http\Request;

class EmpruntController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $emprunts = Emprunt::query()->latest()->paginate(10);

        return response()->json($emprunts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpruntRequest $request)
    {
        //
        $data = $request->validated();

        $data['Date_emprunt'] = $data['Date_emprunt'] ?? now();

        $emprunt = Emprunt::create($data);

        return response()->json([
            'message' => 'Emprunt créé avec succès',
            'data' => $emprunt
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Emprunt $emprunt)
    {
        //
        return response()->json([
            'data' => $emprunt
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEmpruntRequest $request,
        Emprunt $emprunt
    ) {
        //
        $emprunt->update($request->validated());

        return response()->json([
            'message' => 'Emprunt mis à jour avec succès',
            'data' => $emprunt->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emprunt $emprunt)
    {
        //
        $emprunt->delete();

        return response()->json([
            'message' => 'Emprunt supprimé avec succès'
        ]);
    }
}