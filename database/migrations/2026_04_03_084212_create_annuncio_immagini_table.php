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
    Schema::create('annuncio_immagini', function (Blueprint $table) {
        $table->id();
        $table->foreignId('annuncio_id')->constrained('annunci')->onDelete('cascade');
        $table->string('path');        // percorso file salvato
        $table->integer('ordine')->default(0); // per ordinare le foto
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annuncio_immagini');
    }
};
