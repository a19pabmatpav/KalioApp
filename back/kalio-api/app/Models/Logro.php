<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    use HasFactory;

    protected $table = 'logros'; // Nombre de la tabla
    // Definimos los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nom',
        'descripcio',
        'icon'
    ];

    public $timestamps = true;

    // Relación con User (N:M)
    public function users()
    {
        return $this->belongsToMany(User::class, 'logro_user');
    }
}
