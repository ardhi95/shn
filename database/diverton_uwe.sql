-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 16 Nov 2017 pada 11.27
-- Versi Server: 5.6.38
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diverton_uwe`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `acos`
--

CREATE TABLE `acos` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `acos_type_id` smallint(2) NOT NULL DEFAULT '2',
  `model` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `acos_type_id`, `model`, `controller`, `alias`, `description`, `lft`, `rght`, `status`, `created`, `modified`) VALUES
(1, NULL, 2, NULL, NULL, 'top', '', 1, 40, 1, '2016-11-21 00:00:00', '2016-11-21 00:00:00'),
(2, 1, 2, NULL, 'Dashboards', 'Dashboards', '', 2, 3, 1, '2016-11-21 22:41:45', '2016-11-22 16:50:47'),
(4, 1, 2, NULL, 'Admins', 'Admins', '', 4, 5, 1, '2016-11-21 22:42:07', '2016-11-22 16:51:00'),
(5, 1, 2, NULL, 'CmsMenus', 'CmsMenus', '', 6, 7, 1, '2016-11-21 22:47:10', '2016-11-22 16:57:18'),
(7, 1, 1, NULL, 'ModuleObjects', 'ModuleObjects', '', 8, 9, 1, '2016-11-22 16:27:57', '2016-11-22 16:58:48'),
(9, 1, 2, NULL, 'AdminGroups', 'AdminGroups', '', 10, 11, 1, '2016-11-23 12:26:39', '2016-11-23 12:26:39'),
(10, 1, 2, NULL, 'Sales', 'Sales', '', 22, 23, 1, '2017-09-25 12:11:52', '2017-09-25 12:11:52'),
(11, 1, 2, NULL, 'Stores', 'Stores', '', 24, 25, 1, '2017-09-26 10:52:21', '2017-09-26 10:52:21'),
(12, 1, 2, NULL, 'Schedules', 'Schedules', '', 26, 27, 1, '2017-09-27 14:47:11', '2017-09-27 14:47:11'),
(13, 1, 2, NULL, 'Orders', 'Orders', '', 28, 29, 1, '2017-10-13 15:59:35', '2017-10-13 15:59:35'),
(14, 1, 2, NULL, 'Notifications', 'Notifications', '', 30, 31, 1, '2017-10-19 03:06:49', '2017-10-19 03:06:49'),
(15, 1, 2, NULL, 'Products', 'Products', '', 32, 33, 1, '2017-10-19 13:44:49', '2017-10-19 13:44:49'),
(16, 1, 2, NULL, 'CompetitorProducts', 'CompetitorProducts', '', 34, 35, 1, '2017-10-19 15:00:44', '2017-10-19 15:00:44'),
(17, 1, 2, NULL, 'Cities', 'Cities', '', 36, 37, 1, '2017-11-02 14:20:20', '2017-11-02 14:20:20'),
(18, 1, 2, NULL, 'Targets', 'Targets', '', 38, 39, 1, '2017-11-09 13:10:35', '2017-11-09 13:10:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `acos_types`
--

CREATE TABLE `acos_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `acos_types`
--

INSERT INTO `acos_types` (`id`, `name`) VALUES
(1, 'Superadmin only'),
(2, 'All admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aros`
--

CREATE TABLE `aros` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `total_admin` int(11) NOT NULL DEFAULT '0',
  `status` smallint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `description`, `lft`, `rght`, `total_admin`, `status`, `created`, `modified`) VALUES
(1, NULL, NULL, NULL, 'Developer', '', 1, 12, 0, 1, '2016-11-23 00:00:00', '2016-11-28 05:36:38'),
(3, 2, NULL, NULL, 'Admin Reporting', '', 3, 4, 34, 1, '2016-11-26 20:28:05', '2017-03-11 14:58:38'),
(2, 1, NULL, NULL, 'Super Admin', '', 2, 11, 1, 1, '2016-11-23 20:52:43', '2016-11-28 05:36:16'),
(4, 2, NULL, NULL, 'Sales', '', 7, 8, 19, 1, '2017-09-25 12:08:54', '2017-09-25 12:08:54'),
(7, 2, NULL, NULL, 'Ted', '', 9, 10, 0, 1, '2017-11-09 16:08:48', '2017-11-09 16:08:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aros_acos`
--

CREATE TABLE `aros_acos` (
  `id` int(11) NOT NULL,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(17, 2, 4, '1', '1', '1', '1'),
(15, 2, 2, '1', '1', '1', '1'),
(5, 1, 9, '1', '1', '1', '1'),
(6, 1, 7, '1', '1', '1', '1'),
(7, 1, 5, '1', '1', '1', '1'),
(8, 1, 4, '1', '1', '1', '1'),
(10, 1, 2, '1', '1', '1', '1'),
(18, 2, 5, '1', '1', '1', '1'),
(19, 2, 7, '0', '0', '0', '0'),
(20, 2, 9, '1', '1', '1', '1'),
(38, 3, 9, '0', '0', '0', '0'),
(37, 3, 7, '0', '0', '0', '0'),
(36, 3, 5, '0', '0', '0', '0'),
(35, 3, 4, '0', '0', '0', '0'),
(33, 3, 2, '1', '1', '1', '1'),
(79, 1, 10, '1', '1', '1', '1'),
(78, 4, 9, '0', '0', '0', '0'),
(77, 4, 7, '0', '0', '0', '0'),
(76, 4, 5, '0', '0', '0', '0'),
(75, 4, 4, '0', '0', '0', '0'),
(74, 4, 2, '0', '0', '0', '0'),
(80, 2, 10, '1', '1', '1', '1'),
(81, 1, 11, '1', '1', '1', '1'),
(82, 2, 11, '1', '1', '1', '1'),
(83, 1, 12, '1', '1', '1', '1'),
(84, 2, 12, '1', '1', '1', '1'),
(85, 1, 13, '1', '1', '1', '1'),
(86, 2, 13, '1', '1', '1', '1'),
(87, 1, 14, '1', '1', '1', '1'),
(88, 2, 14, '1', '1', '1', '1'),
(89, 1, 15, '1', '1', '1', '1'),
(90, 2, 15, '1', '1', '1', '1'),
(91, 1, 16, '1', '1', '1', '1'),
(92, 2, 16, '1', '1', '1', '1'),
(93, 1, 17, '1', '1', '1', '1'),
(94, 2, 17, '1', '1', '1', '1'),
(95, 1, 18, '1', '1', '1', '1'),
(96, 2, 18, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin_statuses`
--

CREATE TABLE `checkin_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `checkin_statuses`
--

INSERT INTO `checkin_statuses` (`id`, `name`) VALUES
(1, 'Not checkin yet'),
(2, 'Has Checkin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` smallint(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `cities`
--

INSERT INTO `cities` (`id`, `name`, `created`, `modified`, `status`) VALUES
(1, 'DKI Jakarta', '2017-10-05 16:55:00', '2017-10-05 16:55:00', 1),
(2, 'Depok', '2017-10-05 16:55:00', '2017-10-05 16:55:00', 1),
(3, 'Bekasi', '2017-10-05 16:55:00', '2017-10-05 16:55:00', 1),
(4, 'Bogor', '2017-10-05 16:55:00', '2017-10-05 16:55:00', 1),
(5, 'Tangerang', '2017-10-05 16:55:00', '2017-10-05 16:55:00', 1),
(6, 'Bandung', '2017-11-02 14:25:55', '2017-11-02 14:25:55', 1),
(7, 'Surabaya', '2017-11-02 15:12:45', '2017-11-02 15:12:49', 1),
(8, 'Luwuk', '2017-11-09 15:20:27', '2017-11-09 15:20:27', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cms_menus`
--

CREATE TABLE `cms_menus` (
  `id` int(11) NOT NULL,
  `aco_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon_class` varchar(255) DEFAULT '',
  `is_group_separator` smallint(1) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `cms_menus`
--

INSERT INTO `cms_menus` (`id`, `aco_id`, `parent_id`, `lft`, `rght`, `name`, `icon_class`, `is_group_separator`, `status`, `created`, `modified`) VALUES
(1, NULL, NULL, 1, 46, 'Top Level Menu', '', 0, 1, '2016-11-13 15:58:17', '2016-11-13 15:58:17'),
(2, NULL, 1, 2, 3, 'Menu Utama', '', 1, 1, '2016-11-13 15:58:17', '2017-01-05 09:58:42'),
(3, 2, 1, 4, 5, 'Dashboard', 'fa fa-desktop', 0, 1, '2016-11-13 15:58:17', '2017-09-28 10:46:00'),
(5, NULL, 1, 36, 37, 'Menu Admin', '', 1, 1, '2016-11-13 15:58:17', '2017-01-05 10:00:32'),
(6, 4, 1, 38, 39, 'Daftar Admin', 'fa fa-user', 0, 1, '2016-11-13 15:59:25', '2017-01-05 10:00:48'),
(9, 5, 1, 42, 43, 'Menu CMS', 'fa fa-bars', 0, 1, '2016-11-14 10:15:59', '2017-01-05 10:02:00'),
(26, 7, 1, 44, 45, 'Objek Modul', 'glyphicon glyphicon-wrench', 0, 1, '2016-11-21 20:25:25', '2017-01-05 11:44:14'),
(29, 9, 1, 40, 41, 'Grup Admin', 'fa fa-users', 0, 1, '2016-11-22 17:09:30', '2017-01-05 10:01:44'),
(66, 47, 1, 6, 7, 'Log Book', 'fa fa-book', 0, 1, '2017-07-27 16:32:21', '2017-07-27 16:32:21'),
(68, 49, 1, 8, 9, 'Event Schedule', 'glyphicon glyphicon-calendar', 0, 1, '2017-09-02 18:36:24', '2017-09-03 05:26:13'),
(69, 50, 1, 10, 11, 'Speaker', 'fa fa-user', 0, 1, '2017-09-03 12:38:28', '2017-09-03 12:38:28'),
(70, 51, 1, 14, 15, 'About Comsnets', 'fa fa-info', 0, 1, '2017-09-05 15:15:42', '2017-09-05 15:15:42'),
(71, 10, 1, 12, 13, 'Sales', 'fa fa-user', 0, 1, '2017-09-25 12:12:21', '2017-09-25 12:12:21'),
(72, 11, 1, 16, 17, 'Stores', 'glyphicon glyphicon-home', 0, 1, '2017-09-26 10:56:36', '2017-09-26 10:56:36'),
(73, 12, 1, 18, 19, 'Schedule', 'glyphicon glyphicon-time', 0, 1, '2017-09-27 14:48:09', '2017-09-27 14:48:09'),
(74, 13, 1, 20, 21, 'Order', 'fa fa-shopping-cart', 0, 1, '2017-10-13 16:00:08', '2017-10-13 16:00:08'),
(75, 14, 1, 34, 35, 'Broadcast Message', 'fa fa-bell', 0, 1, '2017-10-19 12:44:42', '2017-10-19 12:44:51'),
(76, NULL, 1, 32, 33, 'Notifications', '', 1, 1, '2017-10-19 12:45:46', '2017-10-19 12:46:19'),
(77, NULL, 1, 26, 27, 'Products', '', 1, 1, '2017-10-19 14:53:38', '2017-10-19 14:53:38'),
(78, 15, 1, 28, 29, 'Company Product', 'fa fa-th-large', 0, 1, '2017-10-19 14:56:29', '2017-10-19 14:56:29'),
(79, 16, 1, 30, 31, 'Rival Product', 'glyphicon glyphicon-list-alt', 0, 1, '2017-10-19 15:01:47', '2017-10-19 15:01:47'),
(80, 17, 1, 22, 23, 'City', 'glyphicon glyphicon-map-marker', 0, 1, '2017-11-02 14:21:08', '2017-11-02 14:21:08'),
(81, 18, 1, 24, 25, 'Company Target', 'fa fa-dollar', 0, 1, '2017-11-09 13:11:19', '2017-11-09 13:11:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cms_menu_translations`
--

CREATE TABLE `cms_menu_translations` (
  `id` int(10) NOT NULL,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `cms_menu_translations`
--

INSERT INTO `cms_menu_translations` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(1, 'idn', 'CmsMenu', 1, 'name', 'Top Level Menu'),
(2, 'eng', 'CmsMenu', 1, 'name', 'Top Level Menu'),
(3, 'idn', 'CmsMenu', 2, 'name', 'Menu Utama'),
(4, 'eng', 'CmsMenu', 2, 'name', 'Main Menu'),
(5, 'idn', 'CmsMenu', 3, 'name', 'Dashboard'),
(6, 'eng', 'CmsMenu', 3, 'name', 'Dashboard'),
(9, 'idn', 'CmsMenu', 5, 'name', 'Menu Admin'),
(10, 'eng', 'CmsMenu', 5, 'name', 'Admin Menu'),
(11, 'idn', 'CmsMenu', 6, 'name', 'Daftar Admin'),
(12, 'eng', 'CmsMenu', 6, 'name', 'List Admin'),
(13, 'idn', 'CmsMenu', 9, 'name', 'Menu CMS'),
(14, 'eng', 'CmsMenu', 9, 'name', 'CMS Menu'),
(15, 'idn', 'CmsMenu', 26, 'name', 'Objek Modul'),
(16, 'eng', 'CmsMenu', 26, 'name', 'Module Object'),
(17, 'idn', 'CmsMenu', 29, 'name', 'Grup Admin'),
(18, 'eng', 'CmsMenu', 29, 'name', 'Admin Groups'),
(63, 'idn', 'CmsMenu', 66, 'name', 'Log Book'),
(64, 'eng', 'CmsMenu', 66, 'name', 'Log Book'),
(68, 'eng', 'CmsMenu', 68, 'name', 'Event Schedule'),
(67, 'idn', 'CmsMenu', 68, 'name', 'Event Timeline'),
(69, 'idn', 'CmsMenu', 69, 'name', 'Speaker'),
(70, 'eng', 'CmsMenu', 69, 'name', 'Speaker'),
(71, 'idn', 'CmsMenu', 70, 'name', 'About Comsnets'),
(72, 'eng', 'CmsMenu', 70, 'name', 'About Comsnets'),
(73, 'idn', 'CmsMenu', 71, 'name', 'Sales'),
(74, 'eng', 'CmsMenu', 71, 'name', 'Sales'),
(75, 'idn', 'CmsMenu', 72, 'name', 'Stores'),
(76, 'eng', 'CmsMenu', 72, 'name', 'Stores'),
(77, 'idn', 'CmsMenu', 73, 'name', 'Schedule'),
(78, 'eng', 'CmsMenu', 73, 'name', 'Schedule'),
(79, 'idn', 'CmsMenu', 74, 'name', 'Order'),
(80, 'eng', 'CmsMenu', 74, 'name', 'Order'),
(81, 'idn', 'CmsMenu', 75, 'name', 'BroadcastMessage'),
(82, 'eng', 'CmsMenu', 75, 'name', 'Broadcast Message'),
(83, 'idn', 'CmsMenu', 76, 'name', 'Notification'),
(84, 'eng', 'CmsMenu', 76, 'name', 'Notifications'),
(85, 'idn', 'CmsMenu', 77, 'name', 'Products'),
(86, 'eng', 'CmsMenu', 77, 'name', 'Products'),
(87, 'idn', 'CmsMenu', 78, 'name', 'Company Product'),
(88, 'eng', 'CmsMenu', 78, 'name', 'Company Product'),
(89, 'idn', 'CmsMenu', 79, 'name', 'Rival Product'),
(90, 'eng', 'CmsMenu', 79, 'name', 'Rival Product'),
(91, 'idn', 'CmsMenu', 80, 'name', 'City'),
(92, 'eng', 'CmsMenu', 80, 'name', 'City'),
(93, 'idn', 'CmsMenu', 81, 'name', 'Company Target'),
(94, 'eng', 'CmsMenu', 81, 'name', 'Company Target');

-- --------------------------------------------------------

--
-- Struktur dari tabel `competitor_products`
--

CREATE TABLE `competitor_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` smallint(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `competitor_products`
--

INSERT INTO `competitor_products` (`id`, `name`, `created`, `modified`, `status`) VALUES
(1, 'CRYSTALINE 240ML', '2017-09-27 00:00:00', '2017-10-20 13:29:27', 1),
(2, 'FLOW 220ML', '2017-09-27 00:00:00', '2017-10-20 13:29:08', 1),
(3, 'AQUA 240ML', '2017-09-27 00:00:00', '2017-10-20 13:28:47', 1),
(5, 'AWESOME 220ML', '2017-10-20 13:35:43', '2017-10-20 13:35:43', 1),
(6, 'UWELINO 240ML', '2017-10-20 13:36:00', '2017-10-20 13:36:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `host` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `contents`
--

INSERT INTO `contents` (`id`, `model`, `model_id`, `type`, `host`, `url`, `mime_type`, `path`, `width`, `height`, `created`, `modified`) VALUES
(2, 'User', 9, 'square', 'http://uwe.divertone.com/', 'contents/User/9/9_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/9/9_square.jpg', 300, 300, '2017-09-25 16:27:51', '2017-09-25 16:27:51'),
(3, 'User', 9, 'maxwidth', 'http://uwe.divertone.com/', 'contents/User/9/9_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/9/9_maxwidth.jpg', 800, 450, '2017-09-25 16:27:52', '2017-09-25 16:27:52'),
(4, 'User', 10, 'square', 'http://uwe.divertone.com/', 'contents/User/10/10_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/10/10_square.jpg', 300, 300, '2017-09-26 04:03:14', '2017-09-26 04:03:14'),
(5, 'User', 10, 'maxwidth', 'http://uwe.divertone.com/', 'contents/User/10/10_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/10/10_maxwidth.jpg', 800, 450, '2017-09-26 04:03:14', '2017-09-26 04:03:14'),
(6, 'Store', 1, 'square', 'http://uwe.divertone.com/', 'contents/Store/1/1_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/1/1_square.jpg', 300, 300, '2017-09-27 12:23:55', '2017-10-09 10:22:40'),
(7, 'Store', 1, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/1/1_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/1/1_maxwidth.jpg', 750, 380, '2017-09-27 12:23:56', '2017-10-09 10:22:41'),
(17, 'Store', 13, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/13/13_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/13/13_maxwidth.jpg', 800, 1422, '2017-10-17 22:32:07', '2017-10-17 22:32:07'),
(16, 'Store', 13, 'square', 'http://uwe.divertone.com/', 'contents/Store/13/13_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/13/13_square.jpg', 300, 300, '2017-10-17 22:32:05', '2017-10-17 22:32:05'),
(15, 'Store', 10, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/10/10_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/10/10_maxwidth.jpg', 410, 310, '2017-10-06 14:09:58', '2017-10-09 10:22:24'),
(14, 'Store', 10, 'square', 'http://uwe.divertone.com/', 'contents/Store/10/10_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/10/10_square.jpg', 300, 300, '2017-10-06 14:09:57', '2017-10-09 10:22:24'),
(18, 'User', 18, 'square', 'http://uwe.divertone.com/', 'contents/User/18/18_square.png', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/18/18_square.png', 300, 300, '2017-10-20 10:27:18', '2017-10-23 15:51:18'),
(19, 'User', 18, 'maxwidth', 'http://uwe.divertone.com/', 'contents/User/18/18_maxwidth.png', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/18/18_maxwidth.png', 750, 750, '2017-10-20 10:27:18', '2017-10-23 15:51:18'),
(20, 'Store', 14, 'square', 'http://uwe.divertone.com/', 'contents/Store/14/14_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/14/14_square.jpg', 300, 300, '2017-10-20 10:33:20', '2017-10-20 10:33:20'),
(21, 'Store', 14, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/14/14_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/14/14_maxwidth.jpg', 524, 385, '2017-10-20 10:33:20', '2017-10-20 10:33:20'),
(22, 'Store', 15, 'square', 'http://uwe.divertone.com/', 'contents/Store/15/15_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/15/15_square.jpg', 300, 300, '2017-10-20 10:59:22', '2017-10-20 10:59:22'),
(23, 'Store', 15, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/15/15_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/15/15_maxwidth.jpg', 800, 1067, '2017-10-20 10:59:23', '2017-10-20 10:59:23'),
(24, 'Store', 16, 'square', 'http://uwe.divertone.com/', 'contents/Store/16/16_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/16/16_square.jpg', 300, 300, '2017-10-20 11:05:27', '2017-10-20 11:05:27'),
(25, 'Store', 16, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/16/16_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/16/16_maxwidth.jpg', 800, 1067, '2017-10-20 11:05:28', '2017-10-20 11:05:28'),
(26, 'User', 20, 'square', 'http://uwe.divertone.com/', 'contents/User/20/20_square.png', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/20/20_square.png', 300, 300, '2017-10-20 15:23:31', '2017-10-23 15:51:06'),
(27, 'User', 20, 'maxwidth', 'http://uwe.divertone.com/', 'contents/User/20/20_maxwidth.png', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/20/20_maxwidth.png', 750, 750, '2017-10-20 15:23:32', '2017-10-23 15:51:06'),
(28, 'Store', 17, 'square', 'http://uwe.divertone.com/', 'contents/Store/17/17_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/17/17_square.jpg', 300, 300, '2017-10-20 16:55:06', '2017-10-20 16:55:06'),
(29, 'Store', 17, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/17/17_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/17/17_maxwidth.jpg', 800, 1067, '2017-10-20 16:55:08', '2017-10-20 16:55:08'),
(30, 'Store', 24, 'square', 'http://uwe.divertone.com/', 'contents/Store/24/24_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/24/24_square.jpg', 300, 300, '2017-10-25 10:28:07', '2017-10-25 10:28:07'),
(31, 'Store', 24, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/24/24_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/24/24_maxwidth.jpg', 800, 450, '2017-10-25 10:28:07', '2017-10-25 10:28:07'),
(32, 'Store', 25, 'square', 'http://uwe.divertone.com/', 'contents/Store/25/25_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/25/25_square.jpg', 300, 300, '2017-10-25 10:45:48', '2017-10-25 10:45:48'),
(33, 'Store', 25, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/25/25_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/25/25_maxwidth.jpg', 800, 1067, '2017-10-25 10:45:49', '2017-10-25 10:45:49'),
(34, 'Store', 27, 'square', 'http://uwe.divertone.com/', 'contents/Store/27/27_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/27/27_square.jpg', 300, 300, '2017-10-25 11:26:33', '2017-10-25 11:26:33'),
(35, 'Store', 27, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/27/27_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/27/27_maxwidth.jpg', 800, 450, '2017-10-25 11:26:34', '2017-10-25 11:26:34'),
(36, 'Store', 28, 'square', 'http://uwe.divertone.com/', 'contents/Store/28/28_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/28/28_square.jpg', 300, 300, '2017-10-25 11:28:26', '2017-10-25 11:28:26'),
(37, 'Store', 28, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/28/28_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/28/28_maxwidth.jpg', 800, 450, '2017-10-25 11:28:27', '2017-10-25 11:28:27'),
(38, 'Store', 34, 'square', 'http://uwe.divertone.com/', 'contents/Store/34/34_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/34/34_square.jpg', 300, 300, '2017-11-01 16:08:39', '2017-11-01 16:08:39'),
(39, 'Store', 34, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/34/34_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/34/34_maxwidth.jpg', 780, 1040, '2017-11-01 16:08:40', '2017-11-01 16:08:40'),
(40, 'Store', 36, 'square', 'http://uwe.divertone.com/', 'contents/Store/36/36_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/36/36_square.jpg', 300, 300, '2017-11-02 15:09:13', '2017-11-02 15:09:13'),
(41, 'Store', 36, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/36/36_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/36/36_maxwidth.jpg', 800, 1067, '2017-11-02 15:09:17', '2017-11-02 15:09:17'),
(42, 'User', 23, 'square', 'http://uwe.divertone.com/', 'contents/User/23/23_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/23/23_square.jpg', 300, 300, '2017-11-09 15:28:46', '2017-11-09 15:28:46'),
(43, 'User', 23, 'maxwidth', 'http://uwe.divertone.com/', 'contents/User/23/23_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/User/23/23_maxwidth.jpg', 537, 744, '2017-11-09 15:28:47', '2017-11-09 15:28:47'),
(44, 'Store', 42, 'square', 'http://uwe.divertone.com/', 'contents/Store/42/42_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/42/42_square.jpg', 300, 300, '2017-11-09 16:06:29', '2017-11-09 16:06:29'),
(45, 'Store', 42, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/42/42_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/42/42_maxwidth.jpg', 800, 450, '2017-11-09 16:06:30', '2017-11-09 16:06:30'),
(46, 'Store', 43, 'square', 'http://uwe.divertone.com/', 'contents/Store/43/43_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/43/43_square.jpg', 300, 300, '2017-11-09 16:08:58', '2017-11-09 16:08:58'),
(47, 'Store', 43, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/43/43_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/43/43_maxwidth.jpg', 800, 1067, '2017-11-09 16:09:00', '2017-11-09 16:09:00'),
(48, 'Store', 44, 'square', 'http://uwe.divertone.com/', 'contents/Store/44/44_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/44/44_square.jpg', 300, 300, '2017-11-09 16:12:59', '2017-11-09 16:12:59'),
(49, 'Store', 44, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/44/44_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/44/44_maxwidth.jpg', 800, 450, '2017-11-09 16:13:00', '2017-11-09 16:13:00'),
(50, 'Store', 45, 'square', 'http://uwe.divertone.com/', 'contents/Store/45/45_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/45/45_square.jpg', 300, 300, '2017-11-13 11:50:57', '2017-11-13 11:50:57'),
(51, 'Store', 45, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/45/45_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/45/45_maxwidth.jpg', 759, 1012, '2017-11-13 11:50:58', '2017-11-13 11:50:58'),
(52, 'Store', 46, 'square', 'http://uwe.divertone.com/', 'contents/Store/46/46_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/46/46_square.jpg', 300, 300, '2017-11-13 11:55:58', '2017-11-13 11:55:58'),
(53, 'Store', 46, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/46/46_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/46/46_maxwidth.jpg', 759, 1012, '2017-11-13 11:55:59', '2017-11-13 11:55:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `to` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `fromtext` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `attachment_mime` varchar(255) DEFAULT NULL,
  `attachment_name` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `email_setting_id` int(11) DEFAULT NULL,
  `counting_sending` smallint(3) NOT NULL DEFAULT '0',
  `last_send` bigint(20) NOT NULL,
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_settings`
--

CREATE TABLE `email_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `from` varchar(255) NOT NULL DEFAULT '',
  `fromtext` varchar(255) NOT NULL DEFAULT '',
  `email_setting` text NOT NULL,
  `description` text NOT NULL,
  `lastUpdated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entryDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` char(1) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `i18n`
--

CREATE TABLE `i18n` (
  `id` int(10) NOT NULL,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `langs`
--

CREATE TABLE `langs` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `langs`
--

INSERT INTO `langs` (`id`, `code`, `name`) VALUES
(1, 'idn', 'Indonesia'),
(2, 'eng', 'English');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `notification_group_id` bigint(20) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `gcm_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `description` text,
  `android_class_name` varchar(255) DEFAULT NULL,
  `params` text COMMENT 'in json',
  `created` datetime NOT NULL,
  `arrival_date` datetime DEFAULT NULL,
  `read_date` datetime DEFAULT NULL,
  `is_arrival` smallint(1) NOT NULL DEFAULT '0',
  `is_readed` smallint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `notification_group_id`, `order_id`, `user_id`, `gcm_id`, `title`, `message`, `description`, `android_class_name`, `params`, `created`, `arrival_date`, `read_date`, `is_arrival`, `is_readed`) VALUES
(1, 1, '1', 14, 'eppYMAX9zw8:APA91bGOi0eOvWuYk3USvfrpyhiYpp9fz73FWBW6EJqGXTaHFXseCqpAdNe8-Tm76cIfyxpr0U4uVyuinWPAJhFJVoIhAs6XxwSAOBH9a561vb8LlwMbTSevA5G_Q3XwfOFbkTgNxuLt', 'NEW SCHEDULE', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>19 October 2017 17:13</b>', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>19 October 2017 17:13</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-19 17:09:07', '2017-10-24 11:19:17', '2017-10-19 17:09:21', 1, 1),
(2, 2, NULL, 14, 'eppYMAX9zw8:APA91bGOi0eOvWuYk3USvfrpyhiYpp9fz73FWBW6EJqGXTaHFXseCqpAdNe8-Tm76cIfyxpr0U4uVyuinWPAJhFJVoIhAs6XxwSAOBH9a561vb8LlwMbTSevA5G_Q3XwfOFbkTgNxuLt', 'PROMO', 'PROMO BUKAN OKTOBER!!', 'Selama bulan OKTOBER 2017, semua produk UWE LINO diskon 50 % Hayooo buruan...', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Selama bulan OKTOBER 2017, semua produk UWE LINO diskon 50 % Hayooo buruan...\"},{\"key\":\"title\",\"val\":\"PROMO\"}]', '2017-10-19 17:11:01', '2017-10-24 11:19:17', '2017-10-19 17:11:35', 1, 1),
(3, 3, NULL, 14, 'eppYMAX9zw8:APA91bGOi0eOvWuYk3USvfrpyhiYpp9fz73FWBW6EJqGXTaHFXseCqpAdNe8-Tm76cIfyxpr0U4uVyuinWPAJhFJVoIhAs6XxwSAOBH9a561vb8LlwMbTSevA5G_Q3XwfOFbkTgNxuLt', 'Target Sales Oktober', 'Pencapain Sales yang tidak sesuai dengan target.', 'Dear team sales,<br />\r\nSaya sangat kecewa dengan pencapaian target bulan oktober 2017. Kalian harus pahami produk yang kalian jual adalah air mineral. Saya tidak mau dengar lagi kalian menjaul air ke toko kimia.&nbsp;<br />\r\n<br />\r\nTerima kasih<br />\r\nKasat Intel Densus 88', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Dear team sales,<br \\/>\\r\\nSaya sangat kecewa dengan pencapaian target bulan oktober 2017. Kalian harus pahami produk yang kalian jual adalah air mineral. Saya tidak mau dengar lagi kalian menjaul air ke toko kimia.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima kasih<br \\/>\\r\\nKasat Intel Densus 88\"},{\"key\":\"title\",\"val\":\"Target Sales Oktober\"}]', '2017-10-20 10:10:50', '2017-10-24 11:19:17', NULL, 1, 0),
(4, 3, NULL, 15, NULL, 'Target Sales Oktober', 'Pencapain Sales yang tidak sesuai dengan target.', 'Dear team sales,<br />\r\nSaya sangat kecewa dengan pencapaian target bulan oktober 2017. Kalian harus pahami produk yang kalian jual adalah air mineral. Saya tidak mau dengar lagi kalian menjaul air ke toko kimia.&nbsp;<br />\r\n<br />\r\nTerima kasih<br />\r\nKasat Intel Densus 88', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Dear team sales,<br \\/>\\r\\nSaya sangat kecewa dengan pencapaian target bulan oktober 2017. Kalian harus pahami produk yang kalian jual adalah air mineral. Saya tidak mau dengar lagi kalian menjaul air ke toko kimia.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima kasih<br \\/>\\r\\nKasat Intel Densus 88\"},{\"key\":\"title\",\"val\":\"Target Sales Oktober\"}]', '2017-10-20 10:10:50', NULL, NULL, 0, 0),
(5, 3, NULL, 18, NULL, 'Target Sales Oktober', 'Pencapain Sales yang tidak sesuai dengan target.', 'Dear team sales,<br />\r\nSaya sangat kecewa dengan pencapaian target bulan oktober 2017. Kalian harus pahami produk yang kalian jual adalah air mineral. Saya tidak mau dengar lagi kalian menjaul air ke toko kimia.&nbsp;<br />\r\n<br />\r\nTerima kasih<br />\r\nKasat Intel Densus 88', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Dear team sales,<br \\/>\\r\\nSaya sangat kecewa dengan pencapaian target bulan oktober 2017. Kalian harus pahami produk yang kalian jual adalah air mineral. Saya tidak mau dengar lagi kalian menjaul air ke toko kimia.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima kasih<br \\/>\\r\\nKasat Intel Densus 88\"},{\"key\":\"title\",\"val\":\"Target Sales Oktober\"}]', '2017-10-20 10:10:50', '2017-11-10 11:28:23', '2017-10-20 10:27:37', 1, 1),
(6, 4, '2', 18, 'fTC-rIaFS78:APA91bHXOR2XLRbKMELtieA7JbBOBJkk9lx-vJQoENdUBh7k_U-bBW0tdKOzKI8HABgGSmajCb7v0otLCsfSfQ9MqLBRfoV2c19TzbAvloC6HSlRXT_7iS_YOsh1_46JmOwdiaoYypTr', 'NEW SCHEDULE', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 10:40</b>', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 10:40</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-20 10:34:28', '2017-11-10 11:28:23', '2017-10-20 10:46:06', 1, 1),
(7, 5, '5', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>TOKO BABE</b><br/>Date : <b>20 October 2017 14:10</b>', 'Store : <b>TOKO BABE</b><br/>Date : <b>20 October 2017 14:10</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-20 13:25:20', '2017-11-14 19:35:58', '2017-10-25 12:14:14', 1, 1),
(8, 6, NULL, 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'KERJA WOI', 'KERJA KERJA ', 'KERJAAAAAA', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"KERJAAAAAA\"},{\"key\":\"title\",\"val\":\"KERJA WOI\"}]', '2017-10-20 13:30:09', '2017-11-14 19:35:58', '2017-10-20 16:16:57', 1, 1),
(9, 7, '6', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>20 October 2017 14:00</b>', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>20 October 2017 14:00</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-20 13:32:20', '2017-11-14 19:35:58', '2017-10-20 16:16:53', 1, 1),
(10, 8, '7', 20, 'fcjcSdfGbRE:APA91bF7tWn24mCuoPo-0PDDCWyxEhJXaTd8N09pOrqRzFl0dVVRNvMWLBck6MHfov8prfV9NPQZzEddSQFUGi91IM-xk7y5borI1srUBYq6dU3umimdGTA6Jsek6gXyUXAQU_KvXy4F', 'NEW SCHEDULE', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>20 October 2017 14:05</b>', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>20 October 2017 14:05</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-20 14:06:56', '2017-11-09 16:03:41', '2017-10-20 14:24:00', 1, 1),
(11, 9, '8', 20, 'fcjcSdfGbRE:APA91bF7tWn24mCuoPo-0PDDCWyxEhJXaTd8N09pOrqRzFl0dVVRNvMWLBck6MHfov8prfV9NPQZzEddSQFUGi91IM-xk7y5borI1srUBYq6dU3umimdGTA6Jsek6gXyUXAQU_KvXy4F', 'NEW SCHEDULE', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 15:33</b>', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 15:33</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-20 15:33:31', '2017-11-09 16:03:41', '2017-10-25 10:33:24', 1, 1),
(12, 10, '12', 18, 'fTC-rIaFS78:APA91bHXOR2XLRbKMELtieA7JbBOBJkk9lx-vJQoENdUBh7k_U-bBW0tdKOzKI8HABgGSmajCb7v0otLCsfSfQ9MqLBRfoV2c19TzbAvloC6HSlRXT_7iS_YOsh1_46JmOwdiaoYypTr', 'NEW SCHEDULE', 'Store : <b>TOKO BABE</b><br/>Date : <b>24 October 2017 10:05</b>', 'Store : <b>TOKO BABE</b><br/>Date : <b>24 October 2017 10:05</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-24 09:56:36', '2017-11-10 11:28:23', '2017-10-24 10:09:11', 1, 1),
(13, 11, '14', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>25 October 2017 14:10</b>', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>25 October 2017 14:10</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-24 13:59:31', '2017-11-14 19:35:58', '2017-10-24 13:59:53', 1, 1),
(14, 12, '15', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>Toko Roti</b><br/>Date : <b>24 October 2017 14:04</b>', 'Store : <b>Toko Roti</b><br/>Date : <b>24 October 2017 14:04</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-24 14:00:11', '2017-11-14 19:35:58', '2017-10-25 12:14:18', 1, 1),
(15, 13, '16', 20, 'fcjcSdfGbRE:APA91bF7tWn24mCuoPo-0PDDCWyxEhJXaTd8N09pOrqRzFl0dVVRNvMWLBck6MHfov8prfV9NPQZzEddSQFUGi91IM-xk7y5borI1srUBYq6dU3umimdGTA6Jsek6gXyUXAQU_KvXy4F', 'NEW SCHEDULE', 'Store : <b>Toko ID Marco</b><br/>Date : <b>24 October 2017 14:41</b>', 'Store : <b>Toko ID Marco</b><br/>Date : <b>24 October 2017 14:41</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-24 14:36:35', '2017-11-09 16:03:41', '2017-10-25 10:33:18', 1, 1),
(16, 14, NULL, 13, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(17, 14, NULL, 12, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(18, 14, NULL, 15, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(19, 14, NULL, 11, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(20, 14, NULL, 9, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(21, 14, NULL, 10, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(22, 14, NULL, 14, 'e72_LeMbu64:APA91bGiJkWAORn1diGpH1tGW9Qs1_tA-1RNyOxt9yXdqd3X9Y8Nl6Xl4wn-kWu3jybPhPFq2eYTqNIczio94eSqNI0BFkpkc6ctGM1NDt8mzPsjR37NyOEQSr6Nb1b505ER97Xo0qUh', 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(23, 14, NULL, 16, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(24, 14, NULL, 17, NULL, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', NULL, NULL, 0, 0),
(25, 14, NULL, 18, 'fTC-rIaFS78:APA91bHXOR2XLRbKMELtieA7JbBOBJkk9lx-vJQoENdUBh7k_U-bBW0tdKOzKI8HABgGSmajCb7v0otLCsfSfQ9MqLBRfoV2c19TzbAvloC6HSlRXT_7iS_YOsh1_46JmOwdiaoYypTr', 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', '2017-11-10 11:28:23', NULL, 1, 0),
(26, 14, NULL, 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', '2017-11-14 19:35:58', '2017-10-25 10:21:13', 1, 1),
(27, 14, NULL, 20, 'fcjcSdfGbRE:APA91bF7tWn24mCuoPo-0PDDCWyxEhJXaTd8N09pOrqRzFl0dVVRNvMWLBck6MHfov8prfV9NPQZzEddSQFUGi91IM-xk7y5borI1srUBYq6dU3umimdGTA6Jsek6gXyUXAQU_KvXy4F', 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Cuma ngetest aja\"},{\"key\":\"title\",\"val\":\"Salam Kenal - Admin Baru Nge test\"}]', '2017-10-25 10:16:52', '2017-11-09 16:03:41', '2017-10-25 10:33:11', 1, 1),
(28, 15, '18', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>25 October 2017 10:22</b>', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>25 October 2017 10:22</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-25 10:22:23', '2017-11-14 19:35:58', '2017-10-25 13:27:47', 1, 1),
(29, 16, '20', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>Toko Kawe</b><br/>Date : <b>25 October 2017 10:25</b>', 'Store : <b>Toko Kawe</b><br/>Date : <b>25 October 2017 10:25</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-25 10:25:52', '2017-11-14 19:35:58', '2017-10-25 12:14:24', 1, 1),
(30, 17, '22', 20, 'fcjcSdfGbRE:APA91bF7tWn24mCuoPo-0PDDCWyxEhJXaTd8N09pOrqRzFl0dVVRNvMWLBck6MHfov8prfV9NPQZzEddSQFUGi91IM-xk7y5borI1srUBYq6dU3umimdGTA6Jsek6gXyUXAQU_KvXy4F', 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:25</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:25</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-25 10:29:39', '2017-11-09 16:03:41', '2017-10-25 10:31:32', 1, 1),
(31, 18, '23', 18, 'fgQ0BoKPPxU:APA91bEH3BBKO5UV79f_wGaD00tbNXQMoIuGayp_-y0hTHf7cGPMqfcVAVD0JewLkfOe_6lyCRE3eLG7jg3D6L_2aVx1m52WiZjw0VfgCgFIqJ1aZK_vATjmF9G65g7WGiAoZkyWTQ7w', 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:35</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:35</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-25 10:32:00', '2017-11-10 11:28:23', NULL, 1, 0),
(32, 19, '29', 14, 'e72_LeMbu64:APA91bGiJkWAORn1diGpH1tGW9Qs1_tA-1RNyOxt9yXdqd3X9Y8Nl6Xl4wn-kWu3jybPhPFq2eYTqNIczio94eSqNI0BFkpkc6ctGM1NDt8mzPsjR37NyOEQSr6Nb1b505ER97Xo0qUh', 'NEW SCHEDULE', 'Store : <b>Forisa</b><br/>Date : <b>26 October 2017 12:04</b>', 'Store : <b>Forisa</b><br/>Date : <b>26 October 2017 12:04</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-26 12:04:39', NULL, NULL, 0, 0),
(33, 20, '30', 18, 'fgQ0BoKPPxU:APA91bEH3BBKO5UV79f_wGaD00tbNXQMoIuGayp_-y0hTHf7cGPMqfcVAVD0JewLkfOe_6lyCRE3eLG7jg3D6L_2aVx1m52WiZjw0VfgCgFIqJ1aZK_vATjmF9G65g7WGiAoZkyWTQ7w', 'NEW SCHEDULE', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>30 October 2017 09:50</b>', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>30 October 2017 09:50</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-30 09:48:24', '2017-11-10 11:28:23', NULL, 1, 0),
(34, 21, '31', 18, 'fgQ0BoKPPxU:APA91bEH3BBKO5UV79f_wGaD00tbNXQMoIuGayp_-y0hTHf7cGPMqfcVAVD0JewLkfOe_6lyCRE3eLG7jg3D6L_2aVx1m52WiZjw0VfgCgFIqJ1aZK_vATjmF9G65g7WGiAoZkyWTQ7w', 'NEW SCHEDULE', 'Store : <b>citayam</b><br/>Date : <b>31 October 2017 08:30</b>', 'Store : <b>citayam</b><br/>Date : <b>31 October 2017 08:30</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-10-30 16:25:34', '2017-11-10 11:28:23', NULL, 1, 0),
(35, 22, '32', 20, 'f984oG8Qc54:APA91bF2CM0K2pxGGrS91PXdbvsgII633nuXUiC1qFl-4MhfIUDe0vV362EGblCZxAkDrYR28_PNPZLk0r6CTiZVi4wyfvZZ09FkILiAwYyMBuuOr4xzMJ0_HhN9ezBzYUXXDc0M0gEt', 'NEW SCHEDULE', 'Store : <b>Fitshop</b><br/>Date : <b>01 November 2017 15:46</b>', 'Store : <b>Fitshop</b><br/>Date : <b>01 November 2017 15:46</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-01 15:42:10', '2017-11-09 16:03:41', '2017-11-08 08:50:04', 1, 1),
(36, 23, '35', 18, 'fgQ0BoKPPxU:APA91bEH3BBKO5UV79f_wGaD00tbNXQMoIuGayp_-y0hTHf7cGPMqfcVAVD0JewLkfOe_6lyCRE3eLG7jg3D6L_2aVx1m52WiZjw0VfgCgFIqJ1aZK_vATjmF9G65g7WGiAoZkyWTQ7w', 'NEW SCHEDULE', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-02 15:06:12', '2017-11-10 11:28:23', '2017-11-09 15:46:17', 1, 1),
(37, 24, '36', 18, 'fgQ0BoKPPxU:APA91bEH3BBKO5UV79f_wGaD00tbNXQMoIuGayp_-y0hTHf7cGPMqfcVAVD0JewLkfOe_6lyCRE3eLG7jg3D6L_2aVx1m52WiZjw0VfgCgFIqJ1aZK_vATjmF9G65g7WGiAoZkyWTQ7w', 'NEW SCHEDULE', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-02 15:06:38', '2017-11-10 11:28:23', '2017-11-02 15:21:59', 1, 1),
(38, 25, '39', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-03 07:15:39', '2017-11-14 19:35:58', NULL, 1, 0),
(39, 26, '40', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-03 07:16:05', '2017-11-14 19:35:58', NULL, 1, 0),
(40, 27, '41', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-03 07:16:05', '2017-11-14 19:35:58', NULL, 1, 0),
(41, 28, '42', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 07:25</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 07:25</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-03 07:16:22', '2017-11-14 19:35:58', '2017-11-06 21:26:04', 1, 1),
(42, 29, '44', 18, 'fgQ0BoKPPxU:APA91bEH3BBKO5UV79f_wGaD00tbNXQMoIuGayp_-y0hTHf7cGPMqfcVAVD0JewLkfOe_6lyCRE3eLG7jg3D6L_2aVx1m52WiZjw0VfgCgFIqJ1aZK_vATjmF9G65g7WGiAoZkyWTQ7w', 'NEW SCHEDULE', 'Store : <b>Msolving</b><br/>Date : <b>06 November 2017 19:20</b>', 'Store : <b>Msolving</b><br/>Date : <b>06 November 2017 19:20</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-06 19:21:30', '2017-11-10 11:28:23', '2017-11-09 15:41:34', 1, 1),
(43, 30, '45', 19, 'flc7wfNs8l8:APA91bF7plL_oxHORjc7PZbu4Vv1Pah5lm9S0k0pdFovCvQbJnYdQNjIxs7zmRNYXLBhczW4DpxP0C5V6nhxdY3H9aWh7cON0ZzuzfSm-4fjoyvOr0AF28WmsN-t2w9kw1O9ooZP4_Iw', 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>06 November 2017 21:25</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>06 November 2017 21:25</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-06 21:29:33', '2017-11-14 19:35:58', NULL, 1, 0),
(44, 31, '46', 20, NULL, 'NEW SCHEDULE', 'Store : <b>Mac Arena</b><br/>Date : <b>08 November 2017 08:52</b>', 'Store : <b>Mac Arena</b><br/>Date : <b>08 November 2017 08:52</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-08 08:53:00', '2017-11-09 16:03:41', '2017-11-08 11:01:49', 1, 1),
(45, 32, '50', 18, 'dH_sFs0sMjk:APA91bEA2f53LSIs3LIp0AJc_LNVVJj-CCdIenuzEjFt-q4A0HAp_92rbxRlCS0zRRmc4IiOznchnlN38D0bFm1XCoW5Nd8JKXaTrv7occnwR8y_O-UzgkIZ3-HAEGnBTdOptRuedrWH', 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 15:30</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 15:30</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-09 15:29:37', '2017-11-10 11:28:23', '2017-11-09 15:33:45', 1, 1),
(46, 33, '52', 23, 'fQ74JhfqLdU:APA91bG9wVqkdC1bU32xugRjSogkQBsAU7jkuKUv239y-rpwzV769mpSLnrEyLx22AE67zkATGXtpWSniaD5Y_L8XFfZkd1ucVcJtGrWRdglC7TEGgSVLjX0p_yIf8H1F_ALbLkiRXQZ', 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-09 15:32:31', '2017-11-13 11:55:01', NULL, 1, 0),
(47, 34, '53', 23, 'fQ74JhfqLdU:APA91bG9wVqkdC1bU32xugRjSogkQBsAU7jkuKUv239y-rpwzV769mpSLnrEyLx22AE67zkATGXtpWSniaD5Y_L8XFfZkd1ucVcJtGrWRdglC7TEGgSVLjX0p_yIf8H1F_ALbLkiRXQZ', 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 'DashboardActivity', '[{\"key\":\"id\",\"val\":\"1\"}]', '2017-11-09 15:32:56', '2017-11-13 11:55:01', NULL, 1, 0),
(48, 35, NULL, 13, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(49, 35, NULL, 12, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(50, 35, NULL, 15, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(51, 35, NULL, 11, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(52, 35, NULL, 9, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(53, 35, NULL, 10, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(54, 35, NULL, 14, 'cEbG6ZIoRp8:APA91bGnDtbcXLdhT8YqYtCgWLYMXdWtkU9n-akIZks9TGtZvFo-PJhxPbabn7pbL6MyXOLwa0O4Ce9Sz7AGuwmcFjION44fWk4GZarKZfYQnAe_9IwVHGKwaHxCU5WS4N5MqSSWi2t6', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(55, 35, NULL, 16, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(56, 35, NULL, 17, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(57, 35, NULL, 18, 'dH_sFs0sMjk:APA91bEA2f53LSIs3LIp0AJc_LNVVJj-CCdIenuzEjFt-q4A0HAp_92rbxRlCS0zRRmc4IiOznchnlN38D0bFm1XCoW5Nd8JKXaTrv7occnwR8y_O-UzgkIZ3-HAEGnBTdOptRuedrWH', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', '2017-11-10 11:28:23', '2017-11-10 11:28:38', 1, 1),
(58, 35, NULL, 19, 'fVVUIze2a0k:APA91bEpIG1Xx4ivnZslMl3ABIDj6h__4wNHZoiNeQtUSTkL2AZ9W9m5_ZHWDEPywhEHheymOBsuMjFy9cK4L5uYTlTCLsAxUHzq6cCOsngvIgAta0KkRV8OOdc0CpLrT7hOgHTyY87w', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', '2017-11-14 19:35:58', NULL, 1, 0),
(59, 35, NULL, 20, 'cs_I1xFWQFo:APA91bGeEoz-3xKK_6geNQpV--bga0N4RqTLRM0Lvjr8wV1kAZYpHmI0ZtuGbc-xk4-maKT_cuKqHXMGve-KF7zXSKLjT6GUDj3PM3cp_WdX8P3wwacAQ2pviMCmXOHNSu34eN93L-vk', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', '2017-11-09 16:03:41', NULL, 1, 0),
(60, 35, NULL, 21, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', NULL, NULL, 0, 0),
(61, 35, NULL, 22, 'fdkNw_nlnt8:APA91bFppy1iG69O5AhDP6V_N_4WIqLE_dpZhhK-fGfkp8_jEe3FAHKWepWdymjCxsAVGx_MKV9UD1WqQjdF_t7KENaxe3dk38iS1DD-Tr-z1ZfOuu-Hei8hXM3QO5CBHF33HeprJpur', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', '2017-11-10 13:30:17', NULL, 1, 0),
(62, 35, NULL, 23, 'fQ74JhfqLdU:APA91bG9wVqkdC1bU32xugRjSogkQBsAU7jkuKUv239y-rpwzV769mpSLnrEyLx22AE67zkATGXtpWSniaD5Y_L8XFfZkd1ucVcJtGrWRdglC7TEGgSVLjX0p_yIf8H1F_ALbLkiRXQZ', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:52:50', '2017-11-13 11:55:01', NULL, 1, 0),
(63, 36, NULL, 13, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(64, 36, NULL, 12, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(65, 36, NULL, 15, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(66, 36, NULL, 11, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(67, 36, NULL, 9, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(68, 36, NULL, 10, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(69, 36, NULL, 14, 'cEbG6ZIoRp8:APA91bGnDtbcXLdhT8YqYtCgWLYMXdWtkU9n-akIZks9TGtZvFo-PJhxPbabn7pbL6MyXOLwa0O4Ce9Sz7AGuwmcFjION44fWk4GZarKZfYQnAe_9IwVHGKwaHxCU5WS4N5MqSSWi2t6', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(70, 36, NULL, 16, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(71, 36, NULL, 17, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(72, 36, NULL, 18, 'dH_sFs0sMjk:APA91bEA2f53LSIs3LIp0AJc_LNVVJj-CCdIenuzEjFt-q4A0HAp_92rbxRlCS0zRRmc4IiOznchnlN38D0bFm1XCoW5Nd8JKXaTrv7occnwR8y_O-UzgkIZ3-HAEGnBTdOptRuedrWH', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', '2017-11-10 11:28:23', '2017-11-09 16:04:31', 1, 1),
(73, 36, NULL, 19, 'fVVUIze2a0k:APA91bEpIG1Xx4ivnZslMl3ABIDj6h__4wNHZoiNeQtUSTkL2AZ9W9m5_ZHWDEPywhEHheymOBsuMjFy9cK4L5uYTlTCLsAxUHzq6cCOsngvIgAta0KkRV8OOdc0CpLrT7hOgHTyY87w', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', '2017-11-14 19:35:58', NULL, 1, 0),
(74, 36, NULL, 20, 'cs_I1xFWQFo:APA91bGeEoz-3xKK_6geNQpV--bga0N4RqTLRM0Lvjr8wV1kAZYpHmI0ZtuGbc-xk4-maKT_cuKqHXMGve-KF7zXSKLjT6GUDj3PM3cp_WdX8P3wwacAQ2pviMCmXOHNSu34eN93L-vk', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', '2017-11-09 16:03:41', '2017-11-09 16:05:45', 1, 1);
INSERT INTO `notifications` (`id`, `notification_group_id`, `order_id`, `user_id`, `gcm_id`, `title`, `message`, `description`, `android_class_name`, `params`, `created`, `arrival_date`, `read_date`, `is_arrival`, `is_readed`) VALUES
(75, 36, NULL, 21, NULL, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', NULL, NULL, 0, 0),
(76, 36, NULL, 22, 'fdkNw_nlnt8:APA91bFppy1iG69O5AhDP6V_N_4WIqLE_dpZhhK-fGfkp8_jEe3FAHKWepWdymjCxsAVGx_MKV9UD1WqQjdF_t7KENaxe3dk38iS1DD-Tr-z1ZfOuu-Hei8hXM3QO5CBHF33HeprJpur', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', '2017-11-10 13:30:17', NULL, 1, 0),
(77, 36, NULL, 23, 'fQ74JhfqLdU:APA91bG9wVqkdC1bU32xugRjSogkQBsAU7jkuKUv239y-rpwzV769mpSLnrEyLx22AE67zkATGXtpWSniaD5Y_L8XFfZkd1ucVcJtGrWRdglC7TEGgSVLjX0p_yIf8H1F_ALbLkiRXQZ', 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Hello all,<br \\/>\\r\\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br \\/>\\r\\n<br \\/>\\r\\nTerima Kasih<br \\/>\\r\\nImam MB<br \\/>\\r\\nCo-founder of&nbsp;<a href=\\\"http:\\/\\/zavalite.mlabs.id\\\" target=\\\"_blank\\\">Zavalite<\\/a>\"},{\"key\":\"title\",\"val\":\"User Acceptance Test\"}]', '2017-11-09 15:55:01', '2017-11-13 11:55:01', NULL, 1, 0),
(78, 37, NULL, 18, 'dH_sFs0sMjk:APA91bEA2f53LSIs3LIp0AJc_LNVVJj-CCdIenuzEjFt-q4A0HAp_92rbxRlCS0zRRmc4IiOznchnlN38D0bFm1XCoW5Nd8JKXaTrv7occnwR8y_O-UzgkIZ3-HAEGnBTdOptRuedrWH', 'Test', 'Test', 'Coba', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Coba\"},{\"key\":\"title\",\"val\":\"Test\"}]', '2017-11-09 16:02:17', '2017-11-10 11:28:23', '2017-11-09 16:11:45', 1, 1),
(79, 38, NULL, 20, 'fSj_S1SAG4s:APA91bHZKEuK0U2OlpVzRiUiH5EmMCvlrlFuszGJhwiP9ztH47qkMzTpx6103dQsFg_oWuoGW1-htSNQ9ArD7QmqyXtZY8KdPkYnzIDPcEEA6QZV3j7tkt9z4fYs97xWizcnBTU4IkPt', 'Coba', 'Coba Parno kirim barang', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'DetailNotificationActivity', '[{\"key\":\"description\",\"val\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br \\/>\\r\\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br \\/>\\r\\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br \\/>\\r\\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br \\/>\\r\\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br \\/>\\r\\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"},{\"key\":\"title\",\"val\":\"Coba\"}]', '2017-11-09 16:05:12', '2017-11-09 16:05:12', '2017-11-09 16:05:27', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notification_groups`
--

CREATE TABLE `notification_groups` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `description` text NOT NULL,
  `total_recipient` bigint(20) NOT NULL,
  `total_arrival_message` bigint(11) NOT NULL,
  `total_read_message` bigint(20) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `notification_groups`
--

INSERT INTO `notification_groups` (`id`, `title`, `message`, `description`, `total_recipient`, `total_arrival_message`, `total_read_message`, `created`) VALUES
(1, 'NEW SCHEDULE', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>19 October 2017 17:13</b>', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>19 October 2017 17:13</b>', 1, 1, 1, '2017-10-19 17:09:07'),
(2, 'PROMO', 'PROMO BUKAN OKTOBER!!', 'Selama bulan OKTOBER 2017, semua produk UWE LINO diskon 50 % Hayooo buruan...', 1, 1, 1, '2017-10-19 17:11:01'),
(3, 'Target Sales Oktober', 'Pencapain Sales yang tidak sesuai dengan target.', 'Dear team sales,<br />\r\nSaya sangat kecewa dengan pencapaian target bulan oktober 2017. Kalian harus pahami produk yang kalian jual adalah air mineral. Saya tidak mau dengar lagi kalian menjaul air ke toko kimia.&nbsp;<br />\r\n<br />\r\nTerima kasih<br />\r\nKasat Intel Densus 88', 3, 2, 1, '2017-10-20 10:10:50'),
(4, 'NEW SCHEDULE', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 10:40</b>', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 10:40</b>', 1, 1, 1, '2017-10-20 10:34:28'),
(5, 'NEW SCHEDULE', 'Store : <b>TOKO BABE</b><br/>Date : <b>20 October 2017 14:10</b>', 'Store : <b>TOKO BABE</b><br/>Date : <b>20 October 2017 14:10</b>', 1, 1, 1, '2017-10-20 13:25:20'),
(6, 'KERJA WOI', 'KERJA KERJA ', 'KERJAAAAAA', 1, 1, 1, '2017-10-20 13:30:09'),
(7, 'NEW SCHEDULE', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>20 October 2017 14:00</b>', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>20 October 2017 14:00</b>', 1, 1, 1, '2017-10-20 13:32:20'),
(8, 'NEW SCHEDULE', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>20 October 2017 14:05</b>', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>20 October 2017 14:05</b>', 1, 1, 1, '2017-10-20 14:06:56'),
(9, 'NEW SCHEDULE', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 15:33</b>', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>20 October 2017 15:33</b>', 1, 1, 1, '2017-10-20 15:33:31'),
(10, 'NEW SCHEDULE', 'Store : <b>TOKO BABE</b><br/>Date : <b>24 October 2017 10:05</b>', 'Store : <b>TOKO BABE</b><br/>Date : <b>24 October 2017 10:05</b>', 1, 1, 1, '2017-10-24 09:56:36'),
(11, 'NEW SCHEDULE', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>25 October 2017 14:10</b>', 'Store : <b>TOKO RUPAWAN</b><br/>Date : <b>25 October 2017 14:10</b>', 1, 1, 1, '2017-10-24 13:59:31'),
(12, 'NEW SCHEDULE', 'Store : <b>Toko Roti</b><br/>Date : <b>24 October 2017 14:04</b>', 'Store : <b>Toko Roti</b><br/>Date : <b>24 October 2017 14:04</b>', 1, 1, 1, '2017-10-24 14:00:11'),
(13, 'NEW SCHEDULE', 'Store : <b>Toko ID Marco</b><br/>Date : <b>24 October 2017 14:41</b>', 'Store : <b>Toko ID Marco</b><br/>Date : <b>24 October 2017 14:41</b>', 1, 1, 1, '2017-10-24 14:36:35'),
(14, 'Salam Kenal - Admin Baru Nge test', 'Hai, lam kenal ea :)', 'Cuma ngetest aja', 12, 3, 2, '2017-10-25 10:16:52'),
(15, 'NEW SCHEDULE', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>25 October 2017 10:22</b>', 'Store : <b>TOKO NOVAL</b><br/>Date : <b>25 October 2017 10:22</b>', 1, 1, 1, '2017-10-25 10:22:23'),
(16, 'NEW SCHEDULE', 'Store : <b>Toko Kawe</b><br/>Date : <b>25 October 2017 10:25</b>', 'Store : <b>Toko Kawe</b><br/>Date : <b>25 October 2017 10:25</b>', 1, 1, 1, '2017-10-25 10:25:52'),
(17, 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:25</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:25</b>', 1, 1, 1, '2017-10-25 10:29:39'),
(18, 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:35</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>25 October 2017 10:35</b>', 1, 1, 0, '2017-10-25 10:32:00'),
(19, 'NEW SCHEDULE', 'Store : <b>Forisa</b><br/>Date : <b>26 October 2017 12:04</b>', 'Store : <b>Forisa</b><br/>Date : <b>26 October 2017 12:04</b>', 1, 0, 0, '2017-10-26 12:04:39'),
(20, 'NEW SCHEDULE', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>30 October 2017 09:50</b>', 'Store : <b>Toko Harum Kimia</b><br/>Date : <b>30 October 2017 09:50</b>', 1, 0, 0, '2017-10-30 09:48:24'),
(21, 'NEW SCHEDULE', 'Store : <b>citayam</b><br/>Date : <b>31 October 2017 08:30</b>', 'Store : <b>citayam</b><br/>Date : <b>31 October 2017 08:30</b>', 1, 0, 0, '2017-10-30 16:25:34'),
(22, 'NEW SCHEDULE', 'Store : <b>Fitshop</b><br/>Date : <b>01 November 2017 15:46</b>', 'Store : <b>Fitshop</b><br/>Date : <b>01 November 2017 15:46</b>', 1, 1, 1, '2017-11-01 15:42:10'),
(23, 'NEW SCHEDULE', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 1, 1, 1, '2017-11-02 15:06:12'),
(24, 'NEW SCHEDULE', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 'Store : <b>Harapan Indah</b><br/>Date : <b>02 November 2017 15:10</b>', 1, 1, 1, '2017-11-02 15:06:38'),
(25, 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 1, 0, 0, '2017-11-03 07:15:39'),
(26, 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 1, 0, 0, '2017-11-03 07:16:05'),
(27, 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 14:20</b>', 1, 0, 0, '2017-11-03 07:16:05'),
(28, 'NEW SCHEDULE', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 07:25</b>', 'Store : <b>amru</b><br/>Date : <b>03 November 2017 07:25</b>', 1, 1, 1, '2017-11-03 07:16:22'),
(29, 'NEW SCHEDULE', 'Store : <b>Msolving</b><br/>Date : <b>06 November 2017 19:20</b>', 'Store : <b>Msolving</b><br/>Date : <b>06 November 2017 19:20</b>', 1, 1, 1, '2017-11-06 19:21:30'),
(30, 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>06 November 2017 21:25</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>06 November 2017 21:25</b>', 1, 1, 0, '2017-11-06 21:29:33'),
(31, 'NEW SCHEDULE', 'Store : <b>Mac Arena</b><br/>Date : <b>08 November 2017 08:52</b>', 'Store : <b>Mac Arena</b><br/>Date : <b>08 November 2017 08:52</b>', 1, 1, 1, '2017-11-08 08:53:00'),
(32, 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 15:30</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 15:30</b>', 1, 0, 1, '2017-11-09 15:29:37'),
(33, 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 1, 0, 0, '2017-11-09 15:32:31'),
(34, 'NEW SCHEDULE', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 'Store : <b>Lecos Cafe</b><br/>Date : <b>09 November 2017 17:35</b>', 1, 0, 0, '2017-11-09 15:32:56'),
(35, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 15, 2, 1, '2017-11-09 15:52:50'),
(36, 'User Acceptance Test', 'Tahap percobaan aplikasi awal november', 'Hello all,<br />\r\nSaat ini team developer beserta user sedang melakukan testing setiap fitur yang akan dioperasikan oleh Uwe Limo. Testing berlokasi di Lecos Cafe Bekasi, Jawa Barat.&nbsp;<br />\r\n<br />\r\nTerima Kasih<br />\r\nImam MB<br />\r\nCo-founder of&nbsp;<a href=\"http://zavalite.mlabs.id\" target=\"_blank\">Zavalite</a>', 15, 2, 2, '2017-11-09 15:55:01'),
(37, 'Test', 'Test', 'Coba', 1, 1, 1, '2017-11-09 16:02:17'),
(38, 'Coba', 'Coba Parno kirim barang', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 1, 1, '2017-11-09 16:05:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `notes` text,
  `order_status_id` int(11) NOT NULL DEFAULT '1',
  `delivery_date` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `schedule_id`, `notes`, `order_status_id`, `delivery_date`, `created`, `modified`) VALUES
(1, 2, 'Galon Gak Jadi Beli', 3, NULL, '2017-10-20 10:36:41', '2017-10-20 10:38:26'),
(2, 2, NULL, 4, NULL, '2017-10-20 10:39:32', '2017-10-20 10:39:32'),
(3, 3, NULL, 4, '2017-11-08 00:00:00', '2017-10-20 11:00:54', '2017-10-20 11:00:54'),
(4, 4, NULL, 4, '2017-11-10 00:00:00', '2017-10-20 11:10:30', '2017-10-20 11:10:30'),
(5, 6, 'saldo sukaapa 1.000.000', 4, NULL, '2017-10-20 13:34:00', '2017-10-20 13:34:00'),
(6, 7, 'saldo sukaapa 1jt', 1, NULL, '2017-10-20 14:08:19', '2017-10-20 14:08:19'),
(7, 8, 'saldo sukaapa 1000000', 4, NULL, '2017-10-20 15:36:24', '2017-10-20 15:36:24'),
(8, 9, NULL, 4, NULL, '2017-10-20 16:56:56', '2017-10-20 16:56:56'),
(9, 12, 'tolonh dikirim', 4, '2017-10-25 00:00:00', '2017-10-24 10:07:53', '2017-10-24 10:07:53'),
(10, 13, NULL, 4, '2017-10-25 00:00:00', '2017-10-24 14:23:23', '2017-10-24 14:23:23'),
(11, 17, NULL, 4, '2017-10-02 00:00:00', '2017-10-25 10:11:39', '2017-10-25 10:11:39'),
(12, 21, 'anu point', 1, NULL, '2017-10-25 10:31:42', '2017-10-25 10:31:42'),
(13, 22, 'iseng aja', 4, NULL, '2017-10-25 10:32:53', '2017-10-25 10:32:53'),
(14, 32, NULL, 4, NULL, '2017-11-01 15:43:50', '2017-11-01 15:43:50'),
(15, 37, 'suka apa masih bingung', 4, '2017-11-22 00:00:00', '2017-11-02 15:11:00', '2017-11-02 15:11:00'),
(16, 48, NULL, 4, '2017-11-29 00:00:00', '2017-11-08 11:01:37', '2017-11-08 11:01:37'),
(17, 51, NULL, 4, '2017-11-28 00:00:00', '2017-11-09 15:30:43', '2017-11-09 15:30:43'),
(18, 50, 'Gamau', 4, '2017-11-12 00:00:00', '2017-11-09 15:34:49', '2017-11-09 15:34:49'),
(19, 52, NULL, 4, '2017-11-21 00:00:00', '2017-11-09 15:35:52', '2017-11-09 15:35:52'),
(20, 53, NULL, 4, '2017-11-29 00:00:00', '2017-11-09 15:36:05', '2017-11-09 15:36:05'),
(21, 54, 'saldo sukaapa 1000000', 4, '2017-11-10 00:00:00', '2017-11-09 16:09:43', '2017-11-09 16:10:34'),
(22, 55, 'bungkus', 4, '2017-11-09 00:00:00', '2017-11-09 16:11:33', '2017-11-09 16:11:33'),
(23, 56, 'saldo sukaapa 1000000', 4, '2017-11-10 00:00:00', '2017-11-09 16:14:17', '2017-11-09 16:14:17'),
(24, 57, 'terima kasih', 1, NULL, '2017-11-13 11:56:43', '2017-11-13 11:56:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_lists`
--

CREATE TABLE `order_lists` (
  `id` bigint(20) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `order_lists`
--

INSERT INTO `order_lists` (`id`, `order_id`, `product_id`, `qty`) VALUES
(5, 1, 1, 30),
(6, 1, 2, 0),
(7, 2, 1, 5),
(8, 2, 2, 0),
(9, 3, 1, 5),
(10, 3, 2, 0),
(11, 4, 1, 12),
(12, 4, 2, 13),
(13, 5, 2, 20),
(14, 5, 1, 10),
(15, 5, 4, 1),
(16, 6, 2, 2),
(17, 6, 1, 10),
(18, 6, 4, 1),
(19, 7, 2, 10),
(20, 7, 1, 20),
(21, 7, 4, 1),
(22, 8, 2, 10),
(23, 8, 1, 10),
(24, 8, 4, 10),
(25, 9, 2, 20),
(26, 9, 1, 20),
(27, 9, 4, 20),
(28, 10, 4, 0),
(29, 10, 2, 0),
(30, 10, 1, 880),
(31, 11, 4, 15000),
(32, 11, 2, 1888),
(33, 11, 1, 0),
(34, 12, 2, 20),
(35, 12, 1, 200),
(36, 12, 4, 2000),
(37, 13, 2, 10),
(38, 13, 1, 10),
(39, 13, 4, 10),
(46, 14, 2, 22),
(47, 14, 1, 21),
(48, 14, 4, 12),
(49, 15, 2, 45),
(50, 15, 1, 43),
(51, 15, 4, 900),
(52, 16, 4, 0),
(53, 16, 2, 10),
(54, 16, 1, 15),
(55, 17, 4, 50000),
(56, 17, 2, 100),
(57, 17, 1, 10),
(58, 18, 2, 10),
(59, 18, 1, 10),
(60, 18, 4, 10),
(61, 19, 4, 0),
(62, 19, 2, 6),
(63, 19, 1, 0),
(64, 20, 4, 0),
(65, 20, 2, 52),
(66, 20, 1, 0),
(72, 21, 4, 1000),
(71, 21, 1, 10),
(70, 21, 2, 28),
(73, 22, 2, 10),
(74, 22, 1, 10),
(75, 22, 4, 10),
(76, 23, 2, 10),
(77, 23, 1, 8),
(78, 23, 4, 20),
(79, 24, 4, 1),
(80, 24, 2, 2),
(81, 24, 1, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_logs`
--

CREATE TABLE `order_logs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `aro_id` int(11) DEFAULT NULL,
  `order_log_type_id` int(11) DEFAULT NULL,
  `notes` text,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `order_logs`
--

INSERT INTO `order_logs` (`id`, `order_id`, `creator_id`, `aro_id`, `order_log_type_id`, `notes`, `created`) VALUES
(1, 1, 18, 4, 1, 'kirim segera', '2017-10-20 10:36:41'),
(2, 1, 18, 4, 2, 'kirim segera', '2017-10-20 10:37:43'),
(3, 1, 18, 4, 2, 'Galon Gak Jadi Beli', '2017-10-20 10:38:26'),
(4, 1, 18, 4, 3, 'Gak jadi order semua', '2017-10-20 10:39:08'),
(5, 2, 18, 4, 1, NULL, '2017-10-20 10:39:32'),
(6, 2, 2, 2, 4, NULL, '2017-10-20 10:42:02'),
(7, 3, 18, 4, 1, NULL, '2017-10-20 11:00:54'),
(8, 4, 18, 4, 1, NULL, '2017-10-20 11:10:30'),
(9, 5, 19, 4, 1, 'saldo sukaapa 1.000.000', '2017-10-20 13:34:00'),
(10, 5, 2, 2, 4, NULL, '2017-10-20 13:34:36'),
(11, 6, 20, 4, 1, 'saldo sukaapa 1jt', '2017-10-20 14:08:19'),
(12, 7, 20, 4, 1, 'saldo sukaapa 1000000', '2017-10-20 15:36:24'),
(13, 8, 18, 4, 1, NULL, '2017-10-20 16:56:56'),
(14, 8, 2, 2, 4, NULL, '2017-10-20 17:13:31'),
(15, 7, 2, 2, 4, NULL, '2017-10-20 17:14:05'),
(16, 9, 18, 4, 1, 'tolonh dikirim', '2017-10-24 10:07:53'),
(17, 10, 2, 4, 1, NULL, '2017-10-24 14:23:23'),
(18, 11, 2, 4, 1, NULL, '2017-10-25 10:11:39'),
(19, 11, 2, 2, 4, NULL, '2017-10-25 10:12:36'),
(20, 12, 19, 4, 1, 'anu point', '2017-10-25 10:31:42'),
(21, 13, 20, 4, 1, 'point 20', '2017-10-25 10:32:53'),
(22, 9, 2, 2, 4, NULL, '2017-10-25 10:35:53'),
(23, 10, 2, 2, 4, NULL, '2017-10-25 10:36:17'),
(24, 13, 2, 2, 3, '\'iseng aja\'', '2017-10-25 14:51:59'),
(25, 14, 20, 4, 1, NULL, '2017-11-01 15:43:50'),
(26, 14, 20, 4, 2, NULL, '2017-11-01 15:44:33'),
(27, 14, 20, 4, 2, NULL, '2017-11-01 15:44:44'),
(28, 15, 18, 4, 1, 'suka apa masih bingung', '2017-11-02 15:11:00'),
(29, 16, 20, 4, 1, NULL, '2017-11-08 11:01:37'),
(30, 3, 2, 2, 4, NULL, '2017-11-09 15:22:54'),
(31, 16, 2, 2, 4, NULL, '2017-11-09 15:26:14'),
(32, 15, 2, 2, 4, NULL, '2017-11-09 15:26:43'),
(33, 17, 23, 4, 1, NULL, '2017-11-09 15:30:43'),
(34, 17, 2, 2, 4, NULL, '2017-11-09 15:31:50'),
(35, 18, 18, 4, 1, 'done', '2017-11-09 15:34:50'),
(36, 19, 23, 4, 1, NULL, '2017-11-09 15:35:52'),
(37, 20, 23, 4, 1, NULL, '2017-11-09 15:36:05'),
(38, 18, 2, 2, 3, '\'Gamau\'', '2017-11-09 15:36:42'),
(39, 18, 2, 2, 4, NULL, '2017-11-09 15:36:50'),
(40, 19, 2, 2, 4, NULL, '2017-11-09 15:36:57'),
(41, 20, 2, 2, 4, NULL, '2017-11-09 15:37:12'),
(42, 4, 2, 2, 4, NULL, '2017-11-09 15:37:46'),
(43, 21, 20, 4, 1, 'saldo sukaapa 1000000', '2017-11-09 16:09:43'),
(44, 21, 20, 4, 2, 'saldo sukaapa 1000000', '2017-11-09 16:10:34'),
(45, 22, 18, 4, 1, 'bungkus', '2017-11-09 16:11:33'),
(46, 23, 20, 4, 1, 'saldo sukaapa 1000000', '2017-11-09 16:14:17'),
(47, 21, 2, 2, 4, NULL, '2017-11-09 16:15:46'),
(48, 23, 2, 2, 4, NULL, '2017-11-09 16:19:27'),
(49, 22, 1, 1, 4, NULL, '2017-11-09 16:58:04'),
(50, 22, 1, 1, 4, NULL, '2017-11-09 17:00:04'),
(51, 24, 23, 4, 1, 'terima kasih', '2017-11-13 11:56:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_log_lists`
--

CREATE TABLE `order_log_lists` (
  `id` bigint(20) NOT NULL,
  `order_log_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `order_log_lists`
--

INSERT INTO `order_log_lists` (`id`, `order_log_id`, `product_id`, `qty`) VALUES
(1, 1, 1, 30),
(2, 1, 2, 30),
(3, 2, 1, 30),
(4, 2, 2, 30),
(5, 3, 1, 30),
(6, 3, 2, 0),
(7, 4, 1, 30),
(8, 4, 2, 0),
(9, 5, 1, 5),
(10, 5, 2, 0),
(11, 6, 1, 5),
(12, 6, 2, 0),
(13, 7, 1, 5),
(14, 7, 2, 0),
(15, 8, 1, 12),
(16, 8, 2, 13),
(17, 9, 2, 20),
(18, 9, 1, 100),
(19, 9, 4, 1),
(20, 10, 2, 20),
(21, 10, 1, 100),
(22, 10, 4, 1),
(23, 11, 2, 2),
(24, 11, 1, 10),
(25, 11, 4, 1),
(26, 12, 2, 10),
(27, 12, 1, 20),
(28, 12, 4, 1),
(29, 13, 2, 10),
(30, 13, 1, 10),
(31, 13, 4, 10),
(32, 14, 2, 10),
(33, 14, 1, 10),
(34, 14, 4, 10),
(35, 15, 2, 10),
(36, 15, 1, 20),
(37, 15, 4, 1),
(38, 16, 2, 20),
(39, 16, 1, 20),
(40, 16, 4, 20),
(41, 17, 4, 0),
(42, 17, 2, 0),
(43, 17, 1, 880),
(44, 18, 4, 15000),
(45, 18, 2, 1888),
(46, 18, 1, 0),
(47, 19, 4, 15000),
(48, 19, 2, 1888),
(49, 19, 1, 0),
(50, 20, 2, 20),
(51, 20, 1, 200),
(52, 20, 4, 2000),
(53, 21, 2, 10),
(54, 21, 1, 10),
(55, 21, 4, 10),
(56, 22, 2, 20),
(57, 22, 1, 20),
(58, 22, 4, 20),
(59, 23, 4, 0),
(60, 23, 2, 0),
(61, 23, 1, 880),
(62, 24, 2, 10),
(63, 24, 1, 10),
(64, 24, 4, 10),
(65, 25, 2, 22),
(66, 25, 1, 21),
(67, 25, 4, 12),
(68, 26, 2, 22),
(69, 26, 1, 21),
(70, 26, 4, 12),
(71, 27, 2, 22),
(72, 27, 1, 21),
(73, 27, 4, 12),
(74, 28, 2, 45),
(75, 28, 1, 43),
(76, 28, 4, 900),
(77, 29, 4, 0),
(78, 29, 2, 10),
(79, 29, 1, 15),
(80, 30, 1, 5),
(81, 30, 2, 0),
(82, 31, 4, 0),
(83, 31, 2, 10),
(84, 31, 1, 15),
(85, 32, 2, 45),
(86, 32, 1, 43),
(87, 32, 4, 900),
(88, 33, 4, 50000),
(89, 33, 2, 100),
(90, 33, 1, 10),
(91, 34, 4, 50000),
(92, 34, 2, 100),
(93, 34, 1, 10),
(94, 35, 2, 10),
(95, 35, 1, 10),
(96, 35, 4, 10),
(97, 36, 4, 0),
(98, 36, 2, 6),
(99, 36, 1, 0),
(100, 37, 4, 0),
(101, 37, 2, 52),
(102, 37, 1, 0),
(103, 38, 2, 10),
(104, 38, 1, 10),
(105, 38, 4, 10),
(106, 39, 2, 10),
(107, 39, 1, 10),
(108, 39, 4, 10),
(109, 40, 4, 0),
(110, 40, 2, 6),
(111, 40, 1, 0),
(112, 41, 4, 0),
(113, 41, 2, 52),
(114, 41, 1, 0),
(115, 42, 1, 12),
(116, 42, 2, 13),
(117, 43, 2, 28),
(118, 43, 1, 10),
(119, 43, 4, 1000),
(120, 44, 2, 28),
(121, 44, 1, 10),
(122, 44, 4, 1000),
(123, 45, 2, 10),
(124, 45, 1, 10),
(125, 45, 4, 10),
(126, 46, 2, 10),
(127, 46, 1, 8),
(128, 46, 4, 20),
(129, 47, 4, 1000),
(130, 47, 1, 10),
(131, 47, 2, 28),
(132, 48, 2, 10),
(133, 48, 1, 8),
(134, 48, 4, 20),
(135, 49, 2, 10),
(136, 49, 1, 10),
(137, 49, 4, 10),
(138, 50, 2, 10),
(139, 50, 1, 10),
(140, 50, 4, 10),
(141, 51, 4, 1),
(142, 51, 2, 2),
(143, 51, 1, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_log_types`
--

CREATE TABLE `order_log_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `order_log_types`
--

INSERT INTO `order_log_types` (`id`, `name`) VALUES
(1, 'NEW'),
(2, 'EDIT'),
(3, 'CANCELLED'),
(4, 'FINISHED');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`) VALUES
(1, 'Pending'),
(3, 'Cancelled'),
(4, 'Finished');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` bigint(20) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` smallint(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `created`, `modified`, `status`) VALUES
(1, 'Cup 240ML', 18000, '2017-09-28 00:00:00', '2017-10-20 13:27:24', 1),
(2, 'Galon 19L', 21000, '2017-09-28 00:00:00', '2017-10-20 13:27:08', 1),
(4, 'SukaApa', 1000, '2017-10-20 13:31:02', '2017-10-25 10:32:04', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `restricted_controllers`
--

CREATE TABLE `restricted_controllers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `restricted_controllers`
--

INSERT INTO `restricted_controllers` (`id`, `name`) VALUES
(1, 'AccountController'),
(2, 'PagesController'),
(3, 'TemplateController'),
(4, 'AppController'),
(5, 'ApiController');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_targets`
--

CREATE TABLE `sales_targets` (
  `id` bigint(20) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `total` bigint(20) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `sales_targets`
--

INSERT INTO `sales_targets` (`id`, `sales_id`, `start_date`, `end_date`, `total`, `created`) VALUES
(10, 10, '2017-09-27 00:00:00', '2017-10-27 23:59:59', 100000, '2017-09-26 09:47:35'),
(11, 10, '2017-10-28 00:00:00', '2017-11-28 23:59:59', 2000, '2017-09-26 10:06:29'),
(21, 14, '2017-10-25 00:00:00', '2017-10-27 23:59:59', 1000000, '2017-10-25 17:23:13'),
(22, 14, '2017-10-28 00:00:00', '2017-10-31 23:59:59', 2000000, '2017-10-25 17:23:28'),
(14, 18, '2017-10-20 00:00:00', '2017-11-20 23:59:59', 3500000, '2017-10-20 10:45:18'),
(18, 20, '2017-10-25 00:00:00', '2017-11-30 23:59:59', 1000000, '2017-10-25 10:46:18'),
(17, 19, '2017-10-25 00:00:00', '2017-11-25 23:59:59', 1000000, '2017-10-25 09:44:21'),
(19, 21, '2017-10-25 00:00:00', '2017-11-30 23:59:59', 2500000, '2017-10-25 10:56:51'),
(20, 22, '2017-10-25 00:00:00', '2017-11-30 23:59:59', 5000000, '2017-10-25 11:14:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` int(20) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `schedule_date` datetime NOT NULL,
  `checkin_date` datetime DEFAULT NULL,
  `first_input_data` datetime DEFAULT NULL,
  `check_rival_notes` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `checkin_status_id` smallint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `sales_id`, `store_id`, `schedule_date`, `checkin_date`, `first_input_data`, `check_rival_notes`, `created`, `modified`, `checkin_status_id`) VALUES
(1, 14, 13, '2017-10-19 17:13:00', NULL, NULL, NULL, '2017-10-19 17:09:07', '2017-10-19 17:09:07', 1),
(2, 18, 14, '2017-10-20 10:40:00', '2017-10-20 10:34:54', '2017-10-20 10:39:32', 'halo bos', '2017-10-20 10:34:28', '2017-10-20 10:39:32', 2),
(3, 18, 15, '2017-10-20 10:59:00', '2017-10-20 10:59:39', '2017-10-20 11:00:54', NULL, '2017-10-20 10:59:33', '2017-10-20 11:00:54', 2),
(4, 18, 16, '2017-10-20 11:05:00', '2017-10-20 11:10:00', '2017-10-20 11:10:30', NULL, '2017-10-20 11:05:31', '2017-10-20 11:10:30', 2),
(5, 19, 15, '2017-10-20 14:10:00', '2017-10-20 13:25:32', NULL, NULL, '2017-10-20 13:25:20', '2017-10-20 13:25:20', 2),
(6, 19, 13, '2017-10-20 14:00:00', '2017-10-20 13:32:51', '2017-10-20 13:34:00', NULL, '2017-10-20 13:32:20', '2017-10-20 13:34:00', 2),
(7, 20, 10, '2017-10-20 14:05:00', '2017-10-20 14:07:17', '2017-10-20 14:08:19', NULL, '2017-10-20 14:06:56', '2017-10-20 14:08:19', 2),
(8, 20, 14, '2017-10-20 15:33:00', '2017-10-20 15:35:02', '2017-10-20 15:36:24', 's', '2017-10-20 15:33:31', '2017-10-20 15:36:24', 2),
(9, 18, 17, '2017-10-20 16:55:00', '2017-10-20 16:55:31', '2017-10-20 16:56:56', 'haus', '2017-10-20 16:55:12', '2017-10-20 16:56:56', 2),
(10, 14, 19, '2017-10-21 07:07:00', NULL, NULL, NULL, '2017-10-21 07:07:09', '2017-10-21 07:07:09', 1),
(11, 2, 20, '2017-10-21 07:09:00', NULL, NULL, NULL, '2017-10-21 07:09:50', '2017-10-21 07:09:50', 1),
(12, 18, 15, '2017-10-24 10:05:00', '2017-10-24 10:06:28', '2017-10-24 10:07:53', 'Si Boy', '2017-10-24 09:56:36', '2017-10-24 10:07:53', 2),
(13, 2, 21, '2017-10-24 11:17:00', '2017-10-24 11:17:42', '2017-10-24 14:23:23', NULL, '2017-10-24 11:17:37', '2017-10-24 14:23:23', 2),
(14, 19, 10, '2017-10-25 14:10:00', '2017-10-25 10:21:30', NULL, NULL, '2017-10-24 13:59:31', '2017-10-24 13:59:31', 2),
(15, 19, 20, '2017-10-24 14:04:00', '2017-10-24 14:00:20', NULL, NULL, '2017-10-24 14:00:11', '2017-10-24 14:00:11', 2),
(16, 20, 21, '2017-10-24 14:41:00', '2017-10-24 14:36:48', NULL, NULL, '2017-10-24 14:36:35', '2017-10-24 14:36:35', 2),
(17, 2, 22, '2017-10-25 10:10:00', '2017-10-25 10:10:32', '2017-10-25 10:11:39', NULL, '2017-10-25 10:10:27', '2017-10-25 10:11:39', 2),
(18, 19, 13, '2017-10-25 10:22:00', '2017-10-25 10:22:39', NULL, NULL, '2017-10-25 10:22:23', '2017-10-25 10:22:23', 2),
(19, 2, 23, '2017-10-25 10:22:00', NULL, NULL, NULL, '2017-10-25 10:22:51', '2017-10-25 10:22:51', 1),
(20, 19, 23, '2017-10-25 10:25:00', NULL, NULL, NULL, '2017-10-25 10:25:52', '2017-10-25 10:25:52', 1),
(21, 19, 24, '2017-10-25 10:28:00', '2017-10-25 10:28:23', '2017-10-25 10:31:42', NULL, '2017-10-25 10:28:16', '2017-10-25 10:31:42', 2),
(22, 20, 22, '2017-10-25 10:25:00', '2017-10-25 10:31:47', '2017-10-25 10:32:53', 'point 20', '2017-10-25 10:29:39', '2017-10-25 10:32:53', 2),
(23, 18, 22, '2017-10-25 10:35:00', NULL, NULL, NULL, '2017-10-25 10:32:00', '2017-10-25 10:32:00', 1),
(24, 18, 25, '2017-10-25 10:45:00', NULL, NULL, NULL, '2017-10-25 10:45:54', '2017-10-25 10:45:54', 1),
(25, 20, 28, '2017-10-25 11:28:00', '2017-10-25 11:40:06', NULL, NULL, '2017-10-25 11:28:29', '2017-10-25 11:28:29', 2),
(26, 20, 29, '2017-10-25 11:31:00', '2017-10-25 11:54:14', NULL, NULL, '2017-10-25 11:31:19', '2017-10-25 11:31:19', 2),
(27, 22, 31, '2017-10-25 11:47:00', NULL, NULL, NULL, '2017-10-25 11:47:21', '2017-10-25 11:47:21', 1),
(28, 22, 33, '2017-10-25 12:24:00', NULL, NULL, NULL, '2017-10-25 12:24:27', '2017-10-25 12:24:27', 1),
(29, 14, 16, '2017-10-26 12:04:00', NULL, NULL, NULL, '2017-10-26 12:04:39', '2017-10-26 12:04:39', 1),
(30, 18, 14, '2017-10-30 09:50:00', NULL, NULL, NULL, '2017-10-30 09:48:24', '2017-10-30 09:48:24', 1),
(31, 18, 29, '2017-10-31 08:30:00', NULL, NULL, NULL, '2017-10-30 16:25:34', '2017-10-30 16:25:34', 1),
(32, 20, 33, '2017-11-01 15:46:00', '2017-11-01 15:42:26', '2017-11-01 15:44:44', NULL, '2017-11-01 15:42:09', '2017-11-01 15:44:44', 2),
(33, 20, 34, '2017-11-01 16:08:00', NULL, NULL, NULL, '2017-11-01 16:08:43', '2017-11-01 16:08:43', 1),
(34, 2, 35, '2017-11-01 18:12:00', '2017-11-01 18:12:58', '2017-11-01 18:13:07', NULL, '2017-11-01 18:12:49', '2017-11-01 18:13:07', 2),
(35, 18, 25, '2017-11-02 15:10:00', NULL, NULL, NULL, '2017-11-02 15:06:12', '2017-11-02 15:06:12', 1),
(36, 18, 25, '2017-11-02 15:10:00', NULL, NULL, NULL, '2017-11-02 15:06:38', '2017-11-02 15:06:38', 1),
(37, 18, 36, '2017-11-02 15:09:00', '2017-11-02 15:09:54', '2017-11-02 15:11:00', 'si boy', '2017-11-02 15:09:20', '2017-11-02 15:11:00', 2),
(38, 2, 37, '2017-11-02 15:58:00', '2017-11-02 15:58:54', '2017-11-02 15:59:08', NULL, '2017-11-02 15:58:45', '2017-11-02 15:59:08', 2),
(39, 19, 28, '2017-11-03 14:20:00', NULL, NULL, NULL, '2017-11-03 07:15:39', '2017-11-03 07:15:39', 1),
(40, 19, 28, '2017-11-03 14:20:00', NULL, NULL, NULL, '2017-11-03 07:16:05', '2017-11-03 07:16:05', 1),
(41, 19, 28, '2017-11-03 14:20:00', NULL, NULL, NULL, '2017-11-03 07:16:05', '2017-11-03 07:16:05', 1),
(42, 19, 28, '2017-11-03 07:25:00', NULL, NULL, NULL, '2017-11-03 07:16:22', '2017-11-03 07:16:22', 1),
(43, 18, 36, '2017-11-03 16:00:00', '2017-11-03 16:54:22', NULL, NULL, '2017-11-03 15:56:03', '2017-11-03 15:56:03', 2),
(44, 18, 36, '2017-11-06 19:20:00', '2017-11-06 21:44:58', NULL, NULL, '2017-11-06 19:21:30', '2017-11-06 19:21:30', 2),
(45, 19, 22, '2017-11-06 21:25:00', '2017-11-06 21:29:38', '2017-11-06 21:30:06', NULL, '2017-11-06 21:29:33', '2017-11-06 21:30:06', 2),
(46, 20, 17, '2017-11-08 08:52:00', NULL, NULL, NULL, '2017-11-08 08:53:00', '2017-11-08 08:53:00', 1),
(47, 20, 38, '2017-11-08 08:53:00', '2017-11-08 08:54:00', '2017-11-08 08:54:07', NULL, '2017-11-08 08:53:50', '2017-11-08 08:54:07', 2),
(48, 20, 39, '2017-11-08 11:00:00', '2017-11-08 11:00:20', '2017-11-08 11:01:37', 'kompetitor air mineral', '2017-11-08 11:00:12', '2017-11-08 11:01:37', 2),
(49, 22, 40, '2017-11-09 15:24:00', NULL, NULL, NULL, '2017-11-09 15:24:16', '2017-11-09 15:24:16', 1),
(50, 18, 22, '2017-11-09 15:30:00', '2017-11-09 15:33:52', '2017-11-09 15:34:49', 'note', '2017-11-09 15:29:37', '2017-11-09 15:34:49', 2),
(51, 23, 41, '2017-11-09 15:30:00', '2017-11-09 15:30:14', '2017-11-09 15:30:43', NULL, '2017-11-09 15:30:10', '2017-11-09 15:30:43', 2),
(52, 23, 22, '2017-11-09 17:35:00', '2017-11-09 15:35:43', '2017-11-09 15:35:52', NULL, '2017-11-09 15:32:31', '2017-11-09 15:35:52', 2),
(53, 23, 22, '2017-11-09 17:35:00', '2017-11-09 15:35:56', '2017-11-09 15:36:05', NULL, '2017-11-09 15:32:56', '2017-11-09 15:36:05', 2),
(54, 20, 42, '2017-11-09 16:06:00', '2017-11-09 16:07:42', '2017-11-09 16:10:34', 'saldo sukaapa 1000000', '2017-11-09 16:06:33', '2017-11-09 16:10:34', 2),
(55, 18, 43, '2017-11-09 16:09:00', '2017-11-09 16:09:19', '2017-11-09 16:11:33', 'disini banyak uwe lino', '2017-11-09 16:09:05', '2017-11-09 16:11:33', 2),
(56, 20, 44, '2017-11-09 16:13:00', '2017-11-09 16:13:10', '2017-11-09 16:14:17', 'saldo sukaapa 1000000', '2017-11-09 16:13:02', '2017-11-09 16:14:17', 2),
(57, 23, 45, '2017-11-13 11:51:00', '2017-11-13 11:56:09', '2017-11-13 11:56:43', NULL, '2017-11-13 11:51:09', '2017-11-13 11:56:43', 2),
(58, 23, 46, '2017-11-13 11:56:00', NULL, NULL, NULL, '2017-11-13 11:56:01', '2017-11-13 11:56:01', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_logs`
--

CREATE TABLE `schedule_logs` (
  `id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `competitor_product_id` int(11) NOT NULL,
  `qty` bigint(20) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `schedule_logs`
--

INSERT INTO `schedule_logs` (`id`, `schedule_id`, `competitor_product_id`, `qty`, `created`) VALUES
(20, 2, 1, 96, '2017-10-20 10:39:32'),
(19, 2, 2, 80, '2017-10-20 10:39:32'),
(18, 2, 4, 10, '2017-10-20 10:39:32'),
(17, 2, 3, 20, '2017-10-20 10:39:32'),
(21, 3, 3, 5, '2017-10-20 11:00:54'),
(22, 3, 4, 0, '2017-10-20 11:00:54'),
(23, 3, 2, 0, '2017-10-20 11:00:54'),
(24, 3, 1, 5, '2017-10-20 11:00:54'),
(25, 4, 3, 30, '2017-10-20 11:10:30'),
(26, 4, 4, 69, '2017-10-20 11:10:30'),
(27, 4, 2, 0, '2017-10-20 11:10:30'),
(28, 4, 1, 90, '2017-10-20 11:10:30'),
(29, 6, 3, 20, '2017-10-20 13:34:00'),
(30, 6, 1, 10, '2017-10-20 13:34:00'),
(31, 6, 2, 100, '2017-10-20 13:34:00'),
(32, 6, 4, 20, '2017-10-20 13:34:00'),
(33, 7, 3, 2, '2017-10-20 14:08:19'),
(34, 7, 1, 4, '2017-10-20 14:08:19'),
(35, 7, 6, 4, '2017-10-20 14:08:19'),
(36, 7, 2, 5, '2017-10-20 14:08:19'),
(37, 7, 5, 3, '2017-10-20 14:08:19'),
(38, 8, 3, 1, '2017-10-20 15:36:24'),
(39, 8, 1, 3, '2017-10-20 15:36:24'),
(40, 8, 6, 5, '2017-10-20 15:36:24'),
(41, 8, 2, 4, '2017-10-20 15:36:24'),
(42, 8, 5, 2, '2017-10-20 15:36:24'),
(43, 9, 3, 1, '2017-10-20 16:56:56'),
(44, 9, 1, 1, '2017-10-20 16:56:56'),
(45, 9, 6, 0, '2017-10-20 16:56:56'),
(46, 9, 2, 2, '2017-10-20 16:56:56'),
(47, 9, 5, 1, '2017-10-20 16:56:56'),
(48, 12, 3, 10, '2017-10-24 10:07:53'),
(49, 12, 1, 10, '2017-10-24 10:07:53'),
(50, 12, 6, 10, '2017-10-24 10:07:53'),
(51, 12, 2, 10, '2017-10-24 10:07:53'),
(52, 12, 5, 10, '2017-10-24 10:07:53'),
(63, 13, 3, 654, '2017-10-24 14:23:23'),
(64, 13, 5, 8, '2017-10-24 14:23:23'),
(65, 13, 1, 5, '2017-10-24 14:23:23'),
(66, 13, 2, 15, '2017-10-24 14:23:23'),
(67, 13, 6, 220, '2017-10-24 14:23:23'),
(68, 17, 3, 1, '2017-10-25 10:11:39'),
(69, 17, 5, 2, '2017-10-25 10:11:39'),
(70, 17, 1, 1, '2017-10-25 10:11:39'),
(71, 17, 2, 0, '2017-10-25 10:11:39'),
(72, 17, 6, 100, '2017-10-25 10:11:39'),
(73, 21, 3, 10, '2017-10-25 10:31:42'),
(74, 21, 1, 10, '2017-10-25 10:31:42'),
(75, 21, 6, 500, '2017-10-25 10:31:42'),
(76, 21, 2, 20, '2017-10-25 10:31:42'),
(77, 21, 5, 10, '2017-10-25 10:31:42'),
(78, 22, 3, 10, '2017-10-25 10:32:53'),
(79, 22, 1, 10, '2017-10-25 10:32:53'),
(80, 22, 6, 10, '2017-10-25 10:32:53'),
(81, 22, 2, 10, '2017-10-25 10:32:53'),
(82, 22, 5, 10, '2017-10-25 10:32:53'),
(93, 32, 3, 8, '2017-11-01 15:44:44'),
(94, 32, 1, 9, '2017-11-01 15:44:44'),
(95, 32, 6, 0, '2017-11-01 15:44:44'),
(96, 32, 2, 0, '2017-11-01 15:44:44'),
(97, 32, 5, 8, '2017-11-01 15:44:44'),
(98, 34, 3, 0, '2017-11-01 18:13:07'),
(99, 34, 5, 0, '2017-11-01 18:13:07'),
(100, 34, 1, 0, '2017-11-01 18:13:07'),
(101, 34, 2, 0, '2017-11-01 18:13:07'),
(102, 34, 6, 0, '2017-11-01 18:13:07'),
(103, 37, 3, 80, '2017-11-02 15:11:00'),
(104, 37, 1, 90, '2017-11-02 15:11:00'),
(105, 37, 6, 9, '2017-11-02 15:11:00'),
(106, 37, 2, 77, '2017-11-02 15:11:00'),
(107, 37, 5, 80, '2017-11-02 15:11:00'),
(108, 38, 3, 0, '2017-11-02 15:59:08'),
(109, 38, 5, 0, '2017-11-02 15:59:08'),
(110, 38, 1, 0, '2017-11-02 15:59:08'),
(111, 38, 2, 0, '2017-11-02 15:59:08'),
(112, 38, 6, 0, '2017-11-02 15:59:08'),
(113, 45, 3, 0, '2017-11-06 21:30:06'),
(114, 45, 1, 0, '2017-11-06 21:30:06'),
(115, 45, 6, 0, '2017-11-06 21:30:06'),
(116, 45, 2, 0, '2017-11-06 21:30:06'),
(117, 45, 5, 0, '2017-11-06 21:30:06'),
(118, 47, 3, 0, '2017-11-08 08:54:07'),
(119, 47, 5, 0, '2017-11-08 08:54:07'),
(120, 47, 1, 0, '2017-11-08 08:54:07'),
(121, 47, 2, 0, '2017-11-08 08:54:07'),
(122, 47, 6, 0, '2017-11-08 08:54:07'),
(123, 48, 3, 12, '2017-11-08 11:01:37'),
(124, 48, 5, 5, '2017-11-08 11:01:37'),
(125, 48, 1, 1, '2017-11-08 11:01:37'),
(126, 48, 2, 12, '2017-11-08 11:01:37'),
(127, 48, 6, 2, '2017-11-08 11:01:37'),
(128, 51, 3, 10, '2017-11-09 15:30:43'),
(129, 51, 5, 100, '2017-11-09 15:30:43'),
(130, 51, 1, 52, '2017-11-09 15:30:43'),
(131, 51, 2, 31, '2017-11-09 15:30:43'),
(132, 51, 6, 150, '2017-11-09 15:30:43'),
(133, 50, 3, 10, '2017-11-09 15:34:50'),
(134, 50, 1, 5, '2017-11-09 15:34:50'),
(135, 50, 6, 70, '2017-11-09 15:34:50'),
(136, 50, 2, 3, '2017-11-09 15:34:50'),
(137, 50, 5, 10, '2017-11-09 15:34:50'),
(138, 52, 3, 0, '2017-11-09 15:35:52'),
(139, 52, 5, 0, '2017-11-09 15:35:52'),
(140, 52, 1, 0, '2017-11-09 15:35:52'),
(141, 52, 2, 0, '2017-11-09 15:35:52'),
(142, 52, 6, 0, '2017-11-09 15:35:52'),
(143, 53, 3, 0, '2017-11-09 15:36:05'),
(144, 53, 5, 0, '2017-11-09 15:36:05'),
(145, 53, 1, 0, '2017-11-09 15:36:05'),
(146, 53, 2, 0, '2017-11-09 15:36:05'),
(147, 53, 6, 0, '2017-11-09 15:36:05'),
(157, 54, 5, 20, '2017-11-09 16:10:34'),
(156, 54, 2, 40, '2017-11-09 16:10:34'),
(155, 54, 6, 50, '2017-11-09 16:10:34'),
(154, 54, 1, 30, '2017-11-09 16:10:34'),
(153, 54, 3, 50, '2017-11-09 16:10:34'),
(158, 55, 3, 10, '2017-11-09 16:11:33'),
(159, 55, 1, 5, '2017-11-09 16:11:33'),
(160, 55, 6, 70, '2017-11-09 16:11:33'),
(161, 55, 2, 5, '2017-11-09 16:11:33'),
(162, 55, 5, 5, '2017-11-09 16:11:33'),
(163, 56, 3, 10, '2017-11-09 16:14:17'),
(164, 56, 1, 30, '2017-11-09 16:14:17'),
(165, 56, 6, 50, '2017-11-09 16:14:17'),
(166, 56, 2, 40, '2017-11-09 16:14:17'),
(167, 56, 5, 20, '2017-11-09 16:14:17'),
(168, 57, 3, 1, '2017-11-13 11:56:43'),
(169, 57, 5, 10, '2017-11-13 11:56:43'),
(170, 57, 1, 0, '2017-11-13 11:56:43'),
(171, 57, 2, 0, '2017-11-13 11:56:43'),
(172, 57, 6, 0, '2017-11-13 11:56:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `cms_url` varchar(255) DEFAULT NULL,
  `cms_title` varchar(255) DEFAULT NULL,
  `cms_description` text,
  `cms_keywords` text,
  `cms_author` varchar(255) DEFAULT NULL,
  `cms_app_name` varchar(255) DEFAULT NULL,
  `cms_logo_url` varchar(255) DEFAULT NULL,
  `company_brand_name` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `customer_phone_number` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `copyright_text` varchar(255) NOT NULL,
  `email_logo_url` varchar(205) DEFAULT NULL,
  `path_content` varchar(255) DEFAULT NULL,
  `path_webroot` varchar(255) DEFAULT NULL,
  `map_api_key` varchar(255) DEFAULT NULL,
  `map_android_api_key` varchar(255) DEFAULT NULL,
  `map_browser_api_key` varchar(255) DEFAULT NULL,
  `firebase_api_key` text NOT NULL,
  `facebook_app_id` varchar(255) DEFAULT NULL,
  `google_client_id` text,
  `google_client_secret` varchar(255) DEFAULT NULL,
  `default_lat` varchar(255) DEFAULT NULL,
  `default_lng` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `cms_url`, `cms_title`, `cms_description`, `cms_keywords`, `cms_author`, `cms_app_name`, `cms_logo_url`, `company_brand_name`, `company_address`, `customer_phone_number`, `customer_email`, `admin_email`, `copyright_text`, `email_logo_url`, `path_content`, `path_webroot`, `map_api_key`, `map_android_api_key`, `map_browser_api_key`, `firebase_api_key`, `facebook_app_id`, `google_client_id`, `google_client_secret`, `default_lat`, `default_lng`, `modified`) VALUES
(1, 'http://uwe.divertone.com/', 'UWE LINO CMS', 'UWE LINO CMS', 'UWE LINO CMS', 'MSolving', 'UWE LINO', NULL, 'UWE LIMO', 'Jl Balap Sepeda No 1A Rawamangun Jakarta Timur DKI Jakarta', '(021) 28829199', 'customer@comsnets.com', 'abyfajar@gmail.com', '@comsnets 2017', 'http://192.168.1.100/uwe/cms/img/logo-divertune-small.png', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/', 'AIzaSyCgC44R6iu0UnzCuF9NfQ33LznETv3mZSA', 'AIzaSyArwvQepw4nrjq0NVh9uxsUbEDG2CEqiPY', 'AIzaSyBjXKUQmD0L6kkAbLv3I5NTi2VZN75borc', 'AAAAdKy9XnY:APA91bFQZLktofzRyXlC2x-jqBX42i2IrCmf8KqFYPIaLfr860E-IqqFV7_NButclNX40uFtqsamDydi2AXAevcgthBQsHZ-Pk7-E45AGShAZgLE7_rXnqvRp1-1CRgkCyIU_aaom57B', '1849476045301510', '741315368254-rripopgvl15g799349q8hnjce1j60kel.apps.googleusercontent.com', 'bRg1v9tXogDzK-krA-1mRBbQ', '-6.175414', '106.827122', '2017-09-05 15:53:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` smallint(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `stores`
--

INSERT INTO `stores` (`id`, `creator_id`, `name`, `address`, `city_id`, `postal_code`, `owner`, `phone1`, `phone2`, `latitude`, `longitude`, `created`, `modified`, `status`) VALUES
(1, 2, 'TOKO PAKDE', 'Jl Rawa Belong1 No 18 RT03 / RW09 Kelurahan Rawa Belong Jakarta Timur', 1, NULL, 'Bpk Linglung', '08129292928', NULL, '-6.175414', '106.82712200000003', '2017-09-27 12:26:16', '2017-10-09 10:24:37', 1),
(10, 14, 'TOKO RUPAWAN', 'Jl Mawar No 09 Kelurahan Cipayung Kecamatan Cipayung Jakarta Timur', 3, '12455', 'Bpk Mawar', '0846949999', NULL, '-6.175414', '106.82712200000003', '2017-10-06 14:09:57', '2017-10-09 10:25:09', 1),
(13, 14, 'TOKO NOVAL', 'Jl Mawar 02 No 13', 3, '17433', 'Pak Azhari', NULL, NULL, '-6.3696731', '106.9123018', '2017-10-17 22:32:05', '2017-10-17 22:32:05', 1),
(14, NULL, 'Toko Harum Kimia', 'Jl.Balap Sepeda No.1 Rawamangun', NULL, NULL, 'Wong Fei Hung', '088808621680', NULL, '-6.192639639565755', '106.89153795344237', '2017-10-20 10:33:20', '2017-10-20 10:33:20', 1),
(15, 18, 'TOKO BABE', 'Jl Balap Sepeda No 1A', 1, '154664', 'BABE', NULL, NULL, '-6.1930598', '106.8912951', '2017-10-20 10:59:21', '2017-10-20 10:59:21', 1),
(16, 18, 'Forisa', 'Jl.Pegangsaan', 1, NULL, 'aby', '08215832189', NULL, '-6.1677459818518345', '106.91839143633842', '2017-10-20 11:05:27', '2017-10-20 11:05:27', 1),
(17, 18, 'Mac Arena', 'Jalan Prof Dr.Satrio', 1, '35218', 'iMam', '081289006076', NULL, '-6.223937346039289', '106.8260744959116', '2017-10-20 16:55:06', '2017-10-20 16:55:06', 1),
(18, 2, 'Toko Apa Ya Ini', 'jalan balapan sama siapa no 1', 1, '11320', 'Mas Tur', '087878886169', NULL, '-6.193016536652702', '106.89139064401388', '2017-10-21 01:21:38', '2017-10-21 01:21:38', 1),
(19, 2, 'Toko Maju Jaya', 'jalan jalan men', 1, '14500', 'Bang Jono', '087878888888', NULL, '-6.204119625562866', '106.8196988850832', '2017-10-21 07:07:06', '2017-10-21 07:07:06', 1),
(20, 2, 'Toko Roti', 'monas', 1, '555555', 'Tiger Wood', '0851234513753', NULL, '-6.1755849728476635', '106.82746957987547', '2017-10-21 07:09:45', '2017-10-21 07:09:45', 1),
(21, 2, 'Toko ID Marco', 'gd ariobimo', 1, '14520', 'Ridwan', '087878787878', NULL, '-6.2273313', '106.8335206', '2017-10-24 11:17:30', '2017-10-24 11:17:30', 1),
(22, 2, 'Lecos Cafe', 'jalan pesona anggrek', 1, '13250', 'Bos Irvan', '087878886169', NULL, '-6.203851642260546', '106.99833702296019', '2017-10-25 10:10:26', '2017-10-25 10:10:26', 1),
(23, 2, 'Toko Kawe', 'jalan bintang metropole', 1, '64954', 'mas boy', '088888', NULL, '-6.214612531249028', '107.00907424092293', '2017-10-25 10:22:50', '2017-10-25 10:22:50', 1),
(24, 19, 'lecos parno', 'ruko pesona', 3, NULL, 'parno juga', '02188882288', NULL, '-6.203834643315138', '106.9982223585248', '2017-10-25 10:28:06', '2017-10-25 10:28:06', 1),
(25, 18, 'Harapan Indah', 'Jalan Pesona Anggrek Harapan jaya bekasi utara', 3, NULL, 'irvan', '088808621680', NULL, '-6.2037806', '106.9982304', '2017-10-25 10:45:48', '2017-10-25 10:45:48', 1),
(26, 22, 'Pamela', 'Jl. kh. agus salim', 3, '94711', 'Rizka dama', '08152527697', NULL, '-0.9549928432962865', '122.78681136667727', '2017-10-25 11:21:01', '2017-10-25 11:21:01', 1),
(27, 20, 'indo', 'bulak sentul no.29', 3, '17124', 'rikyyul', '085892380675', NULL, '-6.204577263399712', '106.99664287269115', '2017-10-25 11:26:33', '2017-10-25 11:26:33', 1),
(28, 20, 'amru', 'bulak sentul', 3, '17124', 'juju', '0888888888', NULL, '-6.203861', '106.997821', '2017-10-25 11:28:25', '2017-10-25 11:28:25', 1),
(29, 20, 'citayam', 'perumahan pertanian widuri 2 no.8', 4, '124578', 'hendi', '8880000', NULL, '-6.203861', '106.997821', '2017-10-25 11:31:16', '2017-10-25 11:31:16', 1),
(30, 22, 'Fishop', 'Nambo', 3, '94712', 'Rara', '082396023516', NULL, '-1.0687277', '122.7449494', '2017-10-25 11:44:45', '2017-10-25 11:44:45', 1),
(31, 22, 'Fishop', 'Nambo', 3, '94712', 'rara', '082396023516', NULL, '-1.0687277', '122.7449494', '2017-10-25 11:47:19', '2017-10-25 11:47:19', 1),
(32, 20, 'aaa', 'desa koyoan permai no.30', 1, '124578', 'h3ndi', '8888', NULL, '-1.06220845', '122.71886340000003', '2017-10-25 11:55:54', '2017-10-25 12:03:47', 1),
(33, 22, 'Fitshop', 'Jl. Kh. Agus salim', 3, '94711', 'Eca', '08152527697', NULL, '-1.0687275704947845', '122.74494946002962', '2017-10-25 12:24:25', '2017-10-25 12:24:25', 1),
(34, 20, 'TOKO CERIA', 'Jl. Kayu Putih Tengah IB No. 31', 1, '13820', 'Ardhi', '0852369741', NULL, '-6.1825593', '106.8925738', '2017-11-01 16:08:39', '2017-11-01 16:08:39', 1),
(35, 2, 'toko william', 'scbd', 3, '16579', 'thomas', '96666', NULL, '-6.2309492', '106.809795', '2017-11-01 18:12:32', '2017-11-01 18:12:32', 1),
(36, 18, 'Msolving', 'Jl.Kayu Putih Tengah Ib no.31', 1, '123456', 'Jimmy', '02147865230', NULL, '-6.18276386280279', '106.89260199666023', '2017-11-02 15:09:13', '2017-11-02 15:09:13', 1),
(37, 2, 'backyard', 'jalan', 3, '6464', 'tes', '9499494', NULL, '-6.2726458', '106.8085045', '2017-11-02 15:58:43', '2017-11-02 15:58:43', 1),
(38, 20, 'Mpok Lela Warteg', 'jalan dibelakang msolving', 1, '11530', 'lela', '087548467', NULL, '-6.1825521', '106.8924623', '2017-11-08 08:53:48', '2017-11-08 08:53:48', 1),
(39, 20, 'Toko Jono', 'jalan kayu putih tengah 1b no 31', 1, '11530', 'Imam', '0878788889696', NULL, '-6.1825526', '106.8924613', '2017-11-08 11:00:10', '2017-11-08 11:00:10', 1),
(40, 22, 'Lina jaya', 'Nambo', 6, '94711', 'rizka', '08152527697', NULL, '-1.0747398', '122.7375913', '2017-11-09 15:24:14', '2017-11-09 15:24:14', 1),
(41, 23, 'Mas Bro store', 'jalan jalan sesuka hati', 8, '167985', 'Thomas', '6498849494', NULL, '-6.2038147', '106.9982152', '2017-11-09 15:30:08', '2017-11-09 15:30:08', 1),
(42, 20, 'Lecos Coffe', 'Pesona Anggrek', 3, NULL, 'Hendy', NULL, NULL, '-6.2039149716602076', '106.9982347637415', '2017-11-09 16:06:29', '2017-11-09 16:06:29', 1),
(43, 18, 'Lecos Cafe', 'Kaliabang raya', 3, '123456', 'hendi', '088808621680', NULL, '-6.202889367762202', '106.99814189225435', '2017-11-09 16:08:58', '2017-11-09 16:08:58', 1),
(44, 20, 'lecos 1', 'pesona anggrek', 3, NULL, 'hendy', NULL, NULL, '-6.203963968611572', '106.99828002601862', '2017-11-09 16:12:58', '2017-11-09 16:12:58', 1),
(45, 23, 'Toko Columbia', 'Jalan Kayu putih', 1, '11350', 'Thomas', '087878888619', NULL, '-6.182347871838029', '106.89131453633308', '2017-11-13 11:50:57', '2017-11-13 11:50:57', 1),
(46, 23, 'Toko MCD', 'jalan kirana', 1, '11530', 'Thomas', '0878788886469', NULL, '-6.173827651619286', '106.89663771539927', '2017-11-13 11:55:58', '2017-11-13 11:55:58', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `targets`
--

CREATE TABLE `targets` (
  `id` int(100) NOT NULL,
  `target_date` date NOT NULL,
  `target` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `targets`
--

INSERT INTO `targets` (`id`, `target_date`, `target`) VALUES
(1, '2017-11-01', 3000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `aro_id` int(11) DEFAULT NULL,
  `is_admin` smallint(1) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT '',
  `password` varchar(100) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `current_latitude` varchar(255) NOT NULL,
  `current_longitude` varchar(255) NOT NULL,
  `gcm_id` varchar(255) DEFAULT NULL,
  `is_verify` smallint(1) NOT NULL DEFAULT '0',
  `verify_date` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `last_login_cms` datetime DEFAULT NULL,
  `last_login_web` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `aro_id`, `is_admin`, `email`, `username`, `firstname`, `lastname`, `password`, `phone`, `current_latitude`, `current_longitude`, `gcm_id`, `is_verify`, `verify_date`, `status`, `created`, `modified`, `last_login_cms`, `last_login_web`) VALUES
(1, 1, 1, 'developer@uwe.co.id', 'developer@uwe.co.id', 'Developer', '', 'qpOVrZaYsJk=', NULL, '', '', NULL, 1, '2017-05-11 03:05:05', 1, '2017-05-11 03:05:05', '2017-09-03 12:34:38', '2017-11-10 16:14:11', '2017-05-11 03:05:05'),
(2, 2, 1, 'superadmin@uwe.co.id', 'superadmin@uwe.co.id', 'Super Admin', NULL, 'qpOVrZaYsJk=', '081229361946', '-6.2038133', '106.9982157', NULL, 1, '2017-05-11 10:26:03', 1, '2017-05-11 10:26:03', '2017-07-21 15:16:39', '2017-11-14 10:54:07', NULL),
(13, 4, 1, 'rizky@uwe.co.id', NULL, 'Rizky', '', 'qpOVrZaYsJk=', NULL, '', '', NULL, 0, NULL, 1, '2017-09-26 10:13:20', '2017-09-26 10:13:20', NULL, NULL),
(12, 4, 1, 'tono@uwe.co.id', NULL, 'Tono', '', 'qpOVrZaYsJk=', NULL, '', '', NULL, 0, NULL, 1, '2017-09-26 10:10:24', '2017-09-26 10:10:24', NULL, NULL),
(15, 4, 1, 'fajar@uwe.co.id', NULL, 'Fajar', 'Utama', 'qpOVrZaYsJmb', NULL, '', '', NULL, 0, NULL, 1, '2017-09-27 15:03:01', '2017-09-27 15:03:01', NULL, NULL),
(11, 4, 1, 'angga@uwe.co.id', NULL, 'Angga', '', 'qpOVrZaYsJk=', NULL, '', '', NULL, 0, NULL, 1, '2017-09-26 10:08:12', '2017-09-26 10:08:20', NULL, NULL),
(9, 4, 1, 'sujiwo.tejo@uwe.co.id', NULL, 'Sujiwo', 'Tejo', 'qpOVrZaYsJk=', NULL, '', '', NULL, 0, NULL, 1, '2017-09-25 16:27:51', '2017-10-09 10:30:58', NULL, NULL),
(10, 4, 1, 'yoyonk@uwe.co.id', NULL, 'Yoyonk', '', 'qpOVrZaYsJk=', NULL, '', '', NULL, 0, NULL, 1, '2017-09-26 04:03:13', '2017-09-26 04:03:13', NULL, NULL),
(14, 4, 1, 'ardhi@uwe.co.id', NULL, 'Ardhi', '', 'qpOVrZaYsJk=', NULL, '-6.1825487', '106.8924647', 'cEbG6ZIoRp8:APA91bGnDtbcXLdhT8YqYtCgWLYMXdWtkU9n-akIZks9TGtZvFo-PJhxPbabn7pbL6MyXOLwa0O4Ce9Sz7AGuwmcFjION44fWk4GZarKZfYQnAe_9IwVHGKwaHxCU5WS4N5MqSSWi2t6', 0, NULL, 1, '2017-09-26 10:17:45', '2017-09-26 10:38:31', '2017-10-09 11:52:56', NULL),
(16, 4, 1, 'asdasd@asdasd.asdasd', NULL, 'adasd', 'asdads', 'qpOVqpOVqpOVqpOV', NULL, '', '', NULL, 0, NULL, 1, '2017-09-27 15:03:24', '2017-10-09 10:31:19', NULL, NULL),
(17, 4, 1, 'tes@gmail.com', NULL, 'Tes', 'Ardi', 'qpOVrZaYsJk=', NULL, '', '', NULL, 0, NULL, 1, '2017-10-09 12:33:41', '2017-10-09 12:33:41', NULL, NULL),
(18, 4, 1, 'imam@gmail.com', NULL, 'Imam', 'Mulki', 'qpOVrZaY', NULL, '-6.1824254', '106.8925834', 'dH_sFs0sMjk:APA91bEA2f53LSIs3LIp0AJc_LNVVJj-CCdIenuzEjFt-q4A0HAp_92rbxRlCS0zRRmc4IiOznchnlN38D0bFm1XCoW5Nd8JKXaTrv7occnwR8y_O-UzgkIZ3-HAEGnBTdOptRuedrWH', 0, NULL, 1, '2017-10-13 10:44:08', '2017-10-23 15:51:18', NULL, NULL),
(19, 4, 1, 'dodol@dodol.com', NULL, 'Irvan', 'Agustiansyah', 'qpOVrZaYsJk=', NULL, '-6.21194', '106.9954182', 'fVVUIze2a0k:APA91bEpIG1Xx4ivnZslMl3ABIDj6h__4wNHZoiNeQtUSTkL2AZ9W9m5_ZHWDEPywhEHheymOBsuMjFy9cK4L5uYTlTCLsAxUHzq6cCOsngvIgAta0KkRV8OOdc0CpLrT7hOgHTyY87w', 0, NULL, 1, '2017-10-13 11:21:21', '2017-10-13 11:21:21', NULL, NULL),
(20, 4, 1, 'parno@parno.parno', NULL, 'PARNO', 'LAMPADJOA', 'qpOVrZaY', NULL, '-6.192196', '106.8740346', 'cs_I1xFWQFo:APA91bGeEoz-3xKK_6geNQpV--bga0N4RqTLRM0Lvjr8wV1kAZYpHmI0ZtuGbc-xk4-maKT_cuKqHXMGve-KF7zXSKLjT6GUDj3PM3cp_WdX8P3wwacAQ2pviMCmXOHNSu34eN93L-vk', 0, NULL, 1, '2017-10-20 14:02:55', '2017-11-09 15:02:20', NULL, NULL),
(21, 4, 1, 'yoyo@yoyo.id', NULL, 'YoYo', 'YoYo', 'qpOVrZaY', NULL, '', '', NULL, 0, NULL, 1, '2017-10-25 10:56:30', '2017-10-25 10:56:30', NULL, NULL),
(22, 4, 1, 'riska@riska.id', NULL, 'Riska', 'riska', 'qpOVrZaY', NULL, '-0.9505926', '122.7875051', 'fdkNw_nlnt8:APA91bFppy1iG69O5AhDP6V_N_4WIqLE_dpZhhK-fGfkp8_jEe3FAHKWepWdymjCxsAVGx_MKV9UD1WqQjdF_t7KENaxe3dk38iS1DD-Tr-z1ZfOuu-Hei8hXM3QO5CBHF33HeprJpur', 0, NULL, 1, '2017-10-25 11:14:31', '2017-11-09 15:20:05', NULL, NULL),
(23, 4, 1, 'ardi@tampan.sekali', NULL, 'Thomas', 'Ardi', 'qpOVrZaYsJk=', NULL, '-6.1825515', '106.8924633', 'fQ74JhfqLdU:APA91bG9wVqkdC1bU32xugRjSogkQBsAU7jkuKUv239y-rpwzV769mpSLnrEyLx22AE67zkATGXtpWSniaD5Y_L8XFfZkd1ucVcJtGrWRdglC7TEGgSVLjX0p_yIf8H1F_ALbLkiRXQZ', 0, NULL, 1, '2017-11-09 15:28:46', '2017-11-09 15:28:46', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acos`
--
ALTER TABLE `acos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lft` (`lft`),
  ADD KEY `rght` (`rght`);

--
-- Indexes for table `acos_types`
--
ALTER TABLE `acos_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aros`
--
ALTER TABLE `aros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lft` (`lft`),
  ADD KEY `rght` (`rght`);

--
-- Indexes for table `aros_acos`
--
ALTER TABLE `aros_acos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`),
  ADD KEY `aro_id` (`aro_id`),
  ADD KEY `aco_id` (`aco_id`);

--
-- Indexes for table `checkin_statuses`
--
ALTER TABLE `checkin_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_menus`
--
ALTER TABLE `cms_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `lft` (`lft`),
  ADD KEY `rght` (`rght`);

--
-- Indexes for table `cms_menu_translations`
--
ALTER TABLE `cms_menu_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locale` (`locale`),
  ADD KEY `model` (`model`),
  ADD KEY `row_id` (`foreign_key`),
  ADD KEY `field` (`field`);

--
-- Indexes for table `competitor_products`
--
ALTER TABLE `competitor_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model` (`model`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `i18n`
--
ALTER TABLE `i18n`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locale` (`locale`),
  ADD KEY `model` (`model`),
  ADD KEY `row_id` (`foreign_key`),
  ADD KEY `field` (`field`);

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created` (`created`),
  ADD KEY `arrival_date` (`arrival_date`),
  ADD KEY `read_date` (`read_date`),
  ADD KEY `is_arrival` (`is_arrival`),
  ADD KEY `is_readed` (`is_readed`);

--
-- Indexes for table `notification_groups`
--
ALTER TABLE `notification_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `order_lists`
--
ALTER TABLE `order_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_logs`
--
ALTER TABLE `order_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_log_lists`
--
ALTER TABLE `order_log_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_log_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_log_types`
--
ALTER TABLE `order_log_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restricted_controllers`
--
ALTER TABLE `restricted_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_targets`
--
ALTER TABLE `sales_targets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dateRange` (`start_date`,`end_date`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_id` (`sales_id`),
  ADD KEY `schedule_date` (`schedule_date`);

--
-- Indexes for table `schedule_logs`
--
ALTER TABLE `schedule_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `competitor_product_id` (`competitor_product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `targets`
--
ALTER TABLE `targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acos`
--
ALTER TABLE `acos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `acos_types`
--
ALTER TABLE `acos_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `aros`
--
ALTER TABLE `aros`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `aros_acos`
--
ALTER TABLE `aros_acos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT for table `checkin_statuses`
--
ALTER TABLE `checkin_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cms_menus`
--
ALTER TABLE `cms_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `cms_menu_translations`
--
ALTER TABLE `cms_menu_translations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `competitor_products`
--
ALTER TABLE `competitor_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `i18n`
--
ALTER TABLE `i18n`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `langs`
--
ALTER TABLE `langs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `notification_groups`
--
ALTER TABLE `notification_groups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `order_lists`
--
ALTER TABLE `order_lists`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `order_logs`
--
ALTER TABLE `order_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `order_log_lists`
--
ALTER TABLE `order_log_lists`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `order_log_types`
--
ALTER TABLE `order_log_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `restricted_controllers`
--
ALTER TABLE `restricted_controllers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sales_targets`
--
ALTER TABLE `sales_targets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `schedule_logs`
--
ALTER TABLE `schedule_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `targets`
--
ALTER TABLE `targets`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
