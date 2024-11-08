<?php
	$usuario= $_POST["usuario"];
	$email = $_POST["email"];
	$clave = $_POST["clave"];
	$nacimiento = $_POST["edad"];

    $variables = parse_ini_file('coneccionSQL.txt');

    // Conexión a la base de datos
    $servername = "127.0.0.1";
    $database = "kiwo";
    $username = $variables['usuario'];
    $password = $variables['contraseña'];
    
    $conexion = mysqli_connect($servername, $username, $password, $database); // se crea la conexion
 
    if (!$conexion) {
        die("Conexion fallida: " . mysqli_connect_error());
    }
    else{
    // Verificar si el correo ya existe
    $query_check = "select * from usuario where email = '$email'";
    $resultado_check = mysqli_query($conexion, $query_check);
    
    $query2_check = "select * from usuario where user = '$usuario'";
    $resultado2_check = mysqli_query($conexion, $query2_check);
 
    $registrado = '';
    if (mysqli_num_rows($resultado_check) > 0) {
        // echo "El correo electrónico ya está registrado";
        $registrado = 'correo';
    } elseif (mysqli_num_rows($resultado2_check) > 0) {
        // echo "El usuario ya está registrado";
        $registrado = 'usuario';
    } else {
        // Insertar el resultado del formulario si no hay duplicados
        $query_insert = "insert into usuario values (NULL, '$usuario', '$email', '$clave', '$nacimiento')";
        $resultado_insert = mysqli_query($conexion, $query_insert);
 
        if ($resultado_insert) {
            header("Location: index.php");
 
        } else {
            echo "Error al registrar: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/iconos/KIcon.png" type="image/x-icon">
    
        <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <title>Kiwo</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/login.css">
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
            <section class="login">
                <h1>REGISTRARSE</h1>
                <form action="" method="post">
                    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required/>
                    <input type="text" id="email" name="email" placeholder="Email" required/>
                    <input type="password" id="clave" name="clave" placeholder="Contraseña" required/>
                    <input type="date" id="edad" name="edad" placeholder="nacimiento" required/>
                    <?php if($registrado == 'usuario') echo '<p>Usuario ya registrado, intente con otro!</p>' ?>
                    <?php if($registrado == 'correo') echo '<p>Correo ya registrado, intente con otro!</p>' ?>
                    <button type="submit">Enviar</button>
                </form>
                <p>No tenes cuenta? <a href="../login.html">iniciar sesion</a></p>
            </section>
        </div>
    </main>
    <script type="module" src="../js/headerTOP.js"></script>
    <script type="module" src="../js/menuMobile.js"></script>
</body>
</html>

<?php 
    mysqli_close($conexion);
?>