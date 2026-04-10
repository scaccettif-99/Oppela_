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

});