document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.querySelector('.menuMobileButton');
    const crossButton = document.querySelector('#crossMenuMobile');
    const menu = document.querySelector('.menuMobileDIV');

    menuButton.addEventListener('click', function() {
        menu.classList.add('show');
    });

    crossButton.addEventListener('click', function() {
        menu.classList.remove('show');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.querySelector('#filtrarYordenar');
    const crossButton = document.querySelector('#crossFiltrarYordenar');
    const menu = document.querySelector('.filtrarYordenarDIV');

    menuButton.addEventListener('click', function() {
        menu.classList.add('show');
    });

    crossButton.addEventListener('click', function() {
        menu.classList.remove('show');
    });
});