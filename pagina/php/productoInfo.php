<?php
session_start();

$variables = parse_ini_file('coneccionSQL.txt');

// Conexión a la base de datos
$servername = "127.0.0.1";
$database = "kiwo";
$username = $variables['usuario'];
$password = $variables['contraseña'];

$conexion = mysqli_connect($servername, $username, $password, $database);
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if (isset($_GET['idRopa'])) {
    $product_id = intval($_GET['idRopa']); // Obtener el ID del producto
    $tabla = "ropa";
    $idProd = "idRopa";
    $direccionIMG = "ropa";
    $hay_stock = "";
    $coma = "";
} else if (isset($_GET['idJuguete'])) {
    $product_id = intval($_GET['idJuguete']); // Obtener el ID del producto
    $tabla = "juguete";
    $idProd = "idJuguete";
    $direccionIMG = "juegos";
    $hay_stock = "stock";
    $coma = ",";
} else {
    die("Producto no encontrado.");
}

// Consulta para obtener los detalles del producto
$query = "SELECT $idProd, nombre, marca, precio, oferta, descripcion$coma $hay_stock FROM $tabla WHERE $idProd = $product_id"; // Cambiado a 'idRopa'
$resultado = mysqli_query($conexion, $query);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("Producto no encontrado.");
}

$row = mysqli_fetch_assoc($resultado);

if($tabla == "ropa"){
    // Consultar colores disponibles para esta prenda de ropa
    $colores_query = "SELECT distinct(colores.nombre), colores.idColor FROM colores JOIN ropa_stock_combinado ON idColor = color_idColor WHERE ropa_idropa = $product_id";
    $colores_resultado = mysqli_query($conexion, $colores_query);
    
    // Consultar talles disponibles para esta prenda de ropa
    $talles_query = "SELECT distinct(talles.nombre), talles.idTalle FROM talles JOIN ropa_stock_combinado ON idTalle = talle_idTalle WHERE ropa_idRopa = $product_id";
    $talles_resultado = mysqli_query($conexion, $talles_query);
    
    // Obtener stock para la primera combinación de color y talle
    $primera_color = mysqli_fetch_assoc($colores_resultado);
    $primera_talle = mysqli_fetch_assoc($talles_resultado);
    
    $primer_color_id = $primera_color['idColor'];
    $primer_talle_id = $primera_talle['idTalle'];
    
    // Consulta para obtener el stock de la primera combinación de color y talle
    $stock_query = "SELECT stock FROM ropa_stock_combinado 
                    WHERE ropa_idRopa = $product_id AND color_idColor = $primer_color_id AND talle_idTalle = $primer_talle_id";
    $stock_resultado = mysqli_query($conexion, $stock_query);
    $stock_row = mysqli_fetch_assoc($stock_resultado);
    $stock_inicial = $stock_row ? $stock_row['stock'] : 0;
}
    // Consulta de productos (en este caso juguetes)
    $query2 = "SELECT * FROM $tabla ORDER BY RAND() LIMIT 20";
    $resultado2 = mysqli_query($conexion, $query2);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($row['nombre']); ?></title>
    <link rel="shortcut icon" href="../img/iconos/KIcon.png" type="image/x-icon">
    
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    
    <link rel="stylesheet" href="../css/carousel.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/styleProducto.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
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
        <div class="pagina">
            <div class="recorrer">
                <div class="izqProd">
                    <div class="foto">
                        <div class="thumbnails">
                            <img class="thumbnail" src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/1.jpg " alt="Imagen 1">
                            <img class="thumbnail" src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/2.jpg " alt="Imagen 2">
                            <img class="thumbnail" src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/3.jpg " alt="Imagen 3">
                            <img class="thumbnail" src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/4.jpg " alt="Imagen 4">
                        </div>
                    </div>
                    <img class="prodIMG" id="main-image" src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/1.jpg" alt="main foto">
                </div>
            </div>

            <section class="datos">
                <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>

                <h4><?php echo htmlspecialchars($row['marca']); ?> - 
                    <i class='bx bxs-star sBlue'></i>
                    <i class='bx bxs-star sBlue'></i>
                    <i class='bx bxs-star sBlue'></i>
                    <i class='bx bxs-star sBlue'></i>
                    <i class='bx bxs-star'></i>
                </h4>
                <?php
                    if (isset($row["oferta"]) && htmlspecialchars($row["oferta"]) == '') {
                        echo '                <h2>$ ' . htmlspecialchars(number_format($row["precio"], 0, '', '.')) . '<span>00</span> </h2>';
                    } else {
                        $oferta = isset($row["oferta"]) ? htmlspecialchars($row["oferta"]) : 0; // Asignar 0 si es null

                        if($oferta > 0){
                            echo '                <h5 class="desc">$ ' . htmlspecialchars(number_format($row["precio"], 0, '', '.')) . ' </h5>';
                        }

                        echo '                <h2>$ ' . htmlspecialchars(number_format(htmlspecialchars($row["precio"]) * ((100 - $oferta) / 100), 0, '', '.')) . '<span>00</span> </h2>';
                        if($oferta > 0){
                            echo '                <p class="OFF_precio">' . $oferta . '% de descuento</p>'; // Aquí no es necesario volver a usar htmlspecialchars, ya que ya lo hemos hecho
                        }
                    }
                ?>
                <!-- <h5>$ 120.000</h5> -->
                <!-- <h2>$ <?php echo htmlspecialchars(number_format($row["precio"], 0, '', '.')); ?> <span>00</span></h2> -->

                <!-- <button class="cartButton"><i class='bx bxs-cart-add'></i></button> -->
                
                <!-- <div class="colores">
                    <h4>Color:</h4>
                    <img src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/1.jpg" alt="">
                    <img src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/2.jpg" alt="">
                    <img src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/3.jpg" alt="">
                    <img src="../img/<?php echo $direccionIMG ?>/<?php echo htmlspecialchars($row[$idProd]) ?>/4.jpg" alt="">
                </div> -->
                <form action="carrito.php" method="POST">
                    <input type="hidden" name="tipo" value="<?php echo $tabla; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>">
                    <input type="hidden" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>">
                    
                    <?php
                        if ($oferta !== null && $oferta > 0) {
                            $siNo = "si";
                        } else {
                            $siNo = "no";
                        }
                    ?>
                    <input type="hidden" name="siNo" value="<?php echo htmlspecialchars($siNo) ?>">
                    <input type="hidden" name="oferta" value="<?php echo htmlspecialchars($oferta) ?>">

                    <div class="colsTall">
                        <?php if($tabla == 'ropa') echo '<h4>Color:</h4>'?>
                        <?php if($tabla == 'ropa') echo '<select name="color" id="color" required>'?>
                            <?php 
                                if($tabla == 'ropa'){
                                    // Reiniciar el puntero del resultado para recorrer los colores
                                    mysqli_data_seek($colores_resultado, 0);
                                    while ($color_row = mysqli_fetch_assoc($colores_resultado)) {
                                        $selected = ($color_row['idColor'] == $primer_color_id) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($color_row['idColor']) . '" ' . $selected . '>' . htmlspecialchars($color_row['nombre']) . '</option>';
                                    }
                                }
                            ?>
                        <?php if($tabla == 'ropa') echo '</select>'?>
                    </div>

                    <div class="colsTall">
                        <?php if($tabla == 'ropa') echo '<h4>Talle:</h4>'?>
                        <?php if($tabla == 'ropa') echo '<select name="talle" id="talle" required>'?>
                            <?php 
                                if($tabla == 'ropa'){
                                    // Reiniciar el puntero del resultado para recorrer los talles
                                    mysqli_data_seek($talles_resultado, 0);
                                    while ($talle_row = mysqli_fetch_assoc($talles_resultado)) {
                                        $selected = ($talle_row['idTalle'] == $primer_talle_id) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($talle_row['idTalle']) . '" ' . $selected . '>' . htmlspecialchars($talle_row['nombre']) . '</option>';
                                    }
                                }
                            ?>
                        <?php if($tabla == 'ropa') echo '</select>'?>
                    </div>

                    <div class="cantidadDiv">
                        <?php
                            if($tabla == "ropa"){
                                // Asegúrate de pasar el stock inicial como un valor PHP para usarlo en JS
                                $stockMax = $stock_inicial;
                            } else {
                                $stockMax = htmlspecialchars($row['stock']);
                            }
                        ?>
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" min="1" max="<?php echo $stockMax ?>" required>
                        <span id="mensaje-error" style="color: red;"></span>
                        <?php
                            if($tabla == 'ropa'){
                                echo '<p id="stockDisponibles">Stock: ' . $stock_inicial . '</p>';
                            } else {
                                echo "<p>Stock: " . htmlspecialchars($row['stock']) . "</p>";
                            }
                        ?>
                    </div>

                    <button type="submit" class="buyNow">Añadir al carrito</button>
                </form>


                <script>
                    document.getElementById('color').addEventListener('change', actualizarStock);
                    document.getElementById('talle').addEventListener('change', actualizarStock);

                    function actualizarStock() {
                        const colorId = document.getElementById('color').value;
                        const talleId = document.getElementById('talle').value;

                        // Hacer la consulta AJAX para obtener el stock
                        fetch(`obtener_stock.php?color_id=${colorId}&talle_id=${talleId}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('stockDisponibles').innerText = data.stock || "0";
                            })
                            .catch(error => console.error('Error al obtener el stock:', error));
                    }
                </script>


                <div class="descripcion">
                    <h4>Descripción:</h4>
                    <?php
                        if(htmlspecialchars($row['descripcion']) == '') {
                            echo 'No hay descripcion!';
                        } else {
                            echo htmlspecialchars($row['descripcion']);
                        }
                    ?>
                    
                </div>
            </section>  
        </div>

        <div class="ofertas">
            <div class="ofertasBot">
                <section class="carouselImages-section">
                    <div class="carouselImages-container">
                        <div class="carouselImages">
                            <?php
                            while ($row = mysqli_fetch_assoc($resultado2)) {
                                $nombre_url = urlencode($row[$idProd]); // Codificar nombre para la URL
                                echo '<div class="carouselImages-item pointer">';
                                echo '    <div>';
                                echo '        <a href="productoInfo.php?'. $idProd .'=' . $nombre_url . '">';
                                // echo '            <img src="../img/'. $direccionIMG .'/' . htmlspecialchars($row["imagen"]) . '" alt="' . htmlspecialchars($row["nombre"]) . '">';
                                echo '            <img src="../img/'. $direccionIMG .'/' . htmlspecialchars($row[$idProd]) . '/1.jpg" alt="' . htmlspecialchars($row["nombre"]) . '">';
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
            </div>
        </div>

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

    <script src="../js/headerTOP.js"></script> 
    <script src="../js/productoImagen.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/carouselProductos.js"></script>
    <script src="../js/menuMobile.js"></script>
    <script>
        document.getElementById('color').addEventListener('change', actualizarStock);
        document.getElementById('talle').addEventListener('change', actualizarStock);
        document.getElementById('cantidad').addEventListener('change', actualizarStock);

        function actualizarStock() {
            const colorId = document.getElementById('color').value;
            const talleId = document.getElementById('talle').value;
            const productId = <?php echo $product_id; ?>; // Asegúrate de pasar el product_id desde PHP a JS

            // Hacer la consulta AJAX para obtener el stock
            fetch(`obtener_stock.php?color_id=${colorId}&talle_id=${talleId}&product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    // Actualizar el mensaje de stock disponible
                    const stockDisponible = data.stock || 0;
                    document.getElementById('stockDisponibles').innerText = `Stock: ${stockDisponible}`;

                    // Actualizar el atributo max del input para la cantidad
                    document.getElementById('cantidad').max = stockDisponible;

                    // Opcional: Actualizar el mensaje de error si la cantidad elegida es mayor que el stock disponible
                    const cantidadInput = document.getElementById('cantidad');
                    if (parseInt(cantidadInput.value) > stockDisponible) {
                        document.getElementById('mensaje-error').innerText = "Cantidad excede el stock disponible.";
                    } else {
                        document.getElementById('mensaje-error').innerText = "";
                    }
                })
                .catch(error => console.error('Error al obtener el stock:', error));
        }

        // Inicializa el stock al cargar la página si ya hay un valor seleccionado
        document.addEventListener("DOMContentLoaded", actualizarStock);
    </script>

</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>
