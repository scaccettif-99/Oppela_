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
            <a href="{{ route('gallery') }}">Gallery</a>
            <a href="{{ route('contact') }}">Contatti</a>
        </nav>
        
        {{-- Social / WhatsApp --}}
        <div class="footer-social">
            <a href="https://wa.me/+393381520444" target="_blank" rel="noopener" aria-label="Contattaci su WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
            <a href="https://instagram.com/oppela" target="_blank" rel="noopener" aria-label="Seguici su Instagram">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="https://www.facebook.com/oppelaterni" target="_blank" rel="noopener" aria-label="Seguici su Facebook">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="https://www.tiktok.com/@oppelapaolatinarelli75" target="_blank" rel="noopener" aria-label="Seguici su TikTok">
                <i class="bi bi-tiktok"></i>
            </a>
        </div>
        
    </div>
    
    <div class="footer-bottom">
        <span>&copy; {{ date('Y') }} Oppela!! &mdash; Tutti i diritti riservati</span>
    </div>
</footer>