document.addEventListener("DOMContentLoaded", function () {
    const carousels = document.querySelectorAll('.carouselImages-container');

    carousels.forEach(carousel => {
        let currentSlides = 0;
        let visibleItems = 5;
        const items = carousel.querySelectorAll('.carouselImages-item');
        const totalSlides = items.length;

        function updateVisibleItems() {
            if (window.matchMedia("(max-width: 425px)").matches) {
                visibleItems = 1; // Cambia a 1 elementos visibles si la pantalla es menor a 425px
            } else if (window.matchMedia("(max-width: 768px)").matches) {
                visibleItems = 2; // 2 elementos visibles si la pantalla es menor a 768px
            } else if (window.matchMedia("(max-width: 1024px)").matches) {
                visibleItems = 3; // 3 elementos visibles si la pantalla es menor a 1024px
            } else if (window.matchMedia("(max-width: 1366px)").matches) {
                visibleItems = 4; // 4 elementos visibles si la pantalla es menor a 1366px
            } else if (window.matchMedia("(max-width: 1440px)").matches) {
                visibleItems = 5; // 4 elementos visibles si la pantalla es menor a 1366px
            } else {
                visibleItems = 6; // Valor por defecto para pantallas más grandes
            }
            updateCarousel();
        }

        function updateCarousel() {
            const carouselImages = carousel.querySelector('.carouselImages');

            // Asegúrate de que el ancho del contenedor se ajuste al número total de elementos
            carouselImages.style.width = `${(100 / visibleItems) * totalSlides}%`;

            // Desplaza el carrusel al lugar correcto
            carouselImages.style.transform = `translateX(-${(100 / totalSlides) * currentSlides}%)`;
        }

        function nextSlide() {
            if (window.matchMedia("(max-width: 1024px)").matches) {
                if (currentSlides + visibleItems < totalSlides) {
                    currentSlides += 1;
                } else {
                    currentSlides = totalSlides - visibleItems;
                }
            } else {
                if (currentSlides + visibleItems < totalSlides) {
                    currentSlides += 2;
                } else {
                    currentSlides = totalSlides - visibleItems;
                }
            }
            updateCarousel();
        }

        function prevSlide() {
            if (currentSlides > 0) {
                currentSlides -= 2;
            } else {
                currentSlides = 0;
            }
            updateCarousel();
        }

        // Eventos de click para los botones de control del carrusel
        const nextButton = carousel.querySelector('.nextImages');
        const prevButton = carousel.querySelector('.prevImages');

        if (nextButton) {
            nextButton.addEventListener('click', nextSlide);
        }

        if (prevButton) {
            prevButton.addEventListener('click', prevSlide);
        }

        // Actualiza el carrusel cuando cambia el tamaño de la ventana
        window.addEventListener('resize', updateVisibleItems);

        // Inicializa el carrusel
        updateVisibleItems();
    });
});
