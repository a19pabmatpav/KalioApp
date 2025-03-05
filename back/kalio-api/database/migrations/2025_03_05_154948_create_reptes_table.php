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
        Schema::create('reptes', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom del repte
            $table->date('data_inici'); // Data d'inici
            $table->date('data_fi'); // Data de finalització
            $table->integer('limit_calories_diari'); // Límite calòric diari
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relació amb l'usuari
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reptes');
    }
};
