<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    use HasFactory; // Asegura que puedes usar fábricas para este modelo

    protected $table = 'historics'; // Nombre de la tabla

    protected $fillable = [
        'user_id',
        'day',
        'calories_consumed',
    ];

    // Si usas timestamps (created_at y updated_at)
    public $timestamps = true; // Esto es opcional si estás usando las marcas de tiempo automáticas en Laravel

    // Si el campo 'day' no sigue la convención de formato de fecha de Laravel, puedes definirlo:
    protected $dates = ['day'];
}
