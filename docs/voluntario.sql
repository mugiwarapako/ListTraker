-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-12-2017 a las 21:22:14
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `voluntario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `mensajeCreador` mediumtext,
  `idSismogrupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `mensajeCreador`, `idSismogrupo`) VALUES
(2, 'prueba', 1),
(3, 'dara inicio el simulacro ', 1),
(4, 'termino simulacro ', 1),
(5, 'prueba', 1),
(6, 'hola', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante`
--

CREATE TABLE `participante` (
  `id` int(11) NOT NULL,
  `alias` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participante`
--

INSERT INTO `participante` (`id`, `alias`) VALUES
(123456790, 'mateo'),
(123456791, 'Allison'),
(123456792, 'Allison'),
(123456793, 'Pamela'),
(123456794, 'Eimy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante_sismo_grupo`
--

CREATE TABLE `participante_sismo_grupo` (
  `id` int(11) NOT NULL,
  `idParticipante` int(11) NOT NULL,
  `idSismo` int(11) NOT NULL,
  `tiempo_inicio` varchar(50) NOT NULL,
  `tiempo_estoy_listo` varchar(50) NOT NULL,
  `mensajeParticipante` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participante_sismo_grupo`
--

INSERT INTO `participante_sismo_grupo` (`id`, `idParticipante`, `idSismo`, `tiempo_inicio`, `tiempo_estoy_listo`, `mensajeParticipante`) VALUES
(4, 123456791, 1, '4:00', '4:15', NULL),
(34, 123456791, 1, 'haikhskas', '23-03-2017', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sismogrupo`
--

CREATE TABLE `sismogrupo` (
  `id` int(11) NOT NULL,
  `ubicacion` varchar(250) DEFAULT NULL,
  `latitud` varchar(50) DEFAULT NULL,
  `longitud` varchar(50) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `hora` varchar(45) DEFAULT NULL,
  `participantes` varchar(45) DEFAULT NULL,
  `idUsuarios` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sismogrupo`
--

INSERT INTO `sismogrupo` (`id`, `ubicacion`, `latitud`, `longitud`, `fecha`, `hora`, `participantes`, `idUsuarios`) VALUES
(1, 'Neza', 'jajajaj', 'haikhskas', '23-03-2017', '13:00', '2', 1),
(8, 'Iztapalapa', '34455', '23223', '12-12-17', '2:00', '1', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(8) NOT NULL,
  `folio` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `folio`, `nombre`, `telefono`, `correo`) VALUES
(1, 'ba500', 'baabajs', '67677676', 'bababa@gmail.com'),
(2, 'Pe500', 'Pepe', '34534534', 'pakodiazcastillo@gmail.com'),
(3, 'ja500', 'jajajajaja', '34534534', 'jajajaaja@gmail.com'),
(4, 'ja400', 'gegagaga', '34534534', 'egegeggee@gmail.com'),
(5, 'ja400', 'lalalala', '34534534', 'lalalalla@gmail.com'),
(6, 'SV100', 'Sayuri Velasco', '22997766', 'srr@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSismogrupo` (`idSismogrupo`);

--
-- Indices de la tabla `participante`
--
ALTER TABLE `participante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participante_sismo_grupo`
--
ALTER TABLE `participante_sismo_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_imai_has_sismoGrupo_sismoGrupo1_idx` (`idSismo`),
  ADD KEY `fk_imai_has_sismoGrupo_imai1_idx` (`idParticipante`),
  ADD KEY `idParticipante` (`idParticipante`);

--
-- Indices de la tabla `sismogrupo`
--
ALTER TABLE `sismogrupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sismoGrupo_u1_idx` (`idUsuarios`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `participante`
--
ALTER TABLE `participante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123456795;
--
-- AUTO_INCREMENT de la tabla `participante_sismo_grupo`
--
ALTER TABLE `participante_sismo_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `sismogrupo`
--
ALTER TABLE `sismogrupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`idSismogrupo`) REFERENCES `sismogrupo` (`id`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`idSismogrupo`) REFERENCES `sismogrupo` (`id`);

--
-- Filtros para la tabla `participante_sismo_grupo`
--
ALTER TABLE `participante_sismo_grupo`
  ADD CONSTRAINT `fk_imai_has_sismoGrupo_imai1` FOREIGN KEY (`idParticipante`) REFERENCES `participante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imai_has_sismoGrupo_sismoGrupo1` FOREIGN KEY (`idSismo`) REFERENCES `sismogrupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sismogrupo`
--
ALTER TABLE `sismogrupo`
  ADD CONSTRAINT `fk_sisg_u1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
