<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\EmpruntApiController;
use App\Http\Controllers\Api\MaterialApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware(['auth:sanctum', 'active'])->group(function (): void {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::apiResource('categories', CategoryApiController::class);
    Route::apiResource('materiels', MaterialApiController::class);
    Route::patch('/emprunts/{emprunt}/retour', [EmpruntApiController::class, 'retour']);
    Route::apiResource('emprunts', EmpruntApiController::class);
    Route::apiResource('users', UserApiController::class)->only(['index', 'show', 'update', 'destroy'])->middleware('admin');
});
