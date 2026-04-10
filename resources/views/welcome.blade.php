<x-layout>
    <!-- Hero Accordion -->
    <div class="hero-accordion" style="margin-top: 80px;">

        <!-- Slide 1 -->
        <div class="hero-panel active" data-index="0">
            <div class="hero-panel-color">
                <div class="hero-panel-content">
                    <h1>Abbigliamento<br>donna</h1>
                    <p>Scopri le nostre collezioni</p>
                    <a href="{{ route('annunci.index') }}" class="btn">Scopri</a>
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
                    <h1>Primavera<br>Estate</h1>
                    <p>Scopri i capi del momento</p>
                    <a href="{{ route('annunci.index') }}" class="btn">Scopri</a>
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
                    <h1>Autunno<br>Inverno</h1>
                    <p>I capi per la stagione fredda</p>
                    <a href="{{ route('annunci.index') }}" class="btn">Scopri</a>
                </div>
            </div>
            <div class="hero-panel-img">
                <img src="img/modella2.jpg" alt="Autunno Inverno">
            </div>
        </div>

    </div>

    <!-- Sezioni Brand -->
    <section class="brands-section">
        <div class="my-2 mb-3">
            <h1 class="text-center my-2">I brand che troverai in negozio</h1>
        </div>

        <!-- Brand 1 -->
        <div class="brand-row">
            <div class="brand-header">
                <img src="img/markup.png" class="brand-logo" alt="Marca 1">
            </div>
            <div class="brand-scroll-wrapper">
                <div class="brand-scroll">
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellamarkup.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellamarkup1.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup1.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellamarkup5.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup5.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellamarkup3.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup3.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellamarkup4.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitomarkup4.jpg" alt="Vestito">
                    </div>
                </div>
            </div>
        </div>

        <!-- Brand 2 -->
        <div class="brand-row">
            <div class="brand-header">
                <img src="img/sarachole.png" class="brand-logo1" alt="Marca 2">
            </div>
            <div class="brand-scroll-wrapper">
                <div class="brand-scroll">
                    <div class="brand-card">
                        <img class="img-primary" src="img/cholemodella1.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito1.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/cholemodella.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/cholemodella2.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito2.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/cholemodella3.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito3.jpeg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/cholemodella4.jpeg" alt="Modella">
                        <img class="img-secondary" src="img/choleabito4.jpeg" alt="Vestito">
                    </div>
                </div>
            </div>
        </div>

        <!-- Brand 3 -->
        <div class="brand-row">
            <div class="brand-header">
                <img src="img/Lescopains.jpg" class="brand-logo1" alt="Marca 3">
            </div>
            <div class="brand-scroll-wrapper">
                <div class="brand-scroll">
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellacopains.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellacopains1.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains1.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellacopains2.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains2.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellacopains3.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains3.jpg" alt="Vestito">
                    </div>
                    <div class="brand-card">
                        <img class="img-primary" src="img/modellacopains4.jpg" alt="Modella">
                        <img class="img-secondary" src="img/abitocopains4.jpg" alt="Vestito">
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Banner WhatsApp -->
    <section class="whatsapp-banner">
        <div class="content">
            <h3>Contattaci direttamente su whatsapp per chiedere maggiori informazioni o per fare il tuo ordine.</h3>
            <a href="https://wa.me/+393381520444" target="_blank" class="btn">
                <i class="bi bi-whatsapp me-2"></i>WhatsApp
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

    <!-- Banner Orari + Mappa -->
    <section class="info-section">
        <div class="info-orari">
            <h2 class="info-title">Orari di Apertura</h2>
            <ul class="orari-list">
                <li>
                    <span class="orari-giorno">Lunedì</span>
                    <span class="orari-ore">Chiuso</span>
                </li>
                <li>
                    <span class="orari-giorno">Martedì — Venerdì</span>
                    <span class="orari-ore">09:00 — 13:00 / 15:30 — 19:30</span>
                </li>
                <li>
                    <span class="orari-giorno">Sabato</span>
                    <span class="orari-ore">09:00 — 13:00 / 15:30 — 19:30</span>
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