<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <h1 class="mb-4">Modifica annuncio</h1>

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

            {{-- immagini attuali --}}
            @if($annuncio->immagini->count())
                <div class="mb-3">
                    <label class="form-label">Foto attuali</label>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($annuncio->immagini as $immagine)
                            <div class="position-relative">
                                <img src="{{ Storage::url($immagine->path) }}"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;"
                                    alt="foto">
                                <form action="{{ route('annunci.immagine.destroy', $immagine) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                            style="padding: 2px 6px; font-size: 0.7rem;">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- aggiungi nuove foto --}}
            @if($annuncio->immagini->count() < 5)
                <div class="mb-3">
                    <label class="form-label">Aggiungi foto (max {{ 5 - $annuncio->immagini->count() }} ancora)</label>
                    <input type="file" name="immagini[]" class="form-control" multiple accept="image/*">
                </div>
            @endif

            <button type="submit" class="btn">Salva modifiche</button>
            <a href="{{ route('annunci.show', $annuncio) }}" class="btn btn-outline-secondary ms-2">Annulla</a>
        </form>
    </div>
</x-layout>