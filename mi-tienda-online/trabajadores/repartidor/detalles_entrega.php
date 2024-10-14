<?php
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: ../../public/login.php");
}

require_once '../../config/database.php';
require_once '../../config/oficina_db_functions.php';

// Obtener el ID del pedido de la URL
$idPedido = isset($_GET['idPedido']) ? intval($_GET['idPedido']) : null;

// Obtener detalles del pedido
$detallesPedido = getDetallesPedido($bd, $idPedido);

if (!$detallesPedido) {
    die("No se encontraron detalles para este pedido.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido - PAMBORGHINI</title>
    <link rel="stylesheet" href="../../assets/css/detalles.css">
    
</head>
<body>
    <header>
        <div class="logo">
            <img src="../../assets/images/logo3.png" alt="PAMBORGHINI">
        </div>
        <h1 class="main-title">Detalles del Pedido</h1>
        <a href="index.php" class="btn-volver">Volver</a>
    </header>
    
    <main>
    <div class="detalles-pedido">
        <h2>Detalles del Pedido ID: <?= htmlspecialchars($detallesPedido['id_pedido']) ?></h2>
        <ul>
            <li><strong>Cliente:</strong> <?= htmlspecialchars($detallesPedido['nombre_cliente'] . ' ' . $detallesPedido['apellidos_cliente']) ?></li>
            <li><strong>Teléfono:</strong> <?= htmlspecialchars($detallesPedido['telefono_cliente']) ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($detallesPedido['email_cliente']) ?></li>
            <li><strong>Estado:</strong> <?= htmlspecialchars($detallesPedido['estado']) ?></li>
            <li><strong>Fecha de Pedido:</strong> <?= htmlspecialchars($detallesPedido['fecha_pedido']) ?></li>
            <li><strong>Fecha de Entrega Estimada:</strong> <?= htmlspecialchars($detallesPedido['fecha_entrega']) ?></li>
            <li><strong>Dirección de Entrega:</strong> <?= htmlspecialchars($detallesPedido['direccion_entrega']) ?></li>
            <li><strong>Detalles:</strong> <?= htmlspecialchars($detallesPedido['comentarios_cliente']) ?></li>
            <li><strong>Productos:</strong>
                <ul>
                    <?= $detallesPedido['detalles_productos'] ?>
                </ul>
            </li>
        </ul>
    </div>
</main>




    <footer>
        <p>Pamborghini España © 2024. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
