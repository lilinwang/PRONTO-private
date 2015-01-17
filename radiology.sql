-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 14, 2015 at 09:36 PM
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
-- Table structure for table `protocol`
--

CREATE TABLE IF NOT EXISTS `protocol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocol_number` varchar(50) DEFAULT NULL,
  `protocol_name` varchar(255) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `description` text,
  `bodypart` varchar(50) DEFAULT NULL,
  `bodypart_code` int(11) DEFAULT NULL,
  `bodypart_full` varchar(255) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `golive_date` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `modality` varchar(3) NOT NULL,
  `report` text,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `idx` (`protocol_name`,`description`,`bodypart_full`,`modality`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `protocol`
--

INSERT INTO `protocol` (`id`, `protocol_number`, `protocol_name`, `code`, `description`, `bodypart`, `bodypart_code`, `bodypart_full`, `approval_date`, `golive_date`, `approved_by`, `modality`, `report`) VALUES
(9, '1', 'Head without contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(40, '12', '', NULL, '', 'heart', NULL, '', NULL, NULL, '', 'CT', NULL),
(41, '123123', '', NULL, '', 'HEART', NULL, '', NULL, NULL, '', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `protocol_backup`
--

CREATE TABLE IF NOT EXISTS `protocol_backup` (
  `id` int(11) NOT NULL,
  `protocol_number` varchar(50) DEFAULT NULL,
  `protocol_name` varchar(255) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `description` text,
  `bodypart` varchar(50) DEFAULT NULL,
  `bodypart_code` int(11) DEFAULT NULL,
  `bodypart_full` varchar(255) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `golive_date` date DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `modality` varchar(3) NOT NULL,
  `report` text,
  KEY `id` (`id`)
) DEFAULT CHARSET=utf8;

--
-- Dumping data for table `protocol_backup`
--

INSERT INTO `protocol_backup` (`id`, `protocol_number`, `protocol_name`, `code`, `description`, `bodypart`, `bodypart_code`, `bodypart_full`, `approval_date`, `golive_date`, `approved_by`, `modality`, `report`) VALUES
(9, '1', 'Head without contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(43, '3', 'Head', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL),
(42, '2', 'Head with contrast', NULL, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits, etc.', 'HEAD', 14, 'Head', NULL, NULL, 'Keith Hentel', 'CT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `series_ct`
--

CREATE TABLE IF NOT EXISTS `series_ct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` int(11) NOT NULL,
  `indication` text,
  `patient_orientation` varchar(50) DEFAULT NULL,
  `landmark` text,
  `intravenous_contrast` varchar(50) DEFAULT NULL,
  `scout` varchar(255) DEFAULT NULL,
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
  `notes` text,
  `protocol_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `series_ct`
--

INSERT INTO `series_ct` (`id`, `series_id`, `indication`, `patient_orientation`, `landmark`, `intravenous_contrast`, `scout`, `scanning_mode`, `range_direction`, `gantry_angle`, `algorithm`, `collimation`, `slice_thickness`, `interval`, `table_speed`, `pitch`, `kvp`, `am`, `rotation_time`, `scan_fov`, `display_fov`, `post_processing`, `transfer_images`, `notes`, `protocol_number`) VALUES
(30, 2, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits', 'Supine', 'Beam parallel to the orbital roof to include foramen magnum', 'None', '90 degrees; S150 - I65; 120 kVp; 10 mA', 'Axial', 'Start at foramen magnum to the vertex', '23 to 25 degrees caudad to Reid¡¯s base line', 'Standard', '20 mm (4i x 5mm)', '5 mm', '5 mm', 'n/a', 'n/a', 0, '250 HD/300 VCT/PRO', '1 sec', 'Head', '22 cm', 'Reconstruct axial images at 2.5 mm thickness', 'Send 2.5 mm thickness in bone and standard algorithm to PACS.  Send 5 mm in standard algorithm to PACS.', 'If front or back of head not included in the 22 cm display FOV, then reconstruct to larger display FOV that includes entire head.', 1),
(31, 0, 'Routine cases; including trauma, stroke, tumor, mental status changes, neurological deficits', 'Supine', 'Beam parallel to the orbital roof to include foramen magnum', 'None', '90 degrees; S150 - I65; 120 kVp; 10 mA', 'Axial', 'Start at foramen magnum to the vertex', '23 to 25 degrees caudad to Reid¡¯s base line', 'Standard', '20 mm (4i x 5mm)', '5 mm', '5 mm', 'n/a', 'n/a', 0, '250 HD/300 VCT/PRO', '1 sec', 'Head', '22 cm', 'Reconstruct axial images at 2.5 mm thickness', 'Send 2.5 mm thickness in bone and standard algorithm to PACS.  Send 5 mm in standard algorithm to PACS.', 'If front or back of head not included in the 22 cm display FOV, then reconstruct to larger display FOV that includes entire head.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `series_ct_backup`
--

CREATE TABLE IF NOT EXISTS `series_ct_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` int(11) NOT NULL,
  `indication` text,
  `patient_orientation` varchar(50) DEFAULT NULL,
  `landmark` text,
  `intravenous_contrast` varchar(50) DEFAULT NULL,
  `scout` varchar(255) DEFAULT NULL,
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
  `notes` text,
  `protocol_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`, `reg_time`) VALUES
(2, 'lilinwang', '5042bd31ac0847cd57f610aec46b0bca66e10922', '2014-11-17 05:19:58'),
(3, 'lw555', 'ce1d8cd1f39ee2a3870e83d48aa3f8e67a16a389', '2014-12-12 11:11:29');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
