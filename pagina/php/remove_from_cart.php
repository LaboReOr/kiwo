<?php
session_start();

if (isset($_POST['index'])) {
    $index = intval($_POST['index']);

    // Verificar que el índice sea válido
    if (isset($_SESSION['carrito'][$index])) {
        // Eliminar el producto del carrito
        array_splice($_SESSION['carrito'], $index, 1);
    }

    // Responder con éxito
    echo json_encode(['status' => 'success']);
}
?>
