{{-- Card annuncio nello shop. Parametro: $annuncio --}}
@php
    $isAdmin = auth()->check() && in_array(auth()->user()->role, ['admin', 'owner']);
    $venduto = $annuncio->stato === 'venduto';
@endphp

<div class="col-12 col-sm-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm position-relative annuncio-card">

        {{-- slide immagini --}}
        <div class="position-relative">
            @include('annunci.partials.slider', [
                'annuncio' => $annuncio,
                'height'   => '320px',
                'grigio'   => $venduto,
                'link'     => route('annunci.show', $annuncio),
            ])
            @if($venduto)
                <div class="venduto-stamp">VENDUTO</div>
            @endif
        </div>

        <div class="card-body">
            <h5 class="card-title">{{ $annuncio->titolo }}</h5>
            @if($annuncio->brand)
                <span class="badge mb-2" style="background-color: #feed02; color: #1a1814;">{{ $annuncio->brand }}</span>
            @endif
            <p class="card-text fw-bold mb-2">€ {{ number_format($annuncio->prezzo, 2, ',', '.') }}</p>

            @if($annuncio->taglie_testo)
                <p class="card-taglie mb-0">
                    <span>{{ $annuncio->categoria === 'scarpe' ? 'Numeri' : 'Taglie' }}:</span>
                    {{ $annuncio->taglie_testo }}
                </p>
            @endif
        </div>

        <div class="card-footer bg-white border-0 d-flex gap-2 flex-wrap">
            <a href="{{ route('annunci.show', $annuncio) }}" class="btn btn-sm">Vai al dettaglio</a>

            @unless($venduto)
                <a href="{{ $annuncio->whatsapp_url }}" target="_blank" rel="noopener"
                    class="btn btn-sm btn-whatsapp-info">
                    <i class="bi bi-whatsapp me-1"></i> Chiedi info
                </a>
            @endunless

            @if($isAdmin)
                <a href="{{ route('annunci.edit', $annuncio) }}" class="btn btn-sm btn-outline-secondary" aria-label="Modifica">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('annunci.destroy', $annuncio) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" aria-label="Elimina"
                            onclick="return confirm('Sei sicuro di voler eliminare questo annuncio?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                @if($venduto)
                    <form action="{{ route('annunci.disponibile', $annuncio) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-secondary"
                                onclick="return confirm('Rimettere in vendita questo articolo?')">
                            <i class="bi bi-arrow-counterclockwise"></i> Rimetti in vendita
                        </button>
                    </form>
                @else
                    <form action="{{ route('annunci.venduto', $annuncio) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-check-circle"></i> Venduto
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
