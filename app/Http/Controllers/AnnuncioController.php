<?php

namespace App\Http\Controllers;

use App\Models\Annuncio;
use App\Models\AnnuncioImmagine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Support\Immagini;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AnnuncioController extends Controller
{
    // shop: annunci divisi per categoria, con filtro categoria e ordinamento prezzo combinabili
    public function index(Request $request)
    {
        $categoria = array_key_exists($request->query('categoria'), Annuncio::CATEGORIE)
            ? $request->query('categoria')
            : null;
        $prezzo = in_array($request->query('prezzo'), ['asc', 'desc'], true)
            ? $request->query('prezzo')
            : null;

        $query = Annuncio::with('immagini')
            ->when($categoria, fn ($q) => $q->where('categoria', $categoria))
            ->orderByRaw("stato = 'venduto'"); // i venduti in fondo

        $prezzo
            ? $query->orderBy('prezzo', $prezzo)->orderBy('created_at', 'desc')
            : $query->orderBy('created_at', 'desc');

        $annunci = $query->get();

        // una sezione per categoria, solo se contiene annunci
        $sezioni = collect(Annuncio::CATEGORIE)
            ->map(fn ($label, $slug) => [
                'slug'    => $slug,
                'label'   => $label,
                'annunci' => $annunci->where('categoria', $slug)->values(),
            ])
            ->filter(fn ($sezione) => $sezione['annunci']->isNotEmpty());

        // nel filtro compaiono solo le categorie che hanno almeno un annuncio
        $conAnnunci = Annuncio::distinct()->pluck('categoria')->all();
        $categorieFiltro = array_filter(
            Annuncio::CATEGORIE,
            fn ($slug) => in_array($slug, $conAnnunci, true),
            ARRAY_FILTER_USE_KEY
        );

        return view('annunci.index', [
            'sezioni'         => $sezioni,
            'categorieFiltro' => $categorieFiltro,
            'categoria'       => $categoria,
            'prezzo'          => $prezzo,
            'filtriAttivi'    => $categoria || $prezzo,
        ]);
    }

    // regole comuni a creazione e modifica
    // foto accettate: anche direttamente dal telefono (fino a 15 MB), poi ridotte in automatico
    public const REGOLA_FOTO = ['image', 'mimes:jpg,jpeg,png,webp', 'max:15360'];

    // regole comuni a creazione e modifica
    private function valida(Request $request, ?Annuncio $annuncio = null): array
    {
        $creazione = $annuncio === null;
        $giaPresenti = $annuncio ? $annuncio->immagini()->count() : 0;

        $validated = $request->validate([
            'titolo'          => 'required|string|max:255',
            'descrizione'     => 'nullable|string',
            'prezzo'          => 'required|numeric|min:0',
            'brand'           => 'nullable|string|max:255',
            'categoria'       => ['required', Rule::in(array_keys(Annuncio::CATEGORIE))],
            'taglie'          => 'nullable|array',
            'taglie.*'        => [Rule::in(Annuncio::taglieAmmesse($request->input('categoria')))],
            'in_evidenza'     => 'nullable|boolean',
            // creazione: 1 foto con la modella + almeno 1 del prodotto (max 5 in tutto)
            'foto_modella'    => [$creazione ? 'required' : 'nullable', ...self::REGOLA_FOTO],
            'foto_prodotto'   => [$creazione ? 'required' : 'nullable', 'array',
                                  $creazione ? 'min:1' : 'min:0',
                                  'max:' . ($creazione ? Annuncio::FOTO_MAX - 1 : max(0, Annuncio::FOTO_MAX - $giaPresenti))],
            'foto_prodotto.*' => self::REGOLA_FOTO,
        ], [
            'categoria.required'     => 'Scegli la categoria del prodotto.',
            'taglie.*.in'            => 'Una delle taglie selezionate non è valida per questa categoria.',
            'foto_modella.required'  => 'Carica la foto del capo indossato dalla modella.',
            'foto_prodotto.required' => 'Carica almeno una foto del prodotto da solo.',
            'foto_prodotto.min'      => 'Carica almeno una foto del prodotto da solo.',
            'foto_prodotto.max'      => 'Puoi avere al massimo ' . Annuncio::FOTO_MAX . ' foto per annuncio.',
            'foto_prodotto.*.max'    => 'Ogni foto può pesare al massimo 15 MB.',
            'foto_modella.max'       => 'Ogni foto può pesare al massimo 15 MB.',
        ]);

        // massimo 10 capi in evidenza (contano solo quelli ancora disponibili)
        $validated['in_evidenza'] = $request->boolean('in_evidenza');
        if ($validated['in_evidenza']
            && (! $annuncio || ! $annuncio->in_evidenza)
            && Annuncio::contaInEvidenza($annuncio?->id) >= Annuncio::EVIDENZA_MAX) {
            throw ValidationException::withMessages([
                'in_evidenza' => 'Hai già ' . Annuncio::EVIDENZA_MAX . ' capi in evidenza: togline uno prima di aggiungerne un altro.',
            ]);
        }

        // taglie salvate nell'ordine ufficiale; nessuna taglia per gli accessori
        $ammesse = Annuncio::taglieAmmesse($validated['categoria']);
        $taglie = array_values(array_intersect($ammesse, $validated['taglie'] ?? []));
        $validated['taglie'] = $taglie ?: null;

        return $validated;
    }

    // salva le foto in coda a quelle esistenti (ridotte per il web)
    private function salvaFoto(Annuncio $annuncio, array $files): void
    {
        $ordine = (int) $annuncio->immagini()->max('ordine');
        $ordine = $annuncio->immagini()->exists() ? $ordine + 1 : 0;

        foreach ($files as $file) {
            AnnuncioImmagine::create([
                'annuncio_id' => $annuncio->id,
                'path'        => Immagini::salvaFoto($file, 'annunci'),
                'ordine'      => $ordine++,
            ]);
        }
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
        $validated = $this->valida($request);

        $annuncio = Annuncio::create([
            'user_id'     => auth()->id(),
            'titolo'      => $validated['titolo'],
            'descrizione' => $validated['descrizione'] ?? null,
            'prezzo'      => $validated['prezzo'],
            'brand'       => $validated['brand'] ?? null,
            'categoria'   => $validated['categoria'],
            'taglie'      => $validated['taglie'],
            'in_evidenza' => $validated['in_evidenza'],
            'stato'       => 'disponibile',
        ]);

        // prima la modella, poi il prodotto: in home la seconda foto compare al passaggio del mouse
        $this->salvaFoto($annuncio, array_merge(
            [$request->file('foto_modella')],
            $request->file('foto_prodotto', [])
        ));

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
        $validated = $this->valida($request, $annuncio);

        $annuncio->update(collect($validated)->only([
            'titolo', 'descrizione', 'prezzo', 'brand', 'categoria', 'taglie', 'in_evidenza',
        ])->all());

        // nuove foto del prodotto in coda; l'ordine si cambia con le frecce
        if ($request->hasFile('foto_prodotto')) {
            $this->salvaFoto($annuncio, $request->file('foto_prodotto'));
        }

        return redirect()->route('annunci.show', $annuncio)
                            ->with('success', 'Annuncio aggiornato!');
    }

    // stella "in evidenza" dal profilo: mette o toglie il capo dalla home
    public function evidenza(Annuncio $annuncio)
    {
        if (! $annuncio->in_evidenza && Annuncio::contaInEvidenza() >= Annuncio::EVIDENZA_MAX) {
            return back()->withErrors([
                'in_evidenza' => 'Hai già ' . Annuncio::EVIDENZA_MAX . ' capi in evidenza: togline uno prima di aggiungerne un altro.',
            ]);
        }

        $annuncio->update(['in_evidenza' => ! $annuncio->in_evidenza]);

        return back()->with('success', $annuncio->in_evidenza
            ? 'Capo messo in evidenza nella home.'
            : 'Capo tolto dalla home.');
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

    // elimina definitivamente un annuncio già nel cestino — solo proprietaria/admin
    public function forceDestroy(Annuncio $annuncio)
    {
        abort_unless($annuncio->trashed(), 404);

        foreach ($annuncio->immagini as $immagine) {
            Storage::disk('public')->delete($immagine->path);
        }

        $annuncio->forceDelete();

        return redirect()->route('profile.edit')
                            ->with('success', 'Annuncio eliminato definitivamente.');
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

    // annulla "venduto" (es. segnato per errore): torna disponibile e non verrà più eliminato dopo 7 giorni
    public function disponibile(Annuncio $annuncio)
    {
        $annuncio->update([
            'stato'   => 'disponibile',
            'sold_at' => null,
        ]);

        return back()->with('success', 'Annuncio rimesso in vendita.');
    }
}
