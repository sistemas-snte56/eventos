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
        Schema::table('participantes', function (Blueprint $table) {
            $table->string('calle')->nullable()->after('folio');
            $table->string('colonia')->nullable()->after('calle');
            $table->string('cp')->nullable()->after('colonia');
            $table->foreignId('localidad_id')->after('cp')->constrained('localidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participantes', function (Blueprint $table) {
            //
        });
    }
};
