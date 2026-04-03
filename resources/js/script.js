document.addEventListener('DOMContentLoaded', () => {

    const navbar = document.querySelector('.navbar');
    const toggler = document.querySelector('.navbar-toggler');
    const icon = document.querySelector('.toggler-icon');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    const caroSello = document.querySelector('#heroCarousel');
    const boxesCaption = document.querySelectorAll('.caption-box');

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

    // animazione caption carosello
    if (caroSello) {
        const togliAnimaz = () => {
            boxesCaption.forEach(box => box.classList.remove('animate'));
        };

        const animaSlideAttiva = () => {
            const activeSlide = document.querySelector('.carousel-item.active');
            if (activeSlide) {
                const activeCaption = activeSlide.querySelector('.caption-box');
                if (activeCaption) activeCaption.classList.add('animate');
            }
        };

        animaSlideAttiva();

        caroSello.addEventListener('slid.bs.carousel', () => {
            togliAnimaz();
            animaSlideAttiva();
        });
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

});