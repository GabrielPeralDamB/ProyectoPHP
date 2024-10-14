<?php
// Incluir conexión a la base de datos
require_once '../config/database.php';

// Obtener todos los productos para llenar el combo box
function getAllProducts() {
    global $bd;
    try {
        $stmt = $bd->prepare("SELECT id, nombre FROM Productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los productos: " . $e->getMessage();
    }
}

// Si se envía el formulario, actualizar los datos del producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_producto = $_POST['id_producto'];
    $fields = [];
    $values = [];

    // Agregar los campos que han sido enviados
    if (!empty($_POST['nombre'])) {
        $fields[] = "nombre = ?";
        $values[] = $_POST['nombre'];
    }
    if (!empty($_POST['marca'])) {
        $fields[] = "marca = ?";
        $values[] = $_POST['marca'];
    }
    if (!empty($_POST['size'])) {
        $fields[] = "size = ?";
        $values[] = $_POST['size'];
    }
    if (!empty($_POST['descripcion'])) {
        $fields[] = "descripcion = ?";
        $values[] = $_POST['descripcion'];
    }
    if (!empty($_POST['precio'])) {
        $fields[] = "precio = ?";
        $values[] = $_POST['precio'];
    }
    if (!empty($_POST['stock'])) {
        $fields[] = "stock = ?";
        $values[] = $_POST['stock'];
    }
    if (!empty($_POST['descuento'])) {
        $fields[] = "descuento = ?";
        $values[] = $_POST['descuento'];
    }
    if (!empty($_POST['url_imagen'])) {
        $fields[] = "url_imagen = ?";
        $values[] = $_POST['url_imagen'];
    }

    if (!empty($fields)) {
        // Construir la consulta SQL
        $sql = "UPDATE Productos SET " . implode(", ", $fields) . " WHERE id = ?";
        $values[] = $id_producto; // Agregar el id al final

        try {
            $stmt = $bd->prepare($sql);
            $stmt->execute($values);
            echo "Producto actualizado exitosamente";
        } catch (PDOException $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
        }
    } else {
        echo "No se han realizado cambios.";
    }
}

// Obtener la lista de productos
$productos = getAllProducts();
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../assets/css/styles_editar_producto.css">
</head>
<body>
    <header>
        <h1 class="main-title">Editar Producto</h1>
    </header>
    <a href="index.php" class="btn-volver">Volver</a>
    <main>
        <div class="admin-container">
            <div class="admin-products">
                <h2>Selecciona un Producto para Editar</h2>
                <form action="editar_productos.php" method="post">
                    <label for="producto">Producto:</label>
                    <select id="producto" name="id_producto">
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id']; ?>"><?= $producto['id'] . " - " . $producto['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Campos para editar -->
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" >

                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca">

                    <label for="size">Tamaño:</label>
                    <input type="text" id="size" name="size">

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion"></textarea>

                    <label for="precio">Precio:</label>
                    <input type="text" id="precio" name="precio" >

                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" >

                    <label for="descuento">Descuento:</label>
                    <input type="number" id="descuento" name="descuento">

                    <label for="url_imagen">URL de Imagen:</label>
                    <input type="text" id="url_imagen" name="url_imagen">

                    <button type="submit" class="create-product-button">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Editar Producto</p>
    </footer>
</body>
</html>
