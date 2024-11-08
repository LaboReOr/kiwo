<?php
session_start();

if (isset($_POST['index']) && isset($_POST['quantity'])) {
    $index = intval($_POST['index']);
    $quantity = intval($_POST['quantity']);

    // Verificar que el índice sea válido
    if (isset($_SESSION['carrito'][$index])) {
        // Actualizar la cantidad solo si es mayor a 0
        if ($quantity > 0) {
            $_SESSION['carrito'][$index]['cantidad'] = $quantity;
        } else {
            // Si la cantidad es 0 o menor, se puede optar por eliminar el producto
            array_splice($_SESSION['carrito'], $index, 1);
        }
    }

    // Responder con éxito
    echo json_encode(['status' => 'success']);
}
?>
