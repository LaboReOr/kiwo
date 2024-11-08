<?php
session_start(); // Iniciar la sesión al inicio del archivo

// Verifica si el usuario ha iniciado sesión
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

$conexion = mysqli_connect($servername, $username, $password, $database);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para obtener la información del usuario
$idUsuario = $_SESSION['usuario_id'];
$query = "SELECT user, email, nacimiento FROM usuario WHERE idUsuario = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 'i', $idUsuario); // 'i' indica que el parámetro es un entero
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verificar si se obtuvo información del usuario
if ($fila = mysqli_fetch_assoc($result)) {
    $usuario = htmlspecialchars($fila['user']);
    $email = htmlspecialchars($fila['email']);
    $nacimiento = htmlspecialchars($fila['nacimiento']);
} else {
    // Si no se encuentra el usuario, se puede manejar el error
    echo "Error: Usuario no encontrado.";
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/iconos/KIcon.png" type="image/x-icon">
    
        <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <title>Kiwo</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/cuenta.css">
</head>
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
<body>
    <main>
    <div class="main">
            <section class="cuenta">
                <h1>CUENTA</h1>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <div class="info">
                        <p>USUARIO: <?php echo $usuario; ?></p>
                        <p>EMAIL: <?php echo $email; ?></p>
                        <p>FECHA DE NACIMIENTO: <?php echo $nacimiento; ?></p>
                    </div>
                    <a href="logout.php" class="logout">Cerrar sesión</a>
                    <?php 
                    if ($usuario == "admin"){
                        echo '<a href="admin.php" class="administracion">Administracion</a>';
                    }
                    ?>
                <?php else: ?>
                    <!-- Esta demas, pero lo dejo por las dudas -->
                    <p>No has iniciado sesión. <a href="../login.html" class="logout">Iniciar sesión</a></p>
                <?php endif; ?>
            </section>
        </div>
    </main>
    <script type="module" src="../js/headerTOP.js"></script>
    <script type="module" src="../js/menuMobile.js"></script>
</body>
</html>