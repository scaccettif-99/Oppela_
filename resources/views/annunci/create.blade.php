<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <h1 class="mb-4">Crea nuovo annuncio</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('annunci.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Titolo</label>
                <input type="text" name="titolo" class="form-control" value="{{ old('titolo') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrizione</label>
                <textarea name="descrizione" class="form-control" rows="4">{{ old('descrizione') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prezzo (€)</label>
                <input type="number" name="prezzo" class="form-control" step="0.01" value="{{ old('prezzo') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
            </div>

            @include('annunci.partials.categoria-taglie', ['annuncio' => $annuncio ?? null])

            @include('annunci.partials.foto-nuove')

            @include('annunci.partials.evidenza-campo')

            <button type="submit" class="btn">Pubblica annuncio</button>
            <a href="{{ route('annunci.index') }}" class="btn btn-outline-secondary ms-2">Annulla</a>
        </form>
    </div>
</x-layout>