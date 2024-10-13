<?php

 session_start();
    require_once '../../config/database.php'; // Ajusta la ruta según sea necesario

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

        // Crear la entrega
        $query = "INSERT INTO Entregas (id_usuario, id_pedido, estado, fecha_entrega_estimada, direccion_entrega) 
                  VALUES (:id_usuario, :id_pedido, 'En curso', :fecha_entrega, :direccion_entrega)";
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':id_usuario', $repartidor, PDO::PARAM_INT);
        $stmt->bindParam(':id_pedido', $pedido, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_entrega', $pedidoDetails['fecha_entrega'], PDO::PARAM_STR);
        $stmt->bindParam(':direccion_entrega', $pedidoDetails['direccion_entrega'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Entrega creada correctamente', 'pedido' => $pedido]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Entrega fallida']);
        }
        
    }
?>

