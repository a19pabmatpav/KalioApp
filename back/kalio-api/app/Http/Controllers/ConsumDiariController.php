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
    public function show(ConsumDiari $consumDiari)
    {
        //
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
