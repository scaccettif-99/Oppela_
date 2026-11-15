<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AnnuncioController;
use App\Http\Controllers\Controller;
use App\Models\Annuncio;
use App\Models\BrandLogo;
use App\Models\HeroSlide;
use App\Support\Immagini;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

// "Personalizza home": slide della hero e loghi dei brand (solo admin e owner)
class HomeController extends Controller
{
    public function edit()
    {
        return view('admin.home', [
            'slides'        => HeroSlide::orderBy('posizione')->get(),
            'loghi'         => BrandLogo::orderBy('ordine')->orderBy('id')->get(),
            'destinazioni'  => HeroSlide::destinazioni(),
            'inEvidenza'    => Annuncio::contaInEvidenza(),
        ]);
    }

    public function aggiornaSlide(Request $request, HeroSlide $slide)
    {
        $dati = $request->validateWithBag("slide{$slide->posizione}", [
            'titolo'      => 'required|string|max:80',
            'sottotitolo' => 'nullable|string|max:140',
            'link'        => ['required', Rule::in(array_keys(HeroSlide::destinazioni()))],
            'focus_x'     => 'required|integer|between:0,100',
            'focus_y'     => 'required|integer|between:0,100',
            'immagine'    => ['nullable', ...AnnuncioController::REGOLA_FOTO],
        ], [
            'titolo.required' => 'Il titolo della slide non può essere vuoto.',
            'immagine.max'    => 'La foto può pesare al massimo 15 MB.',
        ]);

        // al massimo un "a capo" nel titolo, come nel design originale
        $dati['titolo'] = preg_replace("/\r\n?/", "\n", trim($dati['titolo']));

        if ($request->hasFile('immagine')) {
            $vecchia = $slide->immagine;
            $dati['immagine'] = Immagini::salvaFoto($request->file('immagine'), 'home', 2000);
            HeroSlide::eliminaFile($vecchia);
        } else {
            unset($dati['immagine']);
        }

        $slide->update($dati);

        return redirect()->to(route('admin.home') . '#slide-' . $slide->posizione)
            ->with('success', "Slide {$slide->posizione} aggiornata.");
    }

    // cambia l'ordine delle slide: scambia la posizione con quella precedente o successiva
    public function spostaSlide(Request $request, HeroSlide $slide)
    {
        $verso = $request->input('direzione') === 'su' ? -1 : 1;
        $altra = HeroSlide::where('posizione', $slide->posizione + $verso)->first();

        if ($altra) {
            DB::transaction(function () use ($slide, $altra) {
                $da = $slide->posizione;
                $a = $altra->posizione;
                // la posizione è unica: passo da un valore libero per lo scambio
                $slide->update(['posizione' => 0]);
                $altra->update(['posizione' => $da]);
                $slide->update(['posizione' => $a]);
            });
        }

        return redirect()->to(route('admin.home') . '#slide-' . $slide->posizione)
            ->with('success', "Ordine delle slide aggiornato: questa ora è la slide {$slide->posizione}.");
    }

    public function aggiungiLogo(Request $request)
    {
        $request->validateWithBag('logo', [
            'nome' => 'required|string|max:60',
            'logo' => 'required|file|max:5120|mimes:jpg,jpeg,png,webp,svg',
        ], [
            'nome.required' => 'Scrivi il nome del brand.',
            'logo.required' => 'Scegli il file del logo.',
            'logo.mimes'    => 'Il logo deve essere JPG, PNG, WebP o SVG.',
            'logo.max'      => 'Il logo può pesare al massimo 5 MB.',
        ]);

        $file = $request->file('logo');
        if (Immagini::eSvg($file) && ! Immagini::svgSicuro(file_get_contents($file->getRealPath()))) {
            return back()->withErrors(['logo' => 'Questo SVG non può essere usato. Prova con una versione PNG del logo.'], 'logo');
        }

        [$percorso, $w, $h] = Immagini::salvaLogo($file);

        BrandLogo::create([
            'nome'      => $request->input('nome'),
            'immagine'  => $percorso,
            'larghezza' => $w,
            'altezza'   => $h,
            'ordine'    => (int) BrandLogo::max('ordine') + 1,
        ]);

        return redirect()->to(route('admin.home') . '#loghi')->with('success', 'Logo aggiunto.');
    }

    public function eliminaLogo(BrandLogo $logo)
    {
        HeroSlide::eliminaFile($logo->immagine);
        $logo->delete();

        return redirect()->to(route('admin.home') . '#loghi')->with('success', "Logo {$logo->nome} eliminato.");
    }

    public function spostaLogo(Request $request, BrandLogo $logo)
    {
        $loghi = BrandLogo::orderBy('ordine')->orderBy('id')->get()->values();
        $i = $loghi->search(fn ($l) => $l->id === $logo->id);
        $j = $request->input('direzione') === 'su' ? $i - 1 : $i + 1;

        if ($j >= 0 && $j < $loghi->count()) {
            $ordine = $loghi->pluck('id')->all();
            [$ordine[$i], $ordine[$j]] = [$ordine[$j], $ordine[$i]];
            foreach ($ordine as $pos => $id) {
                BrandLogo::whereKey($id)->update(['ordine' => $pos + 1]);
            }
        }

        return redirect()->to(route('admin.home') . '#loghi');
    }
}
