-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-01-2020 a las 00:25:42
-- Versión del servidor: 5.7.20
-- Versión de PHP: 7.3.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dirigien_aspirantes`
--
CREATE DATABASE IF NOT EXISTS `dirigien_aspirantes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dirigien_aspirantes`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_aspirante`
--

DROP TABLE IF EXISTS `archivo_aspirante`;
CREATE TABLE `archivo_aspirante` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `aspirante_uuid` char(36) NOT NULL COMMENT 'Aspirante',
  `tipo_archivo_aspirante_id` int(11) NOT NULL COMMENT 'Tipo de soporte',
  `comentarios_aspirante` varchar(255) NOT NULL COMMENT 'Comentarios del aspirante',
  `ruta_web` varchar(128) NOT NULL COMMENT 'Ruta del archivo',
  `md5` char(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Soportes';

--
-- Volcado de datos para la tabla `archivo_aspirante`
--

INSERT INTO `archivo_aspirante` (`uuid`, `aspirante_uuid`, `tipo_archivo_aspirante_id`, `comentarios_aspirante`, `ruta_web`, `md5`, `created_at`, `modified_at`) VALUES
('b208e982-3594-11ea-ba54-aedc42b7cfe7', '6fb7f844-3561-11ea-ba54-aedc42b7cfe7', 1, 'No se puede cambiar.', '/archivos/aspirantes/555/55555555/55555555_3THBLL_vkirQrAJUHCRMpymq8-kgC5bD', 'd167b53918041819c98484a9f3155aa9', '2020-01-12 23:38:55', '2020-01-12 23:38:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_aspirante_cargo`
--

DROP TABLE IF EXISTS `archivo_aspirante_cargo`;
CREATE TABLE `archivo_aspirante_cargo` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `archivo_aspirante_uuid` char(36) NOT NULL COMMENT 'Soporte',
  `aspirante_cargo_uuid` char(36) NOT NULL COMMENT 'Cargo',
  `comentarios_aspirante` varchar(255) NOT NULL,
  `comentarios_analista` varchar(256) DEFAULT NULL,
  `tenido_en_cuenta` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='soporte_proceso';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo_proceso`
--

DROP TABLE IF EXISTS `archivo_proceso`;
CREATE TABLE `archivo_proceso` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `proceso_id` int(11) NOT NULL COMMENT 'Proceso',
  `descripcion` varchar(255) NOT NULL,
  `ruta_web` varchar(128) NOT NULL,
  `md5` char(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Archivos de los procesos';

--
-- Volcado de datos para la tabla `archivo_proceso`
--

INSERT INTO `archivo_proceso` (`id`, `proceso_id`, `descripcion`, `ruta_web`, `md5`, `created_at`, `modified_at`) VALUES
(1, 1, 'Convocatoria', '/archivos/procesos/1/db625e4edf0d6da2b113b21878cde19e1.pdf', '10989b8226ac2d0c9de4c99d4085cf83', '2019-12-29 16:14:16', '2019-12-29 20:48:13'),
(3, 2, 'Convocatoria', '/archivos/procesos/1/db625e4edf0d6da2b113b21878cde19e2.pdf', '10989b8226ac2d0c9de4c99d4085cf83', '2019-12-29 20:45:14', '2019-12-29 20:51:04'),
(4, 3, 'Convocatoria', '/archivos/procesos/1/db625e4edf0d6da2b113b21878cde19e3.pdf', '10989b8226ac2d0c9de4c99d4085cf83', '2019-12-29 20:45:26', '2019-12-29 20:51:13'),
(5, 4, 'Convocatoria', '/archivos/procesos/1/db625e4edf0d6da2b113b21878cde19e4.pdf', '10989b8226ac2d0c9de4c99d4085cf83', '2019-12-29 20:45:48', '2019-12-29 20:51:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante`
--

DROP TABLE IF EXISTS `aspirante`;
CREATE TABLE `aspirante` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `nombres` varchar(128) NOT NULL COMMENT 'Nombres',
  `apellidos` varchar(128) NOT NULL COMMENT 'Apellidos',
  `correo_electronico` varchar(128) NOT NULL COMMENT 'Correo electrónico',
  `password_hash` varchar(255) NOT NULL COMMENT 'Hash contraseña',
  `fecha_nacimiento` date NOT NULL COMMENT 'Fecha de nacimiento',
  `tipo_identificacion_id` int(11) NOT NULL COMMENT 'Tipo ID',
  `identificacion` varchar(60) NOT NULL COMMENT 'Identificación',
  `celular` char(10) NOT NULL COMMENT 'Número de celular',
  `urlfoto` varchar(128) NOT NULL COMMENT 'URL Foto',
  `status` int(11) NOT NULL COMMENT 'Estado',
  `verification_token` varchar(128) DEFAULT NULL COMMENT 'Token de verificación',
  `password_reset_token` varchar(128) DEFAULT NULL,
  `auth_key` varchar(32) NOT NULL,
  `ip_creacion` varchar(40) NOT NULL COMMENT 'IP de creación',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha hora de creación',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha hora de modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Información de los aspirantes';

--
-- Volcado de datos para la tabla `aspirante`
--

INSERT INTO `aspirante` (`uuid`, `nombres`, `apellidos`, `correo_electronico`, `password_hash`, `fecha_nacimiento`, `tipo_identificacion_id`, `identificacion`, `celular`, `urlfoto`, `status`, `verification_token`, `password_reset_token`, `auth_key`, `ip_creacion`, `created_at`, `updated_at`) VALUES
('6fb7f844-3561-11ea-ba54-aedc42b7cfe7', 'FULANITO', 'DE TAL', 'fulanitodetal@gmail.com', '$2y$13$o18k7PzJXpSDyNfT.NVaN.uTxcsHEXgQGTViromzIZM5AO0tcib1O', '1983-12-12', 1, '55555555', '3000000000', '/archivos/aspirantes/555/55555555/55555555_BAoKZmxiCJO-iarq6H_T0WBrVSPfRqMJ.png', 10, 'sNRHX2ySTSksR1Y46EmM6EAC4paPkU5N_1578872329', NULL, 'U5-CZ0q94llj7VUsObpL7vD-mgPiFaAX', '::1', '2020-01-12 23:38:49', '2020-01-12 23:53:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante_cargo`
--

DROP TABLE IF EXISTS `aspirante_cargo`;
CREATE TABLE `aspirante_cargo` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `aspirante_uuid` char(36) NOT NULL COMMENT 'Aspirante',
  `cargo_id` int(11) NOT NULL,
  `opcion_cargo_id` int(11) NOT NULL,
  `pin_proceso_uuid` char(36) DEFAULT NULL COMMENT 'Pin',
  `estado_id` int(11) NOT NULL COMMENT 'Estado',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha hora de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha hora de actualización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Aspirantes a cargos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `proceso_id` int(11) NOT NULL COMMENT 'Proceso',
  `nombre` varchar(255) NOT NULL COMMENT 'Cargo',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha hora de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha hora de actualización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Cargos';

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `proceso_id`, `nombre`, `created_at`, `modified_at`) VALUES
(1, 1, 'Director de área', '2019-12-17 02:28:36', '2019-12-29 20:33:55'),
(2, 1, 'Despachador', '2019-12-17 02:28:36', '2019-12-29 20:34:03'),
(3, 1, 'Vigilante', '2019-12-17 02:28:36', '2019-12-29 20:34:19'),
(4, 1, 'Cargador', '2019-12-17 02:28:36', '2019-12-29 20:34:39'),
(5, 1, 'Profesional 1', '2019-12-17 02:28:36', '2019-12-29 20:35:03'),
(6, 2, 'Cargador', '2019-12-29 20:41:37', '2019-12-29 20:41:37'),
(7, 2, 'Despachador', '2019-12-29 20:41:37', '2019-12-29 20:41:37'),
(8, 2, 'Director de área', '2019-12-29 20:41:37', '2019-12-29 20:41:37'),
(9, 2, 'Profesional 1', '2019-12-29 20:41:37', '2019-12-29 20:41:37'),
(10, 2, 'Vigilante', '2019-12-29 20:41:37', '2019-12-29 20:41:37'),
(11, 3, 'Cargador', '2019-12-29 20:41:51', '2020-01-12 16:08:42'),
(12, 3, 'Despachador', '2019-12-29 20:41:51', '2020-01-12 16:08:46'),
(13, 3, 'Director de área', '2019-12-29 20:41:51', '2020-01-12 16:08:48'),
(14, 3, 'Profesional 1', '2019-12-29 20:41:51', '2020-01-12 16:08:52'),
(15, 3, 'Vigilante', '2019-12-29 20:41:51', '2020-01-12 16:08:55'),
(16, 4, 'Cargador', '2019-12-29 20:42:06', '2020-01-12 16:08:58'),
(17, 4, 'Despachador', '2019-12-29 20:42:06', '2020-01-12 16:09:02'),
(18, 4, 'Director de área', '2019-12-29 20:42:06', '2020-01-12 16:09:06'),
(19, 4, 'Profesional 1', '2019-12-29 20:42:06', '2020-01-12 16:09:09'),
(20, 4, 'Vigilante', '2019-12-29 20:42:06', '2020-01-12 16:09:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

DROP TABLE IF EXISTS `entidad`;
CREATE TABLE `entidad` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `nombre` varchar(128) NOT NULL COMMENT 'Nombre',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Es activo',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Entidades';

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`id`, `nombre`, `activo`, `created_at`, `modified_at`) VALUES
(1, 'Ministerio de la gobernabilidad', 1, '2019-12-29 20:33:20', '2019-12-29 20:33:20'),
(2, 'Ministerio del ecosistema', 1, '2019-12-29 20:35:39', '2019-12-29 20:35:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_aspirante_proceso`
--

DROP TABLE IF EXISTS `estado_aspirante_proceso`;
CREATE TABLE `estado_aspirante_proceso` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `proceso_id` int(11) NOT NULL COMMENT 'Proceso',
  `nombre` varchar(128) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Estados de los aspirantes';

--
-- Volcado de datos para la tabla `estado_aspirante_proceso`
--

INSERT INTO `estado_aspirante_proceso` (`id`, `proceso_id`, `nombre`, `activo`) VALUES
(1, 1, 'En proceso', 1),
(2, 1, 'Admitido', 1),
(3, 1, 'No admitido', 1),
(4, 2, 'En proceso', 1),
(5, 2, 'Admitido', 1),
(6, 2, 'No admitido', 1),
(7, 3, 'En proceso', 1),
(8, 3, 'Admitido', 1),
(9, 3, 'No admitido', 1),
(10, 4, 'Admitido', 1),
(11, 4, 'En proceso', 1),
(12, 4, 'No admitido', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1576213592),
('m130524_201442_init', 1576213599),
('m190124_110200_add_verification_token_column_to_user_table', 1576213599);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion_cargo`
--

DROP TABLE IF EXISTS `opcion_cargo`;
CREATE TABLE `opcion_cargo` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `cargo_id` int(11) NOT NULL COMMENT 'Cargo',
  `opcion` varchar(512) NOT NULL COMMENT 'Opción',
  `requiere_titulo` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Requiere título de grado',
  `anios_experiencia_profesional` float(3,1) NOT NULL DEFAULT '0.0' COMMENT 'Años experiencia profesional',
  `anios_experiencia_relacionada` float(3,1) NOT NULL DEFAULT '0.0' COMMENT 'Años experiencia relacionada',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha hora de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha hora de actualización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Opciones de los cargos';

--
-- Volcado de datos para la tabla `opcion_cargo`
--

INSERT INTO `opcion_cargo` (`id`, `cargo_id`, `opcion`, `requiere_titulo`, `anios_experiencia_profesional`, `anios_experiencia_relacionada`, `created_at`, `modified_at`) VALUES
(1, 1, 'Titulo profesional en derecho, 2 años de experiencia profesional y 2 años de experiencia relacionada', 1, 2.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(2, 1, '5 años de experiencia profesional y 2 años de experiencia relacionada', 0, 5.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(3, 2, 'Titulo profesional en sistemas, 3 años de experiencia profesional y 2 años de experiencia relacionada', 1, 3.0, 2.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(4, 2, '5 años de experiencia profesional y 3 años de experiencia relacionada', 0, 5.0, 3.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(5, 3, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(6, 3, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(7, 4, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(8, 4, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(9, 5, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(10, 5, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(11, 6, 'Titulo profesional en derecho, 2 años de experiencia profesional y 2 años de experiencia relacionada', 1, 2.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(12, 6, '5 años de experiencia profesional y 2 años de experiencia relacionada', 0, 5.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(13, 7, 'Titulo profesional en sistemas, 3 años de experiencia profesional y 2 años de experiencia relacionada', 1, 3.0, 2.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(14, 7, '5 años de experiencia profesional y 3 años de experiencia relacionada', 0, 5.0, 3.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(15, 8, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(16, 8, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(17, 9, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(18, 9, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(19, 10, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(20, 10, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(26, 11, 'Titulo profesional en derecho, 2 años de experiencia profesional y 2 años de experiencia relacionada', 1, 2.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(27, 11, '5 años de experiencia profesional y 2 años de experiencia relacionada', 0, 5.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(28, 12, 'Titulo profesional en sistemas, 3 años de experiencia profesional y 2 años de experiencia relacionada', 1, 3.0, 2.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(29, 12, '5 años de experiencia profesional y 3 años de experiencia relacionada', 0, 5.0, 3.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(30, 13, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(31, 13, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(32, 14, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(33, 14, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(34, 15, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(35, 15, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(41, 16, 'Titulo profesional en derecho, 2 años de experiencia profesional y 2 años de experiencia relacionada', 1, 2.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(42, 16, '5 años de experiencia profesional y 2 años de experiencia relacionada', 0, 5.0, 2.0, '2019-12-17 02:40:24', '2019-12-17 02:40:24'),
(43, 17, 'Titulo profesional en sistemas, 3 años de experiencia profesional y 2 años de experiencia relacionada', 1, 3.0, 2.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(44, 17, '5 años de experiencia profesional y 3 años de experiencia relacionada', 0, 5.0, 3.0, '2019-12-17 02:41:29', '2019-12-17 02:41:29'),
(45, 18, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(46, 18, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:42:42', '2019-12-17 02:42:42'),
(47, 19, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(48, 19, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(49, 20, 'Titulo profesional en ingenieria industrial, 4 años de experiencia profesional y 4 años de experiencia relacionada', 1, 4.0, 4.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35'),
(50, 20, '8 años de experiencia profesional y 5 años de experiencia relacionada', 0, 8.0, 5.0, '2019-12-17 02:43:35', '2019-12-17 02:43:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pin_proceso`
--

DROP TABLE IF EXISTS `pin_proceso`;
CREATE TABLE `pin_proceso` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `proceso_id` int(11) NOT NULL COMMENT 'Proceso',
  `pin` char(36) NOT NULL COMMENT 'Pin',
  `usado` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Usado',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha hora de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha hora de actualización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pin_proceso`
--

INSERT INTO `pin_proceso` (`uuid`, `proceso_id`, `pin`, `usado`, `created_at`, `modified_at`) VALUES
('1232c6da-2905-11ea-8937-dd6870f88cd5', 1, '1232c6f8-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2020-01-12 16:06:21'),
('12356ebc-2905-11ea-8937-dd6870f88cd5', 1, '12356ec6-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2020-01-12 16:06:25'),
('12364f58-2905-11ea-8937-dd6870f88cd5', 1, '12364f6c-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2020-01-12 16:06:28'),
('12373648-2905-11ea-8937-dd6870f88cd5', 1, '1237365c-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2020-01-12 16:06:31'),
('12383bba-2905-11ea-8937-dd6870f88cd5', 1, '12383bce-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2019-12-28 00:00:34'),
('12392412-2905-11ea-8937-dd6870f88cd5', 1, '12392426-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2019-12-28 00:00:34'),
('123a18f4-2905-11ea-8937-dd6870f88cd5', 1, '123a1912-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2019-12-28 00:00:34'),
('123aff08-2905-11ea-8937-dd6870f88cd5', 1, '123aff1c-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2019-12-28 00:00:34'),
('123bdc66-2905-11ea-8937-dd6870f88cd5', 1, '123bdc7a-2905-11ea-8937-dd6870f88cd5', 0, '2019-12-28 00:00:34', '2019-12-28 00:00:34'),
('fcdffffa-2904-11ea-8937-dd6870f88cd5', 1, 'fce00022-2904-11ea-8937-dd6870f88cd5', 0, '2019-12-27 23:59:58', '2019-12-27 23:59:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso`
--

DROP TABLE IF EXISTS `proceso`;
CREATE TABLE `proceso` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `entidad_id` int(11) NOT NULL COMMENT 'Entidad',
  `nombre` varchar(128) NOT NULL COMMENT 'Proceso',
  `fecha_inicio` date DEFAULT NULL COMMENT 'Fecha de inicio',
  `fecha_fin_aplicacion` date DEFAULT NULL COMMENT 'Fin cargue documentos',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o no',
  `requiere_pin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Requiere pin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Procesos';

--
-- Volcado de datos para la tabla `proceso`
--

INSERT INTO `proceso` (`id`, `entidad_id`, `nombre`, `fecha_inicio`, `fecha_fin_aplicacion`, `activo`, `requiere_pin`, `created_at`, `modified_at`) VALUES
(1, 1, 'Convocatoria 0034', '2019-12-06', '2020-01-31', 1, 1, '2019-12-01 15:00:15', '2020-01-12 16:03:20'),
(2, 1, 'Convocatoria 0045', '2019-12-06', '2020-01-31', 1, 0, '2019-12-29 20:38:05', '2019-12-29 20:40:02'),
(3, 2, 'Convocatoria 0043', '2019-12-06', '2020-01-31', 1, 1, '2019-12-29 20:39:21', '2019-12-29 20:39:47'),
(4, 2, 'Convocatoria 0072', '2019-12-06', '2020-01-31', 1, 0, '2019-12-29 20:39:21', '2019-12-29 20:40:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_archivo_aspirante`
--

DROP TABLE IF EXISTS `tipo_archivo_aspirante`;
CREATE TABLE `tipo_archivo_aspirante` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `nombre` varchar(128) NOT NULL COMMENT 'Tipo de soporte',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tipos de soporte';

--
-- Volcado de datos para la tabla `tipo_archivo_aspirante`
--

INSERT INTO `tipo_archivo_aspirante` (`id`, `nombre`, `activo`) VALUES
(1, 'Documento de identificación', 1),
(2, 'Experiencia laboral relacionada', 1),
(3, 'Experiencia laboral no relacionada', 1),
(4, 'Título de bachiller', 1),
(5, 'Título de pregrado', 1),
(6, 'Título de especialización', 1),
(7, 'Título de maestría', 1),
(8, 'Título de doctorado', 1),
(9, 'Diplomado', 1),
(10, 'Curso', 1),
(11, 'Certificado de terminación de materias', 1),
(12, 'Otra documentación de experiencia', 1),
(13, 'Otra documentación de estudios', 1),
(14, 'Otros tipos de soporte', 1),
(15, 'Hoja de vida', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_identificacion`
--

DROP TABLE IF EXISTS `tipo_identificacion`;
CREATE TABLE `tipo_identificacion` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `nombre` varchar(128) NOT NULL COMMENT 'Tipo de identificador',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tipos de identificación';

--
-- Volcado de datos para la tabla `tipo_identificacion`
--

INSERT INTO `tipo_identificacion` (`id`, `nombre`, `activo`) VALUES
(1, 'Cédula de ciudadanía', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `id` bigint(20) NOT NULL,
  `ip_creacion` varchar(40) NOT NULL COMMENT 'Dirección IP',
  `ip_registro` varchar(40) DEFAULT NULL,
  `celular` char(10) NOT NULL,
  `correo_electronico` varchar(128) NOT NULL,
  `identificacion` varchar(60) NOT NULL,
  `token` mediumint(6) NOT NULL COMMENT 'Token',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha hora de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha hora de actualización',
  `validado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tokens';

--
-- Volcado de datos para la tabla `token`
--

INSERT INTO `token` (`id`, `ip_creacion`, `ip_registro`, `celular`, `correo_electronico`, `identificacion`, `token`, `created_at`, `modified_at`, `validado`) VALUES
(21, '::1', NULL, '3138963203', 'fulanitodetal@gmail.com', '55555555', 581241, '2020-01-12 23:15:10', '2020-01-12 23:15:10', 0),
(22, '::1', '::1', '3138963203', 'jabernal@gmail.com', '55555555', 912012, '2020-01-12 23:21:44', '2020-01-12 23:38:55', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `password_hash` varchar(128) NOT NULL,
  `password_reset_token` varchar(128) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivo_aspirante`
--
ALTER TABLE `archivo_aspirante`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UQ_SOPORTE_PROCESO_ASPIRANTE_MD5` (`aspirante_uuid`,`md5`) USING BTREE,
  ADD UNIQUE KEY `UQ_SOPORTE_RUTAWEB` (`ruta_web`),
  ADD KEY `IX_SOPORTE_TIPOSOPORTE` (`tipo_archivo_aspirante_id`),
  ADD KEY `IX_SOPORTE_MD5` (`md5`),
  ADD KEY `IX_SOPORTE_ASPIRANTE` (`aspirante_uuid`),
  ADD KEY `IX_SOPORTE_ASPIRANTE_MD5` (`aspirante_uuid`,`md5`) USING BTREE;

--
-- Indices de la tabla `archivo_aspirante_cargo`
--
ALTER TABLE `archivo_aspirante_cargo`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UQ_SOPORTEPROCESO_SOPORTE_ASPIRANTECARGO` (`archivo_aspirante_uuid`,`aspirante_cargo_uuid`) USING BTREE,
  ADD KEY `IX_SOPORTEPROCESO_SOPORTE` (`archivo_aspirante_uuid`),
  ADD KEY `IX_SOPORTEPROCESO_PROCESO_TENIDOENCUENTA` (`aspirante_cargo_uuid`,`archivo_aspirante_uuid`,`tenido_en_cuenta`),
  ADD KEY `IX_SOPORTEPROCESO_ASPIRANTECARGO` (`aspirante_cargo_uuid`) USING BTREE;

--
-- Indices de la tabla `archivo_proceso`
--
ALTER TABLE `archivo_proceso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_ARCHIVOPROCESO_RUTAWEB` (`ruta_web`),
  ADD KEY `IX_ARCHIVOPROCESO_PROCESO` (`proceso_id`),
  ADD KEY `IX_ARCHIVOPROCESO_MD5` (`md5`);

--
-- Indices de la tabla `aspirante`
--
ALTER TABLE `aspirante`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UQ_ASPIRANTE_URLFOTO` (`urlfoto`),
  ADD KEY `IX_ASPIRANTE_TIPOIDENTIFICACION` (`tipo_identificacion_id`),
  ADD KEY `IX_ASPIRANTE_IDENTIFICACION` (`identificacion`),
  ADD KEY `IX_ASPIRANTE_TIPO_IDENTIFICACION` (`tipo_identificacion_id`,`identificacion`) USING BTREE,
  ADD KEY `FK_ASPIRANTE_ESTADO` (`status`),
  ADD KEY `IX_ASPIRANTE_IPCREACION` (`ip_creacion`),
  ADD KEY `IX_ASPIRANTE_PASSWORD_RESET_TOKEN` (`password_reset_token`),
  ADD KEY `IX_ASPIRANTE_CORREOE` (`correo_electronico`) USING BTREE,
  ADD KEY `IX_ASPIRANTE_CELULAR` (`celular`),
  ADD KEY `IX_ASPIRANTE_CORREOE_STATUS` (`correo_electronico`,`status`) USING BTREE,
  ADD KEY `IX_ASPIRANTE_CELULAR_STATUS` (`celular`,`status`) USING BTREE,
  ADD KEY `IX_ASPIRANTE_IDENTIFICACION_STATUS` (`identificacion`,`status`);

--
-- Indices de la tabla `aspirante_cargo`
--
ALTER TABLE `aspirante_cargo`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `IX_ASPIRANTECARGO_ASPIRANTE` (`aspirante_uuid`),
  ADD KEY `IX_ASPIRANTECARGO_CARGO` (`cargo_id`),
  ADD KEY `IX_ASPIRANTECARGO_ESTADO` (`estado_id`),
  ADD KEY `IX_ASPIRANTECARGO_OPCIONCARGO` (`opcion_cargo_id`),
  ADD KEY `IX_ASPIRANTECARGO_PINPROCESOUUID` (`pin_proceso_uuid`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_CARGO_PROCESO_NOMBRE` (`proceso_id`,`nombre`),
  ADD KEY `IX_CARGO_PROCESO` (`proceso_id`);

--
-- Indices de la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_ENTIDAD_NOMBRE` (`nombre`),
  ADD KEY `IX_ENTIDAD_ACTIVO` (`activo`);

--
-- Indices de la tabla `estado_aspirante_proceso`
--
ALTER TABLE `estado_aspirante_proceso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_ESTADO_PROCESO_NOMBRE` (`proceso_id`,`nombre`) USING BTREE,
  ADD KEY `IX_ESTADOASPIRANTE_ACTIVO` (`activo`),
  ADD KEY `IX_ESTADOASPIRANTEPROCESO_PROCESO` (`proceso_id`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `opcion_cargo`
--
ALTER TABLE `opcion_cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_OPCIONCARGO_CARGO` (`cargo_id`);

--
-- Indices de la tabla `pin_proceso`
--
ALTER TABLE `pin_proceso`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UQ_PINPROCESO_PROCESO_PIN` (`proceso_id`,`pin`) USING BTREE,
  ADD KEY `IX_PINPROCESO_PROCESO` (`proceso_id`);

--
-- Indices de la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_PROCESO_ENTIDAD` (`entidad_id`),
  ADD KEY `IX_PROCESO_ACTIVO` (`activo`);

--
-- Indices de la tabla `tipo_archivo_aspirante`
--
ALTER TABLE `tipo_archivo_aspirante`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_TIPOSOPORTE_NOMBRE` (`nombre`),
  ADD KEY `IX_TIPOSOPORTE_ACTIVO` (`activo`);

--
-- Indices de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_TIPOIDENTIFICACION_NOMBRE` (`nombre`),
  ADD KEY `IX_TIPOIDENTIFICACION_ACTIVO` (`activo`);

--
-- Indices de la tabla `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IX_TOKEN_IPCREACION_CREATEDAT` (`ip_creacion`,`created_at`),
  ADD KEY `IX_TOKEN_IP` (`ip_creacion`),
  ADD KEY `IX_TOKEN_VALIDADO` (`validado`),
  ADD KEY `IX_TOKEN_TOKEN` (`token`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo_proceso`
--
ALTER TABLE `archivo_proceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `entidad`
--
ALTER TABLE `entidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_aspirante_proceso`
--
ALTER TABLE `estado_aspirante_proceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `opcion_cargo`
--
ALTER TABLE `opcion_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `proceso`
--
ALTER TABLE `proceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_archivo_aspirante`
--
ALTER TABLE `tipo_archivo_aspirante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `token`
--
ALTER TABLE `token`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivo_aspirante`
--
ALTER TABLE `archivo_aspirante`
  ADD CONSTRAINT `FK_SOPORTE_ASPIRANTE` FOREIGN KEY (`aspirante_uuid`) REFERENCES `aspirante` (`uuid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOPORTE_TIPOSOPORTE` FOREIGN KEY (`tipo_archivo_aspirante_id`) REFERENCES `tipo_archivo_aspirante` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `archivo_aspirante_cargo`
--
ALTER TABLE `archivo_aspirante_cargo`
  ADD CONSTRAINT `FK_SOPORTECARGO_ASPIRANTECARGO` FOREIGN KEY (`aspirante_cargo_uuid`) REFERENCES `aspirante_cargo` (`uuid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOPORTEPROCESO_SOPORTE` FOREIGN KEY (`archivo_aspirante_uuid`) REFERENCES `archivo_aspirante` (`uuid`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `archivo_proceso`
--
ALTER TABLE `archivo_proceso`
  ADD CONSTRAINT `FK_ARCHIVOPROCESO_PROCESO` FOREIGN KEY (`proceso_id`) REFERENCES `proceso` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `aspirante`
--
ALTER TABLE `aspirante`
  ADD CONSTRAINT `FK_ASPIRANTE_TIPOIDENTIFICACION` FOREIGN KEY (`tipo_identificacion_id`) REFERENCES `tipo_identificacion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `aspirante_cargo`
--
ALTER TABLE `aspirante_cargo`
  ADD CONSTRAINT `FK_ASPIRANTECARGO_ASPIRANTE` FOREIGN KEY (`aspirante_uuid`) REFERENCES `aspirante` (`uuid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ASPIRANTECARGO_CARGO` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ASPIRANTECARGO_ESTADO` FOREIGN KEY (`estado_id`) REFERENCES `estado_aspirante_proceso` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ASPIRANTECARGO_OPCIONCARGO` FOREIGN KEY (`opcion_cargo_id`) REFERENCES `opcion_cargo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ASPIRANTECARGO_PINPROCESO` FOREIGN KEY (`pin_proceso_uuid`) REFERENCES `pin_proceso` (`uuid`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `FK_CARGO_PROCESO` FOREIGN KEY (`proceso_id`) REFERENCES `proceso` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `estado_aspirante_proceso`
--
ALTER TABLE `estado_aspirante_proceso`
  ADD CONSTRAINT `estado_aspirante_proceso_ibfk_1` FOREIGN KEY (`proceso_id`) REFERENCES `proceso` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `opcion_cargo`
--
ALTER TABLE `opcion_cargo`
  ADD CONSTRAINT `FK_OPCIONCARGO_CARGO` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pin_proceso`
--
ALTER TABLE `pin_proceso`
  ADD CONSTRAINT `FK_PINPROCESO_PROCESO` FOREIGN KEY (`proceso_id`) REFERENCES `proceso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD CONSTRAINT `FK_PROCESO_ENTIDAD` FOREIGN KEY (`entidad_id`) REFERENCES `entidad` (`id`) ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
