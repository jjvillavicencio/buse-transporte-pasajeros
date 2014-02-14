-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2014 a las 09:24:26
-- Versión del servidor: 5.6.11
-- Versión de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `buses_db`
--
CREATE DATABASE IF NOT EXISTS `buses_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `buses_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencia`
--

CREATE TABLE IF NOT EXISTS `agencia` (
  `idAgencia` int(11) NOT NULL AUTO_INCREMENT,
  `idCanton` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `rucEmpresa` varchar(12) NOT NULL,
  PRIMARY KEY (`idAgencia`),
  KEY `idCanton` (`idCanton`),
  KEY `rucEmpresa` (`rucEmpresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `agencia`
--

INSERT INTO `agencia` (`idAgencia`, `idCanton`, `direccion`, `telefono`, `rucEmpresa`) VALUES
(1, 3, '10 de agosto y av', '25487451', '100000000001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleto`
--

CREATE TABLE IF NOT EXISTS `boleto` (
  `numBoleto` int(11) NOT NULL AUTO_INCREMENT,
  `cedulaCliente` varchar(10) NOT NULL,
  `fechaEmision` date NOT NULL,
  `horaEmision` time NOT NULL,
  `idTurno` int(11) NOT NULL,
  `agenciaVenta` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `numAsiento` int(11) NOT NULL,
  PRIMARY KEY (`numBoleto`),
  KEY `cedulaCliente` (`cedulaCliente`),
  KEY `idTurno` (`idTurno`),
  KEY `agenciaVenta` (`agenciaVenta`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `boleto`
--

INSERT INTO `boleto` (`numBoleto`, `cedulaCliente`, `fechaEmision`, `horaEmision`, `idTurno`, `agenciaVenta`, `idUsuario`, `numAsiento`) VALUES
(3, '1104892367', '2014-02-10', '00:00:00', 3, 1, 1, 4),
(4, '1104892367', '2014-02-10', '04:16:00', 3, 1, 1, 6),
(5, '1104892367', '2014-02-09', '22:18:58', 3, 1, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bus`
--

CREATE TABLE IF NOT EXISTS `bus` (
  `numBus` int(11) NOT NULL AUTO_INCREMENT,
  `capacidad` int(11) NOT NULL,
  `año` int(11) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `placa` varchar(11) NOT NULL,
  `numDisco` int(11) NOT NULL,
  `rucSocio` varchar(13) NOT NULL,
  PRIMARY KEY (`numBus`),
  KEY `rucSocio` (`rucSocio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `bus`
--

INSERT INTO `bus` (`numBus`, `capacidad`, `año`, `modelo`, `placa`, `numDisco`, `rucSocio`) VALUES
(1, 30, 2006, 'Mercedes Benz', 'LBA1498', 789455, '1104961550001'),
(5, 35, 2009, 'Scannia', 'LDS4897', 78894, '100000000000'),
(10, 25, 2010, 'Mercedes Benz', 'LCF4896', 47895, '1900478213001'),
(14, 25, 2009, 'Mercedes ', 'LBA1452', 2458, '100000000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canton`
--

CREATE TABLE IF NOT EXISTS `canton` (
  `idCanton` int(11) NOT NULL AUTO_INCREMENT,
  `idProvincia` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`idCanton`),
  KEY `idProvincia` (`idProvincia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `canton`
--

INSERT INTO `canton` (`idCanton`, `idProvincia`, `nombre`) VALUES
(3, 4, 'Loja'),
(4, 4, 'Catamayo'),
(5, 4, 'Cariamanga'),
(6, 4, 'Celica'),
(7, 4, 'Alamor'),
(8, 4, 'Zapotillo'),
(9, 5, 'Centinela del Condor'),
(10, 5, 'Pangui'),
(11, 5, 'Yantzatza'),
(12, 6, 'Piura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE IF NOT EXISTS `detallefactura` (
  `idItem` int(11) NOT NULL,
  PRIMARY KEY (`idItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `Ruc` varchar(12) NOT NULL,
  `NombreEmpresa` varchar(40) NOT NULL,
  `Direccion` varchar(60) NOT NULL,
  `idCanton` int(11) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `PermisoOperacion` varchar(20) NOT NULL,
  PRIMARY KEY (`Ruc`),
  KEY `Canton` (`idCanton`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`Ruc`, `NombreEmpresa`, `Direccion`, `idCanton`, `Telefono`, `PermisoOperacion`) VALUES
('100000000001', 'Cooperativa Loja', 'Terminal Terrestre', 3, '2555555', '1554548545454545');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `idFactura` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `idPais` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`idPais`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`idPais`, `Nombre`) VALUES
(1, 'Ecuador'),
(2, 'PerÃº'),
(3, 'Colombia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `cedula` varchar(10) NOT NULL,
  `Nombres` varchar(40) NOT NULL,
  `Apellidos` varchar(40) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(30) NOT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`cedula`, `Nombres`, `Apellidos`, `direccion`, `telefono`, `correo`) VALUES
('1104892367', 'John', 'Villavicencio', 'Las Pitas, Universo ', '0994368052', 'jjvillavicencio@utpl.edu.ec'),
('1104961550', 'Vanessa', 'Sotomayor', 'Daniel Alvarez', '2564897', 'vsotomayor@utpl.edu.ec'),
('1106090531', 'Macarena', 'Criollo', 'Las Pitas', '4895', 'maki2009@hhg.com'),
('1900478213', 'Jackson', 'Masache', 'Daniel Alvarez', '2489654', 'jmasache@utpl.edu.ec');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE IF NOT EXISTS `provincia` (
  `idProvincia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `idPais` int(11) NOT NULL,
  PRIMARY KEY (`idProvincia`),
  KEY `idPais` (`idPais`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`idProvincia`, `nombre`, `idPais`) VALUES
(4, 'Loja', 1),
(5, 'Zamora Chinchipe', 1),
(6, 'Piura', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE IF NOT EXISTS `rutas` (
  `idRuta` int(11) NOT NULL AUTO_INCREMENT,
  `LugarPartida` int(11) NOT NULL,
  `lugarLlegada` int(11) NOT NULL,
  `horaSalida` time NOT NULL,
  `horaLlegada` time NOT NULL,
  `idTipo` int(11) NOT NULL,
  `valor` double NOT NULL,
  PRIMARY KEY (`idRuta`),
  KEY `LugarPartida` (`LugarPartida`,`lugarLlegada`,`idTipo`),
  KEY `idTipo` (`idTipo`),
  KEY `LugarPartida_2` (`LugarPartida`),
  KEY `lugarLlegada` (`lugarLlegada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`idRuta`, `LugarPartida`, `lugarLlegada`, `horaSalida`, `horaLlegada`, `idTipo`, `valor`) VALUES
(1, 4, 3, '12:00:00', '14:00:00', 1, 3.5),
(2, 3, 12, '06:00:00', '18:00:00', 1, 25),
(3, 3, 10, '06:00:00', '11:00:00', 1, 5),
(4, 11, 10, '05:00:00', '07:00:00', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE IF NOT EXISTS `sesiones` (
  `idUsuario` int(11) NOT NULL,
  `idSesion` int(11) NOT NULL,
  `idAgencia` int(11) NOT NULL,
  PRIMARY KEY (`idSesion`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idAgencia` (`idAgencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sesiones`
--

INSERT INTO `sesiones` (`idUsuario`, `idSesion`, `idAgencia`) VALUES
(1, 0, 1),
(1, 6, 1),
(1, 12, 1),
(1, 52, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE IF NOT EXISTS `socio` (
  `rucSocio` varchar(13) NOT NULL,
  `rucEmpresa` varchar(13) NOT NULL,
  `cedulaPersona` varchar(10) NOT NULL,
  PRIMARY KEY (`rucSocio`),
  KEY `cedulaPersona` (`cedulaPersona`),
  KEY `rucEmpresa` (`rucEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`rucSocio`, `rucEmpresa`, `cedulaPersona`) VALUES
('100000000000', '100000000001', '1104892367'),
('1104961550001', '100000000001', '1104961550'),
('1900478213001', '100000000001', '1900478213');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `idTipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`idTipo`, `nombre`) VALUES
(1, 'Especial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE IF NOT EXISTS `turno` (
  `idTurno` int(11) NOT NULL AUTO_INCREMENT,
  `numBus` int(11) NOT NULL,
  `idRuta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`idTurno`),
  KEY `numBus` (`numBus`),
  KEY `idRuta` (`idRuta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`idTurno`, `numBus`, `idRuta`, `fecha`) VALUES
(3, 14, 1, '2014-02-05'),
(4, 5, 2, '2014-02-11'),
(5, 1, 4, '2014-02-15'),
(6, 10, 3, '2014-02-17'),
(8, 10, 3, '2014-02-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(10) NOT NULL,
  `nombreUsr` varchar(10) NOT NULL,
  `claveUsr` longtext NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `cedula` (`cedula`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `cedula`, `nombreUsr`, `claveUsr`) VALUES
(1, '1104892367', 'jjonix', 'e10adc3949ba59abbe56e057f20f883e'),
(2, '1104892367', 'user3', '25f9e794323b453885f5181f1b624d0b');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agencia`
--
ALTER TABLE `agencia`
  ADD CONSTRAINT `agencia_ibfk_1` FOREIGN KEY (`idCanton`) REFERENCES `canton` (`idCanton`),
  ADD CONSTRAINT `agencia_ibfk_2` FOREIGN KEY (`rucEmpresa`) REFERENCES `empresa` (`Ruc`);

--
-- Filtros para la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD CONSTRAINT `boleto_ibfk_1` FOREIGN KEY (`cedulaCliente`) REFERENCES `persona` (`cedula`),
  ADD CONSTRAINT `boleto_ibfk_2` FOREIGN KEY (`idTurno`) REFERENCES `turno` (`idTurno`),
  ADD CONSTRAINT `boleto_ibfk_3` FOREIGN KEY (`agenciaVenta`) REFERENCES `agencia` (`idAgencia`),
  ADD CONSTRAINT `boleto_ibfk_4` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `bus`
--
ALTER TABLE `bus`
  ADD CONSTRAINT `bus_ibfk_1` FOREIGN KEY (`rucSocio`) REFERENCES `socio` (`rucSocio`);

--
-- Filtros para la tabla `canton`
--
ALTER TABLE `canton`
  ADD CONSTRAINT `canton_ibfk_1` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`idCanton`) REFERENCES `canton` (`idCanton`);

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `provincia_ibfk_1` FOREIGN KEY (`idPais`) REFERENCES `pais` (`idPais`);

--
-- Filtros para la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD CONSTRAINT `rutas_ibfk_1` FOREIGN KEY (`LugarPartida`) REFERENCES `canton` (`idCanton`),
  ADD CONSTRAINT `rutas_ibfk_2` FOREIGN KEY (`lugarLlegada`) REFERENCES `canton` (`idCanton`),
  ADD CONSTRAINT `rutas_ibfk_3` FOREIGN KEY (`idTipo`) REFERENCES `tipo` (`idTipo`);

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `sesiones_ibfk_2` FOREIGN KEY (`idAgencia`) REFERENCES `agencia` (`idAgencia`);

--
-- Filtros para la tabla `socio`
--
ALTER TABLE `socio`
  ADD CONSTRAINT `socio_ibfk_1` FOREIGN KEY (`cedulaPersona`) REFERENCES `persona` (`cedula`),
  ADD CONSTRAINT `socio_ibfk_2` FOREIGN KEY (`rucEmpresa`) REFERENCES `empresa` (`Ruc`);

--
-- Filtros para la tabla `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `turno_ibfk_1` FOREIGN KEY (`numBus`) REFERENCES `bus` (`numBus`),
  ADD CONSTRAINT `turno_ibfk_2` FOREIGN KEY (`idRuta`) REFERENCES `rutas` (`idRuta`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `persona` (`cedula`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
