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
        Schema::create('participantes', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
