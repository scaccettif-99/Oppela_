document.addEventListener('DOMContentLoaded', () => {

    const navbar = document.querySelector('.navbar');
    const toggler = document.querySelector('.navbar-toggler');
    const icon = document.querySelector('.toggler-icon');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const scrollTopBtn = document.getElementById('scrollTopBtn');

    // navbar scroll
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        let currentScroll = window.scrollY;

        if (currentScroll > lastScroll && currentScroll > 100) {
            navbar.style.top = '-80px';
        } else {
            navbar.style.top = '0';
        }

        if (currentScroll > 50) {
            navbar.classList.add('navSmall');
        } else {
            navbar.classList.remove('navSmall');
        }

        lastScroll = currentScroll;
    });

    // scroll top button
    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            scrollTopBtn.style.display = window.scrollY > 300 ? 'block' : 'none';
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        });
    }

    // toggler icon animation
    if (toggler && icon) {
        toggler.addEventListener('click', () => {
            icon.classList.toggle('animate-toggle');
        });
    }

    // HERO ACCORDION
    const heroPanels = document.querySelectorAll('.hero-panel');

    if (heroPanels.length > 0) {
        const isMobile = () => window.innerWidth <= 768;
        let autoInterval = null;
        let currentPanel = 0;

        const activatePanel = (index) => {
            heroPanels.forEach(p => p.classList.remove('active'));
            heroPanels[index].classList.add('active');
            currentPanel = index;
        };

        const startAuto = () => {
            autoInterval = setInterval(() => {
                const next = (currentPanel + 1) % heroPanels.length;
                activatePanel(next);
            }, 4000);
        };

        const stopAuto = () => clearInterval(autoInterval);

        heroPanels.forEach((panel, i) => {
            panel.addEventListener('mouseenter', () => {
                if (!isMobile()) {
                    stopAuto();
                    activatePanel(i);
                }
            });

            panel.addEventListener('mouseleave', () => {
                if (!isMobile()) {
                    startAuto();
                }
            });

            panel.addEventListener('click', () => {
                if (isMobile()) {
                    stopAuto();
                    activatePanel(i);
                    startAuto();
                }
            });
        });

        startAuto();
    }

    // intersection observer brand cards
    const brandCards = document.querySelectorAll('.brand-card');
    if (brandCards.length > 0) {
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('card-visible');
                    cardObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

        brandCards.forEach((card, index) => {
            card.style.transitionDelay = `${(index % 5) * 0.1}s`;
            cardObserver.observe(card);
        });
    }

    // CARD ANNUNCI — slider foto (auto, frecce, pallini, swipe)
    document.querySelectorAll('.card-slider').forEach(slider => {
        const track = slider.querySelector('.card-slider-track');
        const slides = slider.querySelectorAll('.card-slide');
        const dots = slider.querySelectorAll('.slide-dot');
        const href = slider.dataset.href;

        let current = 0;
        let timer = null;
        let startX = null;
        let deltaX = 0;
        let moved = false;

        const goTo = (index) => {
            if (!track) return;
            current = (index + slides.length) % slides.length;
            track.style.transform = `translateX(-${current * 100}%)`;
            dots.forEach((d, i) => d.classList.toggle('active', i === current));
        };

        const stop = () => { clearInterval(timer); timer = null; };
        const start = () => {
            stop();
            if (slides.length > 1) timer = setInterval(() => goTo(current + 1), 3500);
        };

        if (slides.length > 1) {
            slider.querySelector('.card-slider-btn.prev').addEventListener('click', (e) => {
                e.preventDefault(); e.stopPropagation();
                goTo(current - 1); start();
            });
            slider.querySelector('.card-slider-btn.next').addEventListener('click', (e) => {
                e.preventDefault(); e.stopPropagation();
                goTo(current + 1); start();
            });

            // autoplay solo quando la card è visibile, pausa al passaggio del mouse
            new IntersectionObserver((entries) => {
                entries.forEach(entry => entry.isIntersecting ? start() : stop());
            }, { threshold: 0.4 }).observe(slider);

            slider.addEventListener('mouseenter', stop);
            slider.addEventListener('mouseleave', start);

            // swipe su touch
            slider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                deltaX = 0;
                stop();
                track.classList.add('dragging');
            }, { passive: true });

            slider.addEventListener('touchmove', (e) => {
                if (startX === null) return;
                deltaX = e.touches[0].clientX - startX;
                const pct = (deltaX / slider.offsetWidth) * 100;
                track.style.transform = `translateX(calc(-${current * 100}% + ${pct}%))`;
            }, { passive: true });

            slider.addEventListener('touchend', () => {
                if (startX === null) return;
                track.classList.remove('dragging');
                moved = Math.abs(deltaX) > 10;
                if (deltaX < -40) goTo(current + 1);
                else if (deltaX > 40) goTo(current - 1);
                else goTo(current);
                startX = null;
                start();
            });
        }

        // click sulla foto: apre il dettaglio annuncio (ma non dopo uno swipe)
        if (href) {
            slider.addEventListener('click', () => {
                if (moved) { moved = false; return; }
                window.location.href = href;
            });
        }
    });

    // DETTAGLIO ANNUNCIO — thumbnails + lightbox con zoom
    const zoomBox = document.getElementById('zoomLightbox');
    if (zoomBox) {
        const images = JSON.parse(zoomBox.dataset.images || '[]');
        const stage = document.getElementById('zoomStage');
        const img = document.getElementById('zoomImg');
        const counter = document.getElementById('zoomCounter');
        const mainImg = document.getElementById('imgPrincipale');
        const mainBg = document.getElementById('imgPrincipaleBg');
        const thumbs = document.querySelectorAll('.thumb-gallery');

        const MAX = 5;
        let index = 0;
        let scale = 1, tx = 0, ty = 0;
        let baseW = 0, baseH = 0, baseL = 0, baseT = 0;

        const setMain = (i) => {
            index = i;
            mainImg.src = images[i];
            if (mainBg) mainBg.src = images[i];
            thumbs.forEach((t, k) => t.classList.toggle('active', k === i));
        };

        thumbs.forEach(t => t.addEventListener('click', () => setMain(Number(t.dataset.index))));

        // dimensione "adatta allo schermo" dell'immagine, centrata nello stage
        const fit = () => {
            const W = stage.clientWidth, H = stage.clientHeight;
            const nw = img.naturalWidth || 1, nh = img.naturalHeight || 1;
            const pad = window.innerWidth < 576 ? 0.98 : 0.86;
            const r = Math.min((W * pad) / nw, (H * pad) / nh, 1.5);
            baseW = nw * r; baseH = nh * r;
            baseL = (W - baseW) / 2; baseT = (H - baseH) / 2;
            img.style.width = baseW + 'px';
            img.style.height = baseH + 'px';
            img.style.left = baseL + 'px';
            img.style.top = baseT + 'px';
        };

        const clamp = () => {
            const W = stage.clientWidth, H = stage.clientHeight;
            const w = baseW * scale, h = baseH * scale;
            tx = w <= W ? (W - w) / 2 - baseL : Math.min(-baseL, Math.max(W - baseL - w, tx));
            ty = h <= H ? (H - h) / 2 - baseT : Math.min(-baseT, Math.max(H - baseT - h, ty));
        };

        const render = (animate = false) => {
            clamp();
            img.classList.toggle('animate', animate);
            img.classList.toggle('zoomed', scale > 1.01);
            img.style.transform = `translate(${tx}px, ${ty}px) scale(${scale})`;
        };

        // zoom mantenendo fermo il punto (cx, cy) dello schermo
        const zoomAt = (cx, cy, newScale, animate = false) => {
            newScale = Math.min(MAX, Math.max(1, newScale));
            const rect = img.getBoundingClientRect();
            const k = newScale / scale;
            tx += (cx - rect.left) * (1 - k);
            ty += (cy - rect.top) * (1 - k);
            scale = newScale;
            render(animate);
        };

        const zoomCenter = (factor) => {
            const r = stage.getBoundingClientRect();
            zoomAt(r.left + r.width / 2, r.top + r.height / 2, scale * factor, true);
        };

        const reset = () => { scale = 1; tx = 0; ty = 0; render(); };

        const show = (i) => {
            index = (i + images.length) % images.length;
            counter.textContent = images.length > 1 ? `${index + 1} / ${images.length}` : '';
            img.style.opacity = '0';
            img.onload = () => { fit(); reset(); img.style.opacity = '1'; };
            img.src = images[index];
            if (img.complete && img.naturalWidth) img.onload();
        };

        const open = () => {
            zoomBox.classList.add('open');
            document.body.style.overflow = 'hidden';
            show(index);
        };

        const close = () => {
            zoomBox.classList.remove('open');
            document.body.style.overflow = '';
            setMain(index);
        };

        document.getElementById('showMain').addEventListener('click', open);
        document.getElementById('zoomClose').addEventListener('click', close);
        document.getElementById('zoomIn').addEventListener('click', () => zoomCenter(1.6));
        document.getElementById('zoomOut').addEventListener('click', () => zoomCenter(1 / 1.6));
        document.getElementById('zoomPrev')?.addEventListener('click', () => show(index - 1));
        document.getElementById('zoomNext')?.addEventListener('click', () => show(index + 1));

        // click sullo sfondo vuoto chiude
        // (con il pointer capture il click arriva allo stage anche se si è toccata la foto)
        let downOnImg = false;
        stage.addEventListener('pointerdown', (e) => { downOnImg = e.target === img; }, true);
        stage.addEventListener('click', (e) => {
            if (e.target === stage && !downOnImg) close();
            downOnImg = false;
        });

        // rotella del mouse
        stage.addEventListener('wheel', (e) => {
            e.preventDefault();
            zoomAt(e.clientX, e.clientY, scale * (e.deltaY < 0 ? 1.15 : 1 / 1.15));
        }, { passive: false });

        // doppio clic / doppio tap: ingrandisce sul punto o torna intero
        const toggleZoom = (x, y) => {
            if (scale > 1.01) { scale = 1; tx = 0; ty = 0; render(true); }
            else zoomAt(x, y, 2.5, true);
        };
        img.addEventListener('dblclick', (e) => toggleZoom(e.clientX, e.clientY));

        // trascinamento e pinch con pointer events
        const pointers = new Map();
        let lastPinchDist = 0;
        let lastTap = 0;

        stage.addEventListener('pointerdown', (e) => {
            if (e.target !== img) return;
            stage.setPointerCapture(e.pointerId);
            pointers.set(e.pointerId, { x: e.clientX, y: e.clientY, sx: e.clientX, sy: e.clientY });
            img.classList.add('panning');
            if (pointers.size === 2) {
                const [a, b] = [...pointers.values()];
                lastPinchDist = Math.hypot(a.x - b.x, a.y - b.y);
            }
        });

        stage.addEventListener('pointermove', (e) => {
            const p = pointers.get(e.pointerId);
            if (!p) return;
            const dx = e.clientX - p.x, dy = e.clientY - p.y;
            p.x = e.clientX; p.y = e.clientY;

            if (pointers.size === 2) {
                const [a, b] = [...pointers.values()];
                const dist = Math.hypot(a.x - b.x, a.y - b.y);
                if (lastPinchDist) zoomAt((a.x + b.x) / 2, (a.y + b.y) / 2, scale * (dist / lastPinchDist));
                lastPinchDist = dist;
            } else if (scale > 1.01) {
                tx += dx; ty += dy;
                render();
            }
        });

        const endPointer = (e) => {
            const p = pointers.get(e.pointerId);
            if (!p) return;
            pointers.delete(e.pointerId);
            if (pointers.size < 2) lastPinchDist = 0;
            if (pointers.size === 0) img.classList.remove('panning');

            // swipe orizzontale a zoom 1: foto successiva/precedente
            const swipe = e.clientX - p.sx;
            if (e.pointerType === 'touch' && scale <= 1.01 && Math.abs(swipe) > 60 && images.length > 1) {
                show(index + (swipe < 0 ? 1 : -1));
                return;
            }

            // doppio tap su touch
            if (e.pointerType === 'touch' && Math.hypot(e.clientX - p.sx, e.clientY - p.sy) < 10) {
                const now = Date.now();
                if (now - lastTap < 300) { toggleZoom(e.clientX, e.clientY); lastTap = 0; }
                else lastTap = now;
            }
        };
        stage.addEventListener('pointerup', endPointer);
        stage.addEventListener('pointercancel', endPointer);

        document.addEventListener('keydown', (e) => {
            if (!zoomBox.classList.contains('open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft' && images.length > 1) show(index - 1);
            if (e.key === 'ArrowRight' && images.length > 1) show(index + 1);
            if (e.key === '+' || e.key === '=') zoomCenter(1.6);
            if (e.key === '-') zoomCenter(1 / 1.6);
        });

        window.addEventListener('resize', () => {
            if (zoomBox.classList.contains('open')) { fit(); reset(); }
        });
    }

    // FORM ANNUNCIO — mostra le taglie giuste in base alla categoria
    const categoriaSelect = document.getElementById('categoriaSelect');
    if (categoriaSelect) {
        const aggiornaTaglie = () => {
            const tipo = categoriaSelect.selectedOptions[0]?.dataset.tipoTaglie || '';
            document.querySelectorAll('.taglie-gruppo').forEach(gruppo => {
                const attivo = gruppo.dataset.tipo === tipo;
                gruppo.hidden = !attivo;
                // i gruppi nascosti non vengono inviati
                gruppo.querySelectorAll('input').forEach(input => {
                    input.disabled = !attivo;
                    if (!attivo) input.checked = false;
                });
            });
        };
        categoriaSelect.addEventListener('change', aggiornaTaglie);
    }

    // SHOP — i filtri si applicano subito, URL pulito senza parametri vuoti
    const shopFiltri = document.getElementById('shopFiltri');
    if (shopFiltri) {
        shopFiltri.addEventListener('change', () => {
            const params = new URLSearchParams();
            new FormData(shopFiltri).forEach((valore, chiave) => {
                if (valore) params.set(chiave, valore);
            });
            const query = params.toString();
            window.location.href = shopFiltri.action + (query ? '?' + query : '');
        });
    }

    // PERSONALIZZA HOME — punto focale delle slide: clic sulla foto + anteprime computer/telefono
    document.querySelectorAll('[data-focus-picker]').forEach(picker => {
        const form = picker.closest('form');
        const area = picker.querySelector('[data-focus-area]');
        const img = picker.querySelector('[data-focus-img]');
        const punto = picker.querySelector('[data-focus-punto]');
        const inX = picker.querySelector('[data-focus-x]');
        const inY = picker.querySelector('[data-focus-y]');
        const anteprime = picker.querySelectorAll('[data-focus-anteprima]');
        const file = form?.querySelector('[data-focus-file]');

        const aggiorna = () => {
            const x = Number(inX.value), y = Number(inY.value);
            punto.style.left = x + '%';
            punto.style.top = y + '%';
            anteprime.forEach(a => { a.style.objectPosition = `${x}% ${y}%`; });
        };

        area.addEventListener('click', (e) => {
            const r = img.getBoundingClientRect();
            const clamp = (v) => Math.min(100, Math.max(0, Math.round(v)));
            inX.value = clamp(((e.clientX - r.left) / r.width) * 100);
            inY.value = clamp(((e.clientY - r.top) / r.height) * 100);
            aggiorna();
        });

        // nuova foto scelta: la mostro subito, prima del salvataggio
        file?.addEventListener('change', () => {
            const f = file.files[0];
            if (!f) return;
            const url = URL.createObjectURL(f);
            img.src = url;
            anteprime.forEach(a => { a.src = url; });
        });

        aggiorna();
    });

    // FORM ANNUNCIO / LOGHI — miniature delle foto appena scelte
    document.querySelectorAll('[data-anteprima-input]').forEach(input => {
        const box = document.querySelector(`[data-anteprima="${input.id}"]`);
        if (!box) return;
        input.addEventListener('change', () => {
            box.innerHTML = '';
            [...input.files].forEach(f => {
                const t = document.createElement('img');
                t.src = URL.createObjectURL(f);
                t.alt = '';
                box.appendChild(t);
            });
        });
    });

    // POPUP SORPRESA
const popup = document.getElementById('sorpresaPopup');
const popupClose = document.getElementById('popupClose');

if (popup) {
    // apre dopo 2 secondi
    setTimeout(() => {
        popup.classList.add('visible');
    }, 1000);

    // chiude con la X
    popupClose.addEventListener('click', () => {
        popup.classList.remove('visible');
    });

    // chiude cliccando fuori
    popup.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.classList.remove('visible');
        }
    });

    // chiude scrollando
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100 && popup.classList.contains('visible')) {
            popup.classList.remove('visible');
        }
    }, { once: false });
}

// SORPRESA BANNER — effetto pulsate
const sorpresaTitle = document.getElementById('sorpresaTitle');
const sorpresaBtn = document.getElementById('sorpresaBtn');

if (sorpresaTitle && sorpresaBtn) {
    const sorpresaObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                sorpresaTitle.classList.add('pulse');
                sorpresaBtn.classList.add('pulse');

                setTimeout(() => {
                    sorpresaTitle.classList.remove('pulse');
                    sorpresaBtn.classList.remove('pulse');
                }, 3000);

                sorpresaObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    sorpresaObserver.observe(document.getElementById('sorpresaBanner'));
}

    // chi siamo — caption automatica allo scroll
    const chisiamoWrappers = document.querySelectorAll('.chisiamo-img-wrapper');
    if (chisiamoWrappers.length > 0) {
        const chisiamoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('open');
                    }, 300);
                    chisiamoObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });

        chisiamoWrappers.forEach(wrapper => {
            chisiamoObserver.observe(wrapper);
        });
    }
// frecce navigazione brand scroll
document.querySelectorAll('.brand-nav-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.dataset.target;
        const dir = btn.dataset.dir;
        const wrapper = document.getElementById(targetId);
        if (!wrapper) return;
        const scrollAmount = 300;
        wrapper.scrollBy({
            left: dir === 'next' ? scrollAmount : -scrollAmount,
            behavior: 'smooth'
        });
    });
});

// GALLERY — masonry intersection observer
const galleryItems = document.querySelectorAll('.masonry-item');
if (galleryItems.length > 0) {
    const galleryObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('item-visible');
                }, i * 60);
                galleryObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    galleryItems.forEach(item => galleryObserver.observe(item));
}

// LIGHTBOX
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightboxImg');
const lightboxCaption = document.getElementById('lightboxCaption');
const lightboxClose = document.getElementById('lightboxClose');
const lightboxPrev = document.getElementById('lightboxPrev');
const lightboxNext = document.getElementById('lightboxNext');

if (lightbox) {
    let currentItems = [];
    let currentIndex = 0;

    const openLightbox = (items, index) => {
        currentItems = items;
        currentIndex = index;
        updateLightbox();
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const closeLightbox = () => {
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    };

    const updateLightbox = () => {
        const item = currentItems[currentIndex];
        lightboxImg.style.opacity = '0';
        setTimeout(() => {
            lightboxImg.src = item.dataset.src;
            lightboxImg.alt = item.dataset.caption;
            lightboxCaption.textContent = item.dataset.caption;
            lightboxImg.style.opacity = '1';
        }, 150);
    };

    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', () => {
            const section = item.closest('.masonry-grid, .brand-scroll');
            const items = Array.from(section.querySelectorAll('.gallery-item'));
            const index = items.indexOf(item);
            openLightbox(items, index);
        });
    });

    lightboxClose.addEventListener('click', closeLightbox);

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    lightboxPrev.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + currentItems.length) % currentItems.length;
        updateLightbox();
    });

    lightboxNext.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % currentItems.length;
        updateLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') {
            currentIndex = (currentIndex - 1 + currentItems.length) % currentItems.length;
            updateLightbox();
        }
        if (e.key === 'ArrowRight') {
            currentIndex = (currentIndex + 1) % currentItems.length;
            updateLightbox();
        }
    });
}

});