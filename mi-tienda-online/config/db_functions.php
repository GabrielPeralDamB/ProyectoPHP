<?php
function getProductos(){
    include("database.php");

try {
    // Conectar con la base de datos y obtener los productos
    $sql = "SELECT * FROM productos";
    $productos = $bd->query($sql);

    // Mostrar el número total de productos
    /*echo "Total: " . $productos->rowCount() . "<br>";*/

    // Recorrer los productos y renderizar el HTML de cada uno
    foreach ($productos as $producto) {
        echo '<section class="item">';
        
        // Tamaño
        echo '<p class="size">Tamaño: ' . htmlspecialchars($producto["size"]) . '</p>';
        
        // Imagen
        echo '<img src="../assets/images/' . htmlspecialchars($producto["url_imagen"]) . '" alt="' . htmlspecialchars($producto["nombre"]) . '">';
        
        // Título
        echo '<h2>' . htmlspecialchars($producto["nombre"]) . '</h2>';
        
        // Precio
        echo '<p class="price">' . htmlspecialchars($producto["precio"]) . '</p>';
        
        // Descripción
        echo '<p class="description">' . htmlspecialchars($producto["descripcion"]) . '</p>';
        
        // Stock
        echo '<p class="stock">Disponibles: ' . htmlspecialchars($producto["stock"]) . '</p>';
        
        // Botón de comprar
        echo '<button class="buy-button">Comprar</button>';
        
        echo '</section>';
    }
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage();
}
}

function getProductosFiltrado($filtroNombre, $filtroMarca, $filtroSize, $filtroMinPrice, $filtroMaxPrice) {
    include("database.php");

    try {
        // Crear la consulta SQL dinámica con filtros
        $sql = "SELECT * FROM productos WHERE 1=1";

        // Array para almacenar los valores que se vincularán a la consulta
        $params = [];

        // Aplicar filtro por nombre si está definido
        if (!empty($filtroNombre)) {
            $sql .= " AND LOWER(nombre) LIKE :nombre";
            $params[':nombre'] = '%' . strtolower($filtroNombre) . '%';
        }

        // Aplicar filtro por marca si está definido
        if (!empty($filtroMarca)) {
            $sql .= " AND LOWER(marca) LIKE :marca";
            $params[':marca'] = '%' . strtolower($filtroMarca) . '%';
        }

        // Aplicar filtro por tamaño si está definido
        if (!empty($filtroSize)) {
            $sql .= " AND LOWER(size) LIKE :size";
            $params[':size'] = '%' . strtolower($filtroSize) . '%';
        }

        // Aplicar filtro por precio mínimo si está definido
        if (!empty($filtroMinPrice)) {
            $sql .= " AND precio >= :minPrice";
            $params[':minPrice'] = $filtroMinPrice;
        }

        // Aplicar filtro por precio máximo si está definido
        if (!empty($filtroMaxPrice)) {
            $sql .= " AND precio <= :maxPrice";
            $params[':maxPrice'] = $filtroMaxPrice;
        }

        // Preparar la consulta
        $stmt = $bd->prepare($sql);

        // Vincular los parámetros de la consulta
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los productos
        $productos = $stmt->fetchAll();

        // Recorrer los productos y renderizar el HTML de cada uno
        foreach ($productos as $producto) {
            echo '<section class="item">';
            
            // Tamaño
            echo '<p class="size">Tamaño: ' . htmlspecialchars($producto["size"]) . '</p>';
            
            // Imagen
            echo '<img src="../assets/images/' . htmlspecialchars($producto["url_imagen"]) . '" alt="' . htmlspecialchars($producto["nombre"]) . '">';
            
            // Título
            echo '<h2>' . htmlspecialchars($producto["nombre"]) . '</h2>';
            
            // Precio
            echo '<p class="price">' . htmlspecialchars($producto["precio"]) . '€</p>';
            
            // Descripción
            echo '<p class="description">' . htmlspecialchars($producto["descripcion"]) . '</p>';
            
            // Stock
            echo '<p class="stock">Disponibles: ' . htmlspecialchars($producto["stock"]) . '</p>';
            
            // Botón de comprar
            echo '<button class="buy-button">Comprar</button>';
            
            echo '</section>';
        }
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}



?>
