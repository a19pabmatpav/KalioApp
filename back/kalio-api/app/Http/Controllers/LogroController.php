<?php

namespace App\Http\Controllers;

use App\Models\Logro;
use App\Models\User;
use Illuminate\Http\Request;

class LogroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Logro $logro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logro $logro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logro $logro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logro $logro)
    {
        //
    }

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

    public function getUserLogros($userId)
    {
        $user = User::with('logros')->findOrFail($userId);

        return response()->json($user->logros);
    }
}
