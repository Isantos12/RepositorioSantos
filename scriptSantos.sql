-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2023 a las 22:00:57
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `skysound2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `idCancion` int(11) NOT NULL,
  `idLista` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `momento` varchar(200) NOT NULL,
  `notas` varchar(200) NOT NULL,
  `ruta` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`idCancion`, `idLista`, `titulo`, `momento`, `notas`, `ruta`) VALUES
(137, 100, 'QWEQWE', 'QWEQWEQWEQWEQWEQWE', 'QWEQWEQWEQWEQWEQWEQWE', 'web/music/onlymp3.to - Danza Kuduro Remix - Don  Omar Ft Daddy Yankee y Arcangel.wmv-C49NyTXpaDs-192k-1657066760357.mp3'),
(138, 100, 'werqwe', 'qweqwe', 'qweqwe', 'web/music/onlymp3.to - Danza Kuduro Remix - Don  Omar Ft Daddy Yankee y Arcangel.wmv-C49NyTXpaDs-192k-1657066760357.mp3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `idFoto` int(11) NOT NULL,
  `idLista` int(11) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `fotoPrincipal` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`idFoto`, `idLista`, `foto`, `fotoPrincipal`) VALUES
(146, 96, 'web/img/66160.jpg', 0),
(147, 97, 'web/img/wp6400060-scaled.jpg', 0),
(148, 98, 'web/img/vinyl.png', 0),
(149, 99, 'web/img/pexels-timothy-paule-ii-2002719.jpg', 0),
(153, 100, 'web/img/a.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas`
--

CREATE TABLE `listas` (
  `idLista` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fechaDelEvento` date NOT NULL,
  `descripcion` text NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `listas`
--

INSERT INTO `listas` (`idLista`, `titulo`, `fechaDelEvento`, `descripcion`, `idUsuario`, `fecha`) VALUES
(96, 'Prueba', '2023-06-24', 'Lista de prueba de musica', 12, '2023-06-14 20:52:35'),
(97, 'Lista de prueba', '0000-00-00', 'Lista de prueba', 12, '2023-06-14 20:59:16'),
(98, 'Lista de prueba2', '0000-00-00', 'Lista de prueba2', 12, '2023-06-14 20:59:16'),
(99, 'Lista de prueba4', '0000-00-00', 'Lista de prueba34', 12, '2023-06-14 20:59:16'),
(100, 'Prueba para rebeca', '0000-00-00', 'Musica evento comida2', 21, '2023-06-14 21:04:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cookie` varchar(100) NOT NULL,
  `rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `cookie`, `rol`) VALUES
(12, 'pepe@gmail.com', '$2y$10$6qqKJJVGTvQ7kp8apoIVaeTFvLkp.2KLF1BTbPOEC6qZN4HvJka76', 'pepe', '27e419706c3e9460f860324f3f06270bb51921a15c9a00336f78a1f16d481e6f546093e9', 'user'),
(17, 'admin@gmail.com', '$2y$10$tDCKg5UAiUjfA/4fS64VjuOBizBINMYg3EmrYoTvbq.UDQC2typF.', 'Admin', 'f3e011fc2e01b03a07d0d8f10bf2d36310e7a931140b53cfe777a99a7bab710cae88fc67', 'admin'),
(21, 'rebe@gamil.com', '$2y$10$NTE4qjUexpsSDvthZoHvTedX.kKussgLDIttbjaffL7cEbgq8FIS6', 'Rebeca', '4f6e64b502286a6bf7355f141a89184c0cf4cba8f44ea6d7c4d2cb5ead4267724ca1de64', 'user'),
(26, 'inma@gmail.com', '$2y$10$2bLCTs7EXkzSrwhWZQCwkeIBSAZ6mXg46Hy5hdCHedWmQrAZTRaW2', 'prueba', '', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`idCancion`),
  ADD KEY `fk_idCancion` (`idLista`) USING BTREE;

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`idFoto`),
  ADD KEY `fk_idFoto` (`idLista`);

--
-- Indices de la tabla `listas`
--
ALTER TABLE `listas`
  ADD PRIMARY KEY (`idLista`),
  ADD KEY `fk_idUsuario` (`idUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `idCancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `idFoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de la tabla `listas`
--
ALTER TABLE `listas`
  MODIFY `idLista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`idLista`) REFERENCES `listas` (`idLista`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fk_idFoto` FOREIGN KEY (`idLista`) REFERENCES `listas` (`idLista`) ON DELETE CASCADE;

--
-- Filtros para la tabla `listas`
--
ALTER TABLE `listas`
  ADD CONSTRAINT `fk_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
