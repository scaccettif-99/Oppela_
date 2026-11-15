<x-layout>
    <div class="container py-5 admin-home" style="margin-top: 80px;">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-2">
            <h1 class="mb-0">Personalizza home</h1>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('welcome') }}" target="_blank" class="btn btn-sm">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Guarda la home
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Torna al profilo
                </a>
            </div>
        </div>
        <p class="text-muted mb-4">Qui cambi le foto e i testi delle tre slide in cima alla home, il loro ordine (frecce accanto al titolo) e i loghi dei brand.</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <nav class="admin-indice mb-5">
            <a href="#slide-1">Slide 1</a>
            <a href="#slide-2">Slide 2</a>
            <a href="#slide-3">Slide 3</a>
            <a href="#loghi">Loghi brand</a>
            <a href="#evidenza">Capi in evidenza</a>
        </nav>

        {{-- SLIDE DELLA HERO --}}
        @foreach($slides as $slide)
            @php
                $bag = $errors->getBag('slide' . $slide->posizione);
                $mio = old('_slide') == $slide->posizione; // i valori vecchi solo per la slide appena inviata
                $valore = fn ($campo) => $mio ? old($campo, $slide->$campo) : $slide->$campo;
            @endphp
            <section class="admin-card mb-5" id="slide-{{ $slide->posizione }}">
                <div class="admin-card-title d-flex justify-content-between align-items-center gap-3">
                    <h2 class="h5 mb-0">Slide {{ $slide->posizione }}{{ $slide->posizione === 1 ? ' · la prima che si vede' : '' }}</h2>
                    <div class="slide-ordine">
                        <span class="small text-muted d-none d-sm-inline">Ordine</span>
                        <button type="submit" form="sposta-slide-{{ $slide->id }}-su" class="foto-btn"
                                title="Sposta prima" aria-label="Sposta la slide prima" @disabled($slide->posizione === 1)>
                            <i class="bi bi-arrow-up"></i>
                        </button>
                        <button type="submit" form="sposta-slide-{{ $slide->id }}-giu" class="foto-btn"
                                title="Sposta dopo" aria-label="Sposta la slide dopo" @disabled($slide->posizione === $slides->count())>
                            <i class="bi bi-arrow-down"></i>
                        </button>
                    </div>
                </div>

                @if($bag->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($bag->all() as $errore)
                                <li>{{ $errore }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.slide.update', $slide) }}" method="POST" enctype="multipart/form-data"
                        class="row g-4 slide-form">
                    @csrf @method('PUT')
                    <input type="hidden" name="_slide" value="{{ $slide->posizione }}">

                    <div class="col-12 col-lg-5">
                        <div class="mb-3">
                            <label class="form-label" for="titolo-{{ $slide->posizione }}">Titolo</label>
                            <textarea name="titolo" id="titolo-{{ $slide->posizione }}" class="form-control" rows="2"
                                    maxlength="80" required>{{ $valore('titolo') }}</textarea>
                            <small class="text-muted">Premi Invio per andare a capo (consigliato: due righe brevi).</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="sottotitolo-{{ $slide->posizione }}">Sottotitolo</label>
                            <input type="text" name="sottotitolo" id="sottotitolo-{{ $slide->posizione }}" class="form-control"
                                    maxlength="140" value="{{ $valore('sottotitolo') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="link-{{ $slide->posizione }}">Il pulsante "Scopri" porta a</label>
                            <select name="link" id="link-{{ $slide->posizione }}" class="form-select">
                                @foreach($destinazioni as $chiave => $etichetta)
                                    <option value="{{ $chiave }}" @selected($valore('link') === $chiave)>{{ $etichetta }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="immagine-{{ $slide->posizione }}">Cambia foto</label>
                            <input type="file" name="immagine" id="immagine-{{ $slide->posizione }}" class="form-control"
                                    accept="image/jpeg,image/png,image/webp" data-focus-file>
                            <small class="text-muted">Meglio una foto verticale. Anche dal telefono, max 15 MB.</small>
                        </div>

                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="focus-picker" data-focus-picker>
                            <input type="hidden" name="focus_x" value="{{ $valore('focus_x') }}" data-focus-x>
                            <input type="hidden" name="focus_y" value="{{ $valore('focus_y') }}" data-focus-y>

                            <p class="form-label mb-2">
                                <i class="bi bi-crosshair me-1"></i>
                                Clicca sulla foto nel punto che deve restare sempre visibile (es. il volto)
                            </p>
                            <div class="focus-sorgente" data-focus-area>
                                <img src="{{ $slide->immagine_url }}" alt="Foto della slide {{ $slide->posizione }}" data-focus-img>
                                <span class="focus-punto" data-focus-punto></span>
                            </div>

                            <div class="focus-anteprime">
                                <figure>
                                    <div class="focus-anteprima focus-anteprima-desktop">
                                        <img src="{{ $slide->immagine_url }}" alt="" data-focus-anteprima>
                                    </div>
                                    <figcaption>Computer</figcaption>
                                </figure>
                                <figure>
                                    <div class="focus-anteprima focus-anteprima-telefono">
                                        <img src="{{ $slide->immagine_url }}" alt="" data-focus-anteprima>
                                    </div>
                                    <figcaption>Telefono</figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn mb-0">
                            <i class="bi bi-check-lg me-1"></i> Salva slide {{ $slide->posizione }}
                        </button>
                    </div>
                </form>
            </section>
        @endforeach

        {{-- LOGHI DEI BRAND --}}
        <section class="admin-card mb-5" id="loghi">
            <h2 class="admin-card-title">Loghi dei brand</h2>
            <p class="text-muted">Compaiono nella striscia che scorre in home, in questo ordine.</p>

            @php $bagLogo = $errors->getBag('logo'); @endphp

            <div class="loghi-lista mb-4">
                @forelse($loghi as $i => $logo)
                    @php [$lw, $lh] = $logo->dimensioniSchermo(); @endphp
                    <div class="logo-item">
                        <div class="logo-item-img">
                            <img src="{{ $logo->url }}" alt="{{ $logo->nome }}" style="width: {{ $lw }}px; height: {{ $lh }}px;">
                        </div>
                        <span class="logo-item-nome">{{ $logo->nome }}</span>
                        <div class="foto-item-azioni">
                            <button type="submit" form="sposta-logo-{{ $logo->id }}-su" class="foto-btn"
                                    title="Sposta prima" aria-label="Sposta prima" @disabled($i === 0)>
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <button type="submit" form="elimina-logo-{{ $logo->id }}" class="foto-btn foto-btn-elimina"
                                    title="Elimina" aria-label="Elimina logo {{ $logo->nome }}"
                                    onclick="return confirm('Togliere il logo {{ $logo->nome }} dalla home?')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button type="submit" form="sposta-logo-{{ $logo->id }}-giu" class="foto-btn"
                                    title="Sposta dopo" aria-label="Sposta dopo" @disabled($i === $loghi->count() - 1)>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Nessun logo: la striscia in home è nascosta.</p>
                @endforelse
            </div>

            <h3 class="h6 mb-3">Aggiungi un logo</h3>
            @if($bagLogo->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($bagLogo->all() as $errore)
                            <li>{{ $errore }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.loghi.store') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end">
                @csrf
                <div class="col-12 col-md-4">
                    <label class="form-label" for="logoNome">Nome del brand</label>
                    <input type="text" name="nome" id="logoNome" class="form-control" maxlength="60" value="{{ old('nome') }}" required>
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="logoFile">File del logo</label>
                    <input type="file" name="logo" id="logoFile" class="form-control" accept=".jpg,.jpeg,.png,.webp,.svg" required>
                </div>
                <div class="col-12 col-md-3">
                    <button type="submit" class="btn w-100 mb-0"><i class="bi bi-plus-lg me-1"></i> Aggiungi</button>
                </div>
                <div class="col-12">
                    <small class="text-muted">Meglio un PNG con sfondo trasparente o un SVG. In home i loghi diventano grigi e si colorano al passaggio del mouse.</small>
                </div>
            </form>
        </section>

        {{-- CAPI IN EVIDENZA: si gestiscono dagli annunci --}}
        <section class="admin-card mb-5" id="evidenza">
            <h2 class="admin-card-title">Capi in evidenza</h2>
            <p class="mb-2">
                In evidenza ora: <strong>{{ $inEvidenza }} di {{ \App\Models\Annuncio::EVIDENZA_MAX }}</strong>.
                Se sono meno di {{ \App\Models\Annuncio::EVIDENZA_MIN }}, la home si completa in automatico con gli ultimi annunci.
            </p>
            <p class="text-muted mb-3">
                Per scegliere un capo: apri l'annuncio in modifica e attiva "Mostra in home", oppure usa la stella
                <i class="bi bi-star"></i> sulle schede nel tuo profilo.
            </p>
            <a href="{{ route('profile.edit') }}#attivi" class="btn btn-sm">Vai ai miei annunci</a>
        </section>

        {{-- form esterni per spostare le slide --}}
        @foreach($slides as $slide)
            @foreach(['su', 'giu'] as $direzione)
                <form id="sposta-slide-{{ $slide->id }}-{{ $direzione }}" action="{{ route('admin.slide.sposta', $slide) }}" method="POST" hidden>
                    @csrf @method('PATCH')
                    <input type="hidden" name="direzione" value="{{ $direzione }}">
                </form>
            @endforeach
        @endforeach

        {{-- form esterni per i pulsanti dei loghi --}}
        @foreach($loghi as $logo)
            <form id="elimina-logo-{{ $logo->id }}" action="{{ route('admin.loghi.destroy', $logo) }}" method="POST" hidden>
                @csrf @method('DELETE')
            </form>
            @foreach(['su', 'giu'] as $direzione)
                <form id="sposta-logo-{{ $logo->id }}-{{ $direzione }}" action="{{ route('admin.loghi.sposta', $logo) }}" method="POST" hidden>
                    @csrf @method('PATCH')
                    <input type="hidden" name="direzione" value="{{ $direzione }}">
                </form>
            @endforeach
        @endforeach
    </div>
</x-layout>
