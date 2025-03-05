<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repte extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'data_inici', 'data_fi', 'limit_calories_diari', 'user_id',
    ];

    /**
     * Relació amb l'usuari.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
