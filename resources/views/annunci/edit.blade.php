<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <h1 class="mb-4">Modifica annuncio</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('annunci.update', $annuncio) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Titolo</label>
                <input type="text" name="titolo" class="form-control" value="{{ old('titolo', $annuncio->titolo) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrizione</label>
                <textarea name="descrizione" class="form-control" rows="4">{{ old('descrizione', $annuncio->descrizione) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prezzo (€)</label>
                <input type="number" name="prezzo" class="form-control" step="0.01" value="{{ old('prezzo', $annuncio->prezzo) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand', $annuncio->brand) }}">
            </div>

            @include('annunci.partials.categoria-taglie', ['annuncio' => $annuncio ?? null])

            @include('annunci.partials.foto-gestione', ['annuncio' => $annuncio])

            @include('annunci.partials.evidenza-campo', ['annuncio' => $annuncio])

            <button type="submit" class="btn">Salva modifiche</button>
            <a href="{{ route('annunci.show', $annuncio) }}" class="btn btn-outline-secondary ms-2">Annulla</a>
        </form>

        {{-- form per eliminare e spostare le singole foto, fuori dal form principale --}}
        @foreach($annuncio->immagini as $immagine)
            <form id="elimina-foto-{{ $immagine->id }}" action="{{ route('annunci.immagine.destroy', $immagine) }}" method="POST" hidden>
                @csrf @method('DELETE')
            </form>
            @foreach(['su', 'giu'] as $direzione)
                <form id="sposta-foto-{{ $immagine->id }}-{{ $direzione }}" action="{{ route('annunci.immagine.sposta', $immagine) }}" method="POST" hidden>
                    @csrf @method('PATCH')
                    <input type="hidden" name="direzione" value="{{ $direzione }}">
                </form>
            @endforeach
        @endforeach
    </div>
</x-layout>