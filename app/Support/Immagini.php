<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Salvataggio immagini caricate dal pannello: le foto del telefono (anche 10 MB)
 * vengono raddrizzate, ridotte e compresse per il web.
 */
class Immagini
{
    public const CARTELLA_MINI = 'mini';

    public const LATO_MINI = 800;

    // URL della miniatura di una foto di public/media (creata con "php artisan media:miniature");
    // se la miniatura non c'è ancora, la foto intera
    public static function mini(string $percorso): string
    {
        $mini = dirname($percorso) . '/' . self::CARTELLA_MINI . '/' . basename($percorso) . '.webp';

        return asset(is_file(public_path($mini)) ? $mini : $percorso);
    }

    // foto (annunci, slide): JPG max $lato px sul lato lungo
    public static function salvaFoto(UploadedFile $file, string $cartella, int $lato = 1600): string
    {
        $img = self::apri($file);
        if (! $img) {
            return $file->store($cartella, 'public'); // formato non gestito da GD: salvo l'originale
        }

        $img = self::ridimensiona($img, $lato);

        // eventuale trasparenza (PNG/WebP) su fondo bianco
        $fondo = imagecreatetruecolor(imagesx($img), imagesy($img));
        imagefill($fondo, 0, 0, imagecolorallocate($fondo, 255, 255, 255));
        imagecopy($fondo, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
        imageinterlace($fondo, true);

        ob_start();
        imagejpeg($fondo, null, 82);
        $dati = ob_get_clean();

        $percorso = $cartella . '/' . Str::random(40) . '.jpg';
        Storage::disk('public')->put($percorso, $dati);

        return $percorso;
    }

    // loghi: mantengono la trasparenza; gli SVG restano vettoriali
    // ritorna [percorso, larghezza, altezza]
    public static function salvaLogo(UploadedFile $file, string $cartella = 'loghi'): array
    {
        if (self::eSvg($file)) {
            $svg = file_get_contents($file->getRealPath());
            [$w, $h] = self::dimensioniSvg($svg);
            $percorso = $cartella . '/' . Str::random(40) . '.svg';
            Storage::disk('public')->put($percorso, $svg);

            return [$percorso, $w, $h];
        }

        $img = self::apri($file);
        if (! $img) {
            $percorso = $file->store($cartella, 'public');
            [$w, $h] = @getimagesize($file->getRealPath()) ?: [200, 60];

            return [$percorso, $w, $h];
        }

        $img = self::ridimensiona($img, 800);
        imagesavealpha($img, true);

        ob_start();
        imagepng($img, null, 9);
        $dati = ob_get_clean();

        $percorso = $cartella . '/' . Str::random(40) . '.png';
        Storage::disk('public')->put($percorso, $dati);

        return [$percorso, imagesx($img), imagesy($img)];
    }

    public static function eSvg(UploadedFile $file): bool
    {
        return strtolower($file->getClientOriginalExtension()) === 'svg'
            || in_array($file->getMimeType(), ['image/svg+xml', 'image/svg'], true);
    }

    // un SVG può contenere codice: lo rifiutiamo se ha script o gestori di eventi
    public static function svgSicuro(string $svg): bool
    {
        return ! preg_match('/<script|<foreignObject|\son\w+\s*=|javascript:|<iframe|<embed|<object/i', $svg)
            && str_contains($svg, '<svg');
    }

    public static function dimensioniSvg(string $svg): array
    {
        if (preg_match('/viewBox\s*=\s*"[\d.\-]+[\s,]+[\d.\-]+[\s,]+([\d.]+)[\s,]+([\d.]+)"/i', $svg, $m)) {
            return [(int) round((float) $m[1]), (int) round((float) $m[2])];
        }
        if (preg_match('/\bwidth\s*=\s*"([\d.]+)/i', $svg, $w) && preg_match('/\bheight\s*=\s*"([\d.]+)/i', $svg, $h)) {
            return [(int) round((float) $w[1]), (int) round((float) $h[1])];
        }

        return [300, 100];
    }

    private static function apri(UploadedFile $file): \GdImage|false
    {
        if (! function_exists('imagecreatefromstring')) {
            return false;
        }

        @ini_set('memory_limit', '512M'); // una foto da 12 MP decompressa occupa ~50 MB
        $img = @imagecreatefromstring(file_get_contents($file->getRealPath()));
        if (! $img) {
            return false;
        }

        // le foto del telefono sono spesso salvate "di lato" con l'orientamento nei dati EXIF
        if (function_exists('exif_read_data') && in_array($file->getMimeType(), ['image/jpeg', 'image/jpg'], true)) {
            $orientamento = @exif_read_data($file->getRealPath())['Orientation'] ?? 1;
            $gradi = [3 => 180, 6 => -90, 8 => 90][$orientamento] ?? 0;
            if ($gradi) {
                $ruotata = imagerotate($img, $gradi, 0);
                if ($ruotata) {
                    $img = $ruotata;
                }
            }
        }

        if (! imageistruecolor($img)) {
            imagepalettetotruecolor($img);
        }
        imagealphablending($img, false);
        imagesavealpha($img, true);

        return $img;
    }

    private static function ridimensiona(\GdImage $img, int $lato): \GdImage
    {
        $w = imagesx($img);
        $h = imagesy($img);
        if (max($w, $h) <= $lato) {
            return $img;
        }

        $r = $lato / max($w, $h);
        $nuova = imagescale($img, (int) round($w * $r), (int) round($h * $r), IMG_BICUBIC);

        return $nuova ?: $img;
    }
}
