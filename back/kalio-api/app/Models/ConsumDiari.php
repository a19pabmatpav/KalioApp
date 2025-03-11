<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Definir la relación con el modelo 'Repte'
    public function repte()
    {
        return $this->belongsTo(Repte::class);
    }
}
