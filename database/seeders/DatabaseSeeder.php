<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tema;
use App\Models\User;
use App\Models\Region;
use App\Models\Colonia;
use App\Models\Municipio;
use App\Models\Delegacion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        // Importar users
        // $users = array_map('str_getcsv', file(database_path('seeders/data/users.csv')));
        // foreach ($users as $index => $row) {
        //     if ($index === 0) continue; // omitir cabecera
        //     User::create([
        //         'id' => $row[0],
        //         'name' => ($row[1]),
        //         'email' => ($row[2])
        //     ]);
        // }

        // Importar regions
        // $regions = array_map('str_getcsv', file(database_path('seeders/data/regions.csv')));
        // foreach ($regions as $index => $row) {
        //     if ($index === 0) continue; // omitir cabecera
        //     Region::create([
        //         'id' => $row[0],
        //         'region' => ($row[1]),
        //         'sede' => ($row[2])
        //     ]);
        // }

        // // Importar delegacions
        // $delegacions = array_map('str_getcsv', file(database_path('seeders/data/delegacions.csv')));
        // foreach ($delegacions as $index => $row) {
        //     if ($index === 0) continue; // omitir cabecera
        //     Delegacion::create([
        //         'id' => $row[0],
        //         'region_id' => ($row[1]),
        //         'deleg_delegacional' => ($row[2]),
        //         'nivel_delegacional' => ($row[3]),
        //         'sede_delegacional' => ($row[4])
        //     ]);
        // }


        // // Importar temas
        // $temas = array_map('str_getcsv', file(database_path('seeders/data/temas.csv')));
        // foreach ($temas as $index => $row) {
        //     if ($index === 0) continue; // omitir cabecera
        //     Tema::create([
        //         'id' => $row[0],
        //         'titulo' => ($row[1]),
        //         'descripcion' => ($row[2])
        //     ]);
        // }

        // // Importar municipios
        // $municipios = array_map('str_getcsv', file(database_path('seeders/data/municipios.csv')));
        // foreach ($municipios as $index => $row) {
        //     if ($index === 0) continue; // omitir cabecera
        //     Municipio::create([
        //         'id' => $row[0],
        //         'nombre' => ($row[1])
        //     ]);
        // }

        // // Importar localidades
        // $colonias = array_map('str_getcsv', file(database_path('seeders/data/colonias.csv')));
        // foreach ($colonias as $index => $row) {
        //     if ($index === 0) continue; // omitir cabecera
        //     Colonia::create([
        //         'id' => $row[0],
        //         'municipio_id' => $row[1],
        //         'nombre' => $row[2],
        //         'codigo_postal' => $row[3]
        //     ]);
        // }        
    }
}