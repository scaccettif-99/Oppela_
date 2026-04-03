<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annuncio extends Model
{
    protected $table = 'annunci';

    protected $fillable = [
        'user_id',
        'titolo',
        'descrizione',
        'prezzo',
        'brand',
        'stato',
        'sold_at',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'prezzo' => 'decimal:2',
    ];

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