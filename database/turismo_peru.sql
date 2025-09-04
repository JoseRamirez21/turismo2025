-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-09-2025 a las 23:57:29
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
-- Base de datos: `turismo_peru`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre`) VALUES
(1, 'Amazonas'),
(2, 'Áncash'),
(3, 'Apurímac'),
(4, 'Arequipa'),
(5, 'Ayacucho'),
(6, 'Cajamarca'),
(7, 'Callao'),
(8, 'Cusco'),
(9, 'Huancavelica'),
(10, 'Huánuco'),
(11, 'Ica'),
(12, 'Junín'),
(13, 'La Libertad'),
(14, 'Lambayeque'),
(15, 'Lima'),
(16, 'Loreto'),
(17, 'Madre de Dios'),
(18, 'Moquegua'),
(19, 'Pasco'),
(20, 'Piura'),
(21, 'Puno'),
(22, 'San Martín'),
(23, 'Tacna'),
(24, 'Tumbes'),
(25, 'Ucayali');

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `provincias`
--
CREATE TABLE IF NOT EXISTS `provincias` (
  `id_provincia` int(11) NOT NULL AUTO_INCREMENT,
  `id_departamento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_provincia`),
  CONSTRAINT `fk_provincia_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos`(`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `provincias`
--


INSERT INTO `provincias` (`id_provincia`, `id_departamento`, `nombre`) VALUES
(1, 1, 'Chachapoyas'),
(2, 1, 'Bagua'),
(3, 2, 'Huaraz'),
(4, 2, 'Chimbote'),
(5, 3, 'Abancay'),
(6, 3, 'Andahuaylas'),
(7, 4, 'Arequipa'),
(8, 4, 'Caylloma'),
(9, 5, 'Huamanga'),
(10, 5, 'Cangallo'),
(11, 6, 'Cajamarca'),
(12, 6, 'Celendín'),
(13, 7, 'Callao'),
(14, 7, 'La Perla'),
(15, 8, 'Cusco'),
(16, 8, 'Urubamba'),
(17, 9, 'Huancavelica'),
(18, 9, 'Tayacaja'),
(19, 10, 'Huánuco'),
(20, 10, 'Leoncio Prado'),
(21, 11, 'Ica'),
(22, 11, 'Pisco'),
(23, 12, 'Huancayo'),
(24, 12, 'Chanchamayo'),
(25, 13, 'Trujillo'),
(26, 13, 'Ascope'),
(27, 14, 'Chiclayo'),
(28, 14, 'Ferreñafe'),
(29, 15, 'Lima'),
(30, 15, 'Huaral'),
(31, 16, 'Maynas'),
(32, 16, 'Alto Amazonas'),
(33, 17, 'Tambopata'),
(34, 17, 'Manu'),
(35, 18, 'Mariscal Nieto'),
(36, 18, 'Ilo'),
(37, 19, 'Pasco'),
(38, 19, 'Oxapampa'),
(39, 20, 'Piura'),
(40, 20, 'Sullana'),
(41, 21, 'Puno'),
(42, 21, 'Juliaca'),
(43, 22, 'Moyobamba'),
(44, 22, 'Tarapoto'),
(45, 23, 'Tacna'),
(46, 23, 'Tarata'),
(47, 24, 'Tumbes'),
(48, 24, 'Zarumilla'),
(49, 25, 'Coronel Portillo'),
(50, 25, 'Atalaya');

--
-- Estructura de tabla para la tabla `distritos`
--

CREATE TABLE IF NOT EXISTS `distritos` (
  `id_distrito` int(11) NOT NULL AUTO_INCREMENT,
  `id_provincia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_distrito`),
  CONSTRAINT `fk_distrito_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincias`(`id_provincia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `distritos`
--

INSERT INTO `distritos` (`id_distrito`, `id_provincia`, `nombre`) VALUES
(1, 1, 'Chachapoyas'),
(2, 1, 'Asunción'),
(3, 1, 'Sonche'),
(4, 2, 'Bagua'),
(5, 2, 'Aramango'),
(6, 2, 'Copallín'),
(7, 3, 'Huaraz'),
(8, 3, 'Independencia'),
(9, 3, 'Cochabamba'),
(10, 4, 'Chimbote'),
(11, 4, 'Nuevo Chimbote'),
(12, 4, 'Santa'),
(13, 5, 'Abancay'),
(14, 5, 'Tamburco'),
(15, 5, 'Curahuasi'),
(16, 6, 'Andahuaylas'),
(17, 6, 'Talavera'),
(18, 6, 'Pacucha'),
(19, 7, 'Arequipa'),
(20, 7, 'Cayma'),
(21, 7, 'Yanahuara'),
(22, 8, 'Caylloma'),
(23, 8, 'Chivay'),
(24, 8, 'Maca'),
(25, 9, 'Huamanga'),
(26, 9, 'San Juan Bautista'),
(27, 9, 'Ayacucho Centro'),
(28, 10, 'Cangallo'),
(29, 10, 'Paras'),
(30, 10, 'Totos'),
(31, 11, 'Cajamarca'),
(32, 11, 'Baños del Inca'),
(33, 11, 'Chetilla'),
(34, 12, 'Celendín'),
(35, 12, 'Chumuch'),
(36, 12, 'Oxamarca'),
(37, 13, 'Callao'),
(38, 13, 'Bellavista'),
(39, 13, 'La Punta'),
(40, 14, 'La Perla'),
(41, 14, 'Carmen de la Legua'),
(42, 14, 'Mi Perú'),
(43, 15, 'Cusco'),
(44, 15, 'San Sebastián'),
(45, 15, 'Santiago'),
(46, 16, 'Urubamba'),
(47, 16, 'Ollantaytambo'),
(48, 16, 'Yucay'),
(49, 17, 'Huancavelica'),
(50, 17, 'Acobamba'),
(51, 17, 'Lircay'),
(52, 18, 'Tayacaja'),
(53, 18, 'Tintay Puncu'),
(54, 18, 'Quichuas'),
(55, 19, 'Huánuco'),
(56, 19, 'Amarilis'),
(57, 19, 'Churubamba'),
(58, 20, 'Leoncio Prado'),
(59, 20, 'Rupa-Rupa'),
(60, 20, 'José Crespo y Castillo'),
(61, 21, 'Ica'),
(62, 21, 'Parcona'),
(63, 21, 'Los Aquijes'),
(64, 22, 'Pisco'),
(65, 22, 'San Clemente'),
(66, 22, 'Huancano'),
(67, 23, 'Huancayo'),
(68, 23, 'Chongos Bajo'),
(69, 23, 'El Tambo'),
(70, 24, 'Chanchamayo'),
(71, 24, 'La Merced'),
(72, 24, 'San Ramón'),
(73, 25, 'Trujillo'),
(74, 25, 'El Porvenir'),
(75, 25, 'Víctor Larco'),
(76, 26, 'Ascope'),
(77, 26, 'Chocope'),
(78, 26, 'Casa Grande'),
(79, 27, 'Chiclayo'),
(80, 27, 'José Leonardo Ortiz'),
(81, 27, 'Pimentel'),
(82, 28, 'Ferreñafe'),
(83, 28, 'Pitipo'),
(84, 28, 'Incahuasi'),
(85, 29, 'Lima'),
(86, 29, 'Miraflores'),
(87, 29, 'San Isidro'),
(88, 30, 'Huaral'),
(89, 30, 'Aucallama'),
(90, 30, 'Chancay'),
(91, 31, 'Maynas'),
(92, 31, 'Iquitos'),
(93, 31, 'Punchana'),
(94, 32, 'Alto Amazonas'),
(95, 32, 'Yurimaguas'),
(96, 32, 'Lagunas'),
(97, 33, 'Tambopata'),
(98, 33, 'Puerto Maldonado'),
(99, 33, 'Inambari'),
(100, 34, 'Manu'),
(101, 34, 'Fitzcarrald'),
(102, 34, 'Madre de Dios'),
(103, 35, 'Mariscal Nieto'),
(104, 35, 'Moquegua Centro'),
(105, 35, 'Samegua'),
(106, 36, 'Ilo'),
(107, 36, 'Pacocha'),
(108, 36, 'El Algarrobal'),
(109, 37, 'Pasco'),
(110, 37, 'Chaupimarca'),
(111, 37, 'Yanacancha'),
(112, 38, 'Oxapampa'),
(113, 38, 'Palcazu'),
(114, 38, 'Villa Rica'),
(115, 39, 'Piura'),
(116, 39, 'Catacaos'),
(117, 39, 'La Unión'),
(118, 40, 'Sullana'),
(119, 40, 'Bellavista'),
(120, 40, 'Marcavelica'),
(121, 41, 'Puno'),
(122, 41, 'Platería'),
(123, 41, 'Capachica'),
(124, 42, 'Juliaca'),
(125, 42, 'San Miguel'),
(126, 42, 'Cabana'),
(127, 43, 'Moyobamba'),
(128, 43, 'Habana'),
(129, 43, 'Yantaló'),
(130, 44, 'Tarapoto'),
(131, 44, 'La Banda de Shilcayo'),
(132, 44, 'San Martín'),
(133, 45, 'Tacna'),
(134, 45, 'Alto de la Alianza'),
(135, 45, 'Calana'),
(136, 46, 'Tarata'),
(137, 46, 'Sitajara'),
(138, 46, 'Susapaya'),
(139, 47, 'Tumbes'),
(140, 47, 'Corrales'),
(141, 47, 'San Juan de la Virgen'),
(142, 48, 'Zarumilla'),
(143, 48, 'Matapalo'),
(144, 48, 'Papayal'),
(145, 49, 'Coronel Portillo'),
(146, 49, 'Callería'),
(147, 49, 'Yarinacocha'),
(148, 50, 'Atalaya'),
(149, 50, 'Raymondi'),
(150, 50, 'Sepahua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares_turisticos`
--

CREATE TABLE IF NOT EXISTS `lugares_turisticos` (
  `id_lugar` int(11) NOT NULL AUTO_INCREMENT,
  `id_distrito` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `latitud` decimal(10,7) DEFAULT NULL,
  `longitud` decimal(10,7) DEFAULT NULL,
  PRIMARY KEY (`id_lugar`),
  CONSTRAINT `fk_lugar_distrito` FOREIGN KEY (`id_distrito`) REFERENCES `distritos`(`id_distrito`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lugares_turisticos`
--

INSERT INTO `lugares_turisticos` (`id_lugar`, `id_distrito`, `nombre`, `descripcion`, `tipo`, `latitud`, `longitud`) VALUES
(1, 1, 'Kuélap', 'Fortaleza preincaica ubicada en la provincia de Chachapoyas', 'Histórico', -6.5700000, -77.8600000),
(2, 2, 'Gocta', 'Cascada impresionante en el distrito de Asunción', 'Natural', -6.5630000, -77.8710000),
(3, 3, 'Revash', 'Necrópolis de arquitectura funeraria', 'Histórico', -6.5500000, -77.8550000),
(4, 4, 'Caverna de Quiocta', 'Cueva con arte rupestre en Bagua', 'Cultural', -5.7000000, -78.5000000),
(5, 5, 'Laguna Pomacochas', 'Laguna de aguas turquesas', 'Natural', -5.8000000, -78.6000000),
(6, 6, 'Santuario de Ampay', 'Área natural protegida', 'Natural', -5.7500000, -78.5500000),
(7, 3, 'Huascarán', 'Parque Nacional con el pico más alto del Perú', 'Natural', -9.1190000, -77.6050000),
(8, 4, 'Laguna Llanganuco', 'Lagunas de aguas turquesas en Huaraz', 'Natural', -9.1660000, -77.6200000),
(9, 5, 'Chavín de Huantar', 'Sitio arqueológico preincaico', 'Histórico', -9.5850000, -77.5270000),
(10, 6, 'Playa Tortugas', 'Playas cerca de Chimbote', 'Natural', -9.0720000, -78.5700000),
(11, 7, 'Museo Reque', 'Museo de cultura Moche', 'Cultural', -9.1000000, -78.5800000),
(12, 8, 'Callejón de Huaylas', 'Valle entre montañas', 'Natural', -9.2000000, -77.6500000),
(13, 9, 'Choquequirao', 'Ruinas Inca menos conocidas que Machu Picchu', 'Histórico', -13.5000000, -72.1000000),
(14, 10, 'Saywite', 'Monumento arqueológico con grabados', 'Histórico', -13.6500000, -72.2000000),
(15, 11, 'Laguna de Pacucha', 'Laguna rodeada de montañas', 'Natural', -13.6000000, -72.1500000),
(16, 12, 'Capilla de Curahuasi', 'Templo colonial', 'Cultural', -13.7000000, -72.2500000),
(17, 13, 'Mirador de Andahuaylas', 'Vista panorámica de la ciudad', 'Natural', -13.6500000, -73.2000000),
(18, 14, 'Puente Colgante de Abancay', 'Puente histórico y turístico', 'Cultural', -13.6000000, -72.8800000),
(19, 15, 'Cañón del Colca', 'Famoso por el vuelo del cóndor', 'Natural', -15.6000000, -71.9000000),
(20, 16, 'Monasterio de Santa Catalina', 'Convento histórico y turístico', 'Histórico', -16.3980000, -71.5360000),
(21, 17, 'Plaza de Armas de Arequipa', 'Centro histórico', 'Cultural', -16.3989000, -71.5350000),
(22, 18, 'Yanahuara', 'Mirador con vista a volcanes', 'Natural', -16.3890000, -71.5310000),
(23, 19, 'Valle de los Volcanes', 'Paisaje geológico impresionante', 'Natural', -16.3500000, -71.4500000),
(24, 20, 'Museo Santuarios Andinos', 'Museo con momia Juanita', 'Cultural', -16.3985000, -71.5355000),
(25, 21, 'Plaza de Armas de Huamanga', 'Centro histórico de Huamanga', 'Cultural', -13.1550000, -74.2230000),
(26, 22, 'Iglesia de la Merced', 'Iglesia colonial en Huamanga', 'Histórico', -13.1530000, -74.2240000),
(27, 23, 'Puquio', 'Distrito con restos arqueológicos', 'Histórico', -13.5200000, -74.3200000),
(28, 24, 'Parque de Cangallo', 'Espacio cultural en Cangallo', 'Cultural', -13.6670000, -74.2000000),
(29, 25, 'Laguna de Parinacochas', 'Laguna rodeada de naturaleza', 'Natural', -14.2000000, -74.0500000),
(30, 26, 'Vilcashuamán', 'Ruinas preincaicas', 'Histórico', -13.0500000, -74.2000000),
(31, 27, 'Cajamarca Plaza de Armas', 'Centro histórico con arquitectura colonial', 'Cultural', -7.1600000, -78.5000000),
(32, 28, 'Baños del Inca', 'Termas naturales', 'Natural', -7.1350000, -78.5000000),
(33, 29, 'Cumbemayo', 'Acueducto y formaciones rocosas', 'Histórico', -7.1600000, -78.6000000),
(34, 30, 'Celendín Mirador', 'Vista panorámica de Celendín', 'Natural', -6.5000000, -78.5000000),
(35, 31, 'Lagunas de Cutervo', 'Parque Nacional con lagunas', 'Natural', -6.7000000, -78.4000000),
(36, 32, 'Iglesia de Cajamarca', 'Templo histórico colonial', 'Histórico', -7.1605000, -78.5020000),
(37, 33, 'Fortaleza del Real Felipe', 'Monumento histórico militar', 'Histórico', -12.0540000, -77.1180000),
(38, 34, 'Islas Palomino', 'Reserva natural con fauna marina', 'Natural', -12.0440000, -77.1000000),
(39, 35, 'Playa La Punta', 'Playa turística del Callao', 'Natural', -12.0500000, -77.1150000),
(40, 36, 'Museo Naval', 'Museo histórico del Callao', 'Cultural', -12.0545000, -77.1175000),
(41, 37, 'Puerto del Callao', 'Zona portuaria histórica', 'Cultural', -12.0560000, -77.1185000),
(42, 38, 'Carmen de la Legua', 'Distrito turístico con plazas', 'Cultural', -12.0700000, -77.1200000),
(43, 39, 'Plaza de Armas de Cusco', 'Centro histórico', 'Cultural', -13.5167000, -71.9781000),
(44, 40, 'Qorikancha', 'Templo del Sol Inca', 'Histórico', -13.5150000, -71.9780000),
(45, 41, 'Sacsayhuamán', 'Ruinas arqueológicas', 'Histórico', -13.5090000, -71.9810000),
(46, 42, 'Ollantaytambo', 'Pueblo y ruinas incas', 'Histórico', -13.2580000, -72.2640000),
(47, 43, 'Valle Sagrado', 'Conjunto de pueblos y ruinas', 'Natural', -13.2880000, -72.0750000),
(48, 44, 'Pisac', 'Mercado y ruinas arqueológicas', 'Cultural', -13.3490000, -71.8610000),
(49, 45, 'Mercado de Huancavelica', 'Centro comercial y cultural', 'Cultural', -12.7800000, -74.9700000),
(50, 46, 'Iglesia de Huancavelica', 'Iglesia colonial histórica', 'Histórico', -12.7790000, -74.9705000),
(51, 47, 'Baños Termales de Lircay', 'Aguas termales naturales', 'Natural', -12.7500000, -74.9600000),
(52, 48, 'Mirador de Acobamba', 'Vista panorámica de la provincia', 'Natural', -12.8500000, -75.0000000),
(53, 49, 'Parque de Tayacaja', 'Espacio recreativo y cultural', 'Cultural', -12.8000000, -74.9500000),
(54, 50, 'Ruinas de Huayllay', 'Sitio arqueológico preincaico', 'Histórico', -12.7900000, -74.9600000),
(55, 51, 'Catedral de Huánuco', 'Templo histórico colonial', 'Histórico', -9.9300000, -76.2400000),
(56, 52, 'Caverna de Huayllay', 'Formaciones rocosas naturales', 'Natural', -9.9500000, -76.2500000),
(57, 53, 'Parque Ecológico', 'Área de recreación y naturaleza', 'Natural', -9.9400000, -76.2450000),
(58, 54, 'Leoncio Prado', 'Distrito con historia', 'Cultural', -9.9200000, -76.2300000),
(59, 55, 'Laguna Patarcocha', 'Laguna rodeada de naturaleza', 'Natural', -9.9600000, -76.2600000),
(60, 56, 'Museo Regional Huánuco', 'Museo cultural y arqueológico', 'Cultural', -9.9350000, -76.2380000),
(61, 57, 'Oasis de Huacachina', 'Laguna en medio del desierto', 'Natural', -14.1250000, -75.7650000),
(62, 58, 'Paracas', 'Reserva nacional con fauna marina', 'Natural', -13.8500000, -76.2600000),
(63, 59, 'Nazca Líneas', 'Geoglifos milenarios', 'Histórico', -14.7000000, -75.1200000),
(64, 60, 'Museo Regional de Ica', 'Museo de historia y cultura', 'Cultural', -14.0680000, -75.7280000),
(65, 61, 'Viñedos Ica', 'Ruta de vinos y piscos', 'Cultural', -14.0650000, -75.7200000),
(66, 62, 'Playa Lagunilla', 'Playa turística en Ica', 'Natural', -14.0700000, -75.7300000),
(67, 63, 'Huancayo Plaza de Armas', 'Centro histórico', 'Cultural', -12.0660000, -75.2050000),
(68, 64, 'Satipo', 'Zona natural y ríos', 'Natural', -11.2500000, -74.8000000),
(69, 65, 'Concepción', 'Distrito histórico', 'Histórico', -11.7660000, -75.2590000),
(70, 66, 'La Merced', 'Atractivo turístico natural', 'Natural', -11.9800000, -75.3900000),
(71, 67, 'Chanchamayo', 'Zona de aventura y ecoturismo', 'Natural', -11.9600000, -75.3900000),
(72, 68, 'Museo de Huancayo', 'Museo cultural', 'Cultural', -12.0670000, -75.2055000),
(73, 69, 'Chan Chan', 'Ciudadela de adobe preincaica', 'Histórico', -8.1220000, -79.0380000),
(74, 70, 'Playa Huanchaco', 'Playa con caballitos de totora', 'Natural', -8.1140000, -79.0390000),
(75, 71, 'Trujillo Plaza de Armas', 'Centro histórico', 'Cultural', -8.1110000, -79.0280000),
(76, 72, 'Huaca de la Luna', 'Ruinas Moche', 'Histórico', -8.1340000, -79.0200000),
(77, 73, 'El Brujo', 'Sitio arqueológico', 'Histórico', -7.9970000, -79.2600000),
(78, 74, 'Parque de Ascope', 'Zona recreativa', 'Cultural', -8.0400000, -79.0100000),
(79, 75, 'Museo Tumbas Reales de Sipán', 'Museo de la cultura Moche', 'Cultural', -6.7790000, -79.9310000),
(80, 76, 'Complejo Arqueológico Huaca Rajada', 'Sitio arqueológico Moche', 'Histórico', -6.7780000, -79.9300000),
(81, 77, 'Plaza de Chiclayo', 'Centro histórico', 'Cultural', -6.7700000, -79.8280000),
(82, 78, 'Reserva Ecológica Chaparrí', 'Área natural protegida', 'Natural', -6.7000000, -79.9000000),
(83, 79, 'Pimentel', 'Playa y balneario', 'Natural', -6.7800000, -79.9300000),
(84, 80, 'Ferreñafe', 'Distrito histórico', 'Histórico', -6.6300000, -79.9000000),
(85, 81, 'Plaza Mayor de Lima', 'Centro histórico de la ciudad', 'Cultural', -12.0464000, -77.0428000),
(86, 82, 'Parque Kennedy', 'Zona turística en Miraflores', 'Natural', -12.1214000, -77.0300000),
(87, 83, 'Huaca Pucllana', 'Sitio arqueológico preincaico', 'Histórico', -12.1210000, -77.0305000),
(88, 84, 'Malecón de Miraflores', 'Vista al océano Pacífico', 'Natural', -12.1180000, -77.0320000),
(89, 85, 'Museo Larco', 'Museo de arte precolombino', 'Cultural', -12.0640000, -77.0220000),
(90, 86, 'Huaral', 'Ciudad con atractivos naturales', 'Natural', -11.4950000, -77.2100000),
(91, 87, 'Reserva Nacional Pacaya Samiria', 'Selva amazónica y fauna', 'Natural', -4.1650000, -73.7800000),
(92, 88, 'Iquitos', 'Ciudad turística amazónica', 'Cultural', -3.7437000, -73.2516000),
(93, 89, 'Río Amazonas', 'Navegación por el río', 'Natural', -3.5000000, -73.2000000),
(94, 90, 'Parque Nacional Yaguas', 'Área protegida de selva', 'Natural', -3.9500000, -73.9500000),
(95, 91, 'Islas de Pacaya', 'Turismo fluvial', 'Natural', -4.0000000, -73.8000000),
(96, 92, 'Alto Amazonas', 'Zona con comunidades nativas', 'Cultural', -4.2000000, -73.9000000),
(97, 93, 'Reserva Nacional Tambopata', 'Selva amazónica y fauna', 'Natural', -12.8300000, -69.3000000),
(98, 94, 'Puerto Maldonado', 'Ciudad turística amazónica', 'Cultural', -12.5900000, -69.1900000),
(99, 95, 'Lago Sandoval', 'Laguna con fauna silvestre', 'Natural', -12.8500000, -69.3300000),
(100, 96, 'Manu', 'Área protegida y biodiversidad', 'Natural', -12.1500000, -71.2000000),
(101, 97, 'Centro de Rescate de Fauna', 'Conservación de animales', 'Cultural', -12.6000000, -69.2500000),
(102, 98, 'Tambopata River', 'Río amazónico para turismo', 'Natural', -12.8200000, -69.3100000),
(103, 99, 'Valle de Moquegua', 'Paisaje natural y cultural', 'Natural', -17.1920000, -70.9350000),
(104, 100, 'Ilo', 'Puerto y playas', 'Natural', -17.6500000, -71.3400000),
(105, 101, 'Museo Contisuyo', 'Museo arqueológico', 'Cultural', -17.1925000, -70.9355000),
(106, 102, 'Mariscal Nieto', 'Distrito histórico', 'Cultural', -17.1930000, -70.9360000),
(107, 103, 'Playa Boca del Río', 'Balneario turístico', 'Natural', -17.6600000, -71.3500000),
(108, 104, 'Camino del Inca', 'Rutas históricas', 'Histórico', -17.2000000, -70.9400000),
(109, 105, 'Bosque de Yanachaga', 'Reserva natural', 'Natural', -10.6500000, -75.3500000),
(110, 106, 'Oxapampa', 'Ciudad turística y ecológica', 'Cultural', -10.4600000, -75.3500000),
(111, 107, 'Pozuzo', 'Colonia austro-alemana', 'Cultural', -10.5000000, -75.3000000),
(112, 108, 'Laguna Patarcocha', 'Laguna con pesca y naturaleza', 'Natural', -10.6400000, -75.3600000),
(113, 109, 'Pasco Ciudad', 'Centro histórico', 'Cultural', -10.6900000, -76.2600000),
(114, 110, 'Daniel Alcides Carrión', 'Distrito con historia minera', 'Histórico', -10.6800000, -75.3000000),
(115, 111, 'Playa Máncora', 'Destino playero turístico', 'Natural', -4.1000000, -81.0500000),
(116, 112, 'Catacaos', 'Centro artesanal y cultural', 'Cultural', -5.2000000, -80.6300000),
(117, 113, 'Sechura', 'Desierto y playas', 'Natural', -5.5700000, -80.8000000),
(118, 114, 'Sullana', 'Ciudad con atractivos históricos', 'Cultural', -4.9000000, -80.6800000),
(119, 115, 'Laguna de Ñapique', 'Laguna natural', 'Natural', -5.1000000, -80.7000000),
(120, 116, 'Parque Nacional Cerros de Amotape', 'Reserva natural', 'Natural', -3.9000000, -80.9000000),
(121, 117, 'Lago Titicaca', 'Lago navegable más alto del mundo', 'Natural', -15.8400000, -69.0700000),
(122, 118, 'Islas de los Uros', 'Islas flotantes', 'Cultural', -15.8630000, -69.0570000),
(123, 119, 'Sillustani', 'Necrópolis preincaica', 'Histórico', -15.8000000, -70.1100000),
(124, 120, 'Juliaca', 'Ciudad comercial y cultural', 'Cultural', -15.5000000, -70.1300000),
(125, 121, 'Chucuito', 'Sitio histórico', 'Histórico', -15.7800000, -70.1000000),
(126, 122, 'Yunguyo', 'Distrito fronterizo y cultural', 'Cultural', -16.1500000, -69.5000000),
(127, 123, 'Parque Nacional Río Abiseo', 'Área natural protegida', 'Natural', -6.5000000, -77.5000000),
(128, 124, 'Tarapoto', 'Ciudad turística amazónica', 'Cultural', -6.5000000, -76.3800000),
(129, 125, 'Lagunas de Sauce', 'Zona recreativa natural', 'Natural', -6.7000000, -76.4000000),
(130, 126, 'Moyobamba', 'Ciudad de las orquídeas', 'Cultural', -6.0300000, -76.9700000),
(131, 127, 'Lamas', 'Pueblo histórico y cultural', 'Cultural', -6.5000000, -76.9000000),
(132, 128, 'Rio Mayo', 'Río amazónico para ecoturismo', 'Natural', -6.6000000, -77.0000000),
(133, 129, 'Plaza de Armas de Tacna', 'Centro histórico', 'Cultural', -18.0000000, -70.2500000),
(134, 130, 'Valle de Locumba', 'Paisaje natural', 'Natural', -17.9000000, -70.3500000),
(135, 131, 'Museo Ferroviario', 'Historia del tren', 'Histórico', -18.0050000, -70.2500000),
(136, 132, 'Tarata', 'Distrito histórico', 'Histórico', -17.8500000, -70.3000000),
(137, 133, 'Candarave', 'Zona natural y cultural', 'Natural', -17.5000000, -70.4000000),
(138, 134, 'Boca del Río Caplina', 'Río y recreación', 'Natural', -18.0100000, -70.2400000),
(139, 135, 'Playa Zorritos', 'Destino playero', 'Natural', -3.5700000, -80.4000000),
(140, 136, 'Puerto Pizarro', 'Atractivo turístico fluvial', 'Natural', -3.5300000, -80.4500000),
(141, 137, 'Manglares de Tumbes', 'Reserva ecológica', 'Natural', -3.5000000, -80.4800000),
(142, 138, 'Tumbes Plaza de Armas', 'Centro histórico', 'Cultural', -3.5667000, -80.4500000),
(143, 139, 'Zarumilla', 'Distrito fronterizo', 'Cultural', -3.4200000, -80.1000000),
(144, 140, 'Contralmirante Villar', 'Zona natural protegida', 'Natural', -3.4000000, -80.2000000),
(145, 141, 'Parque Natural Pucallpa', 'Área verde y recreativa', 'Natural', -8.3800000, -74.5500000),
(146, 142, 'Coronel Portillo', 'Distrito urbano', 'Cultural', -8.3800000, -74.5500000),
(147, 143, 'Callería', 'Zona urbana y cultural', 'Cultural', -8.3700000, -74.5600000),
(148, 144, 'Yarinacocha', 'Lago y zona recreativa', 'Natural', -8.4000000, -74.5800000),
(149, 145, 'Atalaya', 'Distrito amazónico', 'Cultural', -9.1900000, -74.9000000),
(150, 146, 'Sepahua', 'Zona natural y biodiversidad', 'Natural', -9.6000000, -74.9500000);

-- --------------------------------------------------------

--

-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamentos`
--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `distritos`
--
ALTER TABLE `distritos`
  MODIFY `id_distrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT de la tabla `lugares_turisticos`
--
ALTER TABLE `lugares_turisticos`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id_provincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD CONSTRAINT `distritos_ibfk_1` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id_provincia`),
  ADD CONSTRAINT `fk_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id_provincia`);

--
-- Filtros para la tabla `lugares_turisticos`
--
ALTER TABLE `lugares_turisticos`
  ADD CONSTRAINT `fk_distrito` FOREIGN KEY (`id_distrito`) REFERENCES `distritos` (`id_distrito`),
  ADD CONSTRAINT `lugares_turisticos_ibfk_1` FOREIGN KEY (`id_distrito`) REFERENCES `distritos` (`id_distrito`);

--
-- Filtros para la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD CONSTRAINT `fk_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`),
  ADD CONSTRAINT `provincias_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
