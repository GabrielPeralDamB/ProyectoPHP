<?php


session_start();

if (isset($_SESSION['message'])): ?>
    <div class="alert">
        <?= htmlspecialchars($_SESSION['message']); ?>
        <?php unset($_SESSION['message']); // Eliminar mensaje después de mostrarlo 
        ?>
    </div>
<?php endif;

include("../config/database.php"); // Incluye tu conexión a la base de datos

if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id'];

// Consulta para obtener los productos en el carrito
$sql = "SELECT lp.id, lp.cantidad, lp.precio_unitario, lp.precio_total, p.id AS id_producto, p.nombre 
        FROM Linea_Pedidos lp 
        JOIN Productos p ON lp.id_producto = p.id 
        WHERE lp.id_usuario = :id_usuario AND lp.id_pedido IS NULL";

$stmt = $bd->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$lineas_pedido = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular totales
$totalItemCount = 0;
$totalCost = 0;

foreach ($lineas_pedido as $item) {
    $totalItemCount += $item['cantidad'];
    $totalCost += $item['precio_unitario'] * $item['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Carrito de Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylescarrito.css">
    <script src=../assets/js/pagar.js></script>
</head>

<body>

    <header>
        <img src="../assets/images/logo3.png" alt="logo">
        <h1>Finalizar pedido</h1>
    </header>
    <a href="index.php" class="btn-volver">Volver</a>
    <main>
        <div class="cart-container">
            <div class="cart-items">
                <h2>Productos en el carrito</h2>
                <ul id="cart-items-list">
                    <?php foreach ($lineas_pedido as $item): ?>
                        <li>
                            <?= htmlspecialchars($item['nombre']) ?> (x<?= htmlspecialchars($item['cantidad']) ?>) - €<?= number_format($item['precio_unitario'] * $item['cantidad'], 2) ?>
                            <div>
                                <form id="editar" method="POST" action="editar_item.php" style="display:inline;">
                                    <input type="hidden" name="id_linea_pedido" value="<?= htmlspecialchars($item['id']) ?>">
                                    <input type="number" name="cantidad" value="<?= htmlspecialchars($item['cantidad']) ?>" min="1" required >
                                    <button type="submit" class="edit-button">Actualizar</button>
                                </form>
                                <form id="eliminar"method="POST" action="eliminar_item.php" style="display:inline;">
                                    <input type="hidden" name="id_linea_pedido" value="<?= htmlspecialchars($item['id']) ?>"> <!-- Cambiado a id -->
                                    <button type="submit" class="delete-button">Eliminar</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="cart-summary">
                <h2>Resumen</h2>
                <p>Total de productos: <span id="total-items"><?= $totalItemCount ?></span></p>
                <p>Precio Total (Sin Envio): <?= number_format($totalCost, 2) ?>€</p>
                <p>Costo envio: <?php include("../config/variables.php"); echo $costo_envio_permanente?>€</p>
                <p>Precio total: <span id="total-price">€<?= number_format($totalCost+$costo_envio_permanente, 2) ?></span></p>

                <h3>Datos de Entrega</h3>

                <form method="POST" action="pagar.php"> <!-- Cambia 'pagar.php' al nombre de tu archivo de pago -->
                    <div>
                        <label class="labeldatos" for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" required>

                        <label class="labeldatos" for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <label class="labeldatos" for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" required>

                        <label class="labeldatos" for="comentarios">Comentarios:</label>
                        <textarea id="comentarios" name="comentarios"></textarea>
                    </div>



                    <button type="submit" id="checkout-button">Aceptar y Pagar</button>
                </form>
                <br>
                <img src="../assets/images/metodospago.png" alt="Efectivo, Tarjeta, Bizum">
            </div>
        </div>
    </main>

</body>

</html>