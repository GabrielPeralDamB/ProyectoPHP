<?php
require "../config/admin_db_functions.php";
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
}

// Manejo del formulario para crear una categoría
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Comprobar si los datos del formulario están configurados
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;

    // Llamar a la función para crear la categoría
    if (createCategory($nombre, $descripcion)) {
        echo "Categoría creada exitosamente.";
    } else {
        echo "Error al crear la categoría.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Crear Categoría</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylescrearcategorias.css">

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
        <h1>Crear Categoría</h1>
    </header>
    <a href="index.php" class="btn-volver">Volver</a>
    <main>
        <div class="create-category-main">
            <div class="create-category-container">
                <img id="logo" src="../assets/images/logo3.png">

                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">

                    <div class="input-group">
                        <label for="nombre">Nombre de la Categoría</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre de la categoría" required>
                    </div>

                    <div class="input-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" placeholder="Descripción de la categoría" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="create-button">Crear Categoría</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
