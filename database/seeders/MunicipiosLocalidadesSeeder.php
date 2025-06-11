<?php

namespace Database\Seeders;

use App\Models\Localidad;
use App\Models\Municipio;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MunicipiosLocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Importar municipios
        $municipios = array_map('str_getcsv', file(database_path('seeders/data/municipios.csv')));
        foreach ($municipios as $index => $row) {
            if ($index === 0) continue; // omitir cabecera
            Municipio::create([
                'id' => $row[0],
                'nombre' => ($row[1])
            ]);
        }

        // Importar localidades
        $localidades = array_map('str_getcsv', file(database_path('seeders/data/localidades.csv')));
        foreach ($localidades as $index => $row) {
            if ($index === 0) continue; // omitir cabecera
            Localidad::create([
                'id' => $row[0],
                'nombre' => $row[1],
                'municipio_id' => $row[2]
            ]);
        }        
    }
}
