{{--
    Campi categoria + taglie per i form crea/modifica annuncio.
    Parametro opzionale: $annuncio (in modifica)
--}}
@use('App\Models\Annuncio')
@php
    $categoriaAttuale = old('categoria', $annuncio->categoria ?? '');
    $taglieAttuali = old('taglie', $annuncio->taglie ?? []) ?? [];
    $gruppi = [
        'abbigliamento' => ['label' => 'Taglie disponibili', 'valori' => Annuncio::TAGLIE_ABBIGLIAMENTO],
        'scarpe'        => ['label' => 'Numeri disponibili', 'valori' => Annuncio::TAGLIE_SCARPE],
    ];
@endphp

<div class="mb-3">
    <label class="form-label" for="categoriaSelect">Categoria</label>
    <select name="categoria" id="categoriaSelect" class="form-select" required>
        <option value="" disabled {{ $categoriaAttuale ? '' : 'selected' }}>Scegli la categoria…</option>
        @foreach(Annuncio::CATEGORIE as $slug => $label)
            <option value="{{ $slug }}"
                    data-tipo-taglie="{{ Annuncio::tipoTaglie($slug) }}"
                    {{ $categoriaAttuale === $slug ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

@foreach($gruppi as $tipo => $gruppo)
    <div class="mb-3 taglie-gruppo" data-tipo="{{ $tipo }}"
            @if(Annuncio::tipoTaglie($categoriaAttuale) !== $tipo) hidden @endif>
        <label class="form-label d-block">
            {{ $gruppo['label'] }}
            <small class="text-muted">(solo informative, seleziona quelle presenti in negozio)</small>
        </label>
        <div class="d-flex flex-wrap gap-2">
            @foreach($gruppo['valori'] as $valore)
                <input type="checkbox" class="btn-check" name="taglie[]"
                        id="taglia-{{ $tipo }}-{{ $valore }}" value="{{ $valore }}" autocomplete="off"
                        {{ in_array($valore, $taglieAttuali, true) && Annuncio::tipoTaglie($categoriaAttuale) === $tipo ? 'checked' : '' }}
                        @if(Annuncio::tipoTaglie($categoriaAttuale) !== $tipo) disabled @endif>
                <label class="btn btn-outline-dark taglia-pill" for="taglia-{{ $tipo }}-{{ $valore }}">{{ $valore }}</label>
            @endforeach
        </div>
    </div>
@endforeach
