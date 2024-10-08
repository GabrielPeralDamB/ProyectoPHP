<?php
session_start();
if (!isset($_SESSION["dni"])) {
    header("Location: login.php");
} 


include("../config/database.php"); // Incluir tu conexión a la base de datos
include("../config/variables.php");

$id_usuario = $_SESSION['id'];
$fecha_pedido = date('Y-m-d H:i:s'); // Fecha actual
$fecha_entrega = date('Y-m-d H:i:s', strtotime('+2 days')); // Fecha de entrega (2 días después por ejemplo)
$metodo_pago = "Tarjeta"; // Cambiar según el método de pago elegido
$num_telefono_entrega = $_POST['telefono']; // Obtener el teléfono de un formulario
$email_entrega = $_POST['email']; // Obtener el email de un formulario
$direccion_entrega = $_POST['direccion']; // Obtener la dirección de un formulario
$comentarios_cliente = $_POST['comentarios']; // Obtener los comentarios de un formulario
$costo_envio = $costo_envio_permanente; // Suponiendo un costo de envío fijo
$estado = "Pendiente"; // Estado inicial del pedido

// Comenzar una transacción
try {
    $bd->beginTransaction();

    // 1. Obtener las líneas de pedido con el nombre del producto
    $stmt = $bd->prepare("
SELECT lp.id_producto, lp.cantidad, lp.precio_total, p.nombre 
FROM Linea_Pedidos lp 
JOIN Productos p ON lp.id_producto = p.id
WHERE lp.id_usuario = :id_usuario AND lp.id_pedido IS NULL
");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $lineas_pedido = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Agrupar cantidades por producto
    $productos_totales = [];
    foreach ($lineas_pedido as $item) {
        if (isset($productos_totales[$item['id_producto']])) {
            $productos_totales[$item['id_producto']]['cantidad'] += $item['cantidad'];
            $productos_totales[$item['id_producto']]['precio_total'] += $item['precio_total'];
        } else {
            $productos_totales[$item['id_producto']] = [
                'nombre' => $item['nombre'], // Almacenar el nombre del producto
                'cantidad' => $item['cantidad'],
                'precio_total' => $item['precio_total']
            ];
        }
    }

    // 3. Verificar el stock de cada producto
    $productos_sin_stock = [];
    foreach ($productos_totales as $id_producto => $data) {
        // Obtener tanto el nombre como el stock del producto
        $stmt_stock = $bd->prepare("SELECT nombre, stock FROM Productos WHERE id = :id_producto");
        $stmt_stock->bindParam(':id_producto', $id_producto);
        $stmt_stock->execute();
        $producto = $stmt_stock->fetch(PDO::FETCH_ASSOC);

        // Comprobar si hay suficiente stock
        if ($producto['stock'] < $data['cantidad']) {
            $productos_sin_stock[] = [
                'nombre' => $producto['nombre'], // Almacenar el nombre del producto
                'cantidad_solicitada' => $data['cantidad'],
                'stock_disponible' => $producto['stock']
            ];
        }
    }

    // Si hay productos sin stock, lanzar excepción
    if (!empty($productos_sin_stock)) {
        $error_msg = "No hay suficiente stock para los siguientes productos:\n";
        foreach ($productos_sin_stock as $producto) {
            $error_msg .= "Producto: " . $producto['nombre'] . // Cambia 'data' por 'producto'
                " - Cantidad solicitada: " . $producto['cantidad_solicitada'] .
                ", Stock disponible: " . $producto['stock_disponible'] . "\n";
        }
        throw new Exception($error_msg);
    }

    // 4. Insertar el nuevo pedido
    $sql = "INSERT INTO Pedidos (id_usuario, fecha_pedido, fecha_entrega, precio_total, estado, num_telefono_entrega, email_entrega, direccion_entrega, metodo_pago, comentarios_cliente, costo_envio, prioridad_envio) 
            VALUES (:id_usuario, :fecha_pedido, :fecha_entrega, :precio_total, :estado, :num_telefono_entrega, :email_entrega, :direccion_entrega, :metodo_pago, :comentarios_cliente, :costo_envio, 'Normal')";

    // Calcular el precio total basado en las líneas de pedido
    $totalCost = 0;
    foreach ($productos_totales as $data) {
        $totalCost += $data['precio_total']; // Asegúrate de que 'precio_total' se calcule correctamente
    }

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':fecha_pedido', $fecha_pedido);
    $stmt->bindParam(':fecha_entrega', $fecha_entrega);
    $stmt->bindParam(':precio_total', $totalCost);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':num_telefono_entrega', $num_telefono_entrega);
    $stmt->bindParam(':email_entrega', $email_entrega);
    $stmt->bindParam(':direccion_entrega', $direccion_entrega);
    $stmt->bindParam(':metodo_pago', $metodo_pago);
    $stmt->bindParam(':comentarios_cliente', $comentarios_cliente);
    $stmt->bindParam(':costo_envio', $costo_envio);
    $stmt->execute();

    // Obtener el ID del pedido recién creado
    $id_pedido = $bd->lastInsertId();

    // 5. Actualizar las líneas de pedido con el ID del nuevo pedido
    $sql_update_lineas = "UPDATE Linea_Pedidos SET id_pedido = :id_pedido WHERE id_usuario = :id_usuario AND id_pedido IS NULL";
    $stmt = $bd->prepare($sql_update_lineas);
    $stmt->bindParam(':id_pedido', $id_pedido);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();

    // 6. Reducir el stock de los productos
    $sql_update_stock = "UPDATE Productos SET stock = stock - :cantidad WHERE id = :id_producto";
    $stmt = $bd->prepare($sql_update_stock);

    foreach ($productos_totales as $id_producto => $data) {
        $stmt->bindParam(':cantidad', $data['cantidad']);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();
    }

    // Confirmar la transacción
    $bd->commit();

    // Crear los detalles del pedido en un formato legible para el correo
    $detallesPedido = "Pedido #{$id_pedido}\n";
    foreach ($productos_totales as $id_producto => $data) {
        $detallesPedido .= "Producto ID: $id_producto - Nombre: {$data['nombre']} - Cantidad: {$data['cantidad']} - Precio total: {$data['precio_total']} €\n";
    }
    $detallesPedido .= "Costo de envío: $costo_envio €\n";
    $detallesPedido .= "Total: " . ($totalCost + $costo_envio) . " €";
    include("../envioEmailsPHPMailer/index.php");
    // Enviar el correo con los detalles del pedido
    enviarDatosPedido($email_entrega, $detallesPedido);

    // Redireccionar o mostrar un mensaje de éxito
    $_SESSION['message'] = "Pedido realizado con éxito! ID de Pedido: " . $id_pedido;
    header("Location: carrito.php");
    exit;

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $bd->rollBack();
    $_SESSION['message'] = "Error al realizar el pedido: " . nl2br(htmlspecialchars($e->getMessage()));
    header("Location: carrito.php");
    exit;
}
?>