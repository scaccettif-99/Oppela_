<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    protected $table = 'hero_slides';

    protected $fillable = ['posizione', 'titolo', 'sottotitolo', 'immagine', 'focus_x', 'focus_y', 'link'];

    // destinazioni possibili del pulsante "Scopri" (chiave => etichetta)
    public static function destinazioni(): array
    {
        $voci = [
            'evidenza' => 'Capi in evidenza (home)',
            'set'      => 'Set fotografico (home)',
            'shop'     => 'Shop – tutti i prodotti',
        ];
        foreach (Annuncio::CATEGORIE as $slug => $label) {
            $voci['shop:' . $slug] = 'Shop – ' . $label;
        }
        $voci['gallery'] = 'Gallery';
        $voci['chi-siamo'] = 'Chi siamo';

        return $voci;
    }

    public function getHrefAttribute(): string
    {
        if (str_starts_with($this->link, 'shop:')) {
            return route('annunci.index', ['categoria' => substr($this->link, 5)]);
        }

        return match ($this->link) {
            'set'       => url('/#set-fotografico'),
            'shop'      => route('annunci.index'),
            'gallery'   => route('gallery'),
            'chi-siamo' => route('chi-siamo'),
            default     => url('/#capi-in-evidenza'),
        };
    }

    public function getImmagineUrlAttribute(): string
    {
        return self::urlFile($this->immagine);
    }

    public function getPosizioneFocusAttribute(): string
    {
        return $this->focus_x . '% ' . $this->focus_y . '%';
    }

    // le immagini iniziali stanno in public/media, quelle caricate dal pannello nello storage
    public static function urlFile(string $percorso): string
    {
        return str_starts_with($percorso, 'media/') ? asset($percorso) : Storage::url($percorso);
    }

    public static function eliminaFile(?string $percorso): void
    {
        if ($percorso && ! str_starts_with($percorso, 'media/')) {
            Storage::disk('public')->delete($percorso);
        }
    }
}
