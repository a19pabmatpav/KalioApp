<?php

namespace App\Http\Controllers;

use App\Models\Logro;
use App\Models\User;
use Illuminate\Http\Request;

class LogroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * - Recibe:
     *   - `username` (string): Nombre del usuario enviado como parámetro de consulta.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Una lista de logros asignados al usuario.
     *   - Error 400 si no se proporciona el nombre de usuario.
     *   - Error 404 si el usuario no existe.
     */
    public function index(Request $request)
    {
        $username = $request->query('username');

        if (!$username) {
            return response()->json(['error' => 'Nombre de usuario no proporcionado'], 400);
        }

        $user = User::where('name', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Recuperar los logros asignados al usuario
        $logros = $user->logros()->withPivot('user_id')->get();

        return response()->json($logros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     * - Esta función no está implementada porque no se utiliza en una API REST.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * - Recibe:
     *   - Datos necesarios para crear un nuevo logro.
     *
     * @return void
     * - Esta función no está implementada.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Logro $logro
     * - Recibe:
     *   - `logro` (Logro): Instancia del modelo Logro.
     *
     * @return void
     * - Esta función no está implementada.
     */
    public function show(Logro $logro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Logro $logro
     * - Recibe:
     *   - `logro` (Logro): Instancia del modelo Logro.
     *
     * @return void
     * - Esta función no está implementada porque no se utiliza en una API REST.
     */
    public function edit(Logro $logro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * - Recibe:
     *   - `request` (Request): Datos para actualizar un logro.
     *   - `logro` (Logro): Instancia del modelo Logro a actualizar.
     *
     * @return void
     * - Esta función no está implementada.
     */
    public function update(Request $request, Logro $logro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Logro $logro
     * - Recibe:
     *   - `logro` (Logro): Instancia del modelo Logro a eliminar.
     *
     * @return void
     * - Esta función no está implementada.
     */
    public function destroy(Logro $logro)
    {
        //
    }

    /**
     * Asignar un logro a un usuario.
     *
     * @param Request $request
     * - Recibe:
     *   - `user_id` (integer): ID del usuario.
     *   - `logro_id` (integer): ID del logro.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Mensaje de éxito si el logro se asigna correctamente.
     *   - Error 400 si los datos no son válidos.
     */
    public function assignLogroToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'logro_id' => 'required|exists:logros,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $logro = Logro::findOrFail($request->logro_id);

        // Asignar el logro al usuario
        $user->logros()->attach($logro);

        return response()->json([
            'message' => 'Logro asignado al usuario correctamente.',
        ]);
    }

    /**
     * Obtener los logros de un usuario.
     *
     * @param int $userId
     * - Recibe:
     *   - `userId` (integer): ID del usuario.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Una lista de logros asignados al usuario.
     *   - Error 404 si el usuario no existe.
     */
    public function getUserLogros($userId)
    {
        $user = User::with('logros')->findOrFail($userId);

        return response()->json($user->logros);
    }
}
