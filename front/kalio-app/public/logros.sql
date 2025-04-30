-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-04-2025 a las 08:46:36
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
-- Base de datos: `kalio_api`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logros`
--

CREATE TABLE `logros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logros`
--

INSERT INTO `logros` (`id`, `nombre`, `descripcion`, `icono`, `created_at`, `updated_at`) VALUES
(1, 'Rutina en marcha', 'Has registrado tu consumo durante 5 días no consecutivos.', '/public/img/calendar.png', '2025-04-10 09:59:38', NULL),
(2, 'Analítico', 'Has consultado los informes 10 veces.', '/public/img/analytics.png', '2025-04-10 09:59:43', NULL),
(3, 'Hoy mejor que ayer', 'Has tenido 3 días seguidos mejorando tu consumo respecto al día anterior.', '/public/img/self-improvement.png', '2025-04-10 09:59:45', NULL),
(4, 'Día libre?', 'Has superado el límite un día pero lo has compensado al día siguiente.', '/public/img/anxiety.png', '2025-04-10 09:59:46', NULL),
(5, 'Sin parar', '10 días seguidos registrando calorías.', '/public/img/time.png', '2025-04-10 09:59:47', NULL),
(6, 'Objetivo estable', 'Te has mantenido dentro del límite de calorías durante 7 días seguidos.', '/public/img/target.png', '2025-04-10 09:59:49', NULL),
(7, 'Adaptación inteligente', 'Has modificado el reto después de revisar tu rendimiento.', '/public/img/analysis.png', '2025-04-10 09:59:50', NULL),
(8, 'Sin excusas', 'Has registrado calorías a pesar de tener un día de fiesta, viaje o similar.', '/public/img/person.png', '2025-04-10 09:59:51', NULL),
(9, 'Diario digital', '30 días seguidos registrando.', '/public/img/diary.png', '2025-04-10 09:59:53', NULL),
(10, 'Control absoluto', '30 días seguidos dentro del límite del reto.', '/public/img/admin-panel.png', '2025-04-10 09:59:54', NULL),
(11, 'Mi mejor yo', 'Has mejorado tu hábito alimentario según los informes.', '/public/img/trophy.png', '2025-04-10 09:59:55', NULL),
(12, 'El feedback es poder', 'Has ajustado hábitos después de ver un pico alto de consumo.', '/public/img/power-button.png', '2025-04-10 09:59:56', NULL),
(13, 'El maestro del control', 'Has consultado informes cada semana durante un mes.', '/public/img/certificate.png', '2025-04-10 09:59:57', NULL),
(14, '¡No puedo parar!', '100 días seguidos registrando calorías.', '/public/img/business.png', '2025-04-10 09:59:58', NULL),
(15, 'Autocontrol zen', '100 días dentro del límite (no necesariamente seguidos).', '/public/img/ying-yang.png', '2025-04-10 10:00:00', NULL),
(16, 'Imbatible', 'Has reducido gradualmente tu límite de calorías y lo has mantenido 3 veces seguidas.', '/public/img/muscle,png', '2025-04-10 10:00:01', NULL),
(17, 'Contigo hasta el final', 'Has estado activo en la app más de 6 meses.', '/public/img/customer-loyalty.png', '2025-04-10 10:00:03', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `logros`
--
ALTER TABLE `logros`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `logros`
--
ALTER TABLE `logros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
