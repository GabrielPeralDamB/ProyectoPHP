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

    // Crear la entrega
    $query = "INSERT INTO Entregas (id_usuario, id_pedido, estado) VALUES (:id_usuario, :id_pedido, 'En curso')";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':id_usuario', $repartidor, PDO::PARAM_INT);
    $stmt->bindParam(':id_pedido', $pedido, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Entrega creada con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear la entrega.']);
    }
}
?>
