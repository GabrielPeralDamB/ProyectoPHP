<?php
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
} 


include("../config/database.php"); // Incluye tu conexión a la base de datos

if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_linea_pedido'])) {
    $id_linea_pedido = $_POST['id_linea_pedido'];

    try {
        // Prepara la consulta para eliminar la línea de pedido
        $sql = "DELETE FROM Linea_Pedidos WHERE id = :id_linea_pedido"; // Cambiado a id
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_linea_pedido', $id_linea_pedido);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Redirigir de vuelta al carrito con un mensaje de éxito
            $_SESSION['message'] = "Producto eliminado del carrito correctamente.";
            $_SESSION['num_lineas_pedidos'] -=1;
        } else {
            $_SESSION['message'] = "Error al eliminar el producto.";
        }
    } catch (PDOException $e) {
        // Manejo de errores
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }
}

// Redirigir de vuelta al carrito
header("Location: carrito.php");
exit;
?>


