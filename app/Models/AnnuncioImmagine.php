<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnuncioImmagine extends Model
{
    protected $table = 'annuncio_immagini';

    protected $fillable = [
        'annuncio_id',
        'path',
        'ordine',
    ];

    // relazione inversa
    public function annuncio()
    {
        return $this->belongsTo(Annuncio::class);
    }
}