<?php
session_start();

// Comprobar si la petición es POST
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {


    // Verificar que el usuario y la contraseña estén presentes
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        include("../config/db_functions.php");

        if (comprobarDatos($_POST["username"], $_POST["password"])) {

            header("Location: index.php");
            exit();
        } else {
            $err = true;
        }
    } else {
        $err = true;
    }
    
} else {
    $err = null;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleslogin.css">
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
        <h1>Iniciar Sesión</h1>
    </header>
    <main>
        <div class="login-main">
            <div class="login-container">
                <img id="logo" src="../assets/images/logo3.png">


                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                    <div class="input-group">
                        <label for="username">Usuario</label>
                        <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <?php
                    // Mostrar un mensaje de error si hubo algún problema
                    if (isset($err) && $err) {
                        echo "<label>Usuario o contraseña incorrectos</label>";
                    }
                    ?>
                    <button type="submit" class="login-button">Iniciar Sesión</button>
                </form>

                <div class="login-footer">
                    <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
                </div>
            </div>
        </div>
    </main>


</body>

</html>