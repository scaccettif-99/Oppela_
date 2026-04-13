<x-layout>

    {{-- Hero --}}
    <div class="gallery-hero" style="margin-top: 80px;">
        <div class="gallery-hero-inner">
            <p class="gallery-hero-sub">Scorri e scopri</p>
            <h1 class="gallery-hero-title">Gallery</h1>
        </div>
    </div>

    {{-- Lightbox --}}
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" id="lightboxClose">
            <i class="bi bi-x-lg"></i>
        </button>
        <button class="lightbox-prev" id="lightboxPrev">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="lightbox-next" id="lightboxNext">
            <i class="bi bi-chevron-right"></i>
        </button>
        <div class="lightbox-img-wrapper">
            <img src="" alt="" id="lightboxImg">
        </div>
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>

    {{-- Sezione: Il negozio --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Il negozio</h2>
        </div>
        <div class="masonry-grid" data-section="negozio">
            @foreach([
                'img/modellamarkup.jpg', 'img/modellamarkup1.jpg', 'img/modellamarkup3.jpg',
                'img/modellamarkup4.jpg', 'img/modellamarkup5.jpg', 'img/abitomarkup.jpg',
                'img/abitomarkup1.jpg', 'img/cholemodella.jpeg', 'img/cholemodella1.jpeg',
                'img/cholemodella2.jpeg', 'img/cholemodella3.jpeg', 'img/cholemodella4.jpeg',
                'img/modellacopains.jpg', 'img/modellacopains1.jpg', 'img/modellacopains2.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Il negozio">
                    <img src="{{ asset($img) }}" alt="Il negozio" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: Il quartiere --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Il quartiere</h2>
        </div>
        <div class="masonry-grid" data-section="quartiere">
            @foreach([
                'img/choleabito.jpeg', 'img/choleabito1.jpeg', 'img/choleabito2.jpeg',
                'img/choleabito3.jpeg', 'img/choleabito4.jpeg', 'img/abitomarkup3.jpg',
                'img/abitomarkup4.jpg', 'img/abitomarkup5.jpg', 'img/modellacopains3.jpg',
                'img/modellacopains4.jpg', 'img/abitocopains.jpg', 'img/abitocopains1.jpg',
                'img/abitocopains2.jpg', 'img/abitocopains3.jpg', 'img/abitocopains4.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Il quartiere">
                    <img src="{{ asset($img) }}" alt="Il quartiere" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: Le iniziative --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">Le iniziative</h2>
        </div>
        <div class="masonry-grid" data-section="iniziative">
            @foreach([
                'img/modella.jpg', 'img/modella1.jpg', 'img/modella2.jpg',
                'img/modellamarkup.jpg', 'img/modellamarkup1.jpg', 'img/modellamarkup3.jpg',
                'img/modellamarkup4.jpg', 'img/cholemodella.jpeg', 'img/cholemodella1.jpeg',
                'img/cholemodella2.jpeg', 'img/cholemodella3.jpeg', 'img/cholemodella4.jpeg',
                'img/modellacopains.jpg', 'img/modellacopains1.jpg', 'img/modellacopains2.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="Le iniziative">
                    <img src="{{ asset($img) }}" alt="Le iniziative" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sezione: I clienti e gli amici --}}
    <section class="gallery-section">
        <div class="gallery-section-header">
            <h2 class="gallery-section-title">I clienti e gli amici</h2>
        </div>
        <div class="masonry-grid" data-section="clienti">
            @foreach([
                'img/abitomarkup.jpg', 'img/abitomarkup1.jpg', 'img/abitomarkup3.jpg',
                'img/abitomarkup4.jpg', 'img/abitomarkup5.jpg', 'img/choleabito.jpeg',
                'img/choleabito1.jpeg', 'img/choleabito2.jpeg', 'img/choleabito3.jpeg',
                'img/choleabito4.jpeg', 'img/abitocopains.jpg', 'img/abitocopains1.jpg',
                'img/abitocopains2.jpg', 'img/abitocopains3.jpg', 'img/abitocopains4.jpg'
            ] as $img)
                <div class="masonry-item gallery-item" data-src="{{ asset($img) }}" data-caption="I clienti e gli amici">
                    <img src="{{ asset($img) }}" alt="I clienti e gli amici" loading="lazy">
                    <div class="masonry-overlay">
                        <i class="bi bi-zoom-in"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</x-layout>