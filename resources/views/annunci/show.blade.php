<x-layout>
    <div class="container py-5" style="margin-top: 80px;">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-5">

            {{-- Galleria immagini --}}
            <div class="col-12 col-lg-7">
                @if($annuncio->immagini->count())

                    {{-- immagine principale: intera, cliccabile per ingrandire --}}
                    <div class="mb-3 position-relative show-main {{ $annuncio->stato === 'venduto' ? 'is-grey' : '' }}"
                            id="showMain" role="button" aria-label="Ingrandisci foto">
                        <img id="imgPrincipaleBg"
                            src="{{ Storage::url($annuncio->immagini->first()->path) }}"
                            class="show-main-bg" alt="" aria-hidden="true">
                        <img id="imgPrincipale"
                            src="{{ Storage::url($annuncio->immagini->first()->path) }}"
                            class="show-main-img"
                            alt="{{ $annuncio->titolo }}">

                        <span class="show-main-zoom-hint">
                            <i class="bi bi-zoom-in me-1"></i> Clicca per ingrandire
                        </span>

                        @if($annuncio->stato === 'venduto')
                            <div class="venduto-stamp venduto-stamp-lg">VENDUTO</div>
                        @endif
                    </div>

                    {{-- thumbnails --}}
                    @if($annuncio->immagini->count() > 1)
                        <div class="d-flex gap-2 overflow-auto">
                            @foreach($annuncio->immagini as $i => $immagine)
                                <img src="{{ Storage::url($immagine->path) }}"
                                        class="img-thumbnail thumb-gallery {{ $i === 0 ? 'active' : '' }}"
                                        data-index="{{ $i }}"
                                        style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; flex-shrink: 0;"
                                        alt="foto {{ $i + 1 }}">
                            @endforeach
                        </div>
                    @endif

                    {{-- lightbox con zoom --}}
                    <div class="lightbox zoom-lightbox" id="zoomLightbox"
                            data-images='@json($annuncio->immagini->map(fn ($img) => Storage::url($img->path))->values())'>
                        <button class="lightbox-close" id="zoomClose" aria-label="Chiudi">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        @if($annuncio->immagini->count() > 1)
                            <button class="lightbox-prev" id="zoomPrev" aria-label="Foto precedente">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="lightbox-next" id="zoomNext" aria-label="Foto successiva">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        @endif
                        <div class="zoom-stage" id="zoomStage">
                            <img src="" alt="{{ $annuncio->titolo }}" id="zoomImg" draggable="false">
                        </div>
                        <div class="zoom-controls">
                            <button type="button" id="zoomOut" aria-label="Riduci"><i class="bi bi-zoom-out"></i></button>
                            <span id="zoomCounter"></span>
                            <button type="button" id="zoomIn" aria-label="Ingrandisci"><i class="bi bi-zoom-in"></i></button>
                        </div>
                    </div>

                @endif
            </div>

            {{-- Dettagli --}}
            <div class="col-12 col-lg-5">
                <h1 class="mb-2">{{ $annuncio->titolo }}</h1>

                @if($annuncio->brand)
                    <span class="badge mb-3" style="background-color: #feed02; color: #1a1814; font-size: 0.85rem;">
                        {{ $annuncio->brand }}
                    </span>
                @endif

                <p class="fs-3 fw-bold mb-3">€ {{ number_format($annuncio->prezzo, 2, ',', '.') }}</p>

                <p class="mb-3">
                    <a href="{{ route('annunci.index', ['categoria' => $annuncio->categoria]) }}" class="show-categoria">
                        {{ $annuncio->categoria_label }}
                    </a>
                </p>

                @if($annuncio->taglie_testo)
                    <div class="mb-4">
                        <p class="small text-muted mb-2">
                            {{ $annuncio->categoria === 'scarpe' ? 'Numeri disponibili in negozio' : 'Taglie disponibili in negozio' }}
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(array_intersect(\App\Models\Annuncio::taglieAmmesse($annuncio->categoria), $annuncio->taglie ?? []) as $taglia)
                                <span class="taglia-info">{{ $taglia }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($annuncio->descrizione)
                    <p class="mb-4" style="line-height: 1.8;">{{ $annuncio->descrizione }}</p>
                @endif

                <p class="text-muted small mb-4">
                    Pubblicato il {{ $annuncio->created_at?->format('d/m/Y') ?? 'N/D' }}
                </p>

                {{-- bottone WhatsApp pubblico: richiesta info su questo prodotto --}}
                @if($annuncio->stato !== 'venduto')
                    <a href="{{ $annuncio->whatsapp_url }}"
                        target="_blank" rel="noopener"
                        class="btn w-100 mb-3">
                        <i class="bi bi-whatsapp me-2"></i> Chiedi info su WhatsApp
                    </a>
                @endif

                {{-- bottoni admin/owner --}}
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'owner']))
                    <div class="d-flex gap-2 flex-wrap mt-3 pt-3 border-top">
                        <a href="{{ route('annunci.edit', $annuncio) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil me-1"></i> Modifica
                        </a>

                        <form action="{{ route('annunci.destroy', $annuncio) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Eliminare definitivamente questo annuncio?')">
                                <i class="bi bi-trash me-1"></i> Elimina
                            </button>
                        </form>

                        @if($annuncio->stato === 'venduto')
                            <form action="{{ route('annunci.disponibile', $annuncio) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-secondary"
                                        onclick="return confirm('Rimettere in vendita questo articolo?')">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Rimetti in vendita
                                </button>
                            </form>
                        @else
                            <form action="{{ route('annunci.venduto', $annuncio) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-check-circle me-1"></i> Segna come venduto
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-layout>