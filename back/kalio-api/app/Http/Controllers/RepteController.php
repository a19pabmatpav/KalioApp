<?php
namespace App\Http\Controllers;

use App\Models\Repte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ConsumDiari;

class RepteController extends Controller
{
    // Mostrar tots els reptes de l'usuari loguejat
    public function index()
    {
        $reptes = Auth::user()->reptes; // Relació amb l'usuari
        return response()->json($reptes);
    }

    // Crear un nou repte
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

}

