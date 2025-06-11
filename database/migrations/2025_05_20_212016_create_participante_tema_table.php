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
        Schema::create('participante_tema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participante_id')->constrained()->onDelete('cascade');
            $table->foreignId('tema_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Evita registros duplicados en el mismo taller
            $table->unique(['participante_id', 'tema_id']);            
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participante_tema');
    }
};
