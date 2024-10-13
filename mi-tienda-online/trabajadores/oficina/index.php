<?php

session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: ../../public/login.php");
} 


// Incluir la conexión y las funciones
require_once '../../config/database.php';
require_once '../../config/oficina_db_functions.php';

// Aquí ya tienes $bd definida en database.php, ahora la pasas a las funciones

// Obtener todos los repartidores
$repartidores = getUsersByType($bd, 'repartidor');

// Obtener todos los pedidos
$pedidos = getAllPedidos($bd);

// Puedes ahora trabajar con $repartidores y $pedidos
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Entrega - PAMBORGHINI</title>
    <link rel="stylesheet" href="../../assets/css/oficina-styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Cargar jQuery -->
    <script src="../../assets/js/imagenUser.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../../assets/images/logo3.png" alt="PAMBORGHINI">
        </div>
        <h1 class="main-title">Crear Entrega</h1>
        <img id="user" src="../../assets/images/user.png" alt="User" onclick="confirmarCerrarSesion()" width="100px">
        <a href="detalles_entregas.php" id="detalles-btn" class="details-button">Detalles Entregas</a>
    </header>

    <main>
    <div class="admin-container">
        <!-- Zona izquierda: Lista de Repartidores -->
        <section class="admin-users">
            <div class="header-users">
                <h2>Repartidores</h2>
            </div>

            <ul id="repartidor-list">
                <!-- Aquí van los repartidores -->
                <?php if (!empty($repartidores)): ?>
                    <?php foreach ($repartidores as $repartidor): ?>
                        <li>
                            <input type="radio" name="repartidor" value="<?= htmlspecialchars($repartidor['id']) ?>">
                            <span><?= htmlspecialchars($repartidor['nombre'] . " " . $repartidor['apellidos']) ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No se encontraron repartidores</li>
                <?php endif; ?>
            </ul>
        </section>

        <!-- Zona derecha: Lista de Pedidos -->
        <section class="admin-pedidos">
            <div class="header-pedidos">
                <h2>Pedidos</h2>
            </div>

            <ul id="pedido-list">
                <!-- Aquí van los pedidos -->
                <?php if (!empty($pedidos)): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <li>
                            <input type="radio" name="pedido" value="<?= htmlspecialchars($pedido['id']) ?>">
                            <span>Pedido #<?= htmlspecialchars($pedido['id']) ?> | Fecha: <?= htmlspecialchars($pedido['fecha_pedido']) ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No se encontraron pedidos</li>
                <?php endif; ?>
            </ul>
        </section>
    </div>

    <!-- Botón centrado -->
    <div class="button-container">
        <button id="crear-entrega-btn" class="create-delivery-button">Crear Entrega</button>
    </div>
</main>


    <footer>
        <p>Pamborghini España © 2024. Todos los derechos reservados.</p>
    </footer>

    <script>
        $(document).ready(function () {
    $('#crear-entrega-btn').click(function () {
        const repartidor = $('input[name="repartidor"]:checked').val();
        const pedido = $('input[name="pedido"]:checked').val();

        if (!repartidor || !pedido) {
            alert('Por favor selecciona un repartidor y un pedido.');
            return;
        }

        // Hacer la petición AJAX
        $.post('crear_entrega.php', {
            repartidor: repartidor,
            pedido: pedido
        }, function (response) {
            const data = JSON.parse(response);
            if (data.success) {
                alert(data.message);

                // Eliminar el pedido de la lista una vez que la entrega se haya creado
                $('input[name="pedido"][value="' + data.pedido + '"]').closest('li').remove();
            } else {
                alert(data.message);
            }
        }).fail(function () {
            alert('Error en la comunicación con el servidor.');
        });
    });
});

    </script>
</body>

</html>



