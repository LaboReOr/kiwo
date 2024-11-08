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

if (isset($_GET['seccion'])) {
    $seccion_id = intval($_GET['seccion']); // Obtener el ID del producto
} else {
    $seccion_id = 0;
}

if($seccion_id == 0) {
    $tabla = "ropa";
    $direccion = "ropa";
    $id_producto = "idRopa";
    $tituloPagina = "ROPA";
} else if($seccion_id == 1) {
    $tabla = "juguete";
    $direccion = "juegos";
    $id_producto = "idJuguete";
    $tituloPagina = "JUEGOS Y JUGUETES";
} else {
    die("Seccion invalida.");  
}


// Verificar si el usuario ha iniciado sesión
// if (!isset($_SESSION['usuario_id'])) {
//     header("Location: ../login.html");  // Redirigir al login si no ha iniciado sesión
//     exit;
// }

// Consulta para obtener marcas únicas
$marcas_query = "SELECT DISTINCT marca FROM $tabla";
$marcas_resultado = mysqli_query($conexion, $marcas_query);

if (!$marcas_resultado) {
    die("Error en la consulta de marcas: " . mysqli_error($conexion));
}

// Consulta para obtener marcas únicas
if($seccion_id == 0) {
    $material_query = "SELECT DISTINCT material FROM $tabla";
    $material_resultado = mysqli_query($conexion, $material_query);
    
    if (!$material_resultado) {
        die("Error en la consulta de materiales: " . mysqli_error($conexion));
    }
}


// Consulta para obtener los productos de la tabla 'ropa'
// Consulta para obtener los productos con ordenamiento y filtro de marca
if($tabla == "juguete"){
    $query = "SELECT $id_producto, nombre as rjNombre, marca, precio, oferta FROM $tabla WHERE 1=1";
} else {
    $query = "SELECT $id_producto, ropa.nombre as rjNombre, marca, precio, oferta, talles.nombre as talle, colores.nombre as color FROM $tabla 
    join ropa_stock_combinado on idRopa = ropa_stock_combinado.ropa_idRopa 
    join talles on idTalle = talle_idTalle 
    join colores on idColor = color_idColor 
    WHERE 1=1";
}

// Captura de marca
$marca_filtro = '';
if (isset($_GET['marca'])) {
    $marca_filtro = mysqli_real_escape_string($conexion, $_GET['marca']);
    if($marca_filtro != ''){
        $query .= " AND marca = '$marca_filtro'";
    }
}

$material_filtro = '';
if (isset($_GET['material'])) {
    $material_filtro = mysqli_real_escape_string($conexion, $_GET['material']);
    if($material_filtro != ''){
        $query .= " AND material = '$material_filtro'";
    }
}

$talle_filtro = '';
if (isset($_GET['talle'])) {
    $talle_filtro = mysqli_real_escape_string($conexion, $_GET['talle']);
    if($talle_filtro != ''){
        $query .= " AND talles.nombre = '$talle_filtro'";
    }
}

$color_filtro = '';
if (isset($_GET['color'])) {
    $color_filtro = mysqli_real_escape_string($conexion, $_GET['color']);
    if($color_filtro != ''){
        $query .= " AND colores.nombre = '$color_filtro'";
    }
}

$genero_filtro = '';
if (isset($_GET['genero'])) {
    $genero_filtro = mysqli_real_escape_string($conexion, $_GET['genero']);
    if($genero_filtro != ''){
        $query .= " AND genero = '$genero_filtro'";
    }
}

$OFF_filtro = '';
if (isset($_GET['OFF'])) {
    $OFF_filtro = mysqli_real_escape_string($conexion, $_GET['OFF']);
    if($OFF_filtro == 'OFF'){
        $query .= " AND oferta IS NOT NULL";
    }
}

// Evitar que se repita los productos
if($tabla == "ropa"){
    $query .= " GROUP BY idRopa, talles.nombre, colores.nombre";
}

// Captura de ordenamiento
$order = '';
$ordenamiento_max_min = '';
if (isset($_GET['ordenamiento'])) {
    switch ($_GET['ordenamiento']) {
        case 'mayor_precio':
            $order = 'ORDER BY precio DESC';
            $ordenamiento_max_min = 'mayor_precio';
            break;
        case 'menor_precio':
            $order = 'ORDER BY precio ASC';
            $ordenamiento_max_min = 'menor_precio';
            break;
        }
} else {
    $order = "ORDER BY RAND()";
}


// Agregar el ordenamiento
if ($order) {
    $query .= " $order"; // Añadir el ordenamiento
}

$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion)); // Para diagnosticar errores en la consulta
}


// Inicializar variable para almacenar la búsqueda
$query2 = '';
$juguetes = "";

// Verificar si hay una consulta de búsqueda
if (isset($_GET['query2'])) {
    $query2 = mysqli_real_escape_string($conexion, trim($_GET['query2']));
    
    // Consulta para buscar productos que contengan el término en el nombre
    $search_query2 = "SELECT idRopa, ropa.nombre as rjNombre, marca, precio, oferta, talles.nombre as talle, colores.nombre as color FROM ropa
    join ropa_stock_combinado on idRopa = ropa_stock_combinado.ropa_idRopa 
    join talles on idTalle = talle_idTalle 
    join colores on idColor = color_idColor 
    WHERE ropa.nombre LIKE '%$query2%'";
    $resultado = mysqli_query($conexion, $search_query2);

    $juguetes = "si";
    $search_query22 = "SELECT idJuguete, nombre as rjNombre, marca, precio, oferta FROM juguete WHERE juguete.nombre LIKE '%$query2%'";
    $resultado2 = mysqli_query($conexion, $search_query22);
    
    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}

/////////////////////////////

if($tabla == "juguete"){
    $query = "SELECT $id_producto, nombre as rjNombre, marca, precio, oferta FROM $tabla WHERE 1=1";
} else {
    $query = "SELECT $id_producto, ropa.nombre as rjNombre, marca, precio, oferta, talles.nombre as talle, colores.nombre as color FROM $tabla 
    join ropa_has_colores on idRopa = ropa_has_colores.ropa_idRopa 
    join ropa_has_talles on idRopa = ropa_has_talles.ropa_idRopa 
    join talles on idTalle = talles_idTalle 
    join colores on idColor = colores_idColor 
    WHERE 1=1";
}

/////////////////////////////

if($query2 != ''){
    $titulo = $query2;
} else {
    $titulo = $tituloPagina;
}

// Consulta para obtener talles disponibles en ropa
// $talles_resultado = mysqli_query($conexion, "SELECT DISTINCT nombre FROM talles JOIN ropa_has_talles ON idTalle = talles_idTalle WHERE stock > 0");
$talles_resultado = mysqli_query($conexion, "SELECT * from talles");

// Consulta para obtener colores disponibles en ropa
// $colores_resultado = mysqli_query($conexion, "SELECT DISTINCT nombre FROM colores JOIN ropa_has_colores ON idColor = colores_idColor WHERE stock > 0");
$colores_resultado = mysqli_query($conexion, "SELECT * from colores");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kiwo - <?php echo $titulo ?></title>
    <link rel="shortcut icon" href="../img/iconos/KIcon.png" type="image/x-icon">
    
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/styleProductos.css">
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

        <section class="pagina">

            <div class="topPagina">
                <h1><?php echo strtoupper($tituloPagina) ?></h1>
                <button id="filtrarYordenar"><p>FILTRAR Y ORDENAR</p> <i class='bx bx-slider'></i></button>
                
                <div class="filtrarYordenarDIV">
                    <div class="topFO">
                        <button id="crossFiltrarYordenar">
                            <i class='bx bx-x'></i>
                        </button>
                        <h2>FILTRAR Y ORDENAR</h2>
                    </div>
                    <hr>
                    <button onclick="eliminarFiltros()" class="borrarFiltros"><i class='bx bx-trash'></i> Borrar filtros</button>
                    <hr>
                    <div class="ordenarPor">
                        <h3>ORDENAR POR</h3>
                        <div class="ordDIV">
                            <div>   
                                <input id="opcion1" type="radio" name="ordenamiento" value="mayor_precio" onchange="aplicarFiltro(ordenamiento) " <?php if($ordenamiento_max_min == 'mayor_precio'){echo 'checked';} ?>/>
                                <label for="opcion1">MAYOR PRECIO</label>
                            </div>
                            <div>
                                <input id="opcion2" type="radio" name="ordenamiento" value="menor_precio" onchange="aplicarFiltro(ordenamiento)" <?php if($ordenamiento_max_min == 'menor_precio'){echo 'checked';} ?>/>
                                <label for="opcion2">MENOR PRECIO</label>
                            </div>
                            <div>
                                <input id="ofer" type="radio" name="off_prod" value="OFF" onchange="aplicarFiltro(OFF_filtro)" <?php if($OFF_filtro == 'OFF'){echo 'checked';} ?>/>
                                <label for="ofer">OFERTAS</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="ordenarPor">
                        <h3>MARCA</h3>
                        <div class="ordDIV">
                            <?php while ($marca_row = mysqli_fetch_assoc($marcas_resultado)): ?>
                                <div>
                                    <input id="marca_<?php echo htmlspecialchars($marca_row['marca']); ?>" type="radio" name="marca" value="<?php echo htmlspecialchars($marca_row['marca']); ?>" onchange="aplicarFiltro(marca)" <?php if($marca_filtro == htmlspecialchars($marca_row['marca'])){echo 'checked';} ?>/>
                                    <label for="marca_<?php echo htmlspecialchars($marca_row['marca']); ?>"><?php echo htmlspecialchars($marca_row['marca']); ?></label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php if ($seccion_id == 0): ?>
                    <hr>
                    <div class="ordenarPor">
                        <h3>TALLE</h3>
                        <div class="ordDIV">
                            <?php while ($talle_row = mysqli_fetch_assoc($talles_resultado)): ?>
                                <div>
                                    <input id="talle_<?php echo htmlspecialchars($talle_row['nombre']); ?>" type="radio" name="talle" value="<?php echo htmlspecialchars($talle_row['nombre']); ?>" onchange="aplicarFiltro(talle)" <?php if($talle_filtro == htmlspecialchars($talle_row['nombre'])){echo 'checked';} ?>/>
                                    <label for="talle_<?php echo htmlspecialchars($talle_row['nombre']); ?>"><?php echo htmlspecialchars($talle_row['nombre']); ?></label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="ordenarPor">
                        <h3>COLOR</h3>
                        <div class="ordDIV">
                            <?php while ($color_row = mysqli_fetch_assoc($colores_resultado)): ?>
                                <div>
                                    <input id="color_<?php echo htmlspecialchars($color_row['nombre']); ?>" type="radio" name="color" value="<?php echo htmlspecialchars($color_row['nombre']); ?>" onchange="aplicarFiltro(color)" <?php if($color_filtro == htmlspecialchars($color_row['nombre'])){echo 'checked';} ?>/>
                                    <label for="color_<?php echo htmlspecialchars($color_row['nombre']); ?>"><?php echo htmlspecialchars($color_row['nombre']); ?></label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <hr>    
                    <div class="ordenarPor">
                        <h3>GENERO</h3>
                        <div class="ordDIV">
                            <div>
                                <input id="genero_hombre" type="radio" name="genero" value="HOMBRE" onchange="aplicarFiltro(genero)" <?php if($genero_filtro == 'HOMBRE'){echo 'checked';} ?>/>
                                <label for="genero_hombre">HOMBRE</label>
                            </div>
                            <div>
                                <input id="genero_mujer" type="radio" name="genero" value="MUJER" onchange="aplicarFiltro(genero)" <?php if($genero_filtro == 'MUJER'){echo 'checked';} ?>/>
                                <label for="genero_mujer">MUJER</label>
                            </div>
                            <div>
                                <input id="genero_unisex" type="radio" name="genero" value="UNISEX" onchange="aplicarFiltro(genero)" <?php if($genero_filtro == 'UNISEX'){echo 'checked';} ?>/>
                                <label for="genero_unisex">UNISEX</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="ordenarPor">
                        <h3>MATERIAL</h3>
                        <div class="ordDIV">
                            <?php while ($material_row = mysqli_fetch_assoc($material_resultado)): ?>
                                <div>
                                    <input id="material_<?php echo htmlspecialchars($material_row['material']); ?>" type="radio" name="material" value="<?php echo htmlspecialchars($material_row['material']); ?>" onchange="aplicarFiltro(material)" <?php if($material_filtro == htmlspecialchars($material_row['material'])){echo 'checked';} ?>/>
                                    <label for="material_<?php echo htmlspecialchars($material_row['material']); ?>"><?php echo htmlspecialchars($material_row['material']); ?></label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <hr>
                </div>
            </div>
            <div class="grid">
                <?php
                    // Generar el HTML para los productos
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo '<div class="producto">';
                        echo '    <a href="productoInfo.php?'. $id_producto .'=' . htmlspecialchars($row[$id_producto]) . '">';
                        echo '        <div class="cont">';
                        echo '            <div class="imagen">';
                        // echo '                <img src="../img/'. $direccion .'/' . htmlspecialchars($row["imagen"]) . '" alt="producto">';
                        echo '                <img src="../img/'. $direccion .'/'. htmlspecialchars($row[$id_producto]) .'/1.jpg" alt="producto">';
                        echo '            </div>';
                        echo '            <div class="descripcion">';
                        echo '                <div>';
                        if($tabla == "ropa"){
                            echo '                    <h3>' . htmlspecialchars($row["rjNombre"]) . ' ' . htmlspecialchars($row["color"])  . ' ' . htmlspecialchars($row["talle"])  . '</h3>';
                        } else {
                            echo '                    <h3>' . htmlspecialchars($row["rjNombre"]) . '</h3>';
                        }
                        echo '                    <p>' . htmlspecialchars($row["marca"]) . '</p>';
                        echo '                </div>';
                        if (isset($row["oferta"]) && htmlspecialchars($row["oferta"]) == '') {
                            echo '                <h2>$ ' . htmlspecialchars(number_format($row["precio"], 0, '', '.')) . '</h2>';
                        } else {
                            // Asegúrate de que $row["oferta"] no sea null antes de usarlo
                            $oferta = isset($row["oferta"]) ? htmlspecialchars($row["oferta"]) : 0; // Asignar 0 si es null

                            if($oferta > 0){
                                echo '                <h2>$     <s>' . htmlspecialchars(number_format($row["precio"], 0, '', '.')) . '</s> ' . htmlspecialchars(number_format(htmlspecialchars($row["precio"]) * ((100 - $oferta) / 100), 0, '', '.')) . ' </h2>';
                                echo '                <p class="OFF_precio">' . $oferta . '% de descuento</p>'; // Aquí no es necesario volver a usar htmlspecialchars, ya que ya lo hemos hecho
                            } else {
                                echo '                <h2>$ ' . htmlspecialchars(number_format($row["precio"], 0, '', '.')) . '</h2>';
                            }
                        }                        
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </a>';
                        echo '</div>';
                    }

                    if($juguetes == "si"){
                        $id_producto = 'idJuguete';
                        $direccion = "juegos";
                        while ($row2 = mysqli_fetch_assoc($resultado2)) {
                            echo '<div class="producto">';
                            echo '    <a href="productoInfo.php?'. $id_producto .'=' . htmlspecialchars($row2[$id_producto]) . '">';
                            echo '        <div class="cont">';
                            echo '            <div class="imagen">';
                            // echo '                <img src="../img/'. $direccion .'/' . htmlspecialchars($row["imagen"]) . '" alt="producto">';
                            echo '                <img src="../img/'. $direccion .'/'. htmlspecialchars($row2[$id_producto]) .'/1.jpg" alt="producto">';
                            echo '            </div>';
                            echo '            <div class="descripcion">';
                            echo '                <div>';
                            echo '                    <h3>' . htmlspecialchars($row2["rjNombre"]) . '</h3>';
                            echo '                    <p>' . htmlspecialchars($row2["marca"]) . '</p>';
                            echo '                </div>';
                            if (isset($row2["oferta"]) && htmlspecialchars($row2["oferta"]) == '') {
                                echo '                <h2>$ ' . htmlspecialchars(number_format($row2["precio"], 0, '', '.')) . '</h2>';
                            } else {
                                // Asegúrate de que $row["oferta"] no sea null antes de usarlo
                                $oferta = isset($row2["oferta"]) ? htmlspecialchars($row2["oferta"]) : 0; // Asignar 0 si es null

                                if($oferta > 0){
                                    echo '                <h2>$     <s>' . htmlspecialchars(number_format($row2["precio"], 0, '', '.')) . '</s> ' . htmlspecialchars(number_format(htmlspecialchars($row["precio"]) * ((100 - $oferta) / 100), 0, '', '.')) . ' </h2>';
                                    echo '                <p class="OFF_precio">' . $oferta . '% de descuento</p>'; // Aquí no es necesario volver a usar htmlspecialchars, ya que ya lo hemos hecho
                                } else {
                                    echo '                <h2>$ ' . htmlspecialchars(number_format($row2["precio"], 0, '', '.')) . '</h2>';
                                }
                            }                        
                            echo '            </div>';
                            echo '        </div>';
                            echo '    </a>';
                            echo '</div>';
                        }
                    }
                    ?>
            </div>

            
        </section>

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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../js/headerTOP.js"></script>
    <script src="../js/menuMobile.js"></script>

    <script>
        function aplicarFiltro(tipo) {
            const seccion = <?php echo json_encode($seccion_id); ?>;
            const ordenamiento = document.querySelector('input[name="ordenamiento"]:checked')?.value || <?php echo json_encode($ordenamiento_max_min); ?>;
            const marca = document.querySelector('input[name="marca"]:checked')?.value || <?php echo json_encode($marca_filtro); ?>;
            const talle = document.querySelector('input[name="talle"]:checked')?.value || <?php echo json_encode($talle_filtro); ?>;
            const color = document.querySelector('input[name="color"]:checked')?.value || <?php echo json_encode($color_filtro); ?>;
            const genero = document.querySelector('input[name="genero"]:checked')?.value || <?php echo json_encode($genero_filtro); ?>;
            const material = document.querySelector('input[name="material"]:checked')?.value || <?php echo json_encode($material_filtro); ?>;
            const OFF = document.querySelector('input[name="off_prod"]:checked')?.value || <?php echo json_encode($OFF_filtro); ?>;

            const params = new URLSearchParams({ seccion, ordenamiento, OFF, marca, talle, color, genero, material });
            window.location.href = `?${params.toString()}`;

            console.log("asdas");
        }

        // Ordenamiento
        document.querySelectorAll('input[name="ordenamiento"]').forEach(input => {
            input.addEventListener('change', () => aplicarFiltro('ordenamiento'));
        });
        
        // OFF
        document.querySelectorAll('input[name="off_prod"]').forEach(input => {
            input.addEventListener('change', () => aplicarFiltro('off_prod'));
        });

        // Marca
        document.querySelectorAll('input[name="marca"]').forEach(input => {
            input.addEventListener('change', () => aplicarFiltro('marca'));
        });

        // Talle
        document.querySelectorAll('input[name="talle"]').forEach(input => {
            input.addEventListener('change', () => aplicarFiltro('talle'));
        });

        // Color
        document.querySelectorAll('input[name="color"]').forEach(input => {
            input.addEventListener('change', () => aplicarFiltro('color'));
        });

        // Género
        document.querySelectorAll('input[name="genero"]').forEach(input => {
            input.addEventListener('change', () => aplicarFiltro('genero'));
        });

        // Material
        document.querySelectorAll('input[name="material"]').forEach(input => {
            input.addEventListener('change', () => aplicarFiltro('material'));
        });

        function eliminarFiltros() {
            // Limpiar los inputs de filtro
            document.querySelectorAll('input[type="radio"]').forEach(input => {
                input.checked = false;
            });
            
            // Redirigir a la URL base sin parámetros
            const seccion = <?php echo json_encode($seccion_id); ?>;
            window.location.href = `?seccion=${seccion}`;
        }
    </script>

    
    <?php
    // Cerrar la conexión
    mysqli_close($conexion);
    ?>
    
</body>
</html>