-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-10-2020 a las 16:50:19
-- Versión del servidor: 5.7.31-0ubuntu0.18.04.1
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbventaslaravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `idarticulos` int(11) NOT NULL,
  `idcategorias` int(11) DEFAULT NULL,
  `codigo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `descripcion` varchar(512) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`idarticulos`, `idcategorias`, `codigo`, `nombre`, `stock`, `descripcion`, `imagen`, `estado`) VALUES
(1, 1, '1001', 'Impresora Epson', 112, 'Imprasora multifuncional de inyeccion de tinta epson', 'impresora_epson_bk.png', 'Activo'),
(2, 1, '1002', 'impresora hp', 101, 'impresora hp 3570', 'impresora_hp_3570.png', 'Activo'),
(3, 3, '1003', 'Ajax en polvo', 101, 'ajax en polvo remanufacturado en colombia', 'ajax.png', 'Activo'),
(4, 7, '1004', 'Vestido Giorgio Armani', 107, 'Vestido Giorgio Armani-Paris', 'vestido_giorgio.png', 'Activo'),
(5, 5, '1005', 'Aceites de vehiculos', 4, 'aceite shell', 'aceite_shell.png', 'Activo'),
(6, 3, '1006', 'cloro', 106, 'cloro clorox', 'cloro.png', 'Activo'),
(7, 3, '1006', 'cloro', 106, 'cloro clorox', NULL, 'Inactivo'),
(8, 3, '1006', 'cloro', 106, 'cloro clorox', 'pendrive-sandisk.jpg', 'Activo'),
(9, 3, '1006', 'cloro', 106, 'cloro clorox', 'computadora.jpg', 'Activo'),
(10, 3, '1006', 'cloro', 106, 'cloro clorox', 'computadora.jpg', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategorias` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `condicion` varchar(2) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategorias`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'computacion', 'partes de computadoras', '1'),
(3, 'limpieza', 'articulos de limpieza', '1'),
(4, 'medicina', 'articulos de medicina', '1'),
(5, 'Aceites', 'Aceites de vehiculos automotor', '1'),
(6, 'Alimentos', 'Comidas preparadas', '1'),
(7, 'Moda', 'articulos de vestimenta', '1'),
(8, 'servicios', 'servicios de computacion', '1'),
(9, 'Bebidas', 'Bebidas alcoholicas', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingresos`
--

CREATE TABLE `detalle_ingresos` (
  `iddetalle_ingresos` int(11) NOT NULL,
  `idingresos` int(11) NOT NULL,
  `idarticulos` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_ingresos`
--

INSERT INTO `detalle_ingresos` (`iddetalle_ingresos`, `idingresos`, `idarticulos`, `cantidad`, `precio_compra`, `precio_venta`) VALUES
(1, 1, 2, 12, '455.00', '345.00'),
(2, 6, 2, 1, '1.00', '1.00'),
(3, 7, 5, 5, '5.00', '5.00'),
(4, 7, 3, 5, '5.00', '5.00'),
(5, 7, 6, 5, '5.00', '5.00'),
(6, 8, 6, 4, '4.00', '4.00'),
(7, 9, 1, 2, '2.00', '2.00'),
(8, 10, 6, 2, '2.00', '2.00'),
(9, 11, 6, 1, '1.00', '1.00'),
(10, 12, 1, 100, '1.00', '1.00'),
(11, 13, 5, 100, '1.00', '1.00');

--
-- Disparadores `detalle_ingresos`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingresos` FOR EACH ROW UPDATE articulos set stock=stock+NEW.cantidad
WHERE articulos.idarticulos = NEW.idarticulos
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `iddetalle_ventas` int(11) NOT NULL,
  `idventas` int(11) NOT NULL,
  `idarticulos` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`iddetalle_ventas`, `idventas`, `idarticulos`, `cantidad`, `precio_venta`, `descuento`) VALUES
(1, 1, 5, 12, '345.00', '16.00'),
(2, 1, 2, 12, '400.00', '2.00'),
(3, 20, 5, 1, '345.00', '0.00'),
(4, 21, 5, 11, '345.00', '1.00'),
(5, 24, 5, 1, '345.00', '0.00'),
(6, 25, 5, 1, '345.00', '0.00'),
(7, 25, 2, 1, '400.00', '0.00'),
(8, 27, 5, 1, '345.00', '0.00'),
(9, 28, 5, 200, '345.00', '0.00'),
(10, 29, 5, 200, '345.00', '0.00');

--
-- Disparadores `detalle_ventas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVentas` AFTER INSERT ON `detalle_ventas` FOR EACH ROW UPDATE articulos set stock=stock-NEW.cantidad
WHERE articulos.idarticulos = NEW.idarticulos
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `idingresos` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `serie_comprobante` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_comprobante` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`idingresos`, `idproveedor`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `estado`) VALUES
(1, 1, '456', '654', '456', '2020-09-03 18:48:50', '16.00', 'C'),
(4, 3, 'Boleta', '1', '1', '2020-09-27 04:25:14', '18.00', 'A'),
(6, 3, 'Boleta', '1', '1', '2020-09-27 04:35:22', '18.00', 'C'),
(7, 3, 'Boleta', '55', '55', '2020-09-27 04:36:34', '18.00', 'C'),
(8, 3, 'Boleta', '4', '4', '2020-09-27 04:52:12', '18.00', 'A'),
(9, 3, 'Boleta', '2', '2', '2020-09-27 04:53:13', '18.00', 'A'),
(10, 3, 'Boleta', '2', '2', '2020-09-27 04:54:58', '18.00', 'A'),
(11, 3, 'Boleta', '1', '1', '2020-09-27 04:57:52', '18.00', 'A'),
(12, 3, 'Boleta', '1', '1', '2020-09-27 04:59:18', '18.00', 'A'),
(13, 3, 'Boleta', '1', '1', '2020-09-27 05:00:52', '18.00', 'C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2020_09_30_162502_create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `idpersonas` int(11) NOT NULL,
  `tipo_persona` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_documento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_documento` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idpersonas`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`) VALUES
(1, 'Cliente', 'Venceramica', 'tipo1', '1234', 'la chapa', '+58-2536524', 'venceramica@gmail.com'),
(2, 'Cliente', 'Unicon', 'tipo2', '6549', 'Zona Industrial', '+58-8965324', 'conduven@gmail.com'),
(3, 'Proveedor', 'farmatodo', 'PAS', '6765', 'lav', '25321514', 'farmatodo@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('N28hBGMjdTAjLYRuVn6jSJ2IyH3fHalLSOIhegMO', 1, '192.168.10.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOWxrRndWS0JnbEE1T2JxSDNhdERJZzE2eXdBTDlLdE5RNnRlS0VUdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9zdi50ZXN0L2FsbWFjZW4vYXJ0aWN1bG8iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkR1hCWWpKVDYycHVaRVNTVkx0YzlaT1hVS1N4SngyN2NTR2xmdjZ4SE41eWNxNHlKbGprQVciO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJEdYQllqSlQ2MnB1WkVTU1ZMdGM5Wk9YVUtTeEp4MjdjU0dsZnY2eEhONXljcTR5Smxqa0FXIjt9', 1601652464);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'cesar pimentel', 'pimentellatuff@hotmail.com', NULL, '$2y$10$GXBYjJT62puZESSVLtc9ZOXUKSxJx27cSGlfv6xHN5ycq4yJljkAW', NULL, NULL, 'qlzDnSyyUu8xzQ58NWNEOrbDjK7OTmEtydajgpSeWShScQyaEqQEKSt2VIaL', NULL, 'profile-photos/CqEkHBQDZ8JWeA760b8lweqZymU8SwDWVr2kJvkz.jpeg', '2020-10-01 13:00:53', '2020-10-02 13:21:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idventas` int(11) NOT NULL,
  `idclientes` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `serie_comprobante` varchar(7) COLLATE utf8_spanish_ci NOT NULL,
  `num_comprobante` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_ventas` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idventas`, `idclientes`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_ventas`, `estado`) VALUES
(1, 1, 'Boleta', '654', '', '2020-09-07 11:05:43', '16.00', '5624.00', 'C'),
(11, 1, 'Boleta', '5', '5', '2020-09-28 18:15:50', '18.00', '345.00', 'A'),
(12, 1, 'Boleta', '66', '66', '2020-09-28 18:16:47', '18.00', '344.00', 'A'),
(13, 1, 'Boleta', '1', '1', '2020-09-28 18:18:11', '18.00', '345.00', 'A'),
(14, 1, 'Boleta', '22', '22', '2020-09-28 18:18:58', '18.00', '345.00', 'A'),
(20, 1, 'Boleta', '11', '11', '2020-09-28 18:31:18', '18.00', '345.00', 'A'),
(21, 1, 'Boleta', '1', '1', '2020-09-28 18:35:09', '18.00', '3794.00', 'A'),
(23, 1, 'Boleta', '33', '33', '2020-09-30 09:39:46', '18.00', '345.00', 'A'),
(24, 1, 'Boleta', '1', '1', '2020-09-30 09:44:36', '18.00', '345.00', 'A'),
(25, 1, 'Boleta', '1', '1', '2020-09-30 09:45:25', '18.00', '745.00', 'A'),
(27, 1, 'Boleta', '11', '11', '2020-09-30 09:48:52', '18.00', '345.00', 'A'),
(28, 1, 'Boleta', '11', '11', '2020-09-30 09:49:15', '18.00', '69000.00', 'A'),
(29, 1, 'Boleta', '11', '11', '2020-09-30 10:01:37', '18.00', '69000.00', 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`idarticulos`),
  ADD KEY `fk_articulos_acategorias` (`idcategorias`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategorias`);

--
-- Indices de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD PRIMARY KEY (`iddetalle_ingresos`),
  ADD KEY `fk_detalle_ingreso` (`idingresos`),
  ADD KEY `fk_detalle_ingreso_articulo` (`idarticulos`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`iddetalle_ventas`),
  ADD KEY `fk_detalle_ventas` (`idventas`),
  ADD KEY `fk_detalle_ventas_articulos` (`idarticulos`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`idingresos`),
  ADD KEY `fk_ingresos_personas` (`idproveedor`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idpersonas`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idventas`),
  ADD KEY `fk_ventas_clientes` (`idclientes`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `idarticulos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  MODIFY `iddetalle_ingresos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `iddetalle_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `idingresos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idpersonas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `fk_articulos_acategorias` FOREIGN KEY (`idcategorias`) REFERENCES `categorias` (`idcategorias`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD CONSTRAINT `fk_detalle_ingreso` FOREIGN KEY (`idingresos`) REFERENCES `ingresos` (`idingresos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ingreso_articulo` FOREIGN KEY (`idarticulos`) REFERENCES `articulos` (`idarticulos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `fk_detalle_ventas` FOREIGN KEY (`idventas`) REFERENCES `ventas` (`idventas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ventas_articulos` FOREIGN KEY (`idarticulos`) REFERENCES `articulos` (`idarticulos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `fk_ingresos_personas` FOREIGN KEY (`idproveedor`) REFERENCES `personas` (`idpersonas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_clientes` FOREIGN KEY (`idclientes`) REFERENCES `personas` (`idpersonas`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
