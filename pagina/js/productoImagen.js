let currentImage = 'imagen-principal.jpg'; // Imagen principal por defecto

function changeImage(image) {
    const mainImage = document.getElementById('main-image');
    mainImage.src = image;
    currentImage = image; // Actualiza la imagen actual
}

// Cambia la imagen principal al pasar el mouse sobre las miniaturas
const thumbnails = document.querySelectorAll('.thumbnail');
thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('mouseover', () => {
        // Primero elimina la clase 'rojitoThm' de todos los thumbnails
        thumbnails.forEach(t => t.classList.remove('rojitoThm'));
        
        // Luego, agrega la clase 'rojitoThm' al thumbnail actual
        thumbnail.classList.add('rojitoThm');

        // Cambia la imagen principal
        const newSrc = thumbnail.src;
        document.getElementById('main-image').src = newSrc;
    });

    // No es necesario cambiar la imagen al salir
});
