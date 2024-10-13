<?php
// Incluye el archivo de conexión a la base de datos
require_once '../../config/database.php'; // Ajusta la ruta según sea necesario



// Función para obtener todos los usuarios de un tipo específico (en este caso 'repartidor')
function getUsersByType($bd, $tipo_usuario) {
    $query = "SELECT * FROM Usuarios WHERE tipo_usuario = :tipo_usuario";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tipo_usuario', $tipo_usuario, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenemos todos los resultados como un array asociativo
    return $users;
}

// Función para obtener todos los pedidos
function getAllPedidos($bd) {
    $query = "
        SELECT * FROM Pedidos 
        WHERE id NOT IN (
            SELECT id_pedido FROM Entregas
        )
    ";
    $stmt = $bd->query($query);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $pedidos;
}



?>