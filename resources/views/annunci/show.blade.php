<x-layout>
    <div class="container py-5" style="margin-top: 80px;">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-5">

            {{-- Galleria immagini --}}
            <div class="col-12 col-lg-7">
                @if($annuncio->immagini->count())

                    {{-- immagine principale --}}
                    <div class="mb-3 position-relative">
                        <img id="imgPrincipale"
                            src="{{ Storage::url($annuncio->immagini->first()->path) }}"
                            class="img-fluid w-100"
                            style="height: 500px; object-fit: cover; border-radius: 4px; {{ $annuncio->stato === 'venduto' ? 'filter: grayscale(100%)' : '' }}"
                            alt="{{ $annuncio->titolo }}">

                        @if($annuncio->stato === 'venduto')
                            <div class="venduto-stamp venduto-stamp-lg">VENDUTO</div>
                        @endif
                    </div>

                    {{-- thumbnails --}}
                    @if($annuncio->immagini->count() > 1)
                        <div class="d-flex gap-2 overflow-auto">
                            @foreach($annuncio->immagini as $immagine)
                                <img src="{{ Storage::url($immagine->path) }}"
                                        class="img-thumbnail thumb-gallery"
                                        style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; flex-shrink: 0;"
                                        alt="foto"
                                        onclick="document.getElementById('imgPrincipale').src = this.src">
                            @endforeach
                        </div>
                    @endif

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

                @if($annuncio->descrizione)
                    <p class="mb-4" style="line-height: 1.8;">{{ $annuncio->descrizione }}</p>
                @endif

                <p class="text-muted small mb-4">
                    Pubblicato il {{ $annuncio->created_at?->format('d/m/Y') ?? 'N/D' }}
                </p>

                {{-- bottone WhatsApp pubblico --}}
                @if($annuncio->stato !== 'venduto')
                    @php
                        $msg = urlencode("Ciao! Ho visto questo capo sul tuo sito! Sarei interessata ad acquistarlo! Come possiamo metterci d'accordo?");
                    @endphp
                    <a href="https://wa.me/+393381520444?text={{ $msg }}"
                        target="_blank"
                        class="btn w-100 mb-3">
                        <i class="bi bi-whatsapp me-2"></i> Ordina
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

                        @if($annuncio->stato !== 'venduto')
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