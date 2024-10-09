<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entregas Pendientes</title>
    <link rel="stylesheet" href="../../assets/css/entregas_repartidor.css">
    <script src="../../assets/js/imagenUser.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../../assets/images/logo3.png" alt="PANBORGHINI">
        </div>
        <h1 class="main-title">Entregas Pendientes</h1>
        <nav>
            <ul>
                <img id="user" src="../../assets/images/user.png" alt="User" onclick="confirmarCerrarSesion()" width="100px">
            </ul>
        </nav>
    </header>

    <main>
        <section class="admin-entregas">
            <h2>Lista de Entregas Pendientes</h2>
            <ul>
                <!-- Entrega 1 -->
                <li>
                    <div class="detalle-entrega">
                        <span><strong>ID Pedido:</strong> 101</span>
                        <span><strong>Repartidor:</strong> Juan Pérez</span>
                        <span><strong>Fecha de entrega:</strong> 10/10/2024</span>
                        <span><strong>Estado:</strong> Pendiente</span>
                    </div>
                    <div class="acciones-entrega">
                        <button class="detalle-button">Ver Detalles</button>
                        <button class="actualizar-button">Actualizar Estado</button>
                    </div>
                </li>

                <!-- Entrega 2 -->
                <li>
                    <div class="detalle-entrega">
                        <span><strong>ID Pedido:</strong> 102</span>
                        <span><strong>Repartidor:</strong> María García</span>
                        <span><strong>Fecha de entrega:</strong> 11/10/2024</span>
                        <span><strong>Estado:</strong> En camino</span>
                    </div>
                    <div class="acciones-entrega">
                        <button class="detalle-button">Ver Detalles</button>
                        <button class="actualizar-button">Actualizar Estado</button>
                    </div>
                </li>

                <!-- Entrega 3 -->
                <li>
                    <div class="detalle-entrega">
                        <span><strong>ID Pedido:</strong> 103</span>
                        <span><strong>Repartidor:</strong> Pedro Sánchez</span>
                        <span><strong>Fecha de entrega:</strong> 12/10/2024</span>
                        <span><strong>Estado:</strong> Pendiente</span>
                    </div>
                    <div class="acciones-entrega">
                        <button class="detalle-button">Ver Detalles</button>
                        <button class="actualizar-button">Actualizar Estado</button>
                    </div>
                </li>

                <!-- Entrega 4 -->
                <li>
                    <div class="detalle-entrega">
                        <span><strong>ID Pedido:</strong> 104</span>
                        <span><strong>Repartidor:</strong> Laura Fernández</span>
                        <span><strong>Fecha de entrega:</strong> 13/10/2024</span>
                        <span><strong>Estado:</strong> En camino</span>
                    </div>
                    <div class="acciones-entrega">
                        <button class="detalle-button">Ver Detalles</button>
                        <button class="actualizar-button">Actualizar Estado</button>
                    </div>
                </li>
            </ul>
        </section>
    </main>

    <footer>
        <p>Pamborghini Spain © 2024. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
