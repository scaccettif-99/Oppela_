<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <h1 class="mb-5">Il mio profilo</h1>
        
        <div class="row g-4">
            
            {{-- Cruscotto account --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Account
                    </h5>
                    
                    {{-- Aggiorna info --}}
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted">Nome</label>
                            <input type="text" name="name" class="form-control"
                            value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted">Email</label>
                            <input type="email" name="email" class="form-control"
                            value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        
                        <button type="submit" class="btn w-100 mb-4">Salva modifiche</button>
                    </form>
                    
                    {{-- Aggiorna password --}}
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf @method('PUT')
                        
                        <h6 class="mb-3" style="border-bottom: 1px solid #eee; padding-bottom: 0.6rem;">
                            Cambia password
                        </h6>
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted">Password attuale</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted">Nuova password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted">Conferma nuova password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn w-100">Aggiorna password</button>
                    </form>
                </div>
            </div>
            
            {{-- Riepilogo annunci --}}
            <div class="col-12 col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        I miei annunci
                    </h5>
                    <a href="{{ route('annunci.create') }}" class="btn btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Nuovo
                    </a>
                </div>
                
                @if($annunci->isEmpty())
                <p class="text-muted">Nessun annuncio pubblicato.</p>
                @else
                <div class="row g-3">
                    @foreach($annunci as $annuncio)
                    <div class="col-12 col-sm-6">
                        <div class="card border-0 shadow-sm h-100 position-relative">
                            
                            {{-- immagine copertina --}}
                            @if($annuncio->immagineCopertina)
                            <div class="position-relative">
                                <img src="{{ Storage::url($annuncio->immagineCopertina->path) }}"
                                class="card-img-top"
                                style="height: 200px; object-fit: cover; {{ $annuncio->stato === 'venduto' ? 'filter: grayscale(100%)' : '' }}"
                                alt="{{ $annuncio->titolo }}">
                                
                                @if($annuncio->stato === 'venduto')
                                <div class="venduto-stamp">VENDUTO</div>
                                @endif
                            </div>
                            @endif
                            
                            <div class="card-body">
                                <h6 class="card-title">{{ $annuncio->titolo }}</h6>
                                @if($annuncio->brand)
                                <span class="badge mb-2"
                                style="background-color: #feed02; color: #1a1814;">
                                {{ $annuncio->brand }}
                            </span>
                            @endif
                            <p class="fw-bold mb-1">€ {{ number_format($annuncio->prezzo, 2, ',', '.') }}</p>
                            <p class="text-muted small mb-0">
                                {{ $annuncio->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        
                        <div class="card-footer bg-white border-0 d-flex gap-2 flex-wrap">
                            <a href="{{ route('annunci.show', $annuncio) }}"
                            class="btn btn-sm">
                            Vai al dettaglio
                        </a>
                        <a href="{{ route('annunci.edit', $annuncio) }}"
                        class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('annunci.destroy', $annuncio) }}"
                    method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Eliminare questo annuncio?')">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
            @if($annuncio->stato !== 'venduto')
            <form action="{{ route('annunci.venduto', $annuncio) }}"
            method="POST" class="d-inline">
            @csrf @method('PATCH')
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-check-circle"></i>
            </button>
        </form>
        @endif
    </div>
    
</div>
</div>
@endforeach
</div>
@endif
</div>

</div>
</div>
</x-layout>