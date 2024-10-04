<?php
function getProductos()
{
    include("database.php");

    try {
        // Conectar con la base de datos y obtener los productos
        $sql = "SELECT * FROM productos";
        $productos = $bd->query($sql);

        // Mostrar el número total de productos
        /*echo "Total: " . $productos->rowCount() . "<br>";*/

        foreach ($productos as $producto) {
            echo '<section class="item" onclick="mostrarDetalles(' . $producto["id"] . ')">';

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

            // Botón de comprar (con event.stopPropagation())
            echo '<button class="buy-button" onclick="event.stopPropagation(); comprarProducto(' . $producto["id"] . ')">Comprar</button>';

            echo '</section>';
        }
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

function getProductosFiltrado($filtroNombre, $filtroMarca, $filtroSize, $filtroMinPrice, $filtroMaxPrice)
{
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

        foreach ($productos as $producto) {
            echo '<section class="item" onclick="mostrarDetalles(' . $producto["id"] . ')">';

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

            // Botón de comprar (con event.stopPropagation())
            echo '<button class="buy-button" onclick="event.stopPropagation(); comprarProducto(' . $producto["id"] . ')">Comprar</button>';

            echo '</section>';
        }
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

function comprobarDatos($username, $password)
{
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
                $_SESSION["id"] = $usuario["id"];
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


function postUsuario($nombre, $apellidos, $email, $dni, $direccion, $telefono, $fecha_nacimiento, $password)
{
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



function getDetallesProducto($idProducto)
{
    include("database.php"); // Incluir la conexión a la base de datos

    try {
        // Verificar si el idProducto es válido
        if (!$idProducto) {
            throw new Exception("ID de producto no recibido.");
        }

        // Obtener los detalles del producto
        $sqlProducto = "SELECT p.*, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS categorias 
                        FROM Productos p
                        LEFT JOIN CategoriasProductos cp ON p.id = cp.id_producto
                        LEFT JOIN Categorias c ON cp.id_categoria = c.id
                        WHERE p.id = :idProducto
                        GROUP BY p.id";

        $stmtProducto = $bd->prepare($sqlProducto);
        $stmtProducto->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        $stmtProducto->execute();
        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el producto
        if (!$producto) {
            throw new Exception("Producto no encontrado.");
        }

        // Obtener las valoraciones del producto
        $sqlValoraciones = "SELECT v.*, u.nombre AS nombre_usuario FROM Valoraciones v 
                            JOIN Usuarios u ON v.id_usuario = u.id
                            WHERE v.id_producto = :idProducto";
        $stmtValoraciones = $bd->prepare($sqlValoraciones);
        $stmtValoraciones->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        $stmtValoraciones->execute();
        $valoraciones = $stmtValoraciones->fetchAll(PDO::FETCH_ASSOC);

        // Calcular la valoración promedio
        $totalValoracion = 0;
        $numeroValoraciones = count($valoraciones);
        foreach ($valoraciones as $valoracion) {
            $totalValoracion += $valoracion['num_valoracion'];
        }

        // Evitar división por cero
        $promedioValoracion = $numeroValoraciones > 0 ? round($totalValoracion / $numeroValoraciones, 2) : 0;

        return [
            'producto' => $producto,
            'valoraciones' => $valoraciones,
            'promedioValoracion' => $promedioValoracion
        ];
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}



// Función para insertar una nueva valoración
function insertarValoracion($idProducto, $idUsuario, $valoracion, $descripcion)
{
    include("database.php");

    try {
        // Insertar la nueva valoración en la base de datos
        $sqlInsertValoracion = "INSERT INTO Valoraciones (id_producto, id_usuario, descripcion, num_valoracion) 
                                VALUES (:idProducto, :idUsuario, :descripcion, :valoracion)";
        $stmtInsert = $bd->prepare($sqlInsertValoracion);
        $stmtInsert->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        $stmtInsert->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmtInsert->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmtInsert->bindParam(':valoracion', $valoracion, PDO::PARAM_INT);
        $stmtInsert->execute();

        return true;
    } catch (PDOException $e) {
        die("Error al insertar la valoración: " . $e->getMessage());
    }
}


function addCarrito($idProducto)
{
    // Asegúrate de que la sesión esté iniciada
    include("database.php"); // Incluye tu conexión a la base de datos

    // Verificar si el usuario está logueado
    if (isset($_SESSION['id'])) {
        $id_usuario = $_SESSION['id'];
        $cantidad = 1; // Establecer la cantidad en 1
        $precio_unitario = 0; // Inicializa el precio unitario, lo obtendremos del producto
        $precio_total = 0; // Inicializa el precio total

        try {
            // Obtener el precio del producto
            $sql = "SELECT precio FROM productos WHERE id = :id_producto";
            $stmt = $bd->prepare($sql);
            $stmt->bindParam(':id_producto', $idProducto);
            $stmt->execute();
            $producto = $stmt->fetch();

            if ($producto) {
                $precio_unitario = $producto['precio'];
                $precio_total = $precio_unitario * $cantidad; // Calcular el precio total

                // Insertar la línea de pedido en la base de datos
                $sqlInsert = "INSERT INTO Linea_Pedidos (id_pedido, cantidad, id_producto, id_usuario, precio_unitario, precio_total) 
                                VALUES (NULL, :cantidad, :id_producto, :id_usuario, :precio_unitario, :precio_total)";
                $stmtInsert = $bd->prepare($sqlInsert);
                $stmtInsert->bindParam(':cantidad', $cantidad);
                $stmtInsert->bindParam(':id_producto', $idProducto);
                $stmtInsert->bindParam(':id_usuario', $id_usuario);
                $stmtInsert->bindParam(':precio_unitario', $precio_unitario);
                $stmtInsert->bindParam(':precio_total', $precio_total);
                $stmtInsert->execute();

                echo "Producto añadido al carrito.";
                exit; 
            } else {
                echo "Producto no encontrado.";
                exit; 
            }
        } catch (Exception $ex) {
            echo "Error al agregar al carrito: " . $ex->getMessage();
            exit; 
        }
    } else {
        echo "Usuario no autenticado.";
        exit; 
    }
}
