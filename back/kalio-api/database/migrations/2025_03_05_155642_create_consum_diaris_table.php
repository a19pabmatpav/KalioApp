<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consums_diari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repte_id')->constrained('reptes')->onDelete('cascade'); // Relación con el reto
            $table->date('data'); // Fecha del consumo
            $table->float('calories_consumides'); // Cantidad de calorías consumidas
            $table->float('proteines_consumides')->nullable(); // Cantidad de proteínas consumidas
            $table->float('sucres_consumits')->nullable(); // Cantidad de azúcares consumidos
            $table->float('aigua_consumida')->nullable(); // Cantidad de agua consumida
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consum_diaris');
    }
};
