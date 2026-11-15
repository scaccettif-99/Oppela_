<?php

namespace App\Http\Controllers;

use App\Models\Annuncio;
use App\Models\AnnuncioImmagine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnuncioImmagineController extends Controller
{
    public function destroy(AnnuncioImmagine $immagine)
    {
        // ogni annuncio deve restare con la foto della modella + almeno una del prodotto
        if ($immagine->annuncio->immagini()->count() <= Annuncio::FOTO_MIN) {
            return back()->withErrors([
                'foto' => 'Servono almeno ' . Annuncio::FOTO_MIN . ' foto: carica prima quella nuova, poi elimina questa.',
            ]);
        }

        Storage::disk('public')->delete($immagine->path);
        $immagine->delete();
        $this->rinumera($immagine->annuncio);

        return back()->with('success', 'Foto eliminata.');
    }

    // sposta una foto di un posto (su = prima, giu = dopo)
    public function sposta(Request $request, AnnuncioImmagine $immagine)
    {
        $foto = $immagine->annuncio->immagini()->get()->values();
        $i = $foto->search(fn ($f) => $f->id === $immagine->id);
        $j = $request->input('direzione') === 'su' ? $i - 1 : $i + 1;

        if ($j >= 0 && $j < $foto->count()) {
            $ordine = $foto->pluck('id')->all();
            [$ordine[$i], $ordine[$j]] = [$ordine[$j], $ordine[$i]];
            foreach ($ordine as $pos => $id) {
                AnnuncioImmagine::whereKey($id)->update(['ordine' => $pos]);
            }
        }

        return back()->with('success', 'Ordine delle foto aggiornato.');
    }

    private function rinumera(Annuncio $annuncio): void
    {
        foreach ($annuncio->immagini()->get()->values() as $pos => $foto) {
            $foto->update(['ordine' => $pos]);
        }
    }
}
