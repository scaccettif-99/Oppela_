{{--
    Carosello "Collezione Primavera Estate 2026".
    Parametri: $scrollId (id univoco del contenitore, usato dalle frecce)
--}}
<div class="brand-scroll-wrapper" id="{{ $scrollId }}">
    <div class="brand-scroll">
        @foreach(range(1, 16) as $n)
            <div class="brand-card collezione-card gallery-item"
                    data-src="{{ asset('media/coll_est_26_' . $n . '.jpg') }}"
                    data-caption="Collezione Primavera Estate 2026">
                <img src="{{ \App\Support\Immagini::mini('media/coll_est_26_' . $n . '.jpg') }}"
                        alt="Collezione Primavera Estate 2026 - foto {{ $n }}"
                        loading="lazy">
            </div>
        @endforeach
    </div>
</div>
