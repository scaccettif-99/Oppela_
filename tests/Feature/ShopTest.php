<?php

namespace Tests\Feature;

use App\Models\Annuncio;
use App\Models\AnnuncioImmagine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['role' => 'admin'])->save();

        return $user;
    }

    // le due foto obbligatorie: modella + prodotto
    private function foto(): array
    {
        Storage::fake('public');

        return [
            'foto_modella'  => UploadedFile::fake()->image('modella.jpg', 800, 1200),
            'foto_prodotto' => [UploadedFile::fake()->image('prodotto.jpg', 800, 1200)],
        ];
    }

    private function annuncio(array $dati): Annuncio
    {
        return Annuncio::create(array_merge([
            'user_id' => User::factory()->create()->id,
            'titolo'  => 'Prodotto',
            'prezzo'  => 50,
            'stato'   => 'disponibile',
        ], $dati));
    }

    public function test_crea_annuncio_con_categoria_e_taglie_in_ordine(): void
    {
        $this->actingAs($this->admin())
            ->post(route('annunci.store'), [
                'titolo'    => 'Vestito lungo',
                'prezzo'    => 89,
                'categoria' => 'vestiti',
                'taglie'    => ['L', 'S', 'M'],
            ] + $this->foto())
            ->assertRedirect();

        $annuncio = Annuncio::first();
        $this->assertSame('vestiti', $annuncio->categoria);
        $this->assertSame(['S', 'M', 'L'], $annuncio->taglie);
        $this->assertSame('S · M · L', $annuncio->taglie_testo);
    }

    public function test_scarpe_accettano_solo_numeri(): void
    {
        $this->actingAs($this->admin())
            ->post(route('annunci.store'), [
                'titolo' => 'Sandalo', 'prezzo' => 60, 'categoria' => 'scarpe', 'taglie' => ['M'],
            ] + $this->foto())
            ->assertSessionHasErrors('taglie.0');

        $this->actingAs($this->admin())
            ->post(route('annunci.store'), [
                'titolo' => 'Sandalo', 'prezzo' => 60, 'categoria' => 'scarpe', 'taglie' => ['38', '37'],
            ] + $this->foto())
            ->assertSessionHasNoErrors();

        $this->assertSame(['37', '38'], Annuncio::first()->taglie);
    }

    public function test_categoria_obbligatoria_e_accessori_senza_taglie(): void
    {
        $this->actingAs($this->admin())
            ->post(route('annunci.store'), ['titolo' => 'Borsa', 'prezzo' => 40] + $this->foto())
            ->assertSessionHasErrors('categoria');

        $this->actingAs($this->admin())
            ->post(route('annunci.store'), ['titolo' => 'Borsa', 'prezzo' => 40, 'categoria' => 'accessori'] + $this->foto())
            ->assertSessionHasNoErrors();

        $this->assertNull(Annuncio::first()->taglie);
    }

    public function test_shop_mostra_solo_sezioni_con_annunci(): void
    {
        $this->annuncio(['titolo' => 'Borsa rossa', 'categoria' => 'accessori']);
        $this->annuncio(['titolo' => 'Jeans blu', 'categoria' => 'pantaloni', 'taglie' => ['M']]);

        $this->get(route('annunci.index'))
            ->assertOk()
            ->assertSee('id="accessori"', false)
            ->assertSee('id="pantaloni"', false)
            ->assertDontSee('id="scarpe"', false)
            ->assertDontSee('Rimuovi filtri')
            ->assertSee('Taglie:');
    }

    public function test_filtri_categoria_e_prezzo_combinati(): void
    {
        $this->annuncio(['titolo' => 'Borsa economica', 'categoria' => 'accessori', 'prezzo' => 20]);
        $this->annuncio(['titolo' => 'Borsa costosa', 'categoria' => 'accessori', 'prezzo' => 200]);
        $this->annuncio(['titolo' => 'Jeans blu', 'categoria' => 'pantaloni', 'prezzo' => 70]);

        $this->get(route('annunci.index', ['categoria' => 'accessori', 'prezzo' => 'desc']))
            ->assertOk()
            ->assertDontSee('Jeans blu')
            ->assertSeeInOrder(['Borsa costosa', 'Borsa economica'])
            ->assertSee('Rimuovi filtri');

        $this->get(route('annunci.index', ['prezzo' => 'asc']))
            ->assertSeeInOrder(['Borsa economica', 'Borsa costosa']);
    }

    public function test_salvare_modifiche_non_elimina_annuncio_con_foto(): void
    {
        Storage::fake('public');
        $annuncio = $this->annuncio(['titolo' => 'Vecchio titolo', 'categoria' => 'vestiti']);
        AnnuncioImmagine::create(['annuncio_id' => $annuncio->id, 'path' => 'annunci/x.jpg', 'ordine' => 0]);

        $admin = $this->admin();
        $html = $this->actingAs($admin)->get(route('annunci.edit', $annuncio))->assertOk()->getContent();

        // il form principale non deve contenere form annidati
        $principale = substr($html, strpos($html, 'action="' . route('annunci.update', $annuncio)));
        $principale = substr($principale, 0, strpos($principale, '</form>'));
        $this->assertStringNotContainsString('<form', $principale);

        $this->actingAs($admin)
            ->put(route('annunci.update', $annuncio), [
                'titolo' => 'Nuovo titolo', 'prezzo' => 55, 'categoria' => 'vestiti', 'taglie' => ['XS'],
            ])
            ->assertRedirect(route('annunci.show', $annuncio));

        $annuncio->refresh();
        $this->assertFalse($annuncio->trashed());
        $this->assertSame('Nuovo titolo', $annuncio->titolo);
        $this->assertSame(['XS'], $annuncio->taglie);
    }

    public function test_eliminazione_definitiva_solo_dal_cestino(): void
    {
        $admin = $this->admin();
        $annuncio = $this->annuncio(['categoria' => 'accessori']);

        $this->actingAs($admin)->delete(route('annunci.forceDestroy', $annuncio))->assertNotFound();

        $annuncio->delete();
        $this->actingAs($admin)->delete(route('annunci.forceDestroy', $annuncio))->assertRedirect();
        $this->assertSame(0, Annuncio::withTrashed()->count());
    }

    public function test_visitatore_non_puo_creare_annunci(): void
    {
        $this->post(route('annunci.store'), ['titolo' => 'X', 'prezzo' => 1, 'categoria' => 'accessori'])
            ->assertRedirect(route('login'));
    }

    public function test_rimetti_in_vendita_annulla_il_venduto(): void
    {
        $admin = $this->admin();
        $annuncio = $this->annuncio(['categoria' => 'vestiti']);

        $this->actingAs($admin)->patch(route('annunci.venduto', $annuncio));
        $this->assertSame('venduto', $annuncio->fresh()->stato);

        // il pulsante compare su shop, dettaglio e profilo
        $this->actingAs($admin)->get(route('annunci.index'))->assertSee('Rimetti in vendita');
        $this->actingAs($admin)->get(route('annunci.show', $annuncio))->assertSee('Rimetti in vendita');

        $this->actingAs($admin)->patch(route('annunci.disponibile', $annuncio))->assertRedirect();

        $annuncio->refresh();
        $this->assertSame('disponibile', $annuncio->stato);
        $this->assertNull($annuncio->sold_at);
        $this->assertSame(0, Annuncio::daEliminare()->count());
    }

    public function test_visitatore_non_puo_rimettere_in_vendita(): void
    {
        $annuncio = $this->annuncio(['categoria' => 'vestiti', 'stato' => 'venduto', 'sold_at' => now()]);

        $this->patch(route('annunci.disponibile', $annuncio))->assertRedirect(route('login'));
        $this->get(route('annunci.show', $annuncio))->assertDontSee('Rimetti in vendita');
        $this->assertSame('venduto', $annuncio->fresh()->stato);
    }
}
