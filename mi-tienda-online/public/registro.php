<?php
session_start(); 

// Comprobar si la petición es POST
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que todos los campos requeridos estén presentes
    if (
        isset($_POST["nombre"]) &&
        isset($_POST["apellidos"]) &&
        isset($_POST["email"]) &&
        isset($_POST["dni"]) &&
        isset($_POST["direccion"]) &&
        isset($_POST["telefono"]) &&
        isset($_POST["fecha_nacimiento"]) &&
        isset($_POST["password"]) &&
        isset($_POST["confirm_password"])
    ) {
        // Asegurarse de que las contraseñas coincidan
        if ($_POST["password"] === $_POST["confirm_password"]) {
            include("../config/db_functions.php");
            
            // Llamar a la función para registrar el usuario
            $registroExitoso = postUsuario(
                $_POST["nombre"],
                $_POST["apellidos"],
                $_POST["email"],
                $_POST["dni"],
                $_POST["direccion"],
                $_POST["telefono"],
                $_POST["fecha_nacimiento"],
                $_POST["password"]
            );

            if ($registroExitoso) {
                // Redirigir a la página de inicio o mostrar un mensaje de éxito

                include("../envioEmailsPHPMailer/index.php");
                enviarEmail($_POST["email"],$_POST["nombre"]);
                //header("Location: index.php");
                exit();
            } else {
                $err = true; // Error al registrar
            }
        } else {
            $err = true; // Las contraseñas no coinciden
        }
    } else {
        $err = true; // Campos faltantes
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylesregistro.css">

</head>
<body>
    <header>
        <h1>Registro de Usuario</h1>
    </header>
    <main>
        <div class="signup-main">
            <div class="signup-container">
                <img id="logo" src="../assets/images/logo3.png">
                
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">

                <div class="group-div-inputs">
                    <div class="input-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                    </div>

                    <div class="input-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="Ingresa tus apellidos" required>
                    </div>

                    <div class="input-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                    </div>
                </div>
                    
                <div class="group-div-inputs">
                    <div class="input-group">
                        <label for="dni">DNI</label>
                        <input type="text" id="dni" name="dni" placeholder="Ingresa tu DNI" required>
                    </div>

                    <div class="input-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Ingresa tu dirección" required>
                    </div>

                    <div class="input-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="Ingresa tu teléfono" required>
                    </div>
                </div>
                <div class="group-div-inputs">
                    <div class="input-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    </div>

                    <div class="input-group">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirma tu contraseña" required>
                    </div>
                </div>
                    <button type="submit" class="signup-button">Registrarse</button>
                </form>

                <div class="signup-footer">
                    <p>¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a></p>
                </div>

                <?php
                // Mostrar un mensaje de error si hubo algún problema
                if (isset($err) && $err) {
                    echo "<label>Error en el registro. Verifica los datos ingresados.</label>";
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>

