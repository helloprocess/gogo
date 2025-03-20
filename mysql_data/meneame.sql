-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql
-- Tiempo de generación: 20-03-2025 a las 11:18:40
-- Versión del servidor: 8.0.41
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `meneame`
--
CREATE DATABASE IF NOT EXISTS `meneame` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `meneame`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_logs`
--

DROP TABLE IF EXISTS `admin_logs`;
CREATE TABLE `admin_logs` (
  `log_id` int NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_type` text,
  `log_old_value` text,
  `log_new_value` text,
  `log_ref_id` int UNSIGNED NOT NULL,
  `log_user_id` int NOT NULL,
  `log_ip` char(42) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_posts`
--

DROP TABLE IF EXISTS `admin_posts`;
CREATE TABLE `admin_posts` (
  `admin_post_id` int UNSIGNED NOT NULL,
  `admin_user_id` int UNSIGNED NOT NULL,
  `admin_user_login` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `admin_posts`
--

INSERT INTO `admin_posts` (`admin_post_id`, `admin_user_id`, `admin_user_login`) VALUES
(1, 1, 'admin'),
(2, 1, 'admin'),
(6, 1, 'gogo_adm'),
(8, 1, 'gogo_adm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_sections`
--

DROP TABLE IF EXISTS `admin_sections`;
CREATE TABLE `admin_sections` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `admin_sections`
--

INSERT INTO `admin_sections` (`id`, `name`, `created_at`) VALUES
(1, 'admin_users', '2025-03-14 08:00:15'),
(2, 'admin_logs', '2025-03-14 08:00:15'),
(3, 'comment_reports', '2025-03-14 08:00:15'),
(4, 'strikes', '2025-03-14 08:00:15'),
(5, 'hostname', '2025-03-14 08:00:15'),
(6, 'punished_hostname', '2025-03-14 08:00:15'),
(7, 'email', '2025-03-14 08:00:15'),
(8, 'ip', '2025-03-14 08:00:15'),
(9, 'words', '2025-03-14 08:00:15'),
(10, 'noaccess', '2025-03-14 08:00:15'),
(11, 'preguntame', '2025-03-14 08:00:15'),
(12, 'sponsors', '2025-03-14 08:00:15'),
(13, 'mafia', '2025-03-14 08:00:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_id` int NOT NULL,
  `section_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `admin_users`
--

INSERT INTO `admin_users` (`id`, `created_at`, `admin_id`, `section_id`) VALUES
(5, '2025-03-17 16:04:00', 1, 1),
(6, '2025-03-17 16:04:00', 1, 2),
(7, '2025-03-17 16:04:00', 1, 3),
(8, '2025-03-17 16:04:00', 1, 5),
(9, '2025-03-17 16:04:00', 1, 7),
(10, '2025-03-17 16:04:00', 1, 8),
(11, '2025-03-17 16:04:00', 1, 13),
(12, '2025-03-17 16:04:00', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `annotations`
--

DROP TABLE IF EXISTS `annotations`;
CREATE TABLE `annotations` (
  `annotation_key` char(64) NOT NULL,
  `annotation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `annotation_expire` timestamp NULL DEFAULT NULL,
  `annotation_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `annotations`
--

INSERT INTO `annotations` (`annotation_key`, `annotation_time`, `annotation_expire`, `annotation_text`) VALUES
('log-32', '2025-03-17 10:21:49', '2025-04-16 10:21:49', 'a:7:{s:3:\"url\";s:111:\"https://www.nortes.me/2024/03/06/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas/\";s:6:\"status\";s:6:\"queued\";s:5:\"title\";s:21:\"titular de la noticia\";s:4:\"tags\";s:4:\"rwer\";s:3:\"uri\";s:18:\"titular-de-noticia\";s:7:\"content\";s:38:\"rwewerrwewerewrerwerwer erwwerwerrwe w\";s:6:\"sub_id\";s:1:\"1\";}'),
('log-37', '2025-03-17 12:25:00', '2025-04-16 12:25:00', 'a:7:{s:3:\"url\";s:34:\"https://playground.tensorflow.org/\";s:6:\"status\";s:6:\"queued\";s:5:\"title\";s:10:\"wrerwerwer\";s:4:\"tags\";s:3:\"wer\";s:3:\"uri\";s:10:\"wrerwerwer\";s:7:\"content\";s:25:\"wer wer wer r eer r wewer\";s:6:\"sub_id\";s:1:\"1\";}'),
('log-40', '2025-03-17 16:06:04', '2025-04-16 16:06:04', 'a:7:{s:3:\"url\";s:117:\"https://www.agenciasinc.es/Noticias/Revelado-el-misterio-detras-de-los-patrones-geometricos-en-la-nariz-de-los-perros\";s:6:\"status\";s:6:\"queued\";s:5:\"title\";s:20:\"perros y sus narices\";s:4:\"tags\";s:5:\"trufa\";s:3:\"uri\";s:20:\"perros-y-sus-narices\";s:7:\"content\";s:53:\"rwerewrwerwerwerrerwerwerewrewrerwewrrwe ew erw wer r\";s:6:\"sub_id\";s:1:\"1\";}'),
('log-43', '2025-03-17 20:44:48', '2025-04-16 20:44:48', 'a:7:{s:3:\"url\";s:117:\"https://www.agenciasinc.es/Noticias/Revelado-el-misterio-detras-de-los-patrones-geometricos-en-la-nariz-de-los-perros\";s:6:\"status\";s:6:\"queued\";s:5:\"title\";s:20:\"perros y sus narices\";s:4:\"tags\";s:5:\"trufa\";s:3:\"uri\";s:20:\"perros-y-sus-narices\";s:7:\"content\";s:53:\"rwerewrwerwerwerrerwerwerewrewrerwewrrwe ew erw wer r\";s:6:\"sub_id\";s:1:\"1\";}'),
('log-49', '2025-03-19 10:10:49', '2025-04-18 10:10:49', 'a:7:{s:3:\"url\";s:111:\"https://www.nortes.me/2024/03/06/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas/\";s:6:\"status\";s:6:\"queued\";s:5:\"title\";s:18:\"yuityuityuiyuityui\";s:4:\"tags\";s:6:\"iyuyui\";s:3:\"uri\";s:18:\"yuityuityuiyuityui\";s:7:\"content\";s:24:\"iyuyuiuiyuiyutiytuittyui\";s:6:\"sub_id\";s:1:\"1\";}'),
('sub_preferences_2', '2025-03-15 23:39:43', NULL, '{\"no_link\":1,\"intro_min_len\":50}'),
('sub_preferences_3', '2025-03-16 22:05:11', NULL, '{\"intro_min_len\":50,\"rules\":\"hola, reglas\",\"message\":\"mensaje barra lateral\",\"post_html\":\"html al final de la pagina\"}'),
('user_stats-1', '2025-03-20 09:28:44', '2025-06-18 09:28:44', 'O:8:\"stdClass\":7:{s:11:\"total_votes\";i:9;s:11:\"total_links\";i:9;s:15:\"published_links\";i:2;s:14:\"total_comments\";i:4;s:11:\"total_posts\";i:7;s:13:\"total_friends\";i:0;s:12:\"total_images\";i:0;}'),
('user_stats-2', '2025-03-16 22:19:04', '2025-06-14 22:19:04', 'O:8:\"stdClass\":7:{s:11:\"total_votes\";i:0;s:11:\"total_links\";i:0;s:15:\"published_links\";i:0;s:14:\"total_comments\";i:0;s:11:\"total_posts\";i:0;s:13:\"total_friends\";i:0;s:12:\"total_images\";i:0;}'),
('user_stats-3', '2025-03-18 13:11:03', '2025-06-16 13:11:03', 'O:8:\"stdClass\":7:{s:11:\"total_votes\";i:0;s:11:\"total_links\";i:0;s:15:\"published_links\";i:0;s:14:\"total_comments\";i:0;s:11:\"total_posts\";i:0;s:13:\"total_friends\";i:0;s:12:\"total_images\";i:0;}'),
('user_stats-4', '2025-03-18 13:11:03', '2025-06-16 13:11:03', 'O:8:\"stdClass\":7:{s:11:\"total_votes\";i:0;s:11:\"total_links\";i:0;s:15:\"published_links\";i:0;s:14:\"total_comments\";i:0;s:11:\"total_posts\";i:0;s:13:\"total_friends\";i:0;s:12:\"total_images\";i:0;}'),
('user_stats-5', '2025-03-18 13:11:03', '2025-06-16 13:11:03', 'O:8:\"stdClass\":7:{s:11:\"total_votes\";i:0;s:11:\"total_links\";i:0;s:15:\"published_links\";i:0;s:14:\"total_comments\";i:0;s:11:\"total_posts\";i:0;s:13:\"total_friends\";i:0;s:12:\"total_images\";i:0;}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auths`
--

DROP TABLE IF EXISTS `auths`;
CREATE TABLE `auths` (
  `user_id` int UNSIGNED NOT NULL,
  `service` char(32) NOT NULL,
  `uid` decimal(24,0) UNSIGNED NOT NULL,
  `username` char(32) NOT NULL DEFAULT '''''',
  `token` char(64) NOT NULL DEFAULT '''''',
  `secret` char(64) NOT NULL DEFAULT '''''',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `auths`
--

INSERT INTO `auths` (`user_id`, `service`, `uid`, `username`, `token`, `secret`, `modified`) VALUES
(1, '', 1, '\'gogo_admin\'', '\'\'', '\'\'', '2025-03-14 15:19:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatars`
--

DROP TABLE IF EXISTS `avatars`;
CREATE TABLE `avatars` (
  `avatar_id` int NOT NULL,
  `avatar_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `avatar_image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backups`
--

DROP TABLE IF EXISTS `backups`;
CREATE TABLE `backups` (
  `id` int UNSIGNED NOT NULL,
  `contents` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `related_table` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `related_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` char(42) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `backups`
--

INSERT INTO `backups` (`id`, `contents`, `related_table`, `related_id`, `created_at`, `ip`, `user_id`) VALUES
(1, '{\"id\":\"11\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"admin\",\"randkey\":\"683132\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742115752\",\"sent_date\":\"1742115752\",\"published_date\":\"1742115752\",\"modified\":\"1742115752\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"article\",\"ip\":\"121.121.121.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742115752\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742115752\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 11, '2025-03-16 09:07:01', '121.121.121.1', 1),
(2, '{\"id\":\"3\",\"prefix_id\":\"\",\"randkey\":\"24970615\",\"author\":\"1\",\"date\":\"1742163467\",\"votes\":\"0\",\"voted\":\"20\",\"karma\":\"0\",\"content\":\"adsadsad\",\"src\":\"web\",\"read\":\"1\",\"admin\":\"0\",\"poll\":null,\"username\":\"admin\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"ip\":\"2887188481\",\"avatar\":\"0\",\"favorite\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"admin_user_id\":null,\"admin_user_login\":null}', 'posts', 3, '2025-03-16 22:17:58', '172.23.0.1', 1),
(3, '{\"id\":\"2\",\"prefix_id\":\"\",\"randkey\":\"78775966\",\"author\":\"1\",\"date\":\"1742162365\",\"votes\":\"0\",\"voted\":\"20\",\"karma\":\"0\",\"content\":\"hola es una prueba\",\"src\":\"web\",\"read\":\"1\",\"admin\":\"1\",\"poll\":null,\"username\":\"admin\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"ip\":\"2887188481\",\"avatar\":\"0\",\"favorite\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"admin_user_id\":\"1\",\"admin_user_login\":\"admin\"}', 'posts', 2, '2025-03-16 22:48:33', '172.23.0.1', 1),
(4, '{\"id\":\"4\",\"prefix_id\":\"\",\"randkey\":\"96984209\",\"author\":\"1\",\"date\":\"1742167217\",\"votes\":\"0\",\"voted\":\"20\",\"karma\":\"0\",\"content\":\"adssadsadsadsa\",\"src\":\"web\",\"read\":\"1\",\"admin\":\"0\",\"poll\":null,\"username\":\"admin\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"ip\":\"2887188481\",\"avatar\":\"0\",\"favorite\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"admin_user_id\":null,\"admin_user_login\":null}', 'posts', 4, '2025-03-16 23:20:23', '172.23.0.1', 1),
(5, '{\"id\":\"3\",\"prefix_id\":\"\",\"randkey\":\"24970615\",\"author\":\"1\",\"date\":\"1742163467\",\"votes\":\"0\",\"voted\":\"20\",\"karma\":\"0\",\"content\":\"adsadsad dasdasd\",\"src\":\"web\",\"read\":\"1\",\"admin\":\"0\",\"poll\":null,\"username\":\"admin\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"ip\":\"2887188481\",\"avatar\":\"0\",\"favorite\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"admin_user_id\":null,\"admin_user_login\":null}', 'posts', 3, '2025-03-16 23:47:50', '172.23.0.1', 1),
(6, '{\"id\":\"13\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"admin\",\"randkey\":\"125331\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742204851\",\"sent_date\":\"1742204851\",\"published_date\":\"1742204851\",\"modified\":\"1742204851\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"article\",\"ip\":\"172.24.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742204851\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742204851\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 13, '2025-03-17 09:48:06', '172.24.0.1', 1),
(7, '{\"id\":\"4\",\"prefix_id\":\"\",\"randkey\":\"96984209\",\"author\":\"1\",\"date\":\"1742167217\",\"votes\":\"0\",\"voted\":\"20\",\"karma\":\"0\",\"content\":\"adssadsadsadsa dffdf\",\"src\":\"web\",\"read\":\"1\",\"admin\":\"0\",\"poll\":null,\"username\":\"admin\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"ip\":\"2887188481\",\"avatar\":\"0\",\"favorite\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"admin_user_id\":null,\"admin_user_login\":null}', 'posts', 4, '2025-03-17 10:06:03', '172.24.0.1', 1),
(8, '{\"id\":\"14\",\"author\":\"1\",\"blog\":\"2\",\"username\":\"admin\",\"randkey\":\"2596869\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742206705\",\"sent_date\":\"1742206705\",\"published_date\":\"1742206705\",\"modified\":\"1742206705\",\"url\":\"https:\\/\\/www.nortes.me\\/2024\\/03\\/06\\/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas\\/\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"\",\"ip\":\"172.24.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742206705\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742206705\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 14, '2025-03-17 10:18:59', '172.24.0.1', 1),
(9, '{\"id\":\"14\",\"author\":\"1\",\"blog\":\"2\",\"username\":\"admin\",\"randkey\":\"2596869\",\"karma\":\"20.00\",\"valid\":false,\"date\":\"1742206751\",\"sent_date\":\"1742206751\",\"published_date\":\"1742206705\",\"modified\":\"1742206751\",\"url\":\"https:\\/\\/www.nortes.me\\/2024\\/03\\/06\\/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas\\/\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"queued\",\"type\":\"\",\"votes\":\"1\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"titular de la noticia\",\"tags\":\"rwer\",\"uri\":\"titular-de-noticia\",\"thumb_url\":false,\"content\":\"rwewerrwewerewrerwerwer erwwerwerrwe w\",\"content_type\":\"text\",\"ip\":\"172.24.0.1\",\"html\":false,\"read\":\"1\",\"voted\":\"20\",\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"1\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"queued\",\"sub_status_id\":\"1\",\"sub_date\":\"1742206751\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"queued\",\"sub_date_origen\":\"1742206751\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":false}', 'links', 14, '2025-03-17 10:21:49', '172.24.0.1', 1),
(10, '{\"id\":\"20\",\"author\":\"1\",\"blog\":\"1\",\"username\":\"admin\",\"randkey\":\"5057554\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742209826\",\"sent_date\":\"1742209826\",\"published_date\":\"1742209826\",\"modified\":\"1742209826\",\"url\":\"https:\\/\\/playground.tensorflow.org\\/\",\"url_title\":\"A Neural Network Playground\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"text\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742209826\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742209826\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 20, '2025-03-17 11:10:35', '172.21.0.1', 1),
(11, '{\"id\":\"20\",\"author\":\"1\",\"blog\":\"1\",\"username\":\"admin\",\"randkey\":\"5057554\",\"karma\":\"20.00\",\"valid\":false,\"date\":\"1742209840\",\"sent_date\":\"1742209840\",\"published_date\":\"1742209826\",\"modified\":\"1742209840\",\"url\":\"https:\\/\\/playground.tensorflow.org\\/\",\"url_title\":\"A Neural Network Playground\",\"url_description\":\"\",\"encoding\":false,\"status\":\"queued\",\"type\":\"\",\"votes\":\"1\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"wrerwerwer\",\"tags\":\"wer\",\"uri\":\"wrerwerwer\",\"thumb_url\":false,\"content\":\"wer wer wer r eer r wewer\",\"content_type\":\"text\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":\"20\",\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"1\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"queued\",\"sub_status_id\":\"1\",\"sub_date\":\"1742209840\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"queued\",\"sub_date_origen\":\"1742209840\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":false}', 'links', 20, '2025-03-17 12:25:00', '172.21.0.1', 1),
(12, '{\"id\":\"13\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"admin\",\"randkey\":\"125331\",\"karma\":\"20.00\",\"valid\":false,\"date\":\"1742204886\",\"sent_date\":\"1742204886\",\"published_date\":\"1742204851\",\"modified\":\"1742204886\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"queued\",\"type\":\"\",\"votes\":\"1\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"rwerwerwer\",\"tags\":\"art\\u00edculo\",\"uri\":\"rwerwerwer\",\"thumb_url\":false,\"content\":\"<p>rwerwerwer<\\/p>\",\"content_type\":\"article\",\"ip\":\"172.24.0.1\",\"html\":false,\"read\":\"1\",\"voted\":\"20\",\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"2\",\"sub_name\":\"dasd\",\"total_votes\":\"1\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"queued\",\"sub_status_id\":\"2\",\"sub_date\":\"1742204886\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"1\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"1\",\"allow_main_link\":\"0\",\"sub_status_origen\":\"queued\",\"sub_date_origen\":\"1742204886\",\"sub_color1\":\"\",\"sub_color2\":\"\",\"page_mode\":\"standard\",\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":false}', 'links', 13, '2025-03-17 12:28:06', '172.21.0.1', 1),
(13, '{\"id\":\"25\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"admin\",\"randkey\":\"532336\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742218023\",\"sent_date\":\"1742218023\",\"published_date\":\"1742218023\",\"modified\":\"1742218023\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"article\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742218023\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742218023\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 25, '2025-03-17 13:29:48', '172.21.0.1', 1),
(14, '{\"id\":\"28\",\"author\":\"1\",\"blog\":\"4\",\"username\":\"admin\",\"randkey\":\"4479711\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742224396\",\"sent_date\":\"1742224396\",\"published_date\":\"1742224396\",\"modified\":\"1742224396\",\"url\":\"https:\\/\\/www.agenciasinc.es\\/Noticias\\/Revelado-el-misterio-detras-de-los-patrones-geometricos-en-la-nariz-de-los-perros\",\"url_title\":\"El misterio de los patrones geom\\u00e9tricos en la nariz de los perros\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"text\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742224396\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742224396\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 28, '2025-03-17 15:15:32', '172.21.0.1', 1),
(15, '{\"id\":\"28\",\"author\":\"1\",\"blog\":\"4\",\"username\":\"gogo_adm\",\"randkey\":\"4479711\",\"karma\":\"20.00\",\"valid\":false,\"date\":\"1742224535\",\"sent_date\":\"1742224535\",\"published_date\":\"1742224396\",\"modified\":\"1742224535\",\"url\":\"https:\\/\\/www.agenciasinc.es\\/Noticias\\/Revelado-el-misterio-detras-de-los-patrones-geometricos-en-la-nariz-de-los-perros\",\"url_title\":\"El misterio de los patrones geom\\u00e9tricos en la nariz de los perros\",\"url_description\":\"\",\"encoding\":false,\"status\":\"queued\",\"type\":\"\",\"votes\":\"1\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"perros y sus narices\",\"tags\":\"trufa\",\"uri\":\"perros-y-sus-narices\",\"thumb_url\":false,\"content\":\"rwerewrwerwerwerrerwerwerewrewrerwewrrwe ew erw wer r\",\"content_type\":\"text\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":\"20\",\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"1\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"queued\",\"sub_status_id\":\"1\",\"sub_date\":\"1742224535\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"queued\",\"sub_date_origen\":\"1742224535\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":false}', 'links', 28, '2025-03-17 16:06:04', '172.21.0.1', 1),
(16, '{\"id\":\"28\",\"author\":\"1\",\"blog\":\"4\",\"username\":\"gogo_adm\",\"randkey\":\"4479711\",\"karma\":\"20.00\",\"valid\":false,\"date\":\"1742224535\",\"sent_date\":\"1742224535\",\"published_date\":\"1742224396\",\"modified\":\"1742227625\",\"url\":\"https:\\/\\/www.agenciasinc.es\\/Noticias\\/Revelado-el-misterio-detras-de-los-patrones-geometricos-en-la-nariz-de-los-perros\",\"url_title\":\"El misterio de los patrones geom\\u00e9tricos en la nariz de los perros\",\"url_description\":\"\",\"encoding\":false,\"status\":\"queued\",\"type\":\"\",\"votes\":\"1\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"perros y sus narices\",\"tags\":\"trufa\",\"uri\":\"perros-y-sus-narices\",\"thumb_url\":false,\"content\":\"rwerewrwerwerwerrerwerwerewrewrerwewrrwe ew erw wer r\",\"content_type\":\"text\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":\"20\",\"banned\":false,\"thumb_status\":\"error\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"1\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"queued\",\"sub_status_id\":\"1\",\"sub_date\":\"1742224535\",\"comments\":\"2\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"queued\",\"sub_date_origen\":\"1742224535\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":false}', 'links', 28, '2025-03-17 20:44:48', '172.21.0.1', 1),
(17, '{\"id\":\"30\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"gogo_adm\",\"randkey\":\"525691\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742289472\",\"sent_date\":\"1742289472\",\"published_date\":\"1742289472\",\"modified\":\"1742289472\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"article\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742289472\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742289472\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 30, '2025-03-18 09:30:28', '172.21.0.1', 1),
(18, '{\"id\":\"33\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"gogo_adm\",\"randkey\":\"3540053\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742299220\",\"sent_date\":\"1742299220\",\"published_date\":\"1742299220\",\"modified\":\"1742299220\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"article\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"2\",\"sub_name\":\"dasd\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"2\",\"sub_date\":\"1742299220\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"1\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"1\",\"allow_main_link\":\"0\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742299220\",\"sub_color1\":\"\",\"sub_color2\":\"\",\"page_mode\":\"standard\",\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 33, '2025-03-18 12:42:45', '172.21.0.1', 1),
(19, '{\"id\":\"33\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"gogo_adm\",\"randkey\":\"3540053\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742299220\",\"sent_date\":\"1742301765\",\"published_date\":\"1742299220\",\"modified\":\"1742301765\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"titulo de prueba\",\"tags\":\"art\\u00edculo\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"article\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"2\",\"sub_name\":\"dasd\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"2\",\"sub_date\":\"1742299220\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"1\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"1\",\"allow_main_link\":\"0\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742299220\",\"sub_color1\":\"\",\"sub_color2\":\"\",\"page_mode\":\"standard\",\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 33, '2025-03-18 12:43:21', '172.21.0.1', 1),
(20, '{\"id\":\"6\",\"prefix_id\":\"\",\"randkey\":\"10062175\",\"author\":\"1\",\"date\":\"1742213575\",\"votes\":\"0\",\"voted\":\"20\",\"karma\":\"0\",\"content\":\"@admin,5 hola\",\"src\":\"web\",\"read\":\"1\",\"admin\":\"1\",\"poll\":null,\"username\":\"gogo_adm\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"ip\":\"2887057409\",\"avatar\":\"0\",\"favorite\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"admin_user_id\":\"1\",\"admin_user_login\":\"admin\"}', 'posts', 6, '2025-03-18 13:12:44', '172.21.0.1', 1),
(21, '{\"id\":\"37\",\"author\":\"1\",\"blog\":\"2\",\"username\":\"gogo_adm\",\"randkey\":\"7831623\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742371443\",\"sent_date\":\"1742371443\",\"published_date\":\"1742371443\",\"modified\":\"1742371443\",\"url\":\"https:\\/\\/www.nortes.me\\/2024\\/03\\/06\\/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas\\/\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742371443\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742371443\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 37, '2025-03-19 08:04:31', '172.21.0.1', 1),
(22, '{\"id\":\"37\",\"geo\":null,\"thumb_uri\":null,\"do_inline_friend_votes\":false,\"key\":null,\"author\":\"1\",\"blog\":\"2\",\"username\":\"gogo_adm\",\"randkey\":\"7831623\",\"karma\":\"20.00\",\"valid\":false,\"date\":\"1742371475\",\"sent_date\":\"1742371475\",\"published_date\":\"1742371443\",\"modified\":\"1742371475\",\"url\":\"https:\\/\\/www.nortes.me\\/2024\\/03\\/06\\/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas\\/\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"queued\",\"type\":\"\",\"votes\":\"1\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"yuityuityuiyuityui\",\"tags\":\"iyuyui\",\"uri\":\"yuityuityuiyuityui\",\"thumb_url\":false,\"content\":\"iyuyuiuiyuiyutiytuittyui\",\"content_type\":\"image\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":\"20\",\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"1\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"queued\",\"sub_status_id\":\"1\",\"sub_date\":\"1742371475\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"queued\",\"sub_date_origen\":\"1742371475\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":false}', 'links', 37, '2025-03-19 10:10:49', '172.21.0.1', 1),
(23, '{\"id\":\"37\",\"geo\":null,\"thumb_uri\":null,\"do_inline_friend_votes\":false,\"key\":null,\"author\":\"1\",\"blog\":\"2\",\"username\":\"gogo_adm\",\"randkey\":\"7831623\",\"karma\":\"20.00\",\"valid\":false,\"date\":\"1742371475\",\"sent_date\":\"1742371475\",\"published_date\":\"1742371443\",\"modified\":\"1742379049\",\"url\":\"https:\\/\\/www.nortes.me\\/2024\\/03\\/06\\/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas\\/\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"published\",\"type\":\"\",\"votes\":\"1\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"yuityuityuiyuityui\",\"tags\":\"iyuyui\",\"uri\":\"yuityuityuiyuityui\",\"thumb_url\":false,\"content\":\"iyuyuiuiyuiyutiytuittyui\",\"content_type\":\"image\",\"ip\":\"172.21.0.1\",\"html\":false,\"read\":\"1\",\"voted\":\"20\",\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"1\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"published\",\"sub_status_id\":\"1\",\"sub_date\":\"1742371475\",\"comments\":\"0\",\"sub_karma\":\"20.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"published\",\"sub_date_origen\":\"1742371475\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":false}', 'links', 37, '2025-03-19 10:11:22', '172.21.0.1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bans`
--

DROP TABLE IF EXISTS `bans`;
CREATE TABLE `bans` (
  `ban_id` int UNSIGNED NOT NULL,
  `ban_type` enum('email','hostname','punished_hostname','ip','words','proxy','noaccess') CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `ban_text` char(64) NOT NULL,
  `ban_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ban_expire` timestamp NULL DEFAULT NULL,
  `ban_comment` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
  `blog_id` int NOT NULL,
  `blog_key` char(35) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `blog_type` enum('normal','blog','noiframe','redirector','aggregator') CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL DEFAULT 'normal',
  `blog_rss` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `blog_rss2` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `blog_atom` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `blog_url` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `blog_feed` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `blog_feed_checked` timestamp NULL DEFAULT NULL,
  `blog_feed_read` timestamp NULL DEFAULT NULL,
  `blog_title` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `blogs`
--

INSERT INTO `blogs` (`blog_id`, `blog_key`, `blog_type`, `blog_rss`, `blog_rss2`, `blog_atom`, `blog_url`, `blog_feed`, `blog_feed_checked`, `blog_feed_read`, `blog_title`) VALUES
(1, 'ef4a0fcfb264c2365ff334f66919b385', 'normal', '', '', '', 'https://playground.tensorflow.org', NULL, NULL, NULL, NULL),
(2, '537fea395768b81c912c967939538879', 'normal', '', '', '', 'https://www.nortes.me', NULL, NULL, NULL, NULL),
(3, '2b235cffe0c366d461d7738825191d85', 'normal', '', '', '', 'https://streamable.com', NULL, NULL, NULL, NULL),
(4, '99a61640c4cce86e4d48d86ddfacbf6b', 'normal', '', '', '', 'https://www.agenciasinc.es', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category__auto_id` int NOT NULL,
  `category_lang` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'es',
  `category_id` int NOT NULL DEFAULT '0',
  `category_parent` int NOT NULL DEFAULT '0',
  `category_name` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `category_uri` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `category_calculated_coef` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`category__auto_id`, `category_lang`, `category_id`, `category_parent`, `category_name`, `category_uri`, `category_calculated_coef`) VALUES
(1, 'es', 1, 100, 'software libre', NULL, 1.04252),
(4, 'es', 4, 100, 'internet', 'internet', 1.04252),
(6, 'es', 6, 103, 'blogs', NULL, 0.787306),
(38, 'es', 38, 102, 'sociedad', 'sociedad', 1.2186),
(14, 'es', 8, 100, 'hardware', NULL, 1.04252),
(16, 'es', 22, 101, 'ciencia', NULL, 1.06563),
(19, 'es', 13, 100, 'diseño', NULL, 1.04252),
(22, 'es', 11, 100, 'software', NULL, 1.04252),
(70, 'es', 64, 102, 'sucesos', 'sucesos', 1.2186),
(29, 'es', 23, 100, 'juegos', NULL, 1.04252),
(33, 'es', 32, 103, 'friqui', NULL, 0.787306),
(57, 'es', 28, 103, 'podcast', 'podcast', 0.787306),
(35, 'es', 35, 103, 'curiosidades', NULL, 0.787306),
(36, 'es', 36, 101, 'derechos', NULL, 1.06563),
(37, 'es', 37, 100, 'seguridad', NULL, 1.04252),
(39, 'es', 5, 103, 'TV', 'tv', 0.787306),
(40, 'es', 100, 0, 'tecnología', 'tecnologia', 1.04252),
(41, 'es', 101, 0, 'cultura', 'cultura', 1.06563),
(42, 'es', 102, 0, 'actualidad', 'actualidad', 1.2186),
(43, 'es', 7, 102, 'empresas', NULL, 1.2186),
(44, 'es', 9, 101, 'música', NULL, 1.06563),
(45, 'es', 10, 103, 'vídeos', 'videos', 0.787306),
(46, 'es', 12, 103, 'espectáculos', 'espectaculos', 0.787306),
(47, 'es', 15, 101, 'historia', 'historia', 1.06563),
(48, 'es', 16, 101, 'literatura', 'literatura', 1.06563),
(49, 'es', 17, 102, 'américas', 'americas', 1.2186),
(50, 'es', 18, 102, 'europa', 'europa', 1.2186),
(51, 'es', 20, 102, 'internacional', 'internacional', 1.2186),
(53, 'es', 24, 102, 'política', 'politica', 1.2186),
(54, 'es', 25, 102, 'economía', 'economía', 1.2186),
(56, 'es', 27, 103, 'deportes', 'deportes', 0.787306),
(58, 'es', 29, 101, 'educación', 'educación', 1.06563),
(59, 'es', 39, 100, 'medicina', 'medicina', 1.04252),
(60, 'es', 40, 100, 'energía', 'energia', 1.04252),
(61, 'es', 41, 101, 'arte', 'arte', 1.06563),
(62, 'es', 42, 100, 'novedades', 'novedades-tec', 1.04252),
(63, 'es', 43, 100, 'medioambiente', 'medioambiente', 1.04252),
(64, 'es', 44, 102, 'personalidades', 'personalidades', 1.2186),
(65, 'es', 45, 101, 'prensa', 'prensa', 1.06563),
(66, 'es', 103, 0, 'ocio', 'ocio', 0.787306),
(67, 'es', 60, 101, 'fotografía', 'fotografia', 1.06563),
(68, 'es', 61, 101, 'divulgación', 'divulgacion', 1.06563),
(69, 'es', 62, 101, 'cine', 'cine', 1.06563);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats` (
  `chat_time` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `chat_uid` int UNSIGNED NOT NULL DEFAULT '0',
  `chat_room` enum('all','friends','admin') NOT NULL DEFAULT 'all',
  `chat_user` char(32) NOT NULL,
  `chat_text` char(255) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb3 MAX_ROWS=1000;

--
-- Volcado de datos para la tabla `chats`
--

INSERT INTO `chats` (`chat_time`, `chat_uid`, `chat_room`, `chat_user`, `chat_text`) VALUES
(1742426515.79, 1, 'all', 'gogo_adm', 'ttetette');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clones`
--

DROP TABLE IF EXISTS `clones`;
CREATE TABLE `clones` (
  `clon_from` int UNSIGNED NOT NULL,
  `clon_to` int UNSIGNED NOT NULL,
  `clon_ip` char(48) NOT NULL DEFAULT '',
  `clon_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `clones`
--

INSERT INTO `clones` (`clon_from`, `clon_to`, `clon_ip`, `clon_date`) VALUES
(7, 1, 'COOK:172.21.0.1', '2025-03-19 11:37:10'),
(7, 6, 'COOK:172.21.0.1', '2025-03-19 11:37:10'),
(1, 7, '172.21.0.1', '2025-03-19 15:20:19'),
(7, 1, '172.21.0.1', '2025-03-19 15:20:44'),
(6, 1, 'COOK:172.21.0.1', '2025-03-19 16:52:15'),
(6, 7, 'COOK:172.21.0.1', '2025-03-19 16:52:15'),
(1, 6, 'COOK:172.21.0.1', '2025-03-19 17:08:17'),
(1, 7, 'COOK:172.21.0.1', '2025-03-19 17:08:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `comment_type` enum('normal','admin','private') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'normal',
  `comment_randkey` int NOT NULL DEFAULT '0',
  `comment_parent` int DEFAULT '0',
  `comment_link_id` int NOT NULL DEFAULT '0',
  `comment_user_id` int NOT NULL DEFAULT '0',
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_ip_int` decimal(39,0) NOT NULL,
  `comment_ip` varbinary(42) DEFAULT NULL,
  `comment_order` smallint NOT NULL DEFAULT '0',
  `comment_votes` smallint NOT NULL DEFAULT '0',
  `comment_karma` smallint NOT NULL DEFAULT '0',
  `comment_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_type`, `comment_randkey`, `comment_parent`, `comment_link_id`, `comment_user_id`, `comment_date`, `comment_modified`, `comment_ip_int`, `comment_ip`, `comment_order`, `comment_votes`, `comment_karma`, `comment_content`) VALUES
(1, 'normal', 71007442, 0, 28, 1, '2025-03-17 16:06:44', '0000-00-00 00:00:00', 2887057409, 0x3137322e32312e302e31, 1, 0, 20, 'esto es un comentario'),
(2, 'normal', 15456822, 0, 28, 1, '2025-03-17 16:07:05', '0000-00-00 00:00:00', 2887057409, 0x3137322e32312e302e31, 2, 0, 20, '#1 otro'),
(3, 'normal', 15927355, 0, 37, 6, '2025-03-19 17:08:02', '0000-00-00 00:00:00', 2887057409, 0x3137322e32312e302e31, 1, 0, 6, 'fsdfsdadfsadf'),
(4, 'normal', 88324451, 0, 37, 1, '2025-03-19 22:46:23', '0000-00-00 00:00:00', 2887057409, 0x3137322e32312e302e31, 2, 0, 20, 'pues mola'),
(5, 'normal', 68215738, 0, 28, 1, '2025-03-20 09:21:49', '0000-00-00 00:00:00', 2887057409, 0x3137322e32312e302e31, 3, 0, 20, 'desde nueva ip'),
(6, 'normal', 15196889, 0, 20, 1, '2025-03-20 09:41:18', '0000-00-00 00:00:00', 2887057409, 0x3137322e32312e302e31, 1, 0, 20, 'comentamos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE `conversations` (
  `conversation_user_to` int UNSIGNED NOT NULL,
  `conversation_type` enum('comment','post','link') NOT NULL,
  `conversation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `conversation_from` int UNSIGNED NOT NULL,
  `conversation_to` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `conversations`
--

INSERT INTO `conversations` (`conversation_user_to`, `conversation_type`, `conversation_time`, `conversation_from`, `conversation_to`) VALUES
(1, 'post', '2025-03-17 10:06:23', 5, 4),
(1, 'post', '2025-03-17 10:06:23', 5, 2),
(1, 'comment', '2025-03-17 16:07:05', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `counts`
--

DROP TABLE IF EXISTS `counts`;
CREATE TABLE `counts` (
  `key` char(64) NOT NULL,
  `count` int NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `counts`
--

INSERT INTO `counts` (`key`, `count`, `date`) VALUES
('0.published', 0, '2025-03-14 07:37:33'),
('1.abuse', 0, '2025-03-18 09:29:47'),
('1.autodiscard', 0, '2025-03-18 09:29:47'),
('1.discard', 18, '2025-03-18 09:29:47'),
('1.published', 2, '2025-03-20 07:54:59'),
('1.queued', 2, '2025-03-20 08:20:06'),
('2.published', 0, '2025-03-18 16:46:10'),
('2.queued', 2, '2025-03-18 12:00:17'),
('posts', 7, '2025-03-20 09:27:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `favorite_user_id` int UNSIGNED NOT NULL,
  `favorite_type` enum('link','post','comment') NOT NULL DEFAULT 'link',
  `favorite_link_id` int UNSIGNED NOT NULL,
  `favorite_link_readed` int UNSIGNED NOT NULL DEFAULT '0',
  `favorite_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `friend_type` enum('affiliate','manual','hide','affinity') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'affiliate',
  `friend_from` int NOT NULL DEFAULT '0',
  `friend_to` int NOT NULL DEFAULT '0',
  `friend_value` smallint NOT NULL DEFAULT '0',
  `friend_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geo_links`
--

DROP TABLE IF EXISTS `geo_links`;
CREATE TABLE `geo_links` (
  `geo_id` int NOT NULL,
  `geo_text` char(80) DEFAULT NULL,
  `geo_pt` point NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geo_users`
--

DROP TABLE IF EXISTS `geo_users`;
CREATE TABLE `geo_users` (
  `geo_id` int NOT NULL,
  `geo_text` char(80) DEFAULT NULL,
  `geo_pt` point NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_images_seen`
--

DROP TABLE IF EXISTS `html_images_seen`;
CREATE TABLE `html_images_seen` (
  `hash` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `language_id` int NOT NULL,
  `language_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league`
--

DROP TABLE IF EXISTS `league`;
CREATE TABLE `league` (
  `id` int UNSIGNED NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_matches`
--

DROP TABLE IF EXISTS `league_matches`;
CREATE TABLE `league_matches` (
  `id` int UNSIGNED NOT NULL,
  `league_id` int UNSIGNED NOT NULL,
  `local` int UNSIGNED NOT NULL,
  `visitor` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote_starts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `votes_local` int DEFAULT '0',
  `votes_visitor` int DEFAULT '0',
  `votes_tied` int DEFAULT '0',
  `score_local` int DEFAULT NULL,
  `score_visitor` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_teams`
--

DROP TABLE IF EXISTS `league_teams`;
CREATE TABLE `league_teams` (
  `id` int UNSIGNED NOT NULL,
  `shortname` char(5) DEFAULT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_terms`
--

DROP TABLE IF EXISTS `league_terms`;
CREATE TABLE `league_terms` (
  `user_id` int NOT NULL,
  `vendor` enum('nivea') NOT NULL DEFAULT 'nivea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_votes`
--

DROP TABLE IF EXISTS `league_votes`;
CREATE TABLE `league_votes` (
  `match_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `value` int UNSIGNED NOT NULL,
  `ip` decimal(39,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `link_id` int NOT NULL,
  `link_author` int NOT NULL DEFAULT '0',
  `link_blog` int DEFAULT '0',
  `link_status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'discard',
  `link_randkey` int NOT NULL DEFAULT '0',
  `link_votes` int NOT NULL DEFAULT '0',
  `link_negatives` int NOT NULL DEFAULT '0',
  `link_anonymous` int UNSIGNED NOT NULL DEFAULT '0',
  `link_votes_avg` float NOT NULL DEFAULT '0',
  `link_comments` int UNSIGNED NOT NULL DEFAULT '0',
  `link_karma` decimal(10,2) NOT NULL DEFAULT '0.00',
  `link_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `link_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_sent_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_published_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_category` int NOT NULL DEFAULT '0',
  `link_lang` char(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'es',
  `link_ip_int` decimal(39,0) NOT NULL,
  `link_ip` varbinary(42) DEFAULT NULL,
  `link_content_type` char(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `link_uri` char(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `link_url` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `link_thumb_status` enum('unknown','checked','error','local','remote','deleted') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'unknown',
  `link_thumb_x` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `link_thumb_y` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `link_thumb` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `link_url_title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `link_title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `link_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `link_tags` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `link_nsfw` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `links`
--

INSERT INTO `links` (`link_id`, `link_author`, `link_blog`, `link_status`, `link_randkey`, `link_votes`, `link_negatives`, `link_anonymous`, `link_votes_avg`, `link_comments`, `link_karma`, `link_modified`, `link_date`, `link_sent_date`, `link_published_date`, `link_category`, `link_lang`, `link_ip_int`, `link_ip`, `link_content_type`, `link_uri`, `link_url`, `link_thumb_status`, `link_thumb_x`, `link_thumb_y`, `link_thumb`, `link_url_title`, `link_title`, `link_content`, `link_tags`, `link_nsfw`) VALUES
(5, 1, 0, 'discard', 140161, 0, 0, 0, 0, 0, 0.00, '2025-03-16 01:14:56', '2025-03-16 01:14:56', '2025-03-16 01:14:56', '2025-03-16 01:14:56', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(6, 1, 0, 'discard', 274199, 0, 0, 0, 0, 0, 0.00, '2025-03-16 01:15:09', '2025-03-16 01:15:09', '2025-03-16 01:15:09', '2025-03-16 01:15:09', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(7, 1, 0, 'discard', 695057, 0, 0, 0, 0, 0, 0.00, '2025-03-16 01:18:19', '2025-03-16 01:18:19', '2025-03-16 01:18:19', '2025-03-16 01:18:19', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(8, 1, 0, 'discard', 448909, 0, 0, 0, 0, 0, 0.00, '2025-03-16 01:23:39', '2025-03-16 01:23:39', '2025-03-16 01:23:39', '2025-03-16 01:23:39', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(9, 1, 0, 'discard', 953949, 0, 0, 0, 0, 0, 0.00, '2025-03-16 08:00:47', '2025-03-16 08:00:47', '2025-03-16 08:00:47', '2025-03-16 08:00:47', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(10, 1, 0, 'discard', 744806, 0, 0, 0, 0, 0, 0.00, '2025-03-16 08:46:30', '2025-03-16 08:46:30', '2025-03-16 08:46:30', '2025-03-16 08:46:30', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(11, 1, 0, 'private', 683132, 1, 0, 0, 0, 0, 20.00, '2025-03-16 09:07:01', '2025-03-16 09:07:01', '2025-03-16 09:07:01', '2025-03-16 09:02:32', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', 'dsfsdsfdfds', '', 'unknown', 0, 0, NULL, '', 'dsfsdsfdfds', '<p>fdsfsdfdsfsfd</p>', 'artículo', 0),
(12, 1, 2, 'discard', 5321645, 0, 0, 0, 0, 0, 0.00, '2025-03-16 22:57:59', '2025-03-16 22:57:59', '2025-03-16 22:57:59', '2025-03-16 22:57:59', 0, 'es', 2887188481, 0x3137322e32332e302e31, '', '', 'https://www.nortes.me/2024/03/06/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas/', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(13, 1, 0, 'queued', 125331, 1, 0, 0, 0, 0, 20.00, '2025-03-17 09:48:06', '2025-03-17 09:48:06', '2025-03-17 09:48:06', '2025-03-17 09:47:31', 0, 'es', 2887254017, 0x3137322e32342e302e31, 'article', 'rwerwerwer', '', 'unknown', 0, 0, NULL, '', 'rwerwerwer', '<p>rwerwerwer</p>', 'artículo', 0),
(14, 1, 2, 'queued', 2596869, 1, 0, 0, 0, 0, 20.00, '2025-03-17 10:21:49', '2025-03-17 10:19:11', '2025-03-17 10:19:11', '2025-03-17 10:18:25', 0, 'es', 2887254017, 0x3137322e32342e302e31, 'text', 'titular-de-noticia', 'https://www.nortes.me/2024/03/06/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas/', 'checked', 0, 0, NULL, '', 'titular de la noticia', 'rwewerrwewerewrerwerwer erwwerwerrwe w', 'rwer', 0),
(17, 1, 0, 'discard', 670019, 0, 0, 0, 0, 0, 0.00, '2025-03-17 11:02:00', '2025-03-17 11:02:00', '2025-03-17 11:02:00', '2025-03-17 11:02:00', 0, 'es', 2886991873, 0x3137322e32302e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(18, 1, 0, 'discard', 905460, 0, 0, 0, 0, 0, 0.00, '2025-03-17 11:03:32', '2025-03-17 11:03:32', '2025-03-17 11:03:32', '2025-03-17 11:03:32', 0, 'es', 2886991873, 0x3137322e32302e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(19, 1, 0, 'discard', 635004, 0, 0, 0, 0, 0, 0.00, '2025-03-17 11:10:04', '2025-03-17 11:10:04', '2025-03-17 11:10:04', '2025-03-17 11:10:04', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(20, 1, 1, 'queued', 5057554, 1, 0, 0, 0, 1, 20.00, '2025-03-20 09:41:18', '2025-03-17 11:10:40', '2025-03-17 11:10:40', '2025-03-17 11:10:26', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'text', 'wrerwerwer', 'https://playground.tensorflow.org/', 'error', 0, 0, NULL, 'A Neural Network Playground', 'wrerwerwer', 'wer wer wer r eer r wewer', 'wer', 0),
(21, 1, 0, 'discard', 862194, 0, 0, 0, 0, 0, 0.00, '2025-03-17 11:18:55', '2025-03-17 11:18:55', '2025-03-17 11:18:55', '2025-03-17 11:18:55', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(22, 1, 0, 'discard', 406281, 0, 0, 0, 0, 0, 0.00, '2025-03-17 11:38:33', '2025-03-17 11:38:33', '2025-03-17 11:38:33', '2025-03-17 11:38:33', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(23, 1, 0, 'discard', 363237, 0, 0, 0, 0, 0, 0.00, '2025-03-17 13:08:19', '2025-03-17 13:08:19', '2025-03-17 13:08:19', '2025-03-17 13:08:19', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(24, 1, 0, 'discard', 752849, 0, 0, 0, 0, 0, 0.00, '2025-03-17 13:18:00', '2025-03-17 13:18:00', '2025-03-17 13:18:00', '2025-03-17 13:18:00', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(25, 1, 0, 'queued', 532336, 1, 0, 0, 0, 0, 20.00, '2025-03-17 13:29:48', '2025-03-17 13:29:48', '2025-03-17 13:29:48', '2025-03-17 13:27:03', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', 'dasdasdasddasd', '', 'unknown', 0, 0, NULL, '', 'dasdasdasddasd', '<p>dqsasadasdasddas</p>', 'artículo', 0),
(26, 1, 0, 'discard', 652722, 0, 0, 0, 0, 0, 0.00, '2025-03-17 15:01:57', '2025-03-17 15:01:57', '2025-03-17 15:01:57', '2025-03-17 15:01:57', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(27, 1, 0, 'discard', 702690, 0, 0, 0, 0, 0, 0.00, '2025-03-17 15:13:03', '2025-03-17 15:13:03', '2025-03-17 15:13:03', '2025-03-17 15:13:03', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(28, 1, 4, 'published', 4479711, 1, 0, 0, 0, 3, 20.00, '2025-03-20 09:21:49', '2025-03-17 15:15:35', '2025-03-17 15:15:35', '2025-03-17 15:13:16', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'text', 'perros-y-sus-narices', 'https://www.agenciasinc.es/Noticias/Revelado-el-misterio-detras-de-los-patrones-geometricos-en-la-nariz-de-los-perros', 'error', 0, 0, NULL, 'El misterio de los patrones geométricos en la nariz de los perros', 'perros y sus narices', 'rwerewrwerwerwerrerwerwerewrewrerwewrrwe ew erw wer r', 'trufa', 0),
(29, 1, 0, 'discard', 602479, 0, 0, 0, 0, 0, 0.00, '2025-03-17 22:00:36', '2025-03-17 22:00:36', '2025-03-17 22:00:36', '2025-03-17 22:00:36', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(30, 1, 0, 'private', 525691, 1, 0, 0, 0, 0, 20.00, '2025-03-18 09:30:28', '2025-03-18 09:30:28', '2025-03-18 09:30:28', '2025-03-18 09:17:52', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', 'holasfdfsdf', '', 'unknown', 0, 0, NULL, '', 'holasfdfsdf', '', 'artículo', 0),
(31, 1, 0, 'discard', 752229, 0, 0, 0, 0, 0, 0.00, '2025-03-18 10:57:22', '2025-03-18 10:57:22', '2025-03-18 10:57:22', '2025-03-18 10:57:22', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(33, 1, 0, 'queued', 3540053, 1, 0, 0, 0, 0, 20.00, '2025-03-18 12:43:21', '2025-03-18 12:43:21', '2025-03-18 12:43:21', '2025-03-18 12:00:20', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', 'titulo-de-prueba', '', 'unknown', 0, 0, NULL, '', 'titulo de prueba', '', 'artículo', 0),
(34, 1, 0, 'discard', 127377, 0, 0, 0, 0, 0, 0.00, '2025-03-18 14:18:40', '2025-03-18 14:18:40', '2025-03-18 14:18:40', '2025-03-18 14:18:40', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(35, 1, 0, 'discard', 696401, 0, 0, 0, 0, 0, 0.00, '2025-03-18 16:39:01', '2025-03-18 16:39:01', '2025-03-18 16:39:01', '2025-03-18 16:39:01', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(36, 1, 0, 'discard', 602804, 0, 0, 0, 0, 0, 0.00, '2025-03-19 08:03:53', '2025-03-19 08:03:53', '2025-03-19 08:03:53', '2025-03-19 08:03:53', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(37, 1, 2, 'published', 7831623, 1, 0, 0, 0, 2, 20.00, '2025-03-19 22:46:23', '2025-03-19 08:04:35', '2025-03-19 08:04:35', '2025-03-19 08:04:03', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'image', 'yuityuityuiyuityui', 'https://www.nortes.me/2024/03/06/el-parlamento-asturiano-vota-sacar-al-lobo-del-listado-de-especies-protegidas/', 'unknown', 0, 0, NULL, '', 'yuityuityuiyuityui', 'iyuyuiuiyuiyutiytuittyui', 'iyuyui', 0),
(38, 1, 0, 'discard', 136737, 0, 0, 0, 0, 0, 0.00, '2025-03-19 15:27:21', '2025-03-19 15:27:21', '2025-03-19 15:27:21', '2025-03-19 15:27:21', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(39, 1, 0, 'discard', 520821, 0, 0, 0, 0, 0, 0.00, '2025-03-19 22:49:00', '2025-03-19 22:49:00', '2025-03-19 22:49:00', '2025-03-19 22:49:00', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(40, 1, 0, 'discard', 462067, 0, 0, 0, 0, 0, 0.00, '2025-03-19 22:49:00', '2025-03-19 22:49:00', '2025-03-19 22:49:00', '2025-03-19 22:49:00', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(41, 1, 0, 'discard', 798464, 0, 0, 0, 0, 0, 0.00, '2025-03-20 09:22:15', '2025-03-20 09:22:15', '2025-03-20 09:22:15', '2025-03-20 09:22:15', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(42, 1, 0, 'discard', 708926, 0, 0, 0, 0, 0, 0.00, '2025-03-20 09:22:16', '2025-03-20 09:22:16', '2025-03-20 09:22:16', '2025-03-20 09:22:16', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(43, 1, 0, 'discard', 471284, 0, 0, 0, 0, 0, 0.00, '2025-03-20 09:28:28', '2025-03-20 09:28:28', '2025-03-20 09:28:28', '2025-03-20 09:28:28', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0),
(44, 1, 0, 'discard', 811807, 0, 0, 0, 0, 0, 0.00, '2025-03-20 09:28:29', '2025-03-20 09:28:29', '2025-03-20 09:28:29', '2025-03-20 09:28:29', 0, 'es', 2887057409, 0x3137322e32312e302e31, 'article', '', '', 'unknown', 0, 0, NULL, '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_clicks`
--

DROP TABLE IF EXISTS `link_clicks`;
CREATE TABLE `link_clicks` (
  `id` int UNSIGNED NOT NULL,
  `counter` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_commons`
--

DROP TABLE IF EXISTS `link_commons`;
CREATE TABLE `link_commons` (
  `link` int UNSIGNED NOT NULL,
  `value` float NOT NULL,
  `n` int NOT NULL DEFAULT '0',
  `date` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `log_id` int NOT NULL,
  `log_sub` int DEFAULT '1',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_type` enum('link_new','comment_new','link_publish','link_discard','comment_edit','link_edit','post_new','post_edit','login_failed','spam_warn','link_geo_edit','user_new','user_delete','link_depublished','user_depublished_vote') NOT NULL,
  `log_ref_id` int UNSIGNED NOT NULL,
  `log_user_id` int NOT NULL,
  `log_ip_int` decimal(39,0) NOT NULL,
  `log_ip` char(42) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`log_id`, `log_sub`, `log_date`, `log_type`, `log_ref_id`, `log_user_id`, `log_ip_int`, `log_ip`) VALUES
(1, 1, '2025-03-14 20:48:50', 'login_failed', 0, 0, 0, ''),
(2, 1, '2025-03-14 20:49:49', 'login_failed', 0, 0, 0, ''),
(3, 1, '2025-03-14 20:49:49', 'login_failed', 0, 0, 0, ''),
(4, 1, '2025-03-14 21:03:49', 'login_failed', 0, 0, 0, ''),
(5, 1, '2025-03-14 21:47:32', 'login_failed', 0, 0, 0, ''),
(6, 1, '2025-03-14 22:23:43', 'login_failed', 0, 0, 0, ''),
(7, 1, '2025-03-14 22:23:58', 'login_failed', 0, 0, 0, ''),
(8, 1, '2025-03-14 22:29:02', 'login_failed', 0, 0, 0, ''),
(9, 1, '2025-03-14 22:29:28', 'login_failed', 0, 0, 0, ''),
(10, 1, '2025-03-14 22:53:25', 'login_failed', 0, 0, 0, ''),
(11, 1, '2025-03-14 23:19:19', 'login_failed', 0, 0, 0, ''),
(12, 1, '2025-03-15 08:16:42', 'login_failed', 0, 0, 0, ''),
(13, 1, '2025-03-15 08:16:48', 'login_failed', 0, 0, 0, ''),
(14, 1, '2025-03-15 08:25:53', 'login_failed', 0, 0, 0, ''),
(15, 1, '2025-03-16 00:47:55', 'login_failed', 2038003969, 0, 2038003969, '121.121.121.1'),
(16, 1, '2025-03-16 09:07:01', 'link_new', 11, 1, 2038003969, '121.121.121.1'),
(17, 1, '2025-03-16 09:08:16', 'post_new', 1, 1, 2038003969, '121.121.121.1'),
(18, 1, '2025-03-16 21:59:25', 'post_new', 2, 1, 2887188481, '172.23.0.1'),
(19, 1, '2025-03-16 22:17:47', 'post_new', 3, 1, 2887188481, '172.23.0.1'),
(20, 1, '2025-03-16 22:17:58', 'post_edit', 3, 1, 2887188481, '172.23.0.1'),
(21, 1, '2025-03-16 22:37:38', 'user_new', 3, 3, 2887188481, '121.121.121.1'),
(22, 1, '2025-03-16 22:37:59', 'user_new', 4, 4, 2887188481, '121.121.121.1'),
(23, 1, '2025-03-16 22:39:24', 'user_new', 5, 5, 2887188481, '121.121.121.1'),
(24, 1, '2025-03-16 22:48:33', 'post_edit', 2, 1, 2887188481, '172.23.0.1'),
(25, 1, '2025-03-16 23:20:17', 'post_new', 4, 1, 2887188481, '172.23.0.1'),
(26, 1, '2025-03-16 23:20:23', 'post_edit', 4, 1, 2887188481, '172.23.0.1'),
(27, 1, '2025-03-16 23:47:50', 'post_edit', 3, 1, 2887188481, '172.23.0.1'),
(28, 2, '2025-03-17 09:48:06', 'link_new', 13, 1, 2887254017, '172.24.0.1'),
(29, 1, '2025-03-17 10:06:03', 'post_edit', 4, 1, 2887254017, '172.24.0.1'),
(30, 1, '2025-03-17 10:06:23', 'post_new', 5, 1, 2887254017, '172.24.0.1'),
(31, 1, '2025-03-17 10:19:11', 'link_new', 14, 1, 2887254017, '172.24.0.1'),
(32, 1, '2025-03-17 10:21:49', 'link_edit', 14, 1, 2887254017, '172.24.0.1'),
(33, 1, '2025-03-17 11:10:40', 'link_new', 20, 1, 2887057409, '172.21.0.1'),
(34, 1, '2025-03-17 11:37:23', 'login_failed', 2887057409, 0, 2887057409, '172.21.0.1'),
(35, 1, '2025-03-17 11:37:27', 'login_failed', 2887057409, 0, 2887057409, '172.21.0.1'),
(36, 1, '2025-03-17 12:12:55', 'post_new', 6, 1, 2887057409, '172.21.0.1'),
(37, 1, '2025-03-17 12:25:00', 'link_edit', 20, 1, 2887057409, '172.21.0.1'),
(38, 2, '2025-03-17 13:29:48', 'link_new', 25, 1, 2887057409, '172.21.0.1'),
(39, 1, '2025-03-17 15:15:35', 'link_new', 28, 1, 2887057409, '172.21.0.1'),
(40, 1, '2025-03-17 16:06:04', 'link_edit', 28, 1, 2887057409, '172.21.0.1'),
(41, 1, '2025-03-17 16:06:44', 'comment_new', 1, 1, 2887057409, '172.21.0.1'),
(42, 1, '2025-03-17 16:07:05', 'comment_new', 2, 1, 2887057409, '172.21.0.1'),
(43, 1, '2025-03-17 20:44:48', 'link_edit', 28, 1, 2887057409, '172.21.0.1'),
(44, 1, '2025-03-17 21:45:30', 'post_new', 7, 1, 2887057409, '172.21.0.1'),
(45, 1, '2025-03-18 09:30:28', 'link_new', 30, 1, 2887057409, '172.21.0.1'),
(46, 2, '2025-03-18 12:43:21', 'link_new', 33, 1, 2887057409, '172.21.0.1'),
(47, 1, '2025-03-18 13:12:44', 'post_edit', 6, 1, 2887057409, '172.21.0.1'),
(48, 1, '2025-03-19 08:04:35', 'link_new', 37, 1, 2887057409, '172.21.0.1'),
(49, 1, '2025-03-19 10:10:49', 'link_edit', 37, 1, 2887057409, '172.21.0.1'),
(50, 1, '2025-03-19 10:54:11', 'user_new', 6, 6, 2887057409, '121.121.121.1'),
(51, 1, '2025-03-19 10:58:48', 'login_failed', 2887057409, 0, 2887057409, '172.21.0.1'),
(52, 1, '2025-03-19 10:59:02', 'login_failed', 2887057409, 0, 2887057409, '172.21.0.1'),
(53, 1, '2025-03-19 11:01:21', 'user_new', 7, 7, 2887057409, '172.21.0.1'),
(54, 1, '2025-03-19 11:36:31', 'login_failed', 2887057409, 0, 2887057409, '172.21.0.1'),
(55, 1, '2025-03-19 17:08:02', 'comment_new', 3, 6, 2887057409, '172.21.0.1'),
(56, 1, '2025-03-19 22:46:23', 'comment_new', 4, 1, 2887057409, '172.21.0.1'),
(57, 1, '2025-03-20 09:21:49', 'comment_new', 5, 1, 2887057409, '172.21.0.1'),
(58, 1, '2025-03-20 09:29:16', 'post_new', 8, 1, 2887057409, '172.21.0.1'),
(59, 1, '2025-03-20 09:41:18', 'comment_new', 6, 1, 2887057409, '172.21.0.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_pos`
--

DROP TABLE IF EXISTS `log_pos`;
CREATE TABLE `log_pos` (
  `host` varchar(60) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_file` varchar(32) DEFAULT NULL,
  `log_pos` int DEFAULT NULL,
  `master_host` varchar(60) DEFAULT NULL,
  `master_log_file` varchar(32) DEFAULT NULL,
  `master_log_pos` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `type` char(12) NOT NULL DEFAULT '',
  `id` int UNSIGNED NOT NULL,
  `version` tinyint UNSIGNED NOT NULL,
  `user` int UNSIGNED NOT NULL,
  `to` int UNSIGNED NOT NULL DEFAULT '0',
  `access` enum('restricted','public','friends','private') NOT NULL DEFAULT 'restricted',
  `mime` char(32) NOT NULL,
  `extension` char(6) NOT NULL DEFAULT 'jpg',
  `size` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dim1` smallint UNSIGNED NOT NULL,
  `dim2` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `user` int UNSIGNED NOT NULL,
  `type` char(12) NOT NULL,
  `counter` int NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pageloads`
--

DROP TABLE IF EXISTS `pageloads`;
CREATE TABLE `pageloads` (
  `date` date NOT NULL,
  `type` enum('html','ajax','other','rss','image','api','sneaker','bot','geo') NOT NULL DEFAULT 'html',
  `counter` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `polls`
--

DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
  `id` int UNSIGNED NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `duration` smallint NOT NULL DEFAULT '0',
  `votes` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_at` datetime NOT NULL,
  `link_id` int DEFAULT NULL,
  `post_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `polls`
--

INSERT INTO `polls` (`id`, `question`, `duration`, `votes`, `created_at`, `end_at`, `link_id`, `post_id`) VALUES
(1, 'pregunta', 6, 1, '2025-03-17 21:45:30', '2025-03-18 03:45:30', NULL, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `polls_options`
--

DROP TABLE IF EXISTS `polls_options`;
CREATE TABLE `polls_options` (
  `id` int UNSIGNED NOT NULL,
  `option` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `votes` smallint UNSIGNED NOT NULL DEFAULT '0',
  `karma` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `poll_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `polls_options`
--

INSERT INTO `polls_options` (`id`, `option`, `votes`, `karma`, `poll_id`) VALUES
(1, 'opcion 1', 1, 20.00, 1),
(2, 'opcion 2', 0, 0.00, 1),
(3, 'opcion 3', 0, 0.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int UNSIGNED NOT NULL,
  `post_randkey` int NOT NULL DEFAULT '0',
  `post_src` enum('web','api','im','mobile','phone') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'web',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_user_id` int UNSIGNED NOT NULL,
  `post_visible` enum('all','friends') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'all',
  `post_ip_int` decimal(39,0) DEFAULT NULL,
  `post_votes` smallint NOT NULL DEFAULT '0',
  `post_karma` smallint NOT NULL DEFAULT '0',
  `post_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `post_is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `post_randkey`, `post_src`, `post_date`, `post_user_id`, `post_visible`, `post_ip_int`, `post_votes`, `post_karma`, `post_content`, `post_is_admin`) VALUES
(1, 58605581, 'web', '2025-03-16 09:08:16', 1, 'all', 2038003969, 0, 0, 'adasd', 1),
(2, 78775966, 'web', '2025-03-16 21:59:25', 1, 'all', 2887188481, 0, 0, 'hola es una prueba ZXCZCX', 1),
(3, 24970615, 'web', '2025-03-16 22:17:47', 1, 'all', 2887188481, 0, 0, 'adsadsad dasdasd cvcbcb', 0),
(4, 96984209, 'web', '2025-03-16 23:20:17', 1, 'all', 2887188481, 0, 0, 'adssadsadsadsa dffdf erwerwe', 0),
(5, 98363740, 'web', '2025-03-17 10:06:23', 1, 'all', 2887254017, 0, 0, '@admin,4 @admin,2 rtfwertwert', 0),
(6, 10062175, 'web', '2025-03-17 12:12:55', 1, 'all', 2887057409, 0, 0, '@admin,5 hola hhh', 1),
(7, 72533460, 'web', '2025-03-17 21:45:30', 1, 'all', 2887057409, 0, 0, 'Pues eso, la pregunta', 0),
(8, 35411126, 'web', '2025-03-20 09:29:16', 1, 'all', 2887057409, 0, 0, 'Hola!', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prefs`
--

DROP TABLE IF EXISTS `prefs`;
CREATE TABLE `prefs` (
  `pref_user_id` int NOT NULL,
  `pref_key` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `pref_value` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `prefs`
--

INSERT INTO `prefs` (`pref_user_id`, `pref_key`, `pref_value`) VALUES
(1, 'sub_follow', 2),
(1, 'sub_follow', 3),
(6, 'sub_follow', 1),
(7, 'sub_follow', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privates`
--

DROP TABLE IF EXISTS `privates`;
CREATE TABLE `privates` (
  `id` int UNSIGNED NOT NULL,
  `randkey` int NOT NULL DEFAULT '0',
  `user` int UNSIGNED NOT NULL,
  `to` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `report_id` int NOT NULL,
  `report_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `report_type` text,
  `report_reason` text,
  `report_user_id` int NOT NULL,
  `report_ref_id` int NOT NULL,
  `report_status` text,
  `report_modified` timestamp NULL DEFAULT NULL,
  `report_revised_by` int DEFAULT NULL,
  `report_ip` char(42) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rss`
--

DROP TABLE IF EXISTS `rss`;
CREATE TABLE `rss` (
  `blog_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `link_id` int UNSIGNED DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_parsed` timestamp NULL DEFAULT NULL,
  `url` char(250) NOT NULL,
  `title` char(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sneakers`
--

DROP TABLE IF EXISTS `sneakers`;
CREATE TABLE `sneakers` (
  `sneaker_id` char(24) NOT NULL,
  `sneaker_time` int UNSIGNED NOT NULL DEFAULT '0',
  `sneaker_user` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb3 MAX_ROWS=1000;

--
-- Volcado de datos para la tabla `sneakers`
--

INSERT INTO `sneakers` (`sneaker_id`, `sneaker_time`, `sneaker_user`) VALUES
('172.21.0.1-1742401768', 1742462941, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sph_counter`
--

DROP TABLE IF EXISTS `sph_counter`;
CREATE TABLE `sph_counter` (
  `counter_id` int NOT NULL,
  `max_doc_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sponsors`
--

DROP TABLE IF EXISTS `sponsors`;
CREATE TABLE `sponsors` (
  `id` int UNSIGNED NOT NULL,
  `external` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `banner` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `banner_mobile` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `css` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `link` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `strikes`
--

DROP TABLE IF EXISTS `strikes`;
CREATE TABLE `strikes` (
  `strike_id` int NOT NULL,
  `strike_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `strike_type` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `strike_reason` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `strike_user_id` int NOT NULL,
  `strike_report_id` int DEFAULT '0',
  `strike_admin_id` int NOT NULL,
  `strike_karma_old` decimal(4,2) UNSIGNED NOT NULL,
  `strike_karma_new` decimal(4,2) UNSIGNED NOT NULL,
  `strike_karma_restore` decimal(4,2) UNSIGNED NOT NULL,
  `strike_hours` tinyint NOT NULL,
  `strike_expires_at` datetime NOT NULL,
  `strike_comment` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `strike_ip` char(42) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `strike_restored` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subs`
--

DROP TABLE IF EXISTS `subs`;
CREATE TABLE `subs` (
  `id` int NOT NULL,
  `name` char(12) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `parent` smallint UNSIGNED NOT NULL DEFAULT '0',
  `server_name` varchar(32) DEFAULT NULL,
  `base_url` varchar(32) DEFAULT NULL,
  `name_long` char(40) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `sub` tinyint(1) DEFAULT '0',
  `meta` tinyint(1) DEFAULT '0',
  `owner` int NOT NULL DEFAULT '0',
  `nsfw` tinyint(1) DEFAULT '0',
  `created_from` int NOT NULL DEFAULT '0',
  `allow_main_link` tinyint(1) DEFAULT '1',
  `color1` char(7) DEFAULT NULL,
  `color2` char(7) DEFAULT NULL,
  `private` tinyint(1) DEFAULT '0',
  `show_admin` tinyint(1) NOT NULL DEFAULT '0',
  `page_mode` enum('best-comments','threads','interview','answered','standard') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Basic data for every sub site';

--
-- Volcado de datos para la tabla `subs`
--

INSERT INTO `subs` (`id`, `name`, `enabled`, `parent`, `server_name`, `base_url`, `name_long`, `visible`, `sub`, `meta`, `owner`, `nsfw`, `created_from`, `allow_main_link`, `color1`, `color2`, `private`, `show_admin`, `page_mode`) VALUES
(1, 'mnm', 1, 0, '', 'localhost:8001/', 'gogo', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, 0, 1, NULL),
(2, 'dasd', 1, 0, '', 'localhost:8001/', 'saddadsa', 1, 1, 0, 1, 0, 1, 0, '', '', 0, 1, 'standard'),
(3, 'nuevas', 1, 1, '', 'localhost:8001/', 'fsdfsddsffdsfdsfds', 1, 1, 0, 1, 0, 1, 1, '', '', 0, 1, 'standard');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subs_copy`
--

DROP TABLE IF EXISTS `subs_copy`;
CREATE TABLE `subs_copy` (
  `src` int NOT NULL,
  `dst` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `subs_copy`
--

INSERT INTO `subs_copy` (`src`, `dst`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE `sub_categories` (
  `id` smallint UNSIGNED NOT NULL,
  `category` smallint UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `import` tinyint(1) NOT NULL DEFAULT '1',
  `export` tinyint(1) NOT NULL DEFAULT '0',
  `calculated_coef` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Store categories available for each sub site';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_statuses`
--

DROP TABLE IF EXISTS `sub_statuses`;
CREATE TABLE `sub_statuses` (
  `id` smallint UNSIGNED NOT NULL,
  `status` enum('discard','queued','published','abuse','duplicated','autodiscard','metapublished') NOT NULL DEFAULT 'discard',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` smallint UNSIGNED NOT NULL,
  `link` int NOT NULL,
  `origen` smallint UNSIGNED NOT NULL,
  `karma` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Store the status for each link in every sub site';

--
-- Volcado de datos para la tabla `sub_statuses`
--

INSERT INTO `sub_statuses` (`id`, `status`, `date`, `category`, `link`, `origen`, `karma`) VALUES
(1, 'discard', '2025-03-16 01:14:56', 0, 5, 1, 0.00),
(1, 'discard', '2025-03-16 01:15:09', 0, 6, 1, 0.00),
(1, 'discard', '2025-03-16 01:18:19', 0, 7, 1, 0.00),
(1, 'discard', '2025-03-16 01:23:39', 0, 8, 1, 0.00),
(1, 'discard', '2025-03-16 08:00:47', 0, 9, 1, 0.00),
(1, 'discard', '2025-03-16 08:46:30', 0, 10, 1, 0.00),
(1, 'discard', '2025-03-16 22:57:59', 0, 12, 1, 0.00),
(3, 'discard', '2025-03-16 22:57:59', 0, 12, 1, 0.00),
(2, 'queued', '2025-03-17 09:48:06', 0, 13, 2, 0.00),
(1, 'queued', '2025-03-17 10:19:11', 0, 14, 1, 0.00),
(3, 'queued', '2025-03-17 10:19:11', 0, 14, 1, 0.00),
(1, 'discard', '2025-03-17 11:02:00', 0, 17, 1, 0.00),
(3, 'discard', '2025-03-17 11:02:00', 0, 17, 1, 0.00),
(1, 'discard', '2025-03-17 11:03:32', 0, 18, 1, 0.00),
(3, 'discard', '2025-03-17 11:03:32', 0, 18, 1, 0.00),
(1, 'discard', '2025-03-17 11:10:04', 0, 19, 1, 0.00),
(3, 'discard', '2025-03-17 11:10:04', 0, 19, 1, 0.00),
(1, 'queued', '2025-03-17 11:10:40', 0, 20, 1, 0.00),
(3, 'queued', '2025-03-17 11:10:40', 0, 20, 1, 0.00),
(1, 'discard', '2025-03-17 11:18:55', 0, 21, 1, 0.00),
(3, 'discard', '2025-03-17 11:18:55', 0, 21, 1, 0.00),
(1, 'discard', '2025-03-17 11:38:33', 0, 22, 1, 0.00),
(3, 'discard', '2025-03-17 11:38:33', 0, 22, 1, 0.00),
(1, 'discard', '2025-03-17 13:08:19', 0, 23, 1, 0.00),
(3, 'discard', '2025-03-17 13:08:19', 0, 23, 1, 0.00),
(1, 'discard', '2025-03-17 13:18:00', 0, 24, 1, 0.00),
(3, 'discard', '2025-03-17 13:18:00', 0, 24, 1, 0.00),
(2, 'queued', '2025-03-17 13:29:48', 0, 25, 2, 0.00),
(1, 'discard', '2025-03-17 15:01:57', 0, 26, 1, 0.00),
(3, 'discard', '2025-03-17 15:01:57', 0, 26, 1, 0.00),
(1, 'discard', '2025-03-17 15:13:03', 0, 27, 1, 0.00),
(3, 'discard', '2025-03-17 15:13:03', 0, 27, 1, 0.00),
(1, 'published', '2025-03-17 15:15:35', 0, 28, 1, 20.00),
(3, 'queued', '2025-03-17 15:15:35', 0, 28, 1, 0.00),
(1, 'discard', '2025-03-17 22:00:36', 0, 29, 1, 0.00),
(3, 'discard', '2025-03-17 22:00:36', 0, 29, 1, 0.00),
(1, 'discard', '2025-03-18 10:57:22', 0, 31, 1, 0.00),
(3, 'discard', '2025-03-18 10:57:22', 0, 31, 1, 0.00),
(2, 'queued', '2025-03-18 12:43:21', 0, 33, 2, 0.00),
(1, 'discard', '2025-03-18 14:18:40', 0, 34, 1, 0.00),
(3, 'discard', '2025-03-18 14:18:40', 0, 34, 1, 0.00),
(1, 'discard', '2025-03-18 16:39:01', 0, 35, 1, 0.00),
(3, 'discard', '2025-03-18 16:39:01', 0, 35, 1, 0.00),
(1, 'discard', '2025-03-19 08:03:53', 0, 36, 1, 0.00),
(3, 'discard', '2025-03-19 08:03:53', 0, 36, 1, 0.00),
(1, 'published', '2025-03-19 08:04:35', 0, 37, 1, 20.00),
(3, 'queued', '2025-03-19 08:04:35', 0, 37, 1, 0.00),
(1, 'discard', '2025-03-19 15:27:21', 0, 38, 1, 0.00),
(3, 'discard', '2025-03-19 15:27:21', 0, 38, 1, 0.00),
(1, 'discard', '2025-03-19 22:49:00', 0, 39, 1, 0.00),
(3, 'discard', '2025-03-19 22:49:00', 0, 39, 1, 0.00),
(1, 'discard', '2025-03-19 22:49:00', 0, 40, 1, 0.00),
(3, 'discard', '2025-03-19 22:49:00', 0, 40, 1, 0.00),
(1, 'discard', '2025-03-20 09:22:15', 0, 41, 1, 0.00),
(3, 'discard', '2025-03-20 09:22:15', 0, 41, 1, 0.00),
(1, 'discard', '2025-03-20 09:22:16', 0, 42, 1, 0.00),
(3, 'discard', '2025-03-20 09:22:16', 0, 42, 1, 0.00),
(1, 'discard', '2025-03-20 09:28:28', 0, 43, 1, 0.00),
(3, 'discard', '2025-03-20 09:28:28', 0, 43, 1, 0.00),
(1, 'discard', '2025-03-20 09:28:29', 0, 44, 1, 0.00),
(3, 'discard', '2025-03-20 09:28:29', 0, 44, 1, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tag_link_id` int NOT NULL DEFAULT '0',
  `tag_lang` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'es',
  `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag_words` char(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `texts`
--

DROP TABLE IF EXISTS `texts`;
CREATE TABLE `texts` (
  `key` char(32) NOT NULL,
  `id` int UNSIGNED NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trackbacks`
--

DROP TABLE IF EXISTS `trackbacks`;
CREATE TABLE `trackbacks` (
  `trackback_id` int UNSIGNED NOT NULL,
  `trackback_link_id` int NOT NULL DEFAULT '0',
  `trackback_user_id` int NOT NULL DEFAULT '0',
  `trackback_type` enum('in','out') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'in',
  `trackback_status` enum('ok','pendent','error') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'pendent',
  `trackback_date` timestamp NULL DEFAULT NULL,
  `trackback_ip_int` int UNSIGNED NOT NULL DEFAULT '0',
  `trackback_link` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `trackback_url` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `trackback_title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `trackback_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_login` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `user_level` enum('autodisabled','disabled','normal','special','blogger','admin','god') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'normal',
  `user_avatar` int UNSIGNED NOT NULL DEFAULT '0',
  `user_modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_validated_date` timestamp NULL DEFAULT NULL,
  `user_ip` char(42) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_pass` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `user_email` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `user_names` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `user_login_register` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_email_register` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_lang` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `user_comment_pref` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `user_karma` decimal(10,2) DEFAULT '6.00',
  `user_public_info` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_url` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `user_adcode` char(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_adchannel` char(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_phone` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_level`, `user_avatar`, `user_modification`, `user_date`, `user_validated_date`, `user_ip`, `user_pass`, `user_email`, `user_names`, `user_login_register`, `user_email_register`, `user_lang`, `user_comment_pref`, `user_karma`, `user_public_info`, `user_url`, `user_adcode`, `user_adchannel`, `user_phone`) VALUES
(1, 'gogo_adm', 'god', 0, '2025-03-14 12:29:11', '2025-03-14 12:29:11', '2025-03-14 12:29:11', '121.121.121.1', 'sha256:fzfGzA3V75sllxGorDsojoT8j+xVI0oC:109f00cc473694a0f964f9b555c79902e3db7ad50e3b7c3e27246730fafb79d4', 'hello_process@proton.me', 'admin', 'admin', 'hello_process@proton.me', 1, 0, 20.00, 'hola', '', NULL, NULL, NULL),
(2, 'gogogo', 'normal', 0, '2025-03-15 08:16:16', '2025-03-15 08:16:16', NULL, '121.121.121.1', 'sha256:fzfGzA3V75sllxGorDsojoT8j+xVI0oC:109f00cc473694a0f964f9b555c79902e3db7ad50e3b7c3e27246730fafb79d4', 'hello_process@proton.me', 'gogogo', 'gogogo', 'hello_process@proton.me', 1, 0, 6.00, 'test', '', NULL, NULL, NULL),
(3, 'gogo', 'normal', 0, '2025-03-16 22:37:38', '2025-03-16 22:37:38', NULL, '121.121.121.1', 'sha256:jKzat1KSi6brQPPXqURKiHliGErvsEMp:47dc2b868044e443f4f6e13f194df6bd135cffde8cb1750b0840f1e8eba63538', 'hello_process@proton.me', 'gogo', 'gogo', 'hello_process@proton.me', 1, 0, 6.00, NULL, '', NULL, NULL, NULL),
(4, 'gogodasd', 'normal', 0, '2025-03-16 22:37:59', '2025-03-16 22:37:59', NULL, '121.121.121.1', 'sha256:9FxNUSrpZCNDSq3Z3nAQBRQktODMkNXX:db8c63c6285f9267e58eef21ea597b347fae956f0f5bc6b0e60ceeaab69555c2', 'hello_process@proton.me', 'gogodasd', 'gogodasd', 'hello_process@proton.me', 1, 0, 6.00, NULL, '', NULL, NULL, NULL),
(5, 'gogodasdD', 'normal', 0, '2025-03-16 22:39:24', '2025-03-16 22:39:24', NULL, '121.121.121.1', 'sha256:c8R8p2axT4ntmYRaQiOQUB3J+klJvvJB:a8a585fd17742a485b2a86823e77dfa7ff35b3e433817e8f609dab4f7963d6f3', 'hello_process@proton.me', 'gogodasdD', 'gogodasdD', 'hello_process@proton.me', 1, 0, 6.00, NULL, '', NULL, NULL, NULL),
(6, 'gogo_adm2', 'admin', 0, '2025-03-19 10:54:11', '2025-03-19 10:54:11', '2025-03-19 12:00:02', '121.121.121.1', 'sha256:GahyhPIXIwTEbhph0sgsFbvS7HjEgTJR:7b0852833a809d939a423fab7f40566923f4471c4263608a7f95227f3537c631', 'hello_process@proton.me', 'gogo_adm2', 'gogo_adm2', 'hello_process@proton.me', 1, 0, 6.00, NULL, '', NULL, NULL, NULL),
(7, 'gogo_adm3', 'normal', 0, '2025-03-19 11:01:21', '2025-03-19 11:01:21', '2025-03-19 12:37:00', '172.21.0.1', 'sha256:3197ZUqMkLdDVjT1pb1LRnz/isXR4uJf:3eb4ed33867ee0883ee70b7dc23af953b408ff17f9dd18f0a98e7541d5e34364', 'hello_process@proton.me', 'gogo_adm3', 'gogo_adm3', 'hello_process@proton.me', 1, 0, 6.00, NULL, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_similarities`
--

DROP TABLE IF EXISTS `users_similarities`;
CREATE TABLE `users_similarities` (
  `minor` int UNSIGNED NOT NULL,
  `major` int UNSIGNED NOT NULL,
  `value` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `vote_id` int NOT NULL,
  `vote_type` enum('links','comments','posts','polls','users','sites','ads') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'links',
  `vote_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vote_link_id` int NOT NULL DEFAULT '0',
  `vote_user_id` int NOT NULL DEFAULT '0',
  `vote_value` smallint NOT NULL DEFAULT '1',
  `vote_ip_int` decimal(39,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `votes`
--

INSERT INTO `votes` (`vote_id`, `vote_type`, `vote_date`, `vote_link_id`, `vote_user_id`, `vote_value`, `vote_ip_int`) VALUES
(1, 'links', '2025-03-16 09:07:01', 11, 1, 20, 2038003969),
(2, 'posts', '2025-03-16 09:08:16', 1, 1, 20, 2038003969),
(3, 'posts', '2025-03-16 21:59:25', 2, 1, 20, 2887188481),
(4, 'posts', '2025-03-16 22:17:47', 3, 1, 20, 2887188481),
(5, 'posts', '2025-03-16 23:20:17', 4, 1, 20, 2887188481),
(6, 'links', '2025-03-17 09:48:06', 13, 1, 20, 2887254017),
(7, 'posts', '2025-03-17 10:06:23', 5, 1, 20, 2887254017),
(8, 'links', '2025-03-17 10:19:11', 14, 1, 20, 2887254017),
(9, 'links', '2025-03-17 11:10:40', 20, 1, 20, 2887057409),
(10, 'posts', '2025-03-17 12:12:55', 6, 1, 20, 2887057409),
(11, 'links', '2025-03-17 13:29:48', 25, 1, 20, 2887057409),
(12, 'links', '2025-03-17 15:15:35', 28, 1, 20, 2887057409),
(13, 'comments', '2025-03-17 16:06:44', 1, 1, 20, 2887057409),
(14, 'comments', '2025-03-17 16:07:05', 2, 1, 20, 2887057409),
(15, 'posts', '2025-03-17 21:45:30', 7, 1, 20, 2887057409),
(16, 'polls', '2025-03-17 21:45:36', 1, 1, 1, 2887057409),
(17, 'links', '2025-03-18 09:30:28', 30, 1, 20, 2887057409),
(18, 'links', '2025-03-18 12:43:21', 33, 1, 20, 2887057409),
(19, 'links', '2025-03-19 08:04:35', 37, 1, 20, 2887057409),
(20, 'comments', '2025-03-19 17:08:02', 3, 6, 6, 2887057409),
(21, 'comments', '2025-03-19 22:46:23', 4, 1, 20, 2887057409),
(22, 'comments', '2025-03-20 09:21:49', 5, 1, 20, 2887057409),
(23, 'posts', '2025-03-20 09:29:16', 8, 1, 20, 2887057409),
(24, 'comments', '2025-03-20 09:41:18', 6, 1, 20, 2887057409);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votes_summary`
--

DROP TABLE IF EXISTS `votes_summary`;
CREATE TABLE `votes_summary` (
  `votes_year` smallint NOT NULL,
  `votes_month` tinyint NOT NULL,
  `votes_type` char(10) NOT NULL,
  `votes_maxid` int NOT NULL,
  `votes_count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_date` (`log_date`);

--
-- Indices de la tabla `admin_posts`
--
ALTER TABLE `admin_posts`
  ADD KEY `admin_post` (`admin_post_id`,`admin_user_id`);

--
-- Indices de la tabla `admin_sections`
--
ALTER TABLE `admin_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_users_admin_id` (`admin_id`),
  ADD KEY `fk_admin_users_section_id` (`section_id`);

--
-- Indices de la tabla `annotations`
--
ALTER TABLE `annotations`
  ADD PRIMARY KEY (`annotation_key`),
  ADD KEY `annotation_expire` (`annotation_expire`);

--
-- Indices de la tabla `auths`
--
ALTER TABLE `auths`
  ADD UNIQUE KEY `service` (`service`,`uid`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_2` (`service`,`username`);

--
-- Indices de la tabla `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`avatar_id`);

--
-- Indices de la tabla `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `related` (`related_table`,`related_id`),
  ADD KEY `fk_backups_user_id` (`user_id`);

--
-- Indices de la tabla `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`ban_id`),
  ADD UNIQUE KEY `ban_type` (`ban_type`,`ban_text`),
  ADD KEY `expire` (`ban_expire`);

--
-- Indices de la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`),
  ADD UNIQUE KEY `key` (`blog_key`),
  ADD KEY `blog_url` (`blog_url`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category__auto_id`),
  ADD UNIQUE KEY `category_lang` (`category_lang`,`category_id`),
  ADD UNIQUE KEY `id` (`category_id`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD KEY `chat_time` (`chat_time`) USING BTREE;

--
-- Indices de la tabla `clones`
--
ALTER TABLE `clones`
  ADD PRIMARY KEY (`clon_from`,`clon_to`,`clon_ip`),
  ADD KEY `to_date` (`clon_to`,`clon_date`),
  ADD KEY `from_date` (`clon_from`,`clon_date`),
  ADD KEY `clon_date` (`clon_date`),
  ADD KEY `clon_ip` (`clon_ip`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_link_id_2` (`comment_link_id`,`comment_date`),
  ADD KEY `comment_date` (`comment_date`),
  ADD KEY `comment_user_id` (`comment_user_id`,`comment_date`),
  ADD KEY `comment_link_id` (`comment_link_id`,`comment_order`);

--
-- Indices de la tabla `conversations`
--
ALTER TABLE `conversations`
  ADD KEY `conversation_type` (`conversation_type`,`conversation_from`),
  ADD KEY `conversation_time` (`conversation_time`),
  ADD KEY `conversation_type_2` (`conversation_type`,`conversation_to`),
  ADD KEY `conversation_user_to` (`conversation_user_to`,`conversation_type`,`conversation_time`),
  ADD KEY `conversation_type_3` (`conversation_type`,`conversation_user_to`);

--
-- Indices de la tabla `counts`
--
ALTER TABLE `counts`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD UNIQUE KEY `favorite_user_id_2` (`favorite_user_id`,`favorite_type`,`favorite_link_id`),
  ADD KEY `favorite_type` (`favorite_type`,`favorite_link_id`);

--
-- Indices de la tabla `friends`
--
ALTER TABLE `friends`
  ADD UNIQUE KEY `friend_type` (`friend_type`,`friend_from`,`friend_to`),
  ADD KEY `friend_type_3` (`friend_type`,`friend_to`,`friend_date`);

--
-- Indices de la tabla `geo_links`
--
ALTER TABLE `geo_links`
  ADD UNIQUE KEY `geo_id` (`geo_id`);

--
-- Indices de la tabla `geo_users`
--
ALTER TABLE `geo_users`
  ADD UNIQUE KEY `geo_id` (`geo_id`);

--
-- Indices de la tabla `html_images_seen`
--
ALTER TABLE `html_images_seen`
  ADD PRIMARY KEY (`hash`);

--
-- Indices de la tabla `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`language_id`),
  ADD UNIQUE KEY `language_name` (`language_name`);

--
-- Indices de la tabla `league`
--
ALTER TABLE `league`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `league_matches`
--
ALTER TABLE `league_matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `league_id` (`league_id`),
  ADD KEY `league_id_2` (`league_id`,`date`);

--
-- Indices de la tabla `league_teams`
--
ALTER TABLE `league_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `league_terms`
--
ALTER TABLE `league_terms`
  ADD PRIMARY KEY (`user_id`,`vendor`);

--
-- Indices de la tabla `league_votes`
--
ALTER TABLE `league_votes`
  ADD UNIQUE KEY `match_id` (`match_id`,`user_id`),
  ADD KEY `sort_index` (`match_id`,`date`);

--
-- Indices de la tabla `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_url` (`link_url`),
  ADD KEY `link_uri` (`link_uri`),
  ADD KEY `link_blog` (`link_blog`),
  ADD KEY `link_author` (`link_author`,`link_date`),
  ADD KEY `link_date` (`link_date`);

--
-- Indices de la tabla `link_clicks`
--
ALTER TABLE `link_clicks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `link_commons`
--
ALTER TABLE `link_commons`
  ADD UNIQUE KEY `link` (`link`),
  ADD KEY `created` (`created`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_date` (`log_date`),
  ADD KEY `log_type` (`log_type`,`log_ref_id`),
  ADD KEY `log_type_2` (`log_type`,`log_date`);

--
-- Indices de la tabla `log_pos`
--
ALTER TABLE `log_pos`
  ADD PRIMARY KEY (`host`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`type`,`id`,`version`),
  ADD KEY `user` (`user`,`type`,`date`),
  ADD KEY `type` (`type`,`version`,`date`),
  ADD KEY `user_2` (`user`,`date`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`user`,`type`);

--
-- Indices de la tabla `pageloads`
--
ALTER TABLE `pageloads`
  ADD PRIMARY KEY (`date`,`type`);

--
-- Indices de la tabla `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_polls_link_id` (`link_id`),
  ADD KEY `fk_polls_post_id` (`post_id`);

--
-- Indices de la tabla `polls_options`
--
ALTER TABLE `polls_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_polls_options_poll_id` (`poll_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_date` (`post_date`),
  ADD KEY `post_user_id` (`post_user_id`,`post_date`);

--
-- Indices de la tabla `prefs`
--
ALTER TABLE `prefs`
  ADD KEY `pref_user_id` (`pref_user_id`,`pref_key`);

--
-- Indices de la tabla `privates`
--
ALTER TABLE `privates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`,`date`),
  ADD KEY `to_2` (`to`,`read`),
  ADD KEY `to` (`to`,`date`),
  ADD KEY `date` (`date`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `report_date` (`report_date`);

--
-- Indices de la tabla `rss`
--
ALTER TABLE `rss`
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `date` (`date`),
  ADD KEY `blog_id` (`blog_id`,`date`),
  ADD KEY `user_id` (`user_id`,`date`);

--
-- Indices de la tabla `sneakers`
--
ALTER TABLE `sneakers`
  ADD UNIQUE KEY `sneaker_id` (`sneaker_id`);

--
-- Indices de la tabla `sph_counter`
--
ALTER TABLE `sph_counter`
  ADD PRIMARY KEY (`counter_id`);

--
-- Indices de la tabla `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sponsors_link` (`link`),
  ADD KEY `fk_sponsors_admin_id` (`admin_id`);

--
-- Indices de la tabla `strikes`
--
ALTER TABLE `strikes`
  ADD PRIMARY KEY (`strike_id`),
  ADD KEY `strike_date` (`strike_date`);

--
-- Indices de la tabla `subs`
--
ALTER TABLE `subs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `owner` (`owner`);

--
-- Indices de la tabla `subs_copy`
--
ALTER TABLE `subs_copy`
  ADD UNIQUE KEY `uni` (`src`,`dst`),
  ADD KEY `dst_i` (`dst`);

--
-- Indices de la tabla `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD UNIQUE KEY `category_id` (`category`,`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `sub_statuses`
--
ALTER TABLE `sub_statuses`
  ADD UNIQUE KEY `link_id` (`link`,`id`),
  ADD KEY `id_status_category_date` (`id`,`status`,`category`,`date`),
  ADD KEY `id_status_date_category` (`id`,`status`,`date`,`category`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD UNIQUE KEY `tag_link_id` (`tag_link_id`,`tag_lang`,`tag_words`),
  ADD KEY `tag_lang` (`tag_lang`,`tag_date`);

--
-- Indices de la tabla `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`key`,`id`);

--
-- Indices de la tabla `trackbacks`
--
ALTER TABLE `trackbacks`
  ADD PRIMARY KEY (`trackback_id`),
  ADD UNIQUE KEY `trackback_link_id_2` (`trackback_link_id`,`trackback_type`,`trackback_link`),
  ADD KEY `trackback_link_id` (`trackback_link_id`),
  ADD KEY `trackback_url` (`trackback_url`),
  ADD KEY `trackback_date` (`trackback_date`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_login` (`user_login`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `user_karma` (`user_karma`),
  ADD KEY `user_public_info` (`user_public_info`),
  ADD KEY `user_phone` (`user_phone`),
  ADD KEY `user_date` (`user_date`),
  ADD KEY `user_modification` (`user_modification`),
  ADD KEY `user_email_register` (`user_email_register`),
  ADD KEY `user_url` (`user_url`);

--
-- Indices de la tabla `users_similarities`
--
ALTER TABLE `users_similarities`
  ADD UNIQUE KEY `minor` (`minor`,`major`),
  ADD KEY `date` (`date`);

--
-- Indices de la tabla `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD UNIQUE KEY `vote_type` (`vote_type`,`vote_link_id`,`vote_user_id`,`vote_ip_int`),
  ADD KEY `vote_type_4` (`vote_type`,`vote_date`,`vote_user_id`),
  ADD KEY `vote_ip_int` (`vote_ip_int`),
  ADD KEY `vote_type_2` (`vote_type`,`vote_user_id`,`vote_date`);

--
-- Indices de la tabla `votes_summary`
--
ALTER TABLE `votes_summary`
  ADD UNIQUE KEY `votes_year` (`votes_year`,`votes_month`,`votes_type`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `admin_sections`
--
ALTER TABLE `admin_sections`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `backups`
--
ALTER TABLE `backups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `bans`
--
ALTER TABLE `bans`
  MODIFY `ban_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `category__auto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `languages`
--
ALTER TABLE `languages`
  MODIFY `language_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `league`
--
ALTER TABLE `league`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `league_matches`
--
ALTER TABLE `league_matches`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `league_teams`
--
ALTER TABLE `league_teams`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `links`
--
ALTER TABLE `links`
  MODIFY `link_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `polls_options`
--
ALTER TABLE `polls_options`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `privates`
--
ALTER TABLE `privates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `strikes`
--
ALTER TABLE `strikes`
  MODIFY `strike_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subs`
--
ALTER TABLE `subs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `trackbacks`
--
ALTER TABLE `trackbacks`
  MODIFY `trackback_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin_users`
--
ALTER TABLE `admin_users`
  ADD CONSTRAINT `fk_admin_users_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_users_section_id` FOREIGN KEY (`section_id`) REFERENCES `admin_sections` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `backups`
--
ALTER TABLE `backups`
  ADD CONSTRAINT `fk_backups_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `polls`
--
ALTER TABLE `polls`
  ADD CONSTRAINT `fk_polls_link_id` FOREIGN KEY (`link_id`) REFERENCES `links` (`link_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_polls_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `polls_options`
--
ALTER TABLE `polls_options`
  ADD CONSTRAINT `fk_polls_options_poll_id` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sponsors`
--
ALTER TABLE `sponsors`
  ADD CONSTRAINT `fk_sponsors_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sponsors_link` FOREIGN KEY (`link`) REFERENCES `links` (`link_id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `subs_copy`
--
ALTER TABLE `subs_copy`
  ADD CONSTRAINT `subs_copy_ibfk_1` FOREIGN KEY (`src`) REFERENCES `subs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subs_copy_ibfk_2` FOREIGN KEY (`dst`) REFERENCES `subs` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sub_statuses`
--
ALTER TABLE `sub_statuses`
  ADD CONSTRAINT `sub_statuses_ibfk_1` FOREIGN KEY (`link`) REFERENCES `links` (`link_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
