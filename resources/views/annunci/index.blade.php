<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Annunci</h1>
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'owner']))
                <a href="{{ route('annunci.create') }}" class="btn">
                    <i class="bi bi-plus-lg me-1"></i> Nuovo annuncio
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            @forelse($annunci as $annuncio)
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm position-relative">

                        {{-- immagine copertina --}}
                        @if($annuncio->immagineCopertina)
                            <div class="position-relative">
                                <img src="{{ Storage::url($annuncio->immagineCopertina->path) }}"
                                     class="card-img-top"
                                     style="height: 320px; object-fit: cover; {{ $annuncio->stato === 'venduto' ? 'filter: grayscale(100%)' : '' }}"
                                     alt="{{ $annuncio->titolo }}">

                                {{-- timbro venduto --}}
                                @if($annuncio->stato === 'venduto')
                                    <div class="venduto-stamp">VENDUTO</div>
                                @endif
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $annuncio->titolo }}</h5>
                            @if($annuncio->brand)
                                <span class="badge mb-2" style="background-color: #feed02; color: #1a1814;">{{ $annuncio->brand }}</span>
                            @endif
                            <p class="card-text fw-bold">€ {{ number_format($annuncio->prezzo, 2, ',', '.') }}</p>
                        </div>

                        <div class="card-footer bg-white border-0 d-flex gap-2 flex-wrap">
                            <a href="{{ route('annunci.show', $annuncio) }}" class="btn btn-sm">Vai al dettaglio</a>

                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'owner']))
                                <a href="{{ route('annunci.edit', $annuncio) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('annunci.destroy', $annuncio) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Sei sicuro di voler eliminare questo annuncio?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @if($annuncio->stato !== 'venduto')
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
            @empty
                <p class="text-muted">Nessun annuncio disponibile.</p>
            @endforelse
        </div>
    </div>
</x-layout>