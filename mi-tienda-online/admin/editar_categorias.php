<?php
// Incluir conexión a la base de datos
require_once '../config/database.php';

// Obtener todas las categorías para llenar el combo box
function getAllCategories() {
    global $bd;
    try {
        $stmt = $bd->prepare("SELECT id, nombre FROM Categorias");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener las categorías: " . $e->getMessage();
    }
}

// Si se envía el formulario para editar, actualizar los datos de la categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar_categoria'])) {
    $id_categoria = $_POST['id_categoria'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    try {
        $stmt = $bd->prepare("UPDATE Categorias SET nombre = ?, descripcion = ? WHERE id = ?");
        $stmt->execute([$nombre, $descripcion, $id_categoria]);
        echo "<p>Categoría actualizada exitosamente</p>";
    } catch (PDOException $e) {
        echo "<p>Error al actualizar la categoría: " . $e->getMessage() . "</p>";
    }
}

// Si se envía el formulario para eliminar la categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_categoria'])) {
    $id_categoria = $_POST['id_categoria_eliminar'];

    // Verificar si hay productos asociados a la categoría
    $stmt = $bd->prepare("SELECT COUNT(*) FROM CategoriasProductos WHERE id_categoria = ?");
    $stmt->execute([$id_categoria]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<p>No se puede eliminar la categoría porque existen productos asociados a ella.</p>";
    } else {
        // Si no hay productos asociados, proceder a eliminar la categoría
        $stmt = $bd->prepare("DELETE FROM Categorias WHERE id = ?");
        try {
            $stmt->execute([$id_categoria]);
            echo "<p>Categoría eliminada exitosamente.</p>";
        } catch (PDOException $e) {
            echo "<p>Error al eliminar la categoría: " . $e->getMessage() . "</p>";
        }
    }
}

// Obtener la lista de categorías
$categorias = getAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <link rel="stylesheet" href="../assets/css/styles_editar_categoria.css">
</head>
<body>
    <header>
        <h1 class="main-title">Editar Categoría</h1>
    </header>
    <a href="index.php" class="btn-volver">Volver</a>
    <main>
        <div class="admin-container">
            <div class="admin-categorias">
                <h2>Selecciona una Categoría para Editar</h2>
                <form action="editar_categorias.php" method="post">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="id_categoria">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id']; ?>"><?= $categoria['id'] . " - " . $categoria['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Campos para editar -->
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion"></textarea>

                    <button type="submit" name="editar_categoria" class="edit-category-button">Guardar Cambios</button>
                </form>

                <h2>Eliminar Categoría</h2>
                <form action="editar_categorias.php" method="post">
                    <label for="categoria_eliminar">Selecciona una Categoría para Eliminar:</label>
                    <select id="categoria_eliminar" name="id_categoria_eliminar">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id']; ?>"><?= $categoria['id'] . " - " . $categoria['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" name="eliminar_categoria" class="delete-category-button">Eliminar Categoría</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Editar Categoría</p>
    </footer>
</body>
</html>

