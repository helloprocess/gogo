-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-03-2025 a las 09:37:13
-- Versión del servidor: 9.2.0
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
CREATE TABLE IF NOT EXISTS `admin_logs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_type` text,
  `log_old_value` text,
  `log_new_value` text,
  `log_ref_id` int UNSIGNED NOT NULL,
  `log_user_id` int NOT NULL,
  `log_ip` char(42) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_date` (`log_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_posts`
--

DROP TABLE IF EXISTS `admin_posts`;
CREATE TABLE IF NOT EXISTS `admin_posts` (
  `admin_post_id` int UNSIGNED NOT NULL,
  `admin_user_id` int UNSIGNED NOT NULL,
  `admin_user_login` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  KEY `admin_post` (`admin_post_id`,`admin_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `admin_posts`
--

INSERT INTO `admin_posts` (`admin_post_id`, `admin_user_id`, `admin_user_login`) VALUES
(1, 1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_sections`
--

DROP TABLE IF EXISTS `admin_sections`;
CREATE TABLE IF NOT EXISTS `admin_sections` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

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
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_id` int NOT NULL,
  `section_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_users_admin_id` (`admin_id`),
  KEY `fk_admin_users_section_id` (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `admin_users`
--

INSERT INTO `admin_users` (`id`, `created_at`, `admin_id`, `section_id`) VALUES
(1, '2025-03-14 12:30:06', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `annotations`
--

DROP TABLE IF EXISTS `annotations`;
CREATE TABLE IF NOT EXISTS `annotations` (
  `annotation_key` char(64) NOT NULL,
  `annotation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `annotation_expire` timestamp NULL DEFAULT NULL,
  `annotation_text` text,
  PRIMARY KEY (`annotation_key`),
  KEY `annotation_expire` (`annotation_expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `annotations`
--

INSERT INTO `annotations` (`annotation_key`, `annotation_time`, `annotation_expire`, `annotation_text`) VALUES
('sub_preferences_2', '2025-03-15 23:39:43', NULL, '{\"no_link\":1,\"intro_min_len\":50}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auths`
--

DROP TABLE IF EXISTS `auths`;
CREATE TABLE IF NOT EXISTS `auths` (
  `user_id` int UNSIGNED NOT NULL,
  `service` char(32) NOT NULL,
  `uid` decimal(24,0) UNSIGNED NOT NULL,
  `username` char(32) NOT NULL DEFAULT '''''',
  `token` char(64) NOT NULL DEFAULT '''''',
  `secret` char(64) NOT NULL DEFAULT '''''',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `service` (`service`,`uid`),
  KEY `user_id` (`user_id`),
  KEY `service_2` (`service`,`username`)
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
CREATE TABLE IF NOT EXISTS `avatars` (
  `avatar_id` int NOT NULL,
  `avatar_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `avatar_image` blob NOT NULL,
  PRIMARY KEY (`avatar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backups`
--

DROP TABLE IF EXISTS `backups`;
CREATE TABLE IF NOT EXISTS `backups` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `contents` text COLLATE utf8mb3_spanish_ci,
  `related_table` varchar(255) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `related_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` char(42) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `related` (`related_table`,`related_id`),
  KEY `fk_backups_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `backups`
--

INSERT INTO `backups` (`id`, `contents`, `related_table`, `related_id`, `created_at`, `ip`, `user_id`) VALUES
(1, '{\"id\":\"11\",\"author\":\"1\",\"blog\":\"0\",\"username\":\"admin\",\"randkey\":\"683132\",\"karma\":\"0.00\",\"valid\":false,\"date\":\"1742115752\",\"sent_date\":\"1742115752\",\"published_date\":\"1742115752\",\"modified\":\"1742115752\",\"url\":\"\",\"url_title\":\"\",\"url_description\":\"\",\"encoding\":false,\"status\":\"discard\",\"type\":\"\",\"votes\":\"0\",\"anonymous\":\"0\",\"votes_avg\":\"0\",\"negatives\":\"0\",\"title\":\"\",\"tags\":\"\",\"uri\":\"\",\"thumb_url\":false,\"content\":\"\",\"content_type\":\"article\",\"ip\":\"121.121.121.1\",\"html\":false,\"read\":\"1\",\"voted\":null,\"banned\":false,\"thumb_status\":\"unknown\",\"clicks\":null,\"is_sub\":\"1\",\"sub_id\":\"1\",\"sub_name\":\"mnm\",\"total_votes\":\"0\",\"avatar\":\"0\",\"image\":null,\"best_comments\":[],\"poll\":null,\"nsfw\":\"0\",\"sub_status\":\"discard\",\"sub_status_id\":\"1\",\"sub_date\":\"1742115752\",\"comments\":\"0\",\"sub_karma\":\"0.00\",\"email\":\"hello_process@proton.me\",\"user_karma\":\"20.00\",\"user_level\":\"god\",\"user_adcode\":null,\"user_adchannel\":null,\"server_name\":\"\",\"sub_owner\":\"0\",\"base_url\":\"localhost:8001\\/\",\"created_from\":\"0\",\"allow_main_link\":\"1\",\"sub_status_origen\":\"discard\",\"sub_date_origen\":\"1742115752\",\"sub_color1\":null,\"sub_color2\":null,\"page_mode\":null,\"favorite\":null,\"favorite_readed\":null,\"media_size\":null,\"media_mime\":null,\"media_extension\":null,\"media_access\":null,\"media_date\":null,\"sponsored\":null,\"is_new\":true}', 'links', 11, '2025-03-16 09:07:01', '121.121.121.1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bans`
--

DROP TABLE IF EXISTS `bans`;
CREATE TABLE IF NOT EXISTS `bans` (
  `ban_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ban_type` enum('email','hostname','punished_hostname','ip','words','proxy','noaccess') CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `ban_text` char(64) NOT NULL,
  `ban_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ban_expire` timestamp NULL DEFAULT NULL,
  `ban_comment` char(100) DEFAULT NULL,
  PRIMARY KEY (`ban_id`),
  UNIQUE KEY `ban_type` (`ban_type`,`ban_text`),
  KEY `expire` (`ban_expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `blog_id` int NOT NULL AUTO_INCREMENT,
  `blog_key` char(35) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `blog_type` enum('normal','blog','noiframe','redirector','aggregator') CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL DEFAULT 'normal',
  `blog_rss` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `blog_rss2` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `blog_atom` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `blog_url` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `blog_feed` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `blog_feed_checked` timestamp NULL DEFAULT NULL,
  `blog_feed_read` timestamp NULL DEFAULT NULL,
  `blog_title` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`blog_id`),
  UNIQUE KEY `key` (`blog_key`),
  KEY `blog_url` (`blog_url`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `blogs`
--

INSERT INTO `blogs` (`blog_id`, `blog_key`, `blog_type`, `blog_rss`, `blog_rss2`, `blog_atom`, `blog_url`, `blog_feed`, `blog_feed_checked`, `blog_feed_read`, `blog_title`) VALUES
(1, 'ef4a0fcfb264c2365ff334f66919b385', 'normal', '', '', '', 'https://playground.tensorflow.org', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category__auto_id` int NOT NULL AUTO_INCREMENT,
  `category_lang` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'es',
  `category_id` int NOT NULL DEFAULT '0',
  `category_parent` int NOT NULL DEFAULT '0',
  `category_name` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `category_uri` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `category_calculated_coef` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`category__auto_id`),
  UNIQUE KEY `category_lang` (`category_lang`,`category_id`),
  UNIQUE KEY `id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

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
CREATE TABLE IF NOT EXISTS `chats` (
  `chat_time` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `chat_uid` int UNSIGNED NOT NULL DEFAULT '0',
  `chat_room` enum('all','friends','admin') NOT NULL DEFAULT 'all',
  `chat_user` char(32) NOT NULL,
  `chat_text` char(255) NOT NULL,
  KEY `chat_time` (`chat_time`) USING BTREE
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb3 MAX_ROWS=1000;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clones`
--

DROP TABLE IF EXISTS `clones`;
CREATE TABLE IF NOT EXISTS `clones` (
  `clon_from` int UNSIGNED NOT NULL,
  `clon_to` int UNSIGNED NOT NULL,
  `clon_ip` char(48) NOT NULL DEFAULT '',
  `clon_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`clon_from`,`clon_to`,`clon_ip`),
  KEY `to_date` (`clon_to`,`clon_date`),
  KEY `from_date` (`clon_from`,`clon_date`),
  KEY `clon_date` (`clon_date`),
  KEY `clon_ip` (`clon_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
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
  `comment_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_link_id_2` (`comment_link_id`,`comment_date`),
  KEY `comment_date` (`comment_date`),
  KEY `comment_user_id` (`comment_user_id`,`comment_date`),
  KEY `comment_link_id` (`comment_link_id`,`comment_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `conversation_user_to` int UNSIGNED NOT NULL,
  `conversation_type` enum('comment','post','link') NOT NULL,
  `conversation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `conversation_from` int UNSIGNED NOT NULL,
  `conversation_to` int UNSIGNED NOT NULL,
  KEY `conversation_type` (`conversation_type`,`conversation_from`),
  KEY `conversation_time` (`conversation_time`),
  KEY `conversation_type_2` (`conversation_type`,`conversation_to`),
  KEY `conversation_user_to` (`conversation_user_to`,`conversation_type`,`conversation_time`),
  KEY `conversation_type_3` (`conversation_type`,`conversation_user_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `counts`
--

DROP TABLE IF EXISTS `counts`;
CREATE TABLE IF NOT EXISTS `counts` (
  `key` char(64) NOT NULL,
  `count` int NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `counts`
--

INSERT INTO `counts` (`key`, `count`, `date`) VALUES
('0.published', 0, '2025-03-14 07:37:33'),
('1.published', 0, '2025-03-16 08:00:42'),
('1.queued', 0, '2025-03-16 08:02:07'),
('posts', 0, '2025-03-16 09:07:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `favorite_user_id` int UNSIGNED NOT NULL,
  `favorite_type` enum('link','post','comment') NOT NULL DEFAULT 'link',
  `favorite_link_id` int UNSIGNED NOT NULL,
  `favorite_link_readed` int UNSIGNED NOT NULL DEFAULT '0',
  `favorite_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `favorite_user_id_2` (`favorite_user_id`,`favorite_type`,`favorite_link_id`),
  KEY `favorite_type` (`favorite_type`,`favorite_link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `friend_type` enum('affiliate','manual','hide','affinity') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'affiliate',
  `friend_from` int NOT NULL DEFAULT '0',
  `friend_to` int NOT NULL DEFAULT '0',
  `friend_value` smallint NOT NULL DEFAULT '0',
  `friend_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `friend_type` (`friend_type`,`friend_from`,`friend_to`),
  KEY `friend_type_3` (`friend_type`,`friend_to`,`friend_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geo_links`
--

DROP TABLE IF EXISTS `geo_links`;
CREATE TABLE IF NOT EXISTS `geo_links` (
  `geo_id` int NOT NULL,
  `geo_text` char(80) DEFAULT NULL,
  `geo_pt` point NOT NULL,
  UNIQUE KEY `geo_id` (`geo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geo_users`
--

DROP TABLE IF EXISTS `geo_users`;
CREATE TABLE IF NOT EXISTS `geo_users` (
  `geo_id` int NOT NULL,
  `geo_text` char(80) DEFAULT NULL,
  `geo_pt` point NOT NULL,
  UNIQUE KEY `geo_id` (`geo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_images_seen`
--

DROP TABLE IF EXISTS `html_images_seen`;
CREATE TABLE IF NOT EXISTS `html_images_seen` (
  `hash` char(40) NOT NULL,
  PRIMARY KEY (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `language_id` int NOT NULL AUTO_INCREMENT,
  `language_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`language_id`),
  UNIQUE KEY `language_name` (`language_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league`
--

DROP TABLE IF EXISTS `league`;
CREATE TABLE IF NOT EXISTS `league` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_matches`
--

DROP TABLE IF EXISTS `league_matches`;
CREATE TABLE IF NOT EXISTS `league_matches` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `league_id` int UNSIGNED NOT NULL,
  `local` int UNSIGNED NOT NULL,
  `visitor` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote_starts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `votes_local` int DEFAULT '0',
  `votes_visitor` int DEFAULT '0',
  `votes_tied` int DEFAULT '0',
  `score_local` int DEFAULT NULL,
  `score_visitor` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `league_id` (`league_id`),
  KEY `league_id_2` (`league_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_teams`
--

DROP TABLE IF EXISTS `league_teams`;
CREATE TABLE IF NOT EXISTS `league_teams` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `shortname` char(5) DEFAULT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_terms`
--

DROP TABLE IF EXISTS `league_terms`;
CREATE TABLE IF NOT EXISTS `league_terms` (
  `user_id` int NOT NULL,
  `vendor` enum('nivea') NOT NULL DEFAULT 'nivea',
  PRIMARY KEY (`user_id`,`vendor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `league_votes`
--

DROP TABLE IF EXISTS `league_votes`;
CREATE TABLE IF NOT EXISTS `league_votes` (
  `match_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `value` int UNSIGNED NOT NULL,
  `ip` decimal(39,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `match_id` (`match_id`,`user_id`),
  KEY `sort_index` (`match_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `link_id` int NOT NULL AUTO_INCREMENT,
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
  `link_nsfw` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`link_id`),
  KEY `link_url` (`link_url`),
  KEY `link_uri` (`link_uri`),
  KEY `link_blog` (`link_blog`),
  KEY `link_author` (`link_author`,`link_date`),
  KEY `link_date` (`link_date`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

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
(11, 1, 0, 'private', 683132, 1, 0, 0, 0, 0, 20.00, '2025-03-16 09:07:01', '2025-03-16 09:07:01', '2025-03-16 09:07:01', '2025-03-16 09:02:32', 0, 'es', 2038003969, 0x3132312e3132312e3132312e31, 'article', 'dsfsdsfdfds', '', 'unknown', 0, 0, NULL, '', 'dsfsdsfdfds', '<p>fdsfsdfdsfsfd</p>', 'artículo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_clicks`
--

DROP TABLE IF EXISTS `link_clicks`;
CREATE TABLE IF NOT EXISTS `link_clicks` (
  `id` int UNSIGNED NOT NULL,
  `counter` int UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link_commons`
--

DROP TABLE IF EXISTS `link_commons`;
CREATE TABLE IF NOT EXISTS `link_commons` (
  `link` int UNSIGNED NOT NULL,
  `value` float NOT NULL,
  `n` int NOT NULL DEFAULT '0',
  `date` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `link` (`link`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `log_sub` int DEFAULT '1',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_type` enum('link_new','comment_new','link_publish','link_discard','comment_edit','link_edit','post_new','post_edit','login_failed','spam_warn','link_geo_edit','user_new','user_delete','link_depublished','user_depublished_vote') NOT NULL,
  `log_ref_id` int UNSIGNED NOT NULL,
  `log_user_id` int NOT NULL,
  `log_ip_int` decimal(39,0) NOT NULL,
  `log_ip` char(42) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_date` (`log_date`),
  KEY `log_type` (`log_type`,`log_ref_id`),
  KEY `log_type_2` (`log_type`,`log_date`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

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
(17, 1, '2025-03-16 09:08:16', 'post_new', 1, 1, 2038003969, '121.121.121.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_pos`
--

DROP TABLE IF EXISTS `log_pos`;
CREATE TABLE IF NOT EXISTS `log_pos` (
  `host` varchar(60) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_file` varchar(32) DEFAULT NULL,
  `log_pos` int DEFAULT NULL,
  `master_host` varchar(60) DEFAULT NULL,
  `master_log_file` varchar(32) DEFAULT NULL,
  `master_log_pos` int DEFAULT NULL,
  PRIMARY KEY (`host`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
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
  `dim2` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`type`,`id`,`version`),
  KEY `user` (`user`,`type`,`date`),
  KEY `type` (`type`,`version`,`date`),
  KEY `user_2` (`user`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `user` int UNSIGNED NOT NULL,
  `type` char(12) NOT NULL,
  `counter` int NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pageloads`
--

DROP TABLE IF EXISTS `pageloads`;
CREATE TABLE IF NOT EXISTS `pageloads` (
  `date` date NOT NULL,
  `type` enum('html','ajax','other','rss','image','api','sneaker','bot','geo') NOT NULL DEFAULT 'html',
  `counter` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`date`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `polls`
--

DROP TABLE IF EXISTS `polls`;
CREATE TABLE IF NOT EXISTS `polls` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `duration` smallint NOT NULL DEFAULT '0',
  `votes` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_at` datetime NOT NULL,
  `link_id` int DEFAULT NULL,
  `post_id` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_polls_link_id` (`link_id`),
  KEY `fk_polls_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `polls_options`
--

DROP TABLE IF EXISTS `polls_options`;
CREATE TABLE IF NOT EXISTS `polls_options` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `option` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `votes` smallint UNSIGNED NOT NULL DEFAULT '0',
  `karma` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `poll_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_polls_options_poll_id` (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_randkey` int NOT NULL DEFAULT '0',
  `post_src` enum('web','api','im','mobile','phone') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'web',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_user_id` int UNSIGNED NOT NULL,
  `post_visible` enum('all','friends') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'all',
  `post_ip_int` decimal(39,0) DEFAULT NULL,
  `post_votes` smallint NOT NULL DEFAULT '0',
  `post_karma` smallint NOT NULL DEFAULT '0',
  `post_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `post_is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `post_date` (`post_date`),
  KEY `post_user_id` (`post_user_id`,`post_date`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `post_randkey`, `post_src`, `post_date`, `post_user_id`, `post_visible`, `post_ip_int`, `post_votes`, `post_karma`, `post_content`, `post_is_admin`) VALUES
(1, 58605581, 'web', '2025-03-16 09:08:16', 1, 'all', 2038003969, 0, 0, 'adasd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prefs`
--

DROP TABLE IF EXISTS `prefs`;
CREATE TABLE IF NOT EXISTS `prefs` (
  `pref_user_id` int NOT NULL,
  `pref_key` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `pref_value` int UNSIGNED NOT NULL DEFAULT '0',
  KEY `pref_user_id` (`pref_user_id`,`pref_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privates`
--

DROP TABLE IF EXISTS `privates`;
CREATE TABLE IF NOT EXISTS `privates` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `randkey` int NOT NULL DEFAULT '0',
  `user` int UNSIGNED NOT NULL,
  `to` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`date`),
  KEY `to_2` (`to`,`read`),
  KEY `to` (`to`,`date`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `report_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `report_type` text,
  `report_reason` text,
  `report_user_id` int NOT NULL,
  `report_ref_id` int NOT NULL,
  `report_status` text,
  `report_modified` timestamp NULL DEFAULT NULL,
  `report_revised_by` int DEFAULT NULL,
  `report_ip` char(42) DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `report_date` (`report_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rss`
--

DROP TABLE IF EXISTS `rss`;
CREATE TABLE IF NOT EXISTS `rss` (
  `blog_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `link_id` int UNSIGNED DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_parsed` timestamp NULL DEFAULT NULL,
  `url` char(250) NOT NULL,
  `title` char(250) NOT NULL,
  UNIQUE KEY `url` (`url`),
  KEY `date` (`date`),
  KEY `blog_id` (`blog_id`,`date`),
  KEY `user_id` (`user_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sneakers`
--

DROP TABLE IF EXISTS `sneakers`;
CREATE TABLE IF NOT EXISTS `sneakers` (
  `sneaker_id` char(24) NOT NULL,
  `sneaker_time` int UNSIGNED NOT NULL DEFAULT '0',
  `sneaker_user` int UNSIGNED NOT NULL DEFAULT '0',
  UNIQUE KEY `sneaker_id` (`sneaker_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb3 MAX_ROWS=1000;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sph_counter`
--

DROP TABLE IF EXISTS `sph_counter`;
CREATE TABLE IF NOT EXISTS `sph_counter` (
  `counter_id` int NOT NULL,
  `max_doc_id` int NOT NULL,
  PRIMARY KEY (`counter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sponsors`
--

DROP TABLE IF EXISTS `sponsors`;
CREATE TABLE IF NOT EXISTS `sponsors` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `external` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `banner` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `banner_mobile` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '',
  `css` text COLLATE utf8mb3_spanish_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `link` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sponsors_link` (`link`),
  KEY `fk_sponsors_admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `strikes`
--

DROP TABLE IF EXISTS `strikes`;
CREATE TABLE IF NOT EXISTS `strikes` (
  `strike_id` int NOT NULL AUTO_INCREMENT,
  `strike_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `strike_type` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `strike_reason` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `strike_user_id` int NOT NULL,
  `strike_report_id` int DEFAULT '0',
  `strike_admin_id` int NOT NULL,
  `strike_karma_old` decimal(4,2) UNSIGNED NOT NULL,
  `strike_karma_new` decimal(4,2) UNSIGNED NOT NULL,
  `strike_karma_restore` decimal(4,2) UNSIGNED NOT NULL,
  `strike_hours` tinyint NOT NULL,
  `strike_expires_at` datetime NOT NULL,
  `strike_comment` text COLLATE utf8mb3_spanish_ci,
  `strike_ip` char(42) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `strike_restored` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`strike_id`),
  KEY `strike_date` (`strike_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subs`
--

DROP TABLE IF EXISTS `subs`;
CREATE TABLE IF NOT EXISTS `subs` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `page_mode` enum('best-comments','threads','interview','answered','standard') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COMMENT='Basic data for every sub site';

--
-- Volcado de datos para la tabla `subs`
--

INSERT INTO `subs` (`id`, `name`, `enabled`, `parent`, `server_name`, `base_url`, `name_long`, `visible`, `sub`, `meta`, `owner`, `nsfw`, `created_from`, `allow_main_link`, `color1`, `color2`, `private`, `show_admin`, `page_mode`) VALUES
(1, 'mnm', 1, 0, '', 'localhost:8001/', 'gogo', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, 0, 1, NULL),
(2, 'dasd', 0, 0, '', 'localhost:8001/', 'saddadsa', 1, 1, 0, 1, 0, 1, 0, '', '', 0, 1, 'standard');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subs_copy`
--

DROP TABLE IF EXISTS `subs_copy`;
CREATE TABLE IF NOT EXISTS `subs_copy` (
  `src` int NOT NULL,
  `dst` int NOT NULL,
  UNIQUE KEY `uni` (`src`,`dst`),
  KEY `dst_i` (`dst`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` smallint UNSIGNED NOT NULL,
  `category` smallint UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `import` tinyint(1) NOT NULL DEFAULT '1',
  `export` tinyint(1) NOT NULL DEFAULT '0',
  `calculated_coef` float NOT NULL DEFAULT '0',
  UNIQUE KEY `category_id` (`category`,`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Store categories available for each sub site';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_statuses`
--

DROP TABLE IF EXISTS `sub_statuses`;
CREATE TABLE IF NOT EXISTS `sub_statuses` (
  `id` smallint UNSIGNED NOT NULL,
  `status` enum('discard','queued','published','abuse','duplicated','autodiscard','metapublished') NOT NULL DEFAULT 'discard',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` smallint UNSIGNED NOT NULL,
  `link` int NOT NULL,
  `origen` smallint UNSIGNED NOT NULL,
  `karma` decimal(10,2) NOT NULL DEFAULT '0.00',
  UNIQUE KEY `link_id` (`link`,`id`),
  KEY `id_status_category_date` (`id`,`status`,`category`,`date`),
  KEY `id_status_date_category` (`id`,`status`,`date`,`category`)
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
(1, 'discard', '2025-03-16 08:46:30', 0, 10, 1, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_link_id` int NOT NULL DEFAULT '0',
  `tag_lang` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'es',
  `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag_words` char(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  UNIQUE KEY `tag_link_id` (`tag_link_id`,`tag_lang`,`tag_words`),
  KEY `tag_lang` (`tag_lang`,`tag_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `texts`
--

DROP TABLE IF EXISTS `texts`;
CREATE TABLE IF NOT EXISTS `texts` (
  `key` char(32) NOT NULL,
  `id` int UNSIGNED NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`key`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trackbacks`
--

DROP TABLE IF EXISTS `trackbacks`;
CREATE TABLE IF NOT EXISTS `trackbacks` (
  `trackback_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `trackback_link_id` int NOT NULL DEFAULT '0',
  `trackback_user_id` int NOT NULL DEFAULT '0',
  `trackback_type` enum('in','out') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'in',
  `trackback_status` enum('ok','pendent','error') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'pendent',
  `trackback_date` timestamp NULL DEFAULT NULL,
  `trackback_ip_int` int UNSIGNED NOT NULL DEFAULT '0',
  `trackback_link` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `trackback_url` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `trackback_title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `trackback_content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  PRIMARY KEY (`trackback_id`),
  UNIQUE KEY `trackback_link_id_2` (`trackback_link_id`,`trackback_type`,`trackback_link`),
  KEY `trackback_link_id` (`trackback_link_id`),
  KEY `trackback_url` (`trackback_url`),
  KEY `trackback_date` (`trackback_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_login` char(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `user_level` enum('autodisabled','disabled','normal','special','blogger','admin','god') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'normal',
  `user_avatar` int UNSIGNED NOT NULL DEFAULT '0',
  `user_modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
  `user_url` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `user_adcode` char(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_adchannel` char(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `user_phone` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`),
  KEY `user_email` (`user_email`),
  KEY `user_karma` (`user_karma`),
  KEY `user_public_info` (`user_public_info`),
  KEY `user_phone` (`user_phone`),
  KEY `user_date` (`user_date`),
  KEY `user_modification` (`user_modification`),
  KEY `user_email_register` (`user_email_register`),
  KEY `user_url` (`user_url`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_level`, `user_avatar`, `user_modification`, `user_date`, `user_validated_date`, `user_ip`, `user_pass`, `user_email`, `user_names`, `user_login_register`, `user_email_register`, `user_lang`, `user_comment_pref`, `user_karma`, `user_public_info`, `user_url`, `user_adcode`, `user_adchannel`, `user_phone`) VALUES
(1, 'admin', 'god', 0, '2025-03-14 12:29:11', '2025-03-14 12:29:11', '2025-03-14 12:29:11', '121.121.121.1', 'sha256:fzfGzA3V75sllxGorDsojoT8j+xVI0oC:109f00cc473694a0f964f9b555c79902e3db7ad50e3b7c3e27246730fafb79d4', 'hello_process@proton.me', 'admin', 'admin', 'hello_process@proton.me', 1, 0, 20.00, 'hola', '', NULL, NULL, NULL),
(2, 'gogogo', 'normal', 0, '2025-03-15 08:16:16', '2025-03-15 08:16:16', NULL, '121.121.121.1', 'sha256:fzfGzA3V75sllxGorDsojoT8j+xVI0oC:109f00cc473694a0f964f9b555c79902e3db7ad50e3b7c3e27246730fafb79d4', 'hello_process@proton.me', 'gogogo', 'gogogo', 'hello_process@proton.me', 1, 0, 6.00, 'test', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_similarities`
--

DROP TABLE IF EXISTS `users_similarities`;
CREATE TABLE IF NOT EXISTS `users_similarities` (
  `minor` int UNSIGNED NOT NULL,
  `major` int UNSIGNED NOT NULL,
  `value` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `minor` (`minor`,`major`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `vote_id` int NOT NULL AUTO_INCREMENT,
  `vote_type` enum('links','comments','posts','polls','users','sites','ads') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT 'links',
  `vote_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vote_link_id` int NOT NULL DEFAULT '0',
  `vote_user_id` int NOT NULL DEFAULT '0',
  `vote_value` smallint NOT NULL DEFAULT '1',
  `vote_ip_int` decimal(39,0) NOT NULL,
  PRIMARY KEY (`vote_id`),
  UNIQUE KEY `vote_type` (`vote_type`,`vote_link_id`,`vote_user_id`,`vote_ip_int`),
  KEY `vote_type_4` (`vote_type`,`vote_date`,`vote_user_id`),
  KEY `vote_ip_int` (`vote_ip_int`),
  KEY `vote_type_2` (`vote_type`,`vote_user_id`,`vote_date`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `votes`
--

INSERT INTO `votes` (`vote_id`, `vote_type`, `vote_date`, `vote_link_id`, `vote_user_id`, `vote_value`, `vote_ip_int`) VALUES
(1, 'links', '2025-03-16 09:07:01', 11, 1, 20, 2038003969),
(2, 'posts', '2025-03-16 09:08:16', 1, 1, 20, 2038003969);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votes_summary`
--

DROP TABLE IF EXISTS `votes_summary`;
CREATE TABLE IF NOT EXISTS `votes_summary` (
  `votes_year` smallint NOT NULL,
  `votes_month` tinyint NOT NULL,
  `votes_type` char(10) NOT NULL,
  `votes_maxid` int NOT NULL,
  `votes_count` int NOT NULL,
  UNIQUE KEY `votes_year` (`votes_year`,`votes_month`,`votes_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
