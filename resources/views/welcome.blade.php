<x-layout>
    {{-- Popup --}}
    <div class="popup-overlay" id="sorpresaPopup">
        <div class="popup-box">
            <button class="popup-close" id="popupClose">&times;</button>
            <img src="img/logo.jpg" alt="Oppela" class="popup-logo">
            <h3>Scorri verso il basso per ricevere una sorpresa in omaggio!</h3>
            <i class="bi bi-chevron-double-down popup-arrow"></i>
        </div>
    </div>
    <!-- Hero Accordion -->
    <div class="hero-accordion" style="margin-top: 80px;">
        
        <!-- Slide 1 -->
        <div class="hero-panel active" data-index="0">
            <div class="hero-panel-color">
                <div class="hero-panel-content">
                    <h1>Collezione<br>primavera estate</h1>
                    <p>Scopri le nostre collezioni</p>
                    <a href="{{ url('/#brand-section-spring') }}" class="btn">Scopri</a>
                </div>
            </div>
            <div class="hero-panel-img">
                <img src="img/modella.jpg" alt="Abbigliamento donna">
            </div>
        </div>
        
        <!-- Slide 2 -->
        <div class="hero-panel" data-index="1">
            <div class="hero-panel-color">
                <div class="hero-panel-content">
                    <h1>Collezione<br>autunno inverno</h1>
                    <p>Scopri i capi della stagione fredda</p>
                    <a href="{{ url('/#brand-section-fall') }}" class="btn">Scopri</a>
                </div>
            </div>
            <div class="hero-panel-img">
                <img src="img/modella1.jpg" alt="Primavera Estate">
            </div>
        </div>
        
        <!-- Slide 3 -->
        <div class="hero-panel" data-index="2">
            <div class="hero-panel-color">
                <div class="hero-panel-content">
                    <h1>Collezione<br>accessori</h1>
                    <p>Borse, cinte, gioielli da abbinare ai tuoi outfit</p>
                    <a href="{{ url('/#brand-section-acc') }}" class="btn">Scopri</a>
                </div>
            </div>
            <div class="hero-panel-img">
                <img src="img/modella2.jpg" alt="Autunno Inverno">
            </div>
        </div>
        
    </div>
    
    <!-- Sezione Brand -->
    <section class="brands-section">
        
        {{-- Capi in evidenza PE --}}
        <div class="brand-row"  id="brand-section-spring">
            <div class="brand-row-header">
                <div>
                    <h2 class="brand-row-title">Capi in evidenza</h2>
                    <p class="brand-row-subtitle">Collezione Primavera Estate</p>
                </div>
                <div class="brand-row-nav">
                    <button class="brand-nav-btn" data-target="scroll-pe" data-dir="prev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="brand-nav-btn" data-target="scroll-pe" data-dir="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="brand-scroll-wrapper" id="scroll-pe">
                <div class="brand-scroll">
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellamarkup.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellamarkup1.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup1.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellamarkup5.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup5.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellamarkup3.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup3.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellamarkup4.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup4.jpg" alt="Vestito">
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Autunno Inverno --}}
        <div class="brand-row" id="brand-section-fall">
            <div class="brand-row-header">
                <div>
                    <h2 class="brand-row-title">Capi in evidenza</h2>
                    <p class="brand-row-subtitle">Collezione Autunno Inverno</p>
                </div>
                <div class="brand-row-nav">
                    <button class="brand-nav-btn" data-target="scroll-ai" data-dir="prev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="brand-nav-btn" data-target="scroll-ai" data-dir="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="brand-scroll-wrapper" id="scroll-ai">
                <div class="brand-scroll">
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellacopains.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellacopains1.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains1.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellacopains2.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains2.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellacopains3.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains3.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/modellacopains4.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains4.jpg" alt="Vestito">
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Accessori --}}
        <div class="brand-row" id="brand-section-acc">
            <div class="brand-row-header">
                <div>
                    <h2 class="brand-row-title">Accessori</h2>
                    <p class="brand-row-subtitle">Collezione Accessori</p>
                </div>
                <div class="brand-row-nav">
                    <button class="brand-nav-btn" data-target="scroll-acc" data-dir="prev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="brand-nav-btn" data-target="scroll-acc" data-dir="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="brand-scroll-wrapper" id="scroll-acc">
                <div class="brand-scroll">
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/cholemodella1.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito1.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/cholemodella.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/cholemodella2.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito2.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/cholemodella3.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito3.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <span class="brand-badge">In evidenza</span>
                        <img class="img-primary" src="img/cholemodella4.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito4.jpeg" alt="Vestito">
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Titolo e loghi brand --}}
        <div class="brands-header">
            <h1 class="brands-main-title">I brand che troverai in negozio</h1>
            <div class="brands-logos-strip">
                <div class="brand-logo-item">
                    <img src="img/markup.png" alt="Mark Up">
                </div>
                <div class="brand-logo-item">
                    <img src="img/sarachole.png" alt="Sara Chole">
                </div>
                <div class="brand-logo-item">
                    <img src="img/Lescopains.jpg" alt="Les Copains">
                </div>
            </div>
        </div>
        
    </section>
    <!-- Banner WhatsApp Sorpresa -->
    <section class="whatsapp-banner" id="sorpresaBanner">
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