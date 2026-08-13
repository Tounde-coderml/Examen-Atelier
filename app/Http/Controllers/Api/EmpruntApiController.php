<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmpruntRequest;
use App\Http\Requests\UpdateEmpruntRequest;
use App\Http\Resources\EmpruntResource;
use App\Models\Emprunt;
use Illuminate\Http\Request;

class EmpruntApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $emprunts = Emprunt::query()->latest()->paginate(10);

        return EmpruntResource::collection($emprunts);
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

        $data = [
            'message' => 'Emprunt créé avec succès',
            'data' => new EmpruntResource($emprunt)
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Emprunt $emprunt)
    {
        //
        $data = new EmpruntResource($emprunt);

        return response()->json($data);
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

        $data = [
            'message' => 'Emprunt mis à jour avec succès',
            'data' => new EmpruntResource($emprunt->fresh())
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emprunt $emprunt)
    {
        //
        $emprunt->delete();

        $data = [
            'message' => 'Emprunt supprimé avec succès'
        ];

        return response()->json($data);
    }
}