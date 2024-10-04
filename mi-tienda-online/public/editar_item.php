<?php
session_start();
include("../config/database.php"); // Incluye tu conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_linea_pedido = $_POST['id_linea_pedido'];
    $nueva_cantidad = $_POST['cantidad'];

    try {
        // Obtener el precio unitario del producto en la línea de pedido
        $stmt = $bd->prepare("SELECT precio_unitario FROM Linea_Pedidos WHERE id = :id_linea_pedido");
        $stmt->bindParam(':id_linea_pedido', $id_linea_pedido);
        $stmt->execute();
        $linea = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($linea) {
            $precio_unitario = $linea['precio_unitario'];
            $nuevo_precio_total = $precio_unitario * $nueva_cantidad;

            // Actualizar la cantidad y el precio total en la línea de pedido
            $stmt_update = $bd->prepare("UPDATE Linea_Pedidos SET cantidad = :nueva_cantidad, precio_total = :nuevo_precio_total WHERE id = :id_linea_pedido");
            $stmt_update->bindParam(':nueva_cantidad', $nueva_cantidad);
            $stmt_update->bindParam(':nuevo_precio_total', $nuevo_precio_total);
            $stmt_update->bindParam(':id_linea_pedido', $id_linea_pedido);
            $stmt_update->execute();

            $_SESSION['message'] = "Cantidad y precio total actualizados con éxito.";
        } else {
            $_SESSION['message'] = "No se encontró la línea de pedido.";
        }

    } catch (Exception $e) {
        $_SESSION['message'] = "Error al actualizar la cantidad: " . $e->getMessage();
    }

    header("Location: carrito.php"); // Redirigir de vuelta al carrito
    exit;
}
