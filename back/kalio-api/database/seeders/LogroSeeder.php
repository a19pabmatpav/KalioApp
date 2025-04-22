<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Seeder LogroSeeder
 *
 * Este seeder se encarga de poblar la tabla `logros` con los datos iniciales
 * obtenidos desde un archivo JSON ubicado en `public/exits.json`.
 *
 * Funcionalidad:
 * - Verifica si el archivo JSON existe.
 * - Lee los datos del archivo JSON.
 * - Inserta los datos en la tabla `logros`.
 */
class LogroSeeder extends Seeder
{
    /**
     * Ejecutar el seeder para poblar la tabla `logros`.
     *
     * @return void
     * - Lee los datos desde el archivo JSON `public/exits.json`.
     * - Inserta los datos en la tabla `logros`.
     * - Muestra un mensaje de éxito si los datos se insertan correctamente.
     * - Muestra un mensaje de error si el archivo JSON no existe.
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

            // Mensaje de éxito
            $this->command->info('Datos insertados correctamente desde exits.json.');
        } else {
            // Mensaje de error si el archivo no existe
            $this->command->error("El archivo exits.json no existe en la ruta: $jsonPath");
        }
    }
}
