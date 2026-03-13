-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2026 a las 20:23:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `distribuidora_frami`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id_admin` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id_admin`, `created_at`, `nombre`, `contrasenia`, `rol`) VALUES
(1, '2026-02-16 14:09:31', 'adm_frami', 'frami 2077', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(255) NOT NULL DEFAULT '30'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `created_at`, `nombre`) VALUES
(8, '2026-01-31 01:06:46', 'salchichas'),
(9, '2026-01-31 01:06:46', 'hamburguesas'),
(10, '2026-01-31 01:06:46', 'pan_panchos'),
(11, '2026-01-31 01:06:46', 'pan_hamburguesas'),
(12, '2026-01-31 01:06:46', 'bebidas'),
(13, '2026-01-31 01:06:46', 'aderezos'),
(14, '2026-02-17 17:28:06', 'Empanadas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `rol` tinyint(1) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `dni` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(35) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `postal` varchar(10) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `usuario`, `contrasena`, `rol`, `nombre`, `apellido`, `dni`, `correo`, `telefono`, `direccion`, `localidad`, `postal`, `activo`, `imagen`) VALUES
(1, 'Gabriel', 'gaby', 0, 'Gabriel', 'Acuña', 29475986, 'gabiacu@gmail.com', '01147293815', 'Rodolfo López 297', 'Quilmes Oeste', '1878', 1, '/distribuidora-frami/assets/profile/elbana.jpg'),
(2, 'Toby', 'tobydev', 0, 'Tobías', 'Rostro', 47231899, 'tobirostro132@gmail.com', '01170580790', 'Conesa 320', 'Quilmes', '1878', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL,
  `dia_semana` varchar(20) NOT NULL,
  `hora_apertura` time NOT NULL,
  `hora_cierre` time NOT NULL,
  `abierto` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_sucursal` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `estado` enum('pendiente','en_preparacion','en_camino','entregado') NOT NULL,
  `precio` int(11) NOT NULL,
  `moneda` varchar(5) NOT NULL DEFAULT '$',
  `fecha_ingreso` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_entrega` timestamp NULL DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `id_sucursal`, `codigo`, `clave`, `estado`, `precio`, `moneda`, `fecha_ingreso`, `fecha_entrega`, `observaciones`) VALUES
(24, 1, 3, 0, '', 'entregado', 298, '$', '2026-02-12 18:31:08', NULL, NULL),
(25, 1, 3, 0, '', 'pendiente', 76, '$', '2026-02-17 16:59:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(255) NOT NULL,
  `peso_gr` bigint(20) DEFAULT NULL,
  `precio` text NOT NULL,
  `stock` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_vencimiento` date DEFAULT NULL,
  `ruta` text DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `destacado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `created_at`, `nombre`, `peso_gr`, `precio`, `stock`, `fecha_vencimiento`, `ruta`, `id_categoria`, `cantidad`, `descripcion`, `activo`, `destacado`) VALUES
(2, '2026-01-31 01:08:19', 'Hamburguesas Unión Ganadera', NULL, '79.000', 1, NULL, '/distribuidora-frami/assets/productos/hamburguesas_union_40.jpg', 9, 40, 'Carne de hamburguesas Unión ganadera, (CONSULTAR STOCK)', 1, 1),
(3, '2026-01-31 02:05:30', 'Hamburguesas Finexcor + Pan Largo', NULL, '76.000', 1, NULL, '/distribuidora-frami/assets/productos/pan_finexcor_60.jpg', 11, 60, '60 Hamburguesas + Pan Fargo Semilla', 1, 0),
(4, '2026-01-31 02:28:49', 'Cheddar Milkout', 0, '35.000', 1, '0000-00-00', '/distribuidora-frami/assets/productos/cheddar_milkout.jpg', 13, 4, '4 Bloques por Caja192 Fetas por bloque', 1, 0),
(8, '2026-02-01 00:16:29', 'LA CONCHA DE LA LORA', 0, '83.000', 1, '0000-00-00', 'elbana.jpg', 8, 0, 'ANDATE A LA RE PUTA QUE TE PARIÓ', 1, 0),
(13, '2026-02-04 00:14:58', 'Gigantes 100% Carne', 0, '64.000', 0, '0000-00-00', '/distribuidora-frami/assets/productos/gigantes_carne.jpg', 9, 0, '40 Hamburguesas', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_pedidos`
--

CREATE TABLE `productos_pedidos` (
  `id_componente` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `cantidad` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_pedidos`
--

INSERT INTO `productos_pedidos` (`id_componente`, `id_pedido`, `id_producto`, `nombre`, `cantidad`) VALUES
(5, 24, 4, '', 2),
(6, 24, 3, '', 3),
(7, 25, 3, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales_clientes`
--

CREATE TABLE `sucursales_clientes` (
  `id_sucursal` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nombre_sucursal` varchar(50) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `inicio_entregas` time NOT NULL,
  `fin_entregas` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursales_clientes`
--

INSERT INTO `sucursales_clientes` (`id_sucursal`, `id_cliente`, `nombre_sucursal`, `direccion`, `localidad`, `inicio_entregas`, `fin_entregas`) VALUES
(3, 1, 'Hamburguesas Gaby', 'Av. San Martín 29', 'Bernal', '08:30:00', '19:00:00'),
(5, 1, 'Panchería Gaby', 'Av. Zapiola 749', 'Bernal Oeste', '10:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `rol` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `contrasena`, `rol`) VALUES
(1, 'adm_frami', 'frami_2077', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `usuario` (`usuario`,`contrasena`,`dni`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_cliente` (`id_cliente`),
  ADD KEY `direccion` (`id_sucursal`),
  ADD KEY `sucursal` (`id_sucursal`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `productos_pedidos`
--
ALTER TABLE `productos_pedidos`
  ADD PRIMARY KEY (`id_componente`),
  ADD KEY `id_pedido` (`id_pedido`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `sucursales_clientes`
--
ALTER TABLE `sucursales_clientes`
  ADD PRIMARY KEY (`id_sucursal`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `direccion` (`direccion`,`localidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `productos_pedidos`
--
ALTER TABLE `productos_pedidos`
  MODIFY `id_componente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sucursales_clientes`
--
ALTER TABLE `sucursales_clientes`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales_clientes` (`id_sucursal`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `productos_pedidos`
--
ALTER TABLE `productos_pedidos`
  ADD CONSTRAINT `productos_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `productos_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `sucursales_clientes`
--
ALTER TABLE `sucursales_clientes`
  ADD CONSTRAINT `sucursales_clientes_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;