-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2012 at 11:38 AM
-- Server version: 5.1.56
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aylin`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_persian_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_persian_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_persian_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_detail`
--

CREATE TABLE IF NOT EXISTS `customer_detail` (
  `cd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cd_family` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cd_company` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `cd_address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `cd_city` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cd_state` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cd_postal_code` text COLLATE utf8_persian_ci NOT NULL,
  `cd_mobile` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cd_telphone` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cd_national_code` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cd_description` text COLLATE utf8_persian_ci NOT NULL,
  `cd_users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `menu_url` varchar(250) COLLATE utf8_persian_ci NOT NULL,
  `menu_section` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `meta_data`
--

CREATE TABLE IF NOT EXISTS `meta_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50)  COLLATE utf8_persian_ci  DEFAULT NULL,
  `value` varchar(50)  COLLATE utf8_persian_ci  DEFAULT NULL,
  `group` varchar(50)  COLLATE utf8_persian_ci  DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci  AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `user_group` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `content_id` int(10) unsigned NOT NULL auto_increment,
  `content_title` varchar(200) collate utf8_persian_ci NOT NULL,
  `content_text` longtext collate utf8_persian_ci NOT NULL,
  `content_tag` varchar(200) collate utf8_persian_ci NOT NULL,
  `content_modify_date` date NOT NULL,
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=11 ;
