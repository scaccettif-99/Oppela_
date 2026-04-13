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

    // slide immagini hover card annunci
    document.querySelectorAll('.card-img-wrapper').forEach(wrapper => {
        const imgs = wrapper.querySelectorAll('.card-slide-img');
        const dots = wrapper.querySelectorAll('.slide-dot');
        if (imgs.length <= 1) return;

        let current = 0;
        let interval = null;

        const goTo = (index) => {
            imgs[current].classList.remove('active');
            dots[current]?.classList.remove('active');
            current = index % imgs.length;
            imgs[current].classList.add('active');
            dots[current]?.classList.add('active');
        };

        wrapper.addEventListener('mouseenter', () => {
            interval = setInterval(() => goTo(current + 1), 900);
        });

        wrapper.addEventListener('mouseleave', () => {
            clearInterval(interval);
            goTo(0);
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
            const section = item.closest('.masonry-grid');
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