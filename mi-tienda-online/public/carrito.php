<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Carrito de Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylescarrito.css"> <!-- Enlace al archivo CSS -->
</head>
<body>

    <header>
        <img src="../assets/images/logo3.png" alt="logo">
        <h1>Finalizar pedido</h1>
    </header>

    <main>
        <div class="cart-container">
            <!-- Contenedor de productos -->
            <div class="cart-items">
                <h2>Productos en el carrito</h2>
                <ul id="cart-items-list">
                    <!-- Aquí se generarán los productos mediante JS -->
                </ul>
            </div>

            <!-- Resumen del carrito -->
            <div class="cart-summary">
                <h2>Resumen</h2>
                <p >Total de productos: <span id="total-items">0</span></p>
                <p >Descuentos aplicados: €0.00</span></p>
                <p >Impuestos: €0.00</span></p>
                <p >Precio total: <span id="total-price">€0.00</span></p>
                
                <button id="checkout-button">Aceptar y Pagar</button>
                <br>
                <img src="../assets/images/metodospago.png" alt="Efectivo, Targeta, Bizum">
            </div>
        </div>
    </main>

    <script src="../assets/js/carrito.js"></script> <!-- Enlace al archivo JS -->
</body>
</html>
