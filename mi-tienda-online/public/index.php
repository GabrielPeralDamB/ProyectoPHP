<?php

session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
} 
// Comprobar si la petición es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filter = false;

    // Recoger los valores del formulario y aplicar filtros si existen
    $filtroNombre = isset($_POST["search-name"]) ? $_POST["search-name"] : "";
    $filtroMarca = isset($_POST["search-brand"]) ? $_POST["search-brand"] : "";
    $filtroSize = isset($_POST["search-size"]) ? $_POST["search-size"] : "";
    $filtroMinPrice = isset($_POST["min-price"]) ? $_POST["min-price"] : "";
    $filtroMaxPrice = isset($_POST["max-price"]) ? $_POST["max-price"] : "";

    // Establecer si se aplican filtros
    if (!empty($filtroNombre) || !empty($filtroMarca) || !empty($filtroSize) || !empty($filtroMinPrice) || !empty($filtroMaxPrice)) {
        $filter = true;
    }

    // Si no hay filtros, redirigir al índice
    if ($filter == false) {
        header("Location: index.php");
        exit;
    }
} else {
    $filter = false;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAMBORGHINI</title>
    <link rel="stylesheet" href="..\assets\css\styles.css">
    <script src="../assets/js/scripts.js"></script>

    <!-- Codigo para refrescar la página con js, ya que detecta el refrescar!-->
    <script>
        // Almacenar si el estado del refresco es manual (debe cambiar el POST a GET)
        let refrescado = performance.navigation.type === performance.navigation.TYPE_RELOAD;

        window.onload = function() {
            // Si el usuario ha refrescado manualmente y estamos en POST, recargar con GET
            if (refrescado && window.location.href.includes("<?php echo $_SERVER["PHP_SELF"]; ?>")) {
                // Recargar la página usando GET para eliminar el POST
                window.location.href = "<?php echo $_SERVER["PHP_SELF"]; ?>";
            }
        };
    </script>

    <script src="../assets/js/imagenUser.js"></script>
    <script src="../assets/js/imagencarrito.js"></script>
    <script src="../assets/js/mostrardetallesproducto.js"></script>
    
</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/logo3.png" alt="PANBORGHINI">
        </div>
        <h1 class="main-title">PAMBORGHINI</h1>
        <nav>
            <ul>
                <li><img id="lupa" src="../assets/images/lupa.png" alt="Lupa"></li>
                <li><img id="carrito" src="../assets/images/carrito.png" alt="Carrito" onclick="irCarrito()"></li>
                <li><img id="user" src="../assets/images/user.png" alt="User" onclick="confirmarCerrarSesion()"></li>
            </ul>
        </nav>
    </header>
    <div id="form-filter">
        <form action=" <?php echo $_SERVER["PHP_SELF"]; ?> " method="POST">
            <input type="text" id="search-name" name="search-name" placeholder="Buscar por nombre">
            <input type="text" id="search-brand" name="search-brand" placeholder="Buscar por marca">
            <input type="text" id="search-size" name="search-size" placeholder="Buscar por tamaño">
            <input type="decimal" id="min-price" name="min-price" placeholder="Precio mínimo">
            <input type="decimal" id="max-price" name="max-price" placeholder="Precio máximo">
            <button type="submit" id="search-button">Buscar</button>
        </form>
    </div>


    <main>
        <?php
        include("../config/db_functions.php");
        if (isset($filter)) {
            if ($filter == false) {
                getProductos();
            } else {
                getProductosFiltrado($filtroNombre, $filtroMarca, $filtroSize, $filtroMinPrice, $filtroMaxPrice);
            }

        } else {
            getProductos();
        }

        ?>

    </main>

    <footer>
        <p>Pamborghini Spain © 2024. All rights reserved.</p>
    </footer>

    <script src="../assets/js/scriptlupa.js"></script>
</body>

</html>