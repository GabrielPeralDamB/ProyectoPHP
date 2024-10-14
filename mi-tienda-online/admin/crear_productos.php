<?php
require "../config/admin_db_functions.php";
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
    exit();
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Obtener los valores del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
    $stock = isset($_POST['stock']) ? $_POST['stock'] : null;
    $descuento = isset($_POST['descuento']) ? $_POST['descuento'] : null;
    $categoriaId = isset($_POST['categoria']) ? $_POST['categoria'] : null;

    // Validar si se ha cargado un archivo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener información del archivo
        $fileTmpPath = $_FILES['imagen']['tmp_name'];
        $fileName = $_FILES['imagen']['name'];
        $fileNameCmps = pathinfo($fileName);
        $fileExtension = strtolower($fileNameCmps['extension']);

        // Directorio de destino
        $uploadFileDir = '../assets/images/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension; // Generar un nombre único basado en la hora
        $destPath = $uploadFileDir . $newFileName;

        // Validar la extensión de archivo permitida
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Mover el archivo al directorio de destino
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Llamar a la función createProduct pasando el nombre del archivo
                if (createProduct($nombre, $marca, $size, $descripcion, $precio, $stock, $descuento, $newFileName, $categoriaId)) {
                    echo "Producto creado exitosamente.";
                } else {
                    echo "Error al crear el producto.";
                }
            } else {
                echo "Error al mover el archivo de imagen.";
            }
        } else {
            echo "Formato de archivo no permitido. Solo se permiten JPG, JPEG, PNG y GIF.";
        }
    } else {
        echo "Error al cargar la imagen.";
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

                <!-- Se ha agregado enctype para permitir la carga de archivos -->
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
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
                        <label for="imagen">Seleccionar Imagen</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*" required>
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
