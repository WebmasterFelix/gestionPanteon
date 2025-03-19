-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-03-2025 a las 16:04:22
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
-- Base de datos: `gpm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_actividad`
--

CREATE TABLE `tbl_log_actividad` (
  `log_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(255) NOT NULL,
  `modulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `datos_antiguos` text DEFAULT NULL,
  `datos_nuevos` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_log_actividad`
--

INSERT INTO `tbl_log_actividad` (`log_id`, `usuario_id`, `accion`, `modulo`, `descripcion`, `datos_antiguos`, `datos_nuevos`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'actualizar', 'Usuarios', 'Actualización de usuario ID: 3', '{\"usuario_id\":\"3\",\"usuario_nombre\":\"Juan Gabriel\",\"usuario_apellido\":\"Vega Garcia\",\"usuario_password_hash\":\"$2y$10$cpBRMUFLgs7H.NByHPq7FOyhQwYv6p\\/vsEu8IpBjiJo9S.GHHW0Iu\",\"usuario_usuario\":\"juanvega\",\"usuario_estado\":\"activo\",\"usuario_foto\":\"assets\\/images\\/perfil\\/1741900571_c05e55d21dc696222697.png\",\"created_at\":\"2025-03-13 15:16:11\",\"updated_at\":\"2025-03-13 15:24:15\"}', '{\"usuario_nombre\":\"Juan Gabriel\",\"usuario_apellido\":\"Vega Garcia\",\"usuario_usuario\":\"juanvega\",\"usuario_estado\":\"activo\",\"usuario_foto\":\"assets\\/images\\/perfil\\/1741900571_c05e55d21dc696222697.png\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-14 00:02:04'),
(2, 1, 'actualizar', 'Roles', 'Actualización de rol: Administrador', '{\"rol_id\":\"1\",\"rol_nombre\":\"Administrador\",\"rol_descripcion\":\"Acceso completo a todas las funcionalidades del sistema\",\"created_at\":\"2025-03-13 09:24:55\",\"updated_at\":null}', '{\"rol_nombre\":\"Administrador\",\"rol_descripcion\":\"Acceso completo a todas las funcionalidades del sistema\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-14 00:47:20'),
(3, 1, 'crear', 'Roles', 'Creación de rol: Auditor', NULL, '{\"rol_nombre\":\"Auditor\",\"rol_descripcion\":\"Rol de auditor par la supervisi\\u00f3n del sistema\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-14 00:55:49'),
(4, 1, 'actualizar', 'Roles', 'Actualización de rol: Auditor', '{\"rol_id\":\"4\",\"rol_nombre\":\"Auditor\",\"rol_descripcion\":\"Rol de auditor par la supervisi\\u00f3n del sistema\",\"created_at\":\"2025-03-14 06:55:49\",\"updated_at\":\"2025-03-14 06:55:49\"}', '{\"rol_nombre\":\"Auditor\",\"rol_descripcion\":\"Rol de auditor par la supervisi\\u00f3n del sistema\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-14 00:56:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modulos`
--

CREATE TABLE `tbl_modulos` (
  `modulo_id` int(11) NOT NULL,
  `modulo_nombre` varchar(100) NOT NULL,
  `modulo_descripcion` varchar(255) DEFAULT NULL,
  `modulo_ruta` varchar(100) DEFAULT NULL,
  `modulo_icono` varchar(50) DEFAULT NULL,
  `modulo_orden` int(11) DEFAULT 0,
  `modulo_padre_id` int(11) DEFAULT NULL,
  `modulo_estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_modulos`
--

INSERT INTO `tbl_modulos` (`modulo_id`, `modulo_nombre`, `modulo_descripcion`, `modulo_ruta`, `modulo_icono`, `modulo_orden`, `modulo_padre_id`, `modulo_estado`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'Panel principal del sistema', 'dashboard', 'fas fa-tachometer-alt', 1, NULL, 'activo', '2025-03-13 09:24:56', NULL),
(2, 'Usuarios', 'Gestión de usuarios', 'usuarios', 'fas fa-users', 2, NULL, 'activo', '2025-03-13 09:24:56', NULL),
(3, 'Roles', 'Gestión de roles', 'roles', 'fas fa-user-tag', 3, NULL, 'activo', '2025-03-13 09:24:56', NULL),
(4, 'Permisos', 'Gestión de permisos', 'permisos', 'fas fa-key', 4, NULL, 'activo', '2025-03-13 09:24:56', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modulo_acciones`
--

CREATE TABLE `tbl_modulo_acciones` (
  `accion_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `accion_nombre` varchar(50) NOT NULL,
  `accion_descripcion` varchar(255) DEFAULT NULL,
  `accion_clave` varchar(100) NOT NULL COMMENT 'Clave única para identificar la acción en el código',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_modulo_acciones`
--

INSERT INTO `tbl_modulo_acciones` (`accion_id`, `modulo_id`, `accion_nombre`, `accion_descripcion`, `accion_clave`, `created_at`, `updated_at`) VALUES
(1, 2, 'Ver', 'Ver listado de usuarios', 'ver', '2025-03-13 09:24:56', NULL),
(2, 2, 'Crear', 'Crear nuevos usuarios', 'crear', '2025-03-13 09:24:56', NULL),
(3, 2, 'Editar', 'Editar usuarios existentes', 'editar', '2025-03-13 09:24:56', NULL),
(4, 2, 'Eliminar', 'Eliminar usuarios', 'eliminar', '2025-03-13 09:24:56', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos`
--

CREATE TABLE `tbl_permisos` (
  `permiso_id` int(11) NOT NULL,
  `permiso_nombre` varchar(100) NOT NULL,
  `permiso_descripcion` varchar(255) DEFAULT NULL,
  `permiso_clave` varchar(100) NOT NULL COMMENT 'Clave única para identificar el permiso en el código',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_permisos`
--

INSERT INTO `tbl_permisos` (`permiso_id`, `permiso_nombre`, `permiso_descripcion`, `permiso_clave`, `created_at`, `updated_at`) VALUES
(1, 'Administrar Usuarios', 'Gestión completa de usuarios', 'usuarios_admin', '2025-03-13 09:24:56', NULL),
(2, 'Ver Usuarios', 'Ver listado de usuarios', 'usuarios_ver', '2025-03-13 09:24:56', NULL),
(3, 'Crear Usuarios', 'Crear nuevos usuarios', 'usuarios_crear', '2025-03-13 09:24:56', NULL),
(4, 'Editar Usuarios', 'Editar usuarios existentes', 'usuarios_editar', '2025-03-13 09:24:56', NULL),
(5, 'Eliminar Usuarios', 'Eliminar usuarios', 'usuarios_eliminar', '2025-03-13 09:24:56', NULL),
(6, 'Administrar Roles', 'Gestión completa de roles', 'roles_admin', '2025-03-13 09:24:56', NULL),
(7, 'Administrar Permisos', 'Gestión completa de permisos', 'permisos_admin', '2025-03-13 09:24:56', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permiso_acciones`
--

CREATE TABLE `tbl_permiso_acciones` (
  `permiso_accion_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL,
  `accion_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_permiso_acciones`
--

INSERT INTO `tbl_permiso_acciones` (`permiso_accion_id`, `permiso_id`, `accion_id`, `created_at`) VALUES
(1, 2, 1, '2025-03-13 09:24:56'),
(2, 3, 2, '2025-03-13 09:24:56'),
(3, 4, 3, '2025-03-13 09:24:56'),
(4, 5, 4, '2025-03-13 09:24:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `rol_id` int(11) NOT NULL,
  `rol_nombre` varchar(100) NOT NULL,
  `rol_descripcion` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_roles`
--

INSERT INTO `tbl_roles` (`rol_id`, `rol_nombre`, `rol_descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Acceso completo a todas las funcionalidades del sistema', '2025-03-13 09:24:55', NULL),
(2, 'Usuario', 'Acceso básico al sistema', '2025-03-13 09:24:55', NULL),
(3, 'Editor', 'Puede crear y editar contenido pero no administrar usuarios', '2025-03-13 09:24:55', NULL),
(4, 'Auditor', 'Rol de auditor par la supervisión del sistema', '2025-03-14 06:55:49', '2025-03-14 06:55:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_rol_permisos`
--

CREATE TABLE `tbl_rol_permisos` (
  `rol_permiso_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_rol_permisos`
--

INSERT INTO `tbl_rol_permisos` (`rol_permiso_id`, `rol_id`, `permiso_id`, `created_at`) VALUES
(8, 2, 2, '2025-03-13 09:24:56'),
(9, 1, 1, '2025-03-14 00:47:20'),
(10, 1, 2, '2025-03-14 00:47:20'),
(11, 1, 3, '2025-03-14 00:47:20'),
(12, 1, 4, '2025-03-14 00:47:20'),
(13, 1, 5, '2025-03-14 00:47:20'),
(14, 1, 6, '2025-03-14 00:47:20'),
(15, 1, 7, '2025-03-14 00:47:20'),
(17, 4, 2, '2025-03-14 00:56:12'),
(18, 4, 6, '2025-03-14 00:56:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_usuario` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_estado` enum('activo','inactivo','pendiente') NOT NULL,
  `usuario_foto` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'assets/images/prefil/user2-160x160.jpg',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_password_hash`, `usuario_usuario`, `usuario_estado`, `usuario_foto`, `created_at`, `updated_at`) VALUES
(1, 'Administrado', 'Sistema Uriangato', '$2y$10$0/o6peHdlhWmQIf6wR7EzukqvBNvpdrprxXHrOziGEoM.8LhnjOJm', 'admin', 'activo', 'assets/images/perfil/1741900518_aeb02c3df84c11893155.png', '2025-03-13 09:24:56', '2025-03-13 15:15:18'),
(3, 'Juan Gabriel', 'Vega Garcia', '$2y$10$cpBRMUFLgs7H.NByHPq7FOyhQwYv6p/vsEu8IpBjiJo9S.GHHW0Iu', 'juanvega', 'activo', 'assets/images/perfil/1741900571_c05e55d21dc696222697.png', '2025-03-13 15:16:11', '2025-03-13 15:24:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario_roles`
--

CREATE TABLE `tbl_usuario_roles` (
  `usuario_rol_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuario_roles`
--

INSERT INTO `tbl_usuario_roles` (`usuario_rol_id`, `usuario_id`, `rol_id`, `created_at`) VALUES
(1, 1, 1, '2025-03-13 09:24:56'),
(2, 3, 1, '2025-03-14 00:02:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_log_actividad`
--
ALTER TABLE `tbl_log_actividad`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indices de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  ADD PRIMARY KEY (`modulo_id`),
  ADD KEY `idx_modulo_padre_id` (`modulo_padre_id`);

--
-- Indices de la tabla `tbl_modulo_acciones`
--
ALTER TABLE `tbl_modulo_acciones`
  ADD PRIMARY KEY (`accion_id`),
  ADD UNIQUE KEY `uk_modulo_accion_clave` (`modulo_id`,`accion_clave`),
  ADD KEY `idx_modulo_id` (`modulo_id`);

--
-- Indices de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  ADD PRIMARY KEY (`permiso_id`),
  ADD UNIQUE KEY `uk_permiso_clave` (`permiso_clave`);

--
-- Indices de la tabla `tbl_permiso_acciones`
--
ALTER TABLE `tbl_permiso_acciones`
  ADD PRIMARY KEY (`permiso_accion_id`),
  ADD UNIQUE KEY `uk_permiso_accion` (`permiso_id`,`accion_id`),
  ADD KEY `idx_permiso_id` (`permiso_id`),
  ADD KEY `idx_accion_id` (`accion_id`);

--
-- Indices de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `tbl_rol_permisos`
--
ALTER TABLE `tbl_rol_permisos`
  ADD PRIMARY KEY (`rol_permiso_id`),
  ADD UNIQUE KEY `uk_rol_permiso` (`rol_id`,`permiso_id`),
  ADD KEY `idx_rol_id` (`rol_id`),
  ADD KEY `idx_permiso_id` (`permiso_id`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `tbl_usuario_roles`
--
ALTER TABLE `tbl_usuario_roles`
  ADD PRIMARY KEY (`usuario_rol_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_log_actividad`
--
ALTER TABLE `tbl_log_actividad`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  MODIFY `modulo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_modulo_acciones`
--
ALTER TABLE `tbl_modulo_acciones`
  MODIFY `accion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `permiso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_permiso_acciones`
--
ALTER TABLE `tbl_permiso_acciones`
  MODIFY `permiso_accion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_rol_permisos`
--
ALTER TABLE `tbl_rol_permisos`
  MODIFY `rol_permiso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_usuario_roles`
--
ALTER TABLE `tbl_usuario_roles`
  MODIFY `usuario_rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_log_actividad`
--
ALTER TABLE `tbl_log_actividad`
  ADD CONSTRAINT `fk_log_actividad_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`usuario_id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  ADD CONSTRAINT `fk_modulos_modulo_padre` FOREIGN KEY (`modulo_padre_id`) REFERENCES `tbl_modulos` (`modulo_id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `tbl_modulo_acciones`
--
ALTER TABLE `tbl_modulo_acciones`
  ADD CONSTRAINT `fk_modulo_acciones_modulo` FOREIGN KEY (`modulo_id`) REFERENCES `tbl_modulos` (`modulo_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_permiso_acciones`
--
ALTER TABLE `tbl_permiso_acciones`
  ADD CONSTRAINT `fk_permiso_acciones_accion` FOREIGN KEY (`accion_id`) REFERENCES `tbl_modulo_acciones` (`accion_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_permiso_acciones_permiso` FOREIGN KEY (`permiso_id`) REFERENCES `tbl_permisos` (`permiso_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_rol_permisos`
--
ALTER TABLE `tbl_rol_permisos`
  ADD CONSTRAINT `fk_rol_permisos_permiso` FOREIGN KEY (`permiso_id`) REFERENCES `tbl_permisos` (`permiso_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rol_permisos_rol` FOREIGN KEY (`rol_id`) REFERENCES `tbl_roles` (`rol_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_usuario_roles`
--
ALTER TABLE `tbl_usuario_roles`
  ADD CONSTRAINT `fk_usuario_roles_rol` FOREIGN KEY (`rol_id`) REFERENCES `tbl_roles` (`rol_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_roles_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `tbl_usuarios` (`usuario_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
