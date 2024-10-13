<?php
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: ../../public/login.php");
}

// Incluir la conexión y las funciones
require_once '../../config/database.php';
require_once '../../config/oficina_db_functions.php';

// Recoger los filtros del formulario si están definidos
$idEntrega = isset($_GET['idEntrega']) ? $_GET['idEntrega'] : null;
$idPedido = isset($_GET['idPedido']) ? $_GET['idPedido'] : null;
$idRepartidor = isset($_GET['idRepartidor']) ? $_GET['idRepartidor'] : null;
$estado = isset($_GET['estado']) ? $_GET['estado'] : null;

// Obtener las entregas filtradas
$entregas = searchEntregas($bd, $idEntrega, $idPedido, $idRepartidor, $estado);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Entregas - PAMBORGHINI</title>
    <link rel="stylesheet" href="../../assets/css/entregas.css">
</head>

<body>

    <header>
        <div class="logo">
            <img src="../../assets/images/logo3.png" alt="PAMBORGHINI">
        </div>
        <h1 class="main-title">Lista de Entregas</h1>
    </header>
    <a href="index.php" class="btn-volver">Volver</a>
    <main>
        <!-- Formulario de búsqueda -->
        <section class="search-form">
            <h2>Buscar Entregas</h2>
            <form method="GET" action="detalles_entregas.php">
                <label for="idEntrega">ID Entrega:</label>
                <input type="text" id="idEntrega" name="idEntrega" value="<?= htmlspecialchars($idEntrega) ?>">

                <label for="idPedido">ID Pedido:</label>
                <input type="text" id="idPedido" name="idPedido" value="<?= htmlspecialchars($idPedido) ?>">

                <label for="idRepartidor">ID Repartidor:</label>
                <input type="text" id="idRepartidor" name="idRepartidor" value="<?= htmlspecialchars($idRepartidor) ?>">

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($estado) ?>">

                <button type="submit">Buscar</button>
            </form>
        </section>

        <section class="entregas-lista">
            <h2>Detalles de las Entregas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Entrega</th>
                        <th>Repartidor</th>
                        <th>Pedido</th>
                        <th>Estado</th>
                        <th>Fecha Estimada</th>
                        <th>Fecha Real</th>
                        <th>Dirección</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($entregas)): ?>
                        <?php foreach ($entregas as $entrega): ?>
                            <tr>
                                <td><?= htmlspecialchars($entrega['id']) ?></td>
                                <td><?= htmlspecialchars($entrega['repartidor']) ?></td>
                                <td>
                                    <a href="detalles_pedido_oficina.php?idPedido=<?= htmlspecialchars($entrega['pedido']) ?>">
                                        <?= htmlspecialchars($entrega['pedido']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($entrega['estado']) ?></td>
                                <td><?= htmlspecialchars($entrega['fecha_entrega_estimada']) ?></td>
                                <td><?= htmlspecialchars($entrega['fecha_entrega_real']) ?></td>
                                <td><?= htmlspecialchars($entrega['direccion_entrega']) ?></td>
                                <td><?= htmlspecialchars($entrega['notas_entrega']) ?></td>
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