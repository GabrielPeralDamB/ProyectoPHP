use tienda;

INSERT INTO Usuarios(nombre, apellidos, email, tipo_usuario, dni, direccion, telefono, fecha_nacimiento, password, cuenta_operativa) 
VALUES 
("Carlos", "García López", "carlos.garcia@correo.com", "Usuario", "12345678A", "Avenida Siempre Viva, 742", "+34 600123456", '1990-05-15', "pass123", true),
("Marta", "Pérez González", "marta.perez@correo.com", "Administrador", "87654321B", "Calle Falsa, 123", "+34 600654321", '1985-11-23', "contraseña123", true),
("Javier", "Fernández Ruiz", "javi.fernandez@correo.com", "Usuario", "56781234C", "Calle del Olmo, 56", "+34 601234567", '1995-08-10', "clave5678", true),
("Lucía", "Martínez Gómez", "lucia.martinez@correo.com", "Usuario", "34567812D", "Paseo de la Castellana, 80", "+34 602345678", '1998-07-30', "secreto987", true),
("Pablo", "Sánchez López", "pablo.sanchez@correo.com", "Administrador", "23456789E", "Plaza Mayor, 2", "+34 603456789", '1993-02-18', "admin2020", true),
("Ana", "Gutiérrez Hernández", "ana.gutierrez@correo.com", "Usuario", "87654312F", "Calle Luna, 7", "+34 604567890", '2001-12-05', "claveana", true),
("David", "López Martínez", "david.lopez@correo.com", "Usuario", "78901234G", "Calle Sol, 12", "+34 605678901", '1989-04-22', "password123", true),
("Laura", "García Fernández", "laura.garcia@correo.com", "Usuario", "12340987H", "Calle Rosa, 28", "+34 606789012", '1992-03-09', "secretolaura", true),
("Raúl", "Gómez Pérez", "raul.gomez@correo.com", "Administrador", "90876543I", "Calle Verde, 3", "+34 607890123", '1986-09-19', "rauladmin", true),
("Sonia", "Hernández Ortiz", "sonia.hernandez@correo.com", "Usuario", "34567890J", "Calle Azul, 6", "+34 608901234", '1997-10-25', "sonia987", true);


INSERT INTO Categorias (nombre, descripcion) 
VALUES 
('Agua Mineral Natural', 'Agua pura extraída de fuentes subterráneas naturales.'),
('Agua con Gas', 'Agua mineral con burbujas de gas natural o añadido.'),
('Agua Purificada', 'Agua que ha sido filtrada y tratada para eliminar impurezas.'),
('Agua Alcalina', 'Agua con un pH alto, beneficiosa para equilibrar la acidez en el cuerpo.'),
('Agua de Manantial', 'Agua que fluye naturalmente desde el suelo y es embotellada en la fuente.'),
('Agua Saborizada', 'Agua con diferentes sabores añadidos, ideal para hidratar con un toque de sabor.'),
('Agua Artesiana', 'Agua de acuíferos confinados, que fluye naturalmente a la superficie.'),
('Agua Destilada', 'Agua purificada a través de destilación, ideal para usos industriales o médicos.'),
('Agua de Coco', 'Agua de coco 100% natural, rica en electrolitos y vitaminas.'),
('Agua Electrolizada', 'Agua ionizada con electrolitos añadidos, ideal para deportistas.');


/*INSERT INTO Productos (nombre, marca, size, descripcion, precio, stock, descuento, url_imagen) 
VALUES 
('Agua Mineral Natural Evian', 'Evian', '1L', 'Agua mineral natural de los Alpes franceses, ideal para la hidratación diaria.', 1.99, 100, 10, 'evian_1L.jpg'),
('Agua con Gas Perrier', 'Perrier', '750ml', 'Agua mineral con gas natural de la región de Vergèze, Francia, conocida por su frescura.', 2.50, 80, 0, 'perrier_750ml.jpg'),
('Agua Purificada Aquafina', 'Aquafina', '500ml', 'Agua purificada mediante un riguroso proceso de filtración para garantizar pureza.', 0.99, 200, 5, 'aquafina_500ml.jpg'),
('Agua Alcalina Essentia', 'Essentia', '1L', 'Agua alcalina con un pH de 9.5 para equilibrar la acidez del cuerpo y mejorar la hidratación.', 3.49, 150, 0, 'essentia_1L.jpg'),
('Agua de Manantial Fiji', 'Fiji', '1L', 'Agua de manantial extraída y embotellada en la isla de Viti Levu, en Fiji, famosa por su sabor suave.', 2.99, 120, 10, 'fiji_1L.jpg'),
('Agua Saborizada VitaminWater', 'VitaminWater', '500ml', 'Agua enriquecida con vitaminas y minerales esenciales, ideal para recuperar energía.', 1.79, 90, 15, 'vitaminwater_500ml.jpg'),
('Agua Artesiana Voss', 'Voss', '800ml', 'Agua artesiana pura extraída de acuíferos subterráneos de Noruega, conocida por su envase elegante.', 3.99, 70, 0, 'voss_800ml.jpg'),
('Agua Purificada Nestlé Pure Life', 'Nestlé Pure Life', '1.5L', 'Agua purificada de alta calidad, sometida a múltiples procesos de filtración.', 1.50, 180, 5, 'nestle_1.5L.jpg'),
('Agua con Gas San Pellegrino', 'San Pellegrino', '750ml', 'Agua mineral con gas natural, embotellada en las montañas italianas, famosa por su sabor y burbujas.', 2.89, 90, 0, 'sanpellegrino_750ml.jpg'),
('Agua de Coco VitaCoco', 'VitaCoco', '330ml', 'Agua de coco 100% natural, sin conservantes ni azúcares añadidos, perfecta para una hidratación refrescante.', 2.20, 60, 5, 'vitacoco_330ml.jpg');
*/

INSERT INTO Productos (nombre, marca, size, descripcion, precio, stock, descuento, url_imagen) VALUES
('BEZOYA', 'BEZOYA', '500ml', 'Agua mineral natural, pura y ligera, perfecta para mantenerte hidratado en cualquier momento.', 0.85, 100, NULL, 'bezoya.jpg'),
('LANJARON', 'LANJARON', '1L', 'Agua mineral de alta montaña, rica en minerales, ideal para un estilo de vida saludable.', 1.50, 100, NULL, 'lanjaron.webp'),
('AGUA FINA', 'AGUA FINA', '1.5L', 'Agua pura y cristalina, con un sabor suave que refresca y revitaliza.', 1.75, 100, NULL, 'aguafina.jpg'),
('AGUA PURA DE MAR', 'AGUA PURA DE MAR', '500ml', 'Agua del océano purificada, rica en minerales esenciales para un equilibrio perfecto.', 2.10, 100, NULL, 'aguapuramar.png'),
('AGUA SANA', 'AGUA SANA', '1.5L', 'Agua mineral saludable, ideal para una hidratación equilibrada y llena de frescura.', 1.95, 100, NULL, 'aguasana.jpg'),
('ARQUILLO AGUA MINI', 'ARQUILLO', '250ml', 'La mejor opción en tamaño mini, perfecta para llevar contigo a todas partes.', 0.70, 100, NULL, 'arquilloaguamini.jpg'),
('BONA FONT MINI', 'BONA FONT', '250ml', 'Agua mineral en formato compacto, ideal para acompañarte en el día a día.', 0.95, 100, NULL, 'bonafontmini.webp'),
('FONT VELLA', 'FONT VELLA', '500ml', 'Agua mineral natural de las fuentes más puras, refrescante y saludable.', 1.25, 100, NULL, 'fontvella.jpg'),
('LA SERRETA', 'LA SERRETA', '1L', 'Agua mineral natural, perfecta para una hidratación diaria equilibrada.', 1.10, 100, NULL, 'laserreta.jpg'),
('MONDARIZ', 'MONDARIZ', '500ml', 'Agua mineral de Galicia, con una pureza excepcional y un sabor fresco y natural.', 1.80, 100, NULL, 'mondariz.jpg'),
('PACK 6 LA SERRETA', 'LA SERRETA', '6x500ml', 'Pack de 6 botellas de agua mineral La Serreta, ideal para toda la familia.', 5.50, 100, NULL, 'packlaserreta.webp'),
('PACK 6 VILAS', 'VILAS', '6x500ml', 'Pack de 6 botellas de agua Vilas, perfecta para mantenerte hidratado durante toda la semana.', 4.75, 100, NULL, 'packvilas.jpg'),
('VITAL', 'VITAL', '500ml', 'Agua mineral pura y vital, ideal para acompañarte en cada momento del día.', 1.20, 100, NULL, 'vital.png');


INSERT INTO Categoriasproductos (id_producto, id_categoria) 
VALUES 
(1, 1),  -- Evian es Agua Mineral Natural
(2, 2),  -- Perrier es Agua con Gas
(3, 3),  -- Aquafina es Agua Purificada
(4, 4),  -- Essentia es Agua Alcalina
(5, 5),  -- Fiji es Agua de Manantial
(6, 6),  -- VitaminWater es Agua Saborizada
(7, 7),  -- Voss es Agua Artesiana
(8, 8),  -- Agua Destilada Premium
(9, 9),  -- VitaCoco es Agua de Coco
(10, 10);  -- SmartWater es Agua Electrolizada

INSERT INTO Pedidos (id_usuario, fecha_pedido, fecha_entrega, precio_total, estado, num_telefono_entrega, email_entrega, direccion_entrega, metodo_pago, comentarios_cliente, costo_envio, prioridad_envio)
VALUES 
(1, '2024-10-01 14:00:00', '2024-10-03 14:00:00', 25.99, 'En camino', '+34 600123456', 'carlos.garcia@correo.com', 'Avenida Siempre Viva, 742', 'Tarjeta', 'Por favor, entregar en la mañana.', 3.99, 'Alta'),
(2, '2024-09-28 10:30:00', '2024-09-30 09:00:00', 15.50, 'Entregado', '+34 600654321', 'marta.perez@correo.com', 'Calle Falsa, 123', 'PayPal', 'Dejar en la portería.', 2.50, 'Media'),
(3, '2024-10-02 18:00:00', '2024-10-04 16:00:00', 12.99, 'En preparación', '+34 601234567', 'javi.fernandez@correo.com', 'Calle del Olmo, 56', 'Tarjeta', NULL, 3.50, 'Baja'),
(4, '2024-09-20 08:15:00', '2024-09-22 13:30:00', 29.89, 'Entregado', '+34 602345678', 'lucia.martinez@correo.com', 'Paseo de la Castellana, 80', 'Transferencia', 'Entregar sin contacto.', 3.99, 'Alta'),
(5, '2024-09-18 12:45:00', '2024-09-20 15:00:00', 8.75, 'Entregado', '+34 603456789', 'pablo.sanchez@correo.com', 'Plaza Mayor, 2', 'Tarjeta', NULL, 2.99, 'Media'),
(6, '2024-10-01 16:30:00', '2024-10-03 12:00:00', 18.49, 'En camino', '+34 604567890', 'ana.gutierrez@correo.com', 'Calle Luna, 7', 'Tarjeta', NULL, 3.49, 'Alta'),
(7, '2024-09-25 09:00:00', '2024-09-27 14:30:00', 22.39, 'Entregado', '+34 605678901', 'david.lopez@correo.com', 'Calle Sol, 12', 'PayPal', 'Entregar en mano.', 3.99, 'Baja'),
(8, '2024-10-01 11:20:00', '2024-10-03 10:00:00', 13.69, 'En camino', '+34 606789012', 'laura.garcia@correo.com', 'Calle Rosa, 28', 'Tarjeta', NULL, 3.50, 'Media'),
(9, '2024-09-28 14:45:00', '2024-09-30 09:45:00', 26.99, 'Entregado', '+34 607890123', 'raul.gomez@correo.com', 'Calle Verde, 3', 'Transferencia', 'Dejar en la entrada.', 4.50, 'Alta'),
(10, '2024-09-22 07:30:00', '2024-09-24 11:00:00', 9.50, 'Entregado', '+34 608901234', 'sonia.hernandez@correo.com', 'Calle Azul, 6', 'Tarjeta', NULL, 2.50, 'Baja');


INSERT INTO Linea_pedidos (id_pedido, cantidad, id_producto, precio_unitario, precio_total) 
VALUES 
(1, 5, 1, 1.99, 9.95),  -- Pedido de 5 botellas de Evian
(2, 3, 2, 2.50, 7.50),  -- Pedido de 3 botellas de Perrier
(3, 10, 3, 0.99, 9.90),  -- Pedido de 10 botellas de Aquafina
(4, 4, 4, 3.49, 13.96);



SELECT * FROM Usuarios;
SELECT * FROM Linea_pedidos;
SELECT * FROM Pedidos;
SELECT * FROM Productos;
SELECT * FROM Categorias;
