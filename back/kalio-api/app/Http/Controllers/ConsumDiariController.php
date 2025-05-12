<?php

namespace App\Http\Controllers;

use App\Models\ConsumDiari;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConsumDiariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Una lista de todos los consumos diarios registrados en la base de datos.
     */
    public function index()
    {
        $consums = ConsumDiari::all();
        return response()->json($consums);
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
     *   - `repte_id` (integer): ID del reto asociado.
     *   - `data` (date): Fecha del consumo.
     *   - `calories` (integer): Cantidad de calorías consumidas.
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Mensaje de éxito.
     *   - Detalles del consumo diario registrado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'repte_id' => 'required|integer',
            'data' => 'required|date',
            'calories' => 'required|numeric',
            'proteins' => 'nullable|numeric',
            'sugars' => 'nullable|numeric',
            'water' => 'nullable|numeric',
        ]);

        $consum = ConsumDiari::create([
            'repte_id' => $request->repte_id,
            'data' => $request->data,
            'calories_consumides' => $request->calories,
            'proteines_consumides' => $request->proteins,
            'sucres_consumits' => $request->sugars,
            'aigua_consumida' => $request->water,
        ]);

        return response()->json([
            'message' => 'Consum diari registrat correctament',
            'consum' => $consum
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $repte_id
     * - Recibe:
     *   - `repte_id` (integer): ID del reto asociado.
     *   - `range` (string, opcional): Rango de fechas (hoy, semana, mes).
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Una lista de consumos diarios del reto especificado dentro del rango de tiempo.
     *   - Error 404 si no se encuentran consumos para el rango especificado.
     */
    public function show($repte_id, Request $request)
    {

        $range = $request->query('range', 'today'); // Obtener el rango de la consulta (por defecto "today")

        // Crear la consulta base
        $query = ConsumDiari::where('repte_id', $repte_id);

        // Filtrar por rango utilizando el campo `data`
        if ($range === 'today') {
            $query->whereDate('data', now()->toDateString()); // Solo los datos de hoy
        } elseif ($range === 'week') {
            $query->whereBetween('data', [
                now()->subDays(6)->toDateString(), // Hace 6 días
                now()->toDateString() // Hoy
            ]);
        } elseif ($range === 'month') {
            $query->whereBetween('data', [
                now()->subMonth()->toDateString(), // Hace un mes
                now()->toDateString() // Hoy
            ]);
        } else {
            return response()->json([
                'error' => 'Rango no válido.',
                'range' => $range
            ], 400);
        }

        // Obtener los resultados
        $consums = $query->get();

        // Si no se encuentran resultados, devolver un error
        if ($consums->isEmpty()) {
            return response()->json([
                'error' => 'No s\'han trobat consums per a aquest rang.',
                'consulta' => $query->toSql(),
                'bindings' => $query->getBindings(),
                'range' => $range,
            ], 404);
        }

        // Devolver los registros encontrados
        return response()->json($consums);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConsumDiari $consumDiari
     * - Recibe:
     *   - `consumDiari` (ConsumDiari): Instancia del modelo ConsumDiari.
     *
     * @return void
     * - Esta función no está implementada porque no se utiliza en una API REST.
     */


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * - Recibe:
     *   - `request` (Request): Datos para actualizar el consumo diario.
     *   - `consumDiari` (ConsumDiari): Instancia del modelo ConsumDiari a actualizar.
     *
     * @return void
     * - Esta función no está implementada.
     */
    public function update(Request $request, ConsumDiari $consumDiari)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsumDiari $consumDiari
     * - Recibe:
     *   - `consumDiari` (ConsumDiari): Instancia del modelo ConsumDiari a eliminar.
     *
     * @return void
     * - Esta función no está implementada.
     */
    public function destroy(ConsumDiari $consumDiari)
    {
        //
    }
}
