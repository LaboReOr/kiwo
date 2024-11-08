-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2024 a las 00:10:03
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
-- Base de datos: `kiwo`
--
CREATE DATABASE IF NOT EXISTS `kiwo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kiwo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `idColor` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`idColor`, `nombre`) VALUES
(1, 'Rojo'),
(2, 'Azul'),
(3, 'Verde'),
(4, 'Amarillo'),
(5, 'Negro'),
(6, 'Blanco'),
(7, 'Gris'),
(8, 'Rosa'),
(9, 'Marrón'),
(10, 'Morado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juguete`
--

CREATE TABLE `juguete` (
  `idJuguete` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `color` varchar(45) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `edad` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `oferta` int(11) DEFAULT NULL,
  `descripcion` varchar(1020) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ropa`
--

CREATE TABLE `ropa` (
  `idRopa` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `material` varchar(45) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `genero` varchar(45) NOT NULL,
  `precio` int(11) NOT NULL,
  `oferta` int(11) DEFAULT NULL,
  `descripcion` varchar(1020) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ropa_stock_combinado`
--

CREATE TABLE `ropa_stock_combinado` (
  `ropa_idRopa` int(11) NOT NULL,
  `talle_idTalle` int(11) NOT NULL,
  `color_idColor` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talles`
--

CREATE TABLE `talles` (
  `idTalle` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talles`
--

INSERT INTO `talles` (`idTalle`, `nombre`) VALUES
(1, 'XS'),
(2, 'S'),
(3, 'M'),
(4, 'L'),
(5, 'XL'),
(6, 'XXL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `user` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `contraseña` varchar(45) NOT NULL,
  `nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `user`, `email`, `contraseña`, `nacimiento`) VALUES
(1, 'asd', 'asdas', 'asd', '3232-02-01'),
(2, 'camilo', 'camilo@camilo.com', 'camilo12345', '2000-10-10'),
(3, 'alsdiujalsjdasd', 'asdas@gmail.conmasdasds', 'dasd', '1111-11-11'),
(4, 'Nicolas', 'nicolas@gmail.com', 'nico2007', '2006-02-01'),
(9, 'a', 'asdas@gmail.com', 'a', '1111-11-11'),
(10, 'kiwo', 'kiwo@gmail.com', 'kiwo', '2000-12-05'),
(11, 'Gonzalo', 'gonzaloroverda@gmail.com', 'gonza2007', '2007-12-18'),
(12, 'asdas', 'asdasd@gmail.com', 'asdasd', '1111-11-11'),
(14, 'admin', 'admin@admin.admin', 'admin', '9999-09-09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`idColor`);

--
-- Indices de la tabla `juguete`
--
ALTER TABLE `juguete`
  ADD PRIMARY KEY (`idJuguete`);

--
-- Indices de la tabla `ropa`
--
ALTER TABLE `ropa`
  ADD PRIMARY KEY (`idRopa`);

--
-- Indices de la tabla `ropa_stock_combinado`
--
ALTER TABLE `ropa_stock_combinado`
  ADD PRIMARY KEY (`ropa_idRopa`,`talle_idTalle`,`color_idColor`),
  ADD KEY `talle_idTalle` (`talle_idTalle`),
  ADD KEY `color_idColor` (`color_idColor`);

--
-- Indices de la tabla `talles`
--
ALTER TABLE `talles`
  ADD PRIMARY KEY (`idTalle`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `juguete`
--
ALTER TABLE `juguete`
  MODIFY `idJuguete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ropa`
--
ALTER TABLE `ropa`
  MODIFY `idRopa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ropa_stock_combinado`
--
ALTER TABLE `ropa_stock_combinado`
  ADD CONSTRAINT `ropa_stock_combinado_ibfk_1` FOREIGN KEY (`ropa_idRopa`) REFERENCES `ropa` (`idRopa`),
  ADD CONSTRAINT `ropa_stock_combinado_ibfk_2` FOREIGN KEY (`talle_idTalle`) REFERENCES `talles` (`idTalle`),
  ADD CONSTRAINT `ropa_stock_combinado_ibfk_3` FOREIGN KEY (`color_idColor`) REFERENCES `colores` (`idColor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
