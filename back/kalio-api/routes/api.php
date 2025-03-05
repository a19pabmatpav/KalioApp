<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RepteController;

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']); // Obtener datos del usuario autenticado
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reptes', [RepteController::class, 'store']); // Crear o actualizar reto
    Route::post('/consum', [RepteController::class, 'registrarConsumDiari']); // Registrar consum diari
});
