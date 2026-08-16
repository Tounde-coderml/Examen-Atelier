<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserApiController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::query()->latest()->paginate(10));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json(['data' => new UserResource($user->fresh())]);
    }

    public function destroy(User $user)
    {
        $user->tokens()->delete();
        $user->delete();

        return response()->noContent();
    }
}
