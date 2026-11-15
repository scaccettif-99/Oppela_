<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annunci', function (Blueprint $table) {
            $table->string('categoria')->default('accessori')->after('brand')->index();
            $table->json('taglie')->nullable()->after('categoria'); // solo informativo
        });
    }

    public function down(): void
    {
        Schema::table('annunci', function (Blueprint $table) {
            $table->dropColumn(['categoria', 'taglie']);
        });
    }
};
