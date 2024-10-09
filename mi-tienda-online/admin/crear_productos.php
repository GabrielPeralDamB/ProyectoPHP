<?php
require "../config/admin_db_functions.php";
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
}


// Manejo del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    // Comprobar si los datos del formulario están configurados
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
    $stock = isset($_POST['stock']) ? $_POST['stock'] : null;
    $descuento = isset($_POST['descuento']) ? $_POST['descuento'] : null;
    $url_imagen = isset($_POST['url_imagen']) ? $_POST['url_imagen'] : null;
    $categoriaId = isset($_POST['categoria']) ? $_POST['categoria'] : null;

    // Llamar a la función para crear el producto
    if (createProduct($nombre, $marca, $size, $descripcion, $precio, $stock, $descuento, $url_imagen, $categoriaId)) {
        echo "Producto creado exitosamente.";
    } else {
        echo "Error al crear el producto.";
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Crear Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylescrearproducto.css">

    <script>
        window.onload = function() {
            // Verificar si el tipo de navegación fue un "reload" (recarga)
            if (performance.getEntriesByType("navigation")[0].type === "reload") {
                // Si se detecta que la página fue recargada manualmente, redirigir usando GET
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>";
            }
        };
    </script>
</head>

<body>
    <header>
        <h1>Crear Producto</h1>
    </header>
    <a href="index.php" class="btn-volver">Volver</a>
    <main>
        <div class="create-product-main">
            <div class="create-product-container">
                <img id="logo" src="../assets/images/logo3.png">

                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">

                    <div class="group-div-inputs">
                        <div class="input-group">
                            <label for="nombre">Nombre del Producto</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" required>
                        </div>

                        <div class="input-group">
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" name="marca" placeholder="Marca del producto">
                        </div>
                    </div>

                    <div class="group-div-inputs">
                        <div class="input-group">
                            <label for="size">Tamaño/Size</label>
                            <input type="text" id="size" name="size" placeholder="Tamaño del producto">
                        </div>

                        <div class="input-group">
                            <label for="precio">Precio</label>
                            <input type="number" step="0.01" id="precio" name="precio" placeholder="Precio del producto" required>
                        </div>
                    </div>

                    <div class="group-div-inputs">
                        <div class="input-group">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" name="stock" placeholder="Cantidad en stock" required>
                        </div>

                        <div class="input-group">
                            <label for="descuento">Descuento (%)</label>
                            <input type="number" id="descuento" name="descuento" placeholder="Descuento (opcional)">
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" placeholder="Descripción del producto" rows="4" required></textarea>
                    </div>

                    <div class="input-group">
                        <label for="url_imagen">URL de Imagen</label>
                        <input type="text" id="url_imagen" name="url_imagen" placeholder="URL de la imagen del producto">
                    </div>

                    <div class="input-group">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Seleccionar Categoría</option>
                            <?php
                            // Obtener todas las categorías y mostrarlas en el select
                            $categorias = getAllCategories();
                            foreach ($categorias as $categoria) {
                                echo "<option value=\"{$categoria['id']}\">{$categoria['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="create-button">Crear Producto</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>