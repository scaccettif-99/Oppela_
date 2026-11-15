{{--
    Mappa del negozio con OpenStreetMap: nessun cookie di profilazione,
    quindi si mostra subito senza banner di consenso.
    Google Maps resta disponibile come semplice link (si apre solo se il visitatore clicca).
--}}
@php
    // Viale Papa Zaccaria, Terni (a due passi dalla Basilica di San Valentino)
    $lat = 42.54638;
    $lon = 12.64230;
    $bbox = implode(',', [$lon - 0.0045, $lat - 0.0025, $lon + 0.0045, $lat + 0.0025]);
    $indirizzo = 'Viale Papa Zaccaria 1/A, 05100 Terni';
@endphp
<div class="info-mappa">
    <iframe
        src="https://www.openstreetmap.org/export/embed.html?bbox={{ $bbox }}&amp;layer=mapnik&amp;marker={{ $lat }},{{ $lon }}"
        width="100%"
        height="100%"
        style="border:0;"
        loading="lazy"
        tabindex="-1"
        referrerpolicy="no-referrer"
        title="Posizione del negozio Oppela!! in {{ $indirizzo }}">
    </iframe>
    <a href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode($indirizzo) }}"
        target="_blank" rel="noopener" class="mappa-google-link">
        <i class="bi bi-geo-alt-fill"></i> Apri in Google Maps
    </a>
</div>
