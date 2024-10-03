<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleslogin.css"> <!-- Aquí enlazas el archivo CSS -->
    <style>
        /* Inserta aquí el CSS que te proporcioné si no usas un archivo separado */
    </style>
</head>
<body>
    <header>
        <h1>Iniciar Sesión</h1>
    </header>
    <main>
        <div class="login-main">
        <div class="login-container">
        <img id="logo" src="../assets/images/logo3.png">
        
            
            <form action="#" method="POST">
                <div class="input-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                </div>
                
                <button type="submit" class="login-button">Iniciar Sesión</button>
            </form>

            <div class="login-footer">
                <p>¿No tienes cuenta? <a href="#">Regístrate</a></p>
            </div>
        </div>
    </div>
    </main>
    

</body>
</html>

