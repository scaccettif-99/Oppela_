<x-layout>
    <div class="container py-5" style="margin-top: 80px;">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h1 class="mb-5">Il mio profilo</h1>

        {{-- Cruscotto account in orizzontale --}}
        <div class="card border-0 shadow-sm p-4 mb-5">
            <div class="row g-4">

                {{-- Info account --}}
                <div class="col-12 col-md-6">
                    <h5 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Account
                    </h5>
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
                        <button type="submit" class="btn">Salva modifiche</button>
                    </form>
                </div>

                {{-- Cambia password --}}
                <div class="col-12 col-md-6">
                    <h5 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Cambia password
                    </h5>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf @method('PUT')
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
                        <button type="submit" class="btn">Aggiorna password</button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Riepilogo annunci con tabs --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                I miei annunci
            </h4>
            <a href="{{ route('annunci.create') }}" class="btn btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Nuovo
            </a>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-4" id="annunciTabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#attivi">
                    Attivi
                    <span class="badge ms-1" style="background-color: #feed02; color: #1a1814;">
                        {{ $annunciAttivi->count() }}
                    </span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#venduti">
                    Venduti
                    <span class="badge ms-1" style="background-color: #feed02; color: #1a1814;">
                        {{ $annunciVenduti->count() }}
                    </span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#eliminati">
                    Eliminati
                    <span class="badge ms-1" style="background-color: #1a1814; color: #feed02;">
                        {{ $annunciEliminati->count() }}
                    </span>
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- ATTIVI --}}
            <div class="tab-pane fade show active" id="attivi">
                @if($annunciAttivi->isEmpty())
                    <p class="text-muted">Nessun annuncio attivo.</p>
                @else
                    <div class="row g-3">
                        @foreach($annunciAttivi as $annuncio)
                            @include('profile.partials.annuncio-card', ['annuncio' => $annuncio])
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- VENDUTI --}}
            <div class="tab-pane fade" id="venduti">
                @if($annunciVenduti->isEmpty())
                    <p class="text-muted">Nessun annuncio venduto.</p>
                @else
                    <div class="row g-3">
                        @foreach($annunciVenduti as $annuncio)
                            @include('profile.partials.annuncio-card', ['annuncio' => $annuncio])
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ELIMINATI --}}
            <div class="tab-pane fade" id="eliminati">
                @if($annunciEliminati->isEmpty())
                    <p class="text-muted">Nessun annuncio eliminato.</p>
                @else
                    <div class="row g-3">
                        @foreach($annunciEliminati as $annuncio)
                            @include('profile.partials.annuncio-card', ['annuncio' => $annuncio, 'eliminato' => true])
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-layout>