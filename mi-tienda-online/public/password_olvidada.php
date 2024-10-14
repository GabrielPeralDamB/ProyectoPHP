<?php
session_start();
include("../config/db_functions.php");
include("../envioEmailsPHPMailer/index.php");

$message = "";  // Variable para almacenar los mensajes

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Comprobar si el email existe en la base de datos
    if (comprobarEmail($email)) {
        // Generar una nueva contraseña aleatoria
        $nuevaContrasena = generarContrasenaAleatoria(10);

        // Cifrar la nueva contraseña antes de almacenarla
        $nuevaContrasenaCifrada = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        // Actualizar la contraseña del usuario en la base de datos
        if (actualizarContrasena($email, $nuevaContrasenaCifrada)) {
            // Enviar la nueva contraseña por correo electrónico
            enviarContrasenaEmail($email, $nuevaContrasena);
            $message = "Se ha enviado una nueva contraseña a tu correo.";
        } else {
            $message = "Error al actualizar la contraseña.";
        }
    } else {
        $message = "El email no está registrado.";
    }
}

// Función para generar una contraseña aleatoria
function generarContrasenaAleatoria($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($chars), 0, $length);
}

// Función para actualizar la contraseña en la base de datos
function actualizarContrasena($email, $nuevaContrasenaCifrada) {
    include '../config/database.php'; // Incluye el archivo de conexión

    // Prepara la consulta
    $query = "UPDATE usuarios SET password = :contrasena WHERE email = :email";
    $stmt = $bd->prepare($query);

    // Asigna los valores a los parámetros
    $stmt->bindParam(':contrasena', $nuevaContrasenaCifrada);
    $stmt->bindParam(':email', $email);

    // Ejecuta la consulta y devuelve el resultado
    return $stmt->execute();
}

// Función para comprobar si el email existe
function comprobarEmail($email) {
    include '../config/database.php'; // Incluye el archivo de conexión

    // Prepara la consulta
    $query = "SELECT email FROM usuarios WHERE email = :email";
    $stmt = $bd->prepare($query);

    // Asigna el valor al parámetro
    $stmt->bindParam(':email', $email);

    // Ejecuta la consulta
    $stmt->execute();

    // Comprueba si se ha encontrado algún resultado
    return $stmt->rowCount() > 0;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recuperar Contraseña</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleslogin.css">
</head>
<body>
    <header>
        <h1>Recuperar Contraseña</h1>
    </header>
    <a href="login.php" class="btn-volver">Volver</a>
    <main>
        <div class="login-main">
            <div class="login-container">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
                    </div>
                    <button type="submit" class="login-button">Recuperar Contraseña</button>
                </form>
                <?php if (!empty($message)): ?>
                    <div class="message">
                        <p><?php echo $message; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>

