<?php
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
} 
include '../config/db_functions.php';

// Verificar si el idProducto está presente en la URL
if (isset($_GET['idProducto'])) {
    $idProducto = htmlspecialchars($_GET['idProducto']);

    // Obtener los detalles del producto y las valoraciones
    $detalles = getDetallesProducto($idProducto);

    if ($detalles) {
        $producto = $detalles['producto'];
        $valoraciones = $detalles['valoraciones'];
        $promedioValoracion = $detalles['promedioValoracion'];

        // Procesar la nueva valoración si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (isset($_POST['valoracion']) && isset($_POST['descripcion']) && isset($_SESSION['id'])) {
                $valoracion = htmlspecialchars($_POST['valoracion']);
                $descripcion = htmlspecialchars($_POST['descripcion']);
                $id_usuario = htmlspecialchars($_SESSION['id']);

                // Insertar la nueva valoración en la base de datos
                if (insertarValoracion($idProducto, $id_usuario, $valoracion, $descripcion)) {
                    // Redirigir después de insertar la valoración para evitar duplicados en la inserción
                    header("Location: detalle_producto.php?idProducto=" . $idProducto);
                    exit();
                } else {
                    echo '<p>Error al insertar la valoración. Inténtalo de nuevo.</p>';
                }
            }
        }
    }
} else {
    echo "ID de producto no especificado.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/producto.css">
    <title>Detalle del Producto</title>
</head>

<body>
    <a href="index.php" class="btn-volver">Volver</a> 
    <main>
        <div class="producto-detalle">
            <div>
                <!-- Mostrar la imagen del producto -->
                <img src="../assets/images/<?php echo htmlspecialchars($producto['url_imagen']); ?>" alt="Producto" class="producto-imagen">
                <img id="logo" src="../assets/images/logo3.png">
            </div>

            <div class="producto-info">
                <!-- Mostrar los detalles del producto -->
                <h1 class="producto-nombre"><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <h2 class="producto-marca">Marca: <?php echo htmlspecialchars($producto['marca']); ?></h2>
                <h3 class="producto-categoria">
                    Categoría: <?php echo htmlspecialchars($producto['categorias']); ?>
                </h3> <!-- Ahora muestra las categorías -->
                <div class="producto-valoracion">
                    <?php
                    $estrellas = str_repeat('⭐', floor($promedioValoracion)) . str_repeat('☆', 5 - floor($promedioValoracion)); // Crea la representación de estrellas
                    echo $estrellas . " (" . $promedioValoracion . "/5)";
                    ?>
                </div>
                <h4 class="producto-tamano">Tamaño: <?php echo htmlspecialchars($producto['size']); ?></h4>
                <p class="producto-descripcion">Descripción del producto: <?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <p class="producto-precio">Precio: <?php echo htmlspecialchars($producto['precio']); ?> €</p>
                <button class="buy-button">Comprar Ahora</button>
            </div>
        </div>

        <div class="valoraciones-container">
            <!-- Mostrar las valoraciones del producto -->
            <div class="valoraciones">
                <h2>Valoraciones</h2>
                <?php if (count($valoraciones) > 0): ?>
                    <?php foreach ($valoraciones as $valoracion): ?>
                        <div class="valoracion">
                            <p><strong><?php echo htmlspecialchars($valoracion['nombre_usuario']); ?></strong>:
                                ⭐<?php echo htmlspecialchars($valoracion['num_valoracion']); ?>/5</p>
                            <p><?php echo htmlspecialchars($valoracion['descripcion']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aún no hay valoraciones para este producto.</p>
                <?php endif; ?>
            </div>

            <!-- Formulario para agregar una nueva valoración -->
            <div class="agregar-valoracion">
                <h3>Agregar una valoración</h3>
                <form action="" method="POST">
                    <input type="hidden" name="id_usuario" value="1"> <!-- Cambia esto por el usuario real de la sesión -->
                    <label for="valoracion">Valoración (1-5):</label>
                    <select name="valoracion" id="valoracion" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

                    <button type="submit">Enviar Valoración</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Pamborghini. Todos los derechos reservados.</p>
    </footer>
</body>

</html>