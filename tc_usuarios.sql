-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2025 a las 16:12:15
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
-- Base de datos: `ingresos_dif`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_usuarios`
--

CREATE TABLE `tc_usuarios` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario_usuario` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `usuario_foto` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'assets/images/prefil/user2-160x160.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `tc_usuarios`
--

INSERT INTO `tc_usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_password_hash`, `usuario_usuario`, `is_admin`, `date_added`, `usuario_foto`) VALUES
(1, 'Felix Omar', 'Ramirez Vazquez', '$argon2id$v=19$m=65536,t=4,p=1$OFNtOHFUV3hCOUdhUFkuaQ$CCVTHGx3pHiMCQ2ymvm3wfSIGIq4xowICSrHaEnj+XA', 'webmaster', 1, '2024-10-21 15:06:00', 'assets/images/prefil/1731606665_logo-oficial-min.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tc_usuarios`
--
ALTER TABLE `tc_usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tc_usuarios`
--
ALTER TABLE `tc_usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
