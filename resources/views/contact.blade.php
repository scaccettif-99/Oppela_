<x-layout>
    <div class="container py-5" style="margin-top: 80px;">

        <h1 class="mb-5 text-center">Contatti</h1>

        <div class="row g-4 justify-content-center mb-5">

            {{-- WhatsApp --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100">
                    <i class="bi bi-whatsapp mb-3" style="font-size: 2rem; color: #feed02;"></i>
                    <h6 class="mb-2">WhatsApp</h6>
                    <a href="https://wa.me/+393381520444" target="_blank" class="btn mt-2">
                        Scrivici
                    </a>
                </div>
            </div>

            {{-- Instagram --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100">
                    <i class="bi bi-instagram mb-3" style="font-size: 2rem; color: #feed02;"></i>
                    <h6 class="mb-2">Instagram</h6>
                    <a href="https://instagram.com/oppela" target="_blank" class="btn mt-2">
                        @oppela
                    </a>
                </div>
            </div>

            {{-- Facebook --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100">
                    <i class="bi bi-facebook mb-3" style="font-size: 2rem; color: #feed02;"></i>
                    <h6 class="mb-2">Facebook</h6>
                    <a href="https://www.facebook.com/oppelaterni" target="_blank" class="btn mt-2">
                        OPPELA
                    </a>
                </div>
            </div>

            {{-- Email --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100">
                    <i class="bi bi-envelope mb-3" style="font-size: 2rem; color: #feed02;"></i>
                    <h6 class="mb-2">Email</h6>
                    <a href="mailto:oppela@gmail.com" class="btn mt-2">
                        oppela@gmail.com
                    </a>
                </div>
            </div>

            {{-- Telefono --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-4 text-center h-100">
                    <i class="bi bi-telephone mb-3" style="font-size: 2rem; color: #feed02;"></i>
                    <h6 class="mb-2">Telefono</h6>
                    <a href="tel:+390744123456" class="btn mt-2">
                        0744 123456
                    </a>
                </div>
            </div>

        </div>

    </div>

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