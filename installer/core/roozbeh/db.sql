-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2012 at 12:31 PM
-- Server version: 5.1.56
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `aylin_roozbeh`
--

-- --------------------------------------------------------

--
-- Table structure for table `_fields_config`
--

CREATE TABLE IF NOT EXISTS `_fields_config` (
  `name` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `label` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `label_form_attributes` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `label_table_attributes` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `label_view_attributes` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `input` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `input_attributes` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `content_table_attributes` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `content_view_attributes` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `character_limit` int(11) NOT NULL DEFAULT '0',
  `form` tinyint(1) NOT NULL,
  `full_view` tinyint(1) NOT NULL,
  `main_table` tinyint(1) NOT NULL,
  `other_tables` tinyint(1) NOT NULL,
  `index` tinyint(1) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='This table is for store some informations about fields of ta';

-- --------------------------------------------------------

--
-- Table structure for table `_tables_config`
--

CREATE TABLE IF NOT EXISTS `_tables_config` (
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `label` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `view` tinyint(1) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='This table is for store some informations about tables of th';

-- --------------------------------------------------------

--
-- Table structure for table `_tables_menu`
--

CREATE TABLE IF NOT EXISTS `_tables_menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `session_id` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MEMORY  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `_top_breadcrumb_menu`
--

CREATE TABLE IF NOT EXISTS `_top_breadcrumb_menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `label` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `session_id` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=5856 ;
 
