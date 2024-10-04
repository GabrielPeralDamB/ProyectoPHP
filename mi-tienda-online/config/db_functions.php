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
            echo '<section class="item" onclick="mostrarDetalles('.$producto["id"].')">';
            
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

function comprobarDatos($username, $password) {
    try {
        include("database.php");
        // Construimos la consulta para buscar por cualquiera de los campos
        $sql = "SELECT id, nombre, password, email, tipo_usuario, dni, telefono FROM Usuarios 
                WHERE id = :username 
                OR telefono = :username 
                OR email = :username 
                OR dni = :username";

        // Preparar la consulta en lugar de concatenar directamente para evitar SQL Injection
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        echo "Total: " . $stmt->rowCount() . "<br>";

        $salida = false;
        foreach ($stmt as $usuario) {
            echo $usuario['nombre'] . "\t";
            echo $usuario['email'] . "\t <br>";

            
            if (password_verify($password, $usuario["password"])) {
                
                $_SESSION["dni"] = $usuario["dni"];
                $_SESSION["email"] = $usuario["email"];
                $_SESSION["tipo_usuario"] = $usuario["tipo_usuario"];
                $salida = true;

                // Imprime las variables de sesión para verificar su creación
                /*var_dump($_SESSION);*/
            }
        }
        
        return $salida;

    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}


function postUsuario($nombre, $apellidos, $email, $dni, $direccion, $telefono, $fecha_nacimiento, $password) {
    include("database.php");

    try {
        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO Usuarios (nombre, apellidos, email, tipo_usuario, dni, direccion, telefono, fecha_nacimiento, password, cuenta_operativa) 
                VALUES (:nombre, :apellidos, :email, 'usuario', :dni, :direccion, :telefono, :fecha_nacimiento, :password, false)";

        // Preparar la consulta
        $stmt = $bd->prepare($sql);

        // Vincular los parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':password', $hashedPassword);

        // Ejecutar la consulta
        $stmt->execute();

        return true; // Retorna verdadero si se creó el usuario
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
        return false; // Retorna falso en caso de error
    }
}

?>
