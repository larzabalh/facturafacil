-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 01-10-2018 a las 19:47:34
-- Versión del servidor: 5.7.21
-- Versión de PHP: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facturafacil`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condicioniva_id` int(11) DEFAULT NULL,
  `razonSocial` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cuit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dni` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domiciliocomercial` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clienteProveedor` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `concepto` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monto` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F41C9B25F1A0F41C` (`condicioniva_id`),
  KEY `IDX_F41C9B25DB38439E` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicioniva`
--

DROP TABLE IF EXISTS `condicioniva`;
CREATE TABLE IF NOT EXISTS `condicioniva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `condicioniva`
--

INSERT INTO `condicioniva` (`id`, `descripcion`, `estado`) VALUES
(1, 'Consumidor Final', 'A'),
(2, 'Responsable Inscripto', 'A'),
(3, 'Responsable Monotributo', 'A'),
(4, 'Excento', 'A'),
(5, 'No Responsable', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

DROP TABLE IF EXISTS `factura`;
CREATE TABLE IF NOT EXISTS `factura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `importe` double DEFAULT NULL,
  `tipofactura` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipodocumento` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cae` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechavtocae` datetime DEFAULT NULL,
  `codigobarraafip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nrofactura` int(11) DEFAULT NULL,
  `observacion` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `punto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fechadesde` datetime DEFAULT NULL,
  `fechahasta` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F9EBA009DE734E51` (`cliente_id`),
  KEY `IDX_F9EBA009B3CB6227` (`punto_id`),
  KEY `IDX_F9EBA009DB38439E` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `factura`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stock` double DEFAULT NULL,
  `costo` double DEFAULT NULL,
  `codigo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productofactura`
--

DROP TABLE IF EXISTS `productofactura`;
CREATE TABLE IF NOT EXISTS `productofactura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `precio` double NOT NULL,
  `descuento` double DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ADFFE8C47645698E` (`producto_id`),
  KEY `IDX_ADFFE8C4F04F795F` (`factura_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productofactura`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntoventa`
--

DROP TABLE IF EXISTS `puntoventa`;
CREATE TABLE IF NOT EXISTS `puntoventa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` int(11) NOT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C2D68902DB38439E` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `puntoventa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `perfil` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cuit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iibb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechainicio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razonsocial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domicilio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` longblob,
  `condicioniva_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2265B05DF1A0F41C` (`condicioniva_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `clave`, `mail`, `estado`, `perfil`, `cuit`, `iibb`, `fechainicio`, `razonsocial`, `domicilio`, `condicioniva_id`) VALUES
(1, 'admin', 'admin', 'larzabalh@gmail.com', 'A', 'ADMINISTRADOR', '20284681909', '20284681909', '', 'Hernan Larzabal', '-', 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `FK_F41C9B25DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_F41C9B25F1A0F41C` FOREIGN KEY (`condicioniva_id`) REFERENCES `condicioniva` (`id`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_F9EBA009B3CB6227` FOREIGN KEY (`punto_id`) REFERENCES `puntoventa` (`id`),
  ADD CONSTRAINT `FK_F9EBA009DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_F9EBA009DE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

--
-- Filtros para la tabla `productofactura`
--
ALTER TABLE `productofactura`
  ADD CONSTRAINT `FK_ADFFE8C47645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `FK_ADFFE8C4F04F795F` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`);

--
-- Filtros para la tabla `puntoventa`
--
ALTER TABLE `puntoventa`
  ADD CONSTRAINT `FK_C2D68902DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_2265B05DF1A0F41C` FOREIGN KEY (`condicioniva_id`) REFERENCES `condicioniva` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
