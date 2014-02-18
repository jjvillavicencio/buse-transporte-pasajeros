-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2014 a las 20:44:46
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `agencia`
--

INSERT INTO `agencia` (`idAgencia`, `idCanton`, `direccion`, `telefono`, `rucEmpresa`) VALUES
(1, 3, '10 de agosto y av', '25487451', '100000000001'),
(2, 4, 'Calle 1 y Calle2', '2489658', '100000000001'),
(3, 16, 'calle2 y calle3', '4789658', '100000000001'),
(4, 12, 'dir1', '15879', '100000000001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleto`
--

CREATE TABLE IF NOT EXISTS `boleto` (
  `numBoleto` int(11) NOT NULL AUTO_INCREMENT,
  `numFactura` int(11) NOT NULL,
  `cedulaCliente` varchar(10) NOT NULL,
  `idTurno` int(11) NOT NULL,
  `numAsiento` int(11) NOT NULL,
  PRIMARY KEY (`numBoleto`),
  KEY `cedulaCliente` (`cedulaCliente`),
  KEY `idTurno` (`idTurno`),
  KEY `numFactura` (`numFactura`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=134 ;

--
-- Volcado de datos para la tabla `boleto`
--

INSERT INTO `boleto` (`numBoleto`, `numFactura`, `cedulaCliente`, `idTurno`, `numAsiento`) VALUES
(102, 2565, '1000000004', 10, 5),
(103, 2002, '1104892367', 14, 5),
(104, 2002, '1104892367', 14, 4),
(105, 2002, '1104892367', 12, 5),
(106, 2002, '1104892367', 13, 5),
(107, 2523, '1000000005', 13, 10),
(108, 2523, '1000000007', 16, 6),
(109, 8963, '14578965', 18, 5),
(110, 8963, '1104892367', 18, 4),
(112, 789, '1104892367', 17, 4),
(117, 789, '1000000005', 16, 2),
(118, 741, '1104892367', 16, 8),
(119, 423, '1000000005', 16, 10),
(120, 1236, '1104892367', 17, 2),
(123, 12367, '1104892367', 18, 2),
(124, 7894, '1104892367', 18, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

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
(12, 6, 'Piura'),
(13, 4, 'Chaguarpamba'),
(14, 4, 'MacarÃ¡'),
(15, 4, 'Olmedo'),
(16, 5, 'Zamora');

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
  `idCedula` varchar(10) NOT NULL,
  `agencia` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `subTotal` decimal(5,2) NOT NULL,
  `iva` decimal(5,2) NOT NULL,
  `total` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `agencia` (`agencia`),
  KEY `usuario` (`usuario`),
  KEY `idCedula` (`idCedula`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12368 ;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`idFactura`, `idCedula`, `agencia`, `usuario`, `fecha`, `hora`, `subTotal`, `iva`, `total`) VALUES
(231, '1000000005', 1, 1, '2014-02-18', '22:14:00', '0.00', '0.00', '0.00'),
(423, '1104892367', 1, 1, '2014-02-18', '00:55:45', '0.00', '0.00', '0.00'),
(741, '1000000005', 1, 1, '2014-02-18', '23:49:42', '0.00', '0.00', '0.00'),
(789, '1104892367', 1, 1, '2014-02-18', '22:34:22', '0.00', '0.00', '0.00'),
(1236, '1104892367', 1, 1, '2014-02-18', '12:22:42', '0.00', '0.00', '0.00'),
(2001, '1104892367', 1, 1, '2014-02-15', '03:34:59', '0.00', '0.00', '0.00'),
(2002, '1104892367', 1, 1, '2014-02-15', '03:50:17', '0.00', '0.00', '0.00'),
(2523, '1000000005', 1, 1, '2014-02-15', '04:13:30', '0.00', '0.00', '0.00'),
(2565, '1000000003', 1, 1, '2014-02-02', '01:00:00', '6.00', '0.72', '6.72'),
(7894, '1104892367', 1, 1, '2014-02-18', '13:54:03', '0.00', '0.00', '0.00'),
(7898, '1104892367', 1, 1, '2014-02-18', '14:19:07', '30.00', '3.60', '33.60'),
(8963, '14578965', 1, 1, '2014-02-17', '12:52:53', '0.00', '0.00', '0.00'),
(12367, '1104892367', 1, 1, '2014-02-18', '12:24:31', '0.00', '0.00', '0.00');

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
  `telefono` varchar(25) NOT NULL,
  `correo` varchar(30) NOT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`cedula`, `Nombres`, `Apellidos`, `direccion`, `telefono`, `correo`) VALUES
('1000000000', 'Cecilia', 'Watkins', 'P.O. Box 815, 3550 Sit Road', '(475) 478-', 'mus@nibh.com'),
('1000000001', 'Talon', 'Chapman', 'Ap #156-3713 Massa. Avenue', '(364) 797-', 'adipiscing.non@Suspendissetris'),
('1000000002', 'Damian', 'Farmer', '777 Auctor. Ave', '(132) 505-', 'lobortis@Aeneaneget.co.uk'),
('1000000003', 'Dakota', 'Hendricks', '4146 Non Road', '(379) 575-', 'Proin.eget@faucibus.edu'),
('1000000004', 'Ariel', 'Riddle', '144-7754 Dapibus Rd.', '(946) 314-', 'vitae.velit@quamdignissimphare'),
('1000000005', 'Wynne', 'Townsend', '532-7955 Vel, St.', '(364) 860-', 'gravida.mauris@malesuadaIntege'),
('1000000006', 'Amery', 'Noble', 'P.O. Box 572, 3134 Elit Avenue', '(907) 980-', 'lorem.semper.auctor@Cum.com'),
('1000000007', 'Porter', 'Guzman', 'Ap #178-8884 Arcu. Avenue', '(221) 960-', 'lorem@pedemalesuada.com'),
('1000000008', 'Dexter', 'Woodard', 'P.O. Box 646, 1527 Lectus, Avenue', '(713) 758-', 'tellus.lorem.eu@acfermentumvel'),
('1000000009', 'Ella', 'Simpson', '207-7507 Eu, Avenue', '(884) 538-', 'blandit@Donec.ca'),
('1000000010', 'Chaim', 'Anderson', '4080 Sed Street', '(163) 295-', 'eros.turpis.non@Mauriseu.org'),
('1000000011', 'Rama', 'Farley', '592-7297 Aenean St.', '(493) 435-', 'Integer@Fuscefermentum.com'),
('1000000012', 'Raja', 'Bowers', '397-779 Aliquam Av.', '(188) 815-', 'lobortis.nisi.nibh@nibh.ca'),
('1000000013', 'Macaulay', 'Branch', '341-266 Sagittis St.', '(947) 758-', 'est@a.com'),
('1000000014', 'Hanae', 'Dawson', 'P.O. Box 444, 4559 Ut St.', '(139) 973-', 'purus.accumsan@etpedeNunc.net'),
('1000000015', 'Rhona', 'Mann', '8778 Dictum St.', '(553) 711-', 'scelerisque@mienim.co.uk'),
('1000000016', 'Jeremy', 'Bruce', '1046 Eu Ave', '(272) 709-', 'Nullam.feugiat@faucibus.co.uk'),
('1000000017', 'Tamara', 'Stein', '269-5045 Mattis. Ave', '(930) 139-', 'risus.a.ultricies@velitinaliqu'),
('1000000018', 'Roary', 'Reed', 'P.O. Box 772, 4468 Ornare, Avenue', '(550) 528-', 'feugiat@laciniaSedcongue.org'),
('1000000019', 'Hadassah', 'Ward', 'Ap #332-9409 Cursus. Rd.', '(905) 181-', 'sodales@tortor.co.uk'),
('1000000020', 'Velma', 'Duran', 'P.O. Box 548, 2065 Ut, Ave', '(600) 449-', 'nunc.interdum.feugiat@eu.org'),
('1000000021', 'Leah', 'Spence', '8550 Donec St.', '(957) 843-', 'nisi.magna.sed@Cras.com'),
('1000000022', 'Ivan', 'Barrett', '6165 Duis Road', '(857) 355-', 'semper.Nam@eueratsemper.org'),
('1000000023', 'Meghan', 'Richards', 'P.O. Box 410, 1950 Orci. Av.', '(437) 230-', 'Nullam.vitae.diam@adipiscingno'),
('1000000024', 'Fitzgerald', 'Vance', 'P.O. Box 609, 8727 Etiam Rd.', '(521) 940-', 'id.ante.dictum@loremDonec.net'),
('1000000025', 'Lillian', 'Nieves', '872-1539 Non Avenue', '(122) 460-', 'Proin@lectusNullamsuscipit.edu'),
('1000000026', 'Ralph', 'Barlow', 'Ap #327-2976 Dictum Road', '(419) 642-', 'lobortis@commodo.co.uk'),
('1000000027', 'Sade', 'Schultz', '363-4468 Donec Av.', '(464) 218-', 'gravida.Aliquam.tincidunt@netu'),
('1000000028', 'Jerome', 'Freeman', 'P.O. Box 395, 6910 Nisl. Rd.', '(361) 951-', 'cubilia@orciDonecnibh.edu'),
('1000000029', 'Jakeem', 'Hubbard', 'P.O. Box 536, 7746 Ipsum. Rd.', '(207) 828-', 'inceptos@eleifendnondapibus.ca'),
('1000000030', 'Henry', 'Holden', '8841 Gravida. St.', '(464) 827-', 'diam.eu.dolor@Phasellusvitae.o'),
('1000000031', 'Gail', 'Mcfarland', 'Ap #884-4817 Diam. Avenue', '(702) 189-', 'scelerisque.neque@velit.co.uk'),
('1000000032', 'Lance', 'Hensley', 'P.O. Box 554, 2556 Dolor Rd.', '(580) 968-', 'euismod.in@Cumsociis.edu'),
('1000000033', 'Upton', 'Waller', 'P.O. Box 272, 8545 Dictum. Rd.', '(655) 826-', 'amet.ornare.lectus@eratvelpede'),
('1000000034', 'Morgan', 'Rasmussen', 'Ap #426-5437 Fermentum St.', '(702) 152-', 'in@nonarcuVivamus.co.uk'),
('1000000035', 'Jana', 'Christensen', '7422 Lacinia Street', '(777) 259-', 'massa.Suspendisse.eleifend@mol'),
('1000000036', 'Tamara', 'Mercado', 'P.O. Box 585, 4453 Sed Street', '(769) 539-', 'ante.Maecenas@neque.edu'),
('1000000037', 'Ashely', 'Shaw', 'Ap #598-4001 Non St.', '(109) 126-', 'ipsum.Suspendisse.non@ligulaAe'),
('1000000038', 'Keiko', 'Foley', '439-3120 Eleifend, St.', '(779) 789-', 'auctor@ligulaDonec.ca'),
('1000000039', 'Ella', 'Wells', 'P.O. Box 593, 3776 Et Rd.', '(305) 638-', 'Sed@ipsumsodales.co.uk'),
('1000000040', 'Leila', 'Mercer', 'Ap #696-5576 Blandit Road', '(387) 694-', 'aliquam.eu.accumsan@molestieph'),
('1000000041', 'Arthur', 'Mcintosh', '657-6767 Lacus, Ave', '(859) 375-', 'Nam@ac.edu'),
('1000000042', 'Halla', 'Sanchez', '312-4825 Metus. Rd.', '(344) 807-', 'eget.lacus.Mauris@Nullam.org'),
('1000000043', 'Honorato', 'Tyson', '875-329 Justo Rd.', '(220) 560-', 'vehicula@faucibus.com'),
('1000000044', 'Iliana', 'Perez', 'P.O. Box 136, 3575 Viverra. Avenue', '(785) 410-', 'malesuada@euultrices.net'),
('1000000045', 'Rosalyn', 'Tucker', '5470 Sed St.', '(486) 733-', 'cursus.Integer@faucibusorci.ca'),
('1000000046', 'Maryam', 'Mcclain', 'P.O. Box 523, 7749 Pede St.', '(532) 693-', 'eu.tempor@portaelit.co.uk'),
('1000000047', 'Aaron', 'Cardenas', 'Ap #813-3527 Lorem Rd.', '(174) 165-', 'justo.eu@velfaucibusid.ca'),
('1000000048', 'Avram', 'Goff', 'Ap #209-4635 Montes, Avenue', '(461) 395-', 'neque.Nullam@Loremipsum.com'),
('1000000049', 'Winifred', 'Robinson', '329-1732 Iaculis Av.', '(445) 882-', 'Duis.risus@nunc.ca'),
('1000000050', 'Brielle', 'Lynn', '313-3082 Maecenas Avenue', '(397) 804-', 'arcu.Vestibulum.ante@Quisque.c'),
('1000000051', 'Sydney', 'Mcbride', '125-3202 Eu Road', '(561) 208-', 'vel.sapien@euodio.com'),
('1000000052', 'Deirdre', 'Allen', 'Ap #517-3190 Id St.', '(750) 519-', 'Pellentesque@dapibus.ca'),
('1000000053', 'Victoria', 'Savage', 'Ap #873-9104 Metus. Rd.', '(942) 517-', 'tincidunt.vehicula.risus@eu.ca'),
('1000000054', 'Mallory', 'Garner', 'P.O. Box 657, 739 Est, St.', '(111) 515-', 'tristique.pellentesque@sagitti'),
('1000000055', 'Claudia', 'Bates', '779-5930 Elementum St.', '(423) 747-', 'sodales.elit@Duis.co.uk'),
('1000000056', 'Clarke', 'Mejia', '4553 Vitae, St.', '(541) 449-', 'ipsum@disparturient.com'),
('1000000057', 'Britanni', 'Hardy', '465 Pellentesque Ave', '(112) 896-', 'non.sollicitudin@loremvitae.or'),
('1000000058', 'MacKenzie', 'Lynn', 'P.O. Box 371, 4905 In Rd.', '(187) 765-', 'in.consectetuer@orciluctuset.n'),
('1000000059', 'Jesse', 'Zamora', 'Ap #477-4975 Curae; St.', '(708) 864-', 'egestas.hendrerit.neque@Nunc.o'),
('1000000060', 'Amber', 'Hebert', '5115 A, Street', '(653) 634-', 'dolor.Fusce.feugiat@eget.edu'),
('1000000061', 'Aubrey', 'Cox', '814-6571 Est Ave', '(194) 286-', 'ridiculus.mus.Donec@risusNunc.'),
('1000000062', 'Sybill', 'Barlow', '968-7148 Egestas. Ave', '(957) 835-', 'a.mi@Suspendisse.org'),
('1000000063', 'Graham', 'Meyer', '143 Luctus Ave', '(177) 674-', 'metus.Aliquam.erat@lacusCrasin'),
('1000000064', 'Flynn', 'Hoffman', 'P.O. Box 281, 1258 In St.', '(985) 862-', 'Suspendisse@malesuadautsem.org'),
('1000000065', 'Sharon', 'Olsen', '182-302 Duis Av.', '(947) 382-', 'Aenean@Integervulputate.com'),
('1000000066', 'Brennan', 'Cooley', '8216 Hendrerit Rd.', '(892) 388-', 'Aliquam.erat@feugiatnonloborti'),
('1000000067', 'Aurora', 'Wheeler', 'P.O. Box 816, 9434 In Rd.', '(892) 965-', 'odio.vel@feugiatmetus.org'),
('1000000068', 'Roary', 'Vance', '3861 Nec, Ave', '(805) 341-', 'ac@Fuscealiquetmagna.ca'),
('1000000069', 'Travis', 'Barrett', 'P.O. Box 538, 179 Non, Ave', '(705) 465-', 'posuere@eleifend.edu'),
('1000000070', 'Nevada', 'Rosa', '816-9439 Nunc Rd.', '(670) 518-', 'euismod.in.dolor@vestibulumneq'),
('1000000071', 'Judith', 'Randall', '2199 Cras Street', '(736) 686-', 'Cras@maurisut.edu'),
('1000000072', 'Lesley', 'Fowler', '9862 Ultrices Rd.', '(819) 382-', 'mauris.a.nunc@Morbivehicula.or'),
('1000000073', 'Galena', 'William', '371 Tincidunt Road', '(627) 361-', 'ridiculus.mus.Proin@Duissitame'),
('1000000074', 'Denise', 'Harrington', '661-4998 A Rd.', '(463) 216-', 'lectus@turpisegestasFusce.ca'),
('1000000075', 'Luke', 'Gibson', '8346 Elementum, St.', '(485) 139-', 'malesuada.fames.ac@nibhsitamet'),
('1000000076', 'Carter', 'Pennington', '907-9405 Auctor, Street', '(764) 229-', 'Integer.eu@nisi.edu'),
('1000000077', 'Tad', 'Olsen', '3144 Tincidunt Road', '(982) 412-', 'malesuada@leoelementumsem.ca'),
('1000000078', 'Wing', 'Tanner', '539-3002 Et St.', '(614) 874-', 'tristique.aliquet@euismodmauri'),
('1000000079', 'Kelly', 'Levy', 'Ap #870-4413 Faucibus Av.', '(207) 334-', 'enim@risus.edu'),
('1000000080', 'Melodie', 'Bird', '144-8783 Vitae St.', '(805) 947-', 'fames.ac.turpis@facilisis.net'),
('1000000081', 'Lacota', 'Serrano', 'Ap #543-1416 Tincidunt Rd.', '(157) 593-', 'ridiculus.mus.Proin@egestaslig'),
('1000000082', 'Roanna', 'Mueller', '3574 Quisque Rd.', '(665) 395-', 'varius.ultrices@utipsumac.net'),
('1000000083', 'Shelly', 'Rogers', 'Ap #254-2017 Venenatis St.', '(190) 345-', 'porttitor.eros.nec@acmetus.net'),
('1000000084', 'Willow', 'Price', 'Ap #288-1715 Lectus. St.', '(395) 564-', 'volutpat.Nulla.dignissim@primi'),
('1000000085', 'Gary', 'Flores', '8638 Ut St.', '(634) 150-', 'est.ac@nequevenenatislacus.com'),
('1000000086', 'Tanisha', 'Ball', 'Ap #595-9121 Et St.', '(970) 642-', 'lorem@velitSedmalesuada.ca'),
('1000000087', 'Hedda', 'Burgess', '908-4294 Amet, Ave', '(682) 659-', 'Donec.egestas@egestasFusce.com'),
('1000000088', 'Chiquita', 'Kirkland', '408-130 Quam, Av.', '(693) 312-', 'eu.arcu@adipiscinglacusUt.edu'),
('1000000089', 'Vance', 'Pennington', 'P.O. Box 244, 341 Aenean Ave', '(225) 875-', 'a.malesuada@fringillaDonecfeug'),
('1000000090', 'Gwendolyn', 'Baker', '4987 Fermentum Ave', '(964) 450-', 'aliquet@utodio.co.uk'),
('1000000091', 'Jarrod', 'Olson', 'P.O. Box 318, 8868 Fermentum Road', '(858) 724-', 'nulla@nulla.org'),
('1000000092', 'Lisandra', 'Contreras', '8182 Ultrices. Ave', '(237) 199-', 'id@ac.net'),
('1000000093', 'Shad', 'Dean', '7235 Vivamus Rd.', '(620) 772-', 'litora.torquent.per@tortordict'),
('1000000094', 'Hadley', 'Berg', 'P.O. Box 516, 6601 Adipiscing Rd.', '(384) 469-', 'rhoncus.Proin.nisl@suscipit.ne'),
('1000000095', 'Micah', 'Macias', 'P.O. Box 809, 706 Dictum Road', '(824) 913-', 'Sed.et@atlacusQuisque.net'),
('1000000096', 'Lara', 'Bartlett', 'P.O. Box 455, 4963 Integer St.', '(140) 866-', 'quis.diam@lectus.edu'),
('1000000097', 'Cairo', 'Giles', '940-2967 Primis Av.', '(694) 565-', 'Aliquam.ultrices@augueSed.org'),
('1000000098', 'Yuli', 'Huber', 'Ap #821-6339 Placerat Rd.', '(970) 713-', 'et.magna@euturpisNulla.org'),
('1000000099', 'Kameko', 'House', '886 Lobortis Rd.', '(418) 396-', 'nibh.lacinia.orci@lacus.ca'),
('1104892367', 'John', 'Villavicencio', 'Las Pitas, Universo ', '0994368052', 'jjvillavicencio@utpl.edu.ec'),
('1104961550', 'Vanessa', 'Sotomayor', 'Daniel Alvarez', '2564897', 'vsotomayor@utpl.edu.ec'),
('1106090531', 'Macarena', 'Criollo', 'Las Pitas', '4895', 'maki2009@hhg.com'),
('1425789634', 'Prueba de factura', 'factura prueba', 'La prueba y factura', '2489654', 'shgagd@factura'),
('14578965', 'Cliente Prueba', 'prueba', 'Dir prueba', '789456', 'prueba@com'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`idProvincia`, `nombre`, `idPais`) VALUES
(4, 'Loja', 1),
(5, 'Zamora Chinchipe', 1),
(6, 'Piura', 2),
(7, 'Azuay', 1),
(8, 'Guayas', 1),
(9, 'Los Rios', 1),
(10, 'ManabÃ­', 1),
(11, 'Santo Domingo', 1),
(12, 'Bolivar', 1),
(13, 'CaÃ±ar', 1),
(14, 'Carchi', 1),
(15, 'Chimborazo', 1),
(16, 'Cotopaxi', 1),
(17, 'Imbabura', 1),
(18, 'El Oro', 1),
(19, 'Esmeraldas', 1),
(20, 'Morona Santiago', 1),
(21, 'Napo', 1),
(22, 'Orellana', 1),
(23, 'Pastaza', 1),
(24, 'Pichincha', 1),
(25, 'Sucumbios', 1),
(26, 'Tungurahua', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE IF NOT EXISTS `rutas` (
  `idRuta` int(11) NOT NULL AUTO_INCREMENT,
  `LugarPartida` int(11) NOT NULL,
  `lugarLlegada` int(11) NOT NULL,
  PRIMARY KEY (`idRuta`),
  KEY `LugarPartida` (`LugarPartida`,`lugarLlegada`),
  KEY `LugarPartida_2` (`LugarPartida`),
  KEY `lugarLlegada` (`lugarLlegada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`idRuta`, `LugarPartida`, `lugarLlegada`) VALUES
(3, 3, 10),
(2, 3, 12),
(1, 4, 3),
(6, 5, 16),
(7, 7, 12),
(4, 11, 10),
(5, 14, 4);

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
(1, 9, 1),
(1, 12, 1),
(1, 17, 1),
(1, 52, 1),
(1, 78, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`idTipo`, `nombre`) VALUES
(1, 'Especial'),
(2, 'Normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE IF NOT EXISTS `turno` (
  `idTurno` int(11) NOT NULL AUTO_INCREMENT,
  `numBus` int(11) NOT NULL,
  `idRuta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `horaSalida` time NOT NULL,
  `tipo` int(11) NOT NULL,
  `valor` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idTurno`),
  KEY `numBus` (`numBus`),
  KEY `idRuta` (`idRuta`),
  KEY `tipo` (`tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`idTurno`, `numBus`, `idRuta`, `fecha`, `horaSalida`, `tipo`, `valor`) VALUES
(9, 1, 6, '2014-02-10', '05:00:00', 2, '5.00'),
(10, 5, 6, '2014-02-10', '08:00:00', 1, '6.00'),
(11, 10, 6, '2014-02-10', '15:00:00', 2, '5.00'),
(12, 14, 3, '2014-02-10', '09:00:00', 1, '8.00'),
(13, 1, 3, '2014-02-10', '15:00:00', 2, '7.00'),
(14, 5, 2, '2014-02-11', '06:00:00', 1, '25.00'),
(15, 14, 2, '2014-02-11', '15:00:00', 2, '20.00'),
(16, 5, 4, '2014-02-11', '09:00:00', 2, '3.00'),
(17, 14, 3, '2014-02-11', '12:00:00', 2, '8.00'),
(18, 10, 7, '2014-02-14', '06:50:00', 1, '30.00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `cedula`, `nombreUsr`, `claveUsr`) VALUES
(1, '1104892367', 'jjonix', 'e10adc3949ba59abbe56e057f20f883e'),
(2, '1104892367', 'user3', '25f9e794323b453885f5181f1b624d0b'),
(3, '1104961550', 'User', '25f9e794323b453885f5181f1b624d0b');

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
  ADD CONSTRAINT `boleto_ibfk_3` FOREIGN KEY (`numFactura`) REFERENCES `factura` (`idFactura`);

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
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`agencia`) REFERENCES `agencia` (`idAgencia`) ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`idCedula`) REFERENCES `persona` (`cedula`);

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
  ADD CONSTRAINT `rutas_ibfk_2` FOREIGN KEY (`lugarLlegada`) REFERENCES `canton` (`idCanton`);

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
  ADD CONSTRAINT `turno_ibfk_2` FOREIGN KEY (`idRuta`) REFERENCES `rutas` (`idRuta`),
  ADD CONSTRAINT `turno_ibfk_3` FOREIGN KEY (`tipo`) REFERENCES `tipo` (`idTipo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `persona` (`cedula`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
