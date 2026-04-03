<?php

namespace App\Console\Commands;

use App\Models\Annuncio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EliminaAnnunciVenduti extends Command
{
    protected $signature = 'annunci:elimina-venduti';
    protected $description = 'Elimina automaticamente gli annunci venduti dopo 7 giorni';

    public function handle()
    {
        $annunci = Annuncio::daEliminare()->with('immagini')->get();

        foreach ($annunci as $annuncio) {
            foreach ($annuncio->immagini as $immagine) {
                Storage::disk('public')->delete($immagine->path);
            }
            $annuncio->delete();
        }

        $this->info("Eliminati {$annunci->count()} annunci venduti.");
    }
}