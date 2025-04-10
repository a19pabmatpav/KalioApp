<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LogroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ruta al archivo JSON
        $jsonPath = public_path('exits.json');

        // Verificar si el archivo existe
        if (File::exists($jsonPath)) {
            // Leer el contenido del archivo JSON
            $logros = json_decode(File::get($jsonPath), true);

            // Insertar los datos en la tabla 'logros'
            DB::table('logros')->insert($logros);

            $this->command->info('Datos insertados correctamente desde exits.json.');
        } else {
            $this->command->error("El archivo exits.json no existe en la ruta: $jsonPath");
        }
    }
}
