-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 24-06-2021 a las 02:33:39
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante_rbduardo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`) VALUES
(1, 'Platillos'),
(2, 'Entradas'),
(3, 'Bebidas'),
(4, 'Postres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `idPlatillo` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `cantPlatillos` int(11) NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idMesa` int(11) NOT NULL,
  `zona` varchar(60) NOT NULL,
  `idPersonal` int(11) DEFAULT NULL,
  `ocupado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`idMesa`, `zona`, `idPersonal`, `ocupado`) VALUES
(1, 'Juegos', 3, 0),
(2, 'Juegos', 3, 0),
(3, 'Juegos', 3, 0),
(4, 'Balcón', 4, 0),
(5, 'Balcón', 4, 0),
(6, 'Balcón', 4, 0),
(7, 'Entrada', 5, 0),
(8, 'Entrada', 5, 0),
(9, 'Entrada', 5, 0),
(10, 'Baños', 3, 1),
(11, 'Juegos', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `hora` time NOT NULL,
  `totalPedido` float NOT NULL,
  `idMesa` int(11) NOT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `idPersonal` int(11) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `rol` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`idPersonal`, `password`, `nombre`, `apellido`, `rol`) VALUES
(1, 'admin', 'admin', 'admin', 'administrador'),
(2, '312319', 'Ulises', 'Ortega', 'administrador'),
(3, '12345', 'Juan', 'López', 'mesero'),
(4, '74185', 'María', 'Mercédez', 'mesero'),
(5, '78945', 'José', 'Ramírez', 'mesero'),
(6, '415263', 'Guadalupe', 'Pineda', 'mesero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillo`
--

CREATE TABLE `platillo` (
  `idPlatillo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `idCategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `platillo`
--

INSERT INTO `platillo` (`idPlatillo`, `nombre`, `imagen`, `precio`, `descripcion`, `idCategoria`) VALUES
(1, 'Hamburguesa', '../../public/img/hamburguesa.jpg', 45, 'Ricas hamburguesas al carbón', 1),
(3, 'Jericalla', '../../public/img/jericalla.jpg', 15, 'Jericalla casera', 4),
(4, 'Pastel', '../../public/img/pastel.jpg', 20, 'Rebana de pastel de 3 leches', 4),
(5, 'Coca Cola', '../../public/img/coca-cola.jpg', 18, 'Coca Cola de 500 ml', 3),
(6, 'Tacos de carnitas', '../../public/img/tacarnitas.jpg', 55, 'Orden con 3 tacos de carnitas', 1),
(7, 'Tostadas de mole', '../../public/img/tostadas-mole.jpg', 15, 'Precio individual', 2),
(8, 'Tostadas de ceviche de pescado', '../../public/img/tostadas-ceviche.jpg', 25, 'Precio individual', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `folioTicket` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `total` float NOT NULL,
  `idMeza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_pedido`
--

CREATE TABLE `ticket_pedido` (
  `folio` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idMesa`),
  ADD KEY `idPersonal_idx` (`idPersonal`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idMesa_idx` (`idMesa`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idPersonal`);

--
-- Indices de la tabla `platillo`
--
ALTER TABLE `platillo`
  ADD PRIMARY KEY (`idPlatillo`),
  ADD KEY `idCategoria_idx` (`idCategoria`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`folioTicket`),
  ADD KEY `idMesa_idx` (`idMeza`);

--
-- Indices de la tabla `ticket_pedido`
--
ALTER TABLE `ticket_pedido`
  ADD PRIMARY KEY (`folio`,`idPedido`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idPersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `platillo`
--
ALTER TABLE `platillo`
  MODIFY `idPlatillo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `folioTicket` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD CONSTRAINT `idPersonal` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`idPersonal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `idMesa` FOREIGN KEY (`idMesa`) REFERENCES `mesa` (`idMesa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `platillo`
--
ALTER TABLE `platillo`
  ADD CONSTRAINT `idCategoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `idMeza` FOREIGN KEY (`idMeza`) REFERENCES `mesa` (`idMesa`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
