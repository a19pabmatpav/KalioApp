<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Logro;

/**
 * Modelo User
 *
 * Representa un usuario del sistema.
 *
 * Propiedades:
 * - `name` (string): Nombre del usuario.
 * - `email` (string): Correo electrónico del usuario.
 * - `password` (string): Contraseña del usuario (almacenada de forma segura).
 * - `remember_token` (string): Token para recordar la sesión del usuario.
 * - `email_verified_at` (datetime): Fecha y hora en que el correo fue verificado.
 *
 * Relaciones:
 * - Relación de muchos a muchos (N:M) con el modelo `Logro`.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',          // Nombre del usuario
        'email',         // Correo electrónico
        'password',      // Contraseña
    ];

    /**
     * Los atributos que deben permanecer ocultos al serializar.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',       // Contraseña
        'remember_token', // Token para recordar la sesión
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Fecha de verificación del correo
            'password' => 'hashed',           // Contraseña almacenada de forma segura
        ];
    }

    /**
     * Relación con el modelo Logro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * - Retorna:
     *   - Una relación de muchos a muchos (N:M) con el modelo `Logro`.
     */
    public function logros()
    {
        return $this->belongsToMany(Logro::class, 'logro_user');
    }
}
