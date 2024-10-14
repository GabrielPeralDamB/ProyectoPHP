<?php
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: ../../public/login.php");
    exit();
}

// Incluir la conexión
require_once '../../config/database.php';

// Verificar si los datos necesarios han sido enviados
if (isset($_POST['idEntrega']) && isset($_POST['idPedido'])) {
    $idEntrega = $_POST['idEntrega'];
    $idPedido = $_POST['idPedido'];

    try {
        // Iniciar una transacción
        $bd->beginTransaction();

        // Actualizar el estado de la entrega y la fecha de entrega real
        $stmtEntrega = $bd->prepare("
            UPDATE Entregas
            SET estado = 'Entregado', fecha_entrega_real = NOW()
            WHERE id = ?
        ");
        $stmtEntrega->execute([$idEntrega]);

        // Actualizar el estado del pedido
        $stmtPedido = $bd->prepare("
            UPDATE Pedidos
            SET estado = 'Terminado'
            WHERE id = ?
        ");
        $stmtPedido->execute([$idPedido]);

        // Confirmar la transacción
        $bd->commit();

        // Redirigir a la página de entregas con un mensaje de éxito
        header("Location: index.php?success=1");
        exit();
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $bd->rollBack();
        echo "<p>Error al procesar la entrega: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>Error: Datos de entrega no válidos.</p>";
}
