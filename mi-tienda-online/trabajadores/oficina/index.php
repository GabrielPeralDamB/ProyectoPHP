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
    <title>Panel de oficina - PAMBORGHINI</title>
    <link rel="stylesheet" href="../../assets/css/admin-styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Cargar jQuery -->
    <script src="../../assets/js/mostrardetallesproducto-admin.js"></script>
    <script src="../../assets/js/imagenUser.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../../assets/images/logo3.png" alt="PAMBORGHINI">
        </div>
        <h1 class="main-title">Panel de oficina - PAMBORGHINI</h1>
        <img id="user" src="../../assets/images/user.png" alt="User" onclick="confirmarCerrarSesion()" width="100px">

    </header>

    <main>
    <div class="admin-container">
    <!-- Zona izquierda: Lista de Repartidores -->
    <section class="admin-users">
        <div class="header-users">
            <h2>Repartidores</h2>
        </div>

        <ul id="repartidor-list">
            <?php if (!empty($repartidores)): ?>
                <?php foreach ($repartidores as $repartidor): ?>
                    <li>
                        <span><?= htmlspecialchars($repartidor['nombre'] . " " . $repartidor['apellidos'] . " (DNI: " . $repartidor['dni'] . ")") ?></span>
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
            <?php if (!empty($pedidos)): ?>
                <?php foreach ($pedidos as $pedido): ?>
                    <li>
                        <span>Pedido #<?= htmlspecialchars($pedido['id']) ?> | Fecha: <?= htmlspecialchars($pedido['fecha_pedido']) ?> | Estado: <?= htmlspecialchars($pedido['estado']) ?> | Precio: <?= htmlspecialchars($pedido['precio_total']) ?> €</span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No se encontraron pedidos</li>
            <?php endif; ?>
        </ul>
    </section>
</div>
    </main>

    <footer>
        <p>Pamborghini España © 2024. Todos los derechos reservados.</p>
    </footer>

    <script>
        $(document).ready(function() {
            $('.role-selector').change(function() {
                const form = $(this).closest('.role-update-form');
                const id = form.find('input[name="id"]').val();
                const tipo_usuario = $(this).val();

                $.post('', {
                    id: id,
                    tipo_usuario: tipo_usuario
                }, function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                }).fail(function() {
                    alert('Error en la comunicación con el servidor.');
                });
            });
        });
    </script>
</body>

</html>