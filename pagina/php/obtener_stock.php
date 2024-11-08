<?php
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

// Obtener los parámetros de color, talle y product_id
$color_id = isset($_GET['color_id']) ? intval($_GET['color_id']) : 0;
$talle_id = isset($_GET['talle_id']) ? intval($_GET['talle_id']) : 0;
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($color_id && $talle_id && $product_id) {
    // Consulta para obtener el stock de la combinación de talle y color
    $query = "SELECT stock FROM ropa_stock_combinado 
              WHERE ropa_idRopa = ? AND color_idColor = ? AND talle_idTalle = ?";
    
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "iii", $product_id, $color_id, $talle_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $stock);
    mysqli_stmt_fetch($stmt);
    
    if ($stock !== null) {
        echo json_encode(['stock' => $stock]);
    } else {
        echo json_encode(['stock' => 0]); // Si no se encuentra el stock
    }

    mysqli_stmt_close($stmt);
} else {
    // Si no se pasan los parámetros necesarios
    echo json_encode(['stock' => 0]);
}

mysqli_close($conexion);
?>
