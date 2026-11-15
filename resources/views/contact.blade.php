<x-layout>

    {{-- Hero --}}
    <div class="contatti-hero" style="margin-top: 80px;">
        <div class="contatti-hero-inner">
            <p class="contatti-hero-sub">Siamo qui per te</p>
            <h1 class="contatti-hero-title">Contatti</h1>
            <p class="contatti-hero-address">
                <i class="bi bi-geo-alt me-2"></i>Viale Papa Zaccaria 1/A — Terni
            </p>
        </div>
    </div>

    {{-- Contatti cards --}}
    <section class="contatti-section">

        <div class="contatti-grid">

            {{-- WhatsApp --}}
            <a href="https://wa.me/+393381520444" target="_blank" class="contatti-card">
                <div class="contatti-card-icon">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <div class="contatti-card-body">
                    <h3>WhatsApp</h3>
                    <p>Scrivici direttamente</p>
                </div>
                <div class="contatti-card-hover">
                    <i class="bi bi-whatsapp contatti-hover-icon"></i>
                    <span>Apri chat</span>
                </div>
            </a>

            {{-- Instagram --}}
            <a href="https://instagram.com/oppela" target="_blank" class="contatti-card">
                <div class="contatti-card-icon">
                    <i class="bi bi-instagram"></i>
                </div>
                <div class="contatti-card-body">
                    <h3>Instagram</h3>
                    <p>@oppela</p>
                </div>
                <div class="contatti-card-hover">
                    <i class="bi bi-instagram contatti-hover-icon"></i>
                    <span>Seguici</span>
                </div>
            </a>

            {{-- Facebook --}}
            <a href="https://www.facebook.com/oppelaterni" target="_blank" class="contatti-card">
                <div class="contatti-card-icon">
                    <i class="bi bi-facebook"></i>
                </div>
                <div class="contatti-card-body">
                    <h3>Facebook</h3>
                    <p>OPPELA</p>
                </div>
                <div class="contatti-card-hover">
                    <i class="bi bi-facebook contatti-hover-icon"></i>
                    <span>Visita la pagina</span>
                </div>
            </a>

            {{-- Email --}}
            <a href="mailto:oppela.tr@gmail.com" class="contatti-card">
                <div class="contatti-card-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <div class="contatti-card-body">
                    <h3>Email</h3>
                    <p>oppela.tr@gmail.com</p>
                </div>
                <div class="contatti-card-hover">
                    <i class="bi bi-envelope contatti-hover-icon"></i>
                    <span>Scrivici</span>
                </div>
            </a>

            {{-- Telefono --}}
            <a href="tel:+393381520444" class="contatti-card">
                <div class="contatti-card-icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <div class="contatti-card-body">
                    <h3>Telefono</h3>
                    <p>338 152 0444</p>
                </div>
                <div class="contatti-card-hover">
                    <i class="bi bi-telephone contatti-hover-icon"></i>
                    <span>Chiamaci</span>
                </div>
            </a>

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