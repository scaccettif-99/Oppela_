<?php

use App\Support\Immagini;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_loghi', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('immagine');               // "media/..." (iniziali) o percorso sul disco public
            $table->unsignedInteger('larghezza');     // dimensioni originali, servono a bilanciare
            $table->unsignedInteger('altezza');       // visivamente loghi di forme diverse
            $table->unsignedInteger('ordine')->default(0);
            $table->timestamps();
        });

        $iniziali = [
            ['Mark Up', 'markup.png'],
            ['Sara Chole', 'sarachole.png'],
            ['Les Copains', 'Lescopains.jpg'],
            ['Enrico Coveri', 'logo-enrico-coveri.jpg'],
            ['MET', 'logo-met.png'],
            ['Molly Bracken', 'logo-molly-bracken.svg'],
        ];

        foreach ($iniziali as $i => [$nome, $file]) {
            $percorso = public_path('media/' . $file);
            if (str_ends_with($file, '.svg')) {
                [$w, $h] = is_file($percorso) ? Immagini::dimensioniSvg(file_get_contents($percorso)) : [300, 30];
            } else {
                [$w, $h] = (is_file($percorso) ? @getimagesize($percorso) : null) ?: [200, 60];
            }

            DB::table('brand_loghi')->insert([
                'nome' => $nome, 'immagine' => 'media/' . $file,
                'larghezza' => $w, 'altezza' => $h, 'ordine' => $i + 1,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_loghi');
    }
};
