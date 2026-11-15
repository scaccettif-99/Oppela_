{{--
    Slider foto per le card annuncio.
    Parametri: $annuncio, $height (es. '320px'), $grigio (bool), $link (url o null)
--}}
@php
    $immagini = $annuncio->immagini;
    $grigio = $grigio ?? false;
@endphp

<div class="card-slider {{ $grigio ? 'is-grey' : '' }}"
        style="height: {{ $height ?? '320px' }};"
        @if(!empty($link)) data-href="{{ $link }}" @endif>

    @if($immagini->count())
        <div class="card-slider-track">
            @foreach($immagini as $immagine)
                <div class="card-slide">
                    <img src="{{ Storage::url($immagine->path) }}" class="card-slide-bg" alt="" aria-hidden="true" loading="lazy">
                    <img src="{{ Storage::url($immagine->path) }}" class="card-slide-img" alt="{{ $annuncio->titolo }}" loading="lazy" draggable="false">
                </div>
            @endforeach
        </div>

        @if($immagini->count() > 1)
            <button type="button" class="card-slider-btn prev" aria-label="Foto precedente">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button type="button" class="card-slider-btn next" aria-label="Foto successiva">
                <i class="bi bi-chevron-right"></i>
            </button>
            <div class="card-slide-dots">
                @foreach($immagini as $i => $immagine)
                    <span class="slide-dot {{ $i === 0 ? 'active' : '' }}"></span>
                @endforeach
            </div>
        @endif
    @else
        <div class="card-slider-empty"><i class="bi bi-image"></i></div>
    @endif

</div>
