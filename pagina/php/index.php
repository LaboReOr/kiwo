<?php
session_start();  // Iniciamos la sesión

$variables = parse_ini_file('coneccionSQL.txt');

// Conexión a la base de datos
$servername = "127.0.0.1";
$database = "kiwo";
$username = $variables['usuario'];
$password = $variables['contraseña'];

$conexion = mysqli_connect($servername, $username, $password, $database); // Se crea la conexión

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para obtener los productos de la tabla 'ropa'
$query = "SELECT idRopa, nombre, marca, precio, oferta FROM ropa ORDER BY RAND() LIMIT 20";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion)); // Para diagnosticar errores en la consulta
}

$query2 = "SELECT idJuguete, nombre, marca, precio, oferta FROM juguete ORDER BY RAND() LIMIT 20";
$resultado2 = mysqli_query($conexion, $query2);

if (!$resultado2) {
    die("Error en la consulta: " . mysqli_error($conexion)); // Para diagnosticar errores en la consulta
}


///////////////////////////////
$query3 = "SELECT idRopa, nombre, marca, precio FROM ropa ORDER BY RAND() LIMIT 3";
$resultado3 = mysqli_query($conexion, $query3);

///////////////////////////////
$query4 = "SELECT idJuguete, nombre FROM juguete ORDER BY RAND() LIMIT 3";
$resultado4 = mysqli_query($conexion, $query4);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Kiwo</title>
    <link rel="shortcut icon" href="../img/iconos/KIcon.png" type="image/x-icon">

    <link rel="stylesheet" href="../css/carousel.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/carouselProductos.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="loader">
        <img src="../img/iconos/K-kiwoBlanco.png" alt="KIWO">
    </div>
    <header>
        <section class="header">
            <div class="headerTOP" id="textHEADER"></div>
            <div class="headerBOT">
                <div class="maxWITH">
                    <div class="topNAV">
                        <div class="imgNav paddingNav">
                            <a href="index.php">
                                <img src="../img/iconos/K-kiwoBlanco.png" alt="logoKiwo">
                            </a>
                        </div>
                        <div class="midNav">
                            <a href="productosListado.php?seccion=0&ordenamiento=&marca=&talle=&genero=HOMBRE&material=" class="categ ninoHOVER">Niño</a>
                            <div class="nino">
                                <div>
                                    <h3>Marcas Destacadas</h3>
                                    <a href="#">Ver todas las marcas</a>
                                    <a href="#">Adidas</a>
                                    <a href="#">Nike</a>
                                    <a href="#">Puma</a>
                                    <a href="#">Vans</a>
                                </div>
                                <div>
                                    <h3>Ropa</h3>
                                    <a href="#">Ver toda ropa</a>
                                    <a href="#">Ver toda ropa deportiva</a>
                                    <a href="#">Ver toda ropa de vestir</a>
                                    <a href="#">Remeras</a>
                                    <a href="#">Pantalones</a>
                                    <a href="#">Buzos</a>
                                    <a href="#">Accesorios</a>
                                </div>
                                <div>
                                    <h3>Calzado</h3>
                                    <a href="#">Ver todos los calzados</a>
                                    <a href="#">Zapatillas</a>
                                    <a href="#">Zapatos</a>
                                    <a href="#">Medias</a>
                                    <a href="#">Running</a>
                                    <a href="#">Accesorios</a>
                                </div>
                                <div>
                                    <h3>General</h3>
                                    <a href="#">Ver toda la ropa</a>
                                    <a href="#">Calzado</a>
                                    <a href="#">Remeras</a>
                                    <a href="#">Pantalones</a>
                                    <a href="#">Buzos</a>
                                    <a href="#">Accesorios</a>
                                </div>
                            </div>
    
                            <a href="productosListado.php?seccion=0&ordenamiento=&marca=&talle=&genero=MUJER&material=" class="categ ninaHOVER">Niña</a>
                            <div class="nina">
                                <div>
                                    <h3>Marcas Destacadas</h3>
                                    <a href="#">Ver todas las marcas</a>
                                    <a href="#">Adidas</a>
                                    <a href="#">Nike</a>
                                    <a href="#">Puma</a>
                                    <a href="#">Vans</a>
                                </div>
                                <div>
                                    <h3>Ropa</h3>
                                    <a href="#">Ver toda ropa</a>
                                    <a href="#">Ver toda ropa deportiva</a>
                                    <a href="#">Ver toda ropa de vestir</a>
                                    <a href="#">Remeras</a>
                                    <a href="#">Pantalones</a>
                                    <a href="#">Buzos</a>
                                    <a href="#">Accesorios</a>
                                </div>
                                <div>
                                    <h3>Calzado</h3>
                                    <a href="#">Ver todos los calzados</a>
                                    <a href="#">Zapatillas</a>
                                    <a href="#">Zapatos</a>
                                    <a href="#">Medias</a>
                                    <a href="#">Running</a>
                                    <a href="#">Accesorios</a>
                                </div>
                                <div>
                                    <h3>General</h3>
                                    <a href="#">Ver toda la ropa</a>
                                    <a href="#">Calzado</a>
                                    <a href="#">Remeras</a>
                                    <a href="#">Pantalones</a>
                                    <a href="#">Buzos</a>
                                    <a href="#">Accesorios</a>
                                </div>
                            </div>
    
                            <a href="productosListado.php?seccion=1" class="categ">Juegos y Juguetes</a>
                            <a href="productosListado.php?seccion=0" class="categ">Ropa</a>
                        </div>
                        <div class="rightNAV paddingNav">
                            <div class="searchbar">
                                <form action="productosListado.php" method="GET">
                                    <input type="text" name="query2" id="searchInput" placeholder="Buscar" required>
                                    <button type="submit"><i class='pointer bx bx-search searchButton'></i></button>
                                </form>
                            </div>
                            <a href="carrito.php"><i class='bx bx-cart'></i></a>
                            <a href="cuenta.php"><i class='bx bx-user'></i></a>
                        </div>
                        <div class="mobileRightNAV paddingNav">
                            <div class="searchbar">
                                <form action="productosListado.php" method="GET">
                                    <input type="text" name="query2" id="searchInput" placeholder="Buscar" required>
                                    <button type="submit"><i class='pointer bx bx-search searchButton'></i></button>
                                </form>
                            </div>
                            <button class="menuMobileButton">
                                <i class='bx bx-menu menuMobile'></i>
                            </button>
                            <div class="menuMobileDIV">
                                <div class="topMenuMobile">
                                    <i class='bx bx-x invisible'></i>
                                    <a class="linkIMG" href="index.php">
                                        <img class="menuIMG" src="../img/iconos/K-kiwoBlanco.png" alt="">
                                    </a>                                    
                                    <button id="crossMenuMobile">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </div>
                                <div class="categoriasMenuMobile">
                                    <p><a href="index.php">INICIO</a></p>
                                    <p><a href="productosListado.php?seccion=0">ROPA</a></p>
                                    <p><a href="productosListado.php?seccion=1">JUEGOS Y JUGUETES</a></p>
                                    <p><a href="productosListado.php?seccion=0&ordenamiento=&marca=&talle=&genero=HOMBRE&material=">NIÑOS</a></p>
                                    <p><a href="productosListado.php?seccion=0&ordenamiento=&marca=&talle=&genero=MUJER&material=">NIÑAS</a></p>
                                </div>
                                <div class="otrosMenuMobile">
                                    <p><a href="cuenta.php">Cuenta</a></p>
                                    <p><a href="carrito.php">Carrito</a></p>
                                    <p><a href="#">Contacto</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
    </header>

    <main>
        <section class="carousel-section">
            <div class="carousel-container">
                <div class="carousel">
                    <div class="carousel-item pointer">
                        <a href="#">
                            <img src="../img/carrusel/carrusel1 fondo.jpg" alt="Imagen 1">
                        </a>
                    </div>
                    <div class="carousel-item pointer">
                        <a href="#">
                            <img src="../img/carrusel/carrusel2 fondo.jpg" alt="Imagen 2">
                        </a>
                    </div>
                    <div class="carousel-item pointer">
                        <a href="#">
                            <img src="../img/carrusel/carrusel3 fondo.jpg" alt="Imagen 3">
                        </a>
                    </div>
                </div>
                <div class="carousel-controls">
                    <button class="prev" onclick="prevSlide()">&#10094;</button>
                    <button class="next" onclick="nextSlide()">&#10095;</button>
                </div>
                <div class="gradient">

                </div>
            </div>
        </section>
        <div class="main">
            <!-- <section class="edades-section">
                <div class="edades">
                    <div class="edad-contenedor pointer">
                        <a href="#">
                            <h2>0 a 2 AÑOS</h2>
                            <img src="img/edades/0a3.gif" alt="0a2">
                        </a>
                    </div>
                    <div class="edad-contenedor pointer">
                        <a href="#">
                            <h2>3 a 7 AÑOS</h2>
                            <img src="img/edades/3a8.gif" alt="3a7">
                        </a>
                    </div>
                    <div class="edad-contenedor pointer">
                        <a href="#">
                            <h2>8 a 12 AÑOS</h2>
                            <img src="img/edades/9a12.gif" alt="8a12">
                        </a>
                    </div>
                </div>
            </section> -->

            <!-- <section class="productos">
                <div class="dos">
                    <img src="../img/productos/1.jpg" alt="">
                    <img src="../img/productos/2.jpeg" alt="">
                </div>
                <img src="../img/productos/3.jpg" alt="">
                <img src="../img/productos/4.webp" alt="">
            </section> -->

            <section class="verano">
                <div class="veranoTop">
                    <h2>ROPA</h2>
                    <a href="productosListado.php?seccion=0" class="botonLink">VER MAS</a>
                </div>
                <div class="veranoIMG">
                    <?php
                        while ($row3 = mysqli_fetch_assoc($resultado3)) {
                            $nombre_url3 = urlencode($row3["idRopa"]); // Codificar nombre para la URL
                            echo '<a href="productoInfo.php?idRopa=' . $nombre_url3 . '">';
                            echo '  <img src="../img/ropa/' . htmlspecialchars($row3["idRopa"]) . '/1.jpg" alt="' . htmlspecialchars($row3["nombre"]) . '">';
                            echo '</a>';
                        }
                    ?>
                </div>
            </section>

            <section class="invierno">
                <div class="inviernoTop">
                    <h2>JUGUETES</h2>
                    <a href="productosListado.php?seccion=1" class="botonLink">VER MAS</a>
                </div>
                <div class="inviernoIMG">
                    <?php
                        while ($row4 = mysqli_fetch_assoc($resultado4)) {
                            $nombre_url4 = urlencode($row4["idJuguete"]); // Codificar nombre para la URL
                            echo '<a href="productoInfo.php?idJuguete=' . $nombre_url4 . '  ">';
                            echo '  <img src="../img/juegos/' . htmlspecialchars($row4["idJuguete"]) . '/1.jpg" alt="' . htmlspecialchars($row4["nombre"]) . '">';
                            echo '</a>';
                        }
                    ?>
                </div>
            </section>

            <section class="ofertas">
                <div class="ofertasTop">
                    <h2>PRODUCTOS</h2>
                    <a class="botonOfetas" href="productosListado.php">VER MAS</a>
                </div>
                <div class="ofertasBot">
                    <section class="carouselImages-section">
                        <div class="carouselImages-container">
                            <div class="carouselImages">
                                <?php
                                while ($row = mysqli_fetch_assoc($resultado)) {
                                    $nombre_url = urlencode($row["idRopa"]); // Codificar nombre para la URL
                                    echo '<div class="carouselImages-item pointer">';
                                    echo '    <div>';
                                    echo '        <a href="productoInfo.php?idRopa=' . $nombre_url . '">';
                                    echo '            <img src="../img/ropa/' . htmlspecialchars($row["idRopa"]) . '/1.jpg" alt="' . htmlspecialchars($row["nombre"]) . '">';
                                    echo '            <section>';
                                    echo '                <p>' . htmlspecialchars($row["nombre"]) . '</p>';
                                    echo '                <h3>$ ' . htmlspecialchars(number_format($row["precio"], 0, '', '.')) . '</h3>';
                                    echo '            </section>';
                                    echo '        </a>';
                                    echo '    </div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <div class="carouselImages-controls">
                                <button class="prevImages" onclick="prevSlideImages()">&#10094;</button>
                                <button class="nextImages" onclick="nextSlideImages()">&#10095;</button>
                            </div>
                        </div>
                    </section>
                    <section class="carouselImages-section">
                        <div class="carouselImages-container">
                            <div class="carouselImages">
                                <?php
                                while ($row2 = mysqli_fetch_assoc($resultado2)) {
                                    $nombre_url2 = urlencode($row2["idJuguete"]); // Codificar nombre para la URL
                                    echo '<div class="carouselImages-item pointer">';
                                    echo '    <div>';
                                    echo '        <a href="productoInfo.php?idJuguete=' . $nombre_url2 . '">';
                                    echo '            <img src="../img/juegos/' . htmlspecialchars($row2["idJuguete"]) . '/1.jpg" alt="' . htmlspecialchars($row2["nombre"]) . '">';
                                    echo '            <section>';
                                    echo '                <p>' . htmlspecialchars($row2["nombre"]) . '</p>';
                                    echo '                <h3>$ ' . htmlspecialchars(number_format($row2["precio"], 0, '', '.')) . '</h3>';
                                    echo '            </section>';
                                    echo '        </a>';
                                    echo '    </div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <div class="carouselImages-controls">
                                <button class="prevImages" onclick="prevSlideImages()">&#10094;</button>
                                <button class="nextImages" onclick="nextSlideImages()">&#10095;</button>
                            </div>
                        </div>
                    </section>
                </div>
            </section>

        </div>
    </main>

    <footer>
        <div class="topFooter">
            <div>
                <h3>AYUDA</h3>
                <ul>
                    <li><a href="#">Devoluciones</a></li>
                    <li><a href="#">Cambios</a></li>
                    <li><a href="#">Envios</a></li>
                    <li><a href="#">Opciones de pago</a></li>
                    <li><a href="#">ACERCA DE KIWO</a></li>
                </ul>
            </div>
            
            <div>
                <h3>CONTACTO</h3>
                <ul>
                    <li><a href="#"><i class='bx bxl-instagram-alt'></i>Instagram</a></li>
                    <li><a href="#"><i class='bx bxl-twitter' ></i>Twitter</a></li>
                    <li><a href="#"><i class='bx bxl-youtube' ></i>Youtube</a></li>
                    <li><a href="#"><i class='bx bxl-facebook-circle' ></i>Facebook</a></li>
                </ul>
            </div>
    
            <div>
                <h3>PRODUCTOS</h3>
                <ul>
                    <li><a href="#">Niños</a></li>
                    <li><a href="#">Niñas</a></li>
                    <li><a href="#">Calzado</a></li>
                    <li><a href="#">Deportivo</a></li>
                    <li><a href="#">vestir</a></li>
                    <li><a href="#">Juguetes</a></li>
                </ul>
            </div>
        </div>

        <div class="botFooter">
            <p>© 2024 Copyright. Todos los derechos reservados.</p>
            <a href="#">Terminos y condiciones</a>
        </div>
    </footer>

    <script src="../js/script.js"></script>
    <script src="../js/carouselProductos.js"></script>
    <script src="../js/headerTOP.js"></script>
    <script src="../js/menuMobile.js"></script>
    <script src="../js/loader.js"></script>

    <?php
    // Cerrar la conexión
    mysqli_close($conexion);
    ?>
</body>
</html>
