<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Logro;
use App\Models\ConsumDiari;

class AuthController extends Controller
{
    /**
     * Registro de usuario
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user
        ], 201);
    }

    /**
     * Login de usuario
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        // Generar token
        $token = $user->createToken('auth_token')->plainTextToken;

        $hasChallenge = \DB::table('reptes')->where('user_id', $user->id)->exists();
        if ($hasChallenge) {
            $challenge = \DB::table('reptes')->where('user_id', $user->id)->first();

            if ($challenge) {
                $consumDia = \DB::table('consums_diari')
                    ->where('repte_id', $challenge->id)
                    ->whereDate('created_at', date('Y-m-d'))
                    ->get();

                // Verificar qué datos está trayendo
                Log::info('Datos de consumDia:', $consumDia->toArray());

                // Asegurar que sumamos correctamente
                $totalCalories = $consumDia->sum(fn($item) => $item->calories_consumides ?? 0);
                Log::info('Total de calorías consumidas:', ['totalCalories' => $totalCalories]);
            }

        }



        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'repte' => $challenge ?? null,
            'consumDia' => $totalCalories ?? null,
            'consums' => $consumDia ?? null
        ]);
    }

    /**
     * Obtener usuario autenticado
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Cerrar sesión (logout)
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
