-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2024 a las 08:55:34
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `puntodigital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arqueo`
--

CREATE TABLE `arqueo` (
  `id_arqueo` int(11) NOT NULL,
  `empleado` varchar(9) NOT NULL,
  `fecha_arqueo` date NOT NULL,
  `monto_esperado` float NOT NULL,
  `monto_real` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`) VALUES
(18, 'Papel Bond'),
(19, 'Electronicos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `dui_cliente` varchar(10) NOT NULL,
  `nombre_c` varchar(150) NOT NULL,
  `apellido_c` varchar(150) NOT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono_c` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`dui_cliente`, `nombre_c`, `apellido_c`, `direccion`, `telefono_c`) VALUES
('05389469-7', 'Karina Alejandra', 'Paz Acevedo', 'Soyapango, San Salvador', '6578-4210'),
('05789664-8', 'Julio Alberto', 'Martinez Rivera', 'Apastepeque, San Vicente', '8697-5012'),
('06984566-8', 'Ernesto Alexander', 'Cruz Guevara', 'Santo Domingo, San Vicente', '8890-2114'),
('07548993-7', 'Erika Carolina', 'Juarez Vasquez', 'Cojutepeque, Cuscatlan', '6659-2812'),
('1212', 'jorge', 'Antonio', 'ahi', '2020-3020');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `fecha_c` datetime NOT NULL,
  `gerente` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_mantenimiento`
--

CREATE TABLE `control_mantenimiento` (
  `id_cmantenimiento` int(11) NOT NULL,
  `fecha_m` date NOT NULL,
  `detalles_m` varchar(500) NOT NULL,
  `estado_m` varchar(15) NOT NULL,
  `precio_m` float NOT NULL,
  `equipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `control_mantenimiento`
--

INSERT INTO `control_mantenimiento` (`id_cmantenimiento`, `fecha_m`, `detalles_m`, `estado_m`, `precio_m`, `equipo`) VALUES
(48, '0000-00-00', '', 'En proceso', 0, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `id_detallecompra` int(11) NOT NULL,
  `compra` int(11) NOT NULL,
  `producto` varchar(16) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleimpresion`
--

CREATE TABLE `detalleimpresion` (
  `id_detalleimpresion` bigint(20) NOT NULL,
  `producto` varchar(16) NOT NULL,
  `tamanio` varchar(255) NOT NULL,
  `grosor` int(11) NOT NULL,
  `detalles` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `id_detalleventa` int(11) NOT NULL,
  `venta` int(11) NOT NULL,
  `producto` varchar(16) NOT NULL,
  `cantidad` varchar(255) DEFAULT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL,
  `fecha_r` date NOT NULL,
  `marca` varchar(100) NOT NULL,
  `procesador` varchar(100) NOT NULL,
  `ram` varchar(150) NOT NULL,
  `almacenamiento` varchar(150) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `dui_cliente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id_equipo`, `fecha_r`, `marca`, `procesador`, `ram`, `almacenamiento`, `observaciones`, `fecha_entrega`, `dui_cliente`) VALUES
(1, '2023-10-02', 'shitsuba', 'celeron i3', '12', '900ssd', 'clean af', '2023-10-10', '1212'),
(2, '2023-10-03', 'TOSHIT', 'KGADA', '4', '200 HDD', 'SHIT', '2023-10-04', '1212'),
(3, '0012-12-13', '123', '123', '123', '312', '312', '3121-03-12', '1212'),
(16, '2023-12-28', 'HP Pavilion Dm5', 'Intel Core i5 12th Gen', '8 GB ddr4 1900Mhz', '500 GB M.2', 'Falla en pantalla ', '1973-03-29', '05389469-7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

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
  `estado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`dui_persona`, `nombre`, `apellido`, `fecha_nacimiento`, `direccion`, `rol`, `telefono1`, `telefono2`, `fecha_contratacion`, `estado`) VALUES
('08799798-8', 'Carlos Alberto', 'Palacios Menjivar', '1996-06-12', 'Santo Domingo, San Vicente, Colonia Santa Maria', 15, '6908-9304', '7034-9621', '2021-11-18', b'1'),
('09764894-7', 'Ricardo Ayala', 'Castillo Escobar', '2002-02-13', 'll', 13, '7423-9654', '8639-5142', '2021-01-13', b'1'),
('09889877-7', 'Elizabeth Abigail ', 'Zavala Rivas', '1998-11-24', 'Cojutepeque, Cuscatlan', 14, '8654-3121', '8961-3103', '2022-06-30', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo_producto` varchar(16) NOT NULL,
  `nombre_p` varchar(200) NOT NULL,
  `marca` varchar(200) NOT NULL,
  `precio` double(10,2) NOT NULL,
  `categoria` int(11) NOT NULL,
  `proveedor` int(11) NOT NULL,
  `imagen_p` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo_producto`, `nombre_p`, `marca`, `precio`, `categoria`, `proveedor`, `imagen_p`, `stock`) VALUES
('0001228122023002', 'Prueba', '12', 40.00, 18, 29, 'upload/658db75226497.png', 8),
('0025028122023001', 'Papel Bond Carta', '2.50', 12.00, 18, 30, 'upload/658d3194753ed.png', 0),
('0050028122023003', 'USB kingston', 'Kingston', 5.00, 19, 29, 'upload/658dbb346d7ba.png', 12),
('0056005012024005', 'Usb', 'HP', 5.60, 19, 29, 'upload/65989469c2b05.png', 12),
('0099005012024005', 'kjkjkjhkjhkjhk', 'ooo', 9.90, 19, 29, 'upload/6598e34c878cc.jpg', 0),
('0125003012024004', 'Ejemplo', 'De que funciona', 12.50, 18, 29, 'upload/6596287a6601f.png', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_p` varchar(150) NOT NULL,
  `direccion` varchar(300) NOT NULL,
  `telefono` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_p`, `direccion`, `telefono`) VALUES
(29, 'Etouch El Salvador', 'Avenida Juan Pablo II', '2392-8058'),
(30, 'Punto Digital', 'Cojutepeque, Cuscatlan', '9899-8999');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(13, 'Administrador'),
(14, 'Soporte'),
(15, 'Utileria y papeleria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_u` varchar(150) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `correo` varchar(75) NOT NULL,
  `dui_persona` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_u`, `contrasenia`, `correo`, `dui_persona`) VALUES
(5, 'Usuario1', '$2y$10$B4iYwBgvnjz4fajfBYR4kuskRnQEQpd9bdmH7l4EkAsK7YTBB0fCu', 'correo@gmail.com', '08799798-8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `cliente` varchar(9) NOT NULL,
  `empleado` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arqueo`
--
ALTER TABLE `arqueo`
  ADD PRIMARY KEY (`id_arqueo`),
  ADD KEY `arqueoempleado` (`empleado`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`dui_cliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`) USING BTREE,
  ADD KEY `compragerente` (`gerente`);

--
-- Indices de la tabla `control_mantenimiento`
--
ALTER TABLE `control_mantenimiento`
  ADD PRIMARY KEY (`id_cmantenimiento`),
  ADD KEY `mantenimientoequipo` (`equipo`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD PRIMARY KEY (`id_detallecompra`),
  ADD KEY `detalleccompra` (`compra`),
  ADD KEY `detallecproducto` (`producto`);

--
-- Indices de la tabla `detalleimpresion`
--
ALTER TABLE `detalleimpresion`
  ADD PRIMARY KEY (`id_detalleimpresion`),
  ADD KEY `pp` (`producto`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`id_detalleventa`),
  ADD KEY `detallevventa` (`venta`),
  ADD KEY `detallevproducto` (`producto`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `equipocliente` (`dui_cliente`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`dui_persona`),
  ADD KEY `rol` (`rol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo_producto`),
  ADD KEY `productocategoria` (`categoria`),
  ADD KEY `productoproveedor` (`proveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`),
  ADD KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `usuariopersona` (`dui_persona`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `ventacliente` (`cliente`),
  ADD KEY `ventaempleado` (`empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `control_mantenimiento`
--
ALTER TABLE `control_mantenimiento`
  MODIFY `id_cmantenimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arqueo`
--
ALTER TABLE `arqueo`
  ADD CONSTRAINT `arqueoempleado` FOREIGN KEY (`empleado`) REFERENCES `persona` (`dui_persona`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compragerente` FOREIGN KEY (`gerente`) REFERENCES `persona` (`dui_persona`);

--
-- Filtros para la tabla `control_mantenimiento`
--
ALTER TABLE `control_mantenimiento`
  ADD CONSTRAINT `mantenimientoequipo` FOREIGN KEY (`equipo`) REFERENCES `equipo` (`id_equipo`);

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `detalleccompra` FOREIGN KEY (`compra`) REFERENCES `compras` (`id_compra`),
  ADD CONSTRAINT `detallecproducto` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo_producto`);

--
-- Filtros para la tabla `detalleimpresion`
--
ALTER TABLE `detalleimpresion`
  ADD CONSTRAINT `pp` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo_producto`);

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `detallevproducto` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo_producto`),
  ADD CONSTRAINT `detallevventa` FOREIGN KEY (`venta`) REFERENCES `venta` (`id_venta`);

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`dui_cliente`) REFERENCES `cliente` (`dui_cliente`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `productocategoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `productoproveedor` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuariopersona` FOREIGN KEY (`dui_persona`) REFERENCES `persona` (`dui_persona`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `ventacliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`dui_cliente`),
  ADD CONSTRAINT `ventaempleado` FOREIGN KEY (`empleado`) REFERENCES `persona` (`dui_persona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
