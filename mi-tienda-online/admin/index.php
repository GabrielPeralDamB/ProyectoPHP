<?php

session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: ../public/login.php");
} 
include '../config/admin_db_functions.php';

// Verificar si se ha realizado una búsqueda de usuarios
$searchTermUsers = isset($_GET['user-search']) ? $_GET['user-search'] : '';
$users = $searchTermUsers ? searchUsers($searchTermUsers) : getAllUsers();

// Verificar si se ha realizado una búsqueda de productos
$searchTermProducts = isset($_GET['product-search']) ? $_GET['product-search'] : '';
$products = $searchTermProducts ? searchProducts($searchTermProducts) : getAllProducts();

// Manejar la actualización de tipo de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['tipo_usuario'])) {
    $id = $_POST['id'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Llamar a la función para actualizar el tipo de usuario
    if (updateTipoUsuario($id, $tipo_usuario)) {
        // Devolver respuesta en JSON
        echo json_encode(['success' => true, 'message' => 'Rol actualizado correctamente']);
    } else {
        // Manejar el error
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el rol']);
    }
    exit; // Asegurarse de que no se ejecute más código después de enviar la respuesta
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración - PAMBORGHINI</title>
    <link rel="stylesheet" href="../assets/css/admin-styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Cargar jQuery -->
    <script src="../assets/js/mostrardetallesproducto-admin.js"></script>
    <script src="../assets/js/imagenUser.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/logo3.png" alt="PAMBORGHINI">
        </div>
        <h1 class="main-title">Panel de administración - PAMBORGHINI</h1>
        <img id="user" src="../assets/images/user.png" alt="User" onclick="confirmarCerrarSesion()" width="100px">

    </header>

    <main>
        <div class="admin-container">
            <!-- Zona izquierda: Lista de Usuarios -->
            <section class="admin-users">
                <div class="header-users">
                    <h2>Usuarios</h2>
                    <!-- Buscador de Usuarios -->
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" name="user-search" id="user-search" placeholder="Buscar usuario..." value="<?= htmlspecialchars($searchTermUsers) ?>">
                            <button type="submit" class="search-button">
                                <img src="../assets/images/lupa.png" alt="Buscar" class="search-icon">
                            </button>
                        </form>
                    </div>
                </div>

                <ul id="user-list">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <li>
                                <span><?= htmlspecialchars($user['nombre'] . " " . $user['apellidos'] . " (DNI: " . $user['dni'] . ")") ?></span>
                                <form method="POST" class="role-update-form" data-user-id="<?= $user['id'] ?>">
                                    <select name="tipo_usuario" class="role-selector">
                                        <option value="usuario" <?= $user['tipo_usuario'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                                        <option value="repartidor" <?= $user['tipo_usuario'] === 'repartidor' ? 'selected' : '' ?>>Repartidor</option>
                                        <option value="admin" <?= $user['tipo_usuario'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="oficina" <?= $user['tipo_usuario'] === 'oficina' ? 'selected' : '' ?>>Oficina</option>
                                    </select>
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                </form>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No se encontraron usuarios</li>
                    <?php endif; ?>
                </ul>
                <div class="product-footer">
                    <form action="editar_usuarios.php" method="get">
                        <button type="submit" class="create-product-button">Editar Usuario</button>
                    </form>
                    
                </div>
            </section>

            <!-- Zona derecha: Resumen de Productos -->
            <section class="admin-products">
                <div class="product-header">
                    <h2>Productos disponibles</h2>
                    <!-- Buscador de Productos -->
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" name="product-search" id="product-search" placeholder="Buscar producto..." value="<?= htmlspecialchars($searchTermProducts) ?>">
                            <button type="submit" class="search-button">
                                <img src="../assets/images/lupa.png" alt="Buscar" class="search-icon">
                            </button>
                        </form>
                    </div>
                </div>

                <ul id="product-list">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <li>
                                <span><?= htmlspecialchars($product['nombre'] . " | " . $product['marca'] . " | " . $product['precio'] . " € | Stock: " . $product['stock']) ?></span>
                                <button class="info-button" onclick="mostrarDetalles( <?php echo $product['id'] ?> )">
                                    <img src="../assets/images/info.png" alt="Información" class="info-icon">
                                </button>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No se encontraron productos</li>
                    <?php endif; ?>
                </ul>

                <div class="product-footer">
                    <form action="crear_productos.php" method="get">
                        <button type="submit" class="create-product-button">Crear producto</button>
                    </form>
                    <form action="editar_productos.php" method="get">
                        <button type="submit" class="create-product-button">Editar producto</button>
                    </form>
                    <form action="editar_categorias.php" method="get">
                        <button type="submit" class="create-category-button">Editar Categoria</button>
                    </form>
                    <form action="crear_categorias.php" method="get">
                        <button type="submit" class="create-category-button">Crear categoría</button>
                    </form>
                    
                </div>

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