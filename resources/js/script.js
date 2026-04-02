let navbar = document.querySelector(`.navbar`);
let bgNav = document.querySelector(`.bg-t`);
let navlink = document.querySelectorAll(`.nav-link`);
let caroSello = document.querySelector('#heroCarousel');
let boxesCaption = document.querySelectorAll('.caption-box');


// window.addEventListener(`scroll`,()=>{
    //     if (window.scrollY > 0) {
//         navbar.classList.add(`navSmall`)
//     }else{
    //         navbar.classList.remove(`navSmall`)
//     }
// })

let lastScroll = 0;

window.addEventListener('scroll', () => {
    let currentScroll = window.scrollY;
    
    if (currentScroll > lastScroll && currentScroll > 100) {
        navbar.style.top = "-80px"; // nasconde
    } else {
        navbar.style.top = "0"; // mostra
    }
    
    if (currentScroll > 50) {
        navbar.classList.add('navSmall');
    } else {
        navbar.classList.remove('navSmall');
    }
    
    lastScroll = currentScroll;
});

// animazione caption del carosello



function togliAnimaz() {
    boxesCaption.forEach(box => {
        box.classList.remove('animate');
    });
}
function animaSlideAttiva() {
    let activeSlide = document.querySelector('.carousel-item.active');
    let activeCaption = activeSlide.querySelector('.caption-box');
    if (activeCaption) {
        activeCaption.classList.add('animate');
    }
}

// Al caricamento della pagina, anima subito la prima slide
document.addEventListener('DOMContentLoaded', () => {
    animaSlideAttiva();
});

// Al cambio slide, resetta e anima la nuova slide
caroSello.addEventListener('slid.bs.carousel', () => {
    togliAnimaz();
    animaSlideAttiva();
});

let scrollTopBtn = document.getElementById('scrollTopBtn');
let navbarCollapse = document.querySelector('.navbar-collapse');

window.addEventListener('scroll', () => {
    if (window.scrollY > 300) { 
        scrollTopBtn.style.display = 'block';
    } else {
        scrollTopBtn.style.display = 'none';
    }
    
    // Chiude il menu mobile se è aperto
    if (navbarCollapse.classList.contains('show')) {
        navbarCollapse.classList.remove('show');
    }
});

scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // Chiude il menu mobile se è aperto
    if (navbarCollapse.classList.contains('show')) {
        navbarCollapse.classList.remove('show');
    }
});

let toggler = document.querySelector('.navbar-toggler');
let icon = document.querySelector('.toggler-icon');

toggler.addEventListener('click', () => {
    icon.classList.toggle('animate-toggle');
});