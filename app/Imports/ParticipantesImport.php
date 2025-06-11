<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Models\Participante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class ParticipantesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 1. Generar slug único
        $baseSlug = Str::slug($row[2] . '-' . $row[3] . '-' . $row[4]);
        $slug = $baseSlug;
        $counter = 1;

        while (Participante::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // 2. Generar folio único
        do {
            $folio = 'SNT56-' . date('Y') . '-' . strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(8));
        } while (Participante::where('folio', $folio)->exists());

        // 3. Generar código_id único
        $codigoId = sprintf(
            "%04s-%04s-%04s-%04s",
            substr(uniqid(), 0, 4),
            substr(uniqid(), 4, 4),
            substr(uniqid(), 8, 4),
            substr(uniqid(), 12, 4)
        );
        
        
        return new Participante([
            'delegacion_id' => $row[0], // Asegúrate de que este índice coincida con la columna correcta en tu archivo CSV
            'rfc' => $row[1],
            'nombre' => $row[2],
            'apaterno' => $row[3],
            'amaterno' => $row[4],
            'genero' => $row[5],
            'email' => $row[6],
            'npersonal' => $row[7] ?? null, // Maneja el caso donde npersonal pueda ser nulo
            'telefono' => $row[8] ?? null, // Maneja el caso donde telefono pueda ser nulo
            'ct' => $row[9] ?? null, // Maneja el caso donde ct pueda ser nulo
            'cargo' => $row[10] ?? null, // Maneja el caso donde cargo pueda ser nulo
            'nivel' => $row[11],
            'curp' => $row[12]  ?? null, // Maneja el caso donde curp pueda ser nulo
            'folio' => $row[13],
            'slug' => $slug[14], // Genera un slug único
            'codigo_id' => $row[15] ?? null, // Maneja el caso donde codigo_id pueda ser nulo
            'codigo_qr' => $row[16] ?? null, // Maneja el caso donde codigo_id pueda ser nulo
            'talon' => $row[17] ?? null, // Maneja el caso donde codigo_id pueda ser nulo
            'ine_frontal' => $row[18] ?? null, // Maneja el caso donde codigo_id pueda ser nulo,
            'ine_reverso' => $row[19] ?? null, // Maneja el caso donde codigo_id pueda ser nulo,
        

        /*

            $table->id();
            $table->foreignId('delegacion_id')->constrained()->onDelete('cascade'); // nombre corregido
            $table->string('rfc')->unique();
            $table->string('nombre');
            $table->string('apaterno');
            $table->string('amaterno');
            $table->enum('genero', ['Hombre', 'Mujer']);
            $table->string('email')->unique();
            $table->string('npersonal',250)->nullable();
            $table->string('telefono')->nullable();
            $table->string('ct')->nullable();
            $table->string('cargo')->nullable();
            $table->enum('nivel', [
                'Preescolar',
                'Primaria',
                'Educación Especial',
                'Secundaria',
                'Telesecundaria',
                'Educación Física',
                'Niveles Especiales',
                'Paae',
                'Bachillerato',
                'Telebachillerato',
                'Normales',
                'UPV',
                'Jubilados'
            ])->nullable();
            $table->string('curp')->nullable();
            $table->string('folio', 250)->nullable();
            $table->string('slug')->unique();
            $table->string('codigo_id', 250)->nullable();
            $table->string('codigo_qr')->nullable();
            $table->string('talon')->nullable();
            $table->string('ine_frontal')->nullable();
            $table->string('ine_reverso')->nullable();
            $table->timestamps();

        */


        ]);
    }
}
