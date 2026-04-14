<x-layout>

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
                'img/negozio0.JPG', 'img/negozio1.JPG', 'img/negozio2.JPG',
                'img/negozio3.JPG', 'img/negozio4.JPG', 'img/oppela!!.jpg',
                'img/paola.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Il negozio">
                    <img src="{{ asset($img) }}" alt="Il negozio" loading="lazy">
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
                'img/quartiere0.JPG', 'img/quartiere1.JPG', 'img/quartiere2.JPG',
                'img/quartiere3.JPG', 'img/quartiere4.JPG', 'img/quartiere.JPG',
                'img/SanValentino.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Il quartiere">
                    <img src="{{ asset($img) }}" alt="Il quartiere" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: Le iniziative --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Le iniziative</h2>
        </div>
        <div class="masonry-grid" data-section="iniziative">
            @foreach([
                'img/SanValentino1.jpg', 'img/sanvalentino2.jpg', 'img/negozio0.JPG',
                'img/negozio1.JPG', 'img/quartiere0.JPG', 'img/quartiere1.JPG',
                'img/paola.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Le iniziative">
                    <img src="{{ asset($img) }}" alt="Le iniziative" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: I clienti e gli amici --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">I clienti e gli amici</h2>
        </div>
        <div class="masonry-grid" data-section="clienti">
            @foreach([
                'img/negozio2.JPG', 'img/negozio3.JPG', 'img/negozio4.JPG',
                'img/quartiere2.JPG', 'img/quartiere3.JPG', 'img/quartiere4.JPG',
                'img/oppela!!.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="I clienti e gli amici">
                    <img src="{{ asset($img) }}" alt="I clienti e gli amici" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
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

        <div class="info-mappa">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2934.1!2d12.6469!3d42.5630!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sViale+Papa+Zaccaria+1%2C+05100+Terni+TR!5e0!3m2!1sit!2sit!4v1"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Posizione negozio Oppela">
            </iframe>
        </div>
    </section>

</x-layout>