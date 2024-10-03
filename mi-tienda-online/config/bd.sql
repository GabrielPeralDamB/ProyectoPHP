/*Create database tienda;*/

use tienda;

-- Deshabilitar las restricciones de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- Eliminar tablas en el orden correcto
DROP TABLE IF EXISTS Linea_pedidos;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS Pedidos;
DROP TABLE IF EXISTS Usuarios;
DROP TABLE IF EXISTS Categorias;
DROP TABLE IF EXISTS Valoraciones;
DROP TABLE IF EXISTS Categoriasproductos;

-- Habilitar nuevamente las restricciones de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;

drop table if exists Usuarios;
create table Usuarios(
id bigint auto_increment primary key,
nombre varchar(255) not null,
apellidos varchar(255) not null,
email varchar(255) not null unique,
tipo_usuario varchar(255) not null,
dni varchar(255) not null unique,
direccion vaRCHAR(500) NOT NULL, 
telefono varchar(255) not null unique,
fecha_nacimiento DATE not null,
password VARCHAR(255) not null,
cuenta_operativa boolean not null);

drop table if exists Pedidos;
drop table if exists Pedidos;
create table Pedidos(
id bigint auto_increment primary key,
id_usuario bigint not null,
fecha_pedido datetime not null,
fecha_entrega datetime not null,
precio_total DECIMAL(10,2) not null,
estado VARCHAR(255) not null,
num_telefono_entrega VARCHAR(255)not null,
email_entrega VARCHAR(500)not null,
direccion_entrega VARCHAR(500) not null,
metodo_pago VARCHAR(255) not null,
comentarios_cliente TEXT,
costo_envio DECIMAL(10,2) NOT NULL,
prioridad_envio VARCHAR(255),
FOREIGN KEY (id_usuario) REFERENCES Usuarios(id));

drop table if exists Categorias;
create table Categorias(
id bigint auto_increment primary key,
nombre varchar(500) not null,
descripcion TEXT);


drop table if exists Productos;
create table Productos(
id bigint auto_increment primary key,
nombre varchar(500) not null,
marca varchar(255),
size varchar(255),
descripcion text not null,
precio DECIMAL(10,2) not null,
stock int not null,
descuento int,
url_imagen TEXT);

DROP TABLE IF EXISTS CategoriasProductos;

CREATE TABLE CategoriasProductos (
    id_producto BIGINT,
    id_categoria BIGINT NOT NULL,
    PRIMARY KEY (id_producto, id_categoria),
    FOREIGN KEY (id_producto) REFERENCES Productos(id),
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id)
);

/*-- Asegúrate de que cada producto tiene al menos una categoría
ALTER TABLE productos
ADD CONSTRAINT fk_categoria_producto
FOREIGN KEY (id)
REFERENCES categoriasproductos(id_producto);*/



drop table if exists Linea_Pedidos;
create table Linea_Pedidos(
id bigint auto_increment primary key,
id_pedido bigint not null,
cantidad int not null,
id_producto bigint not null,
precio_unitario Decimal(10,2) not null,
precio_total Decimal(10,2) not null,
FOREIGN KEY (id_pedido) REFERENCES Pedidos(id),
FOREIGN KEY (id_producto) REFERENCES Productos(id)) ;


drop table if exists Valoraciones;
create table valoraciones(
	id bigint primary key auto_increment not null,
	id_producto bigint not null,
    id_usuario bigint not null,
    descripcion text,
    num_valoracion int not null,
    FOREIGN KEY (id_producto) REFERENCES Productos(id),
	FOREIGN KEY (id_usuario) REFERENCES Usuarios(id)
);




