<x-layout>
    {{-- <div class="container-fluid text-center bg-body-tertiary">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-12">
                <h1 class="display-4">Oppela!</h1>
            </div>
        </div>
    </div> --}}
    <!-- Carousel -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        
        <div class="carousel-item active">
            <img src="img/copertina.jpg" class="d-block w-100 carousel-img carousel-img-right" alt="Slide 1">
            <div class="carousel-caption d-block">
                <div class="caption-box">
                    <h2>Abbigliamento donna</h2>
                    <p>Scopri le nostre collezioni</p>
                    <button class="btn">Scopri</button>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/modella.jpg" class="d-block w-100 carousel-img" alt="Slide 2">
            <div class="carousel-caption d-block">
                <div class="caption-box">
                    <h2>Primavera Estate</h2>
                    <p>Scopri i capi del momento</p>
                    <button class="btn">Scopri</button>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/modella1.jpg" class="d-block w-100 carousel-img" alt="Slide 3">
            <div class="carousel-caption d-block">
                <div class="caption-box">
                    <h2>Autunno Inverno</h2>
                    <p>I capi per la stagione fredda</p>
                    <button class="btn">Scopri</button>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/modella2.jpg" class="d-block w-100 carousel-img" alt="Slide 3">
            <div class="carousel-caption d-block">
                <div class="caption-box">
                    <h2>San Valentino</h2>
                    <p>Vieni a trovarci in negozio</p>
                    <button class="btn">Indicazioni</button>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Controlli -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

</x-layout>