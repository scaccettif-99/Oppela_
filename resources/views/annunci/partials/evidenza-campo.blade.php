{{-- Opzione "Mostra in home tra i capi in evidenza". Parametro opzionale: $annuncio --}}
@use('App\Models\Annuncio')
@php
    $attivo = (bool) old('in_evidenza', $annuncio->in_evidenza ?? false);
    $giaInEvidenza = Annuncio::contaInEvidenza($annuncio->id ?? null);
    $pieno = ! $attivo && $giaInEvidenza >= Annuncio::EVIDENZA_MAX;
@endphp

<div class="evidenza-campo mb-4">
    <div class="form-check form-switch">
        <input type="hidden" name="in_evidenza" value="0">
        <input class="form-check-input" type="checkbox" role="switch" name="in_evidenza" value="1"
                id="inEvidenza" {{ $attivo ? 'checked' : '' }} {{ $pieno ? 'disabled' : '' }}>
        <label class="form-check-label fw-semibold" for="inEvidenza">
            <i class="bi bi-star-fill me-1"></i> Mostra in home tra i "Capi in evidenza"
        </label>
    </div>
    <p class="small text-muted mb-0 mt-1">
        In evidenza ora: <strong>{{ $giaInEvidenza }} di {{ Annuncio::EVIDENZA_MAX }}</strong>.
        @if($pieno)
            Hai raggiunto il massimo: togli un capo dalla home (dal tuo profilo) per poter scegliere questo.
        @else
            Se ne scegli meno di {{ Annuncio::EVIDENZA_MIN }}, la home si completa in automatico con gli ultimi annunci.
        @endif
    </p>
</div>
