-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-12-2019 a las 14:15:30
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
  `status` int(11) NOT NULL COMMENT 'Estado',
  `verification_token` varchar(128) DEFAULT NULL COMMENT 'Token de verificación',
  `password_reset_token` varchar(128) DEFAULT NULL,
  `auth_key` varchar(32) NOT NULL,
  `ip_creacion` char(15) NOT NULL COMMENT 'IP de creación',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha hora de creación',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha hora de modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Información de los aspirantes';

--
-- Volcado de datos para la tabla `aspirante`
--

INSERT INTO `aspirante` VALUES
('7937b320-1edf-11ea-8824-61b35fc2af27', 'Jairo', 'Bernal', 'jabernal@gmail.com', '$2y$13$oYEKfwxRGdC/21x/dN/VYO/ajtDkpiViJakc7nJDTciUvPGbB9s6.', '1965-07-28', 1, '79365371', 10, 'B3TsUdByMDLWfOPG5zBlDVA_z-7G--oj_1576375633', NULL, 'yjLhaBIzwGftyEgs5Hf-2Dp81taJVqF9', '::1', '2019-12-15 02:07:13', '2019-12-15 02:40:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirante_cargo`
--

DROP TABLE IF EXISTS `aspirante_cargo`;
CREATE TABLE `aspirante_cargo` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `aspirante_uuid` char(36) NOT NULL COMMENT 'Aspirante',
  `cargo_id` int(11) NOT NULL,
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

DROP TABLE IF EXISTS `entidad`;
CREATE TABLE `entidad` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `nombre` varchar(128) NOT NULL COMMENT 'Nombre',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Es activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Entidades';

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` VALUES
(1, 'Entidad 1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_aspirante_proceso`
--

DROP TABLE IF EXISTS `estado_aspirante_proceso`;
CREATE TABLE `estado_aspirante_proceso` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `nombre` varchar(128) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Estados de los aspirantes';

--
-- Volcado de datos para la tabla `estado_aspirante_proceso`
--

INSERT INTO `estado_aspirante_proceso` VALUES
(1, 'En proceso', 1),
(2, 'Admitido', 1),
(3, 'No admitido', 1);

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

INSERT INTO `migration` VALUES
('m000000_000000_base', 1576213592),
('m130524_201442_init', 1576213599),
('m190124_110200_add_verification_token_column_to_user_table', 1576213599);

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
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Procesos';

--
-- Volcado de datos para la tabla `proceso`
--

INSERT INTO `proceso` VALUES
(1, 1, 'Proceso 1', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

DROP TABLE IF EXISTS `soporte`;
CREATE TABLE `soporte` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `aspirante_uuid` char(36) NOT NULL COMMENT 'Aspirante',
  `tipo_soporte_id` int(11) NOT NULL COMMENT 'Tipo de soporte',
  `comentarios_aspirante` varchar(255) NOT NULL COMMENT 'Comentarios del aspirante',
  `archivo_nombre_carga` varchar(255) NOT NULL COMMENT 'Nombre del archivo',
  `archivo_ruta_web` varchar(255) NOT NULL COMMENT 'Ruta del archivo',
  `md5` char(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Soportes';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte_proceso`
--

DROP TABLE IF EXISTS `soporte_proceso`;
CREATE TABLE `soporte_proceso` (
  `uuid` char(36) NOT NULL COMMENT 'Identificador',
  `soporte_uuid` char(36) NOT NULL COMMENT 'Soporte',
  `proceso_id` int(11) NOT NULL COMMENT 'Proceso',
  `comentarios_analista` varchar(256) DEFAULT NULL,
  `tenido_en_cuenta` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='soporte_proceso';

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

INSERT INTO `tipo_identificacion` VALUES
(1, 'Cédula de ciudadanía', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_soporte`
--

DROP TABLE IF EXISTS `tipo_soporte`;
CREATE TABLE `tipo_soporte` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `nombre` varchar(128) NOT NULL COMMENT 'Tipo de soporte',
  `activo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tipos de soporte';

--
-- Volcado de datos para la tabla `tipo_soporte`
--

INSERT INTO `tipo_soporte` VALUES
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
(14, 'Otros tipos de soporte', 1);

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
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` VALUES
(1, 'jabernal', 'UXnPWvHnuMb79xKdPD0F8N0HHQnPADjq', '$2y$13$UrbKRadb74mLeUMhwnSg6urpueP8c8VaxNjjunzekS6GfSxra3zJ6', NULL, 'jabernal@gmail.com', 10, 1576214948, 1576214948, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aspirante`
--
ALTER TABLE `aspirante`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UQ_ASPIRANTE_CORREOE` (`correo_electronico`),
  ADD KEY `IX_ASPIRANTE_TIPOIDENTIFICACION` (`tipo_identificacion_id`),
  ADD KEY `IX_ASPIRANTE_IDENTIFICACION` (`identificacion`),
  ADD KEY `IX_ASPIRANTE_TIPO_IDENTIFICACION` (`tipo_identificacion_id`,`identificacion`) USING BTREE,
  ADD KEY `FK_ASPIRANTE_ESTADO` (`status`),
  ADD KEY `IX_ASPIRANTE_IPCREACION` (`ip_creacion`),
  ADD KEY `IX_ASPIRANTE_PASSWORD_RESET_TOKEN` (`password_reset_token`);

--
-- Indices de la tabla `aspirante_cargo`
--
ALTER TABLE `aspirante_cargo`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `IX_ASPIRANTECARGO_ASPIRANTE` (`aspirante_uuid`),
  ADD KEY `IX_ASPIRANTECARGO_CARGO` (`cargo_id`),
  ADD KEY `IX_ASPIRANTECARGO_ESTADO` (`estado_id`);

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
  ADD UNIQUE KEY `UQ_ESTADO_NOMBRE` (`nombre`),
  ADD KEY `IX_ESTADOASPIRANTE_ACTIVO` (`activo`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_PROCESO_ENTIDAD` (`entidad_id`),
  ADD KEY `IX_PROCESO_ACTIVO` (`activo`);

--
-- Indices de la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UQ_SOPORTE_PROCESO_ASPIRANTE_MD5` (`aspirante_uuid`,`md5`) USING BTREE,
  ADD UNIQUE KEY `UQ_SOPORTE_RUTAWEB` (`archivo_ruta_web`),
  ADD KEY `IX_SOPORTE_TIPOSOPORTE` (`tipo_soporte_id`),
  ADD KEY `IX_SOPORTE_MD5` (`md5`),
  ADD KEY `IX_SOPORTE_ASPIRANTE` (`aspirante_uuid`),
  ADD KEY `IX_SOPORTE_ASPIRANTE_MD5` (`aspirante_uuid`,`md5`) USING BTREE;

--
-- Indices de la tabla `soporte_proceso`
--
ALTER TABLE `soporte_proceso`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `UQ_SOPORTEPROCESO_SOPORTE_PROCESO` (`soporte_uuid`,`proceso_id`),
  ADD KEY `IX_SOPORTEPROCESO_SOPORTE` (`soporte_uuid`),
  ADD KEY `IX_SOPORTEPROCESO_PROCESO` (`proceso_id`),
  ADD KEY `IX_SOPORTEPROCESO_PROCESO_TENIDOENCUENTA` (`proceso_id`,`soporte_uuid`,`tenido_en_cuenta`);

--
-- Indices de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_TIPOIDENTIFICACION_NOMBRE` (`nombre`),
  ADD KEY `IX_TIPOIDENTIFICACION_ACTIVO` (`activo`);

--
-- Indices de la tabla `tipo_soporte`
--
ALTER TABLE `tipo_soporte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_TIPOSOPORTE_NOMBRE` (`nombre`),
  ADD KEY `IX_TIPOSOPORTE_ACTIVO` (`activo`);

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
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador';

--
-- AUTO_INCREMENT de la tabla `entidad`
--
ALTER TABLE `entidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado_aspirante_proceso`
--
ALTER TABLE `estado_aspirante_proceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proceso`
--
ALTER TABLE `proceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_soporte`
--
ALTER TABLE `tipo_soporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

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
  ADD CONSTRAINT `FK_ASPIRANTECARGO_ESTADO` FOREIGN KEY (`estado_id`) REFERENCES `estado_aspirante_proceso` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD CONSTRAINT `FK_PROCESO_ENTIDAD` FOREIGN KEY (`entidad_id`) REFERENCES `entidad` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `FK_SOPORTE_ASPIRANTE` FOREIGN KEY (`aspirante_uuid`) REFERENCES `aspirante` (`uuid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOPORTE_TIPOSOPORTE` FOREIGN KEY (`tipo_soporte_id`) REFERENCES `tipo_soporte` (`id`) ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
