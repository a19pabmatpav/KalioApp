<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Logro
 *
 * Representa un logro que puede ser asignado a múltiples usuarios.
 *
 * Propiedades:
 * - `nom` (string): Nombre del logro.
 * - `descripcio` (string): Descripción del logro.
 * - `icon` (string): URL o ruta del icono asociado al logro.
 *
 * Relaciones:
 * - Relación de muchos a muchos (N:M) con el modelo `User`.
 */
class Logro extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada al modelo
    protected $table = 'logros';

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nom',          // Nombre del logro
        'descripcio',   // Descripción del logro
        'icon',         // Icono asociado al logro
    ];

    // Indica que la tabla tiene columnas de timestamps (created_at, updated_at)
    public $timestamps = true;

    /**
     * Relación con el modelo User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * - Retorna:
     *   - Una relación de muchos a muchos (N:M) con el modelo `User`.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'logro_user');
    }
}
