<x-layout>

    {{-- Hero --}}
    <div class="contatti-hero" style="margin-top: 80px;">
        <div class="contatti-hero-inner">
            <p class="contatti-hero-sub">Siamo qui per te</p>
            <h1 class="contatti-hero-title">Contatti</h1>
            <p class="contatti-hero-address">
                <i class="bi bi-geo-alt me-2"></i>Viale Papa Zaccaria 1 — Terni
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
            <a href="mailto:oppela@gmail.com" class="contatti-card">
                <div class="contatti-card-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <div class="contatti-card-body">
                    <h3>Email</h3>
                    <p>oppela@gmail.com</p>
                </div>
                <div class="contatti-card-hover">
                    <i class="bi bi-envelope contatti-hover-icon"></i>
                    <span>Scrivici</span>
                </div>
            </a>

            {{-- Telefono --}}
            <a href="tel:+390744123456" class="contatti-card">
                <div class="contatti-card-icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <div class="contatti-card-body">
                    <h3>Telefono</h3>
                    <p>0744 123456</p>
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