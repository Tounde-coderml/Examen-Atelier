<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([...$request->validated(), 'role' => 'Employé', 'status' => 'Active']);

        return response()->json([
            'message' => 'Utilisateur créé avec succès.',
            'token' => $user->createToken('atelier-api')->plainTextToken,
            'data' => new UserResource($user),
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Les identifiants sont invalides.',
            ], 422);
        }

        if ($user->status !== 'Active') {
            return response()->json(['message' => 'Ce compte est inactif.'], 403);
        }

        return response()->json([
            'message' => 'Connexion réussie.',
            'token' => $user->createToken('atelier-api')->plainTextToken,
            'data' => new UserResource($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }
}
