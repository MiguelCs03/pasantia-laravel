-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2023 a las 18:12:12
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_principal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_perfil`
--

CREATE TABLE `detalle_perfil` (
  `id_sub_menu` int(11) DEFAULT NULL,
  `id_tipo_usuario` int(11) DEFAULT NULL,
  `dp_rol` int(11) DEFAULT NULL,
  `dp_activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_perfil`
--

INSERT INTO `detalle_perfil` (`id_sub_menu`, `id_tipo_usuario`, `dp_rol`, `dp_activo`) VALUES
(1, 1, 0, 1),
(2, 1, 0, 1),
(3, 1, 0, 1),
(1, 2, NULL, 1),
(1, 3, NULL, 0),
(2, 3, NULL, 0),
(3, 3, NULL, 0),
(3, 3, NULL, 1),
(1, 4, NULL, 0),
(2, 4, NULL, 0),
(3, 4, NULL, 0),
(2, 4, NULL, 0),
(3, 4, NULL, 0),
(2, 4, NULL, 0),
(3, 4, NULL, 0),
(1, 4, NULL, 0);

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `descripcion` varchar(64) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `icono` varchar(16) DEFAULT NULL,
  `menu_activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `descripcion`, `orden`, `icono`, `menu_activo`) VALUES
(1, 'Dashboard', 1, 'ClipboardIcon', 1),
(2, 'Roles y Permisos', 2, 'ClipboardIcon', 1);

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
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2022_04_12_154409_create_madepalogins_table', 1),
(11, '2022_04_12_154651_create_i_s_i_usuarios_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('3a8f4b1f9f3ce41197e1e6a50d176c461116f79893f7496a97b093965f50a2f37ba8067ab38d6661', 11, 3, 'Personal Access Token', '[]', 0, '2023-05-12 19:06:52', '2023-05-12 19:06:52', '2024-05-12 15:06:52'),
('44fe7bf464d7486e914a56026c65846daef0adaf39872f4413a3cc89bda6b2b4dfa86119c773c726', 11, 3, 'Personal Access Token', '[]', 0, '2023-05-12 19:03:00', '2023-05-12 19:03:00', '2024-05-12 15:03:00'),
('c96d6db5cdb18d67382751dcbb6c30c8a464318b54da1895847fa8628c92c69fe0941808bd1411cc', 2, 3, 'Personal Access Token', '[]', 0, '2023-05-12 19:07:19', '2023-05-12 19:07:19', '2024-05-12 15:07:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', '5AT6Jlqs8viy22MQs1KT4CEFW7dGSk6O0QDR8Co6', NULL, 'http://localhost', 1, 0, 0, '2023-05-12 19:00:54', '2023-05-12 19:00:54'),
(2, NULL, 'Laravel Password Grant Client', 'LwR3plaVpmEo84SEyeusygwMxpjNjh2TyCQS3sPf', 'users', 'http://localhost', 0, 1, 0, '2023-05-12 19:00:54', '2023-05-12 19:00:54'),
(3, NULL, 'Laravel Personal Access Client', 'nApzyKkz5lNYFcAxqFMCCcOHJB87CnYbDtfV6JMW', NULL, 'http://localhost', 1, 0, 0, '2023-05-12 19:01:08', '2023-05-12 19:01:08'),
(4, NULL, 'Laravel Password Grant Client', 'AlzR0psjes6pvbTf2XX5cWnrfRheBZv7vvA70wUH', 'users', 'http://localhost', 0, 1, 0, '2023-05-12 19:01:08', '2023-05-12 19:01:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-05-12 19:00:54', '2023-05-12 19:00:54'),
(2, 3, '2023-05-12 19:01:08', '2023-05-12 19:01:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id_sub_menu` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `sm_descripcion` varchar(64) DEFAULT NULL,
  `sm_ruta` varchar(64) DEFAULT NULL,
  `sm_orden` int(11) DEFAULT NULL,
  `sm_icono` varchar(16) DEFAULT NULL,
  `sm_activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sub_menu`
--

INSERT INTO `sub_menu` (`id_sub_menu`, `id_menu`, `sm_descripcion`, `sm_ruta`, `sm_orden`, `sm_icono`, `sm_activo`) VALUES
(1, 1, 'Inicio', 'Inicio', 1, 'ClipboardIcon', 1),
(2, 2, 'Permisos', 'Permiso', 1, 'ClipboardIcon', 1),
(3, 2, 'Roles', 'Rol', 2, 'ClipboardIcon', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tu_nombre` varchar(64) DEFAULT NULL,
  `tu_activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `tu_nombre`, `tu_activo`) VALUES
(1, 'Administrador', 1),
(2, 'Jefe', 1),
(3, 'Trabajador', 1),
(4, 'Prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tipo_usuario` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `id_tipo_usuario`, `remember_token`, `created_at`, `updated_at`, `activo`) VALUES
(1, 'Hannah Simonis', 'tad.franecki@example.net', '2023-05-12 18:21:20', '$2y$10$ZWq63rPwjxlpQebSd6JQHuNYZb95VeQfcvPtwJrUyP/25dSueFSmS', 2, 'fM75zF3pbV', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(2, 'Prof. Shemar Keeling PhD', 'shirley48@example.org', '2023-05-12 18:21:20', '$2y$10$wrkLUONd8AoNNrV0uaTLVuvfLSzAjTfm.4iY4WiPqA.iQZ160mPya', 2, 'Sa3NiQpBFN', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(3, 'Prof. Edna McCullough', 'ybeatty@example.com', '2023-05-12 18:21:20', '$2y$10$W42Qw6I4Jen9r3zS.xxLYuzakRAe9tj1yae5hr5lmweksKBurGXS6', 2, '9QbfUJOcOc', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(4, 'Dr. Asia Halvorson II', 'kennith44@example.org', '2023-05-12 18:21:20', '$2y$10$0Sd9au8VcYEqQl6ezocof.J/iEikiU5lF3wPlC25jF3cvZATdaNiy', 2, 'jPscpt8Hoa', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(5, 'Malvina Lehner II', 'hill.chaya@example.net', '2023-05-12 18:21:20', '$2y$10$YOLRkWU0lJwoLrKoN0LmNO2BqzGWLgk7Gw6tztVDodoTBIIY5pn8O', 2, 'U2pMcAdIOd', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(6, 'Haleigh Sanford DVM', 'treva12@example.net', '2023-05-12 18:21:20', '$2y$10$tLiRPDmRAyNIPGQhQBIYTunahSn6I24WQ/NRLu2H8W7P4nNDqIf9G', 2, 'iP4e4cAEZe', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(7, 'Ms. Cordie Langosh DVM', 'claire15@example.com', '2023-05-12 18:21:20', '$2y$10$iSbgi8iAPCTrMFpJMoY51eTFwApPDqaEx43JT952y.1GmM6fPSfnO', 2, '7qV3IACzbu', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(8, 'Pascale Haley', 'nbradtke@example.net', '2023-05-12 18:21:20', '$2y$10$a0SJnmKP.HWW8zgCi0kDW.egArFoeVd9lQCfaBKe8O/LjSsDeyGIG', 2, '6ON3DO8oqR', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(9, 'Margie Wintheiser', 'glover.kobe@example.net', '2023-05-12 18:21:20', '$2y$10$7I3dlx7f/2oNI.1SWlWKwuRhgtFDZpDJNQL7R7spPV.u3MemF5SdS', 2, 'NMizTqKkif', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(10, 'Brendon Schamberger Sr.', 'zohara@example.org', '2023-05-12 18:21:21', '$2y$10$XY1aL78qxRd1WFlvihur4OPeGwx2o2niDapgfKY.8hR1ZkMxhndri', 2, 'OIgUKsiVt8', '2023-05-12 18:21:21', '2023-05-12 18:21:21', 1),
(11, NULL, 'eloy@g.com', NULL, '$2y$10$O4i6X8lqjhn/n1TVW2EL6.GW..bi6b5yyKyZHklRf30O/8DP1qbte', 1, NULL, '2023-05-12 18:43:52', '2023-05-12 18:43:52', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

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
-- Indices de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
