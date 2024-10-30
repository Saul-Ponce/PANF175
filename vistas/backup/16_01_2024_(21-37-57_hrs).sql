SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS puntodigital;

USE puntodigital;

DROP TABLE IF EXISTS arqueo;

CREATE TABLE `arqueo` (
  `id_arqueo` int(11) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(10) NOT NULL,
  `fecha_arqueo` date NOT NULL,
  `monto_esperado` float NOT NULL,
  `monto_real` float NOT NULL,
  PRIMARY KEY (`id_arqueo`),
  KEY `arqueoempleado` (`empleado`),
  CONSTRAINT `arqueoempleado` FOREIGN KEY (`empleado`) REFERENCES `persona` (`dui_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS categoria;

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO categoria VALUES("5","Categoria 1");
INSERT INTO categoria VALUES("6","Categoria 2");
INSERT INTO categoria VALUES("7","Categoria 3");



DROP TABLE IF EXISTS cliente;

CREATE TABLE `cliente` (
  `dui_cliente` varchar(10) NOT NULL,
  `nombre_c` varchar(150) NOT NULL,
  `apellido_c` varchar(150) NOT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono_c` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`dui_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO cliente VALUES("05389469-7","Karina Alejandra","Paz Acevedo","Soyapango, San Salvador","6578-4210");
INSERT INTO cliente VALUES("05789664-8","Julio Alberto","Martinez Rivera","Apastepeque, San Vicente","8697-5012");
INSERT INTO cliente VALUES("06984566-8","Ernesto Alexander","Cruz Guevara","Santo Domingo, San Vicente","8890-2114");
INSERT INTO cliente VALUES("07548993-7","Erika Carolina","Juarez Vasquez","Cojutepeque, Cuscatlan","6659-2812");
INSERT INTO cliente VALUES("1212","jorge","Antonio","ahi","2020-3020");



DROP TABLE IF EXISTS compras;

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_c` datetime DEFAULT NULL,
  `gerente` varchar(10) DEFAULT NULL,
  `total` float DEFAULT NULL,
  PRIMARY KEY (`id_compra`) USING BTREE,
  KEY `compragerente` (`gerente`),
  CONSTRAINT `compra_fk` FOREIGN KEY (`gerente`) REFERENCES `persona` (`dui_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

INSERT INTO compras VALUES("1","2023-12-31 04:37:55","09764894-7","2");
INSERT INTO compras VALUES("3","2024-01-15 00:00:00","08799798-8","78.75");
INSERT INTO compras VALUES("4","2023-02-15 05:20:54","08799798-8","43");
INSERT INTO compras VALUES("5","2024-06-19 05:21:14","08799798-8","34");
INSERT INTO compras VALUES("6","2024-01-25 05:21:33","09764894-7","55");
INSERT INTO compras VALUES("7","2024-11-28 05:21:48","09877848-8","45");
INSERT INTO compras VALUES("8","2024-01-15 00:00:00","08799798-8","6.5");
INSERT INTO compras VALUES("9","2024-01-16 00:00:00","08799798-8","5.2");
INSERT INTO compras VALUES("10","2024-01-16 00:00:00","08799798-8","8.5");
INSERT INTO compras VALUES("11","2024-01-16 00:00:00","08799798-8","8.5");



DROP TABLE IF EXISTS control_mantenimiento;

CREATE TABLE `control_mantenimiento` (
  `id_cmantenimiento` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_m` date NOT NULL,
  `detalles_m` varchar(500) NOT NULL,
  `estado_m` varchar(15) NOT NULL,
  `precio_m` float NOT NULL,
  `equipo` int(11) NOT NULL,
  PRIMARY KEY (`id_cmantenimiento`),
  KEY `mantenimientoequipo` (`equipo`),
  CONSTRAINT `mantenimientoequipo` FOREIGN KEY (`equipo`) REFERENCES `equipo` (`id_equipo`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

INSERT INTO control_mantenimiento VALUES("48","2024-01-15","no sirve la wea pinches shitsuba no alen pa ni madres","Finalizado","200","1");



DROP TABLE IF EXISTS detallecompra;

CREATE TABLE `detallecompra` (
  `id_detallecompra` int(11) NOT NULL AUTO_INCREMENT,
  `compra` int(11) NOT NULL,
  `producto` varchar(16) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_detallecompra`),
  KEY `detalleccompra` (`compra`),
  KEY `detallecproducto` (`producto`),
  CONSTRAINT `detalleccompra` FOREIGN KEY (`compra`) REFERENCES `compras` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detallecproducto` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO detallecompra VALUES("2","3","0085007112023001","6");
INSERT INTO detallecompra VALUES("3","3","0085007112023002","3");
INSERT INTO detallecompra VALUES("4","8","0065015012024003","1");
INSERT INTO detallecompra VALUES("5","9","0075006443929332","1");
INSERT INTO detallecompra VALUES("6","10","0085007112023001","1");
INSERT INTO detallecompra VALUES("7","11","0085007112023001","1");



DROP TABLE IF EXISTS detalleimpresion;

CREATE TABLE `detalleimpresion` (
  `id_detalleimpresion` bigint(20) NOT NULL,
  `producto` varchar(16) NOT NULL,
  `tamanio` varchar(255) NOT NULL,
  `grosor` int(11) NOT NULL,
  `detalles` varchar(300) NOT NULL,
  PRIMARY KEY (`id_detalleimpresion`),
  KEY `pp` (`producto`),
  CONSTRAINT `pp` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO detalleimpresion VALUES("0","0065015012024003","123","2","3");



DROP TABLE IF EXISTS detalleventa;

CREATE TABLE `detalleventa` (
  `id_detalleventa` int(11) NOT NULL AUTO_INCREMENT,
  `venta` int(11) NOT NULL,
  `producto` varchar(16) NOT NULL,
  `cantidad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_detalleventa`),
  KEY `detallevventa` (`venta`),
  KEY `detallevproducto` (`producto`),
  CONSTRAINT `detallevproducto` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo_producto`),
  CONSTRAINT `detallevventa` FOREIGN KEY (`venta`) REFERENCES `venta` (`id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

INSERT INTO detalleventa VALUES("1","13","0085007112023002","2");
INSERT INTO detalleventa VALUES("2","15","0085007112023002","2");
INSERT INTO detalleventa VALUES("3","15","0085007112023001","3");
INSERT INTO detalleventa VALUES("4","16","0075006443929332","2");
INSERT INTO detalleventa VALUES("5","16","0085007112023001","3");
INSERT INTO detalleventa VALUES("6","16","0085007112023002","5");
INSERT INTO detalleventa VALUES("7","17","0075006443929332","2");
INSERT INTO detalleventa VALUES("8","18","0075006443929332","6");
INSERT INTO detalleventa VALUES("9","18","0085007112023001","2");
INSERT INTO detalleventa VALUES("10","27","0065015012024003","2");
INSERT INTO detalleventa VALUES("11","28","0075006443929332","1");
INSERT INTO detalleventa VALUES("12","29","0085007112023001","1");



DROP TABLE IF EXISTS equipo;

CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_r` date NOT NULL,
  `marca` varchar(100) NOT NULL,
  `procesador` varchar(100) NOT NULL,
  `ram` varchar(150) NOT NULL,
  `almacenamiento` varchar(150) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `dui_cliente` varchar(10) NOT NULL,
  PRIMARY KEY (`id_equipo`),
  KEY `equipocliente` (`dui_cliente`),
  CONSTRAINT `fk_cliente` FOREIGN KEY (`dui_cliente`) REFERENCES `cliente` (`dui_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

INSERT INTO equipo VALUES("1","2023-10-02","shitsuba","celeron i3","12","900ssd","clean af","2023-10-10","1212");
INSERT INTO equipo VALUES("2","2023-10-03","TOSHIT","KGADA","4","200 HDD","SHIT","2023-10-04","1212");
INSERT INTO equipo VALUES("3","0012-12-13","123","123","123","312","312","3121-03-12","1212");



DROP TABLE IF EXISTS persona;

CREATE TABLE `persona` (
  `dui_persona` varchar(10) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(200) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `telefono1` varchar(9) DEFAULT NULL,
  `telefono2` varchar(9) DEFAULT NULL,
  `fecha_contratacion` date DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`dui_persona`),
  KEY `rol` (`rol`),
  CONSTRAINT `fk_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO persona VALUES("08799798-8","Carlos Alberto","Palacios Menjivar","1996-06-12","Santo Domingo, San Vicente, Colonia Santa Maria","15","6908-9304","7034-9621","2021-11-18","1");
INSERT INTO persona VALUES("09764894-7","Ricardo Ayala","Castillo Escobar","2002-02-13","Cuscatlan, Cojutepeque","14","7423-9654","8639-5142","2021-01-13","1");
INSERT INTO persona VALUES("09877848-8","Vanessa Fernanda","Marisol Serrano","1999-01-31","Colonia Nueva Concepcion, San Vicente","13","6987-3613","6312-8432","2020-03-12","1");
INSERT INTO persona VALUES("09889877-7","Elizabeth Abigail ","Zavala Rivas","1998-11-24","Cojutepeque, Cuscatlan","14","8654-3121","8961-3103","2022-06-30","1");
INSERT INTO persona VALUES("33333333-3","dasdasda","adasda","2006-01-09","Su casa","13","1111-1111","1111-1111","2024-01-15","1");



DROP TABLE IF EXISTS producto;

CREATE TABLE `producto` (
  `codigo_producto` varchar(16) NOT NULL,
  `nombre_p` varchar(200) NOT NULL,
  `marca` varchar(200) NOT NULL,
  `precio` double(10,2) NOT NULL,
  `categoria` int(11) NOT NULL,
  `proveedor` int(11) NOT NULL,
  `imagen_p` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`codigo_producto`),
  KEY `productocategoria` (`categoria`),
  KEY `productoproveedor` (`proveedor`),
  CONSTRAINT `productocategoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id_categoria`),
  CONSTRAINT `productoproveedor` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO producto VALUES("0065015012024003","Producto de Prueba","Una marca","6.50","6","13","upload/65a58070d73ee.png","10");
INSERT INTO producto VALUES("0075006443929332","product3","Np","5.20","5","13","","31");
INSERT INTO producto VALUES("0085007112023001","Nuevo producto","Nueva Marca","8.50","5","13","upload/654ac96cf2579.png","2");
INSERT INTO producto VALUES("0085007112023002","Producto2","Yes","9.25","5","13","","25");



DROP TABLE IF EXISTS proveedor;

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_p` varchar(150) NOT NULL,
  `direccion` varchar(300) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

INSERT INTO proveedor VALUES("13","Proveedor 1","Direccion Prueba","5486-3259");
INSERT INTO proveedor VALUES("14","Proveedor 2","Direccion Prueba 2","6325-2100");



DROP TABLE IF EXISTS rol;

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rol`),
  KEY `nombre_rol` (`nombre_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

INSERT INTO rol VALUES("16","231");
INSERT INTO rol VALUES("13","Administracion");
INSERT INTO rol VALUES("14","Soporte");
INSERT INTO rol VALUES("15","Utileria y papeleria");



DROP TABLE IF EXISTS usuario;

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_u` varchar(150) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `correo` varchar(75) NOT NULL,
  `dui_persona` varchar(10) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `usuariopersona` (`dui_persona`),
  CONSTRAINT `usuariopersona` FOREIGN KEY (`dui_persona`) REFERENCES `persona` (`dui_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuario VALUES("5","Usuario1","$2y$10$B4iYwBgvnjz4fajfBYR4kuskRnQEQpd9bdmH7l4EkAsK7YTBB0fCu","correo@gmail.com","08799798-8");
INSERT INTO usuario VALUES("6","Usuario2","$2y$10$tTv/3kFqdlhmGGZAQzveteU.V6qjDSQA.5JcdeugB4HWVLORWXKH2","correo2@gmail.com","09764894-7");



DROP TABLE IF EXISTS venta;

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_venta` date NOT NULL,
  `cliente` varchar(10) NOT NULL,
  `empleado` varchar(10) DEFAULT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `ventacliente` (`cliente`),
  KEY `ventaempleado` (`empleado`),
  CONSTRAINT `ventacliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`dui_cliente`),
  CONSTRAINT `ventaempleado` FOREIGN KEY (`empleado`) REFERENCES `persona` (`dui_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

INSERT INTO venta VALUES("1","2023-11-09","05389469-7","08799798-8","20");
INSERT INTO venta VALUES("9","0000-00-00","05389469-7","","20");
INSERT INTO venta VALUES("10","2023-11-09","05389469-7","","17");
INSERT INTO venta VALUES("11","2023-11-09","05389469-7","","26.25");
INSERT INTO venta VALUES("12","2023-11-09","05389469-7","","52.5");
INSERT INTO venta VALUES("13","2023-11-09","05789664-8","","35.5");
INSERT INTO venta VALUES("14","2023-11-09","05389469-7","","26.25");
INSERT INTO venta VALUES("15","2023-11-09","05389469-7","","44");
INSERT INTO venta VALUES("16","2023-11-09","05389469-7","","82.15");
INSERT INTO venta VALUES("17","2024-01-15","05789664-8","08799798-8","10.4");
INSERT INTO venta VALUES("18","2024-01-15","05389469-7","08799798-8","48.2");
INSERT INTO venta VALUES("19","2024-01-15","05389469-7","08799798-8","42");
INSERT INTO venta VALUES("27","2024-01-15","05389469-7","08799798-8","13");
INSERT INTO venta VALUES("28","2024-01-16","05789664-8","08799798-8","5.2");
INSERT INTO venta VALUES("29","2024-01-16","05789664-8","08799798-8","8.5");



SET FOREIGN_KEY_CHECKS=1;