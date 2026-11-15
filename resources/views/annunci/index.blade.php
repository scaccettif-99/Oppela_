<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Shop</h1>
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'owner']))
                <a href="{{ route('annunci.create') }}" class="btn">
                    <i class="bi bi-plus-lg me-1"></i> Nuovo annuncio
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filtri: categoria e ordinamento prezzo, combinabili --}}
        @if(count($categorieFiltro))
            <form method="GET" action="{{ route('annunci.index') }}" class="shop-filtri" id="shopFiltri">
                <div class="shop-filtri-categorie" role="group" aria-label="Filtra per categoria">
                    <input type="radio" class="btn-check" name="categoria" id="cat-tutte" value=""
                            {{ $categoria ? '' : 'checked' }}>
                    <label class="shop-pill" for="cat-tutte">Tutte</label>

                    @foreach($categorieFiltro as $slug => $label)
                        <input type="radio" class="btn-check" name="categoria" id="cat-{{ $slug }}" value="{{ $slug }}"
                                {{ $categoria === $slug ? 'checked' : '' }}>
                        <label class="shop-pill" for="cat-{{ $slug }}">{{ $label }}</label>
                    @endforeach
                </div>

                <div class="shop-filtri-azioni">
                    <label class="visually-hidden" for="ordinePrezzo">Ordina per prezzo</label>
                    <select name="prezzo" id="ordinePrezzo" class="form-select form-select-sm">
                        <option value="" {{ $prezzo ? '' : 'selected' }}>Ordina: più recenti</option>
                        <option value="asc" {{ $prezzo === 'asc' ? 'selected' : '' }}>Prezzo: dal meno costoso</option>
                        <option value="desc" {{ $prezzo === 'desc' ? 'selected' : '' }}>Prezzo: dal più costoso</option>
                    </select>

                    <noscript><button type="submit" class="btn btn-sm">Applica</button></noscript>

                    @if($filtriAttivi)
                        <a href="{{ route('annunci.index') }}" class="shop-reset">
                            <i class="bi bi-x-circle me-1"></i> Rimuovi filtri
                        </a>
                    @endif
                </div>
            </form>
        @endif

        {{-- Sezioni per categoria: compaiono solo se contengono annunci --}}
        @forelse($sezioni as $sezione)
            <section class="shop-sezione" id="{{ $sezione['slug'] }}">
                <div class="shop-sezione-header">
                    <h2 class="shop-sezione-title">{{ $sezione['label'] }}</h2>
                    <span class="shop-sezione-count">
                        {{ $sezione['annunci']->count() }} {{ $sezione['annunci']->count() === 1 ? 'prodotto' : 'prodotti' }}
                    </span>
                </div>
                <div class="row g-4">
                    @foreach($sezione['annunci'] as $annuncio)
                        @include('annunci.partials.card', ['annuncio' => $annuncio])
                    @endforeach
                </div>
            </section>
        @empty
            @if($filtriAttivi)
                <p class="text-muted">Nessun prodotto corrisponde ai filtri scelti.
                    <a href="{{ route('annunci.index') }}">Rimuovi filtri</a></p>
            @else
                <p class="text-muted">Nessun annuncio disponibile. Questa pagina sarà attiva a breve.</p>
            @endif
        @endforelse
    </div>
</x-layout>
