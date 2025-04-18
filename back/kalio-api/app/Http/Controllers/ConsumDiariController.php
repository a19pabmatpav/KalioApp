<?php

namespace App\Http\Controllers;

use App\Models\ConsumDiari;
use Illuminate\Http\Request;

class ConsumDiariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consums = ConsumDiari::all();
        return response()->json($consums);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function edit(ConsumDiari $consumDiari)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConsumDiari $consumDiari)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsumDiari $consumDiari)
    {
        //
    }
}
