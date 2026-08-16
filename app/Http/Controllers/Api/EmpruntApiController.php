<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnEmpruntRequest;
use App\Http\Requests\StoreEmpruntRequest;
use App\Http\Requests\UpdateEmpruntRequest;
use App\Http\Resources\EmpruntResource;
use App\Models\Emprunt;
use App\Models\Material;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $emprunt = DB::transaction(function () use ($request) {
            $data = $request->validated();
            $material = Material::query()->lockForUpdate()->findOrFail($data['material_id']);

            if ($material->quantite_disponible < 1) {
                throw ValidationException::withMessages([
                    'materiel' => 'Ce matériel est en rupture de stock.',
                ]);
            }

            if ($material->etats !== 'Disponible') {
                throw ValidationException::withMessages([
                    'materiel' => "Ce matériel n'est pas disponible à l'emprunt.",
                ]);
            }

            $emprunt = Emprunt::create([
                ...$data,
                'user_id' => $request->user()->uuid,
                'Date_emprunt' => now(),
                'status' => 'En cours',
            ]);

            $material->decrement('quantite_disponible');

            return $emprunt;
        });

        $data = [
            'message' => 'Emprunt créé avec succès',
            'data' => new EmpruntResource($emprunt),
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
            'data' => new EmpruntResource($emprunt->fresh()),
        ];

        return response()->json($data);
    }

    /**
     * Mark an emprunt as returned and restore one unit of stock.
     */
    public function retour(ReturnEmpruntRequest $request, Emprunt $emprunt)
    {
        $emprunt = DB::transaction(function () use ($request, $emprunt) {
            $emprunt = Emprunt::query()->lockForUpdate()->findOrFail($emprunt->id);

            if ($emprunt->status === 'Retourné') {
                throw ValidationException::withMessages([
                    'emprunt' => 'Cet emprunt a déjà été retourné.',
                ]);
            }

            $returnDate = $request->validated('Date_effective_de_retour') ?? now();

            if (Carbon::parse($returnDate)->lt(Carbon::parse($emprunt->Date_emprunt))) {
                throw ValidationException::withMessages([
                    'Date_effective_de_retour' => "La date de retour ne peut pas précéder la date d'emprunt.",
                ]);
            }

            $material = Material::query()->lockForUpdate()->findOrFail($emprunt->material_id);

            $emprunt->update([
                'status' => 'Retourné',
                'Date_effective_de_retour' => $returnDate,
            ]);

            $material->increment('quantite_disponible');

            return $emprunt->fresh();
        });

        return response()->json([
            'message' => 'Matériel retourné avec succès.',
            'data' => new EmpruntResource($emprunt),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emprunt $emprunt)
    {
        //
        $emprunt->delete();

        $data = [
            'message' => 'Emprunt supprimé avec succès',
        ];

        return response()->json($data);
    }
}
