let navbar = document.querySelector(`.navbar`);
let bgNav = document.querySelector(`.bg-t`);
let navlink = document.querySelectorAll(`.nav-link`);
let caroSello = document.querySelector('#heroCarousel');
let boxesCaption = document.querySelectorAll('.caption-box');


window.addEventListener(`scroll`,()=>{
    if (window.scrollY > 0) {
        navbar.classList.add(`navSmall`)
    }else{
        navbar.classList.remove(`navSmall`)
    }
})

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
