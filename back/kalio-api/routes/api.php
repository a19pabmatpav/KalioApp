<?php
use App\Http\Controllers\HistoricController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RepteController;
use App\Http\Controllers\ConsumDiariController;
use App\Http\Controllers\LogroController;


// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']); // Obtener datos del usuario autenticado
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reptes', [RepteController::class, 'store']); // Crear o actualizar reto
    Route::delete('/reptes/{id}', [RepteController::class, 'destroy']); // Eliminar reto
    Route::get('/consumit', [ConsumDiariController::class, 'index']); // Obtener consums diaris
    Route::post('/logros/assign', [LogroController::class, 'assignLogroToUser']);
    Route::get('/logros/{username}', [LogroController::class, 'index']);
});
Route::get('/consums/{repte_id}', [ConsumDiariController::class, 'show']); // Obtener consums diaris de un usuario

Route::post('/addConsum', [ConsumDiariController::class, 'store']); // Registrar consum diari
Route::get('/historic', [HistoricController::class, 'index']); // Obtener histórico de consums diaris
Route::get('/historic/{id}', [HistoricController::class, 'show']); // Obtener histórico de consums diaris de un usuario


//Route::get('/users/{userId}/logros', [LogroController::class, 'getUserLogros']);
