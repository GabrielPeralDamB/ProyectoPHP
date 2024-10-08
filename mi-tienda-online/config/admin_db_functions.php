<?php
// Incluye el archivo de conexión a la base de datos
require_once '../config/database.php'; // Ajusta la ruta según sea necesario

// Función para mostrar todos los usuarios
function getAllUsers() {
    // Hacer la variable $bd accesible dentro de la función
    global $bd;

    try {
        // Consulta para obtener todos los usuarios, incluyendo DNI y tipo de usuario
        $stmt = $bd->prepare("SELECT id, nombre, apellidos, dni, tipo_usuario FROM Usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar todos los resultados
    } catch (PDOException $e) {
        echo "Error al obtener los usuarios: " . $e->getMessage();
        return []; // Retornar un array vacío en caso de error
    }
}


// Función para buscar usuarios por nombre, apellidos, dni o tipo de usuario
function searchUsers($searchTerm) {
    global $bd;

    try {
        // Limpiar y verificar el término de búsqueda
        $searchTerm = trim($searchTerm);
        
        // Consulta para buscar en todos los campos relevantes
        $sql = "SELECT id, nombre, apellidos, dni, tipo_usuario FROM Usuarios WHERE 
                nombre LIKE :searchTerm OR 
                apellidos LIKE :searchTerm OR 
                dni LIKE :searchTerm OR 
                tipo_usuario LIKE :searchTerm";

        // Preparar la consulta
        $stmt = $bd->prepare($sql);

        // Ejecutar la consulta con el término de búsqueda
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar los resultados encontrados
    } catch (PDOException $e) {
        echo "Error al buscar los usuarios: " . $e->getMessage();
        return []; // Retornar un array vacío en caso de error
    }
}

// Función para mostrar todos los productos
function getAllProducts() {
    global $bd;

    try {
        // Consulta para obtener todos los productos
        $stmt = $bd->prepare("SELECT id, nombre, marca, precio, stock FROM Productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar todos los resultados
    } catch (PDOException $e) {
        echo "Error al obtener los productos: " . $e->getMessage();
        return []; // Retornar un array vacío en caso de error
    }
}

// Función para buscar productos por nombre o marca
function searchProducts($searchTerm) {
    global $bd;

    try {
        // Limpiar y verificar el término de búsqueda
        $searchTerm = trim($searchTerm);
        
        // Consulta para buscar en todos los campos relevantes
        $sql = "SELECT id, nombre, marca, precio, stock FROM Productos WHERE 
                nombre LIKE :searchTerm OR 
                marca LIKE :searchTerm";

        // Preparar la consulta
        $stmt = $bd->prepare($sql);

        // Ejecutar la consulta con el término de búsqueda
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar los resultados encontrados
    } catch (PDOException $e) {
        echo "Error al buscar los productos: " . $e->getMessage();
        return []; // Retornar un array vacío en caso de error
    }
}

function updateTipoUsuario($id, $tipo_usuario) {
    global $bd;

    try {
        $stmt = $bd->prepare("UPDATE Usuarios SET tipo_usuario = :tipo_usuario WHERE id = :id");
        $stmt->execute(['tipo_usuario' => $tipo_usuario, 'id' => $id]);
        return true; // Indica que la actualización fue exitosa
    } catch (PDOException $e) {
        return false; // Indica que hubo un error
    }
}


?>

