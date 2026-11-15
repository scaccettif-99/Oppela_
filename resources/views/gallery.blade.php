<x-layout>
    @php
        // larghezza/altezza reali delle foto: il browser riserva lo spazio prima di caricarle,
        // così la pagina non "salta" (e il link #clienti-soddisfatte arriva nel punto giusto)
        $dim = function (string $path): string {
            $size = @getimagesize(public_path($path));
            return $size ? 'width="' . $size[0] . '" height="' . $size[1] . '"' : '';
        };
    @endphp

    {{-- Hero --}}
    <div class="gallery-hero" style="margin-top: 80px;">
        <div class="gallery-hero-inner">
            <p class="gallery-hero-sub">Scorri e scopri</p>
            <h1 class="gallery-hero-title">Gallery</h1>
        </div>
    </div>

    {{-- Lightbox --}}
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" id="lightboxClose">
            <i class="bi bi-x-lg"></i>
        </button>
        <button class="lightbox-prev" id="lightboxPrev">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="lightbox-next" id="lightboxNext">
            <i class="bi bi-chevron-right"></i>
        </button>
        <div class="lightbox-img-wrapper">
            <img src="" alt="" id="lightboxImg">
        </div>
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>

    {{-- Sezione: Il negozio --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Il negozio</h2>
        </div>
        <div class="masonry-grid" data-section="negozio">
            @foreach([
                'media/negozio0.JPG', 'media/negozio1.JPG', 'media/negozio2.JPG',
                'media/negozio3.JPG', 'media/negozio4.JPG', 'media/oppela!!.jpg',
                'media/paola.jpg', 'media/negozio11.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Il negozio">
                    <img src="{{ asset($img) }}" {!! $dim($img) !!} alt="Il negozio" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: Il quartiere --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Il quartiere</h2>
        </div>
        <div class="masonry-grid" data-section="quartiere">
            @foreach([
                'media/quartiere0.JPG', 'media/quartiere1.JPG', 'media/quartiere2.JPG',
                'media/quartiere3.JPG', 'media/quartiere4.JPG', 'media/quartiere.JPG',
                'media/SanValentino.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Il quartiere">
                    <img src="{{ asset($img) }}" {!! $dim($img) !!} alt="Il quartiere" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: Dieci anni di Oppela!! --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Dieci anni di Oppela!!</h2>
        </div>
        <div class="masonry-grid" data-section="dieci-anni">
            @foreach([
                'media/10anni_1.jpg', 'media/10anni_2.jpg', 'media/10anni_3.jpg',
                'media/10anni_4.jpg', 'media/10anni_5.jpg', 'media/10anni_7.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Dieci anni di Oppela!!">
                    <img src="{{ asset($img) }}" {!! $dim($img) !!} alt="Dieci anni di Oppela!!" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: Clienti soddisfatte (la home punta qui con #clienti-soddisfatte) --}}
    <section class="gallery-section" id="clienti-soddisfatte">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Clienti soddisfatte</h2>
        </div>
        <div class="masonry-grid" data-section="clienti">
            @php
                // tutte le foto media/client_N.jpg, in ordine di numero: basta caricarne di nuove
                $fotoClienti = glob(public_path('media/client_*.jpg')) ?: [];
                natsort($fotoClienti);
                $fotoClienti = array_map(fn ($f) => 'media/' . basename($f), $fotoClienti);
            @endphp
            @foreach($fotoClienti as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Clienti soddisfatte">
                    <img src="{{ asset($img) }}" {!! $dim($img) !!} alt="Cliente soddisfatta di Oppela!!" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: Set fotografico Primavera Estate 2026 --}}
    <section class="gallery-section gallery-section-carousel">
        <div class="gallery-section-header gallery-carousel-header">
            <div>
                <h2 class="gallery-section-title">Set fotografico collezione primavera estate 2026</h2>
                <p class="gallery-section-sub">Modella Annalisa Petrini</p>
            </div>
            <a href="{{ route('annunci.index') }}" class="brand-shop-cta">
                Vai allo shop <i class="bi bi-arrow-right"></i>
            </a>
            <div class="brand-row-nav">
                <button class="brand-nav-btn" data-target="gallery-pe26" data-dir="prev" aria-label="Indietro">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="brand-nav-btn" data-target="gallery-pe26" data-dir="next" aria-label="Avanti">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
        @include('partials.collezione-pe26', ['scrollId' => 'gallery-pe26'])
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