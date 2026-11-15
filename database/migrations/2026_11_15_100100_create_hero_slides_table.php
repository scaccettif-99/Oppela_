<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('posizione')->unique(); // 1, 2, 3
            $table->string('titolo');
            $table->string('sottotitolo')->nullable();
            $table->string('immagine');                 // "media/..." (iniziali) o percorso sul disco public
            $table->unsignedTinyInteger('focus_x')->default(50); // punto da tenere in vista, in %
            $table->unsignedTinyInteger('focus_y')->default(30);
            $table->string('link')->default('evidenza');
            $table->timestamps();
        });

        // contenuti di partenza = quelli già online
        $adesso = now();
        DB::table('hero_slides')->insert([
            ['posizione' => 1, 'titolo' => "Collezione\nprimavera estate", 'sottotitolo' => 'Scopri le nostre collezioni',
             'immagine' => 'media/coll_est_26_14.jpg', 'focus_x' => 50, 'focus_y' => 16, 'link' => 'evidenza',
             'created_at' => $adesso, 'updated_at' => $adesso],
            ['posizione' => 2, 'titolo' => "Collezione\nautunno inverno", 'sottotitolo' => 'Scopri i capi della stagione fredda',
             'immagine' => 'media/modella1.jpg', 'focus_x' => 50, 'focus_y' => 50, 'link' => 'evidenza',
             'created_at' => $adesso, 'updated_at' => $adesso],
            ['posizione' => 3, 'titolo' => "Scopri i nostri\naccessori", 'sottotitolo' => 'Borse, cinte, gioielli da abbinare ai tuoi outfit',
             'immagine' => 'media/coll_est_26_12.jpg', 'focus_x' => 42, 'focus_y' => 20, 'link' => 'shop:accessori',
             'created_at' => $adesso, 'updated_at' => $adesso],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
