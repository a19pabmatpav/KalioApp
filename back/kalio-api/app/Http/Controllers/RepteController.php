<?php
namespace App\Http\Controllers;

use App\Models\Repte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ConsumDiari;

class RepteController extends Controller
{
    /**
     * Mostrar todos los retos del usuario logueado.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Una lista de retos asociados al usuario autenticado.
     */
    public function index()
    {
        $reptes = Auth::user()->reptes; // Relación con el usuario
        return response()->json($reptes);
    }

    /**
     * Crear o actualizar un reto para el usuario autenticado.
     *
     * @param Request $request
     * - Recibe:
     *   - `nom` (string): Nombre del reto.
     *   - `data_inici` (date): Fecha de inicio del reto.
     *   - `data_fi` (date): Fecha de finalización del reto (debe ser posterior a `data_inici`).
     *   - `limit_calories_diari` (integer): Límite diario de calorías.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Mensaje de éxito.
     *   - Detalles del reto creado o actualizado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'data_inici' => 'required|date',
            'data_fi' => 'required|date|after:data_inici',
            'limit_calories_diari' => 'required|integer|min:0',
        ]);

        // Verificar si el usuario ya tiene un reto, en caso de que ya tenga uno lo actualizamos
        $repte = Repte::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nom' => $request->nom,
                'data_inici' => $request->data_inici,
                'data_fi' => $request->data_fi,
                'limit_calories_diari' => $request->limit_calories_diari
            ]
        );

        return response()->json([
            'missatge' => 'Repte creat correctament',
            'repte' => $repte
        ], 201);
    }

    /**
     * Registrar el consumo diario de calorías para el reto del usuario autenticado.
     *
     * @param Request $request
     * - Recibe:
     *   - `calories_consumides` (integer): Cantidad de calorías consumidas.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Mensaje de éxito.
     *   - Detalles del consumo diario registrado.
     *   - Error 400 si el usuario no tiene un reto creado.
     */
    public function registrarConsumDiari(Request $request)
    {
        $request->validate([
            'calories_consumides' => 'required|integer|min:0',
        ]);

        // Obtener el reto del usuario
        $repte = Auth::user()->repte;

        if (!$repte) {
            return response()->json(['missatge' => 'No tens cap repte creat'], 400);
        }

        // Crear el registro de consumo diario
        $consumDiari = new ConsumDiari([
            'repte_id' => $repte->id,
            'data' => now()->toDateString(),
            'calories_consumides' => $request->calories_consumides,
        ]);

        $consumDiari->save();

        return response()->json([
            'missatge' => 'Consum registrat correctament',
            'consum_diari' => $consumDiari
        ], 201);
    }

    /**
     * Eliminar un reto del usuario autenticado.
     *
     * @param int $id
     * - ID del reto a eliminar.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Mensaje de éxito.
     */
    public function destroy($id)
    {
        $repte = Repte::find($id);

        if (!$repte) {
            return response()->json(['missatge' => 'Repte no trobat'], 404);
        }

        // Verificar si el reto pertenece al usuario autenticado
        if ($repte->user_id !== Auth::id()) {
            return response()->json(['missatge' => 'No tens permís per eliminar aquest repte'], 403);
        }

        $repte->delete();

        return response()->json(['missatge' => 'Repte eliminat correctament']);
    }
}

