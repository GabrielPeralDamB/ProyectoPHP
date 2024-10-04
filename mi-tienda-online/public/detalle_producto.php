<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'tienda';
$user = 'root'; // Cambia esto si tienes otra configuración
$pass = ''; // Cambia la contraseña si es necesario

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Verificar si el idProducto está presente en la URL
if (isset($_GET['idProducto'])) {
    $idProducto = htmlspecialchars($_GET['idProducto']);

    // Obtener los detalles del producto
    $sqlProducto = "SELECT * FROM Productos WHERE id = :idProducto";
    $stmtProducto = $pdo->prepare($sqlProducto);
    $stmtProducto->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
    $stmtProducto->execute();
    $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el producto
    if ($producto) {
        // Obtener las valoraciones del producto
        $sqlValoraciones = "SELECT v.*, u.nombre AS nombre_usuario FROM Valoraciones v 
                            JOIN Usuarios u ON v.id_usuario = u.id
                            WHERE v.id_producto = :idProducto";
        $stmtValoraciones = $pdo->prepare($sqlValoraciones);
        $stmtValoraciones->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        $stmtValoraciones->execute();
        $valoraciones = $stmtValoraciones->fetchAll(PDO::FETCH_ASSOC);

        // Procesar la nueva valoración si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['valoracion']) && isset($_POST['descripcion']) && isset($_POST['id_usuario'])) {
                $valoracion = htmlspecialchars($_POST['valoracion']);
                $descripcion = htmlspecialchars($_POST['descripcion']);
                $id_usuario = htmlspecialchars($_POST['id_usuario']);

                // Insertar la nueva valoración en la base de datos
                $sqlInsertValoracion = "INSERT INTO Valoraciones (id_producto, id_usuario, descripcion, num_valoracion) 
                                        VALUES (:idProducto, :idUsuario, :descripcion, :valoracion)";
                $stmtInsert = $pdo->prepare($sqlInsertValoracion);
                $stmtInsert->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
                $stmtInsert->bindParam(':idUsuario', $id_usuario, PDO::PARAM_INT);
                $stmtInsert->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $stmtInsert->bindParam(':valoracion', $valoracion, PDO::PARAM_INT);
                $stmtInsert->execute();

                // Redirigir después de insertar la valoración para evitar duplicados en la inserción
                header("Location: detalle_producto.php?idProducto=" . $idProducto);
                exit();
            }
        }
    } else {
        echo "Producto no encontrado.";
        exit();
    }
} else {
    echo "No se recibió el ID del producto.";
    exit();
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
                <h3 class="producto-categoria">Categoría: Sin gas, destilada</h3> <!-- Puedes agregar una categoría real aquí -->
                <div class="producto-valoracion">⭐⭐⭐⭐☆ (4/5)</div> <!-- Puedes generar dinámicamente la valoración promedio -->
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
                    <!-- Suponiendo que el id_usuario viene de una sesión, puedes reemplazarlo por una validación real -->
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