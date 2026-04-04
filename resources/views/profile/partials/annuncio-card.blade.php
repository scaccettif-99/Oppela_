<div class="col-12 col-sm-6 col-lg-4">
    <div class="card border-0 shadow-sm h-100 position-relative annuncio-card">

        @if($annuncio->immagineCopertina)
            <div class="position-relative">
                <img src="{{ Storage::url($annuncio->immagineCopertina->path) }}"
                    class="card-img-top"
                    style="height: 200px; object-fit: cover; {{ $annuncio->stato === 'venduto' || ($eliminato ?? false) ? 'filter: grayscale(100%)' : '' }}"
                    alt="{{ $annuncio->titolo }}">

                @if($annuncio->stato === 'venduto')
                    <div class="venduto-stamp">VENDUTO</div>
                @endif

                @if($eliminato ?? false)
                    <div class="venduto-stamp" style="border-color: rgba(100,100,100,0.8); color: rgba(100,100,100,0.8);">
                        ELIMINATO
                    </div>
                @endif
            </div>
        @endif

        <div class="card-body">
            <h6 class="card-title">{{ $annuncio->titolo }}</h6>
            @if($annuncio->brand)
                <span class="badge mb-2" style="background-color: #feed02; color: #1a1814;">
                    {{ $annuncio->brand }}
                </span>
            @endif
            <p class="fw-bold mb-1">€ {{ number_format($annuncio->prezzo, 2, ',', '.') }}</p>
            <p class="text-muted small mb-0">
                {{ $annuncio->created_at?->format('d/m/Y') ?? 'N/D' }}
            </p>
        </div>

        @unless($eliminato ?? false)
            <div class="card-footer bg-white border-0 d-flex gap-2 flex-wrap">
                <a href="{{ route('annunci.show', $annuncio) }}" class="btn btn-sm">
                    Vai al dettaglio
                </a>
                <a href="{{ route('annunci.edit', $annuncio) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('annunci.destroy', $annuncio) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Eliminare questo annuncio?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                @if($annuncio->stato !== 'venduto')
                    <form action="{{ route('annunci.venduto', $annuncio) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-check-circle"></i>
                        </button>
                    </form>
                @endif
            </div>
        @endunless

    </div>
</div>