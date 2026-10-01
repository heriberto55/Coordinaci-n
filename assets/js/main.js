const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');

if (menuToggle && menu) {
    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('is-open');
        menuToggle.classList.toggle('is-open');
    });
}

const slides = Array.from(document.querySelectorAll('[data-slide]'));
let currentSlide = 0;

function showSlide(index) {
    if (!slides.length) return;
    slides.forEach((slide, i) => slide.classList.toggle('is-active', i === index));
}

document.querySelectorAll('[data-slide-control]').forEach((button) => {
    button.addEventListener('click', () => {
        const direction = button.dataset.slideControl === 'next' ? 1 : -1;
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        showSlide(currentSlide);
    });
});

if (slides.length > 1) {
    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }, 7000);
}

