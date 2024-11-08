-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2024 a las 01:12:56
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

--
-- Volcado de datos para la tabla `juguete`
--

INSERT INTO `juguete` (`idJuguete`, `nombre`, `color`, `marca`, `edad`, `precio`, `oferta`, `descripcion`, `stock`) VALUES
(1, 'Auto de Carrera', 'Rojo', 'Hot Wheels', 6, 1500, NULL, 'Auto de carrera de alta velocidad', 100),
(2, 'Muñeca', 'Rosa', 'Mattel', 3, 2000, 18, 'Muñeca articulada con accesorios', 50),
(3, 'Bloques de Construcción', 'Multicolor', 'LEGO', 5, 3500, NULL, 'Set de bloques para construir ciudades', 30),
(4, 'Robot Interactivo', 'Blanco', 'Fisher Price', 8, 8000, 75, 'Robot que responde a comandos de voz', 20),
(5, 'Pelota de Fútbol', 'Negro', 'Adidas', 7, 1200, NULL, 'Pelota de fútbol para uso exterior', 200),
(6, 'Pista de Carreras', 'Azul', 'Hot Wheels', 4, 5000, NULL, 'Pista de carreras con loop y rampas', 40),
(7, 'Patineta', 'Negro', 'Razor', 8, 6000, NULL, 'Patineta para trucos y skateboarding', 50),
(8, 'Camión de Bomberos', 'Rojo', 'Tonka', 5, 2500, 2300, 'Camión de bomberos con escalera extensible', 100),
(9, 'Muñeco de Superhéroe', 'Azul', 'Marvel', 4, 1500, NULL, 'Muñeco articulado del héroe favorito', 200),
(10, 'Avión de Juguete', 'Blanco', 'JetSet', 6, 3000, 2800, 'Avión con luces y sonidos', 75),
(11, 'Rompecabezas 3D', 'Multicolor', 'Ravensburger', 10, 5000, NULL, 'Rompecabezas 3D de monumentos famosos', 30),
(12, 'Casa de Muñecas', 'Rosa', 'KidKraft', 6, 10000, 9500, 'Casa de muñecas con muebles incluidos', 20),
(13, 'Juego de Té', 'Blanco', 'Fisher Price', 3, 1800, NULL, 'Juego de té para niños', 150),
(14, 'Set de Pintura', 'Multicolor', 'Crayola', 5, 1200, NULL, 'Set de pintura no tóxica para niños', 90),
(15, 'Tren Eléctrico', 'Negro', 'Lionel', 7, 12000, 11500, 'Tren eléctrico con vías y accesorios', 15),
(16, 'Helicóptero', 'Verde', 'Hot Wheels', 6, 3000, NULL, 'Helicóptero con hélice giratoria', 40),
(17, 'Kit de Ciencias', 'Multicolor', 'Discovery', 8, 4500, NULL, 'Kit para experimentos científicos seguros', 35),
(18, 'Robot Educativo', 'Blanco', 'Lego', 10, 15000, NULL, 'Robot programable para aprendizaje', 10),
(19, 'Bicicleta', 'Azul', 'BMX', 7, 9000, NULL, 'Bicicleta de niños con rodines desmontables', 25),
(20, 'Pelota Saltarina', 'Rosa', 'Wham-O', 3, 500, NULL, 'Pelota que rebota alto y divierte', 200),
(21, 'Caja Registradora', 'Rojo', 'Melissa & Doug', 4, 3000, 2700, 'Caja registradora con billetes y monedas', 50),
(22, 'Pistola de Agua', 'Azul', 'Nerf', 5, 1000, NULL, 'Pistola de agua de gran capacidad', 180);

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

--
-- Volcado de datos para la tabla `ropa`
--

INSERT INTO `ropa` (`idRopa`, `nombre`, `material`, `marca`, `genero`, `precio`, `oferta`, `descripcion`) VALUES
(1, 'Camiseta', 'Algodón', 'Nike', 'Unisex', 2000, NULL, 'Camiseta deportiva de algodón de alta calidad'),
(2, 'Pantalón', 'Denim', 'Levi\'s', 'Hombre', 4500, 40, 'Pantalón de mezclilla clásico'),
(3, 'Chaqueta', 'Poliéster', 'Adidas', 'Mujer', 8000, NULL, 'Chaqueta de poliéster resistente al agua'),
(4, 'Falda', 'Seda', 'Zara', 'Mujer', 3000, 28, 'Falda de seda suave para ocasiones especiales'),
(5, 'Sudadera', 'Algodón', 'Puma', 'Unisex', 2500, NULL, 'Sudadera casual de algodón con capucha'),
(6, 'Camisa', 'Algodón', 'Tommy Hilfiger', 'Hombre', 4000, NULL, 'Camisa de algodón de alta calidad para ocasiones formales'),
(7, 'Vestido', 'Seda', 'Gucci', 'Mujer', 15000, 14000, 'Vestido elegante de seda con detalles únicos'),
(8, 'Chaleco', 'Lana', 'Uniqlo', 'Unisex', 3000, NULL, 'Chaleco de lana para clima fresco'),
(9, 'Abrigo', 'Cachemira', 'Burberry', 'Mujer', 20000, 19000, 'Abrigo de cachemira de lujo para invierno'),
(10, 'Jeans', 'Denim', 'Calvin Klein', 'Hombre', 5000, 4500, 'Jeans de mezclilla de corte ajustado'),
(11, 'Suéter', 'Lana', 'H&M', 'Unisex', 2500, NULL, 'Suéter de lana suave y cómodo'),
(12, 'Short', 'Poliéster', 'Nike', 'Hombre', 1500, NULL, 'Short deportivo para entrenamiento'),
(13, 'Pijama', 'Algodón', 'Old Navy', 'Mujer', 2000, 1800, 'Pijama cómodo de algodón para dormir'),
(14, 'Traje', 'Poliéster', 'Zara', 'Hombre', 8000, NULL, 'Traje clásico para eventos formales'),
(15, 'Leggings', 'Lycra', 'Lululemon', 'Mujer', 2500, NULL, 'Leggings elásticos para yoga y entrenamiento'),
(16, 'Blazer', 'Lana', 'Mango', 'Hombre', 7000, NULL, 'Blazer elegante de lana'),
(17, 'Polo', 'Algodón', 'Lacoste', 'Unisex', 3000, 2700, 'Polo de algodón clásico con logo de marca'),
(18, 'Chaqueta de Cuero', 'Cuero', 'Levi\'s', 'Unisex', 10000, NULL, 'Chaqueta de cuero para un estilo clásico'),
(19, 'Sandalias', 'Sintético', 'Crocs', 'Unisex', 1200, NULL, 'Sandalias cómodas para verano'),
(20, 'Calcetines', 'Algodón', 'Adidas', 'Unisex', 500, NULL, 'Calcetines deportivos'),
(21, 'Falda Plisada', 'Poliéster', 'Forever 21', 'Mujer', 2200, 2000, 'Falda plisada moderna');

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

--
-- Volcado de datos para la tabla `ropa_stock_combinado`
--

INSERT INTO `ropa_stock_combinado` (`ropa_idRopa`, `talle_idTalle`, `color_idColor`, `stock`) VALUES
(1, 2, 1, 50),
(1, 3, 2, 30),
(2, 4, 3, 40),
(3, 5, 4, 20),
(4, 1, 5, 15),
(5, 6, 6, 25),
(6, 1, 1, 20),
(6, 2, 1, 45),
(6, 3, 2, 30),
(6, 4, 3, 10),
(6, 5, 4, 18),
(7, 1, 5, 15),
(7, 2, 5, 20),
(7, 3, 6, 25),
(7, 4, 3, 20),
(7, 4, 8, 12),
(7, 5, 4, 25),
(7, 5, 9, 18),
(8, 1, 2, 10),
(8, 1, 5, 15),
(8, 2, 2, 15),
(8, 3, 3, 20),
(8, 4, 4, 15),
(8, 5, 6, 10),
(9, 1, 7, 12),
(9, 2, 6, 10),
(9, 2, 7, 18),
(9, 3, 8, 10),
(9, 4, 9, 15),
(9, 5, 10, 8),
(10, 2, 1, 30),
(10, 3, 1, 50),
(10, 3, 2, 40),
(10, 4, 5, 20),
(10, 5, 6, 35),
(10, 6, 7, 15),
(11, 1, 3, 25),
(11, 2, 1, 30),
(11, 3, 2, 22),
(11, 4, 2, 40),
(11, 4, 4, 15),
(11, 5, 6, 20),
(12, 1, 1, 10),
(12, 2, 3, 15),
(12, 3, 5, 18),
(12, 4, 7, 12),
(12, 5, 3, 35),
(12, 5, 9, 20),
(13, 1, 4, 22),
(13, 2, 8, 28),
(13, 3, 6, 25),
(13, 4, 7, 30),
(13, 5, 10, 15),
(13, 6, 4, 20),
(14, 1, 5, 25),
(14, 2, 5, 16),
(14, 3, 7, 22),
(14, 4, 6, 12),
(14, 5, 2, 18),
(14, 6, 1, 20),
(15, 1, 6, 25),
(15, 2, 4, 30),
(15, 2, 6, 30),
(15, 3, 5, 20),
(15, 4, 9, 18),
(15, 5, 8, 15),
(16, 1, 3, 12),
(16, 2, 6, 18),
(16, 3, 1, 18),
(16, 3, 7, 25),
(16, 4, 10, 10),
(16, 5, 9, 15),
(17, 4, 2, 22),
(18, 5, 3, 15),
(19, 6, 4, 50),
(20, 1, 5, 60),
(21, 2, 6, 25);

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
  MODIFY `idJuguete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
