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

/*function createEntrega($repartidor, $pedido) {
    session_start();
    require_once '../../config/database.php'; // Ajusta la ruta según sea necesario

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $repartidor = $_POST['repartidor'];
        $pedido = $_POST['pedido'];

        // Validación básica
        if (empty($repartidor) || empty($pedido)) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos.']);
            exit;
        }

        // Obtener información del pedido
        $queryPedido = "SELECT fecha_entrega, direccion_entrega FROM Pedidos WHERE id = :id_pedido";
        $stmtPedido = $bd->prepare($queryPedido);
        $stmtPedido->bindParam(':id_pedido', $pedido, PDO::PARAM_INT);
        $stmtPedido->execute();

        $pedidoDetails = $stmtPedido->fetch(PDO::FETCH_ASSOC);
        if (!$pedidoDetails) {
            echo json_encode(['success' => false, 'message' => 'Pedido no encontrado.']);
            exit;
        }

        // Depuración: muestra los detalles del pedido
        var_dump($pedidoDetails);

        // Crear la entrega
        $query = "INSERT INTO Entregas (id_usuario, id_pedido, estado, fecha_entrega_estimada, direccion_entrega) 
                  VALUES (:id_usuario, :id_pedido, 'En curso', :fecha_entrega, :direccion_entrega)";
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':id_usuario', $repartidor, PDO::PARAM_INT);
        $stmt->bindParam(':id_pedido', $pedido, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_entrega', $pedidoDetails['fecha_entrega'], PDO::PARAM_STR);
        $stmt->bindParam(':direccion_entrega', $pedidoDetails['direccion_entrega'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Entrega creada correctamente']);
        } else {
            $errorInfo = $stmt->errorInfo(); // Captura información de error
            echo json_encode(['success' => false, 'message' => 'Entrega fallida', 'error' => $errorInfo]);
        }
    }
}*/



// Función para obtener todas las entregas
function getAllEntregas($bd) {
    $query = "
        SELECT e.*, u.nombre AS repartidor, p.id AS pedido
        FROM Entregas e
        JOIN Usuarios u ON e.id_usuario = u.id
        JOIN Pedidos p ON e.id_pedido = p.id
    ";
    $stmt = $bd->query($query);
    $entregas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $entregas;
}

function searchEntregas($bd, $idEntrega = null, $idPedido = null, $idRepartidor = null, $estado = null) {
    // Construir la consulta dinámica con filtros
    $query = "
        SELECT e.*, u.id AS repartidor, p.id AS pedido
        FROM Entregas e
        JOIN Usuarios u ON e.id_usuario = u.id
        JOIN Pedidos p ON e.id_pedido = p.id
        WHERE 1 = 1
    ";
    
    // Añadir condiciones según los parámetros recibidos
    $params = [];
    if (!empty($idEntrega)) {
        $query .= " AND e.id = :idEntrega";
        $params[':idEntrega'] = $idEntrega;
    }
    if (!empty($idPedido)) {
        $query .= " AND p.id = :idPedido";
        $params[':idPedido'] = $idPedido;
    }
    if (!empty($idRepartidor)) {
        $query .= " AND u.id = :idRepartidor";
        $params[':idRepartidor'] = $idRepartidor;
    }
    if (!empty($estado)) {
        $query .= " AND e.estado = :estado";
        $params[':estado'] = $estado;
    }

    $stmt = $bd->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDetallesPedido($bd, $idPedido) {
    $query = "
        SELECT 
            p.id AS id_pedido,
            u.nombre AS nombre_cliente,
            u.apellidos AS apellidos_cliente,
            u.telefono AS telefono_cliente,
            u.email AS email_cliente,
            p.fecha_pedido,
            p.fecha_entrega,
            p.precio_total,
            p.estado,
            p.direccion_entrega,
            p.comentarios_cliente,
            GROUP_CONCAT(CONCAT(lp.cantidad, ' x ', prod.nombre, ' (', lp.precio_unitario, '€)') SEPARATOR '<br>') AS detalles_productos
        FROM 
            Pedidos p
        JOIN 
            Usuarios u ON p.id_usuario = u.id
        JOIN 
            Linea_Pedidos lp ON lp.id_pedido = p.id
        JOIN 
            Productos prod ON lp.id_producto = prod.id
        WHERE 
            p.id = :idPedido
        GROUP BY 
            p.id";

    $stmt = $bd->prepare($query);
    $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}




?>