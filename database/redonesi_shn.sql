-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 27, 2019 at 11:36 AM
-- Server version: 10.1.37-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redonesi_shn`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
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
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `acos_type_id`, `model`, `controller`, `alias`, `description`, `lft`, `rght`, `status`, `created`, `modified`) VALUES
(1, NULL, 2, NULL, NULL, 'top', '', 1, 28, 1, '2016-11-21 00:00:00', '2016-11-21 00:00:00'),
(2, 1, 2, NULL, 'Dashboards', 'Dashboards', '', 2, 3, 1, '2016-11-21 22:41:45', '2016-11-22 16:50:47'),
(4, 1, 2, NULL, 'Admins', 'Admins', '', 4, 5, 1, '2016-11-21 22:42:07', '2016-11-22 16:51:00'),
(5, 1, 2, NULL, 'CmsMenus', 'CmsMenus', '', 6, 7, 1, '2016-11-21 22:47:10', '2016-11-22 16:57:18'),
(7, 1, 1, NULL, 'ModuleObjects', 'ModuleObjects', '', 8, 9, 1, '2016-11-22 16:27:57', '2016-11-22 16:58:48'),
(9, 1, 2, NULL, 'AdminGroups', 'AdminGroups', '', 10, 11, 1, '2016-11-23 12:26:39', '2016-11-23 12:26:39'),
(24, 1, 2, NULL, 'WorkShifts', 'WorkShifts', '', 26, 27, 1, '2019-01-08 18:12:07', '2019-01-08 18:12:07'),
(20, 1, 2, NULL, 'Employees', 'Employees', '', 22, 23, 1, '2019-01-08 17:49:04', '2019-01-08 17:49:04'),
(23, 1, 2, NULL, 'WorkUnits', 'WorkUnits', '', 24, 25, 1, '2019-01-08 18:05:11', '2019-01-08 18:05:11');

-- --------------------------------------------------------

--
-- Table structure for table `acos_types`
--

CREATE TABLE `acos_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acos_types`
--

INSERT INTO `acos_types` (`id`, `name`) VALUES
(1, 'Superadmin only'),
(2, 'All admin');

-- --------------------------------------------------------

--
-- Table structure for table `aros`
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
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `description`, `lft`, `rght`, `total_admin`, `status`, `created`, `modified`) VALUES
(1, NULL, NULL, NULL, 'Developer', '', 1, 8, 0, 1, '2016-11-23 00:00:00', '2016-11-28 05:36:38'),
(8, 2, NULL, NULL, 'Admin Reporting', '', 5, 6, 1, 1, '2019-01-08 18:22:23', '2019-01-08 18:22:23'),
(2, 1, NULL, NULL, 'Super Admin', '', 2, 7, 1, 1, '2016-11-23 20:52:43', '2016-11-28 05:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
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
-- Dumping data for table `aros_acos`
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
(120, 1, 24, '1', '1', '1', '1'),
(138, 8, 2, '1', '1', '1', '1'),
(139, 8, 4, '0', '1', '0', '0'),
(140, 8, 5, '0', '0', '0', '0'),
(121, 2, 24, '1', '1', '1', '1'),
(119, 2, 23, '1', '1', '1', '1'),
(118, 1, 23, '1', '1', '1', '1'),
(112, 1, 20, '1', '1', '1', '1'),
(113, 2, 20, '1', '1', '1', '1'),
(141, 8, 7, '0', '0', '0', '0'),
(142, 8, 9, '0', '0', '0', '0'),
(143, 8, 20, '1', '1', '1', '1'),
(144, 8, 23, '0', '1', '0', '0'),
(145, 8, 24, '0', '1', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cms_menus`
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
-- Dumping data for table `cms_menus`
--

INSERT INTO `cms_menus` (`id`, `aco_id`, `parent_id`, `lft`, `rght`, `name`, `icon_class`, `is_group_separator`, `status`, `created`, `modified`) VALUES
(1, NULL, NULL, 1, 56, 'Top Level Menu', '', 0, 1, '2016-11-13 15:58:17', '2016-11-13 15:58:17'),
(2, NULL, 1, 2, 3, 'Menu Utama', '', 1, 1, '2016-11-13 15:58:17', '2017-01-05 09:58:42'),
(3, 2, 1, 4, 5, 'Dashboard', 'fa fa-desktop', 0, 1, '2016-11-13 15:58:17', '2017-09-28 10:46:00'),
(5, NULL, 1, 46, 47, 'Menu Admin', '', 1, 1, '2016-11-13 15:58:17', '2017-01-05 10:00:32'),
(6, 4, 1, 48, 49, 'Daftar Admin', 'fa fa-user', 0, 1, '2016-11-13 15:59:25', '2017-01-05 10:00:48'),
(9, 5, 1, 52, 53, 'Menu CMS', 'fa fa-bars', 0, 1, '2016-11-14 10:15:59', '2017-01-05 10:02:00'),
(26, 7, 1, 54, 55, 'Objek Modul', 'glyphicon glyphicon-wrench', 0, 1, '2016-11-21 20:25:25', '2017-01-05 11:44:14'),
(29, 9, 1, 50, 51, 'Grup Admin', 'fa fa-users', 0, 1, '2016-11-22 17:09:30', '2017-01-05 10:01:44'),
(66, 47, 1, 6, 7, 'Log Book', 'fa fa-book', 0, 1, '2017-07-27 16:32:21', '2017-07-27 16:32:21'),
(68, 49, 1, 8, 9, 'Event Schedule', 'glyphicon glyphicon-calendar', 0, 1, '2017-09-02 18:36:24', '2017-09-03 05:26:13'),
(69, 50, 1, 10, 11, 'Speaker', 'fa fa-user', 0, 1, '2017-09-03 12:38:28', '2017-09-03 12:38:28'),
(70, 51, 1, 12, 13, 'About Comsnets', 'fa fa-info', 0, 1, '2017-09-05 15:15:42', '2017-09-05 15:15:42'),
(87, 23, 1, 40, 41, 'Work Unit', 'fa fa-group', 0, 1, '2019-01-08 18:05:48', '2019-01-08 18:05:48'),
(88, 24, 1, 44, 45, 'Work Shift', 'glyphicon glyphicon-time', 0, 1, '2019-01-08 18:12:46', '2019-01-08 18:12:46'),
(84, NULL, 1, 36, 37, 'Work Settings', '', 1, 1, '2019-01-08 18:00:28', '2019-01-08 18:00:28'),
(83, 20, 1, 32, 33, 'Employee', 'fa fa-user', 0, 1, '2019-01-08 17:49:44', '2019-01-08 17:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `cms_menu_translations`
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
-- Dumping data for table `cms_menu_translations`
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
(74, 'eng', 'CmsMenu', 71, 'name', 'Karyawan'),
(75, 'idn', 'CmsMenu', 72, 'name', 'Stores'),
(76, 'eng', 'CmsMenu', 72, 'name', 'Stores'),
(77, 'idn', 'CmsMenu', 73, 'name', 'Schedule'),
(78, 'eng', 'CmsMenu', 73, 'name', 'Schedule'),
(79, 'idn', 'CmsMenu', 74, 'name', 'Order'),
(80, 'eng', 'CmsMenu', 74, 'name', 'Order'),
(81, 'idn', 'CmsMenu', 75, 'name', 'BroadcastMessage'),
(82, 'eng', 'CmsMenu', 75, 'name', 'Broadcast Message'),
(97, 'idn', 'CmsMenu', 83, 'name', 'Employee'),
(95, 'idn', 'CmsMenu', 82, 'name', 'Products'),
(96, 'eng', 'CmsMenu', 82, 'name', 'Products'),
(87, 'idn', 'CmsMenu', 78, 'name', 'Company Product'),
(88, 'eng', 'CmsMenu', 78, 'name', 'Company Product'),
(89, 'idn', 'CmsMenu', 79, 'name', 'Rival Product'),
(90, 'eng', 'CmsMenu', 79, 'name', 'Rival Product'),
(91, 'idn', 'CmsMenu', 80, 'name', 'City'),
(92, 'eng', 'CmsMenu', 80, 'name', 'City'),
(93, 'idn', 'CmsMenu', 81, 'name', 'Company Target'),
(94, 'eng', 'CmsMenu', 81, 'name', 'Company Target'),
(98, 'eng', 'CmsMenu', 83, 'name', 'Employee'),
(99, 'idn', 'CmsMenu', 84, 'name', 'Work Settings'),
(100, 'eng', 'CmsMenu', 84, 'name', 'Work Settings'),
(101, 'idn', 'CmsMenu', 85, 'name', 'Work Unit'),
(102, 'eng', 'CmsMenu', 85, 'name', 'Work Unit'),
(103, 'idn', 'CmsMenu', 86, 'name', 'Work Shift'),
(104, 'eng', 'CmsMenu', 86, 'name', 'Work Shift'),
(105, 'idn', 'CmsMenu', 87, 'name', 'Work Unit'),
(106, 'eng', 'CmsMenu', 87, 'name', 'Work Unit'),
(107, 'idn', 'CmsMenu', 88, 'name', 'Work Shift'),
(108, 'eng', 'CmsMenu', 88, 'name', 'Work Shift');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
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
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `model`, `model_id`, `type`, `host`, `url`, `mime_type`, `path`, `width`, `height`, `created`, `modified`) VALUES
(6, 'Store', 1, 'square', 'http://uwe.divertone.com/', 'contents/Store/1/1_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/1/1_square.jpg', 300, 300, '2017-09-27 12:23:55', '2017-10-09 10:22:40'),
(7, 'Store', 1, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/1/1_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/1/1_maxwidth.jpg', 750, 380, '2017-09-27 12:23:56', '2017-10-09 10:22:41'),
(17, 'Store', 13, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/13/13_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/13/13_maxwidth.jpg', 800, 1422, '2017-10-17 22:32:07', '2017-10-17 22:32:07'),
(16, 'Store', 13, 'square', 'http://uwe.divertone.com/', 'contents/Store/13/13_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/13/13_square.jpg', 300, 300, '2017-10-17 22:32:05', '2017-10-17 22:32:05'),
(15, 'Store', 10, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/10/10_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/10/10_maxwidth.jpg', 410, 310, '2017-10-06 14:09:58', '2017-10-09 10:22:24'),
(14, 'Store', 10, 'square', 'http://uwe.divertone.com/', 'contents/Store/10/10_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/10/10_square.jpg', 300, 300, '2017-10-06 14:09:57', '2017-10-09 10:22:24'),
(55, 'User', 1, 'maxwidth', 'http://shn.redonesia.com/', 'contents/User/1/1_maxwidth.png', 'image/png', '/home/redonesi/shn.redonesia.com/app/webroot/contents/User/1/1_maxwidth.png', 512, 512, '2019-01-08 22:45:41', '2019-01-08 23:08:33'),
(54, 'User', 1, 'square', 'http://shn.redonesia.com/', 'contents/User/1/1_square.png', 'image/png', '/home/redonesi/shn.redonesia.com/app/webroot/contents/User/1/1_square.png', 511, 511, '2019-01-08 22:45:40', '2019-01-08 23:08:33'),
(20, 'Store', 14, 'square', 'http://uwe.divertone.com/', 'contents/Store/14/14_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/14/14_square.jpg', 300, 300, '2017-10-20 10:33:20', '2017-10-20 10:33:20'),
(21, 'Store', 14, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/14/14_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/14/14_maxwidth.jpg', 524, 385, '2017-10-20 10:33:20', '2017-10-20 10:33:20'),
(22, 'Store', 15, 'square', 'http://uwe.divertone.com/', 'contents/Store/15/15_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/15/15_square.jpg', 300, 300, '2017-10-20 10:59:22', '2017-10-20 10:59:22'),
(23, 'Store', 15, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/15/15_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/15/15_maxwidth.jpg', 800, 1067, '2017-10-20 10:59:23', '2017-10-20 10:59:23'),
(24, 'Store', 16, 'square', 'http://uwe.divertone.com/', 'contents/Store/16/16_square.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/16/16_square.jpg', 300, 300, '2017-10-20 11:05:27', '2017-10-20 11:05:27'),
(25, 'Store', 16, 'maxwidth', 'http://uwe.divertone.com/', 'contents/Store/16/16_maxwidth.jpg', 'image/jpeg', '/home/divertone2017/public_html/sites/uwe.divertone.com/app/webroot/contents/Store/16/16_maxwidth.jpg', 800, 1067, '2017-10-20 11:05:28', '2017-10-20 11:05:28'),
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
-- Table structure for table `email_logs`
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
-- Table structure for table `email_settings`
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
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` smallint(3) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `marital_status` varchar(1) DEFAULT NULL,
  `health_record` varchar(1) DEFAULT NULL,
  `house` int(5) DEFAULT NULL,
  `work_unit_id` bigint(11) NOT NULL,
  `work_shift_id` bigint(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` smallint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `age`, `gender`, `marital_status`, `health_record`, `house`, `work_unit_id`, `work_shift_id`, `created`, `modified`, `status`) VALUES
(1, 'H Robyanto', 51, 'm', 'm', 'b', 1, 1, 1, '2019-01-08 00:00:00', '2019-01-08 00:00:00', 1),
(2, 'Rahmadian Ustrianto', 43, 'm', 'm', 'g', 2, 1, 1, '2019-01-08 20:27:58', '2019-01-08 20:27:58', 0),
(3, 'Darsono', 45, 'm', 'm', 'g', 2, 1, 1, '2019-01-08 21:59:36', '2019-01-08 21:59:36', 0),
(4, 'Alfandi D', 49, 'm', 'm', 'b', 2, 1, 1, '2019-01-08 22:12:37', '2019-01-08 22:12:37', 0),
(5, 'Ria Ulva', 35, 'f', 'm', 'g', 3, 1, 1, '2019-01-08 22:13:06', '2019-01-08 22:13:06', 0),
(6, 'Triawan H', 43, 'm', 'm', 'g', 2, 1, 1, '2019-01-08 22:15:08', '2019-01-08 22:15:08', 0),
(7, 'Hardianti Ayu', 39, 'f', 'm', 'g', 3, 1, 1, '2019-01-08 22:15:42', '2019-01-08 22:15:42', 0),
(8, 'Bagus Prasetyo', 36, 'm', 'm', 'g', 2, 1, 1, '2019-01-08 22:16:05', '2019-01-08 22:16:05', 0),
(9, 'Yudha Dwi C', 36, 'f', 'm', 'g', 3, 1, 1, '2019-01-08 22:16:45', '2019-01-08 22:16:45', 0),
(10, 'Agustian Yunardi', 38, 'm', 'm', 'g', 1, 1, 1, '2019-01-08 22:17:11', '2019-01-08 22:17:11', 0),
(11, 'Moh. Riza M', 41, 'm', 'm', 'b', 2, 1, 1, '2019-01-08 22:17:59', '2019-01-08 22:17:59', 0),
(12, 'Ida Khusniatul', 39, 'f', 'm', 'b', 2, 1, 1, '2019-01-08 22:18:33', '2019-01-08 22:18:33', 0),
(13, 'M Taufik H', 39, 'm', 'm', 'g', 4, 1, 1, '2019-01-08 22:19:02', '2019-01-08 22:19:02', 0),
(14, 'Ari Fisianto', 41, 'm', 'm', 'g', 4, 1, 1, '2019-01-08 22:19:42', '2019-01-08 22:19:42', 0),
(15, 'Panji Ciptoning', 43, 'm', 'm', 'g', 4, 1, 1, '2019-01-08 22:20:15', '2019-01-08 22:20:15', 0),
(16, 'Agung Putra', 44, 'm', 'm', 'g', 4, 1, 1, '2019-01-08 22:20:47', '2019-01-08 22:20:47', 0),
(17, 'Ridwan S', 49, 'm', 'm', 'b', 4, 1, 1, '2019-01-08 22:21:22', '2019-01-08 22:21:22', 0),
(18, 'Agung Farid D', 26, 'm', 's', 'g', 2, 2, 1, '2019-01-08 22:23:32', '2019-01-08 22:23:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `i18n`
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
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`id`, `code`, `name`) VALUES
(1, 'idn', 'Indonesia'),
(2, 'eng', 'English');

-- --------------------------------------------------------

--
-- Table structure for table `restricted_controllers`
--

CREATE TABLE `restricted_controllers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restricted_controllers`
--

INSERT INTO `restricted_controllers` (`id`, `name`) VALUES
(1, 'AccountController'),
(2, 'PagesController'),
(3, 'TemplateController'),
(4, 'AppController'),
(5, 'ApiController');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
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
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `cms_url`, `cms_title`, `cms_description`, `cms_keywords`, `cms_author`, `cms_app_name`, `cms_logo_url`, `company_brand_name`, `company_address`, `customer_phone_number`, `customer_email`, `admin_email`, `copyright_text`, `email_logo_url`, `path_content`, `path_webroot`, `map_api_key`, `map_android_api_key`, `map_browser_api_key`, `firebase_api_key`, `facebook_app_id`, `google_client_id`, `google_client_secret`, `default_lat`, `default_lng`, `modified`) VALUES
(1, 'http://shn.redonesia.com/', 'SHN CMS', 'SHN CMS', 'SHN CMS', 'Redonesia', 'SHN', NULL, 'SHN', 'Jl Balap Sepeda No 1A Rawamangun Jakarta Timur DKI Jakarta', '(021) 28829199', NULL, 'dev@redonesia.com', '@redonesia 2019', NULL, '/home/redonesi/shn.redonesia.com/app/webroot/contents/', '/home/redonesi/shn.redonesia.com/app/webroot/', 'AIzaSyCgC44R6iu0UnzCuF9NfQ33LznETv3mZSA', 'AIzaSyArwvQepw4nrjq0NVh9uxsUbEDG2CEqiPY', 'AIzaSyBjXKUQmD0L6kkAbLv3I5NTi2VZN75borc', 'AAAAdKy9XnY:APA91bFQZLktofzRyXlC2x-jqBX42i2IrCmf8KqFYPIaLfr860E-IqqFV7_NButclNX40uFtqsamDydi2AXAevcgthBQsHZ-Pk7-E45AGShAZgLE7_rXnqvRp1-1CRgkCyIU_aaom57B', '1849476045301510', '741315368254-rripopgvl15g799349q8hnjce1j60kel.apps.googleusercontent.com', 'bRg1v9tXogDzK-krA-1mRBbQ', '-6.175414', '106.827122', '2017-09-05 15:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `aro_id`, `is_admin`, `email`, `username`, `firstname`, `lastname`, `password`, `phone`, `current_latitude`, `current_longitude`, `gcm_id`, `is_verify`, `verify_date`, `status`, `created`, `modified`, `last_login_cms`, `last_login_web`) VALUES
(1, 1, 1, 'developer@shn.co.id', 'developer@shn.co.id', 'Developer', '', 'qpOVrZaYsJk=', NULL, '', '', NULL, 1, '2017-05-11 03:05:05', 1, '2017-05-11 03:05:05', '2017-09-03 12:34:38', '2019-01-21 11:24:05', '2017-05-11 03:05:05'),
(2, 2, 1, 'superadmin@shn.co.id', 'superadmin@shn.co.id', 'Super Admin', NULL, 'qpOVrZaYsJk=', '081229361946', '-6.2038133', '106.9982157', NULL, 1, '2017-05-11 10:26:03', 1, '2017-05-11 10:26:03', '2017-07-21 15:16:39', '2019-01-08 18:27:31', NULL),
(25, 8, 1, 'admin@shn.co.id', NULL, 'Admin', '', 'qpOVrZaYsJk=', NULL, '', '', NULL, 0, NULL, 1, '2019-01-08 18:23:37', '2019-01-08 18:23:37', '2019-01-08 19:58:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_shifts`
--

CREATE TABLE `work_shifts` (
  `id` bigint(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` smallint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_shifts`
--

INSERT INTO `work_shifts` (`id`, `name`, `created`, `modified`, `status`) VALUES
(1, 'Siang', '2019-01-08 00:00:00', '2019-01-08 18:13:15', 1),
(2, 'Malam', '2019-01-08 18:16:00', '2019-01-08 18:16:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_units`
--

CREATE TABLE `work_units` (
  `id` bigint(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` smallint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_units`
--

INSERT INTO `work_units` (`id`, `name`, `created`, `modified`, `status`) VALUES
(1, 'TOP Management', '2019-01-08 18:26:01', '2019-01-08 18:27:51', 1),
(2, 'RnD', '2019-01-08 22:14:25', '2019-01-08 22:14:25', 1);

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
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `restricted_controllers`
--
ALTER TABLE `restricted_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_shifts`
--
ALTER TABLE `work_shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_units`
--
ALTER TABLE `work_units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acos`
--
ALTER TABLE `acos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `acos_types`
--
ALTER TABLE `acos_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aros`
--
ALTER TABLE `aros`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `aros_acos`
--
ALTER TABLE `aros_acos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `cms_menus`
--
ALTER TABLE `cms_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `cms_menu_translations`
--
ALTER TABLE `cms_menu_translations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- AUTO_INCREMENT for table `restricted_controllers`
--
ALTER TABLE `restricted_controllers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `work_shifts`
--
ALTER TABLE `work_shifts`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_units`
--
ALTER TABLE `work_units`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
