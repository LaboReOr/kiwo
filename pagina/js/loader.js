window.onload = function() {
    setTimeout(() => {
        const loader = document.querySelector('.loader');
        loader.classList.add('fade-out'); // Añade la clase para animar
        setTimeout(() => {
            loader.style.display = 'none'; // Oculta el div
        }, 1000); // Duración de la animación
    }, 400); // 1000 milisegundos = 1 segundo
};