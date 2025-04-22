<?php

namespace App\Http\Controllers;

use App\Models\ConsumDiari;
use Illuminate\Http\Request;

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
            'calories' => 'required|integer',
        ]);

        $consum = ConsumDiari::create([
            'repte_id' => $request->repte_id,
            'data' => $request->data,
            'calories_consumides' => $request->calories,
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
     *
     * @return \Illuminate\Http\JsonResponse
     * - Retorna:
     *   - Un resumen del consumo diario del reto especificado (calorías, proteínas, azúcar, agua).
     *   - Error 404 si no se encuentran consumos para el reto en la fecha actual.
     */
    public function show($repte_id)
    {
        $hoy = date('Y-m-d');

        $consums = ConsumDiari::where('repte_id', $repte_id)
            ->where('data', $hoy)
            ->get();
        $totalCalories = $consums->sum('calories_consumides');
        $totalConsumit = [
            'calories' => $totalCalories,
            'proteins' => 0,
            'sugar' => 0,
            'water' => 0,
        ];

        if ($consums->isEmpty()) {
            return response()->json(['error' => 'No s\'han trobat consums per a aquest repte avui.'], 404);
        }

        return response()->json($totalConsumit);
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
    public function edit(ConsumDiari $consumDiari)
    {
        //
    }

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
