-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2025 a las 04:46:48
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
-- Base de datos: `datos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asientos`
--

CREATE TABLE `asientos` (
  `id` int(11) NOT NULL,
  `numero_asiento` varchar(10) DEFAULT NULL,
  `estado` enum('disponible','vendido') DEFAULT 'disponible',
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asientos`
--

INSERT INTO `asientos` (`id`, `numero_asiento`, `estado`, `precio`) VALUES
(1, 'A1', 'disponible', 100.00),
(2, 'A2', 'disponible', 1.00),
(3, 'A3', 'vendido', 0.00),
(4, 'A4', 'vendido', 0.00),
(5, 'A5', 'vendido', 0.00),
(6, 'A6', 'vendido', 0.00),
(7, 'A7', 'vendido', 0.00),
(8, 'A8', 'disponible', 0.00),
(9, 'A9', 'disponible', 0.00),
(10, 'A10', 'disponible', 0.00),
(11, 'B1', 'disponible', 0.00),
(12, 'B2', 'disponible', 0.00),
(13, 'B3', 'disponible', 0.00),
(14, 'B4', 'disponible', 0.00),
(15, 'B5', 'disponible', 0.00),
(16, 'B6', 'disponible', 0.00),
(17, 'B7', 'disponible', 0.00),
(18, 'B8', 'disponible', 0.00),
(19, 'B9', 'disponible', 0.00),
(20, 'B10', 'disponible', 0.00),
(21, 'C1', 'disponible', 0.00),
(22, 'C2', 'disponible', 0.00),
(23, 'C3', 'disponible', 0.00),
(24, 'C4', 'disponible', 0.00),
(25, 'C5', 'disponible', 0.00),
(26, 'C6', 'disponible', 0.00),
(27, 'C7', 'disponible', 0.00),
(28, 'C8', 'disponible', 0.00),
(29, 'C9', 'disponible', 0.00),
(30, 'C10', 'disponible', 0.00),
(31, 'D1', 'disponible', 100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla`
--

CREATE TABLE `tabla` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `tel` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabla`
--

INSERT INTO `tabla` (`id`, `nombre`, `correo`, `tel`) VALUES
(0, 'Erick', 'erick.gabriel.perez@gmail.com', '8714534825');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `registrado` tinyint(1) DEFAULT 1,
  `rol` enum('cliente','admin') DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contraseña`, `registrado`, `rol`) VALUES
(11, 'Gabriel', 'erick20031@live.com.mx', '$2y$10$zepyC/8sslrGBM.xOXD4TuuxWcfGmrzkPxt650uX.9zg4UkDegt0m', 1, 'admin'),
(12, 'Erick', 'erick.gabriel.perez@gmail.com', '$2y$10$zM8MmbwPoLnwe3H9AtceZOLfZ82BI.QqlxHNPrcSI9kB2NaMUaTBK', 1, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `asiento_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asientos`
--
ALTER TABLE `asientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_asiento` (`numero_asiento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `asiento_id` (`asiento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asientos`
--
ALTER TABLE `asientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`asiento_id`) REFERENCES `asientos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
