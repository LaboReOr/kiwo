let currentSlide = 0;
const totalSlides = document.querySelectorAll('.carousel-item').length;

function showSlide(index) {
    const carousel = document.querySelector('.carousel');

    if (index >= totalSlides) {
        currentSlide = totalSlides - 1;
    } else if (index < 0) {
        currentSlide = 0;
    } else {
        currentSlide = index;
    }

    const offset = -currentSlide * 100;
    carousel.style.transform = `translateX(${offset}%)`;
}


function nextSlide() {
    if(currentSlide == totalSlides-1){
        showSlide(currentSlide - totalSlides + 1);
    } else {
        showSlide(currentSlide + 1);
    }
}

function prevSlide() {
    if(currentSlide == 0){
        showSlide(currentSlide + totalSlides - 1);
    } else {
        showSlide(currentSlide - 1);;
    }
}

// Cambiar de imagen automáticamente cada determinados segundos
setInterval(() => {
        if (currentSlide < totalSlides - 1) {
            nextSlide();
        } else {
            prevSlide();
            prevSlide();
        }
}, 7000);