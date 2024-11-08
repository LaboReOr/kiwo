<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html"); // Redirigir si no está autenticado
    exit;
}

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo = $_POST['tipo'];
    $product_id = $_POST['product_id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $siNo = $_POST['siNo'];
    if($siNo == "si"){
        $oferta = $_POST['oferta'];
    } else {
        $oferta = 0;
    }
    if($tipo == "ropa"){
        $color = $_POST['color'];
        $talle = $_POST['talle'];
    }
    $cantidad = $_POST['cantidad'];

    if(empty($oferta)){
        $oferta = 0;
    }

    // Consultar el stock disponible según el tipo de producto
    if ($tipo == "ropa") {
        $stock_query = "SELECT stock FROM ropa_stock_combinado 
                        WHERE ropa_idRopa = ? AND color_idColor = ? AND talle_idTalle = ?";
        $stmt = mysqli_prepare($conexion, $stock_query);
        mysqli_stmt_bind_param($stmt, "iis", $product_id, $color, $talle);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stock);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        // Para juguetes, obtener stock sin filtros adicionales
        $stock_query = "SELECT stock FROM juguete WHERE idJuguete = ?";
        $stmt = mysqli_prepare($conexion, $stock_query);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stock);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // Limitar la cantidad si supera el stock disponible
    if ($cantidad > $stock) {
        $cantidad = $stock; // Si la cantidad supera el stock, usar el stock como cantidad máxima
    }

    // Crear el item del carrito
    if ($tipo == "ropa") {
        $producto = [
            'tipo' => $tipo,
            'id' => $product_id,
            'nombre' => $nombre,
            'precio' => $precio * ((100 - $oferta) / 100),
            'oferta' => $oferta,
            'color' => $color,
            'talle' => $talle,
            'cantidad' => $cantidad,
            'direccionIMG' => "ropa"
        ];
    } else {
        $producto = [
            'tipo' => $tipo,
            'id' => $product_id,
            'nombre' => $nombre,
            'precio' => $precio * ((100 - $oferta) / 100),
            'oferta' => $oferta,
            'cantidad' => $cantidad,
            'direccionIMG' => "juegos"
        ];
    }

    // Comprobar si ya existe el producto en el carrito
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $productoExistente = false;

    // Comprobar si el producto ya está en el carrito
    foreach ($_SESSION['carrito'] as &$item) {
        // Si el producto es ropa, comprobamos por id, color y talle
        if ($tipo == "ropa" && $item['id'] == $product_id && $item['color'] == $color && $item['talle'] == $talle) {
            $nuevaCantidad = $item['cantidad'] + $cantidad;
            // Aseguramos que no se supere el stock
            if ($nuevaCantidad > $stock) {
                $item['cantidad'] = $stock;
            } else {
                $item['cantidad'] = $nuevaCantidad;
            }
            $productoExistente = true;
            break;
        }
        // Si el producto no es ropa, solo comprobamos por id
        if ($tipo != "ropa" && $item['id'] == $product_id) {
            $nuevaCantidad = $item['cantidad'] + $cantidad;
            // Aseguramos que no se supere el stock
            if ($nuevaCantidad > $stock) {
                $item['cantidad'] = $stock;
            } else {
                $item['cantidad'] = $nuevaCantidad;
            }
            $productoExistente = true;
            break;
        }
    }

    // Si el producto no existe en el carrito, lo agregamos
    if (!$productoExistente) {
        $_SESSION['carrito'][] = $producto;
    }

    // Redirigir después de agregar el producto
    header("Location: productosListado.php");
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrito</title>
    <link rel="shortcut icon" href="../img/iconos/KIcon.png" type="image/x-icon">
    
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/carrito.css">
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
        <div class="main">
            <section class="mainProds">
                <div class="carritoProds">
                    <div class="productosTitulos">
                        <p></p>
                        <p>Producto</p>
                        <p></p>
                        <p></p>
                        <p></p>
                        <p></p>
                        <p>Precio</p>
                        <p>Cantidad</p>
                        <p>Subtotal</p>
                        <p></p>
                        <p></p>
                    </div>
                    <section class="elementosCarrito">
                        <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0): ?>
                            <?php foreach ($_SESSION['carrito'] as $index => $producto): ?>
                                <div class="productos">
                                    <img src="../img/<?php echo $producto['direccionIMG'] ?>/<?php echo $producto['id'] ?>/1.jpg " alt=""> <!-- Cambia la imagen según el producto -->
                                    <?php
                                        if($producto['tipo'] == "ropa"){
                                            $colorcito = "SELECT * from colores where idColor = " . $producto['color'];
                                            $colorcito_resultado = mysqli_query($conexion, $colorcito);
                                            $colorcito_row = mysqli_fetch_assoc($colorcito_resultado);

                                            $tallecito = "SELECT * from talles where idTalle = " . $producto['talle'];
                                            $tallecito_resultado = mysqli_query($conexion, $tallecito);
                                            $tallecito_row = mysqli_fetch_assoc($tallecito_resultado);
                                        }
                                    ?>
                                    <h2 class="hideOff"><?php echo htmlspecialchars($producto['nombre']); ?> <?php if(htmlspecialchars($producto['tipo']) == "ropa") echo htmlspecialchars($colorcito_row['nombre']); ?> <?php if(htmlspecialchars($producto['tipo']) == "ropa") echo htmlspecialchars($tallecito_row['nombre']); ?></h2>
                                    
                                    <div class="precio hideOff">
                                        <h3>$<?php echo number_format($producto['precio'], 2); ?></h3>
                                        <?php if ($producto['oferta'] > 0): ?>
                                            <p><s>$<?php echo number_format($producto['precio'] / ((100 - $producto['oferta']) / 100), 2); ?></s></p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Cantidad editable -->
                                    <div class="quantity">
                                        <h2 class="hideOn"><?php echo htmlspecialchars($producto['nombre'])?></h2>
                                        <div class="cantidad">
                                            <button class="btn-cant" onclick="updateQuantity(<?php echo $index; ?>, -1)">-</button>
                                            <input type="number" value="<?php echo htmlspecialchars($producto['cantidad']); ?>" id="cantidad-<?php echo $index; ?>" min="1" readonly>
                                            <button class="btn-cant" onclick="updateQuantity(<?php echo $index; ?>, 1)">+</button>
                                        </div>

                                    </div>
                                    
                                    <h3 class="hideBuy">$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></h3>
                                    <button class="hideBuy" onclick="removeFromCart(<?php echo $index; ?>)"><i class='bx bx-trash hideBuy'></i></button>
                                    
                                    <div class="mobileBuy">
                                        <h3>$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></h3>
                                        <button onclick="removeFromCart(<?php echo $index; ?>)"><i class='bx bx-trash'></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay productos en el carrito.</p>
                        <?php endif; ?>
                    </section>

                    <script>
                        function removeFromCart(index) {
                            const xhr = new XMLHttpRequest();
                            xhr.open("POST", "remove_from_cart.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    // Recargar la página para reflejar los cambios
                                    location.reload();
                                }
                            };
                            xhr.send(`index=${index}`);
                        }
                        
                        function updateQuantity(index, change) {
                            const input = document.getElementById(`cantidad-${index}`);
                            let quantity = parseInt(input.value);
                            quantity += change;

                            let stockRopa = 0;
                            let stockJuguete = 0;

                            <?php
                                if ($producto['tipo'] == "ropa") {
                                    $stock_query = "SELECT * from ropa 
                                    join ropa_stock_combinado on idRopa = ropa_stock_combinado.ropa_idRopa 
                                    join talles on idTalle = talle_idTalle 
                                    join colores on idColor = color_idColor 
                                    where talles.idTalle = '" . $producto['talle'] . "' and colores.idColor = '" . $producto['color'] . "'";
                                    $stock_resultado = mysqli_query($conexion, $stock_query);
                                    $stock_row = mysqli_fetch_assoc($stock_resultado);
                                    echo "stockRopa = " . $stock_row['stock'] . ";";
                                } elseif ($producto['tipo'] == "juguete") {
                                    $stock_query = "SELECT * from juguete";
                                    $stock_resultado = mysqli_query($conexion, $stock_query);
                                    $stock_row = mysqli_fetch_assoc($stock_resultado);
                                    echo "stockJuguete = " . $stock_row['stock'] . ";";
                                }
                            ?>

                            const tipo = <?php echo json_encode($producto['tipo']); ?>;

                            if(tipo == "ropa") {
                                if(quantity <= stockRopa){
                                    input.value = quantity;
                                }
                            } else if(tipo == "juguete") {
                                if(quantity <= stockJuguete) {
                                    input.value = quantity;
                                }
                            }

                            // Verificar que la cantidad nunca sea menor a 1
                            if (input.value < 1) {
                                input.value = 1;
                            }

                            // Enviar AJAX para actualizar el carrito
                            const xhrUpdate = new XMLHttpRequest();
                            xhrUpdate.open("POST", "update_cart.php", true);
                            xhrUpdate.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhrUpdate.onreadystatechange = function () {
                                if (xhrUpdate.readyState == 4 && xhrUpdate.status == 200) {
                                    // Recargar la página para reflejar los cambios
                                    location.reload();
                                }
                            };
                            xhrUpdate.send(`index=${index}&quantity=${input.value}`);
                        }

                    </script>

                </div>
                <div class="carritoInfo">
                    <h1 class="tituloInfo">RESUMEN COMPRA</h1>
                    <hr>
                    <div class="cupon">
                        <h2>Cupon</h2>
                        <form action="">
                            <input type="text">
                            <button>AGREGAR</button>
                        </form>
                    </div>
                    <hr>
                    <div class="precio">
                        <div class="categorias">
                            <h4>Subtotal</h4>
                            <?php
                            $subtotal = 0;
                            $descuentos = 0;

                            if (isset($_SESSION['carrito'])) {
                                foreach ($_SESSION['carrito'] as $producto) {
                                    $subtotal += $producto['precio'] * $producto['cantidad'];
                                    if ($producto['oferta'] > 0) {
                                        $descuentos += ($producto['precio'] / ((100 - $producto['oferta']) / 100) - $producto['precio']) * $producto['cantidad'];
                                    }
                                }
                            }
                            ?>
                            <p class="subtotal">$<?php echo number_format($subtotal, 2); ?></p>
                        </div>
                        <div class="categorias">
                            <h4>Descuentos</h4>
                            <p class="descuentos">-$<?php echo number_format($descuentos, 2); ?></p>
                        </div>
                        <div class="categorias">
                            <h4>Envío:</h4>
                            <?php
                            $envio = $subtotal >= 50000 ? 0 : 5000; // Ejemplo de costo de envío si no supera $50.000
                            ?>
                            <p class="envio"><?php echo $envio == 0 ? "GRATIS" : "$" . number_format($envio, 2); ?></p>
                        </div>
                        <div class="total">
                            <h4>Total</h4>
                            <p>$<?php echo number_format($subtotal - $descuentos + $envio, 2); ?></p>
                        </div>
                    </div>

                    <button class='comprar'>COMPRAR</button>
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

    <script src="../js/headerTOP.js"></script> 
    <script src="../js/productoImagen.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/carouselProductos.js"></script>
    <script src="../js/menuMobile.js"></script>
</body>
</html>


<?php
// Cerrar la conexión
mysqli_close($conexion);
?>