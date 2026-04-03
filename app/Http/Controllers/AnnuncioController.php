<?php

namespace App\Http\Controllers;

use App\Models\Annuncio;
use App\Models\AnnuncioImmagine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnuncioController extends Controller
{
    // lista annunci pubblici
    public function index()
    {
        $annunci = Annuncio::with('immagineCopertina')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('annunci.index', compact('annunci'));
    }

    // dettaglio annuncio pubblico
    public function show(Annuncio $annuncio)
    {
        $annuncio->load('immagini');
        return view('annunci.show', compact('annuncio'));
    }

    // form crea annuncio — solo proprietaria/admin
    public function create()
    {
        return view('annunci.create');
    }

    // salva annuncio — solo proprietaria/admin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titolo'      => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'prezzo'      => 'required|numeric|min:0',
            'brand'       => 'nullable|string|max:255',
            'immagini'    => 'array|max:5',
            'immagini.*'  => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $annuncio = Annuncio::create([
            'user_id'     => auth()->id(),
            'titolo'      => $validated['titolo'],
            'descrizione' => $validated['descrizione'] ?? null,
            'prezzo'      => $validated['prezzo'],
            'brand'       => $validated['brand'] ?? null,
            'stato'       => 'disponibile',
        ]);

        // salva le immagini
        if ($request->hasFile('immagini')) {
            foreach ($request->file('immagini') as $index => $file) {
                $path = $file->store('annunci', 'public');
                AnnuncioImmagine::create([
                    'annuncio_id' => $annuncio->id,
                    'path'        => $path,
                    'ordine'      => $index,
                ]);
            }
        }

        return redirect()->route('annunci.show', $annuncio)
                            ->with('success', 'Annuncio creato con successo!');
    }

    // form modifica — solo proprietaria/admin
    public function edit(Annuncio $annuncio)
    {
        $annuncio->load('immagini');
        return view('annunci.edit', compact('annuncio'));
    }

    // aggiorna annuncio — solo proprietaria/admin
    public function update(Request $request, Annuncio $annuncio)
    {
        $validated = $request->validate([
            'titolo'      => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'prezzo'      => 'required|numeric|min:0',
            'brand'       => 'nullable|string|max:255',
            'immagini'    => 'array|max:5',
            'immagini.*'  => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $annuncio->update($validated);

        // aggiunge nuove immagini se caricate
        if ($request->hasFile('immagini')) {
            $totaleAttuali = $annuncio->immagini()->count();
            $nuove = $request->file('immagini');

            if ($totaleAttuali + count($nuove) > 5) {
                return back()->withErrors(['immagini' => 'Puoi caricare massimo 5 foto per annuncio.']);
            }

            foreach ($nuove as $index => $file) {
                $path = $file->store('annunci', 'public');
                AnnuncioImmagine::create([
                    'annuncio_id' => $annuncio->id,
                    'path'        => $path,
                    'ordine'      => $totaleAttuali + $index,
                ]);
            }
        }

        return redirect()->route('annunci.show', $annuncio)
                            ->with('success', 'Annuncio aggiornato!');
    }

    // elimina annuncio — solo proprietaria/admin
    public function destroy(Annuncio $annuncio)
    {
        // elimina le immagini dal disco
        foreach ($annuncio->immagini as $immagine) {
            Storage::disk('public')->delete($immagine->path);
        }

        $annuncio->delete();

        return redirect()->route('annunci.index')
                            ->with('success', 'Annuncio eliminato.');
    }

    // segna come venduto — solo proprietaria/admin
    public function venduto(Annuncio $annuncio)
    {
        $annuncio->update([
            'stato'   => 'venduto',
            'sold_at' => now(),
        ]);

        return back()->with('success', 'Annuncio segnato come venduto.');
    }
}