<footer class="site-footer">
    <div class="footer-inner">
        
        {{-- Brand --}}
        <div class="footer-brand">
            <span class="footer-logo">Oppela!!</span>
            <p class="footer-tagline">Moda &amp; Stile</p>
        </div>
        
        {{-- Link navigazione --}}
        <nav class="footer-nav" aria-label="Footer navigation">
            <a href="{{ route('welcome') }}">Home</a>
            <a href="{{ url('/gallery') }}">Gallery</a>
            <a href="{{ route('contact') }}">Contatti</a>
        </nav>
        
        {{-- Social / WhatsApp --}}
        <div class="footer-social">
            <a href="https://wa.me/39NUMEROQUI" target="_blank" rel="noopener" aria-label="Contattaci su WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
            <a href="https://instagram.com/USERQUI" target="_blank" rel="noopener" aria-label="Seguici su Instagram">
                <i class="bi bi-instagram"></i>
            </a>
        </div>
        
    </div>
    
    <div class="footer-bottom">
        <span>&copy; {{ date('Y') }} Oppela!! &mdash; Tutti i diritti riservati</span>
    </div>
</footer>