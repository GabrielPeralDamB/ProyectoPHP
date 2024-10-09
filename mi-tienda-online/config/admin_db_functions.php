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

function eliminarProducto($idProducto) {
    global $bd;

    try {
        // Iniciar una transacción
        $bd->beginTransaction();

        // Eliminar las valoraciones asociadas con el producto
        $stmtValoraciones = $bd->prepare("DELETE FROM Valoraciones WHERE id_producto = :idProducto");
        $stmtValoraciones->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        if (!$stmtValoraciones->execute()) {
            throw new Exception('Error al eliminar valoraciones.');
        }

        // Eliminar las líneas de pedidos asociadas con el producto
        $stmtLineaPedidos = $bd->prepare("DELETE FROM Linea_Pedidos WHERE id_producto = :idProducto");
        $stmtLineaPedidos->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        if (!$stmtLineaPedidos->execute()) {
            throw new Exception('Error al eliminar líneas de pedidos.');
        }

        // Eliminar el producto de la tabla CategoriasProductos
        $stmtCategoriasProductos = $bd->prepare("DELETE FROM CategoriasProductos WHERE id_producto = :idProducto");
        $stmtCategoriasProductos->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        if (!$stmtCategoriasProductos->execute()) {
            throw new Exception('Error al eliminar categorías del producto.');
        }

        // Finalmente, eliminar el producto de la tabla Productos
        $stmtProducto = $bd->prepare("DELETE FROM Productos WHERE id = :idProducto");
        $stmtProducto->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        if (!$stmtProducto->execute()) {
            throw new Exception('Error al eliminar el producto.');
        }

        // Confirmar la transacción
        $bd->commit();
        return true; // Eliminación exitosa

    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $bd->rollBack();
        echo "Error al eliminar el producto: " . $e->getMessage();
        return false;
    } catch (Exception $e) {
        // Atrapar otros errores
        $bd->rollBack();
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Función para obtener todas las categorías
function getAllCategories() {
    global $bd;

    try {
        // Consulta para obtener todas las categorías
        $stmt = $bd->prepare("SELECT id, nombre FROM Categorias");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar todos los resultados
    } catch (PDOException $e) {
        echo "Error al obtener las categorías: " . $e->getMessage();
        return []; // Retornar un array vacío en caso de error
    }
}

// Función para crear un nuevo producto
function createProduct($nombre, $marca, $size, $descripcion, $precio, $stock, $descuento, $url_imagen, $categoriaId) {
    global $bd;

    try {
        // Iniciar una transacción
        $bd->beginTransaction();

        // Inserción en la tabla Productos
        $stmt = $bd->prepare("INSERT INTO Productos (nombre, marca, size, descripcion, precio, stock, descuento, url_imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $marca, $size, $descripcion, $precio, $stock, $descuento, $url_imagen]);

        // Obtener el ID del producto recién creado
        $productoId = $bd->lastInsertId();

        // Asignar la categoría al producto
        $stmtCategoria = $bd->prepare("INSERT INTO CategoriasProductos (id_producto, id_categoria) VALUES (?, ?)");
        $stmtCategoria->execute([$productoId, $categoriaId]);

        // Confirmar la transacción
        $bd->commit();
        return true; // Indica que el producto fue creado exitosamente
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $bd->rollBack();
        echo "Error al crear el producto: " . $e->getMessage();
        return false;
    }
}


?>







