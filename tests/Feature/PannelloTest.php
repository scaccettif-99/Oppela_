<?php

namespace Tests\Feature;

use App\Models\Annuncio;
use App\Models\AnnuncioImmagine;
use App\Models\BrandLogo;
use App\Models\HeroSlide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

// Pannello di gestione: foto annunci, capi in evidenza, slide della hero, loghi, registrazione
class PannelloTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['role' => 'admin'])->save();

        return $user;
    }

    // annuncio con N foto finte (la prima è "la modella")
    private function annuncio(array $dati = [], int $foto = 2): Annuncio
    {
        $annuncio = Annuncio::create(array_merge([
            'user_id'   => User::factory()->create()->id,
            'titolo'    => 'Capo',
            'prezzo'    => 50,
            'categoria' => 'vestiti',
            'stato'     => 'disponibile',
        ], $dati));

        // la data di creazione non è "fillable": la imposto a mano per testare l'ordine
        if (isset($dati['created_at'])) {
            $annuncio->forceFill(['created_at' => $dati['created_at']])->save();
        }

        foreach (range(0, $foto - 1) as $i) {
            AnnuncioImmagine::create(['annuncio_id' => $annuncio->id, 'path' => "annunci/{$annuncio->id}-{$i}.jpg", 'ordine' => $i]);
        }

        return $annuncio;
    }

    private function datiAnnuncio(array $extra = []): array
    {
        return array_merge([
            'titolo'        => 'Abito lungo',
            'prezzo'        => 120,
            'categoria'     => 'vestiti',
            'foto_modella'  => UploadedFile::fake()->image('modella.jpg', 3000, 4000),
            'foto_prodotto' => [UploadedFile::fake()->image('prodotto.jpg', 800, 1000)],
        ], $extra);
    }

    // ---------- foto degli annunci ----------

    public function test_creazione_richiede_foto_modella_e_prodotto(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('annunci.store'), $this->datiAnnuncio(['foto_modella' => null]))
            ->assertSessionHasErrors('foto_modella');
        $this->actingAs($admin)->post(route('annunci.store'), $this->datiAnnuncio(['foto_prodotto' => []]))
            ->assertSessionHasErrors('foto_prodotto');

        $this->assertSame(0, Annuncio::count());
    }

    public function test_la_foto_modella_e_sempre_la_prima_e_le_foto_vengono_ridotte(): void
    {
        $this->actingAs($this->admin())->post(route('annunci.store'), $this->datiAnnuncio([
            'foto_prodotto' => [
                UploadedFile::fake()->image('prodotto1.jpg', 800, 1000),
                UploadedFile::fake()->image('prodotto2.jpg', 800, 1000),
            ],
        ]))->assertSessionHasNoErrors();

        $foto = Annuncio::first()->immagini;
        $this->assertCount(3, $foto);

        // la prima è la foto della modella (3000x4000), ridotta a 1600 px sul lato lungo
        [$w, $h] = getimagesize(Storage::disk('public')->path($foto[0]->path));
        $this->assertSame([1200, 1600], [$w, $h]);
        [$w2] = getimagesize(Storage::disk('public')->path($foto[1]->path));
        $this->assertSame(800, $w2); // le foto già piccole non vengono ingrandite
    }

    public function test_non_si_scende_sotto_due_foto_e_si_cambia_ordine(): void
    {
        $admin = $this->admin();
        $annuncio = $this->annuncio([], 2);
        [$prima, $seconda] = $annuncio->immagini->all();

        $this->actingAs($admin)->delete(route('annunci.immagine.destroy', $prima))->assertSessionHasErrors('foto');
        $this->assertSame(2, $annuncio->immagini()->count());

        $this->actingAs($admin)->patch(route('annunci.immagine.sposta', $seconda), ['direzione' => 'su']);
        $this->assertSame([$seconda->id, $prima->id], $annuncio->fresh()->immagini->pluck('id')->all());
    }

    // ---------- capi in evidenza ----------

    public function test_massimo_dieci_capi_in_evidenza(): void
    {
        $admin = $this->admin();
        foreach (range(1, 10) as $i) {
            $this->annuncio(['in_evidenza' => true]);
        }
        $undicesimo = $this->annuncio();

        $this->actingAs($admin)->patch(route('annunci.evidenza', $undicesimo))->assertSessionHasErrors('in_evidenza');
        $this->actingAs($admin)->post(route('annunci.store'), $this->datiAnnuncio(['in_evidenza' => 1]))
            ->assertSessionHasErrors('in_evidenza');

        $this->assertFalse($undicesimo->fresh()->in_evidenza);
        $this->assertSame(10, Annuncio::contaInEvidenza());
    }

    public function test_stella_mette_e_toglie_dalla_home(): void
    {
        $admin = $this->admin();
        $annuncio = $this->annuncio();

        $this->actingAs($admin)->patch(route('annunci.evidenza', $annuncio));
        $this->assertTrue($annuncio->fresh()->in_evidenza);
        $this->actingAs($admin)->patch(route('annunci.evidenza', $annuncio));
        $this->assertFalse($annuncio->fresh()->in_evidenza);
    }

    public function test_home_completa_fino_a_cinque_con_gli_ultimi_annunci(): void
    {
        $vecchio = $this->annuncio(['titolo' => 'Vecchio', 'created_at' => now()->subDays(10)]);
        $scelto = $this->annuncio(['titolo' => 'Scelto', 'in_evidenza' => true, 'created_at' => now()->subDays(20)]);
        $recente = $this->annuncio(['titolo' => 'Recente', 'created_at' => now()->subDay()]);
        $this->annuncio(['titolo' => 'Venduto', 'stato' => 'venduto', 'created_at' => now()]);
        $this->annuncio(['titolo' => 'UnaFoto', 'created_at' => now()], 1);

        // prima i scelti, poi gli ultimi annunci; mai venduti o con una sola foto
        $this->assertSame(['Scelto', 'Recente', 'Vecchio'], Annuncio::perHome()->pluck('titolo')->all());

        // in home: 3 annunci + 2 coppie di riserva = 5 card
        $html = $this->get('/')->assertOk()->getContent();
        $this->assertSame(5, substr_count($html, 'class="brand-card evidenza-card"'));
        $this->assertStringContainsString(route('annunci.show', $scelto), $html);
        $this->assertStringContainsString('Vai al dettaglio', $html);
        $this->assertSame(2, substr_count($html, 'Scopri lo shop'));
    }

    public function test_con_cinque_o_piu_scelti_niente_riempimento(): void
    {
        foreach (range(1, 7) as $i) {
            $this->annuncio(['titolo' => "Scelto{$i}", 'in_evidenza' => true]);
        }
        $this->annuncio(['titolo' => 'NonScelto']);

        $this->assertCount(7, Annuncio::perHome());
        $this->assertNotContains('NonScelto', Annuncio::perHome()->pluck('titolo'));
        $this->assertSame(0, substr_count($this->get('/')->getContent(), 'Scopri lo shop'));
    }

    public function test_senza_annunci_la_home_mostra_le_cinque_foto_di_riserva(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $this->assertSame(5, substr_count($html, 'class="brand-card evidenza-card"'));
        $this->assertStringContainsString('Set fotografico collezione primavera estate 2026', $html);
        $this->assertStringContainsString('Modella Annalisa Petrini', $html);
    }

    // ---------- slide della hero ----------

    public function test_le_slide_iniziali_sono_quelle_di_oggi(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('Scopri i nostri<br />', $html);
        $this->assertStringContainsString('media/coll_est_26_14.jpg', $html);
        $this->assertSame(3, HeroSlide::count());
    }

    public function test_paola_cambia_testi_foto_e_punto_focale_di_una_slide(): void
    {
        $slide = HeroSlide::where('posizione', 2)->first();

        $this->actingAs($this->admin())->put(route('admin.slide.update', $slide), [
            'titolo'      => "Nuova\ncollezione",
            'sottotitolo' => 'Arrivi di novembre',
            'link'        => 'shop:giacche',
            'focus_x'     => 30,
            'focus_y'     => 10,
            'immagine'    => UploadedFile::fake()->image('slide.jpg', 1200, 1800),
        ])->assertRedirect()->assertSessionHasNoErrors();

        $slide->refresh();
        $this->assertSame("Nuova\ncollezione", $slide->titolo);
        $this->assertStringStartsWith('home/', $slide->immagine);
        Storage::disk('public')->assertExists($slide->immagine);

        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('Nuova<br />', $html);
        $this->assertStringContainsString('Arrivi di novembre', $html);
        $this->assertStringContainsString('object-position: 30% 10%', $html);
        $this->assertStringContainsString(route('annunci.index', ['categoria' => 'giacche']), $html);
    }

    public function test_slide_titolo_obbligatorio_e_link_valido(): void
    {
        $slide = HeroSlide::first();
        $this->actingAs($this->admin())->put(route('admin.slide.update', $slide), [
            'titolo' => '', 'link' => 'sito-esterno', 'focus_x' => 50, 'focus_y' => 50,
        ])->assertSessionHasErrorsIn('slide1', ['titolo', 'link']);
    }

    public function test_paola_cambia_l_ordine_delle_slide(): void
    {
        $admin = $this->admin();
        $prima = HeroSlide::where('posizione', 1)->first();
        $seconda = HeroSlide::where('posizione', 2)->first();

        $this->actingAs($admin)->patch(route('admin.slide.sposta', $seconda), ['direzione' => 'su'])->assertRedirect();

        $this->assertSame(1, $seconda->fresh()->posizione);
        $this->assertSame(2, $prima->fresh()->posizione);

        // in home la slide spostata è la prima (quella aperta)
        $html = $this->get('/')->getContent();
        $this->assertLessThan(strpos($html, 'Collezione<br />' . "\n" . 'primavera estate'),
            strpos($html, 'Collezione<br />' . "\n" . 'autunno inverno'));

        // la prima non può salire, l'ultima non può scendere
        $this->actingAs($admin)->patch(route('admin.slide.sposta', $seconda->fresh()), ['direzione' => 'su']);
        $this->assertSame(1, $seconda->fresh()->posizione);
        $ultima = HeroSlide::where('posizione', 3)->first();
        $this->actingAs($admin)->patch(route('admin.slide.sposta', $ultima), ['direzione' => 'giu']);
        $this->assertSame(3, $ultima->fresh()->posizione);
    }

    // ---------- loghi ----------

    public function test_aggiungere_spostare_ed_eliminare_un_logo(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->get(route('admin.home'))->assertOk()->assertSee('Molly Bracken');

        $this->actingAs($admin)->post(route('admin.loghi.store'), [
            'nome' => 'Nuovo Brand',
            'logo' => UploadedFile::fake()->image('logo.png', 400, 120),
        ])->assertSessionHasNoErrors();

        $logo = BrandLogo::where('nome', 'Nuovo Brand')->first();
        $this->assertNotNull($logo);
        $this->assertSame([400, 120], [$logo->larghezza, $logo->altezza]);
        $this->assertSame(BrandLogo::max('ordine'), $logo->ordine); // in fondo
        $this->get('/')->assertSee('Nuovo Brand');

        $this->actingAs($admin)->patch(route('admin.loghi.sposta', $logo), ['direzione' => 'su']);
        $this->assertSame('Nuovo Brand', BrandLogo::orderBy('ordine')->get()->reverse()->values()[1]->nome);

        $this->actingAs($admin)->delete(route('admin.loghi.destroy', $logo));
        $this->assertNull(BrandLogo::find($logo->id));
        Storage::disk('public')->assertMissing($logo->immagine);
    }

    public function test_svg_con_codice_rifiutato(): void
    {
        $svg = UploadedFile::fake()->createWithContent('logo.svg',
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><script>alert(1)</script></svg>');

        $this->actingAs($this->admin())->post(route('admin.loghi.store'), ['nome' => 'X', 'logo' => $svg])
            ->assertSessionHasErrorsIn('logo', 'logo');
        $this->assertNull(BrandLogo::where('nome', 'X')->first());
    }

    // ---------- privacy ----------

    public function test_pagina_privacy_e_link_nel_footer(): void
    {
        config(['oppela.negozio.piva' => '01234567890']);

        $this->get(route('privacy'))->assertOk()
            ->assertSee('Paola Tinarelli')
            ->assertSee('Viale Papa Zaccaria 1/A')
            ->assertSee('P.IVA 01234567890')
            ->assertSee(config('session.cookie'))
            ->assertSee('OpenStreetMap');

        $this->get('/')->assertSee(route('privacy'))->assertSee('P.IVA 01234567890')
            ->assertSee('Sito creato da Francesco Scaccetti Web Dev');
    }

    public function test_senza_partita_iva_non_compare(): void
    {
        config(['oppela.negozio.piva' => null]);
        $this->get(route('privacy'))->assertOk()->assertDontSee('P.IVA');
    }

    // ---------- accessi ----------

    public function test_pannello_vietato_a_visitatori_e_clienti(): void
    {
        $this->get(route('admin.home'))->assertRedirect(route('login'));

        $cliente = User::factory()->create();
        $cliente->forceFill(['role' => 'cliente'])->save();
        $this->actingAs($cliente)->get(route('admin.home'))->assertForbidden();
    }

    public function test_registrazione_con_codice_invito(): void
    {
        config(['oppela.codice_registrazione' => 'oppela-2026']);
        $dati = ['name' => 'Paola', 'email' => 'paola@example.com', 'password' => 'password-sicura', 'password_confirmation' => 'password-sicura'];

        $this->post('/register', $dati + ['codice' => 'sbagliato'])->assertSessionHasErrors('codice');
        $this->assertGuest();

        $this->post('/register', $dati + ['codice' => 'oppela-2026'])->assertRedirect();
        $this->assertAuthenticated();
    }
}
