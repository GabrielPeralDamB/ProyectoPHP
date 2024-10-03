<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylesregistro.css">
    <style>
        /* Aquí va el CSS proporcionado */
    </style>
</head>
<body>
    <header>
        <h1>Registro de Usuario</h1>
    </header>
    <main>
        <div class="signup-main">
            <div class="signup-container">
                <img id="logo" src="../assets/images/logo3.png">
                
                <form action="#" method="POST">

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
                    <p>¿Ya tienes cuenta? <a href="#">Inicia Sesión</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
