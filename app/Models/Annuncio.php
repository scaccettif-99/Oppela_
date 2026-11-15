<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Annuncio extends Model
{
    use SoftDeletes;

    protected $table = 'annunci';

    protected $fillable = [
        'user_id',
        'titolo',
        'descrizione',
        'prezzo',
        'brand',
        'categoria',
        'taglie',
        'in_evidenza',
        'stato',
        'sold_at',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'prezzo' => 'decimal:2',
        'taglie' => 'array',
        'in_evidenza' => 'boolean',
    ];

    // capi in evidenza in home: Paola ne sceglie fino a 10, sotto i 5 si completa in automatico
    public const EVIDENZA_MIN = 5;
    public const EVIDENZA_MAX = 10;

    // foto per annuncio: 1 con la modella + almeno 1 del prodotto
    public const FOTO_MIN = 2;
    public const FOTO_MAX = 5;

    // coppie modella/prodotto mostrate se nello shop ci sono meno di 5 capi adatti
    public const EVIDENZA_DEFAULT = [
        ['modellamarkup.jpg', 'abitomarkup.jpg'],
        ['modellamarkup1.jpg', 'abitomarkup1.jpg'],
        ['modellamarkup5.jpg', 'abitomarkup5.jpg'],
        ['modellamarkup3.jpg', 'abitomarkup3.jpg'],
        ['modellamarkup4.jpg', 'abitomarkup4.jpg'],
        ['modellacopains.jpg', 'abitocopains.jpg'],
        ['modellacopains1.jpg', 'abitocopains1.jpg'],
        ['modellacopains2.jpg', 'abitocopains2.jpg'],
        ['modellacopains3.jpg', 'abitocopains3.jpg'],
        ['modellacopains4.jpg', 'abitocopains4.jpg'],
    ];

    /**
     * Riga "Capi in evidenza" della home, dal più recente:
     * 1) i capi scelti (max 10)  2) se sono meno di 5, gli ultimi annunci dello shop
     * Solo annunci disponibili e con almeno 2 foto (modella + prodotto per l'effetto al passaggio).
     * Le eventuali coppie di riserva (EVIDENZA_DEFAULT) le aggiunge la vista.
     */
    public static function perHome()
    {
        $base = fn () => self::with('immagini')
            ->where('stato', 'disponibile')
            ->has('immagini', '>=', self::FOTO_MIN)
            ->latest();

        $scelti = $base()->where('in_evidenza', true)->take(self::EVIDENZA_MAX)->get();

        if ($scelti->count() < self::EVIDENZA_MIN) {
            $scelti = $scelti->concat(
                $base()->where('in_evidenza', false)->take(self::EVIDENZA_MIN - $scelti->count())->get()
            );
        }

        return $scelti;
    }

    // quanti capi disponibili sono già in evidenza (per il limite di 10)
    public static function contaInEvidenza(?int $escludi = null): int
    {
        return self::where('in_evidenza', true)
            ->where('stato', 'disponibile')
            ->when($escludi, fn ($q) => $q->whereKeyNot($escludi))
            ->count();
    }

    // categorie dello shop, nell'ordine in cui compaiono (slug => etichetta)
    public const CATEGORIE = [
        'accessori' => 'Accessori',
        'giacche'   => 'Giacche',
        'pantaloni' => 'Pantaloni',
        'vestiti'   => 'Vestiti',
        'camicie'   => 'Camicie',
        't-shirt'   => 'T-shirt',
        'scarpe'    => 'Scarpe',
    ];

    // taglie disponibili (solo informative, nessuna logica di acquisto)
    public const TAGLIE_ABBIGLIAMENTO = ['XS', 'S', 'M', 'L', 'XL'];
    public const TAGLIE_SCARPE = ['35', '36', '37', '38', '39', '40', '41', '42'];

    // che tipo di taglie usa una categoria: 'abbigliamento', 'scarpe' o null (accessori)
    public static function tipoTaglie(?string $categoria): ?string
    {
        return match ($categoria) {
            'scarpe'    => 'scarpe',
            'accessori', '', null => null,
            default     => 'abbigliamento',
        };
    }

    public static function taglieAmmesse(?string $categoria): array
    {
        return match (self::tipoTaglie($categoria)) {
            'abbigliamento' => self::TAGLIE_ABBIGLIAMENTO,
            'scarpe'        => self::TAGLIE_SCARPE,
            default         => [],
        };
    }

    public function getCategoriaLabelAttribute(): string
    {
        return self::CATEGORIE[$this->categoria] ?? ucfirst((string) $this->categoria);
    }

    // taglie ordinate come nella lista ufficiale, es. "S · M · L"
    public function getTaglieTestoAttribute(): ?string
    {
        $ordine = self::taglieAmmesse($this->categoria);
        $taglie = array_values(array_intersect($ordine, $this->taglie ?? []));

        return $taglie ? implode(' · ', $taglie) : null;
    }

    public const WHATSAPP = '393381520444';

    // link WhatsApp con messaggio già scritto per chiedere info su questo prodotto
    public function getWhatsappUrlAttribute(): string
    {
        $prodotto = $this->titolo . ($this->brand ? " ({$this->brand})" : '');
        $messaggio = "Ciao! Vorrei qualche informazione su questo prodotto: {$prodotto}. "
            . route('annunci.show', $this);

        return 'https://wa.me/' . self::WHATSAPP . '?text=' . rawurlencode($messaggio);
    }

    // relazione con le immagini
    public function immagini()
    {
        return $this->hasMany(AnnuncioImmagine::class)->orderBy('ordine');
    }

    // relazione con l'utente
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // prima immagine — utile per le card
    public function immagineCopertina()
    {
        return $this->hasOne(AnnuncioImmagine::class)->orderBy('ordine');
    }

    // scope per i venduti da eliminare dopo 7 giorni
    public function scopeDaEliminare($query)
    {
        return $query->where('stato', 'venduto')
                    ->where('sold_at', '<=', now()->subDays(7));
    }
}