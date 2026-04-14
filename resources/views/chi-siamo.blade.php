<x-layout>

    {{-- Hero --}}
    <div class="chisiamo-hero" style="margin-top: 80px;">
        <div class="chisiamo-hero-inner">
            <p class="chisiamo-hero-sub">La nostra storia</p>
            <h1 class="chisiamo-hero-title">Chi siamo</h1>
        </div>
    </div>

    {{-- Intro --}}
    <section class="chisiamo-intro">
        <p>Oppela!! nasce nel 2005 nel cuore di Terni, a due passi dalla Basilica di San Valentino, patrono degli innamorati. Non è un caso — perché Oppela!! è un negozio nato dall'amore. L'amore per la moda, per le persone, per la città.</p>
    </section>

    {{-- Sezioni con foto --}}
    <section class="chisiamo-sections">

        {{-- Sezione 1 --}}
        <div class="chisiamo-row">
            <div class="chisiamo-img-wrapper">
                <img src="img/negozio2.jpg" alt="Le origini" class="chisiamo-banner-img" >
                <div class="chisiamo-caption caption-from-left">
                    <div class="chisiamo-caption-inner">
                        <h3>Le origini</h3>
                        <p>Era il 2005 quando Paola aprì per la prima volta le porte di Oppela!! in Viale Papa Zaccaria. Un piccolo spazio pieno di carattere, di colori e di idee. Da subito il negozio divenne un punto di riferimento per chi cercava qualcosa di più di un semplice capo d'abbigliamento — cercava uno stile, un'identità.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sezione 2 --}}
        <div class="chisiamo-row">
            <div class="chisiamo-img-wrapper">
                <img src="img/paola.jpg" alt="Paola" class="chisiamo-banner-img">
                <div class="chisiamo-caption caption-from-right">
                    <div class="chisiamo-caption-inner">
                        <h3>La persona dietro il negozio</h3>
                        <p>Paola non è solo una commerciante — è una consulente di stile, una confidente, una presenza costante. Con il suo occhio attento e la sua energia contagiosa, sa sempre come valorizzare ogni cliente. Entrare da Oppela!! significa essere accolti, ascoltati, consigliati con cura e passione.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sezione 3 --}}
        <div class="chisiamo-row">
            <div class="chisiamo-img-wrapper">
                <img src="img/quartiere2.jpg" alt="La comunità">
                <div class="chisiamo-caption caption-from-left">
                    <div class="chisiamo-caption-inner">
                        <h3>Una comunità, non solo un negozio</h3>
                        <p>Nel corso degli anni, Oppela!! è diventato molto più di un luogo dove fare acquisti. È un punto di incontro, uno spazio dove le persone si ritrovano, si raccontano, condividono. Le clienti di Paola non sono semplici acquirenti — sono parte di una comunità viva, affettuosa e fedele che cresce ogni giorno.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    {{-- Video --}}
    <section class="chisiamo-video-section">
        <h2 class="chisiamo-video-title">Paola si racconta</h2>
        <div class="chisiamo-video-wrapper">
            <iframe
                src="https://www.youtube.com/embed/aqo38Fs7Yqg"
                title="Presentazione Oppela!!"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
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