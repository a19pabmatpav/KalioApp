<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo ConsumDiari
 *
 * Representa un registro de consumo diario asociado a un reto.
 *
 * Propiedades:
 * - `repte_id` (integer): ID del reto asociado.
 * - `data` (date): Fecha del consumo.
 * - `calories_consumides` (integer): Cantidad de calorías consumidas en esa fecha.
 *
 * Relaciones:
 * - Pertenece a un reto (`Repte`).
 */
class ConsumDiari extends Model
{
    use HasFactory;

    // Definir la tabla si el nombre no sigue la convención
    protected $table = 'consums_diari';

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'repte_id',          // Relación con el reto
        'data',              // Fecha del consumo
        'calories_consumides', // Cantidad de calorías consumidas
    ];

    /**
     * Relación con el modelo Repte
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * - Retorna:
     *   - La relación de pertenencia al modelo `Repte`.
     */
    public function repte()
    {
        return $this->belongsTo(Repte::class);
    }
}
