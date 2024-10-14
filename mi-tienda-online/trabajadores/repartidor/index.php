<?php
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: ../../public/login.php");
}

// Incluir la conexión y las funciones
require_once '../../config/database.php';
require_once '../../config/oficina_db_functions.php';

// Obtener el DNI del repartidor desde la sesión
$dniRepartidor = $_SESSION["dni"];

// Obtener el ID del repartidor según su DNI
$stmt = $bd->prepare("SELECT id FROM Usuarios WHERE dni = ?");
$stmt->execute([$dniRepartidor]);
$repartidor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$repartidor) {
    echo "<p>Error: No se encontró al repartidor.</p>";
    exit;
}

$idRepartidor = $repartidor['id'];

// Recoger los filtros del formulario si están definidos
$idEntrega = isset($_GET['idEntrega']) ? $_GET['idEntrega'] : null;
$idPedido = isset($_GET['idPedido']) ? $_GET['idPedido'] : null;
$estado = isset($_GET['estado']) ? $_GET['estado'] : null;

// Obtener las entregas filtradas del repartidor
$entregas = searchEntregas($bd, $idEntrega, $idPedido, $idRepartidor, $estado);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Entregas del Repartidor - PAMBORGHINI</title>
    <link rel="stylesheet" href="../../assets/css/entregas.css">
    <script src="../../assets/js/imagenUser.js"></script>
</head>

<body>

    <header>
        <div class="logo">
            <img src="../../assets/images/logo3.png" alt="PAMBORGHINI">
        </div>
        <h1 class="main-title">Entregas del Repartidor</h1>
        <img id="user" src="../../assets/images/user.png" alt="User" onclick="confirmarCerrarSesion()" width="100px">
    </header>
    <main>
        <!-- Formulario de búsqueda -->
        <section class="search-form">
            <h2>Buscar Entregas</h2>
            <form method="GET" action="index.php">
                <label for="idEntrega">ID Entrega:</label>
                <input type="text" id="idEntrega" name="idEntrega" value="<?= htmlspecialchars($idEntrega ?? '') ?>">

                <label for="idPedido">ID Pedido:</label>
                <input type="text" id="idPedido" name="idPedido" value="<?= htmlspecialchars($idPedido ?? '') ?>">

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($estado ?? '') ?>">

                <button type="submit">Buscar</button>
            </form>
        </section>

        <section class="entregas-lista">
            <h2>Detalles de las Entregas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Entrega</th>
                        <th>ID Pedido</th>
                        <th>Estado</th>
                        <th>Fecha Estimada</th>
                        <th>Fecha Real</th>
                        <th>Dirección</th>
                        <th>Notas</th>
                        <th>Acción</th> <!-- Nueva columna para la acción -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($entregas)): ?>
                        <?php foreach ($entregas as $entrega): ?>
                            <tr>
                                <td><?= htmlspecialchars($entrega['id']) ?></td>
                                <td>
                                    <a href="detalles_entrega.php?idPedido=<?= htmlspecialchars($entrega['pedido']) ?>">
                                        <?= htmlspecialchars($entrega['pedido']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($entrega['estado'] ?? '') ?></td>
                                <td><?= htmlspecialchars($entrega['fecha_entrega_estimada'] ?? '') ?></td>
                                <td><?= htmlspecialchars($entrega['fecha_entrega_real'] ?? '') ?></td>
                                <td><?= htmlspecialchars($entrega['direccion_entrega'] ?? '') ?></td>
                                <td><?= htmlspecialchars($entrega['notas_entrega'] ?? '') ?></td>
                                <td>
                                    <!-- Botón para marcar como entregado -->
                                    <form action="entregar_pedido.php" method="POST">
                                        <input type="hidden" name="idEntrega" value="<?= htmlspecialchars($entrega['id']) ?>">
                                        <input type="hidden" name="idPedido" value="<?= htmlspecialchars($entrega['pedido']) ?>">
                                        <button type="submit" class="entregar-button">Entregar Pedido</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No se encontraron entregas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Pamborghini España © 2024. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
