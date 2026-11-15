<x-layout>
    {{-- Popup --}}
    <div class="popup-overlay" id="sorpresaPopup">
        <div class="popup-box">
            <button class="popup-close" id="popupClose">&times;</button>
            <img src="{{ asset('media/logo.jpg') }}" alt="Oppela" class="popup-logo">
            <h3>Scorri verso il basso per ricevere una sorpresa in omaggio!</h3>
            <i class="bi bi-chevron-double-down popup-arrow"></i>
        </div>
    </div>
    <!-- Hero Accordion: foto e testi modificabili da "Personalizza home" -->
    <div class="hero-accordion" style="margin-top: 80px;">
        @foreach($slides as $i => $slide)
            <div class="hero-panel {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                <div class="hero-panel-color">
                    <div class="hero-panel-content">
                        <h1>{!! nl2br(e($slide->titolo)) !!}</h1>
                        @if($slide->sottotitolo)
                            <p>{{ $slide->sottotitolo }}</p>
                        @endif
                        <a href="{{ $slide->href }}" class="btn">Scopri</a>
                    </div>
                </div>
                <div class="hero-panel-img">
                    <img src="{{ $slide->immagine_url }}"
                            alt="{{ preg_replace('/\s+/', ' ', $slide->titolo) }}"
                            style="object-position: {{ $slide->posizione_focus }};">
                </div>
            </div>
        @endforeach
    </div>

    <!-- Sezione Brand -->
    <section class="brands-section">
        
        {{-- Capi in evidenza: scelti da Paola, poi ultimi annunci, poi foto di riserva --}}
        @php
            $riserva = array_slice(\App\Models\Annuncio::EVIDENZA_DEFAULT, 0, max(0, \App\Models\Annuncio::EVIDENZA_MIN - $evidenza->count()));
        @endphp
        <div class="brand-row" id="capi-in-evidenza">
            <div class="brand-row-header">
                <div>
                    <h2 class="brand-row-title">Capi in evidenza</h2>
                </div>
                <a href="{{ route('annunci.index') }}" class="brand-shop-cta">
                    Vai allo shop <i class="bi bi-arrow-right"></i>
                </a>
                <div class="brand-row-nav">
                    <button class="brand-nav-btn" data-target="scroll-evidenza" data-dir="prev" aria-label="Indietro">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="brand-nav-btn" data-target="scroll-evidenza" data-dir="next" aria-label="Avanti">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="brand-scroll-wrapper" id="scroll-evidenza">
                <div class="brand-scroll">
                    @foreach($evidenza as $capo)
                        <a href="{{ route('annunci.show', $capo) }}" class="brand-card evidenza-card">
                            <span class="brand-badge">In evidenza</span>
                            <img class="img-primary" src="{{ Storage::url($capo->immagini[0]->path) }}" alt="{{ $capo->titolo }} indossato" loading="lazy">
                            <img class="img-secondary" src="{{ Storage::url($capo->immagini[1]->path) }}" alt="{{ $capo->titolo }}" loading="lazy">
                            <span class="evidenza-dettaglio">
                                <span class="evidenza-dettaglio-nome">{{ $capo->titolo }}</span>
                                <span class="evidenza-dettaglio-cta">Vai al dettaglio <i class="bi bi-arrow-right"></i></span>
                            </span>
                        </a>
                    @endforeach

                    @foreach($riserva as [$modella, $prodotto])
                        <a href="{{ route('annunci.index') }}" class="brand-card evidenza-card">
                            <span class="brand-badge">In evidenza</span>
                            <img class="img-primary" src="{{ asset('media/' . $modella) }}" alt="Modella" loading="lazy">
                            <img class="img-secondary" src="{{ asset('media/' . $prodotto) }}" alt="Capo" loading="lazy">
                            <span class="evidenza-dettaglio">
                                <span class="evidenza-dettaglio-cta">Scopri lo shop <i class="bi bi-arrow-right"></i></span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Set fotografico Primavera Estate 2026 --}}
        <div class="brand-row" id="set-fotografico">
            <div class="brand-row-header">
                <div>
                    <h2 class="brand-row-title">Set fotografico collezione primavera estate 2026</h2>
                    <p class="brand-row-subtitle">Modella Annalisa Petrini</p>
                </div>
                <a href="{{ route('annunci.index') }}" class="brand-shop-cta">
                    Vai allo shop <i class="bi bi-arrow-right"></i>
                </a>
                <div class="brand-row-nav">
                    <button class="brand-nav-btn" data-target="scroll-pe26" data-dir="prev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="brand-nav-btn" data-target="scroll-pe26" data-dir="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
            @include('partials.collezione-pe26', ['scrollId' => 'scroll-pe26'])
        </div>

        {{-- Titolo e loghi brand: striscia in scorrimento continuo, gestita da "Personalizza home" --}}
        @if($loghi->isNotEmpty())
        @php
            // ripetizioni della serie di loghi: abbastanza da riempire anche uno schermo molto largo
            $larghezzaSerie = $loghi->sum(fn ($l) => $l->dimensioniSchermo()[0] + 64) + 64;
            $copie = max(4, (int) ceil(2600 / max(1, $larghezzaSerie)) + 1);
        @endphp
        <div class="brands-header">
            <h1 class="brands-main-title">I brand che troverai in negozio</h1>
            <div class="brands-marquee">
                <div class="brands-marquee-track" style="--copie: {{ $copie }};">
                    {{-- solo la prima serie è letta dagli screen reader --}}
                    @foreach(range(1, $copie) as $copia)
                        <ul class="brands-marquee-group" @if($copia > 1) aria-hidden="true" @endif>
                            @foreach($loghi as $logo)
                                @php [$lw, $lh] = $logo->dimensioniSchermo(); @endphp
                                <li class="brand-logo-item">
                                    <img src="{{ $logo->url }}" width="{{ $lw }}" height="{{ $lh }}"
                                            style="width: {{ $lw }}px; height: {{ $lh }}px;"
                                            alt="{{ $copia === 1 ? $logo->nome : '' }}">
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </section>
    {{-- Clienti soddisfatte: anteprima, le altre foto sono nella gallery --}}
    <section class="home-clienti">
        <div class="home-clienti-inner">
            <h2 class="home-clienti-title">Clienti soddisfatte</h2>
            <div class="home-clienti-grid">
                @foreach([2, 5, 8, 13] as $n)
                    <a href="{{ route('gallery') }}#clienti-soddisfatte" class="home-clienti-item">
                        <img src="{{ asset('media/client_' . $n . '.jpg') }}" alt="Cliente soddisfatta di Oppela!!" loading="lazy">
                    </a>
                @endforeach
            </div>
            <a href="{{ route('gallery') }}#clienti-soddisfatte" class="btn home-clienti-btn">
                Scopri di più <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </section>

    <!-- Banner WhatsApp Sorpresa -->
    {{-- l'immagine di sfondo è passata da qui (e non scritta nel CSS) così l'indirizzo è sempre quello del sito --}}
    <section class="whatsapp-banner" id="sorpresaBanner"
            style="--sorpresa-bg: url('{{ asset('media/SanValentino.jpg') }}');">
        <div class="content">
            <h3 class="sorpresa-title" id="sorpresaTitle">Complimenti: ecco la tua sorpresa!</h3>
            <p style="color: #fdfaf5; margin-bottom: 1.5rem; position: relative; z-index: 3;">
                Clicca sul tasto qui sotto per accedere ad uno sconto del 10% sulla collezione presente in negozio!
            </p>
            @php
            $msg = urlencode("Ho visitato il tuo sito e vorrei reclamare il mio sconto del 10% sulla collezione esposta in negozio! Grazie!");
            @endphp
            <a href="https://wa.me/+393381520444?text={{ $msg }}"
            target="_blank"
            class="btn sorpresa-btn"
            id="sorpresaBtn">
            <i class="bi bi-whatsapp me-2"></i>Reclama il tuo sconto!!
        </a>
    </div>
</section>

<!-- Carosello Recensioni -->
<section class="reviews-section">
    <h2 class="reviews-title">Cosa dicono di noi</h2>
    
    <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">
            
            <div class="carousel-item active">
                <div class="review-card">
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="review-text">È sempre un piacere fermarsi in questo negozio. Paola è una persona meravigliosa oltre ad essere una grande professionista. Nel negozio c'è ovunque il suo magnifico tocco!</p>
                </div>
            </div>
            
            <div class="carousel-item">
                <div class="review-card">
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="review-text">Professionalità, cortesia e qualità sono i tratti distintivi di Oppela!! Paola, la titolare, segue la clientela con competenza offrendo un vasto assortimento di capi di abbigliamento alla moda, borse, cinture e accessori. Ottimo negozio di abbigliamento.</p>
                </div>
            </div>
            
            <div class="carousel-item">
                <div class="review-card">
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="review-text">Il negozio di Paola è come una piccola bomboniera dove trovare capi d'abbigliamento con un ottimo rapporto qualità-prezzo. Paola con la sua professionalità e la sua gentilezza sa sempre consigliarti per il meglio.</p>
                </div>
            </div>
            
            <div class="carousel-item">
                <div class="review-card">
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="review-text">Capi bellissimi, alla moda e ricercati!! Oltre ad essere molto belli sono anche a prezzi accessibili!</p>
                </div>
            </div>
            
            <div class="carousel-item">
                <div class="review-card">
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="review-text">Oltre ad essere un negozio, Oppela!! è un punto di riferimento per il quartiere. Paola sa creare sempre un senso di comunità e fa del suo lavoro qualcosa di più di un semplice negozio di abbigliamento.</p>
                </div>
            </div>
            
        </div>
        
        <div class="carousel-indicators reviews-indicators">
            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="4"></button>
        </div>
    </div>
</section>

{{-- Banner Orari + Mappa --}}
    <section class="info-section">
        <div class="info-orari">
            <h2 class="info-title">Orari di Apertura</h2>
            <ul class="orari-list">
                <li>
                    <span class="orari-giorno">Lunedì mattina</span>
                    <span class="orari-ore">Chiuso</span>
                </li>
                <li>
                    <span class="orari-giorno">Lunedì pomeriggio</span>
                    <span class="orari-ore">16:00 — 19.30 </span>
                </li>
                <li>
                    <span class="orari-giorno">Martedì — Sabato</span>
                    <span class="orari-ore">10:00 — 13:30 / 16.00 — 19:30</span>
                </li>
                <li>
                    <span class="orari-giorno">Domenica</span>
                    <span class="orari-ore">Chiuso</span>
                </li>
            </ul>
            <a href="https://wa.me/+393381520444" target="_blank" rel="noopener" class="btn info-btn">
                <i class="bi bi-whatsapp me-2"></i>Contattaci su WhatsApp
            </a>
        </div>

        @include('partials.mappa')
    </section>

</x-layout>