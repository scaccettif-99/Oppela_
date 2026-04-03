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
    Schema::create('annunci', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('titolo');
        $table->text('descrizione')->nullable();
        $table->decimal('prezzo', 8, 2);
        $table->string('brand')->nullable();
        $table->string('stato')->default('disponibile'); // disponibile · venduto
        $table->timestamp('sold_at')->nullable();        // data vendita
        $table->timestamps();                            // created_at · updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annunci');
    }
};
