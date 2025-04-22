<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Repte
 *
 * Representa un reto asociado a un usuario.
 *
 * Propiedades:
 * - `nom` (string): Nombre del reto.
 * - `data_inici` (date): Fecha de inicio del reto.
 * - `data_fi` (date): Fecha de finalización del reto.
 * - `limit_calories_diari` (integer): Límite diario de calorías para el reto.
 * - `user_id` (integer): ID del usuario al que pertenece el reto.
 *
 * Relaciones:
 * - Pertenece a un usuario (`User`).
 */
class Repte extends Model
{
    use HasFactory;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nom',                // Nombre del reto
        'data_inici',         // Fecha de inicio del reto
        'data_fi',            // Fecha de finalización del reto
        'limit_calories_diari', // Límite diario de calorías
        'user_id',            // ID del usuario asociado
    ];

    /**
     * Relación con el modelo User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * - Retorna:
     *   - La relación de pertenencia al modelo `User`.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
