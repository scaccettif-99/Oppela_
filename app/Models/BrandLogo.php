<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandLogo extends Model
{
    protected $table = 'brand_loghi';

    protected $fillable = ['nome', 'immagine', 'larghezza', 'altezza', 'ordine'];

    public function getUrlAttribute(): string
    {
        return HeroSlide::urlFile($this->immagine);
    }

    /**
     * Dimensioni a schermo: loghi di forme diverse (quadrati, lunghi e stretti, piccoli)
     * occupano più o meno la stessa "superficie", così nessuno domina la striscia.
     * Le immagini non vettoriali non vengono mai ingrandite (si sgranerebbero).
     */
    public function dimensioniSchermo(): array
    {
        $w = max(1, $this->larghezza);
        $h = max(1, $this->altezza);

        $scala = sqrt(9000 / ($w * $h));
        $scala = min($scala, 75 / $h, 260 / $w);
        if (! str_ends_with(strtolower($this->immagine), '.svg')) {
            $scala = min($scala, 1);
        }

        return [(int) round($w * $scala), (int) round($h * $scala)];
    }
}
