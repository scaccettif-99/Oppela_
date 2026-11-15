{{-- Foto in creazione annuncio: prima la modella, poi il prodotto da solo --}}
@use('App\Models\Annuncio')

<div class="foto-annuncio mb-4">
    <h5 class="foto-annuncio-titolo">Foto</h5>
    <p class="small text-muted mb-3">
        Puoi caricare le foto direttamente dal telefono (max 15 MB l'una): vengono ottimizzate in automatico.
        Servono almeno {{ Annuncio::FOTO_MIN }} foto, massimo {{ Annuncio::FOTO_MAX }}.
    </p>

    <div class="row g-3">
        <div class="col-12 col-md-5">
            <label class="foto-slot" for="fotoModella">
                <span class="foto-slot-numero">1</span>
                <span class="foto-slot-titolo">Foto con la modella</span>
                <span class="foto-slot-aiuto">Il capo indossato. È la foto che si vede per prima.</span>
                <span class="foto-slot-anteprima" data-anteprima="fotoModella"></span>
            </label>
            <input type="file" name="foto_modella" id="fotoModella" class="form-control mt-2"
                    accept="image/jpeg,image/png,image/webp" required data-anteprima-input>
        </div>

        <div class="col-12 col-md-7">
            <label class="foto-slot" for="fotoProdotto">
                <span class="foto-slot-numero">2+</span>
                <span class="foto-slot-titolo">Foto del prodotto da solo</span>
                <span class="foto-slot-aiuto">Almeno una, massimo {{ Annuncio::FOTO_MAX - 1 }}. La prima compare in home al passaggio del mouse.</span>
                <span class="foto-slot-anteprima" data-anteprima="fotoProdotto"></span>
            </label>
            <input type="file" name="foto_prodotto[]" id="fotoProdotto" class="form-control mt-2"
                    accept="image/jpeg,image/png,image/webp" multiple required data-anteprima-input>
        </div>
    </div>
</div>
