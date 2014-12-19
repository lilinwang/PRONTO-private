-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2014 at 07:06 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `radiology`
--
CREATE DATABASE IF NOT EXISTS `radiology` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `radiology`;

-- --------------------------------------------------------

--
-- Table structure for table `protocol_ct`
--

CREATE TABLE IF NOT EXISTS `protocol_ct` (
  `protocol_number` varchar(50) NOT NULL,
  `protocol_name` varchar(255) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `description` text,
  `bodypart` varchar(50) DEFAULT NULL,
  `bodypart_code` int(11) DEFAULT NULL,
  `bodypart_full` varchar(255) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `golive_date` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `series` text,
  `notes` text,
  `indication` text,
  `patient_orientation` varchar(50) DEFAULT NULL,
  `landmark` text,
  `intravenous_contrast` varchar(50) DEFAULT NULL,
  `scout` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `series_ct`
--

CREATE TABLE IF NOT EXISTS `series_ct` (
  `series_name` varchar(255) NOT NULL,
  `scanning_mode` varchar(50) DEFAULT NULL,
  `range_direction` text,
  `gantry_angle` text,
  `algorithm` varchar(50) DEFAULT NULL,
  `collimation` varchar(50) DEFAULT NULL,
  `slice_thickness` varchar(50) DEFAULT NULL,
  `interval` varchar(50) DEFAULT NULL,
  `table_speed` varchar(255) DEFAULT NULL,
  `pitch` varchar(255) DEFAULT NULL,
  `kvp` int(11) DEFAULT NULL,
  `am` varchar(50) DEFAULT NULL,
  `rotation_time` varchar(50) DEFAULT NULL,
  `scan_fov` varchar(50) DEFAULT NULL,
  `display_fov` varchar(50) DEFAULT NULL,
  `post_processing` text,
  `transfer_images` text,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
