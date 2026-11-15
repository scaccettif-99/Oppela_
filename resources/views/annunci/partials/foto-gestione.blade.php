{{--
    Foto in modifica annuncio: ordine con le frecce, eliminazione, aggiunta.
    I pulsanti usano form esterni (attributo form=): i form annidati non sono validi in HTML.
    I form veri e propri sono in fondo alla pagina (foto-gestione-form).
--}}
@use('App\Models\Annuncio')
@php
    $totale = $annuncio->immagini->count();
    $puoEliminare = $totale > Annuncio::FOTO_MIN;
@endphp

<div class="foto-annuncio mb-4">
    <h5 class="foto-annuncio-titolo">Foto</h5>
    <p class="small text-muted mb-3">
        La <strong>prima</strong> foto deve essere quella con la modella, la <strong>seconda</strong> quella del prodotto:
        in home compare al passaggio del mouse. Usa le frecce per cambiare l'ordine.
    </p>

    <div class="foto-lista">
        @foreach($annuncio->immagini as $i => $immagine)
            <div class="foto-item">
                <span class="foto-item-ruolo {{ $i === 0 ? 'is-modella' : '' }}">
                    {{ $i + 1 }} · {{ $i === 0 ? 'Modella' : 'Prodotto' }}
                </span>
                <img src="{{ Storage::url($immagine->path) }}" alt="Foto {{ $i + 1 }}">
                <div class="foto-item-azioni">
                    <button type="submit" form="sposta-foto-{{ $immagine->id }}-su" class="foto-btn"
                            title="Sposta prima" aria-label="Sposta prima" @disabled($i === 0)>
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button type="submit" form="elimina-foto-{{ $immagine->id }}" class="foto-btn foto-btn-elimina"
                            title="{{ $puoEliminare ? 'Elimina' : 'Servono almeno ' . Annuncio::FOTO_MIN . ' foto' }}"
                            aria-label="Elimina foto" @disabled(! $puoEliminare)
                            onclick="return confirm('Eliminare questa foto?')">
                        <i class="bi bi-trash"></i>
                    </button>
                    <button type="submit" form="sposta-foto-{{ $immagine->id }}-giu" class="foto-btn"
                            title="Sposta dopo" aria-label="Sposta dopo" @disabled($i === $totale - 1)>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    @if($totale < Annuncio::FOTO_MAX)
        <div class="mt-3">
            <label class="form-label" for="fotoProdotto">
                Aggiungi foto del prodotto (ancora {{ Annuncio::FOTO_MAX - $totale }} al massimo)
            </label>
            <input type="file" name="foto_prodotto[]" id="fotoProdotto" class="form-control"
                    accept="image/jpeg,image/png,image/webp" multiple data-anteprima-input>
            <span class="foto-slot-anteprima mt-2" data-anteprima="fotoProdotto"></span>
            <small class="text-muted">Le nuove foto vanno in fondo. Per cambiare la foto della modella: aggiungi quella nuova, portala al primo posto con le frecce ed elimina la vecchia.</small>
        </div>
    @endif
</div>
