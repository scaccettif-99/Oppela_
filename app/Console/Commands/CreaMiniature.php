<?php

namespace App\Console\Commands;

use App\Support\Immagini;
use Illuminate\Console\Command;

/**
 * Crea le miniature WebP delle foto di public/media (in public/media/mini),
 * usate nelle griglie al posto delle foto intere: la pagina si carica molto prima.
 * Dopo aver aggiunto foto nuove in public/media: php artisan media:miniature
 */
class CreaMiniature extends Command
{
    protected $signature = 'media:miniature {--rifai : ricrea anche quelle già presenti}';

    protected $description = 'Crea le miniature WebP delle foto in public/media';

    public function handle(): int
    {
        $sorgente = public_path('media');
        $dest = public_path('media/' . Immagini::CARTELLA_MINI);
        is_dir($dest) || mkdir($dest, 0755, true);

        $fatte = 0;
        foreach (glob($sorgente . '/*.{jpg,jpeg,JPG,JPEG,png,webp}', GLOB_BRACE) as $file) {
            $mini = $dest . '/' . basename($file) . '.webp';
            if (! $this->option('rifai') && is_file($mini) && filemtime($mini) >= filemtime($file)) {
                continue;
            }

            $img = @imagecreatefromstring(file_get_contents($file));
            if (! $img) {
                $this->warn('Non leggibile: ' . basename($file));
                continue;
            }
            if (! imageistruecolor($img)) {
                imagepalettetotruecolor($img);
            }

            $w = imagesx($img);
            $h = imagesy($img);
            if (max($w, $h) > Immagini::LATO_MINI) {
                $r = Immagini::LATO_MINI / max($w, $h);
                $img = imagescale($img, (int) round($w * $r), (int) round($h * $r), IMG_BICUBIC) ?: $img;
            }
            imagesavealpha($img, true);
            imagewebp($img, $mini, 72);
            $fatte++;
        }

        $this->info("Miniature create: {$fatte}");

        return self::SUCCESS;
    }
}
