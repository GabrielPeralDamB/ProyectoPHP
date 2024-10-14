<?php
// Incluir conexión a la base de datos
require_once '../config/database.php';

// Obtener todos los usuarios para llenar el combo box
function getAllUsers() {
    global $bd;
    try {
        $stmt = $bd->prepare("SELECT id, nombre, apellidos, email, telefono FROM Usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<p>Error al obtener los usuarios: " . $e->getMessage() . "</p>";
    }
}

// Si se envía el formulario para editar, actualizar los datos del usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar_usuario'])) {
    $id_usuario = $_POST['id_usuario'];

    // Recuperar los campos que se enviaron
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $password = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;

    // Preparar la consulta de actualización
    $fields = [];
    $values = [];
    
    // Agregar campos a actualizar solo si están definidos
    if ($nombre !== null) {
        $fields[] = "nombre = ?";
        $values[] = $nombre;
    }
    if ($apellidos !== null) {
        $fields[] = "apellidos = ?";
        $values[] = $apellidos;
    }
    if ($email !== null) {
        $fields[] = "email = ?";
        $values[] = $email;
    }
    if ($telefono !== null) {
        $fields[] = "telefono = ?";
        $values[] = $telefono;
    }
    if ($password !== null && $password !== '') {
        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $fields[] = "password = ?"; // Cambiado de 'contrasena' a 'password'
        $values[] = $hashed_password;
    }
    
    // Si hay campos para actualizar, ejecuta la consulta
    if (count($fields) > 0) {
        $sql = "UPDATE Usuarios SET " . implode(', ', $fields) . " WHERE id = ?";
        $values[] = $id_usuario; // Agregar el ID del usuario al final
        try {
            $stmt = $bd->prepare($sql);
            $stmt->execute($values);
            echo "<p>Usuario actualizado exitosamente</p>";
        } catch (PDOException $e) {
            echo "<p>Error al actualizar el usuario: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>No se han realizado cambios.</p>";
    }
}


// Obtener la lista de usuarios
$usuarios = getAllUsers();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/styles_editar_usuario.css">
</head>
<body>
    <header>
        <h1 class="main-title">Editar Usuario</h1>
    </header>
    <a href="index.php" class="btn-volver">Volver</a>
    <main>
        <div class="admin-container">
            <div class="admin-usuarios">
                <h2>Selecciona un Usuario para Editar</h2>
                <form action="editar_usuarios.php" method="post">
                    <label for="usuario">Usuario:</label>
                    <select id="usuario" name="id_usuario" onchange="populateFields(this.value)">
                        <option value="">-- Selecciona un usuario --</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id']; ?>"><?= $usuario['id'] . " - " . $usuario['nombre'] . " " . $usuario['apellidos']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Campos para editar, inicialmente vacíos -->
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre">

                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">

                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono">

                    <label for="contrasena">Nueva Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena">

                    <button type="submit" name="editar_usuario" class="edit-user-button">Guardar Cambios</button>
                </form>

            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Editar Usuario</p>
    </footer>

    <script>
        // Función para llenar los campos al seleccionar un usuario
        function populateFields(id) {
            // Definir el objeto de usuarios para acceso rápido
            const usuarios = <?= json_encode($usuarios); ?>;
            const usuario = usuarios.find(u => u.id == id);

            if (usuario) {
                document.getElementById('nombre').value = usuario.nombre;
                document.getElementById('apellidos').value = usuario.apellidos;
                document.getElementById('email').value = usuario.email;
                document.getElementById('telefono').value = usuario.telefono;
            } else {
                // Limpiar los campos si no hay usuario seleccionado
                document.getElementById('nombre').value = '';
                document.getElementById('apellidos').value = '';
                document.getElementById('email').value = '';
                document.getElementById('telefono').value = '';
            }
        }
    </script>
</body>
</html>
